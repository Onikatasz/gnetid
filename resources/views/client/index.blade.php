@extends('layouts.app')

@section('title', 'Client List')

@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="user"></i></div>
                            Client List
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('client.create') }}">
                            <i class="me-1" data-feather="user-plus"></i>
                            Add New Client
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4 text-sm">
        <div class="card">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Active</th>
                            <th>Subscription Id</th>
                            <th>Client</th>
                            <th>Plan</th>
                            <th>Phone Number</th>
                            <th>NIK</th>
                            <th>Address</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Username</th>
                            <th>Password</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Active</th>
                            <th>Subscription Id</th>
                            <th>Client</th>
                            <th>Plan</th>
                            <th>Phone Number</th>
                            <th>NIK</th>
                            <th>Address</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Username</th>
                            <th>Password</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($clients->sortByDesc('updated_at')->sortByDesc('id') as $client)
                        <tr>
                            @php
                                $subscription = $subscriptionsClient->where('client_id', $client->id)->first();
                            @endphp

                            <td>
                                @if ($clientsWithValidSubscriptions->contains($client)) 
                                    <!-- Active (Subscribed) -->
                                    <span class="bg-success rounded-circle d-inline-block" style="width: 20px; height: 20px;"></span>
                                @else
                                    <!-- Inactive (Not Subscribed) -->
                                    <span class="bg-danger rounded-circle d-inline-block" style="width: 20px; height: 20px;"></span>
                                @endif
                            </td>

                            <td>
                                {{ $subscription ? $subscription->id : 'No subscription' }}
                            </td>
                            
                            <td>
                                <a href="{{ route('client.show', $client->id) }}" class="text-decoration-none text-reset">
                                    {{ $client->name }}
                                </a>
                            </td>
                            <td>
                                {{ $subscription && $subscription->subscriptionPlan ? $subscription->subscriptionPlan->title : 'No Plan' }}
                            </td>                                                    
                            <td>{{ $client->phone }}</td>
                            <td>{{ $client->nik }}</td>
                            <td>{{ $client->address }}</td>
                            <td data-order="{{ $subscription ? \Carbon\Carbon::parse($subscription->start_date)->timestamp : 0 }}">
                                {{ $subscription ? \Carbon\Carbon::parse($subscription->start_date)->format('d M Y') : 'No subscription' }}
                            <td data-order="{{ $subscription ? \Carbon\Carbon::parse($subscription->end_date)->timestamp : 0 }}">
                                {{ $subscription ? \Carbon\Carbon::parse($subscription->end_date)->format('d M Y') : 'No subscription' }}
                            </td>
                            <td>{{ $subscription ? $subscription->username : 'No subscription' }}</td>
                            <td>
                                @if ($subscription)
                                    <span class="password-hidden" onclick="togglePassword(this)" data-password="{{ $subscription->decrypted_password }}">
                                        ••••••••
                                    </span>
                                @else
                                    No subscription
                                @endif
                            </td>                                                        
                                                                               
                            {{-- <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('client.edit', $client->id) }}"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="{{ route('client.destroy', $client->id) }}" onclick="event.preventDefault(); document.getElementById('delete-client-{{ $client->id }}').submit();"><i data-feather="trash-2"></i></a>

                                <form id="delete-client-{{ $client->id }}" action="{{ route('client.destroy', $client->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(element) {
            const isHidden = element.textContent === '••••••••';
            const password = element.getAttribute('data-password');

            if (isHidden) {
                element.textContent = password; // Show the password
            } else {
                element.textContent = '••••••••'; // Hide the password
            }
        }
    </script>
    
</main>

@endsection
