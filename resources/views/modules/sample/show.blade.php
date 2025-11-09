@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-geo-alt me-2"></i> Samples</h3>
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
