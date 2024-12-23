@extends('layouts.auth')

@section('title', 'Login')

@section('content')


<main>
    <div class="container-xl px-4">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                <!-- Social login form-->
                <div class="card my-5">
                    <div class="card-body p-5 text-center">
                        <div class="h3 fw-light mb-3">Sign In</div>
                        <!-- Social login links-->
                        <a class="btn btn-icon btn-facebook mx-1" href="#!"><i class="fab fa-facebook-f fa-fw fa-sm"></i></a>
                        <a class="btn btn-icon btn-github mx-1" href="#!"><i class="fab fa-github fa-fw fa-sm"></i></a>
                        <a class="btn btn-icon btn-google mx-1" href="#!"><i class="fab fa-google fa-fw fa-sm"></i></a>
                        <a class="btn btn-icon btn-twitter mx-1" href="#!"><i class="fab fa-twitter fa-fw fa-sm text-white"></i></a>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body p-5">
                        <!-- Login form-->
                        <form action="" method="post">
                            @csrf
                            <!-- Form Group (Username)-->
                            <div class="mb-3">
                                <label class="text-gray-600 small" for="emailExample">Username</label>
                                <input class="form-control form-control-solid" name="username" type="text" placeholder="" value="{{ old('username') }}" aria-label="Username" aria-describedby="emailExample" />
                                @error('username')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Form Group (password)-->
                            <div class="mb-3">
                                <label class="text-gray-600 small" for="passwordExample">Password</label>
                                <input class="form-control form-control-solid" name="password" type="password" placeholder="" aria-label="Password" aria-describedby="passwordExample" />
                                @error('username')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Form Group (login box)-->
                            <div class="d-flex align-items-center justify-content-between mb-0">
                                <div class="form-check">
                                    <input class="form-check-input" id="checkRememberPassword" type="checkbox" value="" />
                                    <label class="form-check-label" for="checkRememberPassword">Remember password</label>
                                </div>
                                <button class="btn btn-primary">Login</button>
                            </div>
                        </form>
                    </div>
                    <hr class="my-0" />
                </div>
            </div>
        </div>
    </div>
</main>


@endsection