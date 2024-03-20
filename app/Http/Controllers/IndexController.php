<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Models\Product;
use \Crypt;
use Helper;
use Session;
use App\Models\banner;
use App\Models\cms;
use App\Models\orders;
use App\Models\setting;
use App\Models\inner_banner;
use App\Models\inquiry;
use App\Models\web_cms;
use App\Models\products;
use App\Models\Product_request;
use App\Models\Notification;
use App\Models\testimonials;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\InquiryRequest;
use App\Http\Requests\NewsletterRequest;

class IndexController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $prd_data = Product::where('is_active', 1)->get();
        $banner = banner::where('is_active', 1)->first();
        $testimonials = testimonials::where('is_active', 1)->get();
        // dd($testimonials);
        $content_1 = cms::find(1);
        $content_2 = cms::find(2);
        $content_3 = cms::find(3);
        $content_4 = cms::find(4);
        $content_5 = cms::find(5);
        $content_6 = cms::find(6);
        $content_7 = cms::find(7);
        $content_8 = cms::find(8);
        $content_9 = cms::find(9);
        return view("web.index")->with("title", "Home")
            ->with(compact(
                "banner",
                "content_1",
                "content_2",
                "content_3",
                "content_4",
                "content_5",
                "content_6",
                "content_7",
                "content_8",
                "content_9",
                'testimonials',
                'prd_data'
            ));
    }

    public function about_us()
    {
        $menu = 'about_us';
        $keywords = "";
        $description = "";
        $inner_banner = inner_banner::where('is_active', 1)->find(1);
        $content_4 = cms::where('is_active', 1)->where('id', 4)->first();
        return view('web.about_us')->with('title', 'About Us')->with(compact('menu', 'keywords', 'description', 'inner_banner', 'content_4'));
    }

    public function reviews()
    {
        $menu = 'reviews';
        $keywords = "";
        $description = "";
        $inner_banner = inner_banner::where('is_active', 1)->find(1);
        $content_4 = cms::where('is_active', 1)->where('id', 4)->first();
        return view('web.reviews')->with('title', 'reviews')->with(compact('menu', 'keywords', 'description', 'inner_banner', 'content_4'));
    }

    public function contact()
    {
        $inner_banner = inner_banner::where('is_active', 1)->find(2);
        $setting = setting::find(1);
        return view('web.contact')->with('title', "Contact US")->with(compact('inner_banner', 'setting'));
    }

    public function contactusSubmit(InquiryRequest $request)
    {
        $validator = $request->validated();
        $inquiry = new inquiry;
        $inquiry->name = $request->name;
        $inquiry->phonenumber = $request->phonenumber;
        $inquiry->email = $request->email;
        // $inquiry->subject = $request->subject;
        $inquiry->message = $request->message;
        $inquiry->save();
        $data = '<table style="width:100%;" border="1">';
        foreach ($_POST as $key => $value) {
            if ($value == 'undefined' || $value == '' || $key == "_token") {
            } else {
                $_key = ucwords(str_replace('_', ' ', $key));
                $data .= "<tr><td>$_key</td><td>$value</td></tr>";
            }
        }
        $data .= '</table>';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <no-reply@dominator.com>' . "\r\n";
        $subject = 'Inquiry Submission';
        // Company Email Address
        $setting = setting::find(1);
        $com_email = $setting['email'];
        // dd($com_email);
        // $mailSent = mail($com_email, $subject, $data, $headers);
        // $mailSent=mail('digitonics.developer.454@gmail.com',$subject,$data,$headers);
        // Mail::to($inquiry->inquiries_email)->send(new SendNewsLetter($inquiry));
        return redirect()->route('thankyou')->with('message', 'Thank you! Your message has been successfully sent, we will contact you shortly.');
        // return redirect()->route('thank_you');
        // $this->echoSuccess("Inquiry Saved");
    }

    public function shop()
    {
        if (isset($_GET['cat'])) {
            $all_prd = products::where('category', $_GET['cat'])->where('is_active', 1)->get();
            // $products = products::where('is_active', 1)->where('price','!=', 0)->where('category_id', $category->id)->get();
            // $bannerName=$category->name;

        } else {
            $all_prd = products::where('is_active', 1)->where('price', '!=', 0)->get();
            // $bannerName='Shop';
            // $bannerName='Products For Share';
        }
        $inner_banner = inner_banner::where('is_active', 1)->find(10);
        // $all_prd=products::where('is_active',1)->get();
        $product_cat = DB::table('products')->where('is_active', 1)->groupBy('category')->pluck('category');
        $cat = category::where('is_active', 1)->get();
        // dd($product_cat);
        // $cat = category::where('is_active', 1)->get();
        $setting = setting::find(1);
        return view('web.shop')->with('title', "Shop")->with(compact('inner_banner', 'setting', 'all_prd', 'product_cat', 'cat'));
    }

    public function category($slug)
    {
        //   dd($slug);
        $cat = category::where('slug', $slug)->first();
        $product = products::where('category_id', $cat->id)->get();
        // dd($cat->slug, $product,$slug);
        $inner_banner = inner_banner::where('is_active', 1)->find(10);
        $setting = setting::find(1);
        return view('web.category', compact('inner_banner', 'cat', 'product'))
            ->with('title', "Category");
    }

    public function categoryDetails($id)
    {
        $product = products::find($id);
        // dd($product);
        return view('web.category-detail', compact('product'));
    }

    public function newsletterSubmit(NewsletterRequest $request)
    {
        $validator = $request->validated();
        $inquiry = new newsletter;
        $inquiry->email = $request->email;
        $inquiry->save();
        // Mail::to($request->email)->send(new SendNewsLetter());
        $body = "<html><body>
    <div style='>
        <div style='width: 600px;  margin: 50px auto; color: #2A3342; border:7px solid #eee; '>
            <div style='background-color: #2A3342; padding: 20px 0 20px 0;'>
                <h2 style='text-align: center; color: #FC0500; margin: 0;'>Vault Seeds Bank</h2>
                <div style='width: 20%; height: 1px; background-color: #FC0500; margin: 10px auto 10px auto;'>
                </div>
            </div>
            <!-- For Newsletter -->
             <br><br>
            <div style='padding: 0 40px 0px 40px;'>
                <h3><span style='color: #FC0500;'>Newsletter Subscribtion </span></h3>
                <p> Hello<br>
                    You are Successfully registered in Joev Cosmetic</p>
            </div>
            <!-- End Newsletter -->
        <div style='padding: 30px 40px 35px 40px;'>
            <p style='color: #FC0500; margin: 0;'>
                Best Regards, <br>
                <span><strong>dominator.com</strong></span> <br>
                <a href='info@dominator.com'>info@dominator.com</a>
            </p>
        </div>
    </div></div>
</body></html>";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: <no-reply@dominator.com>' . "\r\n";
        $subject = 'Newsletters Subscription Inquiry';
        // Company Email Address
        // $com_email = Helper::returnFlag(1980);
        $com_email = $request->email;
        // dd($com_email);
        // $mailSent = mail($com_email, $subject, $body, $headers);
        // $mailSent=mail('digitonics.developer.454@gmail.com',$subject,$body,$headers);
        return redirect()->route('thankyou')->with('message', 'Thank you! Your message has been successfully sent, we will contact you shortly.');
        // return redirect()->back()->with('error','You have been Successfully Registered For NewsLetter! An email will be send shortly.');
    }

    public function privacyPolicy()
    {
        $inner_banner = inner_banner::where('is_active', 1)->find(3);
        return view('web.privacyPolicy')
            ->with('title', "Privacy Policy")
            ->with(compact('inner_banner'));
    }

    public function termsCondition()
    {
        $inner_banner = inner_banner::where('is_active', 1)->find(4);
        return view('web.termsCondition')
            ->with('title', "Terms & Conditions")
            ->with(compact('inner_banner'));
    }

    public function product()
    {
        $menu = 'product';
        // $reviews = Helper::getImageWithData('reviews','id','',"is_active=1 and is_deleted=0",0,'order by id asc'); 
        $keywords = "";
        $description = "";
        // dd($menu);
        $inner_banner = inner_banner::where('is_active', 1)->where('id', 5)->first();
        if (isset($_GET) && ($_GET != "")) {
            if (isset($_GET['search']) && ($_GET['search'] != "")) {
                if ($_GET['cat'] == 0) {
                    $products = products::where("is_active", 1)->where('name', 'LIKE', '%' . $_GET['search'] . '%')->paginate(12)->appends(request()->query());
                } else {
                    $products = products::where("is_active", 1)->where('category_id', $_GET['cat'])->where('name', 'LIKE', '%' . $_GET['search'] . '%')->paginate(12)->appends(request()->query());
                }
            } elseif (isset($_GET['cat']) && ($_GET['cat'] != "")) {
                $products = products::where("is_active", 1)->where('category_id', $_GET['cat'])->paginate(12)->appends(request()->query());
            } elseif (isset($_GET['price']) && ($_GET['price'] != "")) {
                if ($_GET['price'] == 25) {
                    $min = 0;
                    $max = 25;
                } elseif ($_GET['price'] == 50) {
                    $min = 25;
                    $max = 50;
                } elseif ($_GET['price'] == 100) {
                    $min = 50;
                    $max = 100;
                } elseif ($_GET['price'] == 200) {
                    $min = 100;
                    $max = 200;
                } elseif ($_GET['price'] == 'above-200') {
                    $min = 200;
                    $max = 10000;
                }
                $products = products::where("is_active", 1)->whereBetween('price', [$min, $max])->paginate(12)->appends(request()->query());
            } elseif (isset($_GET['star']) && ($_GET['star'] != "")) {
                $products = products::where("is_active", 1)->where('ratings_average', $_GET['star'])->paginate(12)->appends(request()->query());
            } else {
                $products = products::where("is_active", 1)->paginate(12)->appends(request()->query());
            }
        } else {
            $products = products::where("is_active", 1)->paginate(12)->appends(request()->query());
        }
        // $category = category::where('is_active', 1)->get();
        return view('web.product')->with('title', 'Products')->with(compact('menu', 'keywords', 'description', 'inner_banner', 'products'));
    }

    public function product_details($id = '')
    {
        // dd($slug);
        $menu = 'Product Details';
        $keywords = "";
        $description = "";
        $inner_banner = inner_banner::where('is_active', 1)->where('id', 6)->first();
        if ($id == "") {
            return redirect()->back()->with('error', 'No product_details Found');
        }
        $details = products::where("is_active", 1)->where('id', $id)->first();
        $related_products = products::where('category', $details->category)->where('is_active', 1)->orderBy('id', 'DESC')->get();
        // dd($related_products);
        if ($details->id != $id) {
            return redirect()->back()->with('error', 'No product details Found');
        }
        return view('web.users.product_detail')->with('title', 'Product Details')
            ->with(compact('menu', 'keywords', 'description', 'details', 'inner_banner', 'related_products'));
    }

    public function product_request($id = '')
    {
        // dd($slug);
        $menu = 'Product Details';
        $keywords = "";
        $description = "";
        $inner_banner = inner_banner::where('is_active', 1)->where('id', 6)->first();
        if ($id == "") {
            return redirect()->back()->with('error', 'No product_details Found');
        }
        $details = products::where("is_active", 1)->where('id', $id)->first();
        $related_products = products::where('category', $details->category)->where('is_active', 1)->orderBy('id', 'DESC')->get();
        // dd($related_products);
        if ($details->id != $id) {
            return redirect()->back()->with('error', 'No product details Found');
        }
        return view('web.users.request')->with('title', 'Product Details')
            ->with(compact('menu', 'keywords', 'description', 'details', 'inner_banner', 'related_products'));
    }

    public function ProductRequest(Request $request)
    {
        if (Auth::check()) {
            //     Session::put('url.intended',URL::previous());
            //     
            // 
            $product_request_check = Product_request::where('user_request_id', auth()->user()->id)->where('product_id', $request->product_id)->first();

            if ($product_request_check) {
                return redirect()->back()->with('error', 'You already Request Send for this product');
            } else {
                $product_request = new Product_request;
                $product_request->user_request_id = auth()->user()->id;
                $product_request->product_id = $request->product_id;
                $product_request->product_user_id = $request->product_user_id;
                $product_request->start_date = $request->start_date;
                $product_request->end_date = $request->end_date;
                $product_request->pickup_time = $request->pickup_time;
                $product_request->total_rent = $request->total_rent;
                $product_request->total_days = $request->total_days;
                // $product_request->latitude=$request->latitude;
                // $product_request->longitude=$request->longitude;
                $product_request->product_action = 'Pending';
                $product_request->product_received = 0;
                $product_request->qr_code = random_int(100000, 999999);
                $product_request->save();
                if ($product_request) {
                    $notification = new Notification;
                    $notification->product_request_id = $product_request->id;
                    $notification->sender_id = auth()->user()->id;
                    $notification->receiver_id = $product_request->product_user_id;
                    $notification->notification_action = 'Pending';
                    $notification->notification_received = 0;
                    $notification->save();
                }
                return redirect()->back()->with('message', 'Send Product Request Successfully');

            }
        } else {
            return redirect()->back()->with('error', "Need to login first");
        }
    }

    public function date()
    {
        return view('web.users.datetime');
    }

    public function checkout()
    {
        $inner_banner = inner_banner::where('is_active', 1)->where('id', 8)->first();
        $shipdata = unserialize($_COOKIE['shipdata']);
        if ($shipdata['shipment'] == 'none') {
            // Session::put('url.intended',URL::previous());
            // return redirect()->back()->with('error' , "Need to Calculate Shipping charges");
        }
        // if (!Auth::check()) {
        //     Session::put('url.intended',URL::previous());
        //     return redirect('login')->with('error' , "Need to login first");
        // }
        $menu = 'checkout';
        // dd(2);
        if (Session::get('cart') && count(Session::get('cart')) > 0) {
            $cart = Session::get('cart');
            // $countries = Helper::returnDataSet('country','');
            $countries = country::get();
            $shipdata = unserialize($_COOKIE['shipdata']);
            $coupondata = unserialize($_COOKIE['coupondata']);
            $user = Auth::user();
            // $checkout_details = orders::where("user_id",Auth::user()->id)->orderBy('id', 'DESC');
            $checkout_details = "";
            // dd($checkout_details);
            if (isset($checkout_details)) {
                //billing
                // $checkout_data['billing_first_name'] = $checkout_details->billing_first_name;
                // $checkout_data['billing_first_name'] = $checkout_details->billing_first_name;
                // $checkout_data['billing_last_name'] = $checkout_details->billing_last_name;
                // $checkout_data['billing_address'] = $checkout_details->billing_address;
                // $checkout_data['billing_country'] = $checkout_details->billing_country;
                // $checkout_data['billing_city'] = $checkout_details->billing_city;
                // $checkout_data['billing_state'] = $checkout_details->billing_state;
                // $checkout_data['billing_phone'] = $checkout_details->billing_phone;
                // $checkout_data['billing_email'] = $checkout_details->billing_email;
                // $checkout_data['billing_zip'] = $checkout_details->billing_zip;
                //shipping
                // $checkout_data['shipping_first_name'] = $checkout_details->shipping_first_name;
                // $checkout_data['shipping_last_name'] = $checkout_details->shipping_last_name;
                // $checkout_data['shipping_address'] = $checkout_details->shipping_address;
                // $checkout_data['shipping_country'] = $checkout_details->shipping_country;
                // $checkout_data['shipping_city'] = $checkout_details->shipping_city;
                // $checkout_data['shipping_state'] = $checkout_details->shipping_state;
                // $checkout_data['shipping_phone'] = $checkout_details->shipping_phone;
                // $checkout_data['shipping_email'] = $checkout_details->shipping_email;
                // $checkout_data['shipping_zip'] = $checkout_details->shipping_zip;
                //billing
                $checkout_data['billing_first_name'] = '';
                $checkout_data['billing_first_name'] = '';
                $checkout_data['billing_last_name'] = '';
                $checkout_data['billing_address'] = '';
                $checkout_data['billing_country'] = '';
                $checkout_data['billing_city'] = '';
                $checkout_data['billing_state'] = '';
                $checkout_data['billing_phone'] = '';
                $checkout_data['billing_email'] = '';
                $checkout_data['billing_zip'] = '';
                //shipping
                $checkout_data['shipping_first_name'] = '';
                $checkout_data['shipping_last_name'] = '';
                $checkout_data['shipping_address'] = '';
                $checkout_data['shipping_country'] = '';
                $checkout_data['shipping_city'] = '';
                $checkout_data['shipping_state'] = '';
                $checkout_data['shipping_phone'] = '';
                $checkout_data['shipping_email'] = '';
                $checkout_data['shipping_zip'] = '';
            } else {
                //billing
                // $checkout_data['billing_first_name'] = $user->name;
                // $checkout_data['billing_last_name'] = '';
                // $checkout_data['billing_address'] = $user->address;
                // $checkout_data['billing_country'] = $user->country;
                // $checkout_data['billing_city'] = $user->city;
                // $checkout_data['billing_state'] = $user->state;
                // $checkout_data['billing_phone'] = $user->phonenumber;
                // $checkout_data['billing_email'] = $user->email;
                // $checkout_data['billing_zip'] = $user->zipcode;
                $checkout_data['shipping_first_name'] = '';
                $checkout_data['shipping_last_name'] = '';
                $checkout_data['shipping_address'] = '';
                $checkout_data['shipping_country'] = '';
                $checkout_data['shipping_city'] = '';
                $checkout_data['shipping_state'] = '';
                $checkout_data['shipping_phone'] = '';
                $checkout_data['shipping_email'] = '';
                $checkout_data['shipping_zip'] = '';
                //shipping
                $checkout_data['shipping_first_name'] = '';
                $checkout_data['shipping_last_name'] = '';
                $checkout_data['shipping_address'] = '';
                $checkout_data['shipping_country'] = '';
                $checkout_data['shipping_city'] = '';
                $checkout_data['shipping_state'] = '';
                $checkout_data['shipping_phone'] = '';
                $checkout_data['shipping_email'] = '';
                $checkout_data['shipping_zip'] = '';
            }
            // dd($checkout_data);
            return view('web.checkout')->with('title', 'Checkout')->with(compact('menu', 'cart', 'inner_banner', 'countries', 'checkout_data', 'shipdata', 'coupondata', 'inner_banner'));
        } else {
            return back()->with('error', "Cannot checkout with product in a Cart.");
        }
    }

    public function payout($id = "")
    {
        $inner_banner = inner_banner::where('is_active', 1)->where('id', 9)->first();
        // $book_id = Crypt::decrypt($id);    
        // $booking = booking::where("is_active" ,1)->where("id" ,$book_id)->first();
        // if(!$booking){
        //     return redirect()->route("home")->with('error','No active booking found against this link.');
        // }
        // if($booking->amount_paid != 0){
        //      return redirect()->route("home")->with('error','Booking Amount of this link is already Paid.');
        // }
        // return view('web.payout')->with('title','Payment')
        // ->with(compact('booking','book_id','id'));
        return view('web.payout')
            ->with('title', "Payment")
            ->with(compact('inner_banner'));
    }

    public function thankyou()
    {
        $menu = 'thankyou';
        $inner_banner = inner_banner::where('is_active', 1)->where('id', 11)->first();
        Session::forget('cart');
        return view('web.thankyou')->with('title', 'Thank you')->with(compact('menu', 'inner_banner'));
    }

    public function thank_you()
    {
        $menu = 'thank_you';
        $inner_banner = inner_banner::where('is_active', 1)->where('id', 11)->first();
        Session::forget('cart');
        return view('web.thank_you')->with('title', 'Thank you')->with(compact('menu', 'inner_banner'));
    }

    public function inquiry_submit(Request $request)
    {
        // dd($request);
        $request->validate([
            'windows_and_door' => 'required',
            'email' => 'required',
            'cont' => 'required',
            'help_var' => 'required',
        ]);
        $item = new inquiryProject();
        $item->windows_and_door = $request->windows_and_door;
        $item->email = $request->email;
        $item->motion_sensors = $request->cont;
        $item->can_we_help = $request->help_var;
        $item->save();
        // dd($item);
        return json_encode(array(
            "statusCode" => 200
        ));
    }

    public function order_placed_submit(Request $request)
    {
        unset($_POST['_token']);
        $order_placed = order_placed::create($_POST);
        return redirect()->back()->with('message', 'Order placed submitted.');
    }

    public function steps()
    {
        if (Auth::user()->role_id == 1) {
            $projects = attributes::where('attribute', 'project')
                ->where('is_active', 1)
                ->get();
            return view('steps')->with(compact('projects'));
        } else {
            return redirect()
                ->back()
                ->with('error', 'No Page Found');
        }
    }

    public function web_cms_edit($id, Request $request)
    {
        $data = DB::table('web_cms')->where('id', $id)->first();
        return response()->json($data);
    }

    public function web_cms_update(Request $request)
    {
        $id = $request->input('id');
        $data = array();
        if ($id == 11 || $id == 10 || $id == 17 || $id == 18 || $id == 24 || $id == 25 || $id == 26 || $id == 27 || $id == 29 || $id == 30) {
            $data['slug'] = $request->input('slug');
        }
        if ($id == 10 || $id == 11 || $id == 12 || $id == 17 || $id == 18 || $id == 24 || $id == 29 || $id == 30) {
            $data['tag'] = $request->input('tag');
        }
        if (($request->img) && ($request->file)) {
            $this->validate($request, [
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            ]);
        }
        if ($request->img) {
            $imgnumber = rand();
            // dd($imgnumber);
            $img = $request->file('img');
            // dd($img);
            $img->move(base_path('public/uploads/web_cms'), '_' . $imgnumber . '.' . $img->getClientOriginalName());
            $imgNameToStore = 'uploads/web_cms/' . '_' . $imgnumber . '.' . $img->getClientOriginalName();
            $data['img'] = $imgNameToStore;
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        $web_cms = web_cms::where('id', $id)->update($data);
        return redirect()->back()
            ->with('success', 'Updated successfully');
    }

    public function upload_image(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $path = "";
        if ($request->hasFile('profile_image')) {
            $profile_image = Str::random(17) . $request->file('profile_image')->getClientOriginalName();
            $request->profile_image->move(public_path('assets/uploads/user'), $profile_image);
            $user->profile_image = $profile_image;
        }
        $user->save();
        return redirect()->back()->with('success', 'Image has been successfully updated');
    }

    public function upload_cover_image(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($request->hasFile('cover_image')) {
            $cover_image = Str::random(17) . $request->file('cover_image')->getClientOriginalName();
            $request->cover_image->move(public_path('assets/uploads/user'), $cover_image);
            $user->cover_image = $cover_image;
        }
        $user->save();
        return redirect()->back()->with('success', 'Image has been successfully updated');
    }

    public function consumers()
    {
        return view('web.consumers');
    }

    public function businesses()
    {
        return view('web.businesses');
    }

    public function salesProfessionals()
    {
        return view('web.sales_professionals');
    }
}
