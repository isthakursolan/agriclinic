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
            <div class="grid grid-cols-4 gap-4">
                <div class="bg-white shadow rounded p-4">
                    <h2 class="text-lg font-semibold">Total Users</h2>
                    <p>10</p>
                    {{-- <p>{{ $usersCount }}</p> --}}
                </div>

                <div class="bg-white shadow rounded p-4">
                    <h2 class="text-lg font-semibold">Total Cases</h2>
                    <p>10</p>
                    {{-- <p>{{ $casesCount }}</p> --}}
                </div>

                <div class="bg-white shadow rounded p-4">
                    <h2 class="text-lg font-semibold">Total Payments</h2>
                    <p>10</p>
                    {{-- <p>₹{{ $totalPayments }}</p> --}}
                </div>

                <div class="bg-white shadow rounded p-4">
                    <h2 class="text-lg font-semibold">Pending Reports</h2>
                    <p>10</p>
                    {{-- <p>{{ $pendingReports }}</p> --}}
                </div>
            </div>

        </div>
    </div>
@endsection
