@extends('layouts.base')
<!-- @section('title', 'Insurances') -->
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 d-flex ms-auto">
            <div>
                <button class="btn bg-gradient-dark" type="button" id="dropdownImport" data-bs-toggle="modal" data-bs-target="#insuranceModal">
                    Import
                </button>
            </div>
        </div>
    </div>

    <!-- Modal - Import Insurances -->
    <div class="modal fade" id="insuranceModal" tabindex="-1" role="dialog" aria-labelledby="insuranceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-md" id="insuranceModalLabel"><b>Import Insurances</b></h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('import-insurances') }}" method="POST" enctype="multipart/form-data">
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

    <!-- Modal - Edit Insurances -->
    <div class="modal fade" id="insuranceEditModal" tabindex="-1" role="dialog" aria-labelledby="insuranceEditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-md" id="insuranceEditModalLabel"><b>Edit Insurance</b></h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('insurance-update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id">
                        <div class="input-group input-group-static mb-4">
                            <label>Marking</label>
                            <input type="text" class="form-control" id="marking" name="marking" value="{{ old('marking') }}" disabled>
                        </div>
                        <div class="input-group input-group-static mb-4">
                            <label>Charge</label>
                            <input type="text" class="form-control" id="charge" name="charge" value="{{ old('charge') }}" required>
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
                    <h6>List Insurances</h6>
                    <p class="text-sm mb-0">
                        View all list of insurances in the system.
                    </p>
                </div>
                @if (count($insurances) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Marking</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Charge</th>
                                    <th class="text-center text-uppercase text-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($insurances as $i)
                                <tr data-id="{{ $i->id_insurance }}">
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-sm font-weight-normal text-secondary mb-0">{{ $loop->iteration }}.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="customer-selected text-sm font-weight-normal mb-0">{{ $customer[$i->id_customer] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="shipper-selected text-sm font-weight-normal mb-0">{{ $shipper[$i->id_shipper] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="marking-selected text-sm font-weight-normal mb-0">{{ $seaShipmentLine[$i->id_sea_shipment_line] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="charge-selected text-sm font-weight-normal mb-0">{{ 'Rp ' . number_format($i->charge ?? 0, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="mx-4 edit-button" data-bs-toggle="modal" data-bs-target="#insuranceEditModal">
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
        var editButtons = document.querySelectorAll(".edit-button");
        editButtons.forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();

                var row = this.closest("tr");
                var id = row.getAttribute("data-id");
                var marking = row.querySelector(".marking-selected").textContent;
                var charge = row.querySelector(".charge-selected").textContent.trim();

                const chargeConvert = parseFloat(charge);

                // Mengisi data ke dalam formulir
                document.getElementById("id").value = id;
                document.getElementById("marking").value = marking;
                document.getElementById("charge").value = charge;
            });
        });

        let inputCharges = document.querySelectorAll("#charge");
        inputCharges.forEach(function(inputCharge) {
            inputCharge.addEventListener("input", function() {
                this.value = formatCurrency(this.value);
            });
        });
    });
</script>