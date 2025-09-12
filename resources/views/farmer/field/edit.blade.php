@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-edit"></i> Update Plot</h3>
                    </div>
                    <form action="{{ route('user.update.field', $field->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Farmer -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="farmer_id">Farmer</label>
                                        <input type="text" class="form-control"
                                            value="{{ $profile->fullname ?? '' }}" readonly>
                                        <input type="hidden" name="farmer_id" value="{{ $profile->id ?? '' }}">
                                    </div>
                                </div>

                                <!-- Plot Name -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_name">Plot Name</label>
                                        <input type="text" class="form-control" name="field_name"
                                            value="{{ old('field_name', $field->field_name) }}" required>
                                    </div>
                                </div>

                                <!-- Area -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="field_area">Area (in Acres)</label>
                                        <input type="number" step="0.01" class="form-control" name="field_area"
                                            value="{{ old('field_area', $field->field_area) }}">
                                    </div>
                                </div>

                                <!-- Soil Type -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="soil_type">Soil Type</label>
                                        <select class="form-control" name="soil_type">
                                            <option value="">Select Soil</option>
                                            <option value="Loamy" {{ $field->soil_type == 'Loamy' ? 'selected' : '' }}>Loamy</option>
                                            <option value="Clay" {{ $field->soil_type == 'Clay' ? 'selected' : '' }}>Clay</option>
                                            <option value="Sandy" {{ $field->soil_type == 'Sandy' ? 'selected' : '' }}>Sandy</option>
                                            <option value="Silty" {{ $field->soil_type == 'Silty' ? 'selected' : '' }}>Silty</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Coordinates -->
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="latitude">Latitude</label>
                                        <input type="text" class="form-control" name="field_latitude" id="latitude"
                                            value="{{ old('field_latitude', $field->field_latitude) }}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="longitude">Longitude</label>
                                        <input type="text" class="form-control" name="field_longitude" id="longitude"
                                            value="{{ old('field_longitude', $field->field_longitude) }}">
                                    </div>
                                </div>

                                <!-- Draw Field Boundary -->
                                <div class="col-md-12 mb-3">
                                    <label>Draw Field Boundary</label>
                                    <div id="fieldMap" style="height: 400px; border: 1px solid #ccc;"></div>
                                    <input type="hidden" name="field_boundary" id="field_boundary"
                                        value="{{ old('field_boundary', $field->field_boundary) }}">
                                </div>

                                <!-- Field Map Image -->
                                <div class="col-md-12 mb-3">
                                    <label>Optional: Upload Field Map Image</label>
                                    <input type="file" class="form-control-file" name="map_image" accept="image/*">
                                    @if ($field->map_image)
                                        <p class="mt-2">Current: <img src="{{ asset('storage/' . $field->map_image) }}" alt="Map" width="100"></p>
                                    @endif
                                </div>

                                <!-- Road Connectivity -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Road Connectivity</label><br>
                                    <input type="radio" name="road_connectivity" value="1"
                                        {{ $field->road_connectivity ? 'checked' : '' }}> Yes
                                    <input type="radio" name="road_connectivity" value="0"
                                        {{ !$field->road_connectivity ? 'checked' : '' }}> No
                                </div>

                                <!-- Irrigation System -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Irrigation System</label><br>
                                    <input type="radio" name="irrigation_system" value="1"
                                        {{ $field->irrigation_system ? 'checked' : '' }}> Yes
                                    <input type="radio" name="irrigation_system" value="0"
                                        {{ !$field->irrigation_system ? 'checked' : '' }}> No
                                </div>

                                <!-- Type of Field -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Type of Field</label>
                                    <input type="text" name="type_of_field" class="form-control"
                                        value="{{ old('type_of_field', $field->type_of_field) }}">
                                </div>

                                <!-- Source of Irrigation -->
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Source of Irrigation</label>
                                    <select name="source_of_irrigation" class="form-select">
                                        <option value="">-- Select Source --</option>
                                        <option value="Canal" {{ $field->source_of_irrigation == 'Canal' ? 'selected' : '' }}>Canal</option>
                                        <option value="Tube Well" {{ $field->source_of_irrigation == 'Tube Well' ? 'selected' : '' }}>Tube Well</option>
                                        <option value="Bore Well" {{ $field->source_of_irrigation == 'Bore Well' ? 'selected' : '' }}>Bore Well</option>
                                        <option value="Stream" {{ $field->source_of_irrigation == 'Stream' ? 'selected' : '' }}>Stream</option>
                                        <option value="Drip System" {{ $field->source_of_irrigation == 'Drip System' ? 'selected' : '' }}>Drip System</option>
                                        <option value="Rainwater" {{ $field->source_of_irrigation == 'Rainwater' ? 'selected' : '' }}>Rainwater</option>
                                        <option value="Other" {{ $field->source_of_irrigation == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <!-- Land Profile -->
                                <div class="mb-3">
                                    <label class="form-label">Land Profile</label>
                                    <textarea name="land_profile" class="form-control">{{ old('land_profile', $field->land_profile) }}</textarea>
                                </div>

                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Plot Description</label>
                                        <textarea class="form-control" name="description" rows="3">{{ old('description', $field->description) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
                            <a href="{{ route('user.field') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- Google Maps API -->
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=drawing&callback=initMap">
    </script>
    <script>
        function initMap() {
            const initialPosition = {
                lat: parseFloat("{{ $field->field_latitude ?? 23.1234 }}"),
                lng: parseFloat("{{ $field->field_longitude ?? 72.5432 }}")
            };

            const polygonMap = new google.maps.Map(document.getElementById("fieldMap"), {
                zoom: 14,
                center: initialPosition,
            });

            const drawingManager = new google.maps.drawing.DrawingManager({
                drawingMode: google.maps.drawing.OverlayType.POLYGON,
                drawingControl: true,
                drawingControlOptions: {
                    position: google.maps.ControlPosition.TOP_CENTER,
                    drawingModes: ['polygon'],
                },
                polygonOptions: {
                    fillColor: '#007bff',
                    fillOpacity: 0.5,
                    strokeWeight: 2,
                    editable: true,
                },
            });

            drawingManager.setMap(polygonMap);

            // Prefill existing boundary if available
            const existingBoundary = {!! $field->field_boundary ?? 'null' !!};
            if (existingBoundary) {
                const coords = JSON.parse(existingBoundary);
                const polygon = new google.maps.Polygon({
                    paths: coords,
                    fillColor: '#007bff',
                    fillOpacity: 0.5,
                    strokeWeight: 2,
                    editable: true,
                });
                polygon.setMap(polygonMap);
            }

            google.maps.event.addListener(drawingManager, 'overlaycomplete', function(event) {
                const path = event.overlay.getPath();
                let coordinates = [];

                for (let i = 0; i < path.getLength(); i++) {
                    coordinates.push({
                        lat: path.getAt(i).lat(),
                        lng: path.getAt(i).lng()
                    });
                }

                document.getElementById("field_boundary").value = JSON.stringify(coordinates);
            });
        }
    </script>
@endsection
