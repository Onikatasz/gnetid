@extends('layouts.auth')

@section('title', $client->name)

@section('content')

<main>
    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <!-- Create Organization-->
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11 mt-4">
                <div class="card text-center h-100">
                    <div class="card-body px-5 pt-5 d-flex flex-column">
                        <div>
                            <div class="h3 text-primary">Create</div>
                            <p class="text-muted mb-4">Create an ticket</p>
                        </div>
                        <div class="icons-org-create align-items-center mx-auto mt-auto">
                            <i class="icon-users" data-feather="mail"></i>
                            <i class="icon-plus fas fa-plus"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent px-5 py-4">
                        <div class="small text-center"><a class="btn btn-block btn-primary" href="multi-tenant-create.html">Create new ticket</a></div>
                    </div>
                </div>
            </div>
            <!-- Join Organization-->
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11 mt-4">
                <div class="card text-center h-100">
                    <div class="card-body px-5 pt-5 d-flex flex-column align-items-between">
                        <div>
                            <div class="h3 text-secondary">Check</div>
                            <p class="text-muted mb-4">Check all your ticket progress</p>
                        </div>
                        <div class="icons-org-join align-items-center mx-auto">
                            <i class="icon-user" data-feather="mail"></i>
                            <i class="icon-arrow fas fa-long-arrow-alt-right"></i>
                            <i class="icon-users" data-feather="check-square"></i>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent px-5 py-4">
                        <div class="small text-center"><a class="btn btn-block btn-secondary" href="{{ route('client.checkMyTicket') }}">Check ticket</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11 mt-4">

                <!-- Logout -->
                <div class="dropdown text-center">
                    <button class="btn btn-teal dropdown-toggle" id="dropdownMenuButton" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{ $client->name }}</button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('client.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                            Logout
                        </a>
                        <a class="dropdown-item" href="#!">Another action</a>
                        <a class="dropdown-item" href="#!">Something else here</a>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('client.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</main>

@endsection