<?php

namespace App\Http\Controllers;

use App\Models\category;
use Illuminate\Http\Request;
// use Request;
use Illuminate\Support\Facades\DB;
use Helper;
use Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function category_index()
    {
        $menu = 'category';
        $category = category::orderBy('id', 'asc')->latest()->paginate(100);
        return view('category.index', compact('category', "menu"))
            ->with('i', (request()->input('page', 1) - 1) * 100);
    }
    public function category_store(Request $request)
    {
        $this->validate($request, [
            // 'type'=> 'required',
            'name' => 'required',
            'slug' => 'required',
            // 'details' => 'required',
            // 'post_by' => 'required',
            // 'created_at' => 'required',
            'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
        ]);
        if ($request->hasFile('img')) {
            $imgnumber = rand();
            $img = $request->file('img');
            $img->move(base_path('public/uploads/category'), '_' . $imgnumber . '.' . $img->getClientOriginalName());
            $imgNameToStore = 'uploads/category/' . '_' . $imgnumber . '.' . $img->getClientOriginalName();
            // dd($imgNameToStore);
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->hasFile('file')) {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/category'), '_' . $filenumber . '.' . $file->getClientOriginalName());
            $fileNameToStore = 'uploads/category/' . '_' . $filenumber . '.' . $file->getClientOriginalName();
        } else {
            $fileNameToStore = 'no-img-avalible.png';
        }
        $category = new category;
        $category->name = $request->input('name');
        $category->slug = $request->input('slug');
        // $category->details = $request->input('details');
        // $category->user_id = $request->input('user_id');
        // $category->post_by = $request->input('post_by');
        // $category->created_at = $request->input('created_at');
        // $category->file = $fileNameToStore;
        $category->img = $imgNameToStore;
        $category->save();
        return redirect()->route('category_index')
            ->with('success', 'Category created successfully.');
    }
    public function category_edit($id, Request $request)
    {
        $data = DB::table('category')->where('id', $id)->first();
        return response()->json($data);
    }
    public function category_show($id, Request $request)
    {
        $data = DB::table('category')->where('id', $id)->first();
        return response()->json($data);
    }
    public function category_update(Request $request)
    {
        if (($request->img) && ($request->file)) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'slug' => 'required',
                // 'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
                // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
            ]);
        } elseif ($request->img) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'slug' => 'required',
                // 'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            ]);
        } elseif ($request->file) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'slug' => 'required',
                // 'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
                // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
            ]);
        } else {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'slug' => 'required',
                // 'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
            ]);
        }
        $data = array();
        $id = $request->input('id');
        // $data['type'] = $request->input('type');
        $data['name'] = $request->input('name');
        $data['slug'] = $request->input('slug');
        // $data['details'] = $request->input('details');
        // $data['user_id'] = $request->input('user_id');
        // $data['post_by'] = $request->input('post_by');
        // $data['created_at'] = $request->input('created_at');
        if ($request->img) {
            $imgnumber = rand();
            // dd($imgnumber);
            $img = $request->file('img');
            $img->move(base_path('public/uploads/category'), '_' . $imgnumber . '.' . $img->getClientOriginalName());
            $imgNameToStore = 'uploads/category/' . '_' . $imgnumber . '.' . $img->getClientOriginalName();
            $data['img'] = $imgNameToStore;
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->file) {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/category'), '_' . $filenumber . '.' . $file->getClientOriginalName());
            $fileNameToStore = 'uploads/category/' . '_' . $filenumber . '.' . $file->getClientOriginalName();
            $data['file'] = $fileNameToStore;
        } else {
            $fileNameToStore = 'no-img-avalible.png';
        }
        $category = category::where('id', $id)->update($data);
        return redirect()->route('category_index')
            ->with('success', 'Category updated successfully');
    }
    public function category_destroy(category $id)
    {
        $id->delete();
        return redirect()->route('category_index')
            ->with('success', 'Category deleted successfully');
    }
    public function category_status(Request $request)
    {
        $category = category::find($request->id);
        $category->is_active = $request->is_active;
        $category->save();
        return response()->json(['success'=>'Status change successfully.']);
    }
}
