@extends('layouts.app')

@section('title', 'Client Add')

@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user-plus"></i></div>
                            Add Client
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('client.index') }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Clients List
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
                <!-- Client details card -->
                <div class="card mb-4">
                    <div class="card-header">Client Details</div>
                    <div class="card-body">
                        <!-- Form Start -->
                        <form method="POST" action="{{ route('client.store') }}">
                            @csrf
                            <!-- Name -->
                            <div class="mb-3">
                                <label class="small mb-1" for="name">Name</label>
                                <input class="form-control" id="name" type="text" name="name" value="{{ old('name') }}" required>
                            </div>

                            <!-- NIK -->
                            <div class="mb-3">
                                <label class="small mb-1" for="nik">NIK</label>
                                <input class="form-control" id="nik" type="text" name="nik" value="{{ old('nik') }}" required>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label class="small mb-1" for="phone">Phone Number</label>
                                <input class="form-control" id="phone" type="text" name="phone" value="{{ old('phone') }}" required>
                            </div>

                            <!-- Address -->
                            <div class="mb-3">
                                <label class="small mb-1" for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            </div>

                            <!-- Subscription Status -->
                            <div class="mb-3">
                                <label class="small mb-1">Subscription Status</label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="subscribedYes" type="radio" name="is_subscribed" value="1" {{ old('is_subscribed') == '1' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="subscribedYes">Subscribed</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" id="subscribedNo" type="radio" name="is_subscribed" value="0" {{ old('is_subscribed') == '0' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="subscribedNo">Not Subscribed</label>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <div class="mt-3">
                                <button class="btn btn-primary" type="submit">Add Client</button>
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
