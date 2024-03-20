<?php

namespace App\Http\Controllers;

use App\Models\inner_banner;
use Illuminate\Http\Request;
// use Request;
use Illuminate\Support\Facades\DB;
use Helper;
use Auth;

class Inner_bannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function inner_banner_index()
    {
        $menu = 'inner_banner';
        $inner_banners = inner_banner::orderBy('id', 'asc')->latest()->paginate(100);
        return view('inner_banner.index', compact('inner_banners', "menu"))
            ->with('i', (request()->input('page', 1) - 1) * 100);
    }
    public function inner_banner_store(Request $request)
    {
        $this->validate($request, [
            // 'type'=> 'required',
            'name' => 'required',
            'page' => 'required',
            // 'details' => 'required',
            // 'post_by' => 'required',
            // 'created_at' => 'required',
            'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
        ]);
        if ($request->hasFile('img')) {
            $imgnumber = rand();
            $img = $request->file('img');
            $img->move(base_path('public/uploads/inner_banner'), '_' . $imgnumber . '.' . $img->getClientOriginalName());
            $imgNameToStore = 'uploads/inner_banner/' . '_' . $imgnumber . '.' . $img->getClientOriginalName();
            // dd($imgNameToStore);
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->hasFile('file')) {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/inner_banner'), '_' . $filenumber . '.' . $file->getClientOriginalName());
            $fileNameToStore = 'uploads/inner_banner/' . '_' . $filenumber . '.' . $file->getClientOriginalName();
        } else {
            $fileNameToStore = 'no-img-avalible.png';
        }
        $inner_banner = new inner_banner;
        $inner_banner->name = $request->input('name');
        $inner_banner->page = $request->input('page');
        // $inner_banner->details = $request->input('details');
        // $inner_banner->user_id = $request->input('user_id');
        // $inner_banner->post_by = $request->input('post_by');
        // $inner_banner->created_at = $request->input('created_at');
        // $inner_banner->file = $fileNameToStore;
        $inner_banner->img = $imgNameToStore;
        $inner_banner->save();
        return redirect()->route('inner_banner_index')
            ->with('success', 'Inner banner created successfully.');
    }
    public function inner_banner_edit($id, Request $request)
    {
        $data = DB::table('inner_banner')->where('id', $id)->first();
        return response()->json($data);
    }
    public function inner_banner_show($id, Request $request)
    {
        $data = DB::table('inner_banner')->where('id', $id)->first();
        return response()->json($data);
    }
    public function inner_banner_update(Request $request)
    {
        if (($request->img) && ($request->file)) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'page' => 'required',
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
                'page' => 'required',
                // 'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            ]);
        } elseif ($request->file) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'page' => 'required',
                // 'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
                // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
            ]);
        } else {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'page' => 'required',
                // 'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
            ]);
        }
        $data = array();
        $id = $request->input('id');
        // $data['type'] = $request->input('type');
        $data['name'] = $request->input('name');
        $data['page'] = $request->input('page');
        // $data['details'] = $request->input('details');
        $data['user_id'] = $request->input('user_id');
        // $data['post_by'] = $request->input('post_by');
        // $data['created_at'] = $request->input('created_at');
        if ($request->img) {
            $imgnumber = rand();
            // dd($imgnumber);
            $img = $request->file('img');
            $img->move(base_path('public/uploads/inner_banner'), '_' . $imgnumber . '.' . $img->getClientOriginalName());
            $imgNameToStore = 'uploads/inner_banner/' . '_' . $imgnumber . '.' . $img->getClientOriginalName();
            $data['img'] = $imgNameToStore;
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->file) {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/inner_banner'), '_' . $filenumber . '.' . $file->getClientOriginalName());
            $fileNameToStore = 'uploads/inner_banner/' . '_' . $filenumber . '.' . $file->getClientOriginalName();
            $data['file'] = $fileNameToStore;
        } else {
            $fileNameToStore = 'no-img-avalible.png';
        }
        $inner_banner = inner_banner::where('id', $id)->update($data);
        return redirect()->route('inner_banner_index')
            ->with('success', 'Inner banner updated successfully');
    }
    public function inner_banner_destroy(inner_banner $id)
    {
        $id->delete();
        return redirect()->route('inner_banner_index')
            ->with('success', 'Inner banner deleted successfully');
    }
    public function inner_banner_status(Request $request)
    {
        $inner_banner = inner_banner::find($request->id);
        $inner_banner->is_active = $request->is_active;
        $inner_banner->save();
        return response()->json(['success'=>'Status change successfully.']);
    }
}
