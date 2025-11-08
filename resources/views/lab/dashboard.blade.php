@extends('layouts.app')
@section('content')
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h2 class="text-2xl font-bold mb-0">Lab Scientist Dashboard </h2>
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
            <h1>Hello {{ auth()->user()->name }}</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #15803d 0%, #0f5d2a 100%); transition: transform 0.3s ease;">
                        <div class="card-body px-4 py-4">
                            <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">Total Users</h5>
                            <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">10</p>
                            {{-- <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">{{ $usersCount }}</p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%); transition: transform 0.3s ease;">
                        <div class="card-body px-4 py-4">
                            <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">Total Cases</h5>
                            <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">10</p>
                            {{-- <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">{{ $casesCount }}</p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #eab308 0%, #ca8a04 100%); transition: transform 0.3s ease;">
                        <div class="card-body px-4 py-4">
                            <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">Total Payments</h5>
                            <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">10</p>
                            {{-- <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">₹{{ $totalPayments }}</p> --}}
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white mb-3 border-0 shadow-lg" style="background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%); transition: transform 0.3s ease;">
                        <div class="card-body px-4 py-4">
                            <h5 class="card-title mb-4 fw-semibold text-start" style="font-size: 0.95rem; opacity: 0.95; letter-spacing: 0.5px;">Pending Reports</h5>
                            <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">10</p>
                            {{-- <p class="card-text fw-bold mb-0 text-end" style="font-size: 3rem; line-height: 1.2;">{{ $pendingReports }}</p> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
