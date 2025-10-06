@extends('layouts.app')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Analyst Dashboard </h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="app-content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3>Welcome, {{ Auth::user()->name }} 👨‍🌾</h3>
                    <p class="text-muted">Here's an overview of  activities.</p>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card text-white bg-success mb-3">
                                <div class="card-body">
                                    <h5 class="card-title ">My Plots</h5><br/>
                                    <p class="card-text"> 10 </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-warning mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Crops</h5><br/>
                                    <p class="card-text"> 10 </p>
                                    {{-- <p class="card-text">{{ $crops_count }}</p> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-info mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Test Requests</h5><br/>
                                    <p class="card-text"> 10 </p>
                                    {{-- <p class="card-text">{{ $tests_count }}</p> --}}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card text-white bg-danger mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Pending Payments</h5><br/>
                                    <p class="card-text"> 10 </p>
                                    {{-- <p class="card-text">{{ $pending_payments }}</p> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
