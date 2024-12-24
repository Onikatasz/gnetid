@extends('layouts.app')

@section('title', 'Add Subscription Plan')

@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="plus"></i></div>
                            Add Subscription Plan
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('subscription_plan.index') }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Subscription Plans
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main page content -->
    <div class="container-xl px-4 mt-4">
        <div class="row justify-content-center">
            <div class="col-xl-8">
                <!-- Subscription Plan details card -->
                <div class="card mb-4">
                    <div class="card-header">Subscription Plan Details</div>
                    <div class="card-body">
                        <!-- Form Start -->
                        <form method="POST" action="{{ route('subscription_plan.store') }}">
                            @csrf
                            <!-- Title -->
                            <div class="mb-3">
                                <label class="small mb-1" for="title">Title</label>
                                <input class="form-control" id="title" type="text" name="title" value="{{ old('title') }}" required>
                            </div>

                            <!-- Price -->
                            <div class="mb-3">
                                <label class="small mb-1" for="price">Price</label>
                                <input class="form-control" id="price" type="number" name="price" value="{{ old('price') }}" required>
                            </div>

                            <!-- Duration -->
                            <div class="mb-3">
                                <label class="small mb-1" for="duration_days">Duration (Days)</label>
                                <input class="form-control" id="duration_days" type="number" name="duration_days" value="{{ old('duration_days') }}" required>
                            </div>

                            <!-- Submit button -->
                            <div class="mt-3">
                                <button class="btn btn-primary" type="submit">Add Plan</button>
                            </div>
                        </form>
                        <!-- Form End -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
