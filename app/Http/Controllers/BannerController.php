<?php

namespace App\Http\Controllers;

use App\Models\banner;
use Illuminate\Http\Request;
// use Request;
use Illuminate\Support\Facades\DB;
use Helper;
use Auth;

class BannerController extends Controller
{

    public function __construct()
    {
ini_set('upload_max_filesize', '500M');
ini_set('max_execution_time', 600);
ini_set('post_max_size', '500M');
        $this->middleware('auth');
    }
    public function banner_index()
    {
        $menu = 'banner';
        $banners = banner::latest()->paginate(10);
        return view('banner.index', compact('banners', "menu"))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    public function banner_store(Request $request)
    {
        ini_set('upload_max_filesize', '500M');
ini_set('max_execution_time', 600);
ini_set('post_max_size', '500M');

        $validator=$this->validate($request, [
            // 'type'=> 'required',
            'name' => 'required',
            // 'slug' => 'required',
            'details' => 'required',
            // 'post_by' => 'required',
            // 'created_at' => 'required',
            'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
        ]);
        if ($request->hasFile('img')) {
            $imgnumber = rand();
            $img = $request->file('img');
            $img->move(base_path('public/uploads/banner'), '_' . $imgnumber . '.' . $img->getClientOriginalName());
            $imgNameToStore = 'uploads/banner/' . '_' . $imgnumber . '.' . $img->getClientOriginalName();
            // dd($imgNameToStore);
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->hasFile('file')) {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/banner'), '_' . $filenumber . '.' . $file->getClientOriginalName());
            $fileNameToStore = 'uploads/banner/' . '_' . $filenumber . '.' . $file->getClientOriginalName();
        } else {
            $fileNameToStore = 'no-img-avalible.png';
        }
        $banner = new banner;
        $banner->name = $request->input('name');
        // $banner->slug = $request->input('slug');
        $banner->details = $request->input('details');
        $banner->user_id = $request->input('user_id');
        // $banner->post_by = $request->input('post_by');
        // $banner->created_at = $request->input('created_at');
        $banner->file = $fileNameToStore;
        $banner->img = $imgNameToStore;
        $banner->save();
        return redirect()->route('banner_index')
            ->with('success', 'Banner created successfully.');
    }
    public function banner_edit($id, Request $request)
    {
        $data = DB::table('banner')->where('id', $id)->first();
        return response()->json($data);
    }
    public function banner_show($id, Request $request)
    {
        $data = DB::table('banner')->where('id', $id)->first();
        return response()->json($data);
    }
    public function banner_update(Request $request)
    {
        if (($request->img) && ($request->file)) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                // 'slug' => 'required',
                'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
                'file' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
                // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
            ]);
        } elseif ($request->img) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                // 'slug' => 'required',
                'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            ]);
        } elseif ($request->file) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                // 'slug' => 'required',
                'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
                'file' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
                // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
            ]);
        } else {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                // 'slug' => 'required',
                'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
            ]);
        }
        $data = array();
        $id = $request->input('id');
        // $data['type'] = $request->input('type');
        $data['name'] = $request->input('name');
        // $data['slug'] = $request->input('slug');
        $data['details'] = $request->input('details');
        $data['user_id'] = $request->input('user_id');
        // $data['post_by'] = $request->input('post_by');
        // $data['created_at'] = $request->input('created_at');
        if ($request->img) {
            $imgnumber = rand();
            // dd($imgnumber);
            $img = $request->file('img');
            $img->move(base_path('public/uploads/banner'), '_' . $imgnumber . '.' . $img->getClientOriginalName());
            $imgNameToStore = 'uploads/banner/' . '_' . $imgnumber . '.' . $img->getClientOriginalName();
            $data['img'] = $imgNameToStore;
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->file) {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/banner'), '_' . $filenumber . '.' . $file->getClientOriginalName());
            $fileNameToStore = 'uploads/banner/' . '_' . $filenumber . '.' . $file->getClientOriginalName();
            $data['file'] = $fileNameToStore;
        } else {
            $fileNameToStore = 'no-img-avalible.png';
        }
        $banner = banner::where('id', $id)->update($data);
        return redirect()->route('banner_index')
            ->with('success', 'Banner updated successfully');
    }
    public function banner_destroy(banner $id)
    {
        $id->delete();
        return redirect()->route('banner_index')
            ->with('success', 'Banner deleted successfully');
    }
    public function banner_status(Request $request)
    {
        $banner = banner::find($request->id);
        $banner->is_active = $request->is_active;
        $banner->save();
        return response()->json(['success'=>'Status change successfully.']);
    }
}
