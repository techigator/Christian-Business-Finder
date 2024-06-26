<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\banner;
use App\Models\AdminNotification;
use App\Models\Buisness;
use App\Models\BuisnessTiming;
use App\Models\category;
use App\Models\Church;
use App\Models\Coupon;
use App\Models\Like;
use App\Models\Message;
use App\Models\Payment;
use App\Models\SalesPersonUser;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Auth;
use Exception;
use Hash;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Mail;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'number' => 'required',
            'denomination' => 'required',
            'fcm_token' => 'required',
        ]);

        try {
            $validator->sometimes('buisness_name', 'required', function ($input) {
                return in_array($input->type, ['business', 'paid_member']);
            });

            $validator->sometimes('buisness_categories', 'required', function ($input) {
                return in_array($input->type, ['business', 'paid_member']);
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

            $validator->sometimes('home_church_name', 'required', function ($input) {
                return $input->type === 'church';
            });

            $validator->sometimes('home_church_address', 'required', function ($input) {
                return $input->type === 'church';
            });

            /* $validator->sometimes('location_1', 'required', function ($input) {
                 return $input->type === 'paid_member';
             });

             $validator->sometimes('location_2', 'required', function ($input) {
                 return $input->type === 'paid_member';
             });

             $validator->sometimes('web_link', 'required', function ($input) {
                 return $input->type === 'paid_member';
             });*/

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->messages()
                ]);
            }

            if ($request->input('type') === 'paid_member') {
                return response()->json([
                    'success' => true
                ]);
            }

            $user_type = $request->input('type');

            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->home_church_name = $request->input('home_church_name');
            $user->home_church_address = $request->input('home_church_address');
            $user->denomination = $request->input('denomination');
            $user->password = Hash::make($request->input('password'));
            $user->type = $user_type;
            $user->number = $request->input('number');
            $user->profile_image = 'user-img.png';
            $user->view_as = $request->input('view_as');
            $user->fcm_token = $request->input('fcm_token');
            $user->country = $request->input('country');
            $user->city = $request->input('city');
            $user->state = $request->input('state');

            $user->save();
            $user_login_token = $user->createToken('renterprise')->accessToken;
            Auth::login($user);

            if ($request->input('referral_code')) {
                $this->saveApiSalesPerson($user, $request->input('referral_code'));
            }

            $location = $request->input('location');
            $longitude = $request->input('longitude');
            $latitude = $request->input('latitude');
            $web_link = $request->input('web_link');

            if ($user_type == 'business') {
                $business = new Buisness();

                $business->user_id = $user->id;
                $business->type = $user_type;
                $business->category_id = $request->buisness_categories;
                $business->name = $request->buisness_name;
                $business->ratings = '0';
                $business->details = $request->buisness_description;
                $business->images = 'No_Image_Available.jpg';
                $business->thumbnail = 'No_Image_Available.jpg';
                $business->opening_hours = '00:00';
                $business->buisness_type = $request->buisness_type;
                $user->web_link = $web_link;

                if ($location) {
                    $business->location = $location;
                    $business->longitude = $longitude;
                    $business->latitude = $latitude;

                } else {
                    $business->location = "";
                    $business->longitude = "";
                    $business->latitude = "";

                }
                $business->save();
            }

            $userData = $user->only([
                'id',
                'type',
                'name',
                'email',
                'profile_image',
                'date_of_birth',
                'number',
                'gender',
                'city',
                'state',
                'country',
                'home_church_name',
                'home_church_address',
                'denomination',
                'view_as',
                'fcm_token',
            ]);

            if ($userData) {
                foreach ($userData as $key => $value) {
                    if (is_null($value)) {
                        $userData[$key] = "";
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'response' => $userData,
                'token' => $user_login_token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function applyCoupon($code = null): \Illuminate\Http\JsonResponse
    {
        try {
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
                'sub_total' => (string)$formattedSubTotal,
                'discount_amount' => (string)$formattedDiscountPercentage,
                'discount' => (string)$formattedDiscountAmount,
                'total' => (string)$formattedNewSubTotal,
            ];

            return response()->json([
                'success' => true,
                'message' => 'Coupon applied successfully!',
                'response' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function validateCoupon($code)
    {
        return Coupon::where('code', $code)->first();
    }

    public function socialMediaRegister(Request $request)
    {
        $checkEmail = User::where('email', $request->email)->first();
        if ($checkEmail) {
            //generate the token for the user
            Auth::login($checkEmail, true);
            $user_login_token = auth()->user()->createToken('renterprise')->accessToken;
            $user = User::find(auth()->user()->id);
            $user->fcm_token = $request->fcm_token;
            $user->save();
            return response()->json([
                'success' => true,
                'data' => $user,
                'token' => $user_login_token,
            ]);
        } else {
            $user = new User;
            $user->type = $request->type;
            $user->login_from = $request->login_from;
            // $user->name=$request->first_name.' '.$request->last_name;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->email_verified = 1;
            if ($request->profile_image) {
                $user->profile_image = $request->profile_image;
            }
            $user->password = Hash::make("123456");
            $user->fcm_token = $request->fcm_token;
            $user->save();
            if ($user) {
                //generate the token for the user
                Auth::login($user, true);
                $user_login_token = auth()->user()->createToken('renterprise')->accessToken;
                $user = User::find(auth()->user()->id);
                return response()->json([
                    'success' => true,
                    // 'data'         => auth()->user(),
                    'data' => $user,
                    'token' => $user_login_token,
                ]);
            }
        }
    }

    public function authenticate(Request $request)
    {
        try {
            $minutes = 60;
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->messages()
                ]);
            }

            if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
                $user_login_token = auth()->user()->createToken('renterprise')->accessToken;
                $user = User::select('id', 'name', 'email', 'type')->where('id', auth()->user()->id)->first();
                $user->fcm_token = $request->fcm_token ?? "";
                $user->save();

                $userData = User::find(auth()->user()->id);
                if ($userData) {
                    foreach ($userData->getAttributes() as $key => $value) {
                        if (is_null($value)) {
                            $userData->{$key} = "";
                        }
                    }
                }

                $userData = $userData->only([
                    'id',
                    'type',
                    'name',
                    'email',
                    'profile_image',
                    'date_of_birth',
                    'number',
                    'gender',
                    'city',
                    'state',
                    'country',
                    'home_church_name',
                    'home_church_address',
                    'denomination',
                    'view_as',
                    'fcm_token',
                ]);

                return response()->json([
                    'success' => true,
                    'response' => $userData,
                    'token' => $user_login_token,
                ])->withCookie(cookie('token', $user_login_token, $minutes));
            } else {
                return response()->json([
                    'success' => false,
                    'Errors' => ['invalid' => ['Invalid Credentials']]
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function updateFcmToken(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $userId = $request->user_id;
            $fcmToken = $request->fcm_token;

            $user = User::find($userId);

            if (empty($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ]);
            }

            $profileUpdate = array_filter([
                'fcm_token' => $fcmToken
            ]);

            $updateStatus = $user->update($profileUpdate);

            if ($updateStatus) {
                $user->refresh();

                return response()->json([
                    'success' => true,
                    'message' => 'FCM Token Updated successfully',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update fcm token',
                ]);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function forgetPasswordEmail(Request $request)
    {
        $emailAddress = $request->email;
        $checkEmailExist = User::where('email', $emailAddress)->first();
        // dd($checkEmailExist->name);
        if ($checkEmailExist) {
            //generate four digits code
            $four_digit_random_number = mt_rand(1000, 9999);
            $setCode = User::where('email', $emailAddress)->update([
                'forget_password_code' => $four_digit_random_number
            ]);
            if ($setCode) {
                $data = array('code' => $four_digit_random_number, 'name' => $checkEmailExist->name, 'email' => $checkEmailExist->email,);
                // Mail::send('email_verification', $data, function($message) use ($emailAddress)
                // {
                //$message->from($data['email']);
                //     $message->to($emailAddress);
                //     $message->subject('Forget Password Email Verification Code');
                // });
                return response([
                    'success' => true,
                    'message' => 'Successfully code generated',
                    'data' => [
                        'id' => $checkEmailExist->id,
                        'name' => $checkEmailExist->name,
                        'email' => $checkEmailExist->email,
                        'code' => $four_digit_random_number
                    ]
                ]);
            } else {
                return response([
                    'success' => false,
                    'message' => 'Failed to generate code'
                ]);
            }
        } else {
            return response([
                'success' => false,
                'message' => 'Email not exists'
            ]);
        }
    }

    public function validEmail(Request $request)
    {
        $emailAddress = $request->email;
        $checkEmailExist = User::where('email', $emailAddress)->first();
        // dd($checkEmailExist->name);
        if ($checkEmailExist) {
            //generate four digits code
            $four_digit_random_number = mt_rand(1000, 9999);
            $setCode = User::where('email', $emailAddress)->update([
                'email_verified_code' => $four_digit_random_number
            ]);
            if ($setCode) {
                $data = array('code' => $four_digit_random_number, 'name' => $checkEmailExist->name, 'email' => $checkEmailExist->email,);
                // Mail::send('email_verification', $data, function($message) use ($emailAddress)
                // {
                //$message->from($data['email']);
                //     $message->to($emailAddress);
                //     $message->subject('Email Verification Code');
                // });
                return response([
                    'success' => true,
                    'message' => 'Successfully code generated',
                    'data' => [
                        'id' => $checkEmailExist->id,
                        'name' => $checkEmailExist->name,
                        'email' => $checkEmailExist->email,
                        'code' => $four_digit_random_number
                    ]
                ]);
            } else {
                return response([
                    'success' => false,
                    'message' => 'Failed to generate code'
                ]);
            }
        } else {
            return response([
                'success' => false,
                'message' => 'Email not exists'
            ]);
        }
    }

    public function checkValidEmailCodeVerification(Request $request)
    {
        $code = $request->code;
        $id = $request->id;
        $checkEmailCode = User::where('id', $id)->where('email_verified_code', $code)->first();
        if ($checkEmailCode == null)
            return response([
                'success' => false,
                'message' => 'Invalid Code'
            ]);
        else
            $setCode = User::where('id', $id)->update([
                'email_verified' => 1
            ]);
        return response([
            'success' => true,
            'message' => 'Code matched successfully'
        ]);
    }

    public function checkForgetPasswordCodeVerification(Request $request)
    {
        $code = $request->code;
        $id = $request->id;
        $checkEmailCode = User::where('id', $id)->where('forget_password_code', $code)->first();
        if ($checkEmailCode == null)
            return response([
                'success' => false,
                'message' => 'Invalid Code'
            ]);
        else
            return response([
                'success' => true,
                'message' => 'Code matched successfully'
            ]);
    }

    public function updateForgetPassword(Request $request)
    {
        $id = $request->id;
        $password = $request->password;
        $passwordHash = Hash::make($password);
        $updatePassword = User::find($id)->update(['password' => $passwordHash]);
        if ($updatePassword) {
            return response([
                'success' => true,
                'message' => 'Password updated successfully'
            ]);
        } else {
            return response([
                'success' => false,
                'message' => 'Failed'
            ]);
        }
    }

    public function changePassword(Request $request)
    {
        #Match The Old Password
        // if (!Hash::check($request->current_password, auth()->user()->password)) {
        //     return response([
        //         'success' => false,
        //         'message' => "Old Password Doesn't match!"
        //     ]);
        $validator = Validator::make($request->all(), [
            'new_password' => 'required | min:8',
            'confirm_new_password' => 'required | min:8',
        ]);
        if ($validator->fails()) {
            return response([
                'status' => 400,
                'error' => $validator->messages()
            ]);
        }
        #Match New Password
        if ($request->new_password != $request->confirm_new_password) {
            return response([
                'success' => false,
                'message' => "New Password Doesn't match!"
            ]);
        } else {
            #Update the new Password
            User::find(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            return response([
                'success' => true,
                'message' => 'Password updated successfully'
            ]);
        }
    }

    public function updateProfileInfo(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = User::find(auth()->user()->id);

            if (is_null($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User record not found',
                ], 404);
            }

            $name = $request->input('name');
            $number = $request->input('number');
            $date_of_birth = $request->input('date_of_birth');
            $gender = $request->input('gender');
            $city = $request->input('city');
            $state = $request->input('state');
            $country = $request->input('country');
            $home_church_name = $request->input('home_church_name');
            $home_church_address = $request->input('home_church_address');
            $denomination = $request->input('denomination');
            $view_as = $request->input('view_as');

            $profileUpdate = array_filter([
                'name' => $name,
                'number' => $number,
                'date_of_birth' => $date_of_birth,
                'gender' => $gender,
                'city' => $city,
                'state' => $state,
                'country' => $country,
                'home_church_name' => $home_church_name,
                'home_church_address' => $home_church_address,
                'denomination' => $denomination,
                'view_as' => $view_as,
            ]);

            $updateStatus = $user->update($profileUpdate);

            if ($updateStatus) {
                $user->refresh();

                foreach ($user->getAttributes() as $key => $value) {
                    if ($value === null) {
                        $user->{$key} = "";
                    }
                }

                $user = $user->only([
                    'id',
                    'type',
                    'name',
                    'email',
                    'profile_image',
                    'date_of_birth',
                    'number',
                    'gender',
                    'city',
                    'state',
                    'country',
                    'home_church_name',
                    'home_church_address',
                    'denomination',
                    'view_as',
                    'fcm_token',
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'User Profile Updated successfully',
                    'data' => $user
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update user profile',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function updateProfileImage(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'profile_image' => 'required',
            'profile_image.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->messages()
            ]);
        }

        $user = User::find(auth()->user()->id);
        if ($request->hasFile('profile_image')) {
            $profile_image = Str::random(17) . $request->file('profile_image')->getClientOriginalName();
            $request->profile_image->move(public_path('assets/uploads/user'), $profile_image);
            $user->profile_image = $profile_image;
        }

        $user->save();

        if ($user) {
            foreach ($user->getAttributes() as $key => $value) {
                if (is_null($value)) {
                    $user->{$key} = "";
                }
            }
        }

        $user = $user->only([
            'id',
            'type',
            'name',
            'email',
            'profile_image',
            'date_of_birth',
            'number',
            'gender',
            'city',
            'state',
            'country',
            'home_church_name',
            'home_church_address',
            'denomination',
            'view_as',
            'fcm_token',
        ]);

        return response()->json([
            'success' => true,
            'file_path' => asset('assets/uploads/user'),
            'message' => 'User Profile Image Uploaded successfully',
            'data' => $user
        ]);
    }

    public function UserTypeChange($user_type): \Illuminate\Http\JsonResponse
    {
        $user = User::find(auth()->user()->id);
        $user->type = $user_type;
        $user->save();
        // User created, return success response
        return response()->json([
            'success' => true,
            'message' => $user_type . 'Type Updated successfully',
            'data' => $user
        ]);
    }

    public function getUser(Request $request, $user_id): \Illuminate\Http\JsonResponse
    {
        /*$token = $request->cookie('token');
        $bearer_token = $request->bearerToken();

        if (is_null($request->bearerToken())) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Unauthorized. Please log in first.',
                ], 401);
        }

        if ($token !== $bearer_token) {
            return response([
                'success' => false,
                'message' => 'Unauthorized. Invalid token.',
            ], 401);
        }*/

        $user = User::find($user_id);

        if (empty($user)) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'User not found.',
                ], 401);
        }

        if ($user) {
            foreach ($user->getAttributes() as $key => $value) {
                if (is_null($value)) {
                    $user->{$key} = "";
                }
            }
        }

        $user = $user->only([
            'id',
            'type',
            'name',
            'email',
            'profile_image',
            'date_of_birth',
            'number',
            'gender',
            'city',
            'state',
            'country',
            'home_church_name',
            'home_church_address',
            'denomination',
            'view_as',
            'fcm_token',
        ]);

        /*$reviews = Product_review::where("renterpriser_id", $user_id)->get();
        if (sizeof($reviews)) {
            $avg = 0;
            foreach ($reviews as $rev) {
                $avg += $rev->star;
            }
            $totalreviews = ceil($avg / count($reviews));
        } else {
            $totalreviews = 0;
        }
        $user_list['reviews_average'] = $totalreviews;*/

        return response()->json([
            'success' => true,
            'data' => $user
            // 'data' => $user_list
        ]);
    }

    public function logout(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->user()->token()->revoke();
        return response()->json([
            'success' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function getCategory(Request $request): \Illuminate\Http\JsonResponse
    {
        /*if (is_null($request->bearerToken())) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Unauthorized. Please log in first.',
                ], 401);
        }*/

        $categories = category::select('id', 'name', 'img')->withCount('buisness')->get();

        if (is_null($categories)) {
            return response()->json([
                'success' => false,
                'message' => 'Categories Not Found'
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'success' => $categories
        ]);
    }

    public function addChurch(Request $request)
    {
        if (!$request->bearerToken()) {
            return response([
                'status' => 401,
                'error' => 'Token not found.'
            ], 401);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 400,
                'error' => $validator->messages()
            ]);
        }
        $user_id = Auth::user()->id;
        if (!$user_id) {
            return response([
                'status' => 401,
                'error' => 'No user id'
            ]);
        }

        $church = new Church;
        $church->name = $request->name;
        $church->longitude = $request->longitude;
        $church->latitude = $request->latitude;
        $church->state = $request->state;
        $church->user_id = $user_id;
        if ($church->save()) {
            return response([
                'Status' => 200,
                'Response' => $church
            ]);
        }
    }

    public function getChurch(): \Illuminate\Http\JsonResponse
    {
        $churches = Church::all();

        return response()->json([
            'Status' => 200,
            'Response' => $churches
        ]);
    }

    public function addBusiness(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'name' => 'required',
            'ratings' => 'required',
            'images' => 'required',
            'images.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf',
            'opening_hours' => 'required',
            'details' => 'required',
            'location' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 400,
                'error' => $validator->messages()
            ]);
        }

        $business = new Buisness();
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/', $name);
                $imgData[] = $name;
            }
            // dd($imgData);
            $business->images = implode(",", $imgData);
        }

        $business->category_id = $request->category_id;
        $business->name = $request->name;
        $business->ratings = $request->ratings;
        $business->opening_hours = $request->opening_hours;
        $business->details = $request->details;
        $business->location = $request->location;
        $business->longitude = $request->longitude;
        $business->latitude = $request->latitude;

        $business->save();

        return response([
            'status' => 200,
            'response' => $business,
        ]);
    }

    public function getBusinessById($id)
    {
        try {
            $business = Buisness::with('rating', 'user')->find($id);
            $user_id = $business['user']['id'];

            if (is_null($business['user'])) {
                return response([
                    'success' => false,
                    'message' => 'User not found!',
                ], 404);
            }

            if (is_null($business)) {
                return response([
                    'success' => false,
                    'message' => 'Business not found!',
                ], 404);
            }

            foreach ($business->getAttributes() as $key => $value) {
                if ($value === null) {
                    $business->{$key} = "";
                }
            }

            foreach ($business->getRelations() as $key => $value) {
                if ($value === null) {
                    $business->{$key} = "";
                }
            }

            $business->category_id = (string)$business->category_id;
            $business->flag = (string)$business->flag;
            $business->details = strip_tags($business->details);
            $business->cover_image = $business->cover_image;
            $business->images = explode(',', $business->images);

            // if (empty($business->cover_image)) {
            //     $business->cover_image = 'No_Image_Available.jpg';
            // }

            if (is_array($business->images) && count($business->images) === 1 && $business->images[0] === "") {
                $business->images = [];
            }

            if (empty($business->thumbnail)) {
                $business->thumbnail = "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png";
            }

            if (strpos($business->location, 's:') === 0) {
                $business->location = explode('(seperate)', unserialize($business->location));
            }

            if (strpos($business->longitude, 's:') === 0) {
                $business->longitude = explode(',', unserialize($business->longitude));
            }

            if (strpos($business->latitude, 's:') === 0) {
                $business->latitude = explode(',', unserialize($business->latitude));
            }

            $business->location = is_array($business->location) ? $business->location : ($business->location ? [$business->location] : []);
            $business->longitude = is_array($business->longitude) ? $business->longitude : ($business->longitude ? [$business->longitude] : []);
            $business->latitude = is_array($business->latitude) ? $business->latitude : ($business->latitude ? [$business->latitude] : []);

            $ratings = $business->rating;
            if ($ratings) {
                $login_user_flag = $ratings->first(function ($rating) use ($user_id) {
                    return $rating->user_id == $user_id;
                });

                if (!is_null($login_user_flag) && $login_user_flag !== false) {
                    $flag = $login_user_flag->flag;
                } else {
                    $flag = 0;
                }

                $average = $business->averageRating();
                $rating_count = count($ratings);
            }

            unset($business->customized_users);
            unset($business->rating);

            // Additional Work On This Api
            $category = category::find($business->category_id);

            if (empty($category)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found.',
                ], 401);
            }

            $viewAs = $business['user']['view_as'] ?? "";
            $webLinks = $business['user']['web_link'];

            if ($webLinks) {
                $webLinks = explode(',', $webLinks);
            } else {
                $webLinks = [];
            }
            unset($business->user);

            $businessTiming = BuisnessTiming::where('buisness_id', $business->id)->first();

            if (!is_null($businessTiming)) {
                $day = explode(',', $businessTiming->day);
                $openingHours = explode(',', $businessTiming->opening_hours);
                $closingHours = explode(',', $businessTiming->closing_hours);
                $availability = explode(',', $businessTiming->availability);
            } else {
                $businessTimingDefault = BuisnessTiming::find(1);
                $day = explode(',', $businessTimingDefault->day);
                $openingHours = explode(',', $businessTimingDefault->opening_hours);
                $closingHours = explode(',', $businessTimingDefault->closing_hours);
                $availability = explode(',', $businessTimingDefault->availability);
            }

            $businessData = $business->only([
                'name',
                'details',
                'service',
                'thumbnail',
                'phone_number'
            ]);

            $businessData['user_id'] = (string)$business->user_id;
            $businessData['category_name'] = $category->name;
            $businessData['view_as'] = $viewAs;
            $businessData['location'] = $business->location;
            $businessData['longitude'] = $business->longitude;
            $businessData['latitude'] = $business->latitude;
            $businessData['web_link'] = $webLinks;
            $businessData['cover_image'] = $business->cover_image ?? "";
            $businessData['images'] = $business->images;
            $businessData['days'] = $day;
            $businessData['opening_hours'] = $openingHours;
            $businessData['closing_hours'] = $closingHours;
            $businessData['availability'] = $availability;
            // Additional Work On This Api

            return response([
                'success' => true,
                'rating_count' => $rating_count,
                'user_rating_flag' => $flag,
                'rating_average' => (string)$average,
                'business' => $businessData,
                // 'business' => $business,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getBusiness($id)
    {
        $category = Category::where('id', $id)->first();

        if (!$category) {
            return response([
                'status' => 400,
                'response' => 'Category not found',
            ]);
        }

        $businesses = Buisness::where('category_id', $id)->get();

        $modifiedBusinesses = [];
        foreach ($businesses as $business) {

            $businessArray = $business->toArray();

            $businessArray = array_map(function ($value) {
                return $value === null ? "" : $value;
            }, $businessArray);

            $location = $businessArray['location'];
            $longitude = $businessArray['longitude'];
            $latitude = $businessArray['latitude'];
            $thumbnail = $businessArray['thumbnail'];
            $cover_image = $businessArray['cover_image'];
            $images = explode(',', $businessArray['images']);
            // cover_image


            if (empty($cover_image)) {
                $cover_image = 'No_Image_Available.jpg';
            }

            if (is_array($images) && count($images) === 1 && $images[0] === "") {
                $images = [];
            }

            if (empty($businessArray['thumbnail'])) {
                $thumbnail = "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png";
            }

            if (strpos($location, 's:') === 0) {
                $location = explode('(seperate)', unserialize($businessArray['location']));
            }

            if (strpos($longitude, 's:') === 0) {
                $longitude = explode(',', unserialize($businessArray['longitude']));
            }

            if (strpos($latitude, 's:') === 0) {
                $latitude = explode(',', unserialize($businessArray['latitude']));
            }

            $location = is_array($location) ? $location : [$location];
            $longitude = is_array($longitude) ? $longitude : [$longitude];
            $latitude = is_array($latitude) ? $latitude : [$latitude];

            $phoneNumber = $businessArray['phone_number'];
            $businessArray['phone_number'] = $phoneNumber;
            $businessArray['category_name'] = $category->name;
            $businessArray['category_image'] = $category->img;
            $businessArray['location'] = $location;
            $businessArray['longitude'] = $longitude;
            $businessArray['latitude'] = $latitude;
            $businessArray['location'] = empty($businessArray['location'][0]) ? [] : $businessArray['location'];
            $businessArray['longitude'] = empty($businessArray['longitude'][0]) ? [] : $businessArray['longitude'];
            $businessArray['latitude'] = empty($businessArray['latitude'][0]) ? [] : $businessArray['latitude'];

            $businessArray['thumbnail'] = $thumbnail;
            $businessArray['cover_image'] = $cover_image;
            $businessArray['images'] = $images;
            unset($businessArray['customized_users']);
            unset($businessArray['user_id']);

            $modifiedBusinesses[] = $businessArray;
        }

        if (count($modifiedBusinesses) == 0) {
            return response([
                'status' => 400,
                'response' => 'Business not found',
            ]);
        }

        return response([
            'status' => 200,
            'response' => $modifiedBusinesses,
        ]);
    }

    public function addSuggestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'buisness_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 400,
                'error' => $validator->messages()
            ]);
        }

        $suggestion = new Suggestion();
        $suggestion->buisness_id = $request->buisness_id;
        $suggestion->save();
        return response([
            'status' => 200,
            'response' => $suggestion,
        ]);
    }

    public function getSuggestion(Request $request)
    {
        /*if (is_null($request->bearerToken())) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Unauthorized. Please log in first.',
                ], 401);
        }*/

        try {
            $suggestions = Suggestion::with('buisness')->get();

            if ($suggestions->isEmpty()) {
                return response([
                    'success' => false,
                    'response' => [],
                ], 401);
            }

            $suggestionData = [];

            foreach ($suggestions as $suggestion) {
                $business = $suggestion->buisness;

                if (!empty($business)) {
                    $categoryId = $business->category_id;
                    $category = Category::find($categoryId);
                    $user = User::find($business->user_id);

                    if ($category) {
                        $categoryName = $category->name;
                        $categoryImage = $category->img;

                        $suggestionDetails = $suggestion->only([
                            'id',
                            'buisness_id',
                            'created_at',
                            'updated_at',
                        ]);

                        foreach ($suggestionDetails as $key => $value) {
                            if ($value === null) {
                                $suggestionDetails[$key] = '';
                            }
                        }

                        $suggestionDetails['category_name'] = $categoryName;
                        $suggestionDetails['category_image'] = $categoryImage;

                        if (is_array($business->images) && count($business->images) === 1 && $business->images[0] === "") {
                            $business->images = [];
                        } else {
                            $business->images = explode(',', $business->images);
                        }

                        if (empty($business->thumbnail)) {
                            $business->thumbnail = "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png";
                        }

                        if (strpos($business->location, 's:') === 0) {
                            $business->location = explode('(seperate)', unserialize($business->location));
                        }

                        if (strpos($business->longitude, 's:') === 0) {
                            $business->longitude = explode(',', unserialize($business->longitude));
                        }

                        if (strpos($business->latitude, 's:') === 0) {
                            $business->latitude = explode(',', unserialize($business->latitude));
                        }

                        $business->location = is_array($business->location) ? $business->location : [$business->location];
                        $business->longitude = is_array($business->longitude) ? $business->longitude : [$business->longitude];
                        $business->latitude = is_array($business->latitude) ? $business->latitude : [$business->latitude];

                        unset($business->customized_users);
                        unset($business->rating);

                        $viewAs = $user->view_as ?? "";
                        $webLinks = $user->web_link;

                        if ($webLinks) {
                            $webLinks = explode(',', $webLinks);
                        } else {
                            $webLinks = [];
                        }

                        $businessTiming = BuisnessTiming::where('buisness_id', $business->id)->first();

                        if (!is_null($businessTiming)) {
                            $day = explode(',', $businessTiming->day);
                            $openingHours = explode(',', $businessTiming->opening_hours);
                            $closingHours = explode(',', $businessTiming->closing_hours);
                            $availability = explode(',', $businessTiming->availability);
                        } else {
                            $businessTimingDefault = BuisnessTiming::find(1);
                            $day = explode(',', $businessTimingDefault->day);
                            $openingHours = explode(',', $businessTimingDefault->opening_hours);
                            $closingHours = explode(',', $businessTimingDefault->closing_hours);
                            $availability = explode(',', $businessTimingDefault->availability);
                        }

                        $businessDetails = $business->only([
                            'name',
                            'service',
                            'thumbnail',
                            'phone_number',
                        ]);

                        $businessDetails['details'] = strip_tags($business->details);;
                        $businessDetails['category_name'] = $category->name;
                        $businessDetails['view_as'] = $viewAs;
                        $businessDetails['location'] = $business->location;
                        $businessDetails['longitude'] = $business->longitude;
                        $businessDetails['latitude'] = $business->latitude;
                        $businessDetails['web_link'] = $webLinks;
                        $businessDetails['cover_image'] = $business->cover_image ?? 'No_Image_Available.jpg';
                        $businessDetails['images'] = $business->images;
                        $businessDetails['days'] = $day;
                        $businessDetails['opening_hours'] = $openingHours;
                        $businessDetails['closing_hours'] = $closingHours;
                        $businessDetails['availability'] = $availability;

                        foreach ($businessDetails as $key => $value) {
                            if ($value === null) {
                                $businessDetails[$key] = '';
                            }
                        }

                        $suggestionDetails['business'] = $businessDetails;

                        $suggestionData[] = $suggestionDetails;
                    } else {
                        return response([
                            'success' => false,
                            'response' => [],
                        ], 401);
                    }
                }
            }

            return response([
                'success' => true,
                'response' => $suggestionData,
            ], 200);
        } catch (\Exception $e) {
            return response([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    public function addLikes(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'buisness_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 400,
                'error' => $validator->messages()
            ]);
        }

        $existingLike = Like::where('user_id', Auth::user()->id)
            ->where('buisness_id', $request->buisness_id)
            ->first();

        if ($existingLike) {
            return response([
                'status' => 400,
                'error' => 'You have already liked this business.'
            ]);
        }

        $like = new Like();
        $like->user_id = Auth::user()->id;
        $like->buisness_id = $request->buisness_id;
        $like->save();
        return response([
            'status' => 200,
            'response' => $like
        ]);
    }

    public function getLikes()
    {
        try {
            $user = Auth::user();
            $userId = $user->id;
            $likes = Like::with('buisness')->where('user_id', $userId)->get();

            if ($likes->isEmpty()) {
                return response([
                    'success' => false,
                    'response' => [],
                ], 401);
            }

            $likeData = [];

            foreach ($likes as $like) {
                $business = $like->buisness;

                if (!empty($business)) {
                    $categoryId = $business->category_id;
                    $category = Category::find($categoryId);

                    $likesDetails['id'] = (string)$like->id;
                    $likesDetails['user_id'] = (string)$like->user_id;
                    $likesDetails['buisness_id'] = (string)$like->buisness_id;
                    $likesDetails['created_at'] = $like->created_at;
                    $likesDetails['updated_at'] = $like->updated_at;

                    foreach ($likesDetails as $key => $value) {
                        if ($value === null) {
                            $likesDetails[$key] = '';
                        }
                    }

                    if (is_array($business->images) && count($business->images) === 1 && $business->images[0] === "") {
                        $business->images = [];
                    } else {
                        $business->images = explode(',', $business->images);
                    }

                    if (empty($business->thumbnail)) {
                        $business->thumbnail = "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/1665px-No-Image-Placeholder.svg.png";
                    }

                    if (strpos($business->location, 's:') === 0) {
                        $business->location = explode('(seperate)', unserialize($business->location));
                    }

                    if (strpos($business->longitude, 's:') === 0) {
                        $business->longitude = explode(',', unserialize($business->longitude));
                    }

                    if (strpos($business->latitude, 's:') === 0) {
                        $business->latitude = explode(',', unserialize($business->latitude));
                    }

                    $business->location = is_array($business->location) ? $business->location : [$business->location];
                    $business->longitude = is_array($business->longitude) ? $business->longitude : [$business->longitude];
                    $business->latitude = is_array($business->latitude) ? $business->latitude : [$business->latitude];

                    unset($business->customized_users);
                    unset($business->rating);

                    $viewAs = $user->view_as ?? "";
                    $webLinks = $user->web_link;

                    if ($webLinks) {
                        $webLinks = explode(',', $webLinks);
                    } else {
                        $webLinks = [];
                    }

                    $businessTiming = BuisnessTiming::where('buisness_id', $business->id)->first();

                    if (!is_null($businessTiming)) {
                        $day = explode(',', $businessTiming->day);
                        $openingHours = explode(',', $businessTiming->opening_hours);
                        $closingHours = explode(',', $businessTiming->closing_hours);
                        $availability = explode(',', $businessTiming->availability);
                    } else {
                        $businessTimingDefault = BuisnessTiming::find(1);
                        $day = explode(',', $businessTimingDefault->day);
                        $openingHours = explode(',', $businessTimingDefault->opening_hours);
                        $closingHours = explode(',', $businessTimingDefault->closing_hours);
                        $availability = explode(',', $businessTimingDefault->availability);
                    }

                    $businessDetails = $business->only([
                        'name',
                        'service',
                        'cover_image',
                        'thumbnail',
                        'phone_number',
                    ]);

                    $businessDetails['details'] = strip_tags($business->details);
                    $businessDetails['category_name'] = $category->name;
                    $businessDetails['category_image'] = $category->img;
                    $businessDetails['view_as'] = $viewAs;
                    $businessDetails['location'] = $business->location;
                    $businessDetails['longitude'] = $business->longitude;
                    $businessDetails['latitude'] = $business->latitude;
                    $businessDetails['web_link'] = $webLinks;
                    $businessDetails['images'] = $business->images;
                    $businessDetails['days'] = $day;
                    $businessDetails['opening_hours'] = $openingHours;
                    $businessDetails['closing_hours'] = $closingHours;
                    $businessDetails['availability'] = $availability;

                    foreach ($businessDetails as $key => $value) {
                        if ($value === null) {
                            $businessDetails[$key] = '';
                        }
                    }

                    $likesDetails['business'] = $businessDetails;
                    $likeData[] = $likesDetails;
                }
            }

            return response([
                'success' => true,
                'response' => $likeData
            ], 200);
        } catch (\Exception $e) {
            return response([
                'success' => false,
                'response' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteLike(Request $request)
    {
        $like = Like::where('id', $request->like_id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if (!$like) {
            return response([
                'status' => 400,
                'response' => 'Like not found or does not belong to the current user.'
            ]);
        }

        $like->delete();

        return response([
            'status' => 200,
            'response' => 'Like deleted successfully'
        ]);
    }

    public function findByChurch(Request $request)
    {
        try {
            // $church = Church::where('id', $request->church_id)
            //     ->where('user_id', Auth::user()->id)
            //     ->firstOrFail();
            $latitude = $request->latitude;
            $longitude = $request->longitude;
            $radius = 5000;
            $businesses = Buisness::select("*",
                DB::raw("6371 * acos(cos(radians(" . $latitude . "))
                                    * cos(radians(buisness.latitude))
                                    * cos(radians(buisness.longitude) - radians(" . $longitude . "))
                                    + sin(radians(" . $latitude . "))
                                    * sin(radians(buisness.latitude))) AS distance"))
                ->having('distance', '<=', $radius)
                // ->where('state' , $request->state)
                ->groupBy("buisness.id")
                ->get();
            return response([
                'status' => 200,
                'nearest_businesses' => $businesses
            ]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'No Church Found'
            ], 404);
        }
    }

    public function getBusinessByCategory($id): \Illuminate\Http\JsonResponse
    {
        $businessByCategory = Buisness::where('category_id', $id)->get();

        if ($businessByCategory->isEmpty()) {
            return response()->json([
                'status' => 401,
                'message' => 'invalid category id or category not found'
            ]);
        }
        return response()->json([
            'status' => 200,
            'Total Business' => count($businessByCategory),
            'message' => $businessByCategory
        ]);
    }

    public function searchPlaces(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $apiKey = 'AIzaSyCYvOXB3SFyyeR0usVOgnLyoDiAd2XDunU';
            $query = $request->input('query');

            $client = new Client();
            $response = $client->get('https://maps.googleapis.com/maps/api/place/textsearch/json', [
                'query' => [
                    'query' => $query,
                    'key' => $apiKey,
                ]
            ]);

            $decodedResponse = json_decode($response->getBody(), true);

            $extractedData = [];

            if (isset($decodedResponse['results'])) {
                foreach ($decodedResponse['results'] as $result) {
                    $formattedAddress = $result['formatted_address'];
                    $lat = strval($result['geometry']['location']['lat']);
                    $lng = strval($result['geometry']['location']['lng']);

                    // $location = $result['geometry']['location'];

                    $extractedData[] = [
                        'location' => $formattedAddress,
                        'latitude' => $lat,
                        'longitude' => $lng,
                        // 'location' => $location,
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'response' => $extractedData,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    public function manageBusiness($id): \Illuminate\Http\JsonResponse
    {
        try {
            $user = User::find($id);

            if (empty($user)) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found.',
                ], 401);
            }

            $business = Buisness::where('user_id', $user->id)->latest()->first();

            if (empty($business)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Business not found.',
                ], 401);
            }

            $businessTiming = BuisnessTiming::where('buisness_id', $business->id)->first();

            if (!is_null($businessTiming)) {
                $day = explode(',', $businessTiming->day);
                $openingHours = explode(',', $businessTiming->opening_hours);
                $closingHours = explode(',', $businessTiming->closing_hours);
                $availability = explode(',', $businessTiming->availability);
            } else {
                $businessTimingDefault = BuisnessTiming::find(1);
                $day = explode(',', $businessTimingDefault->day);
                $openingHours = explode(',', $businessTimingDefault->opening_hours);
                $closingHours = explode(',', $businessTimingDefault->closing_hours);
                $availability = explode(',', $businessTimingDefault->availability);
            }

            foreach ($business->getAttributes() as $key => $value) {
                if (is_null($value)) {
                    $business->{$key} = "";
                }
            }

            $category = category::find($business->category_id);

            if (empty($category)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found.',
                ], 401);
            }

            $viewAs = $user->view_as ?? "";
            $webLinks = $user->web_link;
            $location = $business->location;
            $longitude = $business->longitude;
            $latitude = $business->latitude;
            $cover_image = $business->cover_image;
            $images = $business->images;

            if (empty($cover_image)) {
                $cover_image = 'No_Image_Available.jpg';
            }

            if ($images) {
                $images = explode(',', $images);
            } else {
                $images = [];
            }

            if ($webLinks) {
                $webLinks = explode(',', $webLinks);
            } else {
                $webLinks = [];
            }

            if (strpos($location, 's:') === 0) {
                $location = explode('(seperate)', unserialize($location));
            }

            if (strpos($longitude, 's:') === 0) {
                $longitude = explode(',', unserialize($longitude));
            }

            if (strpos($latitude, 's:') === 0) {
                $latitude = explode(',', unserialize($latitude));
            }

            $location = is_array($location) ? $location : [$location];
            $longitude = is_array($longitude) ? $longitude : [$longitude];
            $latitude = is_array($latitude) ? $latitude : [$latitude];

            $business = $business->only([
                'id',
                'name',
                'details',
                'service',
                'thumbnail',
                'phone_number',
            ]);

            $business['category_name'] = $category->name;
            $business['view_as'] = $viewAs;
            $business['location'] = $location;
            $business['longitude'] = $longitude;
            $business['latitude'] = $latitude;
            $business['web_link'] = $webLinks;
            $business['cover_image'] = $cover_image;
            $business['images'] = $images;
            $business['days'] = $day;
            $business['opening_hours'] = $openingHours;
            $business['closing_hours'] = $closingHours;
            $business['availability'] = $availability;

            return response()->json([
                'success' => true,
                'response' => $business
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateManageBusiness(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $business = Buisness::find($id);

            if (empty($business)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Business record not found',
                ], 404);
            }

            $user = User::where('id', $business->user_id)->first();

            if (empty($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User record not found',
                ], 404);
            }

            $name = $request->input('name');
            $details = $request->input('details');
            $category_id = $request->input('category_id');
            $service = $request->input('service');
            $view_as = $request->input('view_as');
            $location = $request->input('location');
            $longitude = $request->input('longitude');
            $latitude = $request->input('latitude');
            $web_link = $request->input('web_link');
            $images = $request->input('images');
            $days = $request->input('days');
            $opening_hours = $request->input('opening_hours');
            $closing_hours = $request->input('closing_hours');
            $availability = $request->input('availability');
            $phone_number = $request->input('phone_number');

            if (strpos($location, '(seperate)') !== false) {
                $locations = explode('(seperate)', $location);

                $serialize_location = serialize(implode('(seperate)', $locations));
                $serialize_longitude = serialize($longitude);
                $serialize_latitude = serialize($latitude);

                $updateManageBusinessModel = array_filter([
                    'name' => $name,
                    'details' => $details,
                    'category_id' => $category_id,
                    'service' => $service,
                    'location' => $serialize_location,
                    'longitude' => $serialize_longitude,
                    'latitude' => $serialize_latitude,
                    'images' => $images,
                    'phone_number' => $phone_number,
                ]);
            } else {
                $updateManageBusinessModel = array_filter([
                    'name' => $name,
                    'details' => $details,
                    'category_id' => $category_id,
                    'service' => $service,
                    'location' => $location,
                    'longitude' => $longitude,
                    'latitude' => $latitude,
                    'images' => $images,
                    'phone_number' => $phone_number,
                ]);
            }

            $updateManageBusinessUserModel = array_filter([
                'view_as' => $view_as,
                'web_link' => $web_link,
            ]);

            $businessDayTiming = BuisnessTiming::where('buisness_id', $id)->first();
            if (!empty($businessDayTiming)) {
                $updateManageBusinessDayTimingModel = array_filter([
                    'day' => $days,
                    'opening_hours' => $opening_hours,
                    'closing_hours' => $closing_hours,
                    'availability' => $availability
                ]);

                $businessDayTiming->update($updateManageBusinessDayTimingModel);
                $businessDayTiming->refresh();
            } else {
                $businessDayTiming = new BuisnessTiming();
                $businessDayTiming->buisness_id = $id;
                $businessDayTiming->day = $days;
                $businessDayTiming->opening_hours = $opening_hours;
                $businessDayTiming->closing_hours = $closing_hours;
                $businessDayTiming->availability = $availability;

                $businessDayTiming->save();
            }

            $updateManageBusinessStatus = $business->update($updateManageBusinessModel);
            $user->update($updateManageBusinessUserModel);

            if ($updateManageBusinessStatus) {
                $business->refresh();
                $user->refresh();

                foreach ($business->getAttributes() as $key => $value) {
                    if ($value === null) {
                        $business->{$key} = "";
                    }
                }

                $businessTiming = BuisnessTiming::where('buisness_id', $id)->first();
                $day = explode(',', $businessTiming->day);
                $openingHours = explode(',', $businessTiming->opening_hours);
                $closingHours = explode(',', $businessTiming->closing_hours);
                $availability = explode(',', $businessTiming->availability);

                $category = category::find($business->category_id);
                if (empty($category)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Category not found.',
                    ], 401);
                }

                $viewAs = $user->view_as ?? "";
                $webLinks = $user->web_link;
                $location = $business->location;
                $longitude = $business->longitude;
                $latitude = $business->latitude;
                $cover_image = $business->cover_image;
                $images = $business->images;


                if (empty($cover_image)) {
                    $cover_image = 'No_Image_Available.jpg';
                }

                if ($images) {
                    $images = explode(',', $images);
                } else {
                    $images = [];
                }

                if ($webLinks) {
                    $webLinks = explode(',', $webLinks);
                } else {
                    $webLinks = [];
                }

                if (strpos($location, 's:') === 0) {
                    $location = explode('(seperate)', unserialize($location));
                } else {
                    $location = [];
                }

                if (strpos($longitude, 's:') === 0) {
                    $longitude = explode(',', unserialize($longitude));
                } else {
                    $longitude = [];
                }

                if (strpos($latitude, 's:') === 0) {
                    $latitude = explode(',', unserialize($latitude));
                } else {
                    $latitude = [];
                }

                $business = $business->only([
                    'id',
                    'name',
                    'details',
                    'service',
                    'cover_image',
                    'thumbnail',
                    'phone_number',
                ]);

                $business['category_name'] = $category->name;
                $business['view_as'] = $viewAs;
                $business['location'] = $location;
                $business['longitude'] = $longitude;
                $business['latitude'] = $latitude;
                $business['web_link'] = $webLinks;
                $business['cover_image'] = $cover_image;
                $business['images'] = $images;
                $business['days'] = $day;
                $business['opening_hours'] = $openingHours;
                $business['closing_hours'] = $closingHours;
                $business['availability'] = $availability;

                return response()->json([
                    'success' => true,
                    'response' => $business
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to update manage business model',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateManageBusinessThumbnail(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $business = Buisness::find($id);

            if (empty($business)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Business not found.',
                ], 401);
            }

            if ($request->file('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $newFilename = uniqid() . '_' . $thumbnail->getClientOriginalName();
                $thumbnail->move(public_path() . '/uploads/business/', $newFilename);
                $business->thumbnail = $newFilename;
            }
            $business->save();

            $user = User::where('id', $business->user_id)->first();

            if (empty($user)) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found.',
                ], 401);
            }

            $businessTiming = BuisnessTiming::where('buisness_id', $id)->first();

            if (!is_null($businessTiming)) {
                $day = explode(',', $businessTiming->day);
                $openingHours = explode(',', $businessTiming->opening_hours);
                $closingHours = explode(',', $businessTiming->closing_hours);
                $availability = explode(',', $businessTiming->availability);
            } else {
                $businessTimingDefault = BuisnessTiming::find(1);
                $day = explode(',', $businessTimingDefault->day);
                $openingHours = explode(',', $businessTimingDefault->opening_hours);
                $closingHours = explode(',', $businessTimingDefault->closing_hours);
                $availability = explode(',', $businessTimingDefault->availability);
            }

            foreach ($business->getAttributes() as $key => $value) {
                if (is_null($value)) {
                    $business->{$key} = "";
                }
            }

            $category = category::find($business->category_id);

            if (empty($category)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found.',
                ], 401);
            }

            $viewAs = $user->view_as ?? "";
            $webLinks = $user->web_link;
            $location = $business->location;
            $longitude = $business->longitude;
            $latitude = $business->latitude;
            $cover_image = $business->cover_image;
            $images = $business->images;

            if (empty($cover_image)) {
                $cover_image = 'No_Image_Available.jpg';
            }

            if ($images) {
                $images = explode(',', $images);
            } else {
                $images = [];
            }

            if ($webLinks) {
                $webLinks = explode(',', $webLinks);
            } else {
                $webLinks = [];
            }

            if (strpos($location, 's:') === 0) {
                $location = explode('(seperate)', unserialize($location));
            } else {
                $location = [];
            }

            if (strpos($longitude, 's:') === 0) {
                $longitude = explode(',', unserialize($longitude));
            } else {
                $longitude = [];
            }

            if (strpos($latitude, 's:') === 0) {
                $latitude = explode(',', unserialize($latitude));
            } else {
                $latitude = [];
            }

            $business = $business->only([
                'id',
                'name',
                'details',
                'service',
                'cover_image',
                'thumbnail',
                'phone_number',
            ]);

            $business['category_name'] = $category->name;
            $business['view_as'] = $viewAs;
            $business['location'] = $location;
            $business['longitude'] = $longitude;
            $business['latitude'] = $latitude;
            $business['web_link'] = $webLinks;
            $business['cover_image'] = $cover_image;
            $business['images'] = $images;
            $business['days'] = $day;
            $business['opening_hours'] = $openingHours;
            $business['closing_hours'] = $closingHours;
            $business['availability'] = $availability;

            return response()->json([
                'success' => true,
                'response' => $business
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    public function uploadCoverImage(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        try {
            $business = Buisness::find($id);

            if (empty($business)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Business not found.',
                ], 401);
            }

            if ($request->file('cover_image')) {
                $thumbnail = $request->file('cover_image');
                $newFilename = uniqid() . '_' . $thumbnail->getClientOriginalName();
                $thumbnail->move(public_path() . '/uploads/business/', $newFilename);
                $business->cover_image = $newFilename;
            }
            $business->save();

            $user = User::where('id', $business->user_id)->first();

            if (empty($user)) {
                return response()->json([
                    'status' => false,
                    'message' => 'User not found.',
                ], 401);
            }

            $businessTiming = BuisnessTiming::where('buisness_id', $id)->first();

            if (!is_null($businessTiming)) {
                $day = explode(',', $businessTiming->day);
                $openingHours = explode(',', $businessTiming->opening_hours);
                $closingHours = explode(',', $businessTiming->closing_hours);
                $availability = explode(',', $businessTiming->availability);
            } else {
                $businessTimingDefault = BuisnessTiming::find(1);
                $day = explode(',', $businessTimingDefault->day);
                $openingHours = explode(',', $businessTimingDefault->opening_hours);
                $closingHours = explode(',', $businessTimingDefault->closing_hours);
                $availability = explode(',', $businessTimingDefault->availability);
            }

            foreach ($business->getAttributes() as $key => $value) {
                if (is_null($value)) {
                    $business->{$key} = "";
                }
            }

            $category = category::find($business->category_id);

            if (empty($category)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Category not found.',
                ], 401);
            }

            $viewAs = $user->view_as ?? "";
            $webLinks = $user->web_link;
            $location = $business->location;
            $longitude = $business->longitude;
            $latitude = $business->latitude;
            $cover_image = $business->cover_image;
            $images = $business->images;

            if (empty($cover_image)) {
                $cover_image = 'No_Image_Available.jpg';
            }

            if ($images) {
                $images = explode(',', $images);
            } else {
                $images = [];
            }

            if ($webLinks) {
                $webLinks = explode(',', $webLinks);
            } else {
                $webLinks = [];
            }

            if (strpos($location, 's:') === 0) {
                $location = explode('(seperate)', unserialize($location));
            } else {
                $location = [];
            }

            if (strpos($longitude, 's:') === 0) {
                $longitude = explode(',', unserialize($longitude));
            } else {
                $longitude = [];
            }

            if (strpos($latitude, 's:') === 0) {
                $latitude = explode(',', unserialize($latitude));
            } else {
                $latitude = [];
            }

            $business = $business->only([
                'id',
                'name',
                'details',
                'service',
                'thumbnail',
                'phone_number',
            ]);

            $business['category_name'] = $category->name;
            $business['view_as'] = $viewAs;
            $business['location'] = $location;
            $business['longitude'] = $longitude;
            $business['latitude'] = $latitude;
            $business['web_link'] = $webLinks;
            $business['cover_image'] = $cover_image;
            $business['images'] = $images;
            $business['days'] = $day;
            $business['opening_hours'] = $openingHours;
            $business['closing_hours'] = $closingHours;
            $business['availability'] = $availability;

            return response()->json([
                'success' => true,
                'response' => $business
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    public function allChatsByUser($id): \Illuminate\Http\JsonResponse
    {
        try {
            $sender_id = (int)$id;
            $latestMessages = Message::with('recipient')
                ->where(function ($query) use ($id) {
                    $query->where('sender_id', $id)
                        ->orWhere('recipient_id', $id);
                })
                ->select('id', 'sender_id', 'recipient_id', 'content', 'flag', 'created_at')
                ->whereIn('id', function ($query) {
                    $query->select(\DB::raw('MAX(id)'))
                        ->from('messages')
                        ->groupBy(\DB::raw('GREATEST(sender_id, recipient_id)'), \DB::raw('LEAST(sender_id, recipient_id)'));
                })
                ->orderBy('created_at', 'DESC')
                ->get();

            if ($latestMessages->isNotEmpty()) {

                $messageData = [];
                foreach ($latestMessages as $message) {
                    $oppositeSide = null;

                    if ($id != $message->sender_id) {
                        $business_sender = Buisness::where('user_id', $message->sender_id)->select('user_id', 'name', 'thumbnail')->orderBy('created_at', 'DESC')->first();
                        if ($business_sender) {
                            $business_sender->thumbnail = $business_sender->thumbnail ? "https://websitedemolink.co/christian-business-finder/public/uploads/business/{$business_sender->thumbnail}" : "https://websitedemolink.co/christian-business-finder/public/uploads/business/No_Image_Available.jpg";
                            $oppositeSide = $business_sender;
                        } else {
                            $user_sender = User::where('id', $message->sender_id)->select('id', 'name', 'profile_image')->first();
                            if ($user_sender) {
                                $user_sender->profile_image = $user_sender->profile_image ? "https://websitedemolink.co/christian-business-finder/public/assets/uploads/user/{$user_sender->profile_image}" : "https://websitedemolink.co/christian-business-finder/public/uploads/business/user-img.png";
                                $oppositeSide = $user_sender;
                            }
                        }
                    } else {
                        $business_recipient = Buisness::where('user_id', $message->recipient_id)->select('user_id', 'name', 'thumbnail')->orderBy('created_at', 'DESC')->first();
                        if ($business_recipient) {
                            $business_recipient->thumbnail = $business_recipient->thumbnail ? "https://websitedemolink.co/christian-business-finder/public/uploads/business/{$business_recipient->thumbnail}" : "https://websitedemolink.co/christian-business-finder/public/uploads/business/No_Image_Available.jpg";
                            $oppositeSide = $business_recipient;
                        } else {
                            $user_recipient = User::where('id', $message->recipient_id)->select('id', 'name', 'profile_image')->first();
                            if ($user_recipient) {
                                $user_recipient->profile_image = $user_recipient->profile_image ? "https://websitedemolink.co/christian-business-finder/public/assets/uploads/user/{$user_recipient->profile_image}" : "https://websitedemolink.co/christian-business-finder/public/uploads/business/user-img.png";
                                $oppositeSide = $user_recipient;
                            }
                        }
                    }

                    $oppositeSideData = [
                        'recipient_id' => $oppositeSide ? $oppositeSide->user_id ?? $oppositeSide->id : "",
                        'recipient_name' => $oppositeSide ? $oppositeSide->name : "",
                        'recipient_thumbnail' => $oppositeSide ? ($oppositeSide->thumbnail ?? $oppositeSide->profile_image) : "",
                    ];
                    $recipientThumbnail = isset($message->recipient) && $message->recipient ? $message->recipient->thumbnail : "";

                    $messageData[] = [
                        'id' => $message->id,
                        'sent_by' => $message->sender_id, // $sender_id,
                        'sender_id' => $sender_id, // $message->sender_id,
                        'recipient_id' => $oppositeSide ? $oppositeSide->user_id ?? $oppositeSide->id : "", // $message->recipient_id,
                        'recipient_name' => $oppositeSide ? $oppositeSide->name : "Deleted Account", // $message->recipient->name ?? 'Deleted Account',
                        'recipient_thumbnail' => $oppositeSide ? ($oppositeSide->thumbnail ?? $oppositeSide->profile_image) : "", // "https://websitedemolink.co/christian-business-finder/public/uploads/business/{$recipientThumbnail}" ?? 'No_Image_Available.jpg',
                        'content' => $message->content,
                        'flag' => $message->flag,
                        'created_at' => $message->created_at,
                        // 'oppositeSideData' => $oppositeSideData,
                    ];
                }

                return response()->json([
                    'success' => true,
                    'response' => $messageData,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'response' => [],
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    public function specificChatByUser(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $senderId = $request->input('sender_id');
            $recipientId = $request->input('recipient_id');
            $offset = $request->input('offset', 0);
            $perPage = $request->input('per_page', 15);

            /*$messages = Message::where(function ($query) use ($senderId, $recipientId) {
                $query->where(['sender_id' => $senderId, 'recipient_id' => $recipientId])
                    ->orWhere(['sender_id' => $recipientId, 'recipient_id' => $senderId]);
            })
                ->offset($offset)
                ->limit($perPage)
                ->orderBy('id', 'DESC')
                ->get();*/

            $messages = Message::where([
                ['sender_id', $senderId],
                ['recipient_id', $recipientId]
            ])->orWhere([
                ['sender_id', $recipientId],
                ['recipient_id', $senderId]
            ])
                ->offset($offset)
                ->limit($perPage)
                ->orderBy('id', 'DESC')
                ->get();

            if ($messages->count() > 0) {
                $cleanedMessages = $messages->map(function ($message) {
                    return collect($message)->except(['updated_at', 'id'])->toArray();
                });

                $formattedMessages = $messages->map(function ($message) {
                    $createdAtParts = explode(' ', $message->created_at);
                    return [
                        'sender_id' => $message->sender_id,
                        'recipient_id' => $message->recipient_id,
                        'content' => $message->content,
                        'created_date' => $createdAtParts[0],
                        'created_time' => $createdAtParts[1],
                    ];
                });

                return response()->json([
                    'success' => true,
                    'response' => $cleanedMessages,
                    // 'response' => $formattedMessages,
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'response' => 'No messages found.',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    public function sentChatByUser(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $senderId = $request->input('sender_id');
            $recipientId = $request->input('recipient_id');
            $content = $request->input('content');

            $message = Message::create([
                'sender_id' => $senderId,
                'recipient_id' => $recipientId,
                'content' => $content,
            ]);

            $factory = (new Factory)->withServiceAccount([
                "type" => "service_account",
                "project_id" => "christian-business-finder-app",
                "private_key_id" => "f7b0be0056ede86fb7d941448935e8673349fcaa",
                "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDo3SEGdOXsw4nh\nIgF5oNk2BhB1R8AoS+i40fEKq1NrsUyGEEbXx1lZJdYZiFSzadv+LNoq/4P4wFlz\nkp8MV0wvfWSxAVu8zv9Hm1aL2gGZxb5NNUj1NH+eou03yzOADMlKk2B3eMuhp8cI\nHPHJa9e9k0Mud+4+npPI2Oytt4b7dbZsrilvKkQfvKNspzaUxR+9IDacjnkWN2nd\nSma3ZGslu4MJ/Cw2HGGfM2I3b1rs6J4PV5wce1qYOBUk3rp46l0/DPH9LpSNNLpR\n0dok2j9WSGzm8wGuyp1s6rlwxg94wU8LpiWalCPiM3+YXQt/FwNcV6rKtAhWdxaB\nFAHfSWzZAgMBAAECggEAElYLOi9tRXH2QvCDDjlAsVTT6fA+7M1hY2BAqzbnaDT7\nUhkpAuezHOZyT+tgxAnjZUXR3g3lreozgPq8JGQhXyHwElIJj7n69v//1h5R/vJH\ntFusRYafP/YTWM/a28vl88XcFDxCSJXmAbkJvvMLd2WHpjqSW4LwHyIZrOolKlqp\nigAFub2rH3d5+BmPCTaP54bPZaxUHzsQZ8kmc0J4eYzHn82r3Nb23TUw000AbwS2\n3V/7rlOXr1swDUV6Pym46wfsgZRhzrz2Ge+bDy320cMhkEtzz6fAnREXbzxGQIhY\nZ+crlNcjQnFBflDcheFF0MctIjqzIE/HwGmIelr/gQKBgQD98+j5FKsQAAbjV0f9\nM+CqPeFOs3emt//Oz2FJECMUymAdSGNXyFIqTsvtXwCJtjNnzJ3Jny6Ns52OeFTH\nF1ImflwuJkbpFnQQh3VQ+w/eXDP/qbTgBwMnvyGUy/JkJLwERXT/CSUHFjKw6y6f\nTsLVT5Vri5VWDV3j3HRNBnx8uQKBgQDqvbJtD2VwcKPLqb81Rbo2V5k+v9qiEnUJ\ntibqSgWMbZmYxgWveH0qVUmqWP/iDfKoIWWpAIxSg3pvPIYBiYe9eW/gXRlbfY9v\niAz3J2iAyfZ/RngLB2tf6Ptx90OotWVC0xxqWzoTtvgBUoF/n3was0q40I2G5zPV\nfsiwELWhIQKBgFxeA+Xc059dMyQrUd7RqKyjFzkF48Y69IsnOK5XdTsRpMXh12hN\nTz1eLaQnws1T/PyLGvUDte4KX4s7TzKe0912ZlbOy0nqRcrhShVrS8lH5g3ejxBQ\n3J/vT+qMB5zPE6fGD5jXnaUnOMbKs8lz3z+w05srSOTktbq0K4T8j/jZAoGAUhhV\ntl6UE2bRYgDTpkXkgezQ42klhVj/JY5Wvcl1d089UHiwtFVnMM7zHGhT1TMbkkFb\n1GckrBbfUtfP5em7V0CJJ+ZnX9/hshfasPVPTvtTAeAbS4AkxT4t8gWP3AjUiTJb\n1bZh8VMkGRJJx+B2/r+Fem01keB5+EiG10yAuQECgYAXPYzQUBiGSkNMdekFCGN4\nk/0xHbCZodZOTMibz2llfEjq0HjnJ+B8W08ad/iH1nFMGAS5+E2LaFLwxcLrDKv6\ny4xTPwU6j3j1K1X4HpTZI1/5xQsoRziw1exIHMvzMVUAyqqVkkwMDAWtlII59Phr\ncs18spIZENGJkFivRKIEYw==\n-----END PRIVATE KEY-----\n",
                "client_email" => "firebase-adminsdk-f7vc8@christian-business-finder-app.iam.gserviceaccount.com",
                "client_id" => "100015504870668066714",
                "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
                "token_uri" => "https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-f7vc8%40christian-business-finder-app.iam.gserviceaccount.com",
                "universe_domain" => "googleapis.com"
            ]);

            $sender = User::find($senderId);
            $recipient = User::find($recipientId);
            $recipientFcmToken = $recipient->fcm_token;
            $businessUser = Buisness::where('user_id', $senderId)->first();

            if ($businessUser) {
                $this->firebaseConfiguration($factory, $recipientFcmToken, null, $content, $senderId, $businessUser);
            } else {
                $this->firebaseConfiguration($factory, $recipientFcmToken, $sender, $content, $senderId, null);
            }

            return response()->json([
                'success' => true,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        } catch (MessagingException|FirebaseException $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    public function sentChatByImage(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $senderId = $request->input('sender_id');
            $recipientId = $request->input('recipient_id');

            $message = new Message();
            $message->sender_id = $senderId;
            $message->recipient_id = $recipientId;

            if ($request->hasFile('image')) {
                $image = Str::random(17) . '_' . $request->file('image')->getClientOriginalName();
                $request->image->move(public_path('assets/uploads/chats/images/'), $image);
                $message->content = $image;
                $message->flag = 1;
            } else {
                $message->content = 'Corrupted File.';
                $message->flag = 0;
            }

            $message->save();


            $data = $message->only([
                'sender_id',
                'recipient_id',
                'content',
                'flag',
                'created_at',
            ]);

            $factory = (new Factory)->withServiceAccount([
                "type" => "service_account",
                "project_id" => "christian-business-finder-app",
                "private_key_id" => "f7b0be0056ede86fb7d941448935e8673349fcaa",
                "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDo3SEGdOXsw4nh\nIgF5oNk2BhB1R8AoS+i40fEKq1NrsUyGEEbXx1lZJdYZiFSzadv+LNoq/4P4wFlz\nkp8MV0wvfWSxAVu8zv9Hm1aL2gGZxb5NNUj1NH+eou03yzOADMlKk2B3eMuhp8cI\nHPHJa9e9k0Mud+4+npPI2Oytt4b7dbZsrilvKkQfvKNspzaUxR+9IDacjnkWN2nd\nSma3ZGslu4MJ/Cw2HGGfM2I3b1rs6J4PV5wce1qYOBUk3rp46l0/DPH9LpSNNLpR\n0dok2j9WSGzm8wGuyp1s6rlwxg94wU8LpiWalCPiM3+YXQt/FwNcV6rKtAhWdxaB\nFAHfSWzZAgMBAAECggEAElYLOi9tRXH2QvCDDjlAsVTT6fA+7M1hY2BAqzbnaDT7\nUhkpAuezHOZyT+tgxAnjZUXR3g3lreozgPq8JGQhXyHwElIJj7n69v//1h5R/vJH\ntFusRYafP/YTWM/a28vl88XcFDxCSJXmAbkJvvMLd2WHpjqSW4LwHyIZrOolKlqp\nigAFub2rH3d5+BmPCTaP54bPZaxUHzsQZ8kmc0J4eYzHn82r3Nb23TUw000AbwS2\n3V/7rlOXr1swDUV6Pym46wfsgZRhzrz2Ge+bDy320cMhkEtzz6fAnREXbzxGQIhY\nZ+crlNcjQnFBflDcheFF0MctIjqzIE/HwGmIelr/gQKBgQD98+j5FKsQAAbjV0f9\nM+CqPeFOs3emt//Oz2FJECMUymAdSGNXyFIqTsvtXwCJtjNnzJ3Jny6Ns52OeFTH\nF1ImflwuJkbpFnQQh3VQ+w/eXDP/qbTgBwMnvyGUy/JkJLwERXT/CSUHFjKw6y6f\nTsLVT5Vri5VWDV3j3HRNBnx8uQKBgQDqvbJtD2VwcKPLqb81Rbo2V5k+v9qiEnUJ\ntibqSgWMbZmYxgWveH0qVUmqWP/iDfKoIWWpAIxSg3pvPIYBiYe9eW/gXRlbfY9v\niAz3J2iAyfZ/RngLB2tf6Ptx90OotWVC0xxqWzoTtvgBUoF/n3was0q40I2G5zPV\nfsiwELWhIQKBgFxeA+Xc059dMyQrUd7RqKyjFzkF48Y69IsnOK5XdTsRpMXh12hN\nTz1eLaQnws1T/PyLGvUDte4KX4s7TzKe0912ZlbOy0nqRcrhShVrS8lH5g3ejxBQ\n3J/vT+qMB5zPE6fGD5jXnaUnOMbKs8lz3z+w05srSOTktbq0K4T8j/jZAoGAUhhV\ntl6UE2bRYgDTpkXkgezQ42klhVj/JY5Wvcl1d089UHiwtFVnMM7zHGhT1TMbkkFb\n1GckrBbfUtfP5em7V0CJJ+ZnX9/hshfasPVPTvtTAeAbS4AkxT4t8gWP3AjUiTJb\n1bZh8VMkGRJJx+B2/r+Fem01keB5+EiG10yAuQECgYAXPYzQUBiGSkNMdekFCGN4\nk/0xHbCZodZOTMibz2llfEjq0HjnJ+B8W08ad/iH1nFMGAS5+E2LaFLwxcLrDKv6\ny4xTPwU6j3j1K1X4HpTZI1/5xQsoRziw1exIHMvzMVUAyqqVkkwMDAWtlII59Phr\ncs18spIZENGJkFivRKIEYw==\n-----END PRIVATE KEY-----\n",
                "client_email" => "firebase-adminsdk-f7vc8@christian-business-finder-app.iam.gserviceaccount.com",
                "client_id" => "100015504870668066714",
                "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
                "token_uri" => "https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-f7vc8%40christian-business-finder-app.iam.gserviceaccount.com",
                "universe_domain" => "googleapis.com"
            ]);

            $sender = User::find($senderId);
            $recipient = User::find($recipientId);
            $recipientFcmToken = $recipient->fcm_token;
            $content = 'Recieved a image.';
            $businessUser = Buisness::where('user_id', $senderId)->first();

            if ($businessUser) {
                $this->firebaseConfiguration($factory, $recipientFcmToken, null, $content, $senderId, $businessUser);
            } else {
                $this->firebaseConfiguration($factory, $recipientFcmToken, $sender, $content, $senderId, null);
            }

            return response()->json([
                'success' => true,
                'response' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        } catch (MessagingException|FirebaseException $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    public function sentChatByAttachment(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'attachment' => 'required|file|mimes:pdf|max:5000',
        ]);

        try {
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'response' => $validator->messages()
                ], 406);
            }

            $senderId = $request->input('sender_id');
            $recipientId = $request->input('recipient_id');

            $message = new Message();
            $message->sender_id = $senderId;
            $message->recipient_id = $recipientId;

            if ($request->hasFile('attachment')) {
                $attachment = Str::random(17) . '_' . $request->file('attachment')->getClientOriginalName();
                $request->attachment->move(public_path('assets/uploads/chats/attachment/'), $attachment);
                $message->content = $attachment;
                $message->flag = 2;
            } else {
                $message->content = 'Corrupted File.';
                $message->flag = 0;
            }

            $message->save();
            $data = $message->only([
                'sender_id',
                'recipient_id',
                'content',
                'flag',
                'created_at',
            ]);

            $factory = (new Factory)->withServiceAccount([
                "type" => "service_account",
                "project_id" => "christian-business-finder-app",
                "private_key_id" => "f7b0be0056ede86fb7d941448935e8673349fcaa",
                "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDo3SEGdOXsw4nh\nIgF5oNk2BhB1R8AoS+i40fEKq1NrsUyGEEbXx1lZJdYZiFSzadv+LNoq/4P4wFlz\nkp8MV0wvfWSxAVu8zv9Hm1aL2gGZxb5NNUj1NH+eou03yzOADMlKk2B3eMuhp8cI\nHPHJa9e9k0Mud+4+npPI2Oytt4b7dbZsrilvKkQfvKNspzaUxR+9IDacjnkWN2nd\nSma3ZGslu4MJ/Cw2HGGfM2I3b1rs6J4PV5wce1qYOBUk3rp46l0/DPH9LpSNNLpR\n0dok2j9WSGzm8wGuyp1s6rlwxg94wU8LpiWalCPiM3+YXQt/FwNcV6rKtAhWdxaB\nFAHfSWzZAgMBAAECggEAElYLOi9tRXH2QvCDDjlAsVTT6fA+7M1hY2BAqzbnaDT7\nUhkpAuezHOZyT+tgxAnjZUXR3g3lreozgPq8JGQhXyHwElIJj7n69v//1h5R/vJH\ntFusRYafP/YTWM/a28vl88XcFDxCSJXmAbkJvvMLd2WHpjqSW4LwHyIZrOolKlqp\nigAFub2rH3d5+BmPCTaP54bPZaxUHzsQZ8kmc0J4eYzHn82r3Nb23TUw000AbwS2\n3V/7rlOXr1swDUV6Pym46wfsgZRhzrz2Ge+bDy320cMhkEtzz6fAnREXbzxGQIhY\nZ+crlNcjQnFBflDcheFF0MctIjqzIE/HwGmIelr/gQKBgQD98+j5FKsQAAbjV0f9\nM+CqPeFOs3emt//Oz2FJECMUymAdSGNXyFIqTsvtXwCJtjNnzJ3Jny6Ns52OeFTH\nF1ImflwuJkbpFnQQh3VQ+w/eXDP/qbTgBwMnvyGUy/JkJLwERXT/CSUHFjKw6y6f\nTsLVT5Vri5VWDV3j3HRNBnx8uQKBgQDqvbJtD2VwcKPLqb81Rbo2V5k+v9qiEnUJ\ntibqSgWMbZmYxgWveH0qVUmqWP/iDfKoIWWpAIxSg3pvPIYBiYe9eW/gXRlbfY9v\niAz3J2iAyfZ/RngLB2tf6Ptx90OotWVC0xxqWzoTtvgBUoF/n3was0q40I2G5zPV\nfsiwELWhIQKBgFxeA+Xc059dMyQrUd7RqKyjFzkF48Y69IsnOK5XdTsRpMXh12hN\nTz1eLaQnws1T/PyLGvUDte4KX4s7TzKe0912ZlbOy0nqRcrhShVrS8lH5g3ejxBQ\n3J/vT+qMB5zPE6fGD5jXnaUnOMbKs8lz3z+w05srSOTktbq0K4T8j/jZAoGAUhhV\ntl6UE2bRYgDTpkXkgezQ42klhVj/JY5Wvcl1d089UHiwtFVnMM7zHGhT1TMbkkFb\n1GckrBbfUtfP5em7V0CJJ+ZnX9/hshfasPVPTvtTAeAbS4AkxT4t8gWP3AjUiTJb\n1bZh8VMkGRJJx+B2/r+Fem01keB5+EiG10yAuQECgYAXPYzQUBiGSkNMdekFCGN4\nk/0xHbCZodZOTMibz2llfEjq0HjnJ+B8W08ad/iH1nFMGAS5+E2LaFLwxcLrDKv6\ny4xTPwU6j3j1K1X4HpTZI1/5xQsoRziw1exIHMvzMVUAyqqVkkwMDAWtlII59Phr\ncs18spIZENGJkFivRKIEYw==\n-----END PRIVATE KEY-----\n",
                "client_email" => "firebase-adminsdk-f7vc8@christian-business-finder-app.iam.gserviceaccount.com",
                "client_id" => "100015504870668066714",
                "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
                "token_uri" => "https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-f7vc8%40christian-business-finder-app.iam.gserviceaccount.com",
                "universe_domain" => "googleapis.com"
            ]);

            $sender = User::find($senderId);
            $recipient = User::find($recipientId);
            $recipientFcmToken = $recipient->fcm_token;
            $content = 'Received a attachment.';
            $businessUser = Buisness::where('user_id', $senderId)->first();

            if ($businessUser) {
                $this->firebaseConfiguration($factory, $recipientFcmToken, null, $content, $senderId, $businessUser);
            } else {
                $this->firebaseConfiguration($factory, $recipientFcmToken, $sender, $content, $senderId, null);
            }

            return response()->json([
                'success' => true,
                'response' => $data,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        } catch (MessagingException|FirebaseException $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    private function firebaseConfiguration($factory = null, $recipientFcmToken = null, $sender = null, $content = null, $senderId = null, $businessUser = null): void
    {
        try {
            if (!empty($recipientFcmToken)) {
                $messaging = $factory->createMessaging();
                $firebaseMessage = CloudMessage::withTarget('token', $recipientFcmToken)
                    ->withNotification([
                        'title' => $businessUser ? $businessUser->name : $sender->name,
                        'body' => $content,
                    ])
                    ->withData([
                        'sender_id' => $senderId,
                        'image' => $businessUser ? "https://websitedemolink.co/christian-business-finder/public/uploads/business/" . $businessUser->thumbnail : "https://websitedemolink.co/christian-business-finder/public/assets/uploads/user/" . $sender->profile_image
                    ]);
                $messaging->send($firebaseMessage);

                response()->json([
                    'success' => true,
                ], 200);
                return;
            }
        } catch (\Exception $e) {
            response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
            return;
        } catch (MessagingException|FirebaseException $e) {
            response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
            return;
        }
    }

    public function getNotification($id): \Illuminate\Http\JsonResponse
    {
        try {
            $user = User::find($id);

            if (empty($user)) {
                return response()->json([
                    'success' => false,
                    'response' => 'User not found.',
                ], 401);
            }

            $type = $user->type;
            $notifications = AdminNotification::orderBy('created_at', 'DESC')->get();

            if ($notifications->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'response' => 'Notification not found.',
                ], 403);
            }

            $notificationGet = [];
            foreach ($notifications as $notification) {
                $userType = explode(',', $notification->user_type);

                if (is_array($userType) && in_array($type, $userType)) {
                    $image = $notification->image ? asset('uploads/notification/' . $notification->image) : asset('uploads/notification/bell-image.png');
                    $title = $notification->notification_title;
                    $description = strip_tags($notification->notification_description);
                    $created_at = $notification->created_at;

                    $notificationGet[] = [
                        'image' => $image,
                        'title' => $title,
                        'description' => $description,
                        'created_at' => $created_at,
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'response' => $notificationGet,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'response' => $e->getMessage(),
            ], 500);
        }
    }

    public function bannerImage(): \Illuminate\Http\JsonResponse
    {
        try {
            $banners = banner::where('is_active', 1)->get();
            $bannerData = [];

            foreach ($banners as $banner) {
                $bannerData[] = $banner['file'];
            }

            return response()->json([
                'success' => true,
                'response' => $bannerData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function paypalPaymentGateway($amount = null)
    {
        try {
            if (is_null($amount) || $amount === '0') {
                $subscription = Subscription::first();
                $amount = $subscription ? $subscription->amount : 0;
            }

            return view('front-cbf.paypal-app.payment-gateway', compact('amount'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function userCreate(Request $request): \Illuminate\Http\JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'number' => 'required',
            'denomination' => 'required',
            'fcm_token' => 'required',
            'buisness_type' => 'required',
            'buisness_name' => 'required',
            'buisness_categories' => 'required',
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
            $user->fcm_token = $request->input('fcm_token');
            $user->buisness_name = $request->input('buisness_name');
            $user->buisness_description = $request->input('buisness_description');
            $user->buisness_categories = $request->input('buisness_categories');
            $user->latitude = implode(',', $latitude);
            $user->longitude = implode(',', $longitude);
            $user->web_link = implode(',', $web_link);
            $couponCode = $request->input('coupon_code');
            $referralCode = $request->input('referral_code');
            $amount = $request->input('amount');

            $user->save();
            $user_login_token = $user->createToken('renterprise')->accessToken;
            Auth::login($user);

            if ($user) {
                $this->paymentCreate($user, $amount);
                $user->makePaidMember();
            }

            if ($referralCode || $couponCode) {
                $this->saveApiSalesPerson($user, $referralCode, $couponCode);
            }

            $business = new Buisness();
            $business->user_id = $user->id;
            $business->type = $request->type;
            $business->buisness_type = $request->buisness_type;
            $business->category_id = $request->buisness_categories;
            $business->name = $request->buisness_name;
            $business->ratings = '0';
            $business->details = $request->buisness_description;
            $business->service = $request->service ?? '';
            $business->phone_number = $request->number;
            $business->thumbnail = 'No_Image_Available.jpg';
            $business->images = 'No_Image_Available.jpg';
            $business->opening_hours = '00:00';

            if ($location) {
                if (strpos($location, '(seperate)') !== false) {
                    $locations = explode('(seperate)', $location);

                    $serialize_location = serialize(implode('(seperate)', $locations));
                    $serialize_longitude = serialize($longitude);
                    $serialize_latitude = serialize($latitude);
                    $business->location = $serialize_location;
                    $business->longitude = $serialize_longitude;
                    $business->latitude = $serialize_latitude;
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

            $userData = $user->only([
                'id',
                'type',
                'name',
                'email',
                'profile_image',
                'date_of_birth',
                'number',
                'gender',
                'city',
                'state',
                'country',
                'home_church_name',
                'home_church_address',
                'denomination',
                'view_as',
                'fcm_token',
            ]);

            foreach ($userData as $key => $value) {
                if (is_null($value)) {
                    $userData[$key] = "";
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'response' => $userData,
                'token' => $user_login_token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    protected function saveApiSalesPerson(User $user = null, $referralCode = null, $couponCode = null)
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

    public function subscriptionPaymentGateway($userId = null, $amount = null)
    {
        try {
            if (is_null($amount) || $amount === '0' && is_null($userId)) {
                $subscription = Subscription::first();
                $amount = $subscription ? $subscription->amount : 0;
            }

            return view('front-cbf.paypal-app.subscription-payment-gateway', compact('amount', 'userId'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function userUpdate(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $id = $request->input('user_id');
            $amount = $request->input('amount');
            $user = User::find($id);
            $user->type = 'paid_member';
            $user->subscription_expires_at = Carbon::now()->addMonth();
            $user->save();

            $this->paymentCreate($user, $amount);

            return response()->json([
                'success' => true,
                'message' => 'Subscription create successfully'
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
        Payment::create([
            'user_id' => $user->id,
            'amount' => $amount,
            'pay_method_name' => 'paypal'
        ]);
    }
}
