@extends('layouts.print') {{-- Use a special print layout --}}

@section('content')
<div class="print-container">
    @if($printMode)
        <h2 class="text-center">Batch Parameters Report</h2>
        <table class="table table-bordered ">
            <thead>
                <tr>
                    <th>Parameter Name</th>
                    <th>Value</th>
                    <th>Unit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($batch->samples as $sample)
                    @foreach($sample->parameters as $parameter)
                    <tr>
                        <td>{{ $parameter->name }}</td>
                        <td>{{ $parameter->value }}</td>
                        <td>{{ $parameter->unit }}</td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @else
        {{-- Regular view content here --}}
        @include('frontoffice.batches.parameters-view')
    @endif
</div>
@endsection
