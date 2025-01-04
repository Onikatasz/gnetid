@extends('layouts.app')

@section('title', 'Create Client')

@section('content')
<head>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&callback=initMap" async></script>
</head>
<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-xl px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Create Client
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
            <a class="nav-link active ms-0" href="javascript:void(0)" id="profile-tab">Profile</a>
            <a class="nav-link" href="javascript:void(0)" id="internet-tab">Internet And Hardware</a>
            <a class="nav-link" href="javascript:void(0)">Billing</a>
            <a class="nav-link" href="javascript:void(0)">Other</a>
        </nav>
        <hr class="mt-0 mb-4" />
        <div class="row">
            <div class="col-xl-8 mx-auto">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Client Details</div>
                    <div class="card-body">
                        <!-- Form Start -->
                        <form action="{{ route('client.store') }}" method="POST">
                            @csrf
                            <!-- Profile Section -->
                            <div id="profile-section">
                                <!-- Form Group (name) -->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputUsername">Name</label>
                                    <input class="form-control" id="inputUsername" name="name" type="text" placeholder="Enter your username" required/>
                                </div>

                                <!-- Form Row -->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (phone number) -->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputPhone">Phone number</label>
                                        <input class="form-control" id="inputPhone" name="phone" type="tel" placeholder="Enter your phone number" required/>
                                    </div>
                                    <!-- Form Group (NIK) -->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputNik">NIK</label>
                                        <input class="form-control" id="inputNik" name="nik" type="text" placeholder="Enter NIK" required/>
                                    </div>
                                </div>

                                <!-- Form Group (Maps and Lat, Long) -->
                                <div class="mb-3">
                                    <label class="small mb-1" for="showMaps">Coordinate</label>
                                    <input disabled class="form-control mb-2" id="showMaps" type="text" placeholder="" required/>
                                    <input type="hidden" id="inputLatitude" name="latitude" required>
                                    <input type="hidden" id="inputLongitude" name="longitude" required>

                                    <div id="map" style="height: 300px;"></div>
                                </div>

                                <!-- Form Group (address) -->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputAddress">Address</label>
                                    <input class="form-control" id="inputAddress" name="address" type="text" placeholder="Enter your address" required/>
                                </div>

                            </div>

                            <!-- Internet Section -->
                            <div id="internet-section" style="display:none;">
                                <!-- Subscription Plan -->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputPlan">Subscription Plan</label>
                                    <select class="form-control" id="inputPlan" name="subscription_plan_id">
                                        @foreach($plans as $plan)
                                            <option value="{{ $plan->id }}">{{ $plan->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Start Date -->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputStartDate">Start Date</label>
                                    <input class="form-control" id="inputStartDate" name="start_date" type="date" required/>
                                </div>
                            </div>

                            <!-- Save changes button -->
                            <button class="btn btn-primary" type="submit" onclick="checkTabAndSubmit(event)">Create Client</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    document.getElementById('profile-tab').addEventListener('click', function() {
        document.getElementById('profile-section').style.display = 'block';
        document.getElementById('internet-section').style.display = 'none';
        document.getElementById('profile-tab').classList.add('active');
        document.getElementById('internet-tab').classList.remove('active');
    });

    document.getElementById('internet-tab').addEventListener('click', function() {
        document.getElementById('profile-section').style.display = 'none';
        document.getElementById('internet-section').style.display = 'block';
        document.getElementById('internet-tab').classList.add('active');
        document.getElementById('profile-tab').classList.remove('active');
    });

    function checkTabAndSubmit(event) {
        event.preventDefault();
        let profileSection = document.getElementById('profile-section');
        let internetSection = document.getElementById('internet-section');
        let profileInputs = profileSection.querySelectorAll('input[required]');
        let internetInputs = internetSection.querySelectorAll('input[required], select[required]');
        let profileValid = Array.from(profileInputs).every(input => input.checkValidity());
        let internetValid = Array.from(internetInputs).every(input => input.checkValidity());

        if (!profileValid) {
            document.getElementById('profile-tab').click();
            profileInputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.focus();
                    input.reportValidity();
                    return false;
                }
            });
        } else if (!internetValid) {
            document.getElementById('internet-tab').click();
            internetInputs.forEach(input => {
                if (!input.checkValidity()) {
                    input.focus();
                    input.reportValidity();
                    return false;
                }
            });
        } else {
            event.target.closest('form').submit();
        }
    }
</script>

<script>
    function initMap() {
        const defaultLocation = { lat: -7.1203090251218555, lng: 112.4157128805459 };
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 16,
            center: defaultLocation,
        });
        const marker = new google.maps.Marker({
            position: defaultLocation,
            map,
            truggable: true,
        });

        map.addListener("click", (mapsMouseEvent) => {
            // Close the current InfoWindow.
            marker.setPosition(mapsMouseEvent.latLng);
            document.getElementById('showMaps').value = `${mapsMouseEvent.latLng.lat()}, ${mapsMouseEvent.latLng.lng()}`;
            document.getElementById('inputLatitude').value = mapsMouseEvent.latLng.lat();
            document.getElementById('inputLongitude').value = mapsMouseEvent.latLng.lng();
        });
    }
</script>

@endsection
