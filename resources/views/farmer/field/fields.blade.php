@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Fields</h3>
                    </div>
                    <table id="myDataTable" class="display">
                        <thead>
                            <tr>
                                <th>Column 1</th>
                                <th>Column 2</th>
                                <!-- Add more columns as needed -->
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table data will go here, either static or dynamically loaded -->
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <!-- Google Maps JS API with Drawing -->
        <script>
        $(document).ready(function() {
            $('#myDataTable').DataTable();
        });
    </script>

@endsection
