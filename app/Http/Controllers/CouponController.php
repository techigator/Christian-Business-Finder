<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function coupon()
    {
        $users = User::where('type', 'sales_person')->get();
        $coupons = Coupon::latest('created_at')->paginate(10);

        return view('coupon.index', compact('coupons', 'users'));
    }

    public function store(Request $request)
    {
        try {
            $code = $request->input('code');
            $discountType = $request->input('discount_type');
            $discountAmount = $request->input('discount_amount');
            $user_type = $request->input('user_type') ?? '';
            $salesPersonId = $request->input('sales_person_id') ?? '1';

            $existingCoupon = Coupon::where(['user_id' => $salesPersonId, 'user_type' => $user_type, 'code' => $code])->first();

            if ($existingCoupon) {
                return redirect()->back()->withErrors('Coupon already created.');
            }

            $coupon = new Coupon();
            $coupon->user_type = $user_type;
            $coupon->user_id = $salesPersonId;
            $coupon->code = $code;
            $coupon->discount_amount = $discountAmount;

            if ($discountType === 'percentage') {
                $coupon->is_percentage = true;
            } else {
                $coupon->is_percentage = false;
            }
            $coupon->save();

            if ($salesPersonId) {
                $user = User::find($salesPersonId);
                $user->coupon_id = $coupon->id;

                $user->save();
            }

            return redirect()->route('admin.coupon')->withSuccess('Coupon created successfully.');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function delete($id): \Illuminate\Http\JsonResponse
    {
        $coupon = Coupon::find($id);
        $coupon->delete();

        return response()->json([
            'success' => 'Coupon deleted successfully.'
        ]);
    }

    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required',
        ]);

        try {
            $userId = Auth::user()->id;
            $coupon = $this->validateCoupon($request->coupon_code);

            if (empty($coupon)) {
                return redirect()->back()->withErrors(['Invalid Coupon Code']);
            }

            $subTotal = \Cart::session($userId)->getSubTotal();
            $discountPercentage = $coupon->discount_amount;
            $discountAmount = ($discountPercentage / 100) * $subTotal;
            $newSubTotal = $subTotal - $discountAmount;

            session()->put('coupon', [
                'code' => $coupon->code,
                'price' => $newSubTotal,
                'discount' => $coupon->discount_amount
            ]);

            return redirect()->back()->withSuccess('Coupon applied successfully!');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function validateCoupon($code)
    {
        return Coupon::where('code', $code)->first();
    }
}
