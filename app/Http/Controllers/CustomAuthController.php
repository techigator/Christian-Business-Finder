<?php

namespace App\Http\Controllers;

use App\Models\Buisness;
use App\Models\category;
use App\Models\User;
use App\Models\Product;
use App\Models\Notification;
use App\Models\Product_request;
use Illuminate\Http\Request;
use App\Models\UserPageModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class CustomAuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->back()->with('error', "You're already logged In");
        }
        return view('web.signin');
    }

    public function login()
    {
        if (Auth::check()) {
            return back()->with('error', "You're already logged In");
        }
        return view('web.signin');
    }

    public function register($id = null, $businessTypeId = null, $businessType = null)
    {
        $user = User::find($id);
        $categories = category::all();

        if (Auth::check()) {
            return redirect()->route('welcome')->with('error', "You're already logged In");
        }

        return view('web.signup', compact('user', 'businessTypeId', 'businessType', 'categories'));
    }

    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('user_dashboard')->with('message', "Signed in");
        }
        return redirect()->route('welcome')->with('error', "Login details are not valid");
    }

    public function registerSubmit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phonenumber' => 'required',
            'password' => 'required|min:6',
        ]);

        $data = $request->all();
        $user = $this->create($data);
        return redirect()->route('welcome')->with('message', 'Welcome ' . $user->name . ' To Renterprise');
    }

    public function userAddBusinessBehalfBusinessType(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'state' => 'required',
            'ratings' => 'required',
            'opening_hours' => 'required',
            'details' => 'required',
            'location' => 'required',
            'longitude' => $request->has('longitude') ? 'required' : '',
            'latitude' => $request->has('latitude') ? 'required' : '',
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
        ]);

        $user = User::find($id);
        $business = new Buisness();
        if ($request->hasFile('image')) {
            $img_number = rand();
            $img = $request->file('image');
            $newFilename = $img_number . $img->getClientOriginalName();
            $img->move(public_path() . '/uploads/business/', $newFilename);
            $imgNameToStore = $newFilename;
        }

        $business->user_id = $user->id;
        $business->type = $user->type;
        $business->category_id = $request->input('category');
        $business->name = $request->input('name');
        $business->state = $request->input('state');
        $business->ratings = $request->input('ratings');
        $business->images = $imgNameToStore;
        $business->opening_hours = $request->input('opening_hours');
        $business->details = $request->input('details');
        $business->location = $request->input('location');
        $business->longitude = $request->input('longitude');
        $business->latitude = $request->input('latitude');
        $business->save();

        return redirect()->route('thankyou')
            ->with('message', 'Business created successfully.');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phonenumber' => $data['phonenumber'],
            'password' => Hash::make($data['password'])
        ]);
    }

    public function redirectToFacebook()
    {

        Session::put('link_back', url()->previous());
        return Socialite::driver('facebook')
            ->scopes(['pages_read_engagement', 'pages_manage_posts', 'pages_manage_cta'])
            ->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user_data = Socialite::driver('facebook')->user();
            // dd($user_data);
            $old_user = User::where('facebook_id', $user_data->id)->first();
            if ($old_user) {
                $old_user->facebook_id = $user_data->id;
                $old_user->user_acess_token = $user_data->token;
                $old_user->save();
            } else {
                $user_data = Socialite::driver('facebook')->user();
                $new_user = User::where('id', Auth::user()->id)->first();
                // $new_user = new User;
                $new_user->facebook_id = $user_data->id;
                $new_user->user_acess_token = $user_data->token;
                $new_user->save();
            }
            // $acc_id = auth()->user()->facebook_id;
            $acc_id = $user_data->id;
            // $useraccesstoken = auth()->user()->user_acess_token;
            $useraccesstoken = $user_data->token;
            $response = Http::get('https://graph.facebook.com/' . $acc_id . '/accounts?access_token=' . $useraccesstoken);
            $jsonData = $response->json()['data'];
            // dd($jsonData);
            $pages = UserPageModel::where('user_id', auth()->user()->id)->get();
            foreach ($jsonData as $key => $values) {
                if (count($pages) > 0) {
                    if ($pages[$key]->page_id !== $values['id']) {
                        $user_pages = new UserPageModel();
                        $user_pages->user_id = auth()->user()->id;
                        $user_pages->page_id = $values['id'];
                        $user_pages->page_name = $values['name'];
                        $user_pages->page_access_token = $values['access_token'];
                        $user_pages->save();
                    }
                } else {

                    $user_pages = new UserPageModel();
                    $user_pages->user_id = auth()->user()->id;
                    $user_pages->page_id = $values['id'];
                    $user_pages->page_name = $values['name'];
                    $user_pages->page_access_token = $values['access_token'];
                    $user_pages->save();
                }
            }


            // Auth::loginUsingId($userModel->id);
            // return redirect()->route('welcome');
            $link_back = Session::get('link_back');
            return redirect($link_back . '?modal="open"');
        } catch (Exception $e) {
            return redirect('facebook');
        }
    }

    // Create Products
    public function CreateProduct(Request $request)
    {
        if (Auth::check()) {

            $product = new Product;
            $product->user_id = auth()->user()->id;
            if ($request->hasFile('image1')) {
                $image1 = Str::random(17) . $request->file('image1')->getClientOriginalName();
                $request->image1->move(public_path('assets/uploads/product'), $image1);
                $product->image1 = $image1;
            }
            if ($request->hasFile('image2')) {
                $image2 = Str::random(17) . $request->file('image2')->getClientOriginalName();
                $request->image2->move(public_path('assets/uploads/product'), $image2);
                $product->image2 = $image2;
            }
            if ($request->hasFile('image3')) {
                $image3 = Str::random(17) . $request->file('image3')->getClientOriginalName();
                $request->image3->move(public_path('assets/uploads/product'), $image3);
                $product->image3 = $image3;
            }
            if ($request->hasFile('image4')) {
                $image4 = Str::random(17) . $request->file('image4')->getClientOriginalName();
                $request->image4->move(public_path('assets/uploads/product'), $image4);
                $product->image4 = $image4;
            }
            if ($request->hasFile('image5')) {
                $image5 = Str::random(17) . $request->file('image5')->getClientOriginalName();
                $request->image5->move(public_path('assets/uploads/product'), $image5);
                $product->image5 = $image5;
            }
            $product->name = $request->product_name;
            $product->category = $request->category;
            $product->price = $request->price;
            $product->price_type = $request->price_type;
            $product->condition = $request->condition;
            $product->tag = $request->tag;
            $product->latitude = $request->latitude;
            $product->longitude = $request->longitude;
            $product->zip_code = $request->zip_code;
            $product->renter_availability = '{"from": ' . $request->from . ',  "to": ' . $request->to . '}';
            $product->description = $request->description;
            $product->location = '{"longitudeDelta": ' . $request->lngDelta . ',  "latitudeDelta": ' . $request->latDelta . '}';
            $product->tag = $request->tag;
            $product->save();
            return redirect()->route('user_form')->with('message', 'Product created successfully.');
        }
        return redirect()->route('user_form')->with('error', 'You are not allowed to access');
    }

    public function user_dashboard()
    {
        if (Auth::check()) {
            return view('web.user-dashboard.dashboard');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function user_order()
    {
        if (Auth::check()) {
            return view('web.user-dashboard.order_user');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function incoming_request()
    {

        if (Auth::check()) {
            $reqdetail = product_request::where('status', 1)->where('product_user_id', auth::user()->id)->get();
            // dd($reqdetail);
            return view('web.user-dashboard.incomingrequest', compact('reqdetail'));
        }
        // changes withErrors('You are not allowed to access')
        return redirect("login")->with('error', 'You are not allowed to access');
    }

    public function Product_Action($id, $productaction)
    {
        $product_request = Product_request::where('id', $id)->first();
        $product_request->product_action = $productaction;
        $product_request->save();
        if ($productaction == 'Accept') {
            $product = Product::where('id', $product_request->product_id)->first();
            $product->availability = 0;
            $product->will_be_available = $product_request->end_date;
            $product->update();
        }
        if ($productaction == 'Reject') {
            $product = Product::where('id', $product_request->product_id)->first();
            // $notification = Notification::where('product_request_id',$product_request->id)->first();
            $product->availability = 1;
            $product->will_be_available = "";
            $product->update();
        }
        if ($product_request) {
            // $notification = new Notification
            $notification = Notification::where('product_request_id', $product_request->id)->first();
            $notification->product_request_id = $product_request->id;
            $notification->sender_id = $product_request->product_user_id;
            $notification->receiver_id = $product_request->user_request_id;
            $notification->notification_action = $productaction;
            $notification->update();
        }
        return redirect()->back()->with('message', $productaction . ' Product Request Successfully');
    }

    public function req_notify($id, $reqnotify)
    {
        $product_requestt = Product_request::where('id', $id)->first();
        $notification_requestt = Notification::where('product_request_id', $product_requestt->id)->first();
        $product_requestt->product_received = $reqnotify;
        // dd($reqnotify);
        $product_requestt->save();
        if ($reqnotify == 0) {
            $products = Product::where('id', $product_requestt->product_id)->first();
            $products->availability = 1;
            $products->will_be_available = "";
            $products->update();
            $notifications = Notification::where('id', $notification_requestt->id)->first();
            $notifications->notification_received = 0;
            $notifications->update();
        }
        // if($reqnotify==1){
        // $products = products::where('id',$product_requestt->product_id)->first();
        // $products->availability=0;
        // $products->will_be_available=$product_requestt->end_date;
        // $products->update();
        // $notifications = Notification::where('id',$notification_requestt->id)->first();
        // $notifications->notification_received=1;
        // $notifications->update();
        // }
        if ($reqnotify == 1) {
            $products = Product::where('id', $product_requestt->product_id)->first();
            $products->availability = 0;
            $products->will_be_available = $product_requestt->end_date;
            $products->update();
            $notifications = Notification::where('id', $notification_requestt->id)->first();
            $notifications->notification_received = 1;
            $notifications->update();
            // dd($int,$int2,$int1);
            // ADD TOKEN AMOUNT
        }
        return redirect()->back()->with('message', ' Product Recieved Successfully');
    }

    public function req_return($id, $reqreturn)
    {
        $product_requestt = Product_request::where('id', $id)->first();
        $product_requestt->product_return = $reqreturn;
        $product_requestt->save();
        if ($reqreturn == 0) {
            $products = Product::where('id', $product_requestt->product_id)->first();
            $products->availability = 0;
            $products->will_be_available = $product_requestt->end_date;
            $products->update();
        }
        if ($reqreturn == 1) {
            $products = Product::where('id', $product_requestt->product_id)->first();
            $products->availability = 1;
            $products->will_be_available = "";
            $products->update();
        }
        return redirect()->back()->with('message', ' Product Return Successfully');
    }

    public function post_request()
    {

        if (Auth::check()) {
            $reqdetail = product_request::where('status', 1)->where('user_request_id', auth::user()->id)->get();
            return view('web.user-dashboard.postrequest', compact('reqdetail'));
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function user_form()
    {
        // $product=Product::select('id','name','tag')->where('is_active',1)->get();
        $category_data = Product::groupBy('category')->pluck('category');
        $category_list = array();
        foreach ($category_data as $key => $val):
            $category_list[$key]['category'] = $val;
            $category_list[$key]['slug'] = base64_encode($val);
        endforeach;
        $tag_data = Product::groupBy('tag')->pluck('tag');
        $tag_list = array();
        foreach ($category_data as $key => $val):
            $tag_list[$key]['tag'] = $val;
            // $tag_list[$key]['slug']= base64_encode($val);
        endforeach;
        $tagprice_data = Product::groupBy('price_type')->pluck('price_type');
        $tagprice_list = array();
        foreach ($category_data as $key => $val):
            $tagprice_list[$key]['price_type'] = $val;
            // $tag_list[$key]['slug']= base64_encode($val);
        endforeach;
        $condition_data = Product::groupBy('condition')->pluck('condition');
        $condition_list = array();
        foreach ($category_data as $key => $val):
            $condition_list[$key]['condition'] = $val;
            // $tag_list[$key]['slug']= base64_encode($val);
        endforeach;
        // $category_list=array();
        // dd($category_list);
        if (Auth::check()) {
            return view('web.user-dashboard.user_form', compact('category_data', 'category_list', 'tag_data', 'tag_list', 'tagprice_data', 'tagprice_list', 'condition_data', 'condition_list'));
        }
        return view('web.user-dashboard.user_form');
    }

    public function user_account()
    {
        if (Auth::check()) {
            return view('web.user-dashboard.user_account');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function user_account_info()
    {
        if (Auth::check()) {
            return view('web.user-dashboard.user_account_info');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function user_change_password()
    {
        if (Auth::check()) {
            return view('web.user-dashboard.user_change_password');
        }
        return redirect("login")->withSuccess('You are not allowed to access');
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('admin.login')
            ->with('SUCCESS', 'Logout Successfully');
    }
}
