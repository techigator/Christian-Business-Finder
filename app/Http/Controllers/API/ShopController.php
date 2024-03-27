<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Buisness;
use App\Models\Rating;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;
use App\Models\Product;
use App\Models\Product_request;
use App\Models\Product_review;
use App\Models\Product_item_review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use DB;
use Stripe\Stripe;
use Stripe\TaxRate;

class ShopController extends Controller
{
// Product
    public function CreateProduct(Request $request)
    {
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
        $product->location = $request->location;
        $product->latitude = $request->latitude;
        $product->longitude = $request->longitude;
        $product->zip_code = $request->zip_code;
        $product->renter_availability = $request->renter_availability;
        $product->description = $request->description;
        $product->tag = $request->tag;
        $product->save();
        return response()->json([
            'success' => true,
            'file_path' => asset('assets/uploads/product'),
            'data' => $product
        ]);
    }

    public function UpdateProduct(Request $request)
    {
        $product = Product::where('id', $request->id)->first();
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
        $product->location = $request->location;
        $product->latitude = $request->latitude;
        $product->longitude = $request->longitude;
        $product->zip_code = $request->zip_code;
        $product->renter_availability = $request->renter_availability;
        $product->description = $request->description;
        $product->tag = $request->tag;
        $product->user_id = auth()->user()->id;
        $product->save();
        return response()->json([
            'success' => true,
            'file_path' => asset('assets/uploads/product'),
            'data' => $product
        ]);
    }

    public function ProductStatusChange(Request $request)
    {
        $product = Product::find($request->id);
        $product->is_active = $request->status;
        $product->save();
        return response()->json([
            'success' => true,
            'message' => 'Status successfully Change',
            'data' => $product
        ]);
    }

    public function MyProduct($user_id)
    {
        $product = Product::where('user_id', $user_id)->where('is_deleted', 0)->get();
        $product_list = array();
        foreach ($product as $key => $val):
            $product_list[$key]['id'] = $val->id;
            $product_list[$key]['user_id'] = $val->user_id;
            $product_list[$key]['name'] = $val->name;
            $product_list[$key]['price_type'] = $val->price_type;
            $product_list[$key]['latitude'] = $val->latitude;
            $product_list[$key]['longitude'] = $val->longitude;
            $product_list[$key]['price'] = $val->price;
            $product_list[$key]['image1'] = $val->image1;
            $product_list[$key]['category'] = $val->category;
            $product_list[$key]['zip_code'] = $val->zip_code;
            $product_list[$key]['renter_availability'] = $val->renter_availability;
            $product_list[$key]['availability'] = $val->availability;
            $product_list[$key]['will_be_available'] = $val->will_be_available;
            $product_list[$key]['is_active'] = $val->is_active;
            $product_item_review = Product_item_review::where("product_id", $val->id)->get();
            if (sizeof($product_item_review)) {
                $avg = 0;
                foreach ($product_item_review as $rev) {
                    $avg += $rev->star;
                }
                $totalproductreview = ceil($avg / count($product_item_review));
            } else {
                $totalproductreview = 0;
            }
            $product_list[$key]['product_reviews_average'] = $totalproductreview;
        endforeach;
        return response()->json([
            'success' => true,
            'file_path' => asset('assets/uploads/product'),
            'data' => $product_list
        ]);
    }

    public function LatestProducts()
    {
        $product = Product::where('is_active', 1)->orderBy('id', 'DESC')->limit(9)->get();
        $product_list = array();
        foreach ($product as $key => $val):
            $user = User::find($val->user_id);
            $renter_availability = explode(",", $val->renter_availability);
            if (date("Y-m-d H:i:s") >= $renter_availability[0] && date("Y-m-d H:i:s") <= $renter_availability[1]) {
                $product_list[$key]['id'] = $val->id;
                $product_list[$key]['user_id'] = $val->user_id;
                $product_list[$key]['fcm_token'] = $user->fcm_token;
                $product_list[$key]['name'] = $val->name;
                $product_list[$key]['price_type'] = $val->price_type;
                $product_list[$key]['price'] = $val->price;
                $product_list[$key]['latitude'] = $val->latitude;
                $product_list[$key]['longitude'] = $val->longitude;
                $product_list[$key]['image1'] = $val->image1;
                $product_list[$key]['category'] = $val->category;
                $product_list[$key]['zip_code'] = $val->zip_code;
                $product_list[$key]['renter_availability'] = $val->renter_availability;
                $product_list[$key]['availability'] = $val->availability;
                $product_list[$key]['will_be_available'] = $val->will_be_available;
                $product_list[$key]['is_active'] = $val->is_active;
                $product_item_review = Product_item_review::where("product_id", $val->id)->get();
                if (sizeof($product_item_review)) {
                    $avg = 0;
                    foreach ($product_item_review as $rev) {
                        $avg += $rev->star;
                    }
                    $totalproductreview = ceil($avg / count($product_item_review));
                } else {
                    $totalproductreview = 0;
                }
                $product_list[$key]['product_reviews_average'] = $totalproductreview;
            }
        endforeach;
        return response()->json([
            'success' => true,
            'file_path' => asset('assets/uploads/product'),
            'data' => $product_list
        ]);
    }

