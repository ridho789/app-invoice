@extends('layouts.base')
<!-- @section('title', 'Customers') -->
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 d-flex ms-auto">
            <div>
                <button class="btn btn-icon bg-gradient-primary" id="btn-new-customer">
                    new customer
                </button>
            </div>
            <!-- <div>
                <button class="btn bg-gradient-dark ms-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Import
                </button>
            </div> -->
        </div>
    </div>

    <div class="row">
        <!-- alert error -->
        @if(session('error_type') == 'duplicate-alert')
        <div class="col-12" id="error-message" style="opacity: 1; transition: opacity 1s ease;">
            <div class="alert alert-danger text-white" role="alert">
                <strong>Error!</strong> {{ session('error') }}!
            </div>
        </div>
        @endif

        <div class="col-12">
            <!-- form new customer -->
            <div id="form-new-customer" style="display: none;">
                <div class="card mb-4">
                    <div class="card-header pb-4">
                        <h6>New Customer</h6>
                        <p class="text-sm mb-0">
                            Fill out the new customer form below.
                        </p>
                    </div>
                    <div class="card-body px-4 pt-0 pb-0">
                        <form action="{{ url('customer-store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4 mb-4">
                                    <div class="input-group input-group-static">
                                        <label>Enter a customer <span class="text-primary">*</span></label>
                                        <input type="text" name="customer" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>
                                <div class="col-lg-2 mb-4">
                                    <div class="input-group input-group-static">
                                        <label>Enter discount (<span class="text-info">2nd Invoice</span>)</label>
                                        <input type="text" name="discount" id="discount" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2 mb-4">
                                    <div class="input-group input-group-static text-xs">
                                        @if (count($companies) > 0)
                                            <label style="margin-left: -1px; margin-bottom: 11px;">Select company</label>
                                            <select class="form-control company" name="id_company" multiple style="width: 100%;">
                                                @foreach ($companies as $c)
                                                    <option value="{{ $c->id_company }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label style="margin-bottom: 4.5px;">Select company</label>
                                            <select class="form-control text-xs" disabled>
                                                <option value="">No data available</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-2 mb-4">
                                    <div class="input-group input-group-static text-xs">
                                        @if (count($bankers) > 0)
                                            <label style="margin-left: -1px; margin-bottom: 11px;">Select banker</label>
                                            <select class="form-control banker" name="id_banker" multiple style="width: 100%;">
                                                @foreach ($bankers as $b)
                                                    <option value="{{ $b->id_banker }}">{{ $b->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label style="margin-bottom: 4.5px;">Select banker</label>
                                            <select class="form-control text-xs" disabled>
                                                <option value="">No data available</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-2 mb-4">
                                    <div class="input-group input-group-static text-xs">
                                        @if (count($accounts) > 0)
                                            <label style="margin-left: -1px; margin-bottom: 11px;">Select account</label>
                                            <select class="form-control account" name="id_account" multiple style="width: 100%;">
                                                @foreach ($accounts as $a)
                                                    <option value="{{ $a->id_account }}">{{ $a->account_no }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label style="margin-bottom: 4.5px;">Select account</label>
                                            <select class="form-control text-xs" disabled>
                                                <option value="">No data available</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <div class="input-group input-group-static text-xs">
                                        @if (count($shippers) > 0)
                                            <label style="margin-left: -1px; margin-bottom: 11px;">Select shipper</label>
                                            <select class="form-control select2" name="id_shipper[]" multiple style="width: 100%;">
                                                @foreach ($shippers as $s)
                                                    <option value="{{ $s->id_shipper }}" {{ (is_array(old('id_shipper')) && in_array($s->id_shipper, old('id_shipper'))) ? 'selected' : '' }}>{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label style="margin-bottom: 4.5px;">Select shipper</label>
                                            <select class="form-control text-xs" disabled>
                                                <option value="">No data available</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="form-check form-check-inline" style="padding-left: 0;">
                                        <input type="hidden" id="is-bill-weight-hidden" name="input_is_bill_weight" value="0">
                                        <input class="form-check-input" type="checkbox" id="isBillWeight" 
                                        onclick="document.getElementById('is-bill-weight-hidden').value = this.checked ? 1 : 0;">
                                        <label class="form-check-label" for="isBillWeight">Click to enable weighted billing in invoice printing</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- form edit customer -->
            <div class="col-12" id="form-edit-customer" style="display: none;">
                <div class="card mb-4">
                    <div class="card-header pb-4">
                        <h6>Edit Customer</h6>
                        <p class="text-sm mb-0">
                            Fill out the edit customer form below.
                        </p>
                    </div>
                    <div class="card-body px-4 pt-0 pb-0">
                        <form action="{{ url('customer-update') }}" method="POST">
                            @csrf
                            <input type="hidden" id="edit-id" name="id">
                            <div class="row">
                                <div class="col-lg-4 mb-4">
                                    <div class="input-group input-group-static">
                                        <label>Enter a customer <span class="text-primary">*</span></label>
                                        <input type="text" name="customer" id="edit-customer" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>
                                <div class="col-lg-2 mb-4">
                                    <div class="input-group input-group-static">
                                        <label>Enter discount (<span class="text-info">2nd Invoice</span>)</label>
                                        <input type="text" name="discount" id="edit-discount" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-2 mb-4">
                                    <div class="input-group input-group-static text-xs">
                                        @if (count($companies) > 0)
                                            <label style="margin-left: -1px; margin-bottom: 11px;">Select company</label>
                                            <select class="form-control company" name="id_company" id="edit-company" multiple style="width: 100%;">
                                                @foreach ($companies as $c)
                                                    <option value="{{ $c->id_company }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label style="margin-bottom: 4.5px;">Select company</label>
                                            <select class="form-control" disabled>
                                                <option value="">No data available</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-2 mb-4">
                                    <div class="input-group input-group-static text-xs">
                                        @if (count($bankers) > 0)
                                            <label style="margin-left: -1px; margin-bottom: 11px;">Select banker</label>
                                            <select class="form-control banker" name="id_banker" id="edit-banker" multiple style="width: 100%;">
                                                @foreach ($bankers as $b)
                                                    <option value="{{ $b->id_banker }}">{{ $b->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label style="margin-bottom: 4.5px;">Select banker</label>
                                            <select class="form-control text-xs" disabled>
                                                <option value="">No data available</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-2 mb-4">
                                    <div class="input-group input-group-static text-xs">
                                        @if (count($accounts) > 0)
                                            <label style="margin-left: -1px; margin-bottom: 11px;">Select account</label>
                                            <select class="form-control account" name="id_account" id="edit-account" multiple style="width: 100%;">
                                                @foreach ($accounts as $a)
                                                    <option value="{{ $a->id_account }}">{{ $a->account_no }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label style="margin-bottom: 4.5px;">Select account</label>
                                            <select class="form-control text-xs" disabled>
                                                <option value="">No data available</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-4">
                                    <div class="input-group input-group-static text-xs">
                                        @if (count($shippers) > 0)
                                            <label style="margin-left: -1px; margin-bottom: 12px;">Select shipper</label>
                                            <select class="form-control select2" name="id_shipper[]" multiple style="width: 100%;" id="edit-shipper">
                                                @foreach ($shippers as $s)
                                                    <option value="{{ $s->id_shipper }}">{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <label style="margin-bottom: 4.5px;">Select shipper</label>
                                            <select class="form-control" disabled>
                                                <option value="">No data available</option>
                                            </select>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <div class="form-check form-check-inline" style="padding-left: 0;">
                                        <input type="hidden" id="edit-is-bill-weight-hidden" name="value_is_bill_weight">
                                        <input class="form-check-input" type="checkbox" id="editIsBillWeight">
                                        <label class="form-check-label" for="editIsBillWeight">Click to enable weighted billing in invoice printing</label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header pb-5">
                    <h6>List Customers</h6>
                    <p class="text-sm mb-0">
                        View all list of customers in the system.
                    </p>
                </div>
                @if (count($customers) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Company</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Banker</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Account</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Setup</th>
                                    <th class="text-center text-uppercase text-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $c)
                                <tr data-id="{{ $c->id_customer }}" data-id-company="{{ $c->id_company }}" data-shipper="{{ implode(',', explode(',', $c->shipper_ids)) }}"
                                data-id-banker="{{ $c->id_banker }}" data-id-account="{{ $c->id_account }}">
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-sm font-weight-normal text-secondary mb-0">{{ $loop->iteration }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="name-customer-selected">
                                        @if ($c->discount && $c->discount > 0)
                                            <p class="text-sm font-weight-normal text-primary mb-0">{{ $c->name }}</p>
                                        @else
                                            <p class="text-sm font-weight-normal mb-0">{{ $c->name }}</p>
                                        @endif
                                    </td>
                                    <td class="shipper-selected align-middle text-center text-sm">
                                        @php
                                            $shipperNamesString = null;
                                            if ($c->shipper_ids) {
                                                $shipperIds = explode(',', $c->shipper_ids);
                                                $shipperNames = [];
    
                                                foreach ($shipperIds as $shipperId) {
                                                    // Periksa apakah shipperId ada dalam array $shipperName sebelum menambahkannya ke $shipperNames
                                                    if (isset($shipperName[$shipperId])) {
                                                        $shipperNames[] = $shipperName[$shipperId];
                                                    }
                                                }
    
                                                $shipperNamesString = implode(', ', $shipperNames);
                                            }
                                        @endphp

                                        <p class="text-sm font-weight-normal mb-0">{{ $shipperNamesString ?? '-' }}</p>
                                    </td>
                                    <td class="company-selected align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $companyName[$c->id_company] ?? '-' }}</p>
                                    </td>
                                    <td class="banker-selected align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $bankerName[$c->id_banker] ?? '-' }}</p>
                                    </td>
                                    <td class="account-selected align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $accountNo[$c->id_account] ?? '-' }}</p>
                                    </td>
                                    <td class="calign-middle text-center text-sm">
                                        @if ($c->is_bill_weight)
                                            <p class="text-sm font-weight-normal mb-0">Heavy Billing</p>
                                        @else
                                            <p class="text-sm font-weight-normal mb-0">-</p>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="mx-4 btn-edit-customer" id="btn-edit-customer">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                    </td>
                                    <td style="display: none;" class="discount-selected">{{ 'Rp ' . number_format(floatval($c->discount ?? 0), 0, ',', '.') ?? '-' }}</td>
                                    <td style="display: none;" class="bill-weight-selected">{{ $c->is_bill_weight ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="card-body px-0 pt-0 pb-0">
                    <div class="d-flex justify-content-center mb-3">
                        <span class="text-xs mb-3"><i>No available data to display..</i></span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<script>
    // multi select
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "Please choose.."
        });

        $('.company').select2({
            placeholder: "Please choose..",
            maximumSelectionLength: 1
        });

        $('.banker').select2({
            placeholder: "Please choose..",
            maximumSelectionLength: 1
        });

        $('.account').select2({
            placeholder: "Please choose..",
            maximumSelectionLength: 1
        });
    });

    setTimeout(function() {
        var errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.opacity = '0';
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 1000);
        }
    }, 3500);

    function formatCurrency(num) {
        num = num.toString().replace(/[^\d-]/g, '');

        num = num.replace(/-+/g, (match, offset) => offset > 0 ? "" : "-");

        let isNegative = false;
        if (num.startsWith("-")) {
            isNegative = true;
            num = num.slice(1);
        }

        let formattedNum = "Rp " + Math.abs(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        if (isNegative) {
            formattedNum = "-" + formattedNum;
        }

        return formattedNum;
    }

    document.addEventListener("DOMContentLoaded", function() {
        const toggleFormButton = document.getElementById('btn-new-customer');
        const myForm = document.getElementById('form-new-customer');

        toggleFormButton.addEventListener('click', function() {
            if (myForm.style.display === 'none') {
                myForm.style.display = 'block';
            }

            if (myEditForm.style.display === 'block') {
                myEditForm.style.display = 'none';
            }
        });

        const myEditForm = document.getElementById('form-edit-customer');
        var editButtons = document.querySelectorAll(".btn-edit-customer");

        editButtons.forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();

                var row = this.closest("tr");
                var id = row.getAttribute("data-id");
                var customer = row.querySelector(".name-customer-selected").textContent;
                var discount = row.querySelector(".discount-selected").textContent;
                var company = row.getAttribute("data-id-company");
                var banker = row.getAttribute("data-id-banker");
                var account = row.getAttribute("data-id-account");
                var shipperIds = row.getAttribute("data-shipper").split(',');
                $('#edit-shipper').val(shipperIds).trigger('change');

                if (shipperIds.length > 0) {
                    var selectElement = document.getElementById("edit-shipper");
                    selectElement.querySelectorAll('option').forEach(function(option) {
                        if (shipperIds.includes(option.value)) {
                            option.setAttribute('selected', 'selected');
                        } else {
                            option.removeAttribute('selected');
                        }
                    });
                }

                document.getElementById("edit-id").value = id;
                document.getElementById("edit-customer").value = customer.trim();
                document.getElementById("edit-discount").value = discount.trim();

                $("#edit-company").val(company);
                $("#edit-company").select2({
                    placeholder: "Please choose..",
                    maximumSelectionLength: 1
                });

                $("#edit-banker").val(banker);
                $("#edit-banker").select2({
                    placeholder: "Please choose..",
                    maximumSelectionLength: 1
                });

                $("#edit-account").val(account);
                $("#edit-account").select2({
                    placeholder: "Please choose..",
                    maximumSelectionLength: 1
                });

                // Is bill weight
                var billWeight = row.querySelector(".bill-weight-selected").textContent;
                var isDBillWeightCheckboxEditForm = document.getElementById('editIsBillWeight');
                var hiddenEditValueBillWeight = document.querySelector("input[name='value_is_bill_weight']");
                isDBillWeightCheckboxEditForm.checked = parseInt(billWeight) === 1;

                if (hiddenEditValueBillWeight) {
                    hiddenEditValueBillWeight.value = billWeight;
                }

                if (myEditForm.style.display === 'none') {
                    myEditForm.style.display = 'block';
                }

                if (myForm.style.display === 'block') {
                    myForm.style.display = 'none';
                }
            });
        });

        // Input discount
        let priceDiscount = document.querySelectorAll("#discount");
        priceDiscount.forEach(function(discount) {
            discount.addEventListener("input", function() {
                this.value = formatCurrency(this.value);
            });
        });

        // Edit discount
        let editDiscounts = document.querySelectorAll("#edit-discount");
        editDiscounts.forEach(function(editDiscount) {
            editDiscount.addEventListener("input", function() {
                this.value = formatCurrency(this.value);
            });
        });

        // Elemen checkbox form add
        var isBillWeightCheckbox = document.getElementById('isBillWeight');
        isBillWeightCheckbox.addEventListener('click', function () {
            var isBillWeight = isBillWeightCheckbox.checked ? 1 : 0;
            var hiddenValueBillWeight = document.querySelector("input[name='input_is_bill_weight']");
            hiddenValueBillWeight.value = isBillWeight;
        });

        // Elemen checkbox form edit
        var isBillWeightCheckboxEdit = document.getElementById('editIsBillWeight');
        isBillWeightCheckboxEdit.addEventListener('click', function () {
            var isBillWeightEdit = isBillWeightCheckboxEdit.checked ? 1 : 0;
            
            // Setel nilai checkbox ke input tersembunyi
            var hiddenEditValueBillWeight = document.querySelector("input[name='value_is_bill_weight']");
            hiddenEditValueBillWeight.value = isBillWeightEdit;
        });
    });
</script>
@endsection