@extends('layouts.base')
<!-- @section('title', 'Sea Freight Shipment') -->
@section('content')
<div class="container-fluid py-4">
    <!-- <div class="row">
        <div class="col-12 d-flex ms-auto">
            <div>
                <a href="{{ url('/form_sea_shipment') }}" class="btn btn-icon bg-gradient-primary" id="btn-new-sea-shipment">
                    new sea shipment
                </a>
            </div>
        </div>
    </div> -->

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-5 d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0 mt-0">List Sea Freight Shipment</h6>
                        <p class="text-sm mb-0">
                            View all list of sea freight shipment.
                        </p>
                    </div>
                    <form id="deleteForm" method="POST" action="{{ url('sea_shipment-multi_delete') }}" class="d-inline">
                        @csrf
                        <input type="hidden" id="allSelectRow" name="ids" value="">
                        <button id="deleteButton" type="button" class="btn btn-primary ms-2 btn-sm" style="display: none;">
                            Delete data
                        </button>
                    </form>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table id="table-invoice" class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th width=5%>
                                        <input type="checkbox" id="selectAllCheckbox">
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No. Aju</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ship</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Origin</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Etd</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Eta</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Company</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allSeaShipment as $ss)
                                <tr data-id="{{ $ss->id_sea_shipment }}">
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <input type="checkbox" class="select-checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-sm font-weight-normal text-secondary mb-0">{{ $loop->iteration }}.</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">{{ $ss->no_aju ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $ss->date ? \Carbon\Carbon::createFromFormat('Y-m-d', $ss->date)->format('d-M-y') : '-' }}</p>
                                    </td>
                                    <td class="align-middle text-start text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $customer[$ss->id_customer] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-start text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $shipper[$ss->id_shipper] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <p class="text-sm font-weight-normal mb-0">{{ $ship[$ss->id_ship] ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $origin[$ss->id_origin] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $ss->etd ? \Carbon\Carbon::createFromFormat('Y-m-d', $ss->etd)->format('d-M-y') : '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $ss->eta ? \Carbon\Carbon::createFromFormat('Y-m-d', $ss->eta)->format('d-M-y') : '-' }}</p>
                                    </td>
                                    <td class="align-middle text-start text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $ss->customer->company->name ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if ($ss->is_printed)
                                            <p class="text-sm font-weight-bold mb-0">Printed</p>
                                        @else
                                            <p class="text-sm font-weight-bold mb-0 text-primary">Not Printed</p>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('sea_shipment-edit', ['id' => Crypt::encrypt($ss->id_sea_shipment)]) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="{{ url('sea_shipment-delete/' . $ss->id_sea_shipment) }}" class="mx-0" onclick="return confirmDelete()" 
                                            data-bs-toggle="tooltip" data-bs-original-title="Delete">
                                            <i class="material-icons text-secondary position-relative text-lg">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    function confirmDelete() {
        return confirm('Are you sure you want to delete this data?');
    }

    function deleteSeaShipment(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Checkbox
    var table = document.getElementById('table-invoice');
    var checkboxes;
    var selectAllCheckbox = document.getElementById('selectAllCheckbox');
    var allSelectRowInput = document.getElementById('allSelectRow');
    var editButton = document.getElementById('editButton');
    var deleteButton = document.getElementById('deleteButton');

    if (table) {
        checkboxes = table.getElementsByClassName('select-checkbox');

        // Event listener untuk checkbox "Select All"
        selectAllCheckbox.addEventListener('change', function() {
            for (var i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = this.checked;
                var row = checkboxes[i].parentNode.parentNode;
                row.classList.toggle('selected', this.checked);
            }

            // Update button visibility
            updateButtonVisibility();

            // Ambil dan simpan ID semua baris yang terpilih ke dalam input hidden
            updateAllSelectRow();
        });

        // Event listener untuk checkbox di setiap baris
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].addEventListener('change', function() {
                var row = this.parentNode.parentNode;
                row.classList.toggle('selected', this.checked);

                // Periksa apakah setidaknya satu checkbox terpilih
                var atLeastOneChecked = Array.from(checkboxes).some(function(checkbox) {
                    return checkbox.checked;
                });

                // Update button visibility
                updateButtonVisibility();

                // Periksa apakah semua checkbox terpilih
                var allChecked = true;
                for (var j = 0; j < checkboxes.length; j++) {
                    if (!checkboxes[j].checked) {
                        allChecked = false;
                        break;
                    }
                }

                // Atur status checkbox "Select All"
                selectAllCheckbox.checked = allChecked;

                // Ambil dan simpan ID semua baris yang terpilih ke dalam input hidden
                updateAllSelectRow();
            });
        }

        // Fungsi untuk mengambil dan menyimpan ID semua baris yang terpilih
        function updateAllSelectRow() {
            var selectedIds = Array.from(checkboxes)
                .filter(function(checkbox) {
                    return checkbox.checked;
                })
                .map(function(checkbox) {
                    return checkbox.closest('tr').getAttribute('data-id');
                });

            allSelectRowInput.value = selectedIds.join(',');
        }

        // Fungsi untuk mengatur visibilitas tombol
        function updateButtonVisibility() {
            var selectedCheckboxes = Array.from(checkboxes).filter(function(checkbox) {
                return checkbox.checked;
            }).length;

            if (selectedCheckboxes === 1) {
                deleteButton.style.display = 'inline-block';

            } else if (selectedCheckboxes > 1) {
                deleteButton.style.display = 'inline-block';

            } else {
                deleteButton.style.display = 'none';
            }
        }

        // Event listener for the delete button
        deleteButton.addEventListener('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteForm.submit();
                }
            });
        });
    }
</script>
@endsection