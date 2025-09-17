@extends('layouts.app')

@section('content')
    <div class="content-wrapper pt-4">
        <section class="content">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-map-marked-alt"></i> Payment </h3>
                    </div>
                    <div class="card-body">

                        <h3>Samples </h3>
                        <form action="{{ route('payments.confirm', $id) }}" method="POST" id="checkoutForm">
                            @csrf
                            <table border="1" style="width:100%" class="datatable table table-striped table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Select</th>
                                        <th scope="col">Sample ID</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Parameters</th>
                                        <th scope="col">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sample as $s)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="samples[]" value="{{ $s->id }}"
                                                    class="sampleCheck" checked data-amount="{{ $s->amount }}">
                                            </td>
                                            <td>{{ $s->id }}</td>
                                            <td>{{ $s->sample_type }}</td>
                                            <td>{{ implode(', ', $s->parameters) }}</td>
                                            <td>{{ $s->amount }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <h4>Total: ₹<span id="totalAmount">{{ $totalAmount }}</span></h4>
                            <input type="hidden" name="amount" id="amountInput" value="{{ $totalAmount }}">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> Payment Mode</label>
                                        <select name="mode" id="mode" class="form-control" required>
                                            <option value="">Select Mode</option>
                                            <option value="cash">Cash</option>
                                            <option value="online">Online</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="cash_fields" style="display: none;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="to">Cash Given To:</label>
                                            <select id="to" name="to" class="form-control">
                                                <option value="select" disabled selected>Select</option>
                                                <option value="field_agent">Field Agent</option>
                                                <option value="front_desk">Front Desk</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div id="online_fields" style="display: none;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="transaction_id">Transaction ID:</label>
                                            <input type="text" id="transaction_id" name="transaction_id"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                             <div class="card-footer text-right">
                                <button id="confirmPayBtn" type="submit" class="btn btn-success">
                                    <i class="fas fa-save"></i> Confirm Payment
                                </button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentModeSelect = document.getElementById('mode');
            const onlineFields = document.getElementById('online_fields');
            const cashFields = document.getElementById('cash_fields');
            const totalAmountSpan = document.getElementById('totalAmount');
            const amountInput = document.getElementById('amountInput');
            const payBtn = document.getElementById('confirmPayBtn');
            const form = document.getElementById('checkoutForm');

            // toggle payment fields
            paymentModeSelect.addEventListener('change', function() {
                cashFields.style.display = (this.value === 'cash') ? 'block' : 'none';
                onlineFields.style.display = (this.value === 'online') ? 'block' : 'none';
            });

            // update total
            function updateTotal() {
                let total = 0;
                document.querySelectorAll('.sampleCheck:checked').forEach(chk => {
                    total += parseFloat(chk.dataset.amount);
                });
                totalAmountSpan.textContent = total.toFixed(2);
                amountInput.value = total.toFixed(2);

                // disable if total = 0
                payBtn.disabled = (total === 0);
            }

            // add listeners
            document.querySelectorAll('.sampleCheck').forEach(chk => {
                chk.addEventListener('change', updateTotal);
            });

            // validate on submit
            form.addEventListener('submit', function(e) {
                if (parseFloat(amountInput.value) === 0) {
                    e.preventDefault();
                    alert('Total amount must be greater than 0 to proceed with payment.');
                }
            });

            // initial calculation
            updateTotal();
        });
    </script>
@endsection
