@extends('layouts.base')
<!-- @section('title', 'Pricelists') -->
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 d-flex ms-auto">
            <div>
                <button class="btn bg-gradient-primary" type="button" data-bs-toggle="modal" data-bs-target="#pricelistNewModal">
                    New Pricelist
                </button>
            </div>
            <div>
                <button class="btn bg-gradient-dark ms-2" type="button" id="dropdownImport" data-bs-toggle="modal" data-bs-target="#pricelistModal">
                    Import
                </button>
            </div>
        </div>
    </div>

    <!-- Modal - Import Pricelists -->
    <div class="modal fade" id="pricelistModal" tabindex="-1" role="dialog" aria-labelledby="pricelistModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-md" id="pricelistModalLabel"><b>Import Pricelists</b></h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('import-pricelist') }}" method="POST" enctype="multipart/form-data">
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

    <!-- Modal - new Pricelist -->
    <div class="modal fade" id="pricelistNewModal" tabindex="-1" role="dialog" aria-labelledby="pricelistNewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-md" id="pricelistNewModalLabel"><b>New Pricelist</b></h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('pricelist-store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        @if (count($customers) > 0)
                            <div class="input-group input-group-static mb-2">
                                <label>Customer </label>
                            </div>
                            <div class="input-group input-group-static text-xs mb-4">
                                <select class="form-select select-cust" name="id_customer" multiple style="width: 100%;">
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
                                <select class="form-select select-shipper" name="id_shipper" multiple style="width: 100%;">
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
                            @if (count($origins) > 0)
                                <div class="input-group input-group-static">
                                    <label>Origin <span class="text-danger">*</span></label>
                                </div>
                                <div class="input-group input-group-static text-xs">
                                    <select class="form-select select-new-origin" name="id_origin" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;" required>
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
                            <label>Price <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="price" id="new-price" value="{{ old('price') }}" placeholder="..." required>
                        </div>

                        <div class="input-group input-group-static mb-1">
                            <label>Type <span class="text-danger">*</span></label>
                        </div>
                        <div class="input-group input-group-static mb-4">
                            <select class="form-select text-left" name="type" id="new-type" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;" required>
                                <option value="">...</option>
                                <option value="BASE PRICE BILL">BASE PRICE BILL</option>
                                <option value="DIFFERENCE BILL">DIFFERENCE BILL</option>
                            </select>
                        </div>

                        <div class="input-group input-group-static mb-4">
                            <div class="col-5">
                                <label>Start Period </label>
                                <input type="date" class="form-control start-period" name="start_period" value="{{ old('start_period') }}">
                            </div>
                            <div class="col-1"></div>
                            <div class="col-6">
                                <label>End Period </label>
                                <input type="date" class="form-control end-period" name="end_period" value="{{ old('end_period') }}">
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

    <!-- Modal - Edit Pricelist -->
    <div class="modal fade" id="pricelistEditModal" tabindex="-1" role="dialog" aria-labelledby="pricelistEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-md" id="pricelistEditModalLabel"><b>Edit Pricelist</b></h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('pricelist-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">

                        @if (count($customers) > 0)
                            <div class="input-group input-group-static mb-2">
                                <label>Customer </label>
                            </div>
                            <div class="input-group input-group-static text-xs mb-4">
                                <select class="form-select select-cust" id="customer" name="id_customer" multiple style="width: 100%;">
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
                                <select class="form-select select-shipper" id="shipper" name="id_shipper" multiple style="width: 100%;">
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
                            @if (count($origins) > 0)
                                <div class="input-group input-group-static">
                                    <label>Origin <span class="text-danger">*</span></label>
                                </div>
                                <div class="input-group input-group-static text-xs">
                                    <select class="form-select select-new-origin" id="origin" name="id_origin" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;" required>
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
                            <label>Price <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="price" name="price" value="{{ old('price') }}" placeholder="..." required>
                        </div>

                        <div class="input-group input-group-static mb-1">
                            <label>Type <span class="text-danger">*</span></label>
                        </div>
                        <div class="input-group input-group-static mb-4">
                            <select class="form-select text-left" name="type" id="type" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;" required>
                                <option value="">...</option>
                                <option value="BASE PRICE BILL">BASE PRICE BILL</option>
                                <option value="DIFFERENCE BILL">DIFFERENCE BILL</option>
                            </select>
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
                    <h6>List Pricelists</h6>
                    <p class="text-sm mb-0">
                        View all list of pricelists in the system.
                    </p>
                </div>
                @if (count($pricelists) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Origin</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Price</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Start Period</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">End Period</th>
                                    <th class="text-center text-uppercase text-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pricelists as $p)
                                <tr data-id="{{ $p->id_pricelist }}" data-id-customer="{{ $p->id_customer }}" data-id-shipper="{{ $p->id_shipper }}"
                                data-id-origin="{{ $p->id_origin }}" data-id-type="{{ $p->type }}">
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-sm font-weight-normal text-secondary mb-0">{{ $loop->iteration }}.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="customer-selected text-sm font-weight-normal mb-0">{{ $customer[$p->id_customer] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="shipper-selected text-sm font-weight-normal mb-0">{{ $shipper[$p->id_shipper] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="origin-selected text-sm font-weight-normal mb-0">{{ $origin[$p->id_origin] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="price-selected text-sm font-weight-normal mb-0">{{ 'Rp ' . number_format($p->price ?? 0, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="type-selected text-sm font-weight-normal mb-0">{{ $p->type ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if (!empty($p->start_period))
                                        <p class="start-period-selected text-sm font-weight-normal mb-0" data-start-period="{{ $p->start_period }}">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $p->start_period)->format('d-M-y') ?? '-' }}</p>
                                        @else
                                        <p class="start-period-selected text-sm font-weight-normal mb-0">-</p>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if (!empty($p->end_period))
                                        <p class="end-period-selected text-sm font-weight-normal mb-0" data-end-period="{{ $p->end_period }}">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $p->end_period)->format('d-M-y') ?? '-' }}</p>
                                        @else
                                        <p class="end-period-selected text-sm font-weight-normal mb-0">-</p>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="mx-4 edit-button" data-bs-toggle="modal" data-bs-target="#pricelistEditModal">
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

    document.addEventListener('DOMContentLoaded', function() {
        // select2
        function initializeSelect2() {
            var selectElementsCustomers = document.querySelectorAll('.select-cust');
            selectElementsCustomers.forEach(function(selectElement) {
                $(selectElement).select2({
                    placeholder: "Please choose..",
                    maximumSelectionLength: 1
                });
            });

            var selectElementsShippers = document.querySelectorAll('.select-shipper');
            selectElementsShippers.forEach(function(selectElement) {
                $(selectElement).select2({
                    placeholder: "Please choose..",
                    maximumSelectionLength: 1
                });
            });
        }

        initializeSelect2();

        var modal = document.getElementById('pricelistModal');
        modal.addEventListener('shown.bs.modal', function() {
            initializeSelect2();
        });

        let priceNewPricelist = document.querySelectorAll("#new-price");
        priceNewPricelist.forEach(function(newPrice) {
            newPrice.addEventListener("input", function() {
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
                var shipper = row.getAttribute("data-id-shipper");
                var origin = row.getAttribute("data-id-origin");
                var type = row.getAttribute("data-id-type");
                var price = row.querySelector(".price-selected").textContent.trim();

                const priceConvert = parseFloat(price);

                // Mengisi data ke dalam formulir
                document.getElementById("id").value = id;
                document.getElementById("origin").value = origin;
                document.getElementById("price").value = price;
                document.getElementById("type").value = type;

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

        let inputPrices = document.querySelectorAll("#price");
        inputPrices.forEach(function(inputPrice) {
            inputPrice.addEventListener("input", function() {
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