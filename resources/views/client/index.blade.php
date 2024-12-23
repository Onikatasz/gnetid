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
    <div class="container-fluid px-4">
        <div class="card">
            <div class="card-body">
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Active</th>
                            <th>Client</th>
                            <th>Phone Number</th>
                            <th>NIK</th>
                            <th>Address</th>
                            <th>Joined Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Active</th>
                            <th>Client</th>
                            <th>Phone Number</th>
                            <th>NIK</th>
                            <th>Address</th>
                            <th>Joined Date</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($clients as $client)
                        <tr>
                            <td>
                                @if ($client->is_subscribed)
                                    <!-- Active (Subscribed) -->
                                    <span class="bg-success rounded-circle d-inline-block" style="width: 20px; height: 20px;"></span>
                                @else
                                    <!-- Inactive (Not Subscribed) -->
                                    <span class="bg-danger rounded-circle d-inline-block" style="width: 20px; height: 20px;"></span>
                                @endif
                            </td>
                            
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->phone_number }}</td>
                            <td>{{ $client->nik }}</td>
                            <td>{{ $client->address }}</td>
                            <td>{{ $client->created_at->format('d M Y') }}</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('client.edit', $client->id) }}"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="{{ route('client.destroy', $client->id) }}" onclick="event.preventDefault(); document.getElementById('delete-client-{{ $client->id }}').submit();"><i data-feather="trash-2"></i></a>

                                <form id="delete-client-{{ $client->id }}" action="{{ route('client.destroy', $client->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

@endsection
