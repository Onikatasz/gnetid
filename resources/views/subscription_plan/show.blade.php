@extends('layouts.app')

@section('title', $subscriptionPlan->title)

@section('content')


<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="layers"></i></div>
                            {{  $subscriptionPlan->title }} - Subscription Plan
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <!-- Subscription Plan page navigation-->
        <nav class="nav nav-borders">
            <a class="nav-link active ms-0" href="">Plan Details</a>
            <a class="nav-link" href="">Features</a>
            <a class="nav-link" href="">Billing</a>
            <a class="nav-link" href="">Other</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <!-- Subscription Plan details card-->
                <div class="card mb-4">
                    <div class="card-header">Subscription Plan Details</div>
                    <div class="card-body">
                        <!-- Form Start -->
                        <form action="{{ route('subscription_plan.update', $subscriptionPlan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                        
                            <!-- Form Group (title) -->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputPlanTitle">Plan Title</label>
                                <input class="form-control" id="inputPlanTitle" name="title" type="text" placeholder="Enter the subscription plan title" value="{{ $subscriptionPlan->title }}" />
                            </div>
                        
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (price) -->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPrice">Price</label>
                                    <input class="form-control" id="inputPrice" name="price" type="number" placeholder="Enter the plan price" value="{{ $subscriptionPlan->price }}" />
                                </div>
                                <!-- Form Group (duration) -->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputDuration">Duration (in days)</label>
                                    <input class="form-control" id="inputDuration" name="duration_days" type="number" placeholder="Enter subscription duration" value="{{ $subscriptionPlan->duration_days }}" />
                                </div>
                            </div>

                            <!-- Save changes button -->
                            <button class="btn btn-primary" type="submit">Save changes</button>
                            <a class="btn btn-danger" href="{{ route('subscription_plan.destroy', $subscriptionPlan->id) }} ">Delete Subscription Plan</a>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
