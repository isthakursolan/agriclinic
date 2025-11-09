@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header text-white" style="background-color: #777777;">
            <h4>Accept Collected Samples</h4>
        </div>
        <div class="card-body">
            {{-- <form method="GET" action="{{ route('frontoffice.samples.accept') }}">
                <div class="form-group">
                    <label>Select Field Agent</label>
                    <select name="agent_id" class="form-control">
                        <option value="">All Agents</option>
                        @foreach ($agents as $agent)
                            <option value="{{ $agent->id }}" {{ request('agent_id') == $agent->id ? 'selected' : '' }}>
                                {{ $agent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button class="btn btn-info mt-2">Filter</button>
            </form> --}}
            <form action="{{ route('frontoffice.samples.accept.process') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <table class="table datatable table-bordered table-striped">
                        <thead>
                            <tr>
                                {{-- <th><input type="checkbox" id="toggleAll">*</th> --}}
                                <th>#</th>
                                <th>Sample ID</th>
                                <th>Farmer</th>
                                {{-- <th>Method</th> --}}
                                {{-- <th>Payment Status</th> --}}
                                {{-- <th>Accept?</th> --}}
                                <th>Collected By</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($samples as $sample)
                                <tr>
                                    <td><input type="checkbox" name="sample_ids[]" value="{{ $sample->id }}"
                                            class="sampleCheckbox"></td>
                                    <td>{{ $sample->sample_id }}</td>
                                    <td>{{ $sample->farmer->fullname }}</td>
                                    {{-- <td>{{ $sample->collection_method }}</td> --}}
                                    {{-- <td>
                                        @if ($sample->payment && $sample->payment->status === 'paid')
                                            <span style="color: #777777;">Paid ✅</span>
                                        @else
                                            <span style="color: #777777;">Unpaid ❌</span>
                                        @endif
                                    </td> --}}
                                    {{-- <td>
                                        <input type="checkbox" name="sample_ids[]" value="{{ $sample->id }}" />
                                    </td> --}}
                                    <td>{{ $sample->collected_by_agent ? $sample->collected_by_agent : ($sample->collection_method ? $sample->collection_method : 'Not Collected') }}
                                    </td>
                                    <td>
                                        @if ($sample->sample_status === 'rejected')
                                            <span class="badge bg-danger text-white">
                                                Rejected: {{ $sample->rejection_reason ?? 'No reason provided' }}
                                            </span>
                                        @elseif ($sample->sample_status === 'accepted' || ($sample->payment && $sample->payment->status === 'paid'))
                                            <span class="badge bg-success">Collected</span>
                                        @else
                                            <span class="badge bg-warning">Pending Collection</span>
                                        @endif
                                    </td>
                                </tr>
                                {{-- <form action="{{ route('frontoffice.samples.reject', $sample->id) }}" method="POST">
                                    @csrf
                                    <input type="text" name="reason" placeholder="Reason for rejection"
                                        class="form-control" required>
                                    <button type="submit" class="btn btn-danger mt-2">Reject Sample</button>
                                </form> --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-success">Accept Selected</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('toggleAll').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('.sampleCheckbox');
            checkboxes.forEach(function(box) {
                box.checked = this.checked;
            }, this);
        });
    </script>
@endsection
