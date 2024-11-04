@extends('layouts.base')
<!-- @section('title', 'Bill Recap (SOA)') -->
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 d-flex ms-auto">
            <div>
                <button class="btn bg-gradient-dark" type="button" id="dropdownImport" data-bs-toggle="dropdown" aria-expanded="false">
                    Import
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div id="form-new-bill-recap">
            <div class="card mb-4">
                <div class="card-header pb-4">
                    <h6>Form Bill Recap (SOA)</h6>
                    <p class="text-sm mb-0">
                        Fill out the new bill recap form below.
                    </p>
                </div>
                <div class="card-body px-4 pt-0 pb-0">
                    @if ($bill)
                    <form class="form" action="{{ url('bill_recap-update') }}" method="POST">
                        @csrf
                        <div class="form-bill-recap mb-4">
                            <input type="hidden" name="id" value="{{ $bill->id_bill_recap }}">
                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</label>
                                @if (count($customers) > 0)
                                <select class="form-control" name="id_customer" disabled>
                                    <option value="">Choose one..</option>
                                    @foreach ($customers as $c)
                                    <option value="{{ $c->id_customer }}" {{ old('id_customer', $seaShipment->id_customer) == $c->id_customer ? 'selected' : '' }}>{{ $c->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @else
                                <select class="form-control" name="id_customer" disabled>
                                    <option value="">No data available</option>
                                </select>
                                @endif
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Load Date</label>
                                <input type="date" name="load_date" class="form-control" value="{{ old('load_date', $seaShipment->etd) }}" disabled>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Inv</label>
                                <input type="text" name="no_inv" class="form-control" value="{{ old('no_inv', $bill->inv_no) }}" disabled>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Freight</label>
                                <input type="text" name="freight" class="form-control" value="{{ old('freight', $bill->freight_type) }}" disabled>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Units</label>
                                <input type="text" name="size" id="size" class="form-control" value="{{ old('size', $bill->size) }}" disabled>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Price</label>
                                <input type="text" name="unit_price" id="unit_price" class="form-control" 
                                value="{{ old('unit_price', 'Rp ' . number_format($bill->unit_price ?? 0, 0, ',', '.')) }}" disabled>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</label>
                                <input type="text" name="amount" id="amount" class="form-control" 
                                value="{{ old('amount', 'Rp ' . number_format($bill->amount ?? 0, 0, ',', '.')) }}" disabled>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Date</label>
                                <input type="date" name="payment_date" value="{{ old('payment_date', $bill->payment_date) }}" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Amount</label>
                                <input type="text" name="payment_amount" id="payment_amount" value="{{ old('payment_amount', $bill->payment_amount) }}" class="form-control">
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Remaining Bill</label>
                                <input type="text" name="remaining_bill" id="remaining_bill" value="{{ old('remaining_bill', $bill->remaining_bill) }}" class="form-control" readonly>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Overdue Bill</label>
                                <input type="date" name="overdue_bill" value="{{ old('overdue_bill', $bill->overdue_bill) }}" class="form-control">
                            </div>
                        </div>

                        <button type="submit" id="submitBtnBill" class="btn btn-primary btn-sm">Update</button>
                    </form>
                    @else
                    <form class="form" action="{{ url('bill_recap-store') }}" method="POST">
                        @csrf
                        <div class="form-bill-recap mb-4">
                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</label>
                                @if (count($customers) > 0)
                                <select class="form-control" name="id_customer" required>
                                    <option value="">Choose one..</option>
                                    @foreach ($customers as $c)
                                    <option value="{{ $c->id_customer }}" {{ old('id_customer') == $c->id_customer ? 'selected' : '' }}>{{ $c->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @else
                                <select class="form-control" name="id_customer" disabled>
                                    <option value="">No data available</option>
                                </select>
                                @endif
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Load Date</label>
                                <input type="date" name="load_date" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Inv</label>
                                <input type="text" name="no_inv" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Freight</label>
                                <select class="form-control" name="freight" required>
                                    <option value="">Choose one..</option>
                                    <option value="SIN BTH">SIN BTH</option>
                                    <option value="SIN JKT">SIN JKT</option>
                                    <option value="BTH JKT">BTH JKT</option>
                                </select>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Entry Date / BL</label>
                                <input type="date" name="entry_date" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Size (M3)</label>
                                <input type="text" name="size" id="size" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Price</label>
                                <input type="text" name="unit_price" id="unit_price" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</label>
                                <input type="text" name="amount" id="amount" class="form-control" readonly>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Date</label>
                                <input type="date" name="payment_date" class="form-control">
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Amount</label>
                                <input type="text" name="payment_amount" id="payment_amount" class="form-control">
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Remaining Bill</label>
                                <input type="text" name="remaining_bill" id="remaining_bill" class="form-control" readonly>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Overdue Bill</label>
                                <input type="date" name="overdue_bill" class="form-control">
                            </div>
                        </div>

                        <button type="submit" id="submitBtnBill" class="btn btn-primary btn-sm">Submit</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-bill-recap {
        display: flex;
        overflow-x: auto;
    }

    .input-group-static {
        margin-right: 10px;
    }
</style>

<script>
    const amountInput = document.getElementById('amount');
    const paymentAmountInput = document.getElementById('payment_amount');
    const remainingBillInput = document.getElementById('remaining_bill');

    paymentAmountInput.addEventListener('input', updateAmount);

    function updateAmount() {
        const paymentAmountValue = parseFloat(paymentAmountInput.value.replace(/Rp\s?|[.]/g, ''));

        if (!isNaN(paymentAmountValue)) {
            const convertFormattedAmount = parseFloat(amountInput.value.replace(/Rp\s?|[.]/g, ''));
            if (paymentAmountValue < convertFormattedAmount) {
                const remainingBill = convertFormattedAmount - paymentAmountValue;
                const formattedRemainingBill = new Intl.NumberFormat('id-ID', {
                    maximumFractionDigits: 0
                }).format(remainingBill);
                remainingBillInput.value = "Rp " + formattedRemainingBill;
                remainingBillInput.classList.remove('text-danger');

            } else if (paymentAmountValue == convertFormattedAmount) {
                remainingBillInput.value = '0';
                remainingBillInput.classList.remove('text-danger');

            } else {
                remainingBillInput.value = 'Overpayment';
                remainingBillInput.classList.add('text-danger');
                paymentAmountInput.value = '';
            }

        } else {
            remainingBillInput.value = '';
        }
    }

    // currency
    function formatCurrency(num) {
        num = num.toString().replace(/[^\d-]/g, '');

        num = num.replace(/-+/g, (match, offset) => offset > 0 ? "" : "-");

        let isNegative = false;
        if (num.startsWith("-")) {
            isNegative = true;
            num = num.slice(1);
        }

        let formattedNum = Math.abs(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        if (isNegative) {
            formattedNum = "-" + formattedNum;
        }

        return "Rp " + formattedNum;
    }

    document.addEventListener('DOMContentLoaded', function() {
        paymentAmountInput.value = formatCurrency(paymentAmountInput.value);
        remainingBillInput.value = formatCurrency(remainingBillInput.value);

        let inputPrices = document.querySelectorAll("#payment_amount");
        inputPrices.forEach(function(inputPrice) {
            inputPrice.addEventListener("input", function() {
                this.value = formatCurrency(this.value);
            });
        });

        // update remaining bill when page loads
        updateAmount();
    });
</script>
@endsection