@extends('layouts.app') 

@section('title', 'Send Broadcast')

@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="file-plus"></i></div>
                            Send Broadcast
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="#">
                            <i class="me-1" data-feather="arrow-left"></i>
                            Back to ??
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main page content-->
    <div class="container-fluid px-4">
        <div class="row gx-4">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">Session</div>
                    <div class="card-body">
                        <select id="sessionSelect" class="form-control" required>
                            @foreach ($data as $session)
                            <option value="{{ $session }}">{{ ucfirst($session) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card card-header-actions mb-4">
                    <div class="card-header">Message Text</div>
                    <div class="card-body">
                        <textarea id="messageText" class="lh-base form-control" placeholder="Enter your message..." rows="4" required></textarea>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-header">Search Client</div>
                    <div class="card-body">
                        <input type="text" id="clientSearch" class="form-control mb-2" placeholder="Search Client by Phone or Name..." required>
                        <div id="clientResults" class="list-group" style="max-height: 200px; overflow-y: auto;"></div>
                        <table class="table mt-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="clientTable">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card card-header-actions">
                    <div class="card-header">
                        Send
                    </div>
                    <div class="card-body">
                        <div class="d-grid">
                            <button id="sendBroadcast" class="fw-500 btn btn-primary">Send Message</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    let selectedClients = [];

    document.getElementById('clientSearch').addEventListener('input', function () {
        let query = this.value;
        if (query.length > 2) {
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
                            if (!selectedClients.find(c => c.phone === client.phone)) {
                                selectedClients.push(client);
                                updateClientTable();
                            }
                            results.innerHTML = '';
                        };
                        results.appendChild(item);
                    });
                });
        }
    });

    function updateClientTable() {
        let tableBody = document.getElementById('clientTable');
        tableBody.innerHTML = '';
        selectedClients.forEach((client, index) => {
            let row = `<tr>
                <td>${client.name}</td>
                <td>${client.phone}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeClient(${index})">Remove</button></td>
            </tr>`;
            tableBody.innerHTML += row;
        });
    }

    function removeClient(index) {
        selectedClients.splice(index, 1);
        updateClientTable();
    }

    document.getElementById('sendBroadcast').addEventListener('click', function () {
        let session = document.getElementById('sessionSelect').value;
        let text = document.getElementById('messageText').value;
        let phones = selectedClients.map(client => client.phone);

        fetch("{{ route('message.sendBroadcast') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                session: session,
                text: text,
                phones: phones
            })
        })
        .then(response => response.json())
        .then(data => {
            alert('Broadcast sent successfully!');
        })
        .catch(error => {
            alert('Failed to send broadcast!');
            console.error(error);
        });
    });
</script>

@endsection
