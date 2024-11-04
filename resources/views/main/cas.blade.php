@extends('layouts.base')
<!-- @section('title', 'Cas') -->
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 d-flex ms-auto">
            <div>
                <button class="btn bg-gradient-primary" type="button" data-bs-toggle="modal" data-bs-target="#casNewModal">
                    New Cas
                </button>
            </div>
            <div>
                <button class="btn bg-gradient-dark  ms-2" type="button" data-bs-toggle="modal" data-bs-target="#casModal">
                    Import
                </button>
            </div>
        </div>
    </div>

    <!-- Modal - Import Cas -->
    <div class="modal fade" id="casModal" tabindex="-1" role="dialog" aria-labelledby="casModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-md" id="casModalLabel"><b>Import Cas</b></h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('import-cas') }}" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="basic-form custom_file_input">
                            @csrf
                            <input class="form-control" type="file" name="file" required>
                            @error('file')
                            <div class="text-danger text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary btn-md" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn bg-gradient-primary btn-md">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal - Create New Cas -->
    <div class="modal fade" id="casNewModal" tabindex="-1" role="dialog" aria-labelledby="casNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-md" id="casNewModalLabel"><b>New Cas</b></h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('cas-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        @if (count($customers) > 0)
                            <div class="input-group input-group-static mb-2">
                                <label>Customer </label>
                            </div>
                            <div class="input-group input-group-static text-xs mb-4">
                                <select class="form-select select-new-cust" name="id_customer" multiple style="width: 100%;">
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->id_customer }}" data-shipper-ids="{{ $c->shipper_ids }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="input-group input-group-static mb-2">
                                <label>Customer </label>
                            </div>
                            <div class="input-group input-group-static text-xs mb-4">
                                <select class="form-control" disabled>
                                    <option value="">No data available</option>
                                </select>
                            </div>
                        @endif

                        @if (count($shippers) > 0)
                            <div class="input-group input-group-static mb-2">
                                <label>Shipper </label>
                            </div>
                            <div class="input-group input-group-static text-xs mb-4">
                                <select class="form-select select-new-shipper" name="id_shipper" multiple style="width: 100%;">
                                    @foreach ($shippers as $s)
                                        <option value="{{ $s->id_shipper }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="input-group input-group-static mb-2">
                                <label>Shipper </label>
                            </div>
                            <div class="input-group input-group-static text-xs mb-4">
                                <select class="form-control" disabled>
                                    <option value="">No data available</option>
                                </select>
                            </div>
                        @endif
                        
                        <div class="input-group input-group-static mb-4">
                            <div class="col-5">
                                <label>LTS <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="new-lts" name="new_lts" value="{{ old('new-lts') }}" oninput="this.value = this.value.toUpperCase()" placeholder="..." required>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-6">
                                <label>Charge <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="new-charge" name="new_charge" value="{{ old('new-charge') }}" placeholder="..." required>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            @if (count($origins) > 0)
                                <div class="input-group input-group-static">
                                    <label>Origin <span class="text-danger">*</span></label>
                                </div>
                                <div class="input-group input-group-static text-xs">
                                    <select class="form-select select-new-origin" id="new_id_origin" name="id_origin" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;" required>
                                        <option value="">...</option>
                                        @foreach ($origins as $o)
                                            <option value="{{ $o->id_origin }}">{{ $o->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="input-group input-group-static">
                                    <label>Origin</label>
                                </div>
                                <div class="input-group input-group-static text-xs">
                                    <select class="form-control" disabled>
                                        <option value="">No data available</option>
                                    </select>
                                </div>
                            @endif
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <div class="col-5">
                                @if (count($units) > 0)
                                    <div class="input-group input-group-static">
                                        <label>Unit </label>
                                    </div>
                                    <div class="input-group input-group-static text-xs">
                                        <select class="form-select select-new-unit" id="new_id_unit" name="id_unit" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                            <option value="">...</option>
                                            @foreach ($units as $u)
                                                <option value="{{ $u->id_unit }}">{{ $u->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="input-group input-group-static">
                                        <label>Unit </label>
                                    </div>
                                    <div class="input-group input-group-static text-xs">
                                        <select class="form-control" disabled>
                                            <option value="">No data available</option>
                                        </select>
                                    </div>
                                @endif
                            </div>
                            <div class="col-1"></div>
                            <div class="col-6">
                                <label style="margin-bottom: 1.25px;">Desc </label>
                                <input type="text" class="form-control" id="new-desc" name="new_desc" value="{{ old('new-desc') }}" placeholder="...">
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <div class="col-5">
                                <label>Start Period </label>
                                <input type="date" class="form-control start-period" id="new_start_period" name="new_start_period" value="{{ old('new_start_period') }}">
                            </div>
                            <div class="col-1"></div>
                            <div class="col-6">
                                <label>End Period </label>
                                <input type="date" class="form-control end-period" id="new_end_period" name="new_end_period" value="{{ old('new_end_period') }}">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn bg-gradient-secondary btn-md" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary btn-md ms-1">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal - Edit Cas -->
    <div class="modal fade" id="casEditModal" tabindex="-1" role="dialog" aria-labelledby="casEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-md" id="casEditModalLabel"><b>Edit Cas</b></h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('cas-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">

                        @if (count($customers) > 0)
                            <div class="input-group input-group-static mb-1">
                                <label>Customer </label>
                            </div>
                            <div class="input-group input-group-static text-xs mb-4">
                                <select class="form-select select-new-cust" id="customer" name="id_customer" multiple style="width: 100%;">
                                    @foreach ($customers as $c)
                                        <option value="{{ $c->id_customer }}" data-shipper-ids="{{ $c->shipper_ids }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="input-group input-group-static mb-1">
                                <label>Customer </label>
                            </div>
                            <div class="input-group input-group-static text-xs mb-4">
                                <select class="form-control" disabled>
                                    <option value="">No data available</option>
                                </select>
                            </div>
                        @endif

                        @if (count($shippers) > 0)
                            <div class="input-group input-group-static mb-1">
                                <label>Shipper </label>
                            </div>
                            <div class="input-group input-group-static text-xs mb-4">
                                <select class="form-select select-new-shipper" id="shipper" name="id_shipper" multiple style="width: 100%;">
                                    @foreach ($shippers as $s)
                                        <option value="{{ $s->id_shipper }}">{{ $s->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="input-group input-group-static mb-1">
                                <label>Shipper </label>
                            </div>
                            <div class="input-group input-group-static text-xs mb-4">
                                <select class="form-control" disabled>
                                    <option value="">No data available</option>
                                </select>
                            </div>
                        @endif
                        
                        <div class="input-group input-group-static mb-4">
                            <div class="col-5">
                                <label>LTS <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lts" name="lts" value="{{ old('lts') }}" oninput="this.value = this.value.toUpperCase()" placeholder="..." required>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-6">
                                <label>Charge <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="charge" name="charge" value="{{ old('charge') }}" placeholder="..." required>
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            @if (count($origins) > 0)
                                <div class="input-group input-group-static">
                                    <label>Origin <span class="text-danger">*</span></label>
                                </div>
                                <div class="input-group input-group-static text-xs">
                                    <select class="form-select select-new-origin" id="id_origin" name="id_origin" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;" required>
                                        <option value="">...</option>
                                        @foreach ($origins as $o)
                                            <option value="{{ $o->id_origin }}">{{ $o->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="input-group input-group-static">
                                    <label>Origin</label>
                                </div>
                                <div class="input-group input-group-static text-xs">
                                    <select class="form-control" disabled>
                                        <option value="">No data available</option>
                                    </select>
                                </div>
                            @endif
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <div class="col-5">
                                @if (count($units) > 0)
                                    <div class="input-group input-group-static">
                                        <label>Unit </label>
                                    </div>
                                    <div class="input-group input-group-static text-xs">
                                        <select class="form-select select-new-unit" id="id_unit" name="id_unit" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                            <option value="">...</option>
                                            @foreach ($units as $u)
                                                <option value="{{ $u->id_unit }}">{{ $u->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="input-group input-group-static">
                                        <label>Unit </label>
                                    </div>
                                    <div class="input-group input-group-static text-xs">
                                        <select class="form-control" disabled>
                                            <option value="">No data available</option>
                                        </select>
                                    </div>
                                @endif
                            </div>
                            <div class="col-1"></div>
                            <div class="col-6">
                                <label style="margin-bottom: 1.25px;">Desc </label>
                                <input type="text" class="form-control" id="desc" name="desc" value="{{ old('desc') }}" placeholder="...">
                            </div>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <div class="col-5">
                                <label>Start Period </label>
                                <input type="date" class="form-control start-period" id="start_period" name="start_period" value="{{ old('start_period') }}">
                            </div>
                            <div class="col-1"></div>
                            <div class="col-6">
                                <label>End Period </label>
                                <input type="date" class="form-control end-period" id="end_period" name="end_period" value="{{ old('end_period') }}">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn bg-gradient-secondary btn-md" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn bg-gradient-primary btn-md ms-1">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if(session()->has('logErrors'))
    <div class="row">
        <div class="col-md-12 mb-4" style="max-height: 350px; overflow-y: auto;">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title text-sm text-danger">Error Log</h5>
                    @if(is_array(session('logErrors')))
                    @foreach(session('logErrors') as $logError)
                    {{ $logError }} <br>
                    @endforeach
                    @else
                    {{ session('logErrors') }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-5">
                    <h6>List Cas</h6>
                    <p class="text-sm mb-0">
                        View all list of cas in the system.
                    </p>
                </div>
                @if (count($cas) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lts</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Charge</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Origin</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Desc</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Start Period</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">End Period</th>
                                    <th class="text-center text-uppercase text-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cas as $c)
                                <tr data-id="{{ $c->id_cas }}" data-id-customer="{{ $c->id_customer }}" data-id-shipper="{{ $c->id_shipper }}" data-id-unit="{{ $c->id_unit }}" 
                                data-id-origin="{{ $c->id_origin }}">
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-sm font-weight-normal text-secondary mb-0">{{ $loop->iteration }}.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="customer-selected text-sm font-weight-normal mb-0">{{ $customer[$c->id_customer] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="shipper-selected text-sm font-weight-normal mb-0">{{ $shipper[$c->id_shipper] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="lts-selected text-sm font-weight-normal mb-0">{{ $c->lts ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="charge-selected text-sm font-weight-normal mb-0">{{ 'Rp ' . number_format($c->charge ?? 0, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="origin-selected text-sm font-weight-normal mb-0">{{ $origin[$c->id_origin] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="unit-selected text-sm font-weight-normal mb-0">{{ $unit[$c->id_unit] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="desc-selected text-sm font-weight-normal mb-0">{{ $c->desc ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if (!empty($c->start_period))
                                        <p class="start-period-selected text-sm font-weight-normal mb-0" data-start-period="{{ $c->start_period }}">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $c->start_period)->format('d-M-y') ?? '-' }}</p>
                                        @else
                                        <p class="start-period-selected text-sm font-weight-normal mb-0">-</p>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if (!empty($c->end_period))
                                        <p class="end-period-selected text-sm font-weight-normal mb-0" data-end-period="{{ $c->end_period }}">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $c->end_period)->format('d-M-y') ?? '-' }}</p>
                                        @else
                                        <p class="end-period-selected text-sm font-weight-normal mb-0">-</p>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="mx-4 edit-button" data-bs-toggle="modal" data-bs-target="#casEditModal">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                    </td>
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
@endsection

<script>
    // Mengikat event pada elemen di atas modal untuk menangani perubahan pada elemen .select-new-cust
    document.addEventListener('change', function(event) {
        var targetElement = event.target;
        if (targetElement.classList.contains('select-new-cust')) {
            var selectedCustomerId = targetElement.value;
            var selectedCustomerShipperIds = targetElement.options[targetElement.selectedIndex].getAttribute('data-shipper-ids');

            var selectShipper = document.querySelector('.select-new-shipper');
            var options = selectShipper.querySelectorAll('option');
            selectShipper.value = null;
            options.forEach(function(option) {
                option.disabled = true;
            });

            if (selectedCustomerId === "") {
                options.forEach(function(option) {
                    option.disabled = false;
                });

            } else if (selectedCustomerShipperIds) {
                if (typeof selectedCustomerShipperIds === 'string') {
                    var shipperIdsArray = selectedCustomerShipperIds.split(',');
                    shipperIdsArray.forEach(function(value) {
                        var shipperName = selectShipper.querySelector('option[value="' + value + '"]').textContent;
                        var existingOption = selectShipper.querySelector('option[value="' + value + '"]');
                        if (existingOption) {
                            existingOption.disabled = false;
                        }
                    });

                } else {
                    var shipperId = selectedCustomerShipperIds;
                    var shipperName = selectShipper.querySelector('option[value="' + shipperId + '"]').textContent;
                    var existingOption = selectShipper.querySelector('option[value="' + shipperId + '"]');
                    if (existingOption) {
                        existingOption.disabled = false;
                    }
                }
            }
        }
    });

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

    // Check LTS
    function checkLTS() {
        // Modal add cas
        const ltsInput = document.getElementById('new-lts');
        const unitSelect = document.getElementById('new_id_unit');

        // Modal edit cas
        const ltsEditInput = document.getElementById('lts');
        const unitEditSelect = document.getElementById('id_unit');

        const requiredValues = ['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM'];

        ltsInput.addEventListener('change', function () {
            if (requiredValues.includes(ltsInput.value)) {
                unitSelect.setAttribute('required', 'required');
            } else {
                unitSelect.removeAttribute('required');
            }
        });

        ltsEditInput.addEventListener('change', function () {
            if (requiredValues.includes(ltsEditInput.value)) {
                unitEditSelect.setAttribute('required', 'required');
            } else {
                unitEditSelect.removeAttribute('required');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // select2
        function initializeSelect2() {
            var selectElementsCustomers = document.querySelectorAll('.select-new-cust');
            selectElementsCustomers.forEach(function(selectElement) {
                $(selectElement).select2({
                    placeholder: "Please choose..",
                    maximumSelectionLength: 1
                });
            });

            var selectElementsShippers = document.querySelectorAll('.select-new-shipper');
            selectElementsShippers.forEach(function(selectElement) {
                $(selectElement).select2({
                    placeholder: "Please choose..",
                    maximumSelectionLength: 1
                });
            });
        }

        initializeSelect2();

        var modal = document.getElementById('casNewModal');
        modal.addEventListener('shown.bs.modal', function() {
            initializeSelect2();
            checkLTS();
        });

        var modalEdit = document.getElementById('casEditModal');
        modalEdit.addEventListener('shown.bs.modal', function() {
            checkLTS();
        });
        
        let chargeNewCas = document.querySelectorAll("#new-charge");
        chargeNewCas.forEach(function(newCharge) {
            newCharge.addEventListener("input", function() {
                this.value = formatCurrency(this.value);
            });
        });

        var editButtons = document.querySelectorAll(".edit-button");
        editButtons.forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();

                var row = this.closest("tr");
                var id = row.getAttribute("data-id");
                var customer = row.getAttribute("data-id-customer");
                var unit = row.getAttribute("data-id-unit");
                var shipper = row.getAttribute("data-id-shipper");
                var origin = row.getAttribute("data-id-origin");
                var lts = row.querySelector(".lts-selected").textContent;
                var charge = row.querySelector(".charge-selected").textContent.trim();
                var desc = row.querySelector(".desc-selected").textContent;

                const chargeConvert = parseFloat(charge);

                // Mengisi data ke dalam formulir
                document.getElementById("id").value = id;
                document.getElementById("lts").value = lts;
                document.getElementById("charge").value = charge;
                document.getElementById("id_origin").value = origin;
                document.getElementById("id_unit").value = unit;

                $("#customer").val(customer);
                $("#customer").select2({
                    placeholder: "Please choose..",
                    maximumSelectionLength: 1
                });

                $("#shipper").val(shipper);
                $("#shipper").select2({
                    placeholder: "Please choose..",
                    maximumSelectionLength: 1
                });

                if (desc && desc != '-') {
                    document.getElementById("desc").value = desc;
                }
                
                var startPeriodElement = row.querySelector(".start-period-selected");
                if (startPeriodElement.hasAttribute("data-start-period")) {
                    var startPeriod = row.querySelector(".start-period-selected").getAttribute("data-start-period").trim();
                    document.getElementById("start_period").value = startPeriod;

                } else {
                    document.getElementById("start_period").value = null;
                }
                
                var endPeriodElement = row.querySelector(".end-period-selected");
                if (endPeriodElement.hasAttribute("data-end-period")) {
                    var endPeriod = row.querySelector(".end-period-selected").getAttribute("data-end-period").trim();
                    document.getElementById("end_period").value = endPeriod;

                } else {
                    document.getElementById("end_period").value = null;
                }
            });
        });

        let inputCharges = document.querySelectorAll("#charge");
        inputCharges.forEach(function(inputCharge) {
            inputCharge.addEventListener("input", function() {
                this.value = formatCurrency(this.value);
            });
        });

        // Start Period - End Period
        var startPeriods = document.getElementsByClassName('start-period');
        var endPeriods = document.getElementsByClassName('end-period');

        for (let i = 0; i < startPeriods.length; i++) {
            let startPeriod = startPeriods[i];
            let endPeriod = endPeriods[i];

            startPeriod.addEventListener('change', function () {
                if (startPeriod.value) {
                    endPeriod.min = startPeriod.value;
                } else {
                    endPeriod.removeAttribute('min');
                }
            });

            endPeriod.addEventListener('change', function () {
                if (endPeriod.value && startPeriod.value && endPeriod.value < startPeriod.value) {
                    endPeriod.value = startPeriod.value;
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'End Period cannot be earlier than Start Period',
                        position: 'top-end',
                        width: '300px',
                        toast: true,
                        showConfirmButton: false,
                        timer: 3500,
                        timerProgressBar: true,
                        customClass: {
                            container: 'swal2-top-end-container'
                        }
                    });
                }
            });
        }
    });
</script>