<?php

namespace App\Http\Controllers;

use App\Models\cms;
use Illuminate\Http\Request;
// use Request;
use Illuminate\Support\Facades\DB;
use Helper;
use Auth;

class cmsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function cms_index()
    {
        $menu = 'cms';
        $cmss = cms::orderBy('id', 'asc')->latest()->paginate(10);
        return view('cms.index', compact('cmss', "menu"))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    public function cms_store(Request $request)
    {
        $this->validate($request, [
            // 'type'=> 'required',
            'name' => 'required',
            'page' => 'required',
            'details' => 'required',
            'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
        ]);
        if ($request->hasFile('img')) {
            $imgnumber = rand();
            $img = $request->file('img');
            $img->move(base_path('public/uploads/cms'), '_' . $imgnumber . '.' . $img->getClientOriginalName());
            $imgNameToStore = 'uploads/cms/' . '_' . $imgnumber . '.' . $img->getClientOriginalName();
            // dd($imgNameToStore);
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->hasFile('file')) {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/cms'), '_' . $filenumber . '.' . $file->getClientOriginalName());
            $fileNameToStore = 'uploads/cms/' . '_' . $filenumber . '.' . $file->getClientOriginalName();
        } else {
            $fileNameToStore = 'no-img-avalible.png';
        }
        $cms = new cms;
        $cms->name = $request->input('name');
        $cms->page = $request->input('page');
        $cms->details = $request->input('details');
        $cms->user_id = $request->input('user_id');
        // $cms->file = $fileNameToStore;
        $cms->img = isset($imgNameToStore)?$imgNameToStore:'';
        $cms->save();
        return redirect()->route('cms_index')
            ->with('success', 'CMS created successfully.');
    }
    public function cms_edit($id, Request $request)
    {
        $data = DB::table('cms')->where('id', $id)->first();
        return response()->json($data);
    }
    public function cms_show($id, Request $request)
    {
        $data = DB::table('cms')->where('id', $id)->first();
        return response()->json($data);
    }
    public function cms_update(Request $request)
    {
        if (($request->img) && ($request->file)) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'page' => 'required',
                'details' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
                // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
            ]);
        } elseif ($request->img) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'page' => 'required',
                'details' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            ]);
        } elseif ($request->file) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'page' => 'required',
                'details' => 'required',
                // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
            ]);
        } else {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'page' => 'required',
                'details' => 'required',
            ]);
        }
        $data = array();
        $id = $request->input('id');
        // $data['type'] = $request->input('type');
        $data['name'] = $request->input('name');
        $data['page'] = $request->input('page');
        $data['details'] = $request->input('details');
        $data['user_id'] = $request->input('user_id');
        if ($request->img) {
            $imgnumber = rand();
            // dd($imgnumber);
            $img = $request->file('img');
            $img->move(base_path('public/uploads/cms'), '_' . $imgnumber . '.' . $img->getClientOriginalName());
            $imgNameToStore = 'uploads/cms/' . '_' . $imgnumber . '.' . $img->getClientOriginalName();
            $data['img'] = $imgNameToStore;
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->file) {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/cms'), '_' . $filenumber . '.' . $file->getClientOriginalName());
            $fileNameToStore = 'uploads/cms/' . '_' . $filenumber . '.' . $file->getClientOriginalName();
            $data['file'] = $fileNameToStore;
        } else {
            $fileNameToStore = 'no-img-avalible.png';
        }
        $cms = cms::where('id', $id)->update($data);
        return redirect()->route('cms_index')
            ->with('success', 'CMS updated successfully');
    }
    public function cms_destroy(cms $id)
    {
        $id->delete();
        return redirect()->route('cms_index')
            ->with('success', 'CMS deleted successfully');
    }
}
