<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buisness;
use Illuminate\Http\Request;
use App\Models\Banner;

use File;

class BannerController extends Controller
{

    public function index()
    {
        $banners = Banner::with('business')->get();
        $businesses = Buisness::all();

        return view('admin.banner.index', compact('banners', 'businesses'));
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $banner = new Banner();
        $businessId = $request->input('business_id');
        $banner->buisness_id = $businessId ?? null;

        if ($request->hasFile('file')) {
            $imageName = uniqid() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('/uploads/banner'), $imageName);
            $banner->file = $imageName;
        }
        $banner->save();

        return back()->with('SUCCESS', 'Banner uploaded successfully!');
    }

    public function status(Request $request, $id)
    {
        $banner = Banner::find($id);
        $banner->is_active = $request->input('status');

        $banner->save();
    }

    public function edit($id): \Illuminate\Http\JsonResponse
    {
        $banner = Banner::find($id);
        $businesses = Buisness::select('id', 'name')->get();

//        $bannerData = $banner->only([
//            'file',
//            'is_active'
//        ]);
        $bannerData['file'] = $banner->file;
        $bannerData['is_active'] = $banner->is_active;
        $bannerData['businesses'] = $businesses;

        return response()->json([
            'success' => true,
            'banner_data' => $bannerData,
        ]);
    }

    public function update(Request $request, $id): \Illuminate\Http\RedirectResponse
    {
        $banner = Banner::find($id);

        if ($request->hasFile('file')) {
            $imageName = uniqid() . '_' . $request->file->getClientOriginalName();
            $request->file->move(public_path('assets/uploads/banner'), $imageName);
            $banner->file = $imageName;
        }
        $banner->save();

        return back()->with('SUCCESS', 'Banner uploaded successfully!');
    }

    public function delete($id): \Illuminate\Http\RedirectResponse
    {
        $banner = Banner::find($id);

        /* Remove old file */
        if (File::exists(public_path('assets/uploads/banner/' . $banner->file)))
            File::delete(public_path('assets/uploads/banner/' . $banner->file));
        /* Remove old file */

        $banner->delete();
        return back()->with('SUCCESS', 'Banner deleted successfully!');

    }
}
