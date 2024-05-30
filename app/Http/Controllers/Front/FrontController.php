<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Buisness;
use App\Models\BuisnessTiming;
use App\Models\category;
use App\Models\City;
use App\Models\inquiry;
use App\Models\Like;
use App\Models\logo;
use App\Models\Message;
use App\Models\newsletter;
use App\Models\Payment;
use App\Models\Rating;
use App\Models\SalesPersonUser;
use App\Models\setting;
use App\Models\State;
use App\Models\Subscription;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FrontController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userId = $user->id ?? null;
        $categories = category::all();
        $states = State::all();
        $cities = City::all();
        $suggestions = Suggestion::with('buisness')->get();

        $processedCategories = [];
        $processedSuggestions = [];

        foreach ($categories as $category) {
            $business = $category->buisness;
            $processedCategories[] = [
                'business' => $business,
                'category' => $category,
            ];
        }

        foreach ($suggestions as $suggestion) {
            $business = $suggestion->buisness;
            $likes = $suggestion->buisness->likes;
            $business->like = $this->likes($likes, $userId);

            $categoryId = $business->category_id;
            $category = Category::find($categoryId);

            if (strpos($business->location, 's:') === 0) {
                $business->location = explode('(seperate)', unserialize($business->location));
            }

            $business->location = is_array($business->location) ? $business->location : [$business->location];
            $business->location = implode(',', $business->location);

            $processedSuggestions[] = [
                'business' => $business,
                'category' => $category,
            ];
        }

        return view('front-cbf.index', compact('processedSuggestions', 'processedCategories', 'userId', 'states', 'cities'));
    }

    public function category()
    {
        $categories = category::all();
        $processedCategories = [];

        foreach ($categories as $category) {
            $business = $category->buisness;
            $processedCategories[] = [
                'category' => $category,
                'business' => $business,
            ];
        }
        return view('front-cbf.category', compact('processedCategories'))->with('title', "Category");
    }

    public function categoryDetails($slug)
    {
        $userId = Auth::user()->id;
        $categories = category::with('buisness')->where('slug', $slug)->get();
        $processedBusinesses = [];
        $categoryName = "";

        foreach ($categories as $category) {

            $categoryName = $category->name;
            foreach ($category['buisness'] as $business) {

                $likes = $business['likes'];
                foreach ($likes as $like) {
                    if ((string)$like->user_id == (string)$userId) {
                        $business->like = $like ?? null;
                    }
                }

                $categoryId = $business->category_id;
                $category = Category::find($categoryId);
                $categoryName = $category->name;

                if (strpos($business->location, 's:') === 0) {
                    $business->location = explode('(seperate)', unserialize($business->location));
                }

                $business->location = is_array($business->location) ? $business->location : [$business->location];
                $business->location = implode(',', $business->location);

                $processedBusinesses[] = [
                    'business' => $business,
                    'category' => $category,
                ];
            }
        }

        return view('front-cbf.category-detail', compact('processedBusinesses', 'categoryName'))->with('title', "Category Detail");
    }

    public function editProfile()
    {
        $user = Auth::user();
        $userId = Auth::user()->id;
        $ownBusiness = Buisness::where('user_id', $userId)->first();

        return view('front-cbf.edit-profile', compact('ownBusiness', 'user'))->with('title', "Profile");
    }

    public function updateProfile(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $user = User::find($id);

        $name = $request->input('name');
        $number = $request->input('number');
        $date_of_birth = $request->input('date_of_birth');
        $gender = $request->input('gender');
        $city = $request->input('city');
        $state = $request->input('state');
        $country = $request->input('country');
        $denomination = $request->input('denomination');
        $home_church_name = $request->input('home_church_name');
        $home_church_address = $request->input('home_church_address');
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

            return redirect()->back()->with('success', 'Profile Updated Successfully.');
        } else {
            return redirect()->back()->with('error', 'Something Went Wrong.');
        }
    }

    public function updateProfileImage(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);

        if ($request->file('profile')) {
            $profile = $request->file('profile');
            $newFilename = uniqid() . '_' . $profile->getClientOriginalName();
            $profile->move(public_path() . 'assets/uploads/user/', $newFilename);
            $user->profile_image = $newFilename;
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile image updated successfully',
            'response' => asset('assets/uploads/user/' . $user->profile_image)
        ]);
    }

    public function business($id = null)
    {
        $userId = Auth::user()->id;
        $businesses = Buisness::all();
        $processedBusinesses = [];

        if ($id) {
            $business = Buisness::find($id);

            $likes = $business->likes;
            $business->like = $this->likes($likes, $userId);

            $categoryId = $business->category_id;
            $category = Category::find($categoryId);

            if (strpos($business->location, 's:') === 0) {
                $business->location = explode('(seperate)', unserialize($business->location));
            }

            $business->location = is_array($business->location) ? $business->location : [$business->location];
            $business->location = implode(',', $business->location);

            $processedBusinesses[] = [
                'business' => $business,
                'category' => $category,
            ];
        } else {
            foreach ($businesses as $business) {

                $likes = $business->likes;
                $business->like = $this->likes($likes, $userId);

                $categoryId = $business->category_id;
                $category = Category::find($categoryId);

                if (strpos($business->location, 's:') === 0) {
                    $business->location = explode('(seperate)', unserialize($business->location));
                }

                $business->location = is_array($business->location) ? $business->location : [$business->location];
                $business->location = implode(',', $business->location);

                $processedBusinesses[] = [
                    'business' => $business,
                    'category' => $category,
                ];
            }
        }

        return view('front-cbf.business', compact('processedBusinesses'))->with('title', "Business");
    }

    public function businessDetails($id)
    {
        $userId = Auth::user()->id;
        $business = Buisness::with('rating', 'likes')->find($id);
        $likes = $business->likes;
        $business->like = $this->likes($likes, $userId);

        $ratingCount = count($business->rating);
        $average = (string)$business->averageRating();
        $formatted_average = number_format($average, 2);

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

        $business->days = $day;
        $business->opening_hours = $openingHours;
        $business->closing_hours = $closingHours;
        $business->availability = $availability;

        $rating = Rating::where(['user_id' => $userId, 'buisness_id' => $business->id, 'flag' => '1'])->first();

        return view('front-cbf.business-detail', compact('business', 'ratingCount', 'formatted_average', 'rating'))->with('title', "Business Detail");
    }

    private function likes($likes, $userId)
    {
        foreach ($likes as $like) {
            if ((string)$like->user_id == (string)$userId) {
                return $like;
            }
        }

        return null;
    }

    public function resumeSend(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $business = Buisness::find($id);
        $email = $business->user['email'];
        $message = new Message();

        $attachment = $request->file('attachment');
        $message->sender_id = Auth::id();
        $message->recipient_id = $id;

        $extension = $attachment->getClientOriginalExtension();

        if ($extension === 'pdf') {
            $attachment = Str::random(17) . '_' . $request->file('attachment')->getClientOriginalName();
            $request->attachment->move(public_path('assets/uploads/chats/attachment/'), $attachment);
            $message->content = $attachment;
            $message->flag = 2;
        } else {
            $message->content = 'Corrupted File.';
            $message->flag = 0;
        }

        $message->save();
        $subject = 'Received Attachment';
        $emailMessage = view('front-cbf.email-template.email-resume', compact('business', 'attachment'));

        send_mail($email, $subject, $emailMessage);

        return response()->json([
            'success' => true,
            'message' => "Thank you! for show your interest we'll right back.",
        ]);
    }

    public function ratedUnratedBusiness($id): \Illuminate\Http\JsonResponse
    {
        $userId = Auth::id();
        $business = Buisness::with('rating')->where('id', $id)->first();
        $ratings = $business->rating;
        $foundRating = $ratings->where('user_id', $userId)->first();

        if (!is_null($foundRating)) {
            $flag = $foundRating->flag;

            if ($flag == 1) {
                $foundRating->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Rating Updated Successfully',
                'flag' => 0,
            ]);
        } else {
            $ratingData = [
                'user_id' => $userId,
                'buisness_id' => $id,
                'flag' => 1,
                'ratings' => 1,
            ];

            $newRating = Rating::create($ratingData);
            $newRating->save();

            return response()->json([
                'success' => true,
                'message' => 'Rating Placed Successfully',
                'ratings' => $newRating,
                'flag' => 1,
            ]);
        }
    }

    public function manageBusiness($id)
    {
        $business = Buisness::find($id);
        $categories = category::all();
        $subscriptionAmount = Subscription::first()->amount;

        $businessUser = $business->user;
        $checkSubscription = $businessUser['subscription_expires_at'];

        if (strpos($business->location, 's:') === 0) {
            $business->location = explode('(seperate)', unserialize($business->location));
        }

        if (strpos($business->longitude, 's:') === 0) {
            $business->longitude = explode(',', unserialize($business->longitude));
        }

        if (strpos($business->latitude, 's:') === 0) {
            $business->latitude = explode(',', unserialize($business->latitude));
        }

        $business->phone_number = $business->phone_number ?? $business->user['number'];
        $business->location = is_array($business->location) ? $business->location : [$business->location];
        $business->longitude = is_array($business->longitude) ? $business->longitude : [$business->longitude];
        $business->latitude = is_array($business->latitude) ? $business->latitude : [$business->latitude];
        $business->web_link = explode(',', $business->user['web_link']);
        $business->view_as = explode(',', $business->user['view_as']);
        $business->images = explode(',', $business->images);

        if ($business->business_timing->isEmpty()) {
            $businessTiming = BuisnessTiming::where('buisness_id', 0)->get();
            $business->day = explode(',', $businessTiming[0]['day']);
            $business->opening_hours = explode(',', $businessTiming[0]['opening_hours']);
            $business->closing_hours = explode(',', $businessTiming[0]['closing_hours']);
            $business->availability = explode(',', $businessTiming[0]['availability']);
        } else {
            $business->day = explode(',', $business->business_timing[0]['day']);
            $business->opening_hours = explode(',', $business->business_timing[0]['opening_hours']);
            $business->closing_hours = explode(',', $business->business_timing[0]['closing_hours']);
            $business->availability = explode(',', $business->business_timing[0]['availability']);
        }

        return view('front-cbf.manage-business', compact('business', 'categories', 'businessUser', 'checkSubscription', 'subscriptionAmount'));
    }

    public function subscription(Request $request): \Illuminate\Http\JsonResponse
    {
        $requestData = $request->all();
        $redirectUrl = route('subscription.payment.gateway', ['requestData' => $requestData]);

        return response()->json([
            'success' => true,
            'message' => 'Subscription successful.',
            'redirect_url' => $redirectUrl,
        ]);
    }

    public function subscriptionPaymentGateway(Request $request)
    {
        try {
            $requestData = $request->input('requestData');

            return view('front-cbf.paypal-web.subscription-payment-gateway', compact('requestData'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function userSubscriptionUpdate(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $id = $request->input('user_id');
            $amount = $request->input('amount');
            $couponCode = $request->input('coupon_code');
            $referralCode = $request->input('referral_code');

            $user = User::find($id);
            $user->type = 'paid_member';
            $user->subscription_expires_at = Carbon::now()->addMonth();
            $user->save();

            $this->paymentCreate($user, $amount);
            $this->saveSalesPerson($user, $referralCode, $couponCode);

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

    protected function saveSalesPerson(User $user = null, $referralCode = null, $couponCode = null)
    {
        $referralBy = User::where('referral_code', $referralCode)->first();
        if ($referralBy) {

            SalesPersonUser::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'referral_id' => $referralBy->id,
                    'referral_code' => $referralCode
                ],
                [
                    'coupon_code' => $couponCode
                ]
            );
        }
    }

    public function updateManageBusiness(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $business = Buisness::find($id);

        $data = array();
        $data['category_id'] = $request->input('category_id');
        $data['name'] = $request->input('name');
        $data['service'] = $request->input('service');
        $data['phone_number'] = $request->input('phone_number');
        $data['details'] = $request->input('details');

        $location = $request->input('location');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        $web_link = $request->input('web_link');
        $view_as = $request->input('view_as');

        if (count((array)$location) > 1) {
            for ($i = 1; $i < count((array)$location); $i++) {
                $location[$i] = '(seperate)' . $location[$i];
            }
            $location = implode(',', $location);
        } else {
            $location = $location[0];
        }

        if (strpos($location, ',(seperate)') !== false) {
            $locations = explode(',(seperate)', $location);

            $serialize_location = serialize(implode('(seperate)', $locations));
            $serialize_longitude = serialize($longitude);
            $serialize_latitude = serialize($latitude);
            $data['location'] = $serialize_location;
            $data['longitude'] = $serialize_longitude;
            $data['latitude'] = $serialize_latitude;
        } else {
            $data['location'] = $location;
            $data['longitude'] = $longitude[0];
            $data['latitude'] = $latitude[0];
        }

        if (count((array)$view_as) > 1) {
            $data['view_as'] = implode(',', $view_as);
        } else {
            $data['view_as'] = $view_as[0];
        }

        Buisness::where('id', $id)->update($data);

        $businessTiming = array();
        $businessTiming['buisness_id'] = $business->id;
        $daysArray = $request->input('days');
        $opening_hours = $request->input('opening_hours');
        $closing_hours = $request->input('closing_hours');
        $availabilityArray = $request->input('availability');

        $availabilityMap = [];
        foreach ($daysArray as $day) {
            $availabilityMap[] = isset($availabilityArray[$day]) && $availabilityArray[$day] === "1" ? 1 : 0;
        }

        $opening_hours_am = array_map(function ($hour) {
            return date("h:i A", strtotime($hour));
        }, $opening_hours);

        $closing_hours_pm = array_map(function ($hour) {
            return date("h:i A", strtotime($hour));
        }, $closing_hours);

        $businessTiming['day'] = implode(',', $daysArray);
        $businessTiming['opening_hours'] = implode(',', $opening_hours_am);
        $businessTiming['closing_hours'] = implode(',', $closing_hours_pm);
        $businessTiming['availability'] = implode(',', $availabilityMap);

        $availabilityDays = BuisnessTiming::where('buisness_id', $business->id)->update($businessTiming);

        if ($availabilityDays === 0) {
            BuisnessTiming::create([
                'id' => $business->id,
                'day' => implode(',', $daysArray),
                'opening_hours' => implode(',', $opening_hours_am),
                'closing_hours' => implode(',', $closing_hours_pm),
                'availability' => implode(',', $availabilityMap),
            ]);
        }

        $userData = array();
        if (count((array)$web_link) > 1) {
            $userData['web_link'] = implode(',', $web_link);
        } else {
            $userData['web_link'] = $web_link[0];
        }

        if (count((array)$view_as) > 1) {
            $userData['view_as'] = implode(',', $view_as);
        } else {
            $userData['view_as'] = $view_as[0];
        }

        User::where('id', (int)$business->user_id)->update($userData);

        return redirect()->back()->with('success', 'Business Updated Successfully');
    }

    public function updateManageBusinessThumbnail(Request $request, $id): \Illuminate\Http\JsonResponse
    {
        $business = Buisness::find($id);

        if ($request->file('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $newFilename = uniqid() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path() . '/uploads/business/', $newFilename);
            $business->thumbnail = $newFilename;
        }
        $business->save();

        return response()->json([
            'success' => true,
            'message' => 'Thumbnail image updated successfully',
            'response' => asset('uploads/business/' . $business->thumbnail)
        ]);
    }

    public function aboutUs()
    {
        return view('front-cbf.about-us')->with('title', 'About Us');
    }

    public function favourite()
    {
        $userId = Auth::user()->id;
        $likedBusinesses = Like::with('buisness')->where('user_id', $userId)->get();
        $processedLikedBusinesses = [];

        foreach ($likedBusinesses as $businesses) {
            $business = $businesses->buisness;
            $business->like = $businesses;

            $categoryId = $business->category_id;
            $category = Category::find($categoryId);

            if (strpos($business->location, 's:') === 0) {
                $business->location = explode('(seperate)', unserialize($business->location));
            }

            $business->location = is_array($business->location) ? $business->location : [$business->location];
            $business->location = implode(',', $business->location);

            $processedLikedBusinesses[] = [
                'business' => $business,
                'category' => $category,
            ];
        }

        return view('front-cbf.favourite', compact('processedLikedBusinesses'))->with('title', 'About Us');
    }

    public function contact()
    {
        $setting = setting::find(1);
        $logo = logo::find(1);
        return view('front-cbf.contact', compact('setting', 'logo'))->with('title', "Contact US");
    }

    public function contactusSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required|min:10|numeric',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $firstName = $request->first_name;
        $lastName = $request->last_name;
        $email = $request->email;
        $phoneNumber = $request->phone_number;
        $message = $request->message;

        inquiry::create([
            'name' => $firstName . ' ' . $lastName,
            'email' => $email,
            'phone_number' => $phoneNumber,
            'message' => $message,
        ]);

        $subject = 'Get In Touch With Us';
        $emailMessage = view('front-cbf.email-template.email-get-in-touch', compact('firstName', 'lastName', 'email', 'phoneNumber', 'message',));

        $setting = setting::find(1);
        $adminEmail = $setting->email;

        send_mail($adminEmail, $subject, $emailMessage);

        return redirect()->back()->with('success', 'Thank you! Your message has been successfully sent, we will contact you shortly.');
    }

    public function newsLetterSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subscribe_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $email = $request->subscribe_email;

        newsletter::create([
            'user_id' => Auth::user()->id,
            'email' => $email
        ]);

        $subject = 'Newsletter Subscription';
        $emailMessage = view('front-cbf.email-template.email-news-letter-subscriber', compact('email'));

        $setting = setting::find(1);
        $adminEmail = $setting->email;

        send_mail($adminEmail, $subject, $emailMessage);

        return redirect()->back()->with('success', 'Thank you! For Your Subscription Email.');
    }

    public function privacyPolicy()
    {
        return view('front-cbf.privacy-policy')->with('title', "Privacy Policy");
    }

    public function termsCondition()
    {
        return view('front-cbf.terms-condition')->with('title', "Terms & Conditions");
    }

    public function businessFinder()
    {
        return view('front-cbf.business-finder')->with('title', 'Business Finder');
    }

    public function likeUnlikeBusiness($id)
    {
        $user = Auth::user();
        $userId = $user->id;
        $existingBusinessLiked = Like::where(['user_id' => $userId, 'buisness_id' => $id])->first();

        if ($existingBusinessLiked) {
            $existingBusinessLiked->delete();

            return response([
                'success' => true,
                'msg' => 'Business Unliked Successfully',
                'unLikedBusiness' => $existingBusinessLiked
            ]);
        }

        $businessLiked = Like::create([
            'user_id' => $userId,
            'buisness_id' => $id,
        ]);

        return response([
            'success' => true,
            'msg' => 'Business Liked Successfully',
            'likedBusiness' => $businessLiked
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
                    $businessUserId = $business->user_id;
                    $businessUser = User::find($businessUserId);

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

                    $viewAs = $businessUser->view_as ?? "";
                    $webLinks = $businessUser->web_link;

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

    public function searchBusiness(Request $request): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();

        if ($user) {
            $search = $request->get('query');

            $data = Buisness::select([
                'id',
                'name',
                'service',
                'details',
                'location',
                'longitude',
                'latitude',
            ])
                ->where('name', 'LIKE', '%' . $search . '%')
                ->orWhere('service', 'LIKE', "%{$search}%")
                ->orWhere('details', 'LIKE', "%{$search}%")
                ->orWhere('location', 'LIKE', "%{$search}%")
                ->orWhere('longitude', 'LIKE', "%{$search}%")
                ->orWhere('latitude', 'LIKE', "%{$search}%")
                ->get();

            $data = $data->map(function ($item) {
                return [
                    'name' => $item['name'],
                    'url' => route('front.business', ['id' => $item['id']])
                ];
            });
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Please login first',
            ]);
        }

        return response()->json($data);
    }
}
