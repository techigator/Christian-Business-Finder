<?php

namespace App\Http\Controllers;

use App\Models\Buisness;
use App\Models\category;
use App\Models\User;
use App\Exports\BusinessExport;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// use App\Traits\PHPCustomMail;

class BusinessController extends Controller
{
    // use PHPCustomMail;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function businessIndex()
    {
        $menu = 'business';
        $loggedInUser = Auth::user();
//        dd($loggedInUser);
        $loggedInUserId = $loggedInUser->id;
        $categories = category::all();

        if ($loggedInUser->type === 'sales_person') {
             $users = User::where(['type' => 'user', 'created_by' => $loggedInUser->id])->get();
            $userIds = User::where(['type' => 'user', 'created_by' => $loggedInUser->id])
                ->pluck('id')
                ->toArray();
            $businesses = Buisness::with('category')
                ->where(function($query) use ($userIds, $loggedInUserId) {
                    $query->whereIn('user_id', array_merge($userIds, [$loggedInUserId]))
                        ->where(function ($query) {
                            $query->where('type', 'user')
                                ->orWhere('type', 'sales_person');
                        });
                })
                ->orderBy('created_at', 'desc')
                ->latest()
                ->paginate(10);
        } else {
            $businesses = Buisness::with('category')->orderBy('created_at', 'desc')->latest()->paginate(20);
            $users = User::where('type', 'user')->get();
        }

        return view('business.index', compact('businesses', "menu", 'categories', 'users'))
            ->with('i', (request()->input('page', 1) - 1) * 100);
    }

