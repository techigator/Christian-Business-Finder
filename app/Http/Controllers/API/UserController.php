<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Buisness;
use App\Models\category;
use App\Models\Church;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product_review;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Auth;
use Exception;
use Hash;
use Mail;
use File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;

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
        ]);

        try {
            $validator->sometimes('buisness_name', 'required', function ($input) {
                return in_array($input->type, ['business', 'paid_member']);
            });

            $validator->sometimes('buisness_categories', 'required', function ($input) {
                return in_array($input->type, ['business', 'paid_member']);
            });

            $validator->sometimes('view_as', 'required', function ($input) {
                return in_array($input->type, ['business','consumer']);
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


            // $validator->sometimes('location_1', 'required', function ($input) {
            //     return $input->type === 'paid_member';
            // });

            // $validator->sometimes('location_2', 'required', function ($input) {
            //     return $input->type === 'paid_member';
            // });

            // $validator->sometimes('web_link', 'required', function ($input) {
            //     return $input->type === 'paid_member';
            // });

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->messages()
                ]);
            }

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->home_church_name = $request->home_church_name;
            $user->home_church_address = $request->home_church_address;
            $user->denomination = $request->denomination;
            $user->password = Hash::make($request->password);
            $user->type = $request->type;
            $user->number = $request->number;
            $user->profile_image = 'user-img.png';

            if ($request->type == 'business') {
                $user->buisness_name = $request->buisness_name;
                $user->buisness_description = $request->buisness_description;
                $user->buisness_categories = $request->buisness_categories;
                $user->location_1 = $request->location_1;
                $user->location_2 = $request->location_2;
                $user->web_link = $request->web_link;
                $user->view_as = $request->view_as;
                $user->number = $request->number;
            } elseif ($request->type == 'consumer') {
                $user->country = $request->country;
                $user->city = $request->city;
                $user->state = $request->state;
                $user->view_as = $request->view_as;
            } elseif ($request->type == 'paid_member') {
                $user->buisness_name = $request->buisness_name;
                $user->number = $request->number;
                $user->buisness_description = $request->buisness_description;
                $user->buisness_categories = $request->buisness_categories;
                $user->location_1 = $request->location_1;
                $user->location_2 = $request->location_2;
                $user->web_link = $request->web_link;
            }

            $user->save();
            $user_login_token = $user->createToken('renterprise')->accessToken;
            Auth::login($user);

            return response()->json([
                'success' => true,
                'message' => 'User created successfully',
                'user' =>  $user->id,
                'token' =>  $user_login_token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    public function SocialMediaRegister(Request $request)
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
                'success'      => true,
                'data'         => $user,
                'token'        => $user_login_token,
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
                $user->profile_image =  $request->profile_image;
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
                    'success'      => true,
                    // 'data'         => auth()->user(),
                    'data'         => $user,
                    'token'        => $user_login_token,
                ]);
            }
        }
    }
    
    public function authenticate(Request $request)
    {
        $minutes = 60;
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
         if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'Errors' => $validator->messages()
            ]);
        }
        if (auth()->attempt(['email' => $request->email , 'password' => $request->password])) {
            //generate the token for the user
            $user_login_token = auth()->user()->createToken('renterprise')->accessToken;
            $user = User::select('id','name','email', 'type')->where('id', auth()->user()->id)->first();
            $user->fcm_token = $request->fcm_token;
            $user->save();
            
            // if($user->email_verified==0){
            //  return response()->json([
            //     'success'      => false,
            //     'message' => 'You are required to verify your email address.'
            // ]);
            // }else{
        
            return response()->json([
                'success' => true,
                'data' => $user,
                'token' => $user_login_token,
            ])->withCookie(cookie('token', $user_login_token, $minutes));
            // }

        } else {
            //wrong login credentials, return, user not authorised to our system, return error code 401
            return response()->json([
                'success' => false,
                'Errors' => ['invalid' => ['Invalid Credentials']]
            ]);
        }
    }
    
    public function ForgetPasswordEmail(Request $request)
    {
        $emailAddress   = $request->email;
        $checkEmailExist = User::where('email', $emailAddress)->first();
        // dd($checkEmailExist->name);
        if ($checkEmailExist) {
            //generate four digits code
            $four_digit_random_number = mt_rand(1000, 9999);
            $setCode = User::where('email', $emailAddress)->update([
                'forget_password_code'  => $four_digit_random_number
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
                    'success'   => true,
                    'message'   => 'Successfully code generated',
                    'data'      => [
                        'id'    => $checkEmailExist->id,
                        'name' => $checkEmailExist->name,
                        'email' => $checkEmailExist->email,
                        'code'  => $four_digit_random_number
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
    
    public function ValidEmail(Request $request)
    {
        $emailAddress   = $request->email;
        $checkEmailExist = User::where('email', $emailAddress)->first();
        // dd($checkEmailExist->name);
        if ($checkEmailExist) {
            //generate four digits code
            $four_digit_random_number = mt_rand(1000, 9999);
            $setCode = User::where('email', $emailAddress)->update([
                'email_verified_code'  => $four_digit_random_number
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
                    'success'   => true,
                    'message'   => 'Successfully code generated',
                    'data'      => [
                        'id'    => $checkEmailExist->id,
                        'name' => $checkEmailExist->name,
                        'email' => $checkEmailExist->email,
                        'code'  => $four_digit_random_number
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
    
    public function CheckValidEmailCodeVerification(Request $request)
    {
        $code = $request->code;
        $id   = $request->id;
        $checkEmailCode = User::where('id', $id)->where('email_verified_code', $code)->first();
        if ($checkEmailCode == null)
            return response([
                'success' => false,
                'message' => 'Invalid Code'
            ]);
        else
            $setCode = User::where('id', $id)->update([
                'email_verified'  => 1
            ]);
        return response([
            'success'   => true,
            'message'   => 'Code matched successfully'
        ]);
    }
    
    public function checkForgetPasswordCodeVerification(Request $request)
    {
        $code = $request->code;
        $id   = $request->id;
        $checkEmailCode = User::where('id', $id)->where('forget_password_code', $code)->first();
        if ($checkEmailCode == null)
            return response([
                'success' => false,
                'message' => 'Invalid Code'
            ]);
        else
            return response([
                'success'   => true,
                'message'   => 'Code matched successfully'
            ]);
    }
    
    public function updateForgetPassword(Request $request)
    {
        $id             = $request->id;
        $password       = $request->password;
        $passwordHash = Hash::make($password);
        $updatePassword = User::find($id)->update(['password' => $passwordHash]);
        if ($updatePassword) {
            return response([
                'success'   => true,
                'message'   => 'Password updated successfully'
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
                'success'   => true,
                'message'   => 'Password updated successfully'
            ]);
        }
    }
    
    public function updateProfileInfo(Request $request)
    {
        try {
            $user = User::find(auth()->user()->id);
            $name = $request->input('name');
            $number = $request->input('number');
            $date_of_birth = $request->input('date_of_birth');
            $gender = $request->input('gender');
            $home_church_address = $request->input('home_church_address');
            $denomination = $request->input('denomination');
            $business_name = $request->input('buisness_name');
            $business_description = $request->input('business_description');
            $business_categories = $request->input('buisness_categories');
            $view_as = $request->input('view_as');
            $country = $request->input('country');
            $city = $request->input('city');
            $state = $request->input('state');
            $want_to_see = $request->input('want_to_see');
            $location_1 = $request->input('location_1');
            $location_2 = $request->input('location_2');
            $web_link = $request->input('web_link');

            if (is_null($user)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User record not found',
                ], 404);
            }

            $profileUpdate = array_filter([
                'name' => $name,
                'number' => $number,
                'date_of_birth' => $date_of_birth,
                'gender' => $gender,
                'home_church_address' => $home_church_address,
                'denomination' => $denomination,
            ]);


            if ($user->type == 'buisness') {
                $profileUpdate = array_filter([
                    'buisness_name' => $business_name,
                    'buisness_description' => $business_description,
                    'buisness_categories' => $business_categories,
                    'view_as' => $view_as,
                ]);
            } elseif ($user->type == 'consumer') {
                $profileUpdate = array_filter([
                    'country' => $country,
                    'city' => $city,
                    'state' => $state,
                    'want_to_see' => $want_to_see,
                ]);
            } elseif ($user->type == 'paid_member') {
                $profileUpdate = array_filter([
                    'buisness_name' => $business_name,
                    'buisness_description' => $business_description,
                    'buisness_categories' => $business_categories,
                    'location_1' => $location_1,
                    'location_2' => $location_2,
                    'web_link' => $web_link,
                ]);
            }

            User::where('id', $user->id)->update($profileUpdate);
            return response()->json([
                'success' => true,
                'message' => 'User Profile Updated successfully',
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'message' => $e->getMessage(),
            ]);
        }
    }
    
    public function updateProfileImage(Request $request)
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
        return response()->json([
            'success'   => true,
            'file_path'=> asset('assets/uploads/user'),
            'message'   => 'User Profile Image Uploaded successfully',
            'data'      => $user
        ]);
    }
    
    public function UserTypeChange($user_type)
    {
        $user = User::find(auth()->user()->id);
        $user->type = $user_type;
        $user->save();
        // User created, return success response
        return response()->json([
            'success'   => true,
            'message'   => $user_type  . 'Type Updated successfully',
            'data'      => $user
        ]);
    }
    
   public function GetUser(Request $request, $user_id)
    {
        $token = $request->cookie('token');
        $bearer_token = $request->bearerToken();
        // dd($token,$bearer_token);

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
        }

        $user = User::find($user_id);
        
        if ($user) {
            foreach ($user->getAttributes() as $key => $value) {
                if (is_null($value)) {
                    $user->{$key} = "";
                }
            }
        }
        
        /*$user_list['user_id'] = $user->id;
        $user_list['user_name'] = $user->name;
        $user_list['user_email'] = $user->email;
        $user_list['user_profile_image'] = $user->profile_image;
        $user_list['date_of_birth'] = $user->date_of_birth;
        $user_list['gender'] = $user->gender;
        $user_list['number'] = $user->number;

        if ($user->type == 'buisness') {
            $user_list['buisness_name'] = $user->buisness_name;
            $user_list['buisness_description'] = $user->buisness_description;
            $user_list['buisness_categories'] = $user->buisness_categories;
            $user_list['home_church_address'] = $user->home_church_address;
            $user_list['denomination'] = $user->denomination;
            $user_list['view_as'] = $user->view_as;
        } elseif ($user->type == 'consumer') {
            $user_list['country'] = $user->country;
            $user_list['city'] = $user->city;
            $user_list['state'] = $user->state;
            $user_list['want_to_see'] = $user->want_to_see;
            $user_list['home_church_address'] = $user->home_church_address;
            $user_list['denomination'] = $user->denomination;
        } elseif ($user->type == 'paid_member') {
            $user_list['buisness_name'] = $user->buisness_name;
            $user_list['buisness_description'] = $user->buisness_description;
            $user_list['buisness_categories'] = $user->buisness_categories;
            $user_list['home_church_address'] = $user->home_church_address;
            $user_list['denomination'] = $user->denomination;
            $user_list['location_1'] = $user->location_1;
            $user_list['location_2'] = $user->location_2;
            $user_list['web_link'] = $user->web_link;
        }*/

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
    
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'success'   => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function getCategory(Request $request)
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
    
    public function getChurch()
    {
        $churches = Church::all();

        return response()->json([
            'Status' => 200,
            'Response' => $churches
        ]);
    }
    

    public function addBuisness(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'ratings' => 'required',
            'images' => 'required',
            'images.*' => 'mimes:jpeg,jpg,png,gif,csv,txt,pdf',
            'opening_hours' => 'required',
            'details' => 'required',
            'location' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'status' => 400,
                'error' => $validator->messages()
            ]);
        }

        $buisness = new Buisness();
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $name = $file->getClientOriginalName();
                $file->move(public_path() . '/uploads/', $name);
                $imgData[] = $name;
            }
            // dd($imgData);
            $buisness->images = implode("," , $imgData);
        }

        $buisness->name = $request->name;
        $buisness->ratings = $request->ratings;
        $buisness->opening_hours = $request->opening_hours;
        $buisness->details = $request->details;
        $buisness->location = $request->location;
        $buisness->longitude = $request->longitude;
        $buisness->latitude = $request->latitude;
        $buisness->category_id = $request->category_id;
        $buisness->save();
        return response([
            'status' => 200,
            'response' => $buisness,
        ]);
    }
    
    public function getBuisnessById(Request $request, $id)
    {
        try {
            $user = Auth::user();
            if (is_null($user)) {
                return response([
                    'success' => false,
                    'message' => 'User not found!',
                ], 404);
            }

            $user_id = $user->id;
            $business = Buisness::with('rating')->find($id);
            if (is_null($business)) {
                return response([
                    'success' => false,
                    'message' => 'Business not found!',
                ], 404);
            }
            
            $business->details = strip_tags($business->details);
            $business->images = explode(',', $business->images);

            $ratings = $business->rating;
            $login_user_flag = $ratings->first(function ($rating) use ($user_id) {
                return $rating->user_id == $user_id;
            });

            if (!is_null($login_user_flag) && $login_user_flag !== false) {
                $flag = $login_user_flag->flag;
            } else {
                $flag = 0;
            }
            $average = $business->averageRating();

            return response([
                'success' => true,
                'status' => 200,
                'message' => 'Get Business By Id',
                'user_rating_flag' => $flag,
                'rating_average' => (string) $average,
                'business' => $business,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getBusiness(Request $request, $id)
    {
       $category = Category::where('id', $id)->first();

    if (!$category) {
        return response([
            'status' => 400,
            'response' => 'Category not found',
        ]);
    }

        $business = Buisness::where('category_id', $id)->get();
        if (count($business) == 0) {
        return response([
            'status' => 400,
            'response' => 'Business not found',
        ]);
    }
         return response([
            'status' => 200,
            'response' => $business,
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

        $suggestions = Suggestion::with('buisness')->get();
        return response([
            'status' => 200,
            'response' => $suggestions,
        ]);
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
    public function getLikes()
    {
        $likes = Like::with('buisness')->where('user_id', Auth::user()->id)->get();
        return response([
            'status' => 200,
            'response' => $likes
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
            $businesses = Buisness::select( "*",
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
    
    public function getBuisnessByCategory($id)
    {
        $buisnessByCategory = Buisness::where('category_id', $id)->get();
        if ($buisnessByCategory->isEmpty()) {
            return response()->json([
                'status' => 401,
                'message' =>  'invalid category id or category not found'
            ]);
        }
        return response()->json([
            'status' => 200,
            'Total Business' => count($buisnessByCategory),
            'message' =>  $buisnessByCategory
        ]);
    }
}
