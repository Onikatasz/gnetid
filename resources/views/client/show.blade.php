@extends('layouts.app')

@section('title', $client->name)

@section('content')


<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            {{  $client->name }} - Profile
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <nav class="nav nav-borders">
            <a class="nav-link active ms-0" href="">Profile</a>
            <a class="nav-link" href="">Internet And Hardware</a>
            <a class="nav-link" href="">Billing</a>
            <a class="nav-link" href="">Other</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Client Details</div>
                    <div class="card-body">
                        <!-- Form Start -->
                        <form action="{{ route('client.update', $client->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                        
                            <!-- Form Group (name) -->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Name</label>
                                <input class="form-control" id="inputUsername" name="name" type="text" placeholder="Enter your username" value="{{ $client->name }}" />
                            </div>
                        
                            <!-- Form Row -->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number) -->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Phone number</label>
                                    <input class="form-control" id="inputPhone" name="phone" type="tel" placeholder="Enter your phone number" value="{{ $client->phone }}" />
                                </div>
                                <!-- Form Group (NIK) -->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputNik">NIK</label>
                                    <input class="form-control" id="inputNik" name="nik" type="text" placeholder="Enter NIK" value="{{ $client->nik }}" />
                                </div>
                            </div>
                        
                            <!-- Form Group (address) -->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputAddress">Address</label>
                                <input class="form-control" id="inputAddress" name="address" type="text" placeholder="Enter your address" value="{{ $client->address }}" />
                            </div>
                        
                            <!-- Save changes button -->
                            <button class="btn btn-primary" type="submit">Save changes</button>
                            <a class="btn btn-danger" href="{{ route('client.destroy', $client->id) }} ">Delete Client</a>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
