@extends('layouts.app')

@section('title', 'Ticket Create')

@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="file-plus"></i></div>
                            Create Ticket
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('ticket.index') }}">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to All Tickets
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <form method="POST" action="{{ route('ticket.store') }}">
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
                        <div class="card-header">Search Client</div>
                        <div class="card-body">
                            <input type="text" id="clientSearch" class="form-control mb-2" placeholder="Search Client by Phone or Name..." required>
                            <input type="hidden" name="client_id" id="clientIdInput" required>
                            <div id="clientResults" class="list-group" style="max-height: 200px; overflow-y: auto;"></div>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header">Status</div>
                        <div class="card-body">
                            <select class="form-control" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                    </div>
                    <div class="card card-header-actions">
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

<script>
    document.getElementById('clientSearch').addEventListener('input', function () {
        let query = this.value;
        if (query.length > 2) { // Only fetch if input length > 2
            fetch(`/client/search?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    let results = document.getElementById('clientResults');
                    results.innerHTML = '';
                    data.forEach(client => {
                        let item = document.createElement('a');
                        item.classList.add('list-group-item', 'list-group-item-action');
                        item.textContent = `${client.name} (${client.phone})`;
                        item.href = '#';
                        item.onclick = function (e) {
                            e.preventDefault();
                            document.getElementById('clientIdInput').value = client.id;
                            document.getElementById('clientSearch').value = `${client.name} (${client.phone})`;
                            results.innerHTML = '';
                        };
                        results.appendChild(item);
                    });
                });
        }
    });
</script>

@endsection