    public function Categories()
    {
        $category_data = Product::groupBy('category')->pluck('category');
        $category_list = array();
        foreach ($category_data as $key => $val):
            $category_list[$key]['category'] = $val;
            $category_list[$key]['slug'] = base64_encode($val);
        endforeach;
        return response()->json([
            'success' => true,
            'data' => $category_list
        ]);
    }

    public function CategoryProducts($slug)
    {
        $category = base64_decode($slug);
        $product = Product::where('is_active', 1)->where('category', $category)->get();
        $product_list = array();
        foreach ($product as $key => $val):
            $user = User::find($val->user_id);
            $renter_availability = explode(",", $val->renter_availability);
            if (date("Y-m-d H:i:s") >= $renter_availability[0] && date("Y-m-d H:i:s") <= $renter_availability[1]) {
                $product_list[$key]['id'] = $val->id;
                $product_list[$key]['user_id'] = $val->user_id;
                $product_list[$key]['fcm_token'] = $user->fcm_token;
                $product_list[$key]['name'] = $val->name;
                $product_list[$key]['price_type'] = $val->price_type;
                $product_list[$key]['price'] = $val->price;
                $product_list[$key]['latitude'] = $val->latitude;
                $product_list[$key]['longitude'] = $val->longitude;
                $product_list[$key]['image1'] = $val->image1;
                $product_list[$key]['category'] = $val->category;
                $product_list[$key]['zip_code'] = $val->zip_code;
                $product_list[$key]['renter_availability'] = $val->renter_availability;
                $product_list[$key]['availability'] = $val->availability;
                $product_list[$key]['will_be_available'] = $val->will_be_available;
                $product_list[$key]['is_active'] = $val->is_active;
            } else {
                $product_list[$key]['id'] = 0;
            }
        endforeach;
        return response()->json([
            'success' => true,
            'file_path' => asset('assets/uploads/product'),
            'data' => $product_list
        ]);
    }

    public function SearchProducts(Request $request)
    {
        // $product = Product::where('is_active',1)->where('name', 'LIKE', '%' . $request->product_name . '%')->Where('zip_code', $request->zip_code)->get();
        $latitude = $request->latitude;
        $longitude = $request->longitude;
        $radius = 100; // in kilometers
        $product = DB::table('products')->select('id', 'user_id', 'name', 'price_type', 'price', 'image1', 'category', 'zip_code', 'is_active', 'latitude', 'longitude', 'is_active', 'availability', 'renter_availability', 'will_be_available',
            DB::raw("( 6371 * acos( cos( radians('$latitude') )
 * cos( radians( latitude ) )
 * cos( radians( longitude ) - radians('$longitude') )
 + sin( radians('$latitude') )
 * sin( radians( latitude ) ) ) )AS distance"))
            ->where('name', 'LIKE', '%' . $request->product_name . '%')
            ->where('is_active', 1)
            ->having('distance', '<', $radius)
            ->orderBy('distance')
            ->get();
        $product_list = array();
        foreach ($product as $key => $val):
            $user = User::find($val->user_id);
            $renter_availability = explode(",", $val->renter_availability);
            if (date("Y-m-d H:i:s") >= $renter_availability[0] && date("Y-m-d H:i:s") <= $renter_availability[1]) {
                $product_list[$key]['id'] = $val->id;
                $product_list[$key]['user_id'] = $val->user_id;
                $product_list[$key]['fcm_token'] = $user->fcm_token;
                $product_list[$key]['name'] = $val->name;
                $product_list[$key]['price_type'] = $val->price_type;
                $product_list[$key]['price'] = $val->price;
                $product_list[$key]['image1'] = $val->image1;
                $product_list[$key]['latitude'] = $val->latitude;
                $product_list[$key]['longitude'] = $val->longitude;
                $product_list[$key]['category'] = $val->category;
                $product_list[$key]['zip_code'] = $val->zip_code;
                $product_list[$key]['renter_availability'] = $val->renter_availability;
                $product_list[$key]['availability'] = $val->availability;
                $product_list[$key]['will_be_available'] = $val->will_be_available;
                $product_list[$key]['is_active'] = $val->is_active;
                $product_item_review = Product_item_review::where("product_id", $val->id)->get();
                if (sizeof($product_item_review)) {
                    $avg = 0;
                    foreach ($product_item_review as $rev) {
                        $avg += $rev->star;
                    }
                    $totalproductreview = ceil($avg / count($product_item_review));
                } else {
                    $totalproductreview = 0;
                }
                $product_list[$key]['product_reviews_average'] = $totalproductreview;
            }
        endforeach;
        return response()->json([
            'success' => true,
            'file_path' => asset('assets/uploads/product'),
            'data' => $product_list
        ]);
    }

