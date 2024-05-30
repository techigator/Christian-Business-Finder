<?php

namespace App\Http\Controllers;

use App\Models\Buisness;
use App\Models\BuisnessTiming;
use App\Models\category;
use App\Models\SalesPersonUser;
use App\Models\User;
use App\Exports\BusinessExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

// use App\Traits\PHPCustomMail;

class BusinessController extends Controller
{
    // use PHPCustomMail;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function businessIndex($slug = null)
    {
        $menu = 'business';
        $loggedInUser = Auth::user();
        $loggedInUserId = $loggedInUser->id;
        $categories = category::all();
        $modifiedBusiness = collect();

        if ($loggedInUser->type === 'sales_person') {
            $salesPersons = SalesPersonUser::with('users')->where('referral_id', $loggedInUser->id)->get();
            $userIds = $salesPersons->pluck('users.id')->filter()->all();
            $users = User::whereIn('id', $userIds)->orderBy('created_at', 'desc')->get();

            $businesses = Buisness::with('category')->whereIn('user_id', array_merge($userIds, [$loggedInUserId]))
                ->orderBy('created_at', 'desc')
                ->latest()
                ->paginate(10);

            $perPage = 7;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $businesses->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedModifiedBusiness = new LengthAwarePaginator($currentPageItems, $businesses->count(), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]);

            foreach ($paginatedModifiedBusiness as $business) {
                if (is_string($business->location) && strpos($business->location, 's:') === 0) {
                    $business->location = explode('(seperate)', unserialize($business->location));
                } else {
                    $business->location = (array) $business->location;
                }

                if (strpos($business->longitude, 's:') === 0) {
                    $business->longitude = explode(',', unserialize($business->longitude));
                } else {
                    $business->longitude = is_array($business->longitude) ? $business->longitude : (array) $business->longitude;
                }

                if (strpos($business->latitude, 's:') === 0) {
                    $business->latitude = explode(',', unserialize($business->latitude));
                } else {
                    $business->latitude = is_array($business->latitude) ? $business->latitude : (array) $business->latitude;
                }

                $business->location = is_array($business->location) ? $business->location : [$business->location];
                $business->longitude = is_array($business->longitude) ? $business->longitude : [$business->longitude];
                $business->latitude = is_array($business->latitude) ? $business->latitude : [$business->latitude];

                $modifiedBusiness->push($business);
            }
        } else {
            $users = User::where('type', 'user')->get();
            $businesses = Buisness::with('category')->where('type', $slug)->orderBy('created_at', 'desc')->get();

            $perPage = 7;
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $currentPageItems = $businesses->slice(($currentPage - 1) * $perPage, $perPage)->values();
            $paginatedModifiedBusiness = new LengthAwarePaginator($currentPageItems, $businesses->count(), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]);

