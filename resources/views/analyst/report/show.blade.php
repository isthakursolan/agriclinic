@extends('layouts.app')

@section('content')
<div class="content-wrapper pt-4">
    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">

                <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                    <h3 class="card-title mb-0"><i class="fas fa-leaf"></i> Consolidated Soil Report</h3>
                    <div>
                        <button id="printReport" class="btn btn-light btn-sm me-2">
                            <i class="fas fa-print"></i> Print Report
                        </button>
                        <button id="downloadPdf" class="btn btn-light btn-sm">
                            <i class="fas fa-file-pdf"></i> Download PDF
                        </button>
                    </div>
                </div>

                <!-- ✅ Report Area (only this part prints/downloads) -->
                <div class="card-body" id="reportArea">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5><strong>R - 00001</strong></h5>
                            <p><strong>Name:</strong> Sh Arvind Sharma</p>
                            <p><strong>Regd. Number:</strong> R-001051</p>
                            <p><strong>Phone:</strong> 94173 76224</p>
                            <p><strong>Address:</strong> Village Chajpur, Tehsil Jubbal, Distt Shimla HP</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Sample ID:</strong> —</p>
                            <p><strong>Lab Ref No:</strong> Batch-39:7-12</p>
                            <p><strong>Crop:</strong> Apple</p>
                            <p><strong>Variety / Rootstock:</strong> Seedling</p>
                            <p><strong>Age of Crop/Tree:</strong> 10–50 years</p>
                            <p><strong>Block:</strong> Himpari Orchard 1–6</p>
                            <p><strong>Receiving Date:</strong> 07 Oct 2021</p>
                            <p><strong>Reporting Date:</strong> 13 Oct 2021</p>
                            <p><strong>Referral Person:</strong> Self</p>
                        </div>
                    </div>

                    <h5 class="mt-4"><strong>Test Name:</strong> Soil Analysis</h5>

                    <div class="table-responsive">
                        <table id="reportTable" class="table table-bordered table-striped">
                            <thead class="table-success">
                                <tr>
                                    <th>S.No</th>
                                    <th>Parameter</th>
                                    <th>Normal Range</th>
                                    <th>Himpari-1</th>
                                    <th>Himpari-2</th>
                                    <th>Himpari-3</th>
                                    <th>Himpari-4</th>
                                    <th>Himpari-5</th>
                                    <th>Himpari-6</th>
                                    <th>Response to Fertilizer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>1</td><td>pH Soil</td><td>6.6 – 7.3</td><td>6.48</td><td>6.06</td><td>6.07</td><td>5.99</td><td>6.00</td><td>6.61</td><td>-</td></tr>
                                <tr><td>2</td><td>EC Soil (dS/m)</td><td>< 2.00</td><td>0.237</td><td>0.208</td><td>0.163</td><td>0.154</td><td>0.211</td><td>0.151</td><td>-</td></tr>
                                <tr><td>3</td><td>Organic Carbon</td><td>0.50 – 0.75</td><td>3.12</td><td>2.91</td><td>1.95</td><td>2.70</td><td>2.94</td><td>2.07</td><td>-</td></tr>
                                <tr><td>4</td><td>N Available (kg/ha)</td><td>280 – 560</td><td>457.86</td><td>420.22</td><td>439.04</td><td>457.86</td><td>526.85</td><td>426.50</td><td>Medium</td></tr>
                                <tr><td>5</td><td>P Available (kg/ha)</td><td>10 – 25</td><td>129.14</td><td>137.98</td><td>43.68</td><td>29.34</td><td>26.88</td><td>69.66</td><td>Low to None</td></tr>
                                <tr><td>6</td><td>K Available (kg/ha)</td><td>120 – 280</td><td>668.64</td><td>678.72</td><td>646.24</td><td>698.88</td><td>719.04</td><td>703.36</td><td>None</td></tr>
                                <tr><td>7</td><td>Calcium [cmol(p+)/kg]</td><td>2.00 – 4.00</td><td>6.30</td><td>-</td><td>-</td><td>5.56</td><td>-</td><td>-</td><td>Low</td></tr>
                                <tr><td>8</td><td>Mg [cmol(p+)/kg]</td><td>1.00 – 2.00</td><td>2.17</td><td>-</td><td>-</td><td>2.11</td><td>-</td><td>-</td><td>Low</td></tr>
                                <tr><td>9</td><td>S Available (ppm)</td><td>10.00 – 20.00</td><td>29.96</td><td>-</td><td>-</td><td>14.74</td><td>-</td><td>-</td><td>Low to Medium</td></tr>
                                <tr><td>10</td><td>Soil Max Water Holding Capacity (%)</td><td>20 – 50</td><td>46.12</td><td>-</td><td>-</td><td>43.10</td><td>-</td><td>-</td><td>-</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <h5 class="mt-4">Interpretations:</h5>
                    <p>Your probability of yield increase from fertilizers varies from <strong>Medium to None</strong>.</p>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6><strong>Analyzed & Reported by:</strong></h6>
                            <p>Akshay Bhardwaj<br>B.Sc. (Chemistry)</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <h6><strong>Approved by:</strong></h6>
                            <p>Dr. Brijesh Kamal<br>M.Sc., Ph.D. (Mycology & Plant Pathology)</p>
                        </div>
                    </div>

                    <hr>
                    <h6 class="mt-3 text-danger"><strong>Disclaimer:</strong></h6>
                    <p>
                        Results relate only to the sample received by Agri Clinic Solan and are representative only of that
                        sample. No warranty is given that these results relate to any other part of the field or area not
                        covered by the sample.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- jsPDF + html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
$(document).ready(function() {
    // ✅ Print only report area
    $('#printReport').click(function() {
        const printContent = document.getElementById('reportArea').innerHTML;
        const originalContent = document.body.innerHTML;
        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload(); // reload to restore page
    });

    // ✅ Download only report area as PDF
    $('#downloadPdf').click(function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('p', 'pt', 'a4');
        const report = document.querySelector("#reportArea");

        html2canvas(report, { scale: 2 }).then(canvas => {
            const imgData = canvas.toDataURL('image/png');
            const imgWidth = 595; // A4 width
            const pageHeight = 842; // A4 height
            const imgHeight = canvas.height * imgWidth / canvas.width;
            let heightLeft = imgHeight;
            let position = 0;

            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft > 0) {
                position = heightLeft - imgHeight;
                doc.addPage();
                doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }

            doc.save('Soil_Report.pdf');
        });
    });
});
</script>
@endpush