    public function TagSearchProducts(Request $request)
    {
        $product = Product::where('is_active', 1)->where('tag', 'LIKE', '%' . $request->tag . '%')->get();
        $product_list = array();
        foreach ($product as $key => $val):
            $renter_availability = explode(",", $val->renter_availability);
            if (date("Y-m-d H:i:s") >= $renter_availability[0] && date("Y-m-d H:i:s") <= $renter_availability[1]) {
                $product_list[$key]['id'] = $val->id;
                $product_list[$key]['user_id'] = $val->user_id;
                $product_list[$key]['name'] = $val->name;
                $product_list[$key]['price_type'] = $val->price_type;
                $product_list[$key]['price'] = $val->price;
                $product_list[$key]['image1'] = $val->image1;
                $product_list[$key]['latitude'] = $val->latitude;
                $product_list[$key]['longitude'] = $val->longitude;
                $product_list[$key]['category'] = $val->category;
                $product_list[$key]['zip_code'] = $val->zip_code;
                $product_list[$key]['renter_availability'] = $val->renter_availability;
                $product_list[$key]['availability'] = $val->availability;
                $product_list[$key]['will_be_available'] = $val->will_be_available;
                $product_list[$key]['is_active'] = $val->is_active;
                $product_item_review = Product_item_review::where("product_id", $val->id)->get();
                if (sizeof($product_item_review)) {
                    $avg = 0;
                    foreach ($product_item_review as $rev) {
                        $avg += $rev->star;
                    }
                    $totalproductreview = ceil($avg / count($product_item_review));
                } else {
                    $totalproductreview = 0;
                }
                $product_list[$key]['product_reviews_average'] = $totalproductreview;
            }
        endforeach;
        return response()->json([
            'success' => true,
            'file_path' => asset('assets/uploads/product'),
            'data' => $product_list
        ]);
    }

