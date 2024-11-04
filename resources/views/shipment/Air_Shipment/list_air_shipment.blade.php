@extends('layouts.base')
<!-- @section('title', 'Air Freight Shipment') -->
@section('content')
<div class="container-fluid py-4">

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-5">
                    <h6>List Air Freight Shipment</h6>
                    <p class="text-sm mb-0">
                        View all list of air freight shipment.
                    </p>
                    <div class="position-relative">
                        <form id="deleteForm" method="POST" action="{{ url('air_shipment-multi_delete') }}" class="d-inline">
                            @csrf
                            <input type="hidden" id="allSelectRow" name="ids" value="">
                            <button id="deleteButton" type="button" class="btn btn-primary ms-2 btn-sm" style="display: none; position: absolute; top: 10px; right: 10px;">
                                Delete data
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body px-4 pt-0 pb-0">
                    <div class="table-responsive p-0">

                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th width=5%>
                                        <input type="checkbox" id="selectAllCheckbox">
                                    </th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Origin</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Company</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allAirShipment as $as)
                                <tr data-id="{{ $as->id_air_shipment }}">
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
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $as->date ? \Carbon\Carbon::createFromFormat('Y-m-d', $as->date)->format('d-M-y') : '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $customer[$as->id_customer] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $shipper[$as->id_shipper] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $origin[$as->id_origin] ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-start text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $as->customer->company->name ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if ($as->is_printed)
                                            <p class="text-sm font-weight-bold mb-0">Printed</p>
                                        @else
                                            <p class="text-sm font-weight-bold mb-0 text-primary">Not Printed</p>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('air_shipment-edit', ['id' => Crypt::encrypt($as->id_air_shipment)]) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                        <a href="{{ url('air_shipment-delete/' . $as->id_air_shipment) }}" class="mx-0" onclick="return confirmDelete()" 
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

    function deleteAirShipment(id) {
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

    // Checkbox Elements
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.select-checkbox');
    const deleteButton = document.getElementById('deleteButton');
    const allSelectRow = document.getElementById('allSelectRow');

    // Fungsi untuk mengumpulkan semua id yang dipilih
    function updateSelectedIds() {
        const selectedIds = Array.from(checkboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => checkbox.closest('tr').getAttribute('data-id'));

        allSelectRow.value = selectedIds.join(','); // Gabungkan id yang dipilih dengan koma
    }

    // Fungsi untuk mengecek apakah ada checkbox yang dipilih dan menampilkan tombol delete
    function toggleDeleteButton() {
        const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        deleteButton.style.display = (selectAllCheckbox.checked || anyChecked) ? 'inline-block' : 'none';
    }

    // Event listener untuk checkbox "Select All"
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
            toggleDeleteButton();
            updateSelectedIds();
        });
    }

    // Event listener untuk setiap checkbox dengan class "select-checkbox"
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleDeleteButton();
            updateSelectedIds();
        });
    });

    // Event listener untuk tombol delete
    deleteButton.addEventListener('click', function() {
        if (allSelectRow.value === '') {
            alert('Tidak ada data yang dipilih!');
        } else {
            // Menampilkan popup konfirmasi sebelum menghapus data
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
                    document.getElementById('deleteForm').submit(); 
                }
            });
        }
    });

</script>
@endsection