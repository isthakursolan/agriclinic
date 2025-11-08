@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header text-white" style="background-color: #777777;">
                        <h3 class="card-title mb-0 text-white"><i class="bi bi-geo-alt me-2"></i> Register New Plot</h3>
                    </div>
                    <form action="{{ route('user.field.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="farmer_id">Farmer</label>
                                        <input type="text"  class="form-control"
                                            value="{{ old('fullname', $profile->fullname ?? '') }}" readonly>
                                            <input type="text" name="farmer_id" value="{{ old('fullname', $profile->id ?? '') }}" hidden>
                                        {{-- <select class="form-control" name="farmer_id" required> --}}
                                            {{-- <option value="">Select Farmer</option>
                                        @foreach ($farmers as $farmer)
                                            <option value="{{ $farmer->id }}">{{ $farmer->name }}</option>
                                        @endforeach --}}
                                        {{-- </select> --}}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="field_name">Plot Name</label>
                                        <input type="text" class="form-control" name="field_name"
                                            placeholder="E.g., West Orchard" required>
                                    </div>
                                </div>
                                <!-- Area -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="area">Area (in Acres)</label>
                                        <input type="number" step="0.01" class="form-control" name="field_area"
                                            placeholder="E.g., 3.75">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="soil_type">Soil Type</label>
                                        <select class="form-control" name="soil_type">
                                            <option value="">Select Soil</option>
                                            <option value="Loamy">Loamy</option>
                                            <option value="Clay">Clay</option>
                                            <option value="Sandy">Sandy</option>
                                            <option value="Silty">Silty</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="latitude">Latitude</label>
                                        <input type="text" class="form-control" name="field_latitude" id="latitude">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="longitude">Longitude</label>
                                        <input type="text" class="form-control" name="field_longitude" id="longitude">
                                    </div>
                                </div>
                                {{-- <div class="col-md-12 mb-3">
                                    <label>Location Marker</label>
                                    <div id="map" style="height: 300px; border: 1px solid #ccc;"></div>
                                </div> --}}
                                <div class="col-md-12 mb-3">
                                    <label>Draw Field Boundary</label>
                                    <div id="fieldMap" style="height: 400px; border: 1px solid #ccc;"></div>
                                    <input type="hidden" name="field_boundary" id="field_boundary">
                                </div>

                                <!-- Static Field Map Upload -->
                                <div class="col-md-12 mb-3">
                                    <label>Optional: Upload Field Map Image</label>
                                    <input type="file" class="form-control-file" name="map_image" accept="image/*">
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Road Connectivity</label><br>
                                    <input type="radio" name="road_connectivity" value="1"> Yes
                                    <input type="radio" name="road_connectivity" value="0"> No
                                </div>

                                <div class=" col-md-6 mb-3">
                                    <label class="form-label">Irrigation System</label><br>
                                    <input type="radio" name="irrigation_system" value="1"> Yes
                                    <input type="radio" name="irrigation_system" value="0"> No
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Type of Field</label>
                                    <input type="text" name="type_of_field" class="form-control">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Source of Irrigation</label>
                                    <select name="source_of_irrigation" class="form-select">
                                        <option value="">-- Select Source --</option>
                                        <option value="Canal">Canal</option>
                                        <option value="Tube Well">Tube Well</option>
                                        <option value="Bore Well">Bore Well</option>
                                        <option value="stream">Stream</option>
                                        <option value="drip system">Drip System</option>
                                        <option value="Rainwater">Rainwater</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Land Profile</label>
                                    <textarea name="land_profile" class="form-control" placeholder="Natural or Altered"></textarea>
                                </div>
                                <!-- Description -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Plot Description</label>
                                        <textarea class="form-control" name="description" rows="3"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <div style="padding: 15px;">
                                <button type="submit" class="btn btn-dark"><i class="fas fa-save"></i> Submit</button>
                                <a href="{{ route('user.field') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>

    <!-- Google Maps JS API with Drawing -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=drawing&callback=initMap">
    </script>
    <script>
        function initMap() {
            const initialPosition = {
                lat: 23.1234,
                lng: 72.5432
            };
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 14,
                center: initialPosition,
            });

            const marker = new google.maps.Marker({
                position: initialPosition,
                map: map,
                draggable: true,
            });

            marker.addListener('dragend', function() {
                const pos = marker.getPosition();
                document.getElementById("latitude").value = pos.lat().toFixed(6);
                document.getElementById("longitude").value = pos.lng().toFixed(6);
            });

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
                    fillColor: '#28a745',
                    fillOpacity: 0.5,
                    strokeWeight: 2,
                    editable: true,
                },
            });

            drawingManager.setMap(polygonMap);

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
