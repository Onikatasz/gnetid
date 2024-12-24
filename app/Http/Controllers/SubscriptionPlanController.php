<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Http\Requests\StoreSubscriptionPlanRequest;
use App\Http\Requests\UpdateSubscriptionPlanRequest;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::all();
        return view('subscription_plan.index', compact('subscriptionPlans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('subscription_plan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionPlanRequest $request)
    {
        SubscriptionPlan::create([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'duration_days' => $request->input('duration_days'),
        ]);

        return redirect()->route('subscription_plan.index')->with('success', 'Subscription plan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return view('subscription_plan.show', compact('subscriptionPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('subscription_plan.edit', compact('subscriptionPlan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionPlanRequest $request, SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->update([
            'title' => $request->input('title'),
            'price' => $request->input('price'),
            'duration_days' => $request->input('duration_days'),
        ]);

        return redirect()->route('subscription_plan.index')->with('success', 'Subscription plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        //
    }
}