    public function businessStore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'state' => 'required',
            'ratings' => 'required',
            'opening_hours' => 'required',
            'details' => 'required',
            'location' => 'required',
            'longitude' => $request->has('longitude') ? 'required' : '',
            'latitude' => $request->has('latitude') ? 'required' : '',
            'image' => $request->has('longitude') ? 'required|mimes:jpeg,png,jpg,gif,svg|max:50000' : '',
        ]);
        $business = new Buisness();

        if ($request->hasFile('image')) {
            // $img_number = rand();
            $img = $request->file('image');
            $newFilename = $img->getClientOriginalName();
            $img->move(public_path() . '/uploads/business/', $newFilename);
            $imgNameToStore = $newFilename;
            // $imgNameToStore = $img->getClientOriginalName();
            // $img->move(base_path('public/uploads/business'), '_' . $img_number . '.' . $img->getClientOriginalName());
            // $imgNameToStore = '/uploads/business/' . '_' . $img_number . '.' . $img->getClientOriginalName();
        }

        $customized_users = $request->input('customized_users');
        $serialized_users = serialize($customized_users);
        $business->customized_users = $serialized_users;

        $business->user_id = $request->input('user_id');
        $business->type = $request->input('user_type');
        $business->category_id = $request->input('category');
        $business->name = $request->input('name');
        $business->state = $request->input('state');
        $business->ratings = $request->input('ratings');
        $business->thumbnail = $imgNameToStore;
        $business->images = $imgNameToStore;
        $business->opening_hours = $request->input('opening_hours');
        $business->details = $request->input('details');
        $business->location = $request->input('location');
        $business->longitude = $request->input('longitude');
        $business->latitude = $request->input('latitude');
        $business->save();

        if (Auth::user()->type === 'admin') {
            return redirect()->route('business.index')
                ->with('success', 'Business created successfully.');
        } else {
            return redirect()->route('business.sales.index')
                ->with('success', 'Business created successfully.');
        }
    }

    public function businessShow($id, Request $request)
    {
        $data = DB::table('category')->where('id', $id)->first();
        return response()->json($data);
    }

    public function businessEdit($id)
    {
        $business = Buisness::find($id);
        $users = null;

        if ($business->customized_users) {
            $unserializedUsers = unserialize($business->customized_users);
            $customized_users = User::whereIn('id', $unserializedUsers)->get();
            $unserializedUsersId = $customized_users->pluck('id');
        } else {
            $users = User::where('type', 'user')->get();
        }

        $data =  [
            'id' => $business->id,
            'user_id' => $business->user_id,
            'type' => $business->type,
            'customized_users' => $unserializedUsersId ?? $users,
            'category_id' => $business->category_id,
            'name' => $business->name,
            'state' => $business->state,
            'ratings' => $business->ratings,
            'images' => $business->images,
            'opening_hours' => $business->opening_hours,
            'details' => $business->details,
            'location' => $business->location,
            'longitude' => $business->longitude,
            'latitude' => $business->latitude,
        ];

        return response()->json($data);
    }

    public function businessUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'state' => 'required',
            'ratings' => 'required',
            'opening_hours' => 'required',
            'details' => 'required',
            'location' => 'required',
            'image' => $request->has('image') ? 'required|mimes:jpeg,png,jpg,gif,svg|max:50000' : '',
            'longitude' => $request->has('longitude') ? 'required' : '',
            'latitude' => $request->has('latitude') ? 'required' : '',
        ]);

        $data = array();
        $id = $request->input('id');
        $customized_users = $request->input('customized_users');
        $serialized_users = serialize($customized_users);
        $data['customized_users'] = $serialized_users;
        $data['name'] = $request->input('name');
        $data['state'] = $request->input('state');
        $data['ratings'] = $request->input('ratings');
        $data['opening_hours'] = $request->input('opening_hours');
        $data['details'] = $request->input('details');
        $data['location'] = $request->input('location');
        $data['longitude'] = $request->input('longitude');
        $data['latitude'] = $request->input('latitude');

        if ($request->hasFile('image')) {
            $img_number = rand();
            $img = $request->file('image');
            $newFilename = $img->getClientOriginalName();
            $img->move(public_path() . '/uploads/business/', $newFilename);
            $imgNameToStore = $newFilename;
            // $img->move(base_path('public/uploads/business'), '_' . $img_number . '.' . $img->getClientOriginalName());
            // $imgNameToStore = $img->getClientOriginalName();
            // $imgNameToStore = 'uploads/business/' . '_' . $img_number . '.' . $img->getClientOriginalName();
            $data['images'] = $imgNameToStore;
        }

        $business = Buisness::where('id', $id)->update($data);

        if (Auth::user()->type === 'admin') {
            return redirect()->route('business.index')
                ->with('success', 'Business updated successfully.');
        } else {
            return redirect()->route('business.sales.index')
                ->with('success', 'Business updated successfully.');
        }
    }

    public function businessDestroy($id)
    {
        $business = Buisness::find($id);
        $business->delete();
        return redirect()->route('business.index')
            ->with('success', 'Business deleted successfully');
    }

    public function businessStatus(Request $request)
    {
        $business = Buisness::find($request->id);
        $business->is_active = $request->is_active;
        $business->save();
        return response()->json(['success' => 'Status change successfully.']);
    }

    function send_mail($to, $subject, $string): bool
    {
        $from = 'no-reply@christian-business-finder.com';

        // To send HTML mail, the Content-type header must be set
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

        // Create email headers
        $headers .= 'From: ' . $from . "\r\n" .
            'Reply-To: ' . $from . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        $html = $string;

        // Sending email
        Mail::send([], [], function ($message) use ($to, $subject, $html) {
            $message->to($to)
                ->subject($subject)
                ->setBody($html, 'text/html');
        });

        if (Mail::failures()) {
            return false;
        }

        return true;
    }

    public function customizedMembersSendMail($id)
    {
        $business = Buisness::find($id);

        if (is_null($business->customized_users)) {
            return redirect()->back()->with('error', 'Members Not Found In This Business');
        }

        $unserializedUsers = unserialize($business->customized_users);
        $customized_users = User::whereIn('id', $unserializedUsers)->get();
        // dd($customized_users);

        $userSubject = 'Received Sign-up Link';

        foreach ($customized_users as $user) {
            $userId = $user->id;
            $userName = $user->name;
            $userEmail = $user->email;
            $businessTypeId = $business->user_id;
            $businessType = $business->user_type;

            $userMessage = view('admin.email-business-invitation', compact('userId', 'userName', 'business', 'businessTypeId', 'businessType'));
            $this->send_mail($userEmail, $userSubject, $userMessage);
        }

        return redirect()->back()->with('success', 'Email send to members');
    }

    public function exportBusinesses()
    {
        $loggedInUser = Auth::user();
        $loggedInUserId = $loggedInUser->id;

        if ($loggedInUser->type === 'sales_person') {
            $userIds = User::where(['type' => 'user', 'created_by' => $loggedInUser->id])
                ->pluck('id')
                ->toArray();
            $businesses = Buisness::with('category')
                ->where(function($query) use ($userIds, $loggedInUserId) {
                    $query->whereIn('user_id', array_merge($userIds, [$loggedInUserId]))
                        ->where(function ($query) {
                            $query->where('type', 'user')
                                ->orWhere('type', 'sales_person');
                        });
                })
                ->orderBy('created_at', 'desc')
                ->latest()
                ->paginate(10);

            $business_report = $businesses->map(function ($business, $index) {
                return [
                    $index + 1,
                    $business->category->name,
                    $business->name,
                    $business->state,
                    $business->ratings,
                    $business->opening_hours,
                    strip_tags($business->details),
                    $business->location,
                    $business->longitude,
                    $business->latitude,
                ];
            });

            return Excel::download(new BusinessExport($business_report->toArray()), 'businesses-report.xlsx');
        } else {
            $businesses = Buisness::with('category')->orderBy('created_at', 'desc')->get();
            $business_report = $businesses->map(function ($business, $index) {
                return [
                    $index + 1,
                    $business->category->name,
                    $business->name,
                    $business->state,
                    $business->ratings,
                    $business->opening_hours,
                    strip_tags($business->details),
                    $business->location,
                    $business->longitude,
                    $business->latitude,
                ];
            });

            return Excel::download(new BusinessExport($business_report->toArray()), 'businesses-report.xlsx');
        }
    }
}
