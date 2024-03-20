<?php

namespace App\Http\Controllers;

use App\Models\products;
use App\Models\category;
use App\Models\product_draft;
use App\Models\ProductImg;
use Illuminate\Http\Request;
// use Request;
use Illuminate\Support\Facades\DB;
use Helper;
use Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function products_index()
    {
        $menu = 'products';
        $products = products::select('id', 'category_id', 'name', 'img', 'is_active','is_feature')->orderBy('id', 'asc')->latest()->paginate(10000);
        $categories = category::where('is_active', 1)->get();
        return view('products.index', compact('products', "menu", 'categories'))
            ->with('i', (request()->input('page', 1) - 1) * 100);
    }
    public function products_store(Request $request)
    {

        if ($request->hasFile('img')) {
            $this->validate($request, [
                'category_id' => 'required',
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required',
                'details' => 'required',
                
                // 'price' => 'required',
                // 'post_by' => 'required',
                // 'variations' => 'required',
                // 'created_at' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
                // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
            ]);
            $imgnumber = rand();
            $img = $request->file('img');
            $img->move(
                base_path('public/uploads/products'),
                '_' . $imgnumber . '.' . str_replace(' ', '-', $img->getClientOriginalName())
            );
            $imgNameToStore = 'uploads/products/' . '_' . $imgnumber . '.' . str_replace(
                ' ',
                '-',
                $img->getClientOriginalName()
            );
            // dd($imgNameToStore);
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->hasFile('file')) {
            $this->validate($request, [
                'file' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm|max:100000',
            ]);
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(
                base_path('public/uploads/products'),
                '_' . $filenumber . '.' . str_replace(' ', '-', $file->getClientOriginalName())
            );
            $fileNameToStore = 'uploads/products/' . '_' . $filenumber . '.'
                . str_replace(' ', '-', $file->getClientOriginalName());
        } else {
            $fileNameToStore = null;
        }
         if($validator->fails()) {
        return redirect()->route('products_index')
            ->with('error', $validator);
    // return Redirect::back()->withErrors($validator);
}
        $products = new products;
        $category_id = $request->input('category_id');
        // dd($category_id);
        $products->category_id = $category_id;

        // $products->category_id = $request->input('category_id');

        $products->name = $request->input('name');
        $products->slug = $request->input('slug');
        $products->price = $request->input('price');
        $products->details = $request->input('details');
     
        $products->user_id = $request->input('user_id');
        $products->post_by = $request->input('post_by');
        $products->price = $request->input('price');
        $products->variations = $request->input('variations');
        // $products->video_link = $request->input('video_link');
        $products->created_at = $request->input('created_at');
        $products->file = $fileNameToStore;
        $products->img = $imgNameToStore;
        $products->save();
        return redirect()->route('products_index')
            ->with('success', 'Product created successfully.');
    }


    public function products_edit($id, Request $request)
    {
        $data = DB::table('products')->where('id', $id)->first();
        return response()->json($data);
    }


    public function products_show($id, Request $request)
    {
        $data = DB::table('products')->where('id', $id)->first();
        // $category = category::where('id',$data->category_id)->first();
        // $data->category=$category->name;
        return response()->json($data);
    }


    public function drafts_show($id, Request $request)
    {

        $draft = product_draft::where('id', $id)->first();
        $product = products::where('id', $draft->product_id)->first();
        // dd($draft);
        $data['img'] = $product->img;
        $data['product_id'] = $product->id;
        $data['caption'] = $draft->caption;
        $data['id'] = $draft->id;
        $data['name'] = $product->name;
        $data['title'] = $draft->title;
        // $data = DB::table('products')->where('id', $id)->first();
        // $category = category::where('id',$data->category_id)->first();
        // $data->category=$category->name;
        return response()->json($data);
    }


    public function products_update(Request $request)
    {
        //dd($_POST);
        if (($request->img) && ($request->file)) {
            $this->validate($request, [
                'category_id' => 'required',
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required',
                'details' => 'required',
                
                // 'price' => 'required',
                // 'post_by' => 'required',
                // 'variations' => 'required',
                // 'created_at' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
                'file' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm|max:100000',
            ]);
        } elseif ($request->img) {
            $this->validate($request, [
                'category_id' => 'required',
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required',
                'details' => 'required',
                
                // 'price' => 'required',
                // 'post_by' => 'required',
                // 'variations' => 'required',
                // 'created_at' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            ]);
        } elseif ($request->file) {
            $this->validate($request, [
                'category_id' => 'required',
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required',
                'details' => 'required',
                
                // 'price' => 'required',
                // 'post_by' => 'required',
                // 'variations' => 'required',
                // 'created_at' => 'required',
                'file' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm|max:100000',
            ]);
        } else {
            $this->validate($request, [
                'category_id' => 'required',
                'name' => 'required',
                'slug' => 'required',
                'price' => 'required',
                'details' => 'required',
                
                // 'price' => 'required',
                // 'post_by' => 'required',
                // 'variations' => 'required',
                // 'created_at' => 'required',
            ]);
        }
        // dd($request->input('video_link'));
        $data = array();
        $id = $request->input('id');
        // $data['category_id'] = $request->input('category_id');

        $category_id = $request->input('category_id');

        $data['category_id'] = $category_id;


        $data['name'] = $request->input('name');
        $data['slug'] = $request->input('slug');
        $data['price'] = $request->input('price');
        $data['details'] = $request->input('details');
        $data['keywords'] = $request->input('keywords');
        // $data['video_link'] = $request->input('video_link');
        $data['user_id'] = $request->input('user_id');
        $data['price'] = $request->input('price');
        $data['post_by'] = $request->input('post_by');
        $data['variations'] = $request->input('variations');
        $data['created_at'] = $request->input('created_at');
        if ($request->img) {
            $imgnumber = rand();
            // dd($imgnumber);
            $img = $request->file('img');
            // dd($img);
            $img->move(base_path('public/uploads/products'), '_'
                . $imgnumber . '.' . str_replace(' ', '-', $img->getClientOriginalName()));
            $imgNameToStore = 'uploads/products/' . '_' . $imgnumber . '.'
                . str_replace(' ', '-', $img->getClientOriginalName());
            $data['img'] = $imgNameToStore;
        } else {

            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->file) {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/products'), '_' . $filenumber . '.' . str_replace(' ', '-', $file->getClientOriginalName()));
            $fileNameToStore = 'uploads/products/' . '_' . $filenumber . '.' . str_replace(' ', '-', $file->getClientOriginalName());
            $data['file'] = $fileNameToStore;
        } else {
            $fileNameToStore = null;
        }
        $product = products::where('id', $id)->update($data);
        return redirect()->route('products_index')
            ->with('success', 'Product updated successfully');
    }


    // public function productImgs($id)
    // {
    //     $product = products::find($id);
    //     // dd($product);
    //     return view('products.product-images', compact('product'));
    // }

    // public function images_store(Request $request, $id)
    // {
    //     $request->validate([
    //         'img1' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
    //         'img2' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
    //         'img3' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
    //     ]);

    //     $product = new ProductImg();
    //     $product->product_id = $id;
    //     if ($request->hasFile('img1')) {
    //         $file = $request->file('img1');
    //         $fileName = time() . '.' . $file->getClientOriginalExtension();
    //         $path = $file->move('uploads/products/', $fileName);
    //         $product->image1 = $fileName;
    //     }
    //     if ($request->hasFile('img2')) {
    //         $file = $request->file('img2');
    //         $fileName = time() . '.' . $file->getClientOriginalExtension();
    //         $path = $file->move('uploads/products/', $fileName);
    //         $product->image2 = $fileName;
    //     }
    //     if ($request->hasFile('img3')) {
    //         $file = $request->file('img3');
    //         $fileName = time() . '.' . $file->getClientOriginalExtension();
    //         $path = $file->move('uploads/products/', $fileName);
    //         $product->image3 = $fileName;
    //     }

    //     $product->save();
    //     return redirect()->route('products_index')
    //         ->with('success', 'Product images added successfully');
    // }


    public function products_destroy(products $id)
    {
        $id->delete();
        return redirect()->route('products_index')
            ->with('success', 'Product deleted successfully');
    }
    public function products_status(Request $request)
    {
        $products = products::find($request->id);
        $products->is_active = $request->is_active;
        $products->save();
        return response()->json(['success' => 'Status change successfully.']);
    }

    public function products_is_feature(Request $request)
    {
        $products = products::find($request->id);
        $products->is_feature = $request->is_feature;
        $products->save();
        return response()->json(['success' => 'Is feature change successfully.']);
    }
}