    public function Product_Details($product_id)
    {
        $val = Product::where('is_active', 1)->where('id', $product_id)->first();
        $product_list = array();
        if ($val) {
            // User
            $user = User::find($val->user_id);
            // Reviews
            $reviews = Product_review::where("renterpriser_id", $val->user_id)->get();
            if (sizeof($reviews)) {
                $avg = 0;
                foreach ($reviews as $rev) {
                    $avg += $rev->star;
                }
                $totalreviews = ceil($avg / count($reviews));
            } else {
                $totalreviews = 0;
            }
            $product_list['User_Info'] = '%%%%%%%%%%%%%%%%%%';
            $product_list['user_name'] = $user->name;
            $product_list['fcm_token'] = $user->fcm_token;
            $product_list['user_email'] = $user->email;
            $product_list['user_profile_image'] = $user->profile_image;
            $product_list['reviews_average'] = $totalreviews;
            $product_list['Product_Info'] = '%%%%%%%%%%%%%%%%%%';
            $product_list['id'] = $val->id;
            $product_list['user_id'] = $val->user_id;
            $product_list['category'] = $val->category;
            $product_list['name'] = $val->name;
            $product_list['price_type'] = $val->price_type;
            $product_list['price'] = $val->price;
            $product_list['condition'] = $val->condition;
            $product_list['location'] = $val->location;
            $product_list['latitude'] = $val->latitude;
            $product_list['longitude'] = $val->longitude;
            $product_list['zip_code'] = $val->zip_code;
            $product_list['renter_availability'] = $val->renter_availability;
            $product_list['availability'] = $val->availability;
            $product_list['will_be_available'] = $val->will_be_available;
            $product_list['description'] = $val->description;
            $product_list['tag'] = $val->tag;
            $product_list['image1'] = $val->image1;
            $product_list['image2'] = $val->image2;
            $product_list['image3'] = $val->image3;
            $product_list['image4'] = $val->image4;
            $product_list['image5'] = $val->image5;
            $product_item_review = Product_item_review::where("product_id", $val->id)->get();
            if (sizeof($product_item_review)) {
                $avg = 0;
                foreach ($product_item_review as $rev) {
                    $avg += $rev->star;
                }
                $totalproductreview = ceil($avg / count($product_item_review));
            } else {
                $totalproductreview = 0;
            }
            $product_list['product_reviews_average'] = $totalproductreview;
            return response()->json([
                'success' => true,
                'file_path' => asset('assets/uploads/product'),
                'data' => $product_list
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product Not Found or Inactive',
                'data' => $product_list
            ]);
        }
    }

// Reviews
    public function CreateReview(Request $request)
    {
        $product_reviews = Product_review::where('user_id', auth()->user()->id)->where('renterpriser_id', $request->renterpriser_id)->first();
        if (!$product_reviews) {
            $product_reviews = new Product_review;
            $product_reviews->user_id = auth()->user()->id;
            $product_reviews->renterpriser_id = $request->renterpriser_id;
            $product_reviews->star = $request->star;
            $product_reviews->message = $request->message;
            $product_reviews->save();
            return response()->json([
                'success' => true,
                'data' => $product_reviews
            ]);
        } else {
            $product_reviews->user_id = auth()->user()->id;
            $product_reviews->renterpriser_id = $request->renterpriser_id;
            $product_reviews->star = $request->star;
            $product_reviews->message = $request->message;
            $product_reviews->save();
            return response()->json([
                'success' => true,
                'message' => 'Your Review has been updated.',
                'data' => $product_reviews
            ]);
        }
    }

    public function GetAllReview($user_id)
    {
        $product_reviews = Product_review::where('status', 1)->where('renterpriser_id', $user_id)->get();
        $product_reviews_list = array();
        if (!$product_reviews->isEmpty()) {
            foreach ($product_reviews as $key => $val):
                $user = User::find($val->user_id);
                $comments_list[$key]['id'] = $val->id;
                $comments_list[$key]['user_name'] = $user->name;
                $comments_list[$key]['user_profile_image'] = $user->profile_image;
                $comments_list[$key]['star'] = $val->star;
                $comments_list[$key]['message'] = $val->message;
                $comments_list[$key]['created_at'] = $val->created_at;
            endforeach;
            return response()->json([
                'success' => true,
                'data' => $comments_list
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Review on this Product',
                'data' => $product_reviews_list
            ]);
        }
    }

    public function CreateProductReview(Request $request)
    {
        $product_item_reviews = Product_item_review::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->first();
        if (!$product_item_reviews) {
            $product_item_reviews = new Product_item_review;
            $product_item_reviews->user_id = auth()->user()->id;
            $product_item_reviews->product_id = $request->product_id;
            $product_item_reviews->star = $request->star;
            $product_item_reviews->message = $request->message;
            $product_item_reviews->save();
            return response()->json([
                'success' => true,
                'data' => $product_item_reviews
            ]);
        } else {
            $product_item_reviews->user_id = auth()->user()->id;
            $product_item_reviews->product_id = $request->product_id;
            $product_item_reviews->star = $request->star;
            $product_item_reviews->message = $request->message;
            $product_item_reviews->save();
            return response()->json([
                'success' => true,
                'message' => 'Your Review has been updated.',
                'data' => $product_item_reviews
            ]);
        }

    }

