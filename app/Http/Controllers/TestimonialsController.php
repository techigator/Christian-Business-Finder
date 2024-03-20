<?php

namespace App\Http\Controllers;

use App\Models\testimonials;
use Illuminate\Http\Request;
// use Request;
use Illuminate\Support\Facades\DB;
use Helper;
use Auth;

class testimonialsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function Testimonials_index()
    {
        $menu = 'testimonials';
        $testimonialss = testimonials::orderBy('id', 'asc')->latest()->paginate(10);
        return view('testimonials.index', compact('testimonialss', "menu"))
            ->with('i', (request()->input('page', 1) - 1) * 10);
    }
    public function testimonials_store(Request $request)
    {
        $this->validate($request, [
            // 'type'=> 'required',
            'name' => 'required',
            'star' => 'required',
            'details' => 'required',
            // 'post_by' => 'required',
            // 'created_at' => 'required',
            'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
        ]);
        if ($request->hasFile('img')) {
            $imgnumber = rand();
            $img = $request->file('img');
            $img->move(base_path('public/uploads/testimonials'), '_' . $imgnumber . '.' . $img->getClientOriginalName());
            $imgNameToStore = 'uploads/testimonials/' . '_' . $imgnumber . '.' . $img->getClientOriginalName();
            // dd($imgNameToStore);
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->hasFile('file')) {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/testimonials'), '_' . $filenumber . '.' . $file->getClientOriginalName());
            $fileNameToStore = 'uploads/testimonials/' . '_' . $filenumber . '.' . $file->getClientOriginalName();
        } else {
            $fileNameToStore = 'no-img-avalible.png';
        }
        $testimonials = new testimonials;
        $testimonials->name = $request->input('name');
        $testimonials->details = $request->input('details');
        $testimonials->user_id = $request->input('user_id');
        $testimonials->star = $request->input('star');
        // $testimonials->post_by = $request->input('post_by');
        // $testimonials->created_at = $request->input('created_at');
        // $testimonials->file = $fileNameToStore;
        $testimonials->img = $imgNameToStore;
        $testimonials->save();
        return redirect()->route('testimonials_index')
            ->with('success', 'Testimonial created successfully.');
    }
    public function testimonials_edit($id, Request $request)
    {
        $data = DB::table('testimonials')->where('id', $id)->first();
        return response()->json($data);
    }
    public function testimonials_show($id, Request $request)
    {
        $data = DB::table('testimonials')->where('id', $id)->first();
        return response()->json($data);
    }
    public function testimonials_update(Request $request)
    {
        if (($request->img) && ($request->file)) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'details' => 'required',
                'star' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
                // 'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
            ]);
        } elseif ($request->img) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'star' => 'required',
                'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
                'img' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
            ]);
        } elseif ($request->file) {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'star' => 'required',
                'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
                'file'=> 'required|mimes:mp4,ppx,pdf,ogv,jpg,webm|max:100000',
            ]);
        } else {
            $this->validate($request, [
                // 'type'=> 'required',
                'name' => 'required',
                'star' => 'required',
                'details' => 'required',
                // 'post_by' => 'required',
                // 'created_at' => 'required',
            ]);
        }
        $data = array();
        $id = $request->input('id');
        // $data['type'] = $request->input('type');
        $data['name'] = $request->input('name');
        $data['details'] = $request->input('details');
        $data['user_id'] = $request->input('user_id');
        $data['star'] = $request->input('star');
        // $data['post_by'] = $request->input('post_by');
        // $data['created_at'] = $request->input('created_at');
        if ($request->img) {
            $imgnumber = rand();
            // dd($imgnumber);
            $img = $request->file('img');
            $img->move(base_path('public/uploads/testimonials'), '_' . $imgnumber . '.' . $img->getClientOriginalName());
            $imgNameToStore = 'uploads/testimonials/' . '_' . $imgnumber . '.' . $img->getClientOriginalName();
            $data['img'] = $imgNameToStore;
        } else {
            $imgNameToStore = 'no-img-avalible.png';
        }
        if ($request->file) {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/testimonials'), '_' . $filenumber . '.' . $file->getClientOriginalName());
            $fileNameToStore = 'uploads/testimonials/' . '_' . $filenumber . '.' . $file->getClientOriginalName();
            $data['file'] = $fileNameToStore;
        } else {
            $fileNameToStore = 'no-img-avalible.png';
        }
        $testimonials = testimonials::where('id', $id)->update($data);
        return redirect()->route('testimonials_index')
            ->with('success', 'Testimonial updated successfully');
    }
    public function testimonials_destroy(testimonials $id)
    {
        $id->delete();
        return redirect()->route('testimonials_index')
            ->with('success', 'Testimonial deleted successfully');
    }
        public function testimonials_status(Request $request)
    {
        $testimonials = testimonials::find($request->id);
        $testimonials->is_active = $request->is_active;
        $testimonials->save();
        return response()->json(['success'=>'Status change successfully.']);
    }
}