            foreach ($paginatedModifiedBusiness as $business) {
                if (is_string($business->location) && strpos($business->location, 's:') === 0) {
                    $business->location = explode('(seperate)', unserialize($business->location));
                } else {
                    $business->location = (array) $business->location;
                }

                if (strpos($business->longitude, 's:') === 0) {
                    $business->longitude = explode(',', unserialize($business->longitude));
                } else {
                    $business->longitude = is_array($business->longitude) ? $business->longitude : (array) $business->longitude;
                }

                if (strpos($business->latitude, 's:') === 0) {
                    $business->latitude = explode(',', unserialize($business->latitude));
                } else {
                    $business->latitude = is_array($business->latitude) ? $business->latitude : (array) $business->latitude;
                }

                $business->location = is_array($business->location) ? $business->location : [$business->location];
                $business->longitude = is_array($business->longitude) ? $business->longitude : [$business->longitude];
                $business->latitude = is_array($business->latitude) ? $business->latitude : [$business->latitude];

                $modifiedBusiness->push($business);
            }
        }

        return view('business.index', compact('modifiedBusiness', "menu", 'categories', 'users', 'paginatedModifiedBusiness'))
            ->with('i', (request()->input('page', 1) - 1) * 100);
    }

    public function businessStore(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'days' => 'required',
            'opening_hours' => 'required',
            'closing_hours' => 'required',
            'availability' => 'required',
            'location' => $request->has('location') ? 'required' : '',
            'longitude' => $request->has('longitude') ? 'required' : '',
            'latitude' => $request->has('latitude') ? 'required' : ''
        ]);

        $userId = $request->input('user_id') ?? '1';
        $existingBusiness = Buisness::where('user_id', $userId)
            ->where('type', '<>', 'admin')
            ->first();

        if ($existingBusiness) {
            if (Auth::user()->type === 'admin') {
                return redirect()->route('business.index')
                    ->with('error', 'Business already exist on this user.');
            } else {
                return redirect()->route('business.sales.index')
                    ->with('error', 'Business already exist on this user.');
            }
        }

        $business = new Buisness();

        $location = $request->input('location');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

        if (count((array)$location) > 1) {
            for ($i = 1; $i < count((array)$location); $i++) {
                $location[$i] = '(seperate)' . $location[$i];
            }
            $location = implode(',', $location);
        } else {
            $location = $location[0];
        }

        if (strpos($location, ',(seperate)') !== false) {
            $locations = explode(',(seperate)', $location);

            $serialize_location = serialize(implode('(seperate)', $locations));
            $serialize_longitude = serialize(implode(',', $longitude));
            $serialize_latitude = serialize(implode(',', $latitude));
            $business->location = $serialize_location;
            $business->longitude = $serialize_longitude;
            $business->latitude = $serialize_latitude;
        } else {
            $business->location = $location;
            $business->longitude = $longitude[0];
            $business->latitude = $latitude[0];
        }

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $imageNames = [];

            foreach ($images as $img) {
                $img_number = rand();
                $newFilename = $img_number .'_'. $img->getClientOriginalName();
                $img->move(public_path() . '/uploads/business/', $newFilename);
                $imageNames[] = $newFilename;
            }

            $imgNameToStore = implode(',', $imageNames);
        }

        if ($request->hasFile('thumbnail')) {
            $img_number = rand();
            $img = $request->file('thumbnail');
            $newThumbnailName = $img_number . '_' . $img->getClientOriginalName();
            $img->move(public_path() . '/uploads/business/', $newThumbnailName);
            $thumbnailNameToStore = $newThumbnailName;
        }

         /*$customized_users = $request->input('customized_users');
         $serialized_users = serialize($customized_users);
         $business->customized_users = $customized_users; // $serialized_users;*/

        $user = User::find($userId);
        $userType = $user->type === 'admin' ? 'admin' : 'business';
        $user->type = $userType;
        $business->user_id = $userId;
        $business->type = $user->type === 'admin' ? 'admin' : 'business';
        $business->buisness_type = 'Business';
        $business->category_id = $request->input('category');
        $business->name = $request->input('name');
        $business->state = $request->input('state');
        $business->ratings = $request->input('ratings');
        $business->thumbnail = $thumbnailNameToStore ?? null;
        $business->images = $imgNameToStore ?? null;
        $business->details = $request->input('details');

        $user->save();
        $business->save();

        $businessTiming = new BuisnessTiming();
        $businessTiming->buisness_id = $business->id;
        $daysArray = $request->input('days');
        $opening_hours = $request->input('opening_hours');
        $closing_hours = $request->input('closing_hours');
        $availabilityArray = $request->input('availability');

        $availabilityMap = [];
        foreach ($daysArray as $day) {
            $availabilityMap[] = isset($availabilityArray[$day]) && $availabilityArray[$day] === "1" ? 1 : 0;
        }

        $opening_hours_am = array_map(function ($hour) {
            return date("h:i A", strtotime($hour));
        }, $opening_hours);

        $closing_hours_pm = array_map(function ($hour) {
            return date("h:i A", strtotime($hour));
        }, $closing_hours);

        $businessTiming->opening_hours = implode(',', $opening_hours_am);
        $businessTiming->closing_hours = implode(',', $closing_hours_pm);
        $businessTiming->day = implode(',', $daysArray);
        $businessTiming->availability = implode(',', $availabilityMap);

        $businessTiming->save();

        if (Auth::user()->type === 'admin') {
            return redirect()->route('business.index', $userType)
                ->with('success', 'Business created successfully.');
        } else {
            return redirect()->route('business.sales.index')
                ->with('success', 'Business created successfully.');
        }
    }

    public function businessShow($id)
    {
        $data = DB::table('category')->where('id', $id)->first();
        return response()->json($data);
    }

    public function businessEdit($id)
    {
        $business = Buisness::find($id);
        // $users = $business->user_id;

        /*if ($business->customized_users) {
            $unserializedUsers = unserialize($business->customized_users);
            $customized_users = User::whereIn('id', $unserializedUsers)->get();
            $unserializedUsersId = $customized_users->pluck('id');
        } else {
            $users = User::where('type', 'user')->get();
        }*/

        if (is_string($business->location) && strpos($business->location, 's:') === 0) {
            $location = explode('(seperate)', unserialize($business->location));
        } else {
            $location = (array) $business->location;
        }

        if (strpos($business->longitude, 's:') === 0) {
            $longitude = explode(',', unserialize($business->longitude));
        } else {
            $longitude = is_array($business->longitude) ? $business->longitude : (array) $business->longitude;
        }

        if (strpos($business->latitude, 's:') === 0) {
            $latitude = explode(',', unserialize($business->latitude));
        } else {
            $latitude = is_array($business->latitude) ? $business->latitude : (array) $business->latitude;
        }

        $location = is_array($location) ? $location : [$location];
        $longitude = is_array($longitude) ? $longitude : [$longitude];
        $latitude = is_array($latitude) ? $latitude : [$latitude];

        $businessTiming = BuisnessTiming::where('buisness_id', $id)->first();

        if ($businessTiming) {
            $days = explode(',', $businessTiming->day);
            $openingHours = explode(',', $businessTiming->opening_hours);
            $closingHours = explode(',', $businessTiming->closing_hours);
            $availability = explode(',', $businessTiming->availability);
        } else {
            $businessTiming = BuisnessTiming::where('buisness_id', 0)->first();

            $days = explode(',', $businessTiming->day);
            $openingHours = explode(',', $businessTiming->opening_hours);
            $closingHours = explode(',', $businessTiming->closing_hours);
            $availability = explode(',', $businessTiming->availability);
        }

        $data = [
            'id' => $business->id,
            'user_id' => $business->user_id,
            'type' => $business->type,
            'user' => $business->user_id ?? '',
            'category_id' => $business->category_id,
            'name' => $business->name,
            'state' => $business->state,
            'ratings' => $business->ratings,
            'thumbnail' => $business->thumbnail,
            'images' => explode(',', $business->images),
            'days' => $days,
            'opening_hours' => $openingHours,
            'closing_hours' => $closingHours,
            'availabilities' => $availability,
            'details' => $business->details,
            'location' => $location,
            'longitude' => $longitude,
            'latitude' => $latitude,
        ];

        return response()->json($data);
    }

    public function businessUpdate(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'state' => 'required',
            'ratings' => 'required',
            'days' => 'required',
            'opening_hours' => 'required',
            'closing_hours' => 'required',
            'availability' => 'required',
            'details' => 'required',
            'location' => $request->has('location') ? 'required' : '',
            'longitude' => $request->has('longitude') ? 'required' : '',
            'latitude' => $request->has('latitude') ? 'required' : ''
        ]);

        $data = array();
        $id = $request->input('business_id');
        $userId = $request->input('user_id') ?? '1';
        $customized_users = $request->input('customized_users');

        /*if ($customized_users) {
            $serialized_users = serialize($customized_users);
            $data['customized_users'] = $serialized_users;
        } else {
            $data['customized_users'] = null;
        }*/

        $data['name'] = $request->input('name');
        $data['state'] = $request->input('state');
        $data['ratings'] = $request->input('ratings');
        $data['opening_hours'] = "00:00";
        $data['details'] = $request->input('details');

        $business = Buisness::find($id);
        $businessId = $business->id;

        $location = $request->input('location');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');

        if (count((array)$location) > 1) {
            for ($i = 1; $i < count((array)$location); $i++) {
                $location[$i] = '(seperate)' . $location[$i];
            }
            $location = implode(',', $location);
        } else {
            $location = $location[0];
        }

        if (strpos($location, ',(seperate)') !== false) {
            $locations = explode(',(seperate)', $location);

            $serialize_location = serialize(implode('(seperate)', $locations));
            $serialize_longitude = serialize(implode(',', $longitude));
            $serialize_latitude = serialize(implode(',', $latitude));
            $data['location'] = $serialize_location;
            $data['longitude'] = $serialize_longitude;
            $data['latitude'] = $serialize_latitude;
        } else {
            $data['location'] = $location;
            $data['longitude'] = $longitude[0];
            $data['latitude'] = $latitude[0];
        }

        if ($request->hasFile('thumbnail')) {
            $img_number = rand();
            $img = $request->file('thumbnail');
            $newThumbnailName = $img_number . '_' . $img->getClientOriginalName();
            $img->move(public_path() . '/uploads/business/', $newThumbnailName);
            $data['thumbnail'] = $newThumbnailName;
        }

        $currentImages = $business->images;

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $imageNames = [];

            foreach ($images as $img) {
                $img_number = rand();
                $newFilename = $img_number . '_' . $img->getClientOriginalName();
                $img->move(public_path() . '/uploads/business/', $newFilename);
                $imageNames[] = $newFilename;
            }

            if (!empty($currentImages)) {
                $currentImages .= ',' . implode(',', $imageNames);
            } else {
                $currentImages = implode(',', $imageNames);
            }

            $data['images'] = $currentImages;
        }

        Buisness::where('id', $businessId)->update($data);

        $businessTiming = array();
        $businessTiming['buisness_id'] = $businessId;

        $daysArray = $request->input('days');
        $opening_hours = $request->input('opening_hours');
        $closing_hours = $request->input('closing_hours');
        $availabilityArray = $request->input('availability');

        $availabilityMap = [];
        foreach ($daysArray as $day) {
            $availabilityMap[] = isset($availabilityArray[$day]) && $availabilityArray[$day] === "1" ? 1 : 0;
        }

        $opening_hours_am = array_map(function ($hour) {
            return date("h:i A", strtotime($hour));
        }, $opening_hours);

        $closing_hours_pm = array_map(function ($hour) {
            return date("h:i A", strtotime($hour));
        }, $closing_hours);

        $businessTiming['opening_hours'] = implode(',', $opening_hours_am);
        $businessTiming['closing_hours'] = implode(',', $closing_hours_pm);
        $businessTiming['day'] = implode(',', $daysArray);
        $businessTiming['availability'] = implode(',', $availabilityMap);

        $availabilityDays = BuisnessTiming::where('buisness_id', $businessId)->update($businessTiming);

        if ($availabilityDays === 0) {
            BuisnessTiming::create([
                'id' => $business->id,
                'day' => implode(',', $daysArray),
                'opening_hours' => implode(',', $opening_hours_am),
                'closing_hours' => implode(',', $closing_hours_pm),
                'availability' => implode(',', $availabilityMap),
            ]);
        }

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

        return response()->json([
            'success' => 'Business deleted successfully'
        ]);
    }

    public function businessStatus(Request $request)
    {
        $business = Buisness::find($request->id);
        $business->is_active = $request->is_active;
        $business->save();
        return response()->json(['success' => 'Status change successfully.']);
    }

    public function customizedMembersSendMail($id)
    {
        $business = Buisness::find($id);

        if (is_null($business->customized_users)) {
            return redirect()->back()->with('error', 'Members Not Found In This Business');
        }

        $unserializedUsers = unserialize($business->customized_users);
        $customized_users = User::whereIn('id', $unserializedUsers)->get();

        $userSubject = 'Received Sign-up Link';
        $signupLink = route('front.signup');

        foreach ($customized_users as $user) {
            $userId = $user->id;
            $userName = $user->name;
            $userEmail = $user->email;
            $businessTypeId = $business->user_id;
            $businessType = $business->user_type;

            $userMessage = view('admin.email-business-invitation', compact('userId', 'userName', 'business', 'businessTypeId', 'businessType', 'signupLink'));
            send_mail($userEmail, $userSubject, $userMessage);
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
                ->where(function ($query) use ($userIds, $loggedInUserId) {
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
