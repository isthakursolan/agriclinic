@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Samples</h3>
                    </div>
{{--
<h2>Sample #{{ $sample->id }}</h2>
<p>Type: {{ $sample->sampleType->name }}</p>
<p>Packages: {{ implode(', ', $sample->package_names ?? []) }}</p>
<p>Parameters:</p>
<ul>
    @foreach($sample->investigations as $inv)
        <li>{{ $inv->parameter->name }} - Result: {{ $inv->result ?? 'Pending' }}</li>
    @endforeach
</ul> --}}

                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable();
        });
    </script>
@endsection
