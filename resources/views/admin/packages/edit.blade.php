@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Update Package</h3>
                    </div>
                    <form action="{{ route('admin.packages.update', $package->id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Package Name</label>
                                        <input type="text" name="package_name" class="form-control"
                                            value="{{ old('package_name', $package->package_name) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Sample Type</label>
                                        <select name="sample_type" class="form-select" required>
                                            <option value="">-- Select Sample Type --</option>
                                            @foreach ($sampleTypes as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ old('sample_type', $package->sample_type) == $type->id ? 'selected' : '' }}>
                                                    {{ $type->e_type }} ({{ $type->h_type }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Price</label>
                                        <input type="number" name="price" class="form-control"
                                            value="{{ old('price', $package->price) }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Reporting Time</label>
                                        <input type="text" name="reporting_time" class="form-control"
                                            value="{{ old('reporting_time', $package->reporting_time) }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label>Parameters</label>
                                        <select id="paramSelect" class="form-select">
                                            <option value="">-- Select Parameter --</option>
                                            @foreach ($parameters as $param)
                                                @if (!in_array($param->id, json_decode($package->parameters)))
                                                    <option value="{{ $param->id }}">{{ $param->parameter }}
                                                        ({{ $param->symbol }})
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="selectedParams" class="mt-2">
                                            @foreach (json_decode($package->parameters) as $paramId)
                                                @php
                                                    $paramObj = $parameters->firstWhere('id', $paramId);
                                                @endphp
                                                @if ($paramObj)
                                                    <span class="badge bg-success m-1" data-id="{{ $paramObj->id }}">
                                                        {{ $paramObj->parameter }}
                                                        <button type="button"
                                                            class="btn-close btn-close-white btn-sm removeParam"></button>
                                                    </span>
                                                @endif
                                            @endforeach
                                        </div>

                                        <input type="hidden" name="parameters" id="parametersInput"
                                            value="{{ $package->parameters }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Update Package</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <script>
        const paramSelect = document.getElementById('paramSelect');
        const selectedParams = document.getElementById('selectedParams');
        const parametersInput = document.getElementById('parametersInput');

        // Add selected parameter to div
        paramSelect.addEventListener('change', function() {
            const selectedId = this.value;
            if (!selectedId) return;

            const selectedText = this.options[this.selectedIndex].text;

            // Append badge
            const badge = document.createElement('span');
            badge.className = 'badge bg-success m-1';
            badge.dataset.id = selectedId;
            badge.innerHTML =
                `${selectedText} <button type="button" class="btn-close btn-close-white btn-sm removeParam"></button>`;
            selectedParams.appendChild(badge);

            // Update hidden input
            let current = JSON.parse(parametersInput.value || '[]');
            current.push(parseInt(selectedId));
            parametersInput.value = JSON.stringify(current);

            // Remove from select
            this.options[this.selectedIndex].remove();
        });

        // Remove parameter from div
        selectedParams.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeParam')) {
                const badge = e.target.parentElement;
                const id = parseInt(badge.dataset.id);
                const text = badge.textContent.replace('×', '').trim();

                // Remove badge
                badge.remove();

                // Update hidden input
                let current = JSON.parse(parametersInput.value || '[]');
                current = current.filter(i => i !== id);
                parametersInput.value = JSON.stringify(current);

                // Add back to select
                const option = document.createElement('option');
                option.value = id;
                option.text = text;
                paramSelect.appendChild(option);
            }
        });
    </script>
@endsection