    public function GetAllProductReview($product_id)
    {
        $product_item_reviews = Product_item_review::where('status', 1)->where('product_id', $product_id)->get();
        $product_item_reviews_list = array();
        if (!$product_item_reviews->isEmpty()) {
            foreach ($product_item_reviews as $key => $val):
                $user = User::find($val->user_id);
                $comments_list[$key]['id'] = $val->id;
                $comments_list[$key]['user_name'] = $user->name;
                $comments_list[$key]['user_profile_image'] = $user->profile_image;
                $comments_list[$key]['star'] = $val->star;
                $comments_list[$key]['message'] = $val->message;
                $comments_list[$key]['created_at'] = $val->created_at;
            endforeach;
            return response()->json([
                'success' => true,
                'data' => $comments_list
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No Review on this Product',
                'data' => $product_item_reviews_list
            ]);
        }
    }

// Product Request
    public function ProductRequest(Request $request)
    {
        $product_request = new Product_request;
        $product_request->user_request_id = auth()->user()->id;
        $product_request->product_id = $request->product_id;
        $product_request->product_user_id = $request->product_user_id;
        $product_request->start_date = $request->start_date;
        $product_request->end_date = $request->end_date;
        $product_request->pickup_time = $request->pickup_time;
        $product_request->total_rent = $request->total_rent;
        $product_request->latitude = $request->latitude;
        $product_request->longitude = $request->longitude;
        $product_request->product_action = 'Pending';
        $product_request->qr_code = random_int(100000, 999999);
        $product_request->save();
        if ($product_request) {
            $notification = new Notification;
            $notification->product_request_id = $product_request->id;
            $notification->sender_id = auth()->user()->id;
            $notification->receiver_id = $product_request->product_user_id;
            $notification->notification_action = 'Pending';
            $notification->save();
        }
        return response([
            'success' => true,
            'message' => 'Send Product Request Successfully',
            'data' => $product_request
        ]);
    }

    public function ProductDelete($id)
    {
        $product = Product::where('id', $id)->first();
        $product->is_deleted = 1;
        $product->is_active = 0;
        $product->save();
        return response([
            'success' => true,
            'message' => 'Product Delete Successfully',
            'data' => $product
        ]);
    }

    public function ProductRequestDelete($id)
    {
        $product_request = Product_request::where('id', $id)->first();
        $product_request->is_deleted = 1;
        $product_request->status = 0;
        $product_request->save();
        return response([
            'success' => true,
            'message' => 'Product Request Delete Successfully',
            'data' => $product_request
        ]);
    }

    public function ProductRequestReceived(Request $request)
    {
        $product_request = Product_request::find($request->id);
        $product_request->product_received = $request->product_received;
        $product_request->save();
        return response()->json([
            'success' => true,
            'message' => 'Product Received successfully',
            'data' => $product_request
        ]);
    }

    public function ProductRequestPickupTimeChange(Request $request)
    {
        $product_request = Product_request::find($request->id);
        $product_request->pickup_time = $request->pickup_time;
        $product_request->save();
        return response()->json([
            'success' => true,
            'message' => 'Pickup Time successfully change',
            'data' => $product_request
        ]);
    }

    public function ProductRequestReturn(Request $request)
    {
        $product_request = Product_request::find($request->id);
        $product_request->product_return = $request->product_return;
        $product_request->save();
        if ($request->product_return == 1) {
            $product = Product::where('id', $product_request->product_id)->first();
            $product->availability = 1;
            $product->will_be_available = '';
            $product->update();
        }
        return response()->json([
            'success' => true,
            'message' => 'Product Return Successfully',
            'data' => $product_request
        ]);
    }

