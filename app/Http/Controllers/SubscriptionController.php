<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::latest('created_at')->paginate(10);

        return view('subscription.index', compact('subscriptions'));
    }

    public function store(Request $request)
    {
        try {
            $subscriptionAmount = $request->input('subscription_amount');
            $formattedAmount = number_format($subscriptionAmount, 2, '.', '');

            $subscription = new Subscription();
            $subscription->amount = $formattedAmount;

            $subscription->save();

            return redirect()->route('subscription.index')->withSuccess('Subscription amount created successfully.');
        } catch (\Exception $exception) {
            return redirect()->back()->withErrors($exception->getMessage());
        }
    }

    public function delete($id)
    {
        $coupon = Subscription::find($id);
        $coupon->delete();

        return response()->json([
            'success' => 'Subscription amount deleted successfully.'
        ]);
    }
}
