<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subscription = Subscription::find($id);

        if (!$subscription) {
            return response()->json(['message' => 'Subscription not found'], 404);
        }

        try {
            $subscription->update($request->all());
            return response()->json(['message' => 'Subscription updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update subscription', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //
    }

    public function payment($id)
    {
        // Decrypt the ID
        $id = Crypt::decryptString($id);

        // Log in as a specific user (e.g., user with ID 1)
        Auth::loginUsingId(1);

        // Find the subscription by ID
        $subscription = Subscription::find($id);

        if ($subscription) {
            // Get the current end date
            $startDate = Carbon::parse($subscription->start_date);
            $endDate = Carbon::parse($subscription->end_date);

            // Calculate the new end date using the helper
            $newEndDate = thisDayOrLast($endDate->addMonthNoOverflow(), $startDate->day);

            // Prepare the data for updating the subscription
            $data = [
                'subscription_plan_id' => $subscription->subscription_plan_id,
                'start_date' => $subscription->end_date,
                'end_date' => $newEndDate->toDateString(),
            ];

            // Call the update function
            $response = $this->update(new Request($data), $id);

            if ($response->getStatusCode() == 200) {
                return response()->json(['message' => 'Subscription updated successfully'], 200);
            } else {
                return response()->json(['message' => 'Failed to update subscription'], 500);
            }
        } else {
            return response()->json(['message' => 'Subscription not found'], 404);
        }
    }

    public function checkPaymentDates($phone)
    {
        if (substr($phone, 0, 1) == '0') {
            $updatedPhone = '62' . substr($phone, 1);
        }

        $subscription = Subscription::whereHas('client', function ($query) use ($phone, $updatedPhone) {
            $query->where('phone', $phone)->orWhere('phone', $updatedPhone);
        })->first();
    
        if ($subscription) {
            $startDate = Carbon::parse($subscription->start_date);
            $billingDates = [];
    
            for ($i = 0; $i < 12; $i++) {
                $startDate = $startDate->addMonthNoOverflow();
                $billingDates[] = thisDayOrLast($startDate, Carbon::parse($subscription->start_date)->day)->toDateString();
            }
    
            return response()->json(['billing_dates' => $billingDates]);
        }
    
        return response()->json(['message' => 'Subscription not found'], 404);
    }
}