    public function ProductAction($id, $productaction)
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
        if ($product_request) {
            $notification = new Notification;
            $notification->product_request_id = $product_request->id;
            $notification->sender_id = $product_request->product_user_id;
            $notification->receiver_id = $product_request->user_request_id;
            $notification->notification_action = $productaction;
            $notification->save();
        }
        return response([
            'success' => true,
            'message' => $productaction . ' Product Request Successfully',
            'data' => $product_request
        ]);
    }

    public function MyProductRequest()
    {
        if (auth()->user()->type == 'user') {
            $product_user = Product_request::where('is_deleted', 0)->where('user_request_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        } else {
            $product_user = Product_request::where('is_deleted', 0)->where('product_user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        }
        $product_user_list = array();
        foreach ($product_user as $key => $val):
// user info
            if (auth()->user()->type == 'user') {
                $user = User::where('id', $val->product_user_id)->first();
            } else {
                $user = User::where('id', $val->user_request_id)->first();
            }
            $reviews = Product_review::where("renterpriser_id", $user->id)->get();
            if (sizeof($reviews)) {
                $avg = 0;
                foreach ($reviews as $rev) {
                    $avg += $rev->star;
                }
                $totalreviews = ceil($avg / count($reviews));
            } else {
                $totalreviews = 0;
            }
            $product = Product::where('id', $val->product_id)->first();
            $product_user_list[$key]['UserInfo'] = '%%%%%%%%%%%%%%%%%%';
            $product_user_list[$key]['otheruser_id'] = $user->id;
            $product_user_list[$key]['fcm_token'] = $user->fcm_token;
            $product_user_list[$key]['otheruser_name'] = $user->name;
            $product_user_list[$key]['otheruser_profile_image'] = $user->profile_image;
            $product_user_list[$key]['reviews_average'] = $totalreviews;
            $product_user_list[$key]['reviews_count'] = $reviews->count();
            $product_user_list[$key]['RequestInfo'] = '%%%%%%%%%%%%%%%%%%';
            $product_user_list[$key]['start_date'] = $val->start_date;
            $product_user_list[$key]['end_date'] = $val->end_date;
            $product_user_list[$key]['pickup_time'] = $val->pickup_time;
            $product_user_list[$key]['total_rent'] = $val->total_rent;
            $product_user_list[$key]['latitude'] = $val->latitude;
            $product_user_list[$key]['longitude'] = $val->longitude;
            $product_user_list[$key]['product_action'] = $val->product_action;
            $product_user_list[$key]['product_received'] = $val->product_received;
            $product_user_list[$key]['product_return'] = $val->product_return;
            $product_user_list[$key]['qr_code'] = $val->qr_code;
            $product_user_list[$key]['created_at'] = $val->created_at;
            $product_user_list[$key]['product_request_id'] = $val->id;
            $product_user_list[$key]['ProductInfo'] = '%%%%%%%%%%%%%%%%%%';
            $product_user_list[$key]['product_id'] = $product->id;
            $product_user_list[$key]['product_name'] = $product->name;
            $product_user_list[$key]['product_price_type'] = $product->price_type;
            $product_user_list[$key]['product_price'] = $product->price;
            $product_user_list[$key]['product_latitude'] = $product->latitude;
            $product_user_list[$key]['product_longitude'] = $product->longitude;
            $product_user_list[$key]['product_image1'] = $product->image1;
            $product_user_list[$key]['product_category'] = $product->category;
            $product_user_list[$key]['product_zip_code'] = $product->zip_code;
            $product_user_list[$key]['renter_availability'] = $product->renter_availability;
            $product_user_list[$key]['availability'] = $product->availability;
            $product_user_list[$key]['will_be_available'] = $product->will_be_available;
        endforeach;
        return response()->json([
            'success' => true,
            'path' => asset('assets/uploads/user/'),
            'data' => $product_user_list
        ]);
    }

    public function MyOrderProductRequest()
    {
        if (auth()->user()->type == 'user') {
            $product_user = Product_request::where('product_received', 1)->where('user_request_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        } else {
            $product_user = Product_request::where('product_received', 1)->where('product_user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        }
        $product_user_list = array();
        foreach ($product_user as $key => $val):
// user info
            if (auth()->user()->type == 'user') {
                $user = User::where('id', $val->product_user_id)->first();
            } else {
                $user = User::where('id', $val->user_request_id)->first();
            }
            $reviews = Product_review::where("renterpriser_id", $user->id)->get();
            if (sizeof($reviews)) {
                $avg = 0;
                foreach ($reviews as $rev) {
                    $avg += $rev->star;
                }
                $totalreviews = ceil($avg / count($reviews));
            } else {
                $totalreviews = 0;
            }
            $product = Product::where('id', $val->product_id)->first();
            $product_user_list[$key]['UserInfo'] = '%%%%%%%%%%%%%%%%%%';
            $product_user_list[$key]['otheruser_id'] = $user->id;
            $product_user_list[$key]['fcm_token'] = $user->fcm_token;
            $product_user_list[$key]['otheruser_name'] = $user->name;
            $product_user_list[$key]['otheruser_profile_image'] = $user->profile_image;
            $product_user_list[$key]['reviews_average'] = $totalreviews;
            $product_user_list[$key]['reviews_count'] = $reviews->count();
            $product_user_list[$key]['RequestInfo'] = '%%%%%%%%%%%%%%%%%%';
            $product_user_list[$key]['start_date'] = $val->start_date;
            $product_user_list[$key]['end_date'] = $val->end_date;
            $product_user_list[$key]['pickup_time'] = $val->pickup_time;
            $product_user_list[$key]['total_rent'] = $val->total_rent;
            $product_user_list[$key]['latitude'] = $val->latitude;
            $product_user_list[$key]['longitude'] = $val->longitude;
            $product_user_list[$key]['product_action'] = $val->product_action;
            $product_user_list[$key]['product_received'] = $val->product_received;
            $product_user_list[$key]['product_return'] = $val->product_return;
            $product_user_list[$key]['qr_code'] = $val->qr_code;
            $product_user_list[$key]['created_at'] = $val->created_at;
            $product_user_list[$key]['product_request_id'] = $val->id;
            $product_user_list[$key]['ProductInfo'] = '%%%%%%%%%%%%%%%%%%';
            $product_user_list[$key]['product_id'] = $product->id;
            $product_user_list[$key]['product_name'] = $product->name;
            $product_user_list[$key]['product_price_type'] = $product->price_type;
            $product_user_list[$key]['product_price'] = $product->price;
            $product_user_list[$key]['product_latitude'] = $product->latitude;
            $product_user_list[$key]['product_longitude'] = $product->longitude;
            $product_user_list[$key]['product_image1'] = $product->image1;
            $product_user_list[$key]['product_category'] = $product->category;
            $product_user_list[$key]['product_zip_code'] = $product->zip_code;
            $product_user_list[$key]['renter_availability'] = $product->renter_availability;
            $product_user_list[$key]['availability'] = $product->availability;
            $product_user_list[$key]['will_be_available'] = $product->will_be_available;
        endforeach;
        return response()->json([
            'success' => true,
            'path' => asset('assets/uploads/user/'),
            'data' => $product_user_list
        ]);
    }

    public function MyProductRequestNotifications()
    {
        $notification_user = Notification::where('receiver_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        // dd($notification_user);
        $product_user_list = array();
        foreach ($notification_user as $key => $val):
// user info
            $product_request = Product_request::where('id', $val->product_request_id)->where('product_user_id', auth()->user()->id)->first();
            if ($product_request) {
                $user = User::where('id', $product_request->user_request_id)->first();
            } else {
                $product_request = Product_request::where('id', $val->product_request_id)->where('user_request_id', auth()->user()->id)->first();
                // dd($product_request);
                $user = User::where('id', $product_request->product_user_id)->first();
            }
            $product = Product::where('id', $product_request->product_id)->first();
            // if($product->user_id!=auth()->user()->id){
            $product_user_list[$key]['UserInfo']['otheruser_id'] = $user->id;
            $product_user_list[$key]['UserInfo']['fcm_token'] = $user->fcm_token;
            $product_user_list[$key]['UserInfo']['otheruser_name'] = $user->name;
            $product_user_list[$key]['UserInfo']['otheruser_profile_image'] = $user->profile_image;
            $product_user_list[$key]['UserInfo']['RequestInfo'] = '%%%%%%%%%%%%%%%%%%';
            // $product_user_list[$key]['start_date']=$product_request->start_date;
            // $product_user_list[$key]['end_date']=$product_request->end_date;
            // $product_user_list[$key]['total_rent']=$product_request->total_rent;
            // $product_user_list[$key]['latitude']=$product_request->latitude;
            // $product_user_list[$key]['longitude']=$product_request->longitude;
            $product_user_list[$key]['ProductRequest']['product_action'] = $product_request->product_action;
            $product_user_list[$key]['ProductRequest']['created_at'] = $product_request->created_at;
            $product_user_list[$key]['ProductRequest']['product_request_id'] = $product_request->id;
            $product_user_list[$key]['ProductInfo']['product_id'] = $product->id;
            $product_user_list[$key]['ProductInfo']['product_name'] = $product->name;
            // $product_user_list[$key]['product_price_type']=$product->price_type;
            // $product_user_list[$key]['product_price']=$product->price;
            // $product_user_list[$key]['product_latitude']=$product->latitude;
            // $product_user_list[$key]['product_longitude']=$product->longitude;
            // $product_user_list[$key]['product_image1']=$product->image1;
            // $product_user_list[$key]['product_category']=$product->category;
            // $product_user_list[$key]['product_zip_code']=$product->zip_code;
            $product_user_list[$key]['NotificationInfo']['notification_id'] = $val->id;
            $product_user_list[$key]['NotificationInfo']['notification_read'] = $val->notification_read;
            $product_user_list[$key]['NotificationInfo']['notification_action'] = $val->notification_action;
            // }else{
            // }
        endforeach;
        return response()->json([
            'success' => true,
            'path' => asset('assets/uploads/user/'),
            'data' => $product_user_list
        ]);
    }

    public function NotificationAction($id, $notificationaction)
    {
        $notification = Notification::where('id', $id)->first();
        $notification->notification_read = $notificationaction;
        $notification->save();
        return response([
            'success' => true,
            'message' => $notificationaction . ' notification Successfully',
            'data' => $notification
        ]);
    }

    public function NotificationDelete($id)
    {
        $notification = Notification::where('id', $id)->first();
        $notification->delete();
        if ($notification) {
            return response([
                'success' => true,
                'message' => 'Product Request Delete Successfully',
                'data' => $notification
            ]);
        } else {
            return response([
                'success' => true,
                'message' => 'Notification Delete Successfully',
                'data' => $notification
            ]);
        }
    }

    public function StripIntentResponds(Request $request)
    {
        $stripe = new \Stripe\StripeClient('sk_test_51N85bUIwoLJhjM2E5U1zOZ1GjvpZiLpjh16pQxQS5xUdT859TU0xi1Rj2l5wOeQM0Vg8QrCA0BBEKEHZRiTNtTAn00CsNy3cur');
        $response = $stripe->paymentIntents->create([
            'payment_method_types' => ['card'],
            'amount' => $request->amount,
            'currency' => $request->currency,
        ]);
        if ($response) {
            return response([
                'success' => true,
                'data' => $response
            ]);
        }
    }

    public function addImages(Request $request)
    {
        try {
            $id = $request->input('business_id');
            $business = Buisness::find($id);

            $validator = Validator::make($request->all(), [
                'images' => 'required',
                'images.*' => 'image|mimes:jpeg,jpg,png|dimensions:max_width=800,max_height=600',
                // 'images.*' => 'image|mimes:jpeg,jpg,png',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Image upload validation failed',
                ], 400);
            }

            if (!is_null($business)) {
                $currentImages = $business->images;
                if ($request->file('images')) {
                    $newFilename = $request->images->getClientOriginalName();
                    $request->images->move(public_path() . '/uploads/business/', $newFilename);
                }

                if (!empty($currentImages)) {
                    $currentImages .= ',';
                }

                $currentImages .= $newFilename;

                $business->images = $currentImages;
                $business->save();

                $images = explode(',', $business->images);
                return response()->json([
                    'success' => true,
                    // 'message' => 'Image added to the column successfully',
                    'data' => $images
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'No image file provided',
                ], 400);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    public function rateBusiness(Request $request)
    {
        try {
            $user_id = Auth::id();
            $flag = $request->input('flag');
            $business_id = $request->input('business_id');
            $business = Buisness::with('rating')->where('id', $business_id)->first();
            $ratings = $business->rating;

            if (is_null($business_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Business Not Found!',
                ], 404); // 404 Not Found
            }

            if (is_null($user_id)) {
                return response()->json([
                    'success' => false,
                    'message' => 'User Not Found!'
                ], 401); // 401 Unauthorized
            }

            $foundRating = $ratings->where('user_id', $user_id)->first();

            if ($foundRating) {
                if ($flag == 1) {
                    $foundRating->ratings++;
                    $foundRating->flag = 1;
                } elseif ($flag == 0) {
                    $foundRating->ratings--;
                    $foundRating->flag = 0;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid flag value',
                    ], 400); // 400 Bad Request
                }
                $foundRating->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Rating Updated Successfully',
                    'data' => $foundRating,
                ]);
            } else {
                $ratingData = [
                    'user_id' => $user_id,
                    'buisness_id' => $business_id,
                    'flag' => 1,
                ];

                if ($flag == 1) {
                    $ratingData['ratings'] = 1;
                } elseif ($flag == 0) {
                    $ratingData['ratings'] = -1;
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid flag value',
                    ], 400); // 400 Bad Request
                }

                $newRating = Rating::create($ratingData);
                $newRating->save();

                return response()->json([
                    'success' => true,
                    'message' => 'New Rating Recorded Successfully',
                    'data' => $newRating
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500); // 500 Internal Server Error
        }
    }
}
