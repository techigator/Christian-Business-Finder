<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Buisness;
use App\Models\category;
use App\Models\Coupon;
use App\Models\Payment;
use App\Models\SalesPersonUser;
use App\Models\Subscription;
use App\Models\User;
use App\Traits\PHPCustomMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use PHPCustomMail;

    public function login()
    {
        return view('front-cbf.auth.login')->with('title', "Login");
    }

    public function loginSubmit(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->route('front.index')->with('success', "Signed In Successfully");
        }

        return redirect()->back()->with('error', "Login details are not valid");
    }

    public function register()
    {
        $categories = category::all();
        $subscriptionAmount = Subscription::first()->amount;

        return view('front-cbf.auth.register', compact('categories', 'subscriptionAmount'))->with('title', "Register");
    }

    public function registerSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'number' => 'required',
            'denomination' => 'required',
        ]);

        $validator->sometimes('home_church_name', 'required', function ($input) {
            return $input->type == 'church';
        });

        $validator->sometimes('home_church_address', 'required', function ($input) {
            return $input->type == 'church';
        });

        $validator->sometimes('business_name', 'required', function ($input) {
            return $input->type == 'business';
        });

        $validator->sometimes('business_categories', 'required', function ($input) {
            return $input->type == 'business';
        });

        $validator->sometimes('view_as', 'required', function ($input) {
            return in_array($input->type, ['business', 'consumer']);
        });

        $validator->sometimes('country', 'required', function ($input) {
            return $input->type === 'consumer';
        });

        $validator->sometimes('city', 'required', function ($input) {
            return $input->type === 'consumer';
        });

        $validator->sometimes('state', 'required', function ($input) {
            return $input->type === 'consumer';
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $requestData = $request->all();

            if ($request->input('type') === 'paid_member') {
                $this->paypalPaymentGateway($requestData);
                return view('front-cbf.paypal-web.payment-gateway', compact('requestData'));
            }

            $user = $this->createUser($requestData);
            Auth::login($user);

            if ($user->type === 'business') {
                $this->createBusiness($user, $requestData);
            }

            if ($request->input('referral_code')) {
                $this->saveSalesPerson($user, $request->input('referral_code'), null);
            }

            return redirect()->route('front.index')->with('success', "Signup Successfully");
        } catch (\Exception $e) {
            return redirect()->route('front.index')->with('error', $e->getMessage());
        }
    }

    protected function createUser($data): User
    {
        $user = new User();
        $user->fill([
            'type' => $data['type'],
            'name' => $data['name'],
            'email' => $data['email'],
            'number' => $data['number'],
            'password' => Hash::make($data['password']),
            'home_church_name' => $data['home_church_name'],
            'home_church_address' => $data['home_church_address'],
            'denomination' => $data['denomination'],
            'profile_image' => 'user-img.png',
            'fcm_token' => 'FCM_' . $data['name'] . '_' . bin2hex(random_bytes(10)),
        ]);

        if ($data['type'] === 'church') {
            $user->fill([
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
            ]);
        } else if ($data['type'] === 'consumer') {
            $user->fill([
                'country' => $data['country'],
                'state' => $data['state'],
                'city' => $data['city'],
                'view_as' => $data['view_as'],
            ]);
        } else {
            $user->fill([
                'buisness_name' => $data['business_name'],
                'buisness_description' => $data['business_description'],
                'buisness_categories' => $data['business_categories'],
                'latitude' => implode(',', $data['latitude']),
                'longitude' => implode(',', $data['longitude']),
                'web_link' => implode(',', $data['web_link']),
                'view_as' => $data['view_as'],
            ]);
        }

        $user->save();
        return $user;
    }

    protected function createBusiness(User $user, $data)
    {
        $business = new Buisness();
        $business->fill([
            'user_id' => $user->id,
            'category_id' => $data['business_categories'],
            'type' => $data['type'],
            'buisness_type' => $data['business_type'],
            'service' => $data['service'],
            'name' => $data['business_name'],
            'ratings' => '0',
            'thumbnail' => 'No_Image_Available.jpg',
            'images' => 'No_Image_Available.jpg',
            'phone_number' => $data['business_phone_number'],
            'opening_hours' => '00:00',
            'details' => $data['business_description'],
            'location' => $data['location'] ? implode(',', $data['location']) : '',
            'longitude' => $data['longitude'] ? implode(',', $data['longitude']) : '',
            'latitude' => $data['latitude'] ? implode(',', $data['latitude']) : '',
        ]);
        $business->save();
    }

    public function changePassword()
    {
        return view('front-cbf.auth.change-password')->with('title', "Change Password");
    }

    public function changePasswordSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $errorMessage = $validator->messages()->first('password');

        if ($validator->fails()) {
            return redirect()->back()->with('error', $errorMessage);
        }

        $email = $request->email;
        $newPassword = $request->password;
        $user = User::where('email', $email)->first();

        if ($user === null) {
            return redirect()->back()->with("error", "User Email Doesn't Exist");
        }

        $userId = $user->id;
        if (User::find($userId)->update(['password' => Hash::make($newPassword)])) {
            return redirect()->back()->with('success', 'Password updated successfully');
        }
    }

    public function forgetPassword()
    {
        return view('front-cbf.auth.forget-password')->with('title', "Forget");
    }

    public function resetPassword(Request $request): \Illuminate\Http\RedirectResponse
    {
        try {
            $request->validate([
                'email' => 'required|email',
            ]);

            $email = $request->email;
            $user = User::where('email', $email)->first();

            if ($user === null) {
                return redirect()->route('front.login')->with("error", "User Email Doesn't Exist");
            }

            $userEmail = $user->email;
            $userName = $user->name;
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $otp,
                'created_at' => Carbon::now()
            ]);

            $resetPasswordURL = route('front.reset.password', $otp);
            $userSubject = 'Reset Password Link';
            $userMessage = view('front-cbf.email-template.email-reset-password', compact('resetPasswordURL', 'userName'));
            send_mail($userEmail, $userSubject, $userMessage);

            return redirect()->route('front.reset.password')->with('success', 'We have sent you a email.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function showResetPasswordForm($otp)
    {
        return view('front-cbf.auth.forget-password-link', ['token' => $otp]);
    }

    public function submitResetPasswordForm(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|confirmed|string|min:8',
        ]);

        $updatePassword = DB::table('password_resets')
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->with('error', 'Invalid Token');
        }

        User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect()->route('front.login')->with('success', 'Your password has been changed!');
    }

    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        return redirect()->route('front.login')->with('success', 'Logout Successfully!');
    }

    public function applyCouponWeb(Request $request): \Illuminate\Http\JsonResponse
    {
        $code = $request->input('coupon_code');

        if (is_null($code)) {
            return response()->json([
                'success' => false,
                'message' => 'Please first enter code'
            ]);
        }

        $coupon = $this->validateCoupon($code);
        $subscription = Subscription::first();

        if (empty($subscription)) {
            return response()->json([
                'success' => false,
                'message' => 'Subscription amount is empty'
            ]);
        }

        if (empty($coupon)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Coupon Code'
            ]);
        }

        $subTotal = $subscription->amount;
        $discountPercentage = $coupon->discount_amount;
        $discountAmount = ($discountPercentage / 100) * $subTotal;
        $newSubTotal = $subTotal - $discountAmount;

        $formattedSubTotal = number_format($subTotal, 2, '.', '');
        $formattedDiscountPercentage = number_format($discountPercentage, 2, '.', '');
        $formattedDiscountAmount = number_format($discountAmount, 2, '.', '');
        $formattedNewSubTotal = number_format($newSubTotal, 2, '.', '');

        $data = [
            'sub_total' => $formattedSubTotal,
            'discount_amount' => $formattedDiscountPercentage,
            'discount' => $formattedDiscountAmount,
            'total' => $formattedNewSubTotal,
        ];

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully!',
            'data' => $data
        ]);
    }

    private function validateCoupon($code)
    {
        return Coupon::where('code', $code)->first();
    }

    public function paypalPaymentGateway($requestData = null): bool
    {
        try {
            if (is_null($requestData)) {
                return false;
            }

            return true;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function userWebCreate(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'number' => 'required',
            'business_phone_number' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'business_type' => 'required',
            'business_name' => 'required',
            'business_categories' => 'required',
            'view_as' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages()
            ]);
        }

        try {
            $location = $request->input('location');
            $latitude = $request->input('latitude');
            $longitude = $request->input('longitude');
            $web_link = $request->input('web_link');

            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->home_church_name = $request->input('home_church_name');
            $user->home_church_address = $request->input('home_church_address');
            $user->denomination = $request->input('denomination');
            $user->password = Hash::make($request->input('password'));
            $user->type = $request->input('type');
            $user->number = $request->input('number');
            $user->profile_image = 'user-img.png';
            $user->view_as = $request->input('view_as');
            $user->fcm_token = 'FCM_' . $request->input('name') . '_' . bin2hex(random_bytes(10)) ?? "";
            $user->buisness_name = $request->input('business_name');
            $user->buisness_description = $request->input('business_description');
            $user->buisness_categories = $request->input('business_categories');
            $user->latitude = implode(',', $latitude);
            $user->longitude = implode(',', $longitude);
            $user->web_link = implode(',', $web_link);
            $couponCode = $request->input('coupon_code');
            $referralCode = $request->input('referral_code');
            $amount = $request->input('amount');

            $user->save();
            Auth::login($user);

            if ($user) {
                $this->paymentCreate($user, $amount);
                $user->makePaidMember();
            }

            if ($referralCode || $couponCode) {
                $this->saveSalesPerson($user, $referralCode, $couponCode);
            }

            $business = new Buisness();
            $business->user_id = $user->id;
            $business->category_id = $request->input('business_categories');
            $business->type = $request->input('type');
            $business->buisness_type = $request->input('business_type');
            $business->service = $request->input('service');
            $business->name = $request->input('business_name');
            $business->ratings = '0';
            $business->phone_number = $request->input('business_phone_number');
            $business->details = $request->input('business_description');
            $business->thumbnail = 'No_Image_Available.jpg';
            $business->images = 'No_Image_Available.jpg';
            $business->opening_hours = '00:00';

            if ($location) {
                if (count($location) > 1) {
                    for ($i = 1; $i < count((array)$location); $i++) {
                        $location[$i] = '(seperate)' . $location[$i];
                    }

                    $locationString = implode('', $location);
                    if (strpos($locationString, '(seperate)') !== false) {

                        $serialize_location = serialize($locationString);
                        $serialize_longitude = serialize(implode(',', $longitude));
                        $serialize_latitude = serialize(implode(',', $latitude));
                        $business->location = $serialize_location;
                        $business->longitude = $serialize_longitude;
                        $business->latitude = $serialize_latitude;
                    } else {
                        $business->location = implode(',', $location);
                        $business->longitude = implode(',', $longitude);
                        $business->latitude = implode(',', $latitude);
                    }
                } else {
                    $business->location = implode(',', $location);
                    $business->longitude = implode(',', $longitude);
                    $business->latitude = implode(',', $latitude);
                }
            } else {
                $business->location = "";
                $business->longitude = "";
                $business->latitude = "";
            }

            $business->save();

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    protected function paymentCreate(User $user = null, $amount = null)
    {
        $payment = new Payment();

        $payment->fill([
            'user_id' => $user->id,
            'amount' => $amount,
            'pay_method_name' => 'paypal'
        ]);

        $payment->save();
    }

    protected function saveSalesPerson(User $user = null, $referralCode = null, $couponCode = null)
    {
        $referralBy = User::where('referral_code', $referralCode)->first();
        if ($referralBy) {
            $salesPerson = new SalesPersonUser();
            $salesPerson->fill([
                'user_id' => $user->id,
                'referral_id' => $referralBy->id,
                'coupon_code' => $couponCode,
                'referral_code' => $referralCode,
            ]);

            $salesPerson->save();
        }
    }
}
