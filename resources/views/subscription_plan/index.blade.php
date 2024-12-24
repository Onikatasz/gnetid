@extends('layouts.app')

@section('title', 'Subscription Plans')

@section('content')

<main>
    <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
        <div class="container-fluid px-4">
            <div class="page-header-content">
                <div class="row align-items-center justify-content-between pt-3">
                    <div class="col-auto mb-3">
                        <h1 class="page-header-title">
                            <div class="page-header-icon"><i data-feather="list"></i></div>
                            Subscription Plans
                        </h1>
                    </div>
                    <div class="col-12 col-xl-auto mb-3">
                        <a class="btn btn-sm btn-light text-primary" href="{{ route('subscription_plan.create') }}">
                            <i class="me-1" data-feather="plus"></i>
                            Add New Plan
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
                            <th>Price</th>
                            <th>Duration (Days)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Duration (Days)</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($subscriptionPlans as $plan)
                        <tr>
                            <td>{{ $plan->title }}</td>
                            <td>{{ $plan->price }}</td>
                            <td>{{ $plan->duration_days }}</td>
                            <td>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark me-2" href="{{ route('subscription_plan.edit', $plan->id) }}"><i data-feather="edit"></i></a>
                                <a class="btn btn-datatable btn-icon btn-transparent-dark" href="{{ route('subscription_plan.destroy', $plan->id) }}" onclick="event.preventDefault(); document.getElementById('delete-plan-{{ $plan->id }}').submit();"><i data-feather="trash-2"></i></a>

                                <form id="delete-plan-{{ $plan->id }}" action="{{ route('subscription_plan.destroy', $plan->id) }}" method="POST" style="display: none;">
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
