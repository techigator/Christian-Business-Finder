<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;

use File;

class BannerController extends Controller
{

	public function index()
    {
    	$banners = Banner::all();
    	return view('admin.banner.index',compact('banners'));
    }

    public function store(Request $request)
    {
    	$banner = new Banner;

    	if ($request->hasFile('file'))
        {
            $imageName = time().rand(10000,99999).'.'.$request->file->extension();  
            $request->file->move(public_path('assets/uploads/banner'), $imageName);
            $banner->file=$imageName;
        }

        $banner->save();
		return back()->with('SUCCESS', 'Banner uploaded successfully!');
    }

    public function delete($id)
    {
        $cl = Banner::find($id);
        
        /* Remove old file */
        if(File::exists(public_path('assets/uploads/banner/'.$cl->file)))
            File::delete(public_path('assets/uploads/banner/'.$cl->file));
        /* Remove old file */

        $cl->delete();
        return back()->with('SUCCESS', 'Banner deleted successfully!');

	}

    public function update_status(Request $request, $id)
    {
        $cl = Banner::find($request->user_id);
        $cl->status = $request->status;
        $cl->save();
	}

}