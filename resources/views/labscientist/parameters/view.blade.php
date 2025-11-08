@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> Parameter Report for {{ $parameter->parameter }} in Batch
                            {{ $batch->batch_no }} with Sample Type {{ $batch->sampleType->e_type }} </h3>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        {{-- <div class="mb-3">
                            <button id="printBtn" class="btn btn-outline-primary">
                                <i class="fas fa-print"></i> Print
                            </button>
                            <button id="pdfBtn" class="btn btn-outline-danger">
                                <i class="fas fa-file-pdf"></i> PDF
                            </button>
                        </div> --}}

                        <table id="parametersTable" class="table datatable table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Parameter</th>
                                    <th>Sample Id</th>
                                    <th>Lab Ref No </th>
                                    <th>Reading 1</th>
                                    <th>Reading 2</th>
                                    <th>Dilusion</th>
                                    <th>Result</th>
                                    <th>Interpretation</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($samples as $sample)
                                    @php $investigation = $sample->investigations[0] ?? null; @endphp
                                    @if ($investigation)
                                        <tr>
                                            <td>{{ $parameter->parameter }}</td>
                                            <td>{{ $sample->sample_id }}</td>
                                            <td>{{ $sample->lab_ref_no }}</td>

                                            @foreach (['reading1', 'reading2', 'dilusion', 'result', 'interpretation'] as $field)
                                                <td contenteditable="true" class="editable"
                                                    data-id="{{ $investigation->id }}" data-field="{{ $field }}">
                                                    {{ $investigation->{$field} }}
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                        <button id="saveAllBtn" class="btn btn-success">
                            <i class="fas fa-save"></i> Save All Changes
                        </button>
                        <button type="button" onclick="window.history.back()" class="btn btn-secondary">Cancel</button>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const table = $('#parametersTable').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        title: 'Batch Parameters Report',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        title: 'Batch Parameters Report',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });

            // // External print/pdf buttons
            // document.getElementById('printBtn').addEventListener('click', () => table.button(0).trigger());
            // document.getElementById('pdfBtn').addEventListener('click', () => table.button(1).trigger());

            // Mark edited cells visually
            document.querySelectorAll('.editable').forEach(cell => {
                cell.addEventListener('input', () => {
                    cell.classList.add('table-warning');
                });
            });

            // Handle Bulk Save
            const saveAllBtn = document.getElementById('saveAllBtn');
            saveAllBtn.addEventListener('click', async () => {
                const editedCells = document.querySelectorAll('.editable.table-warning');
                const changes = [];

                editedCells.forEach(cell => {
                    changes.push({
                        id: cell.dataset.id,
                        field: cell.dataset.field,
                        value: cell.textContent.trim()
                    });
                });

                if (changes.length === 0) {
                    alert('No changes to save.');
                    return;
                }

                if (!confirm('Save all changes?')) return;

                saveAllBtn.disabled = true;
                saveAllBtn.textContent = 'Saving...';

                try {
                    const response = await fetch("{{ route('parameters.bulkUpdate') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            data: changes
                        })
                    });

                    const result = await response.json();

                    if (result.success) {
                        alert(result.message || 'All changes saved!');
                        editedCells.forEach(cell => {
                            cell.classList.remove('table-warning');
                            cell.classList.add('table-success');
                        });

                        setTimeout(() => {
                            document.querySelectorAll('.table-success').forEach(c => c.classList
                                .remove('table-success'));
                        }, 1500);
                    } else {
                        alert(result.message || 'Error saving changes.');
                    }

                } catch (error) {
                    console.error(error);
                    alert('Something went wrong while saving.');
                } finally {
                    saveAllBtn.disabled = false;
                    saveAllBtn.innerHTML = '<i class="fas fa-save"></i> Save All Changes';
                }
            });
        });
    </script>
@endpush
