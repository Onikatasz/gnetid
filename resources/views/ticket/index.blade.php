@extends('layouts.app')

@section('title', 'Ticket List')

@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Ticket List
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('ticket.create') }}">
                            <i class="me-1" data-feather="plus"></i>
                            Create New Ticket
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
                            <th>Title</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Title</th>
                            <th>Client</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->title }}</td>
                            <td><a href="{{ route("client.show", $ticket->client_id) }}" class="text-decoration-none text-reset">{{ $ticket->client->name }}</a></td>
                            <td>{{ $ticket->created_at->format('d M Y H:i:s') }}</td>
                            <td>
                                @if ($ticket->status == 'pending')
                                    <div class="badge bg-yellow-soft text-yellow">Pending</div>
                                @elseif ($ticket->status == 'in_progress')
                                    <div class="badge bg-blue-soft text-blue">In Progress</div>
                                @else
                                    <div class="badge bg-green-soft text-green">Completed</div>
                                @endif
                            </td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('ticket.edit', $ticket->id) }}"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="{{ route('ticket.destroy', $ticket->id) }}" onclick="event.preventDefault(); document.getElementById('delete-ticket-{{ $ticket->id }}').submit();"><i data-feather="trash-2"></i></a>
                                <form id="delete-ticket-{{ $ticket->id }}" action="{{ route('ticket.destroy', $ticket->id) }}" method="POST" style="display: none;">
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
