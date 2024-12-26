@extends('layouts.client')

@section('title', 'Create Ticket')

@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('client.dashboard') }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to Dashboard
                        </a>
                    </div>
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="file-plus"></i></div>
                            Create Ticket
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('ticket.checkMyTicket') }}">
                            Go to All Tickets
                            <i class="ms-1" data-feather="arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <form method="POST" action="{{ route('ticket.storeMyTicket') }}">
            @csrf
            <div class="row gx-4">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">Ticket Title</div>
                        <div class="card-body">
                            <input class="form-control" name="title" type="text" placeholder="Enter your ticket title..." required />
                        </div>
                    </div>
                    <div class="card card-header-actions mb-4">
                        <div class="card-header">Ticket Description</div>
                        <div class="card-body">
                            <textarea class="lh-base form-control" name="body" placeholder="Enter your ticket description..." rows="4" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            Publish
                        </div>
                        <div class="card-body">
                            <div class="d-grid">
                                <button type="submit" class="fw-500 btn btn-primary">Submit Ticket</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>

@endsection
