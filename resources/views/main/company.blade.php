@extends('layouts.base')
<!-- @section('title', 'Companies') -->
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 d-flex ms-auto">
            <div>
                <button class="btn btn-icon bg-gradient-primary" id="btn-new-company">
                    new company
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
            <!-- form new company -->
            <div id="form-new-company" style="display: none;">
                <div class="card mb-4">
                    <div class="card-header pb-4">
                        <h6>New Company</h6>
                        <p class="text-sm mb-0">
                            Fill out the new company form below.
                        </p>
                    </div>
                    <div class="card-body px-4 pt-0 pb-0">
                        <form action="{{ url('company-store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="input-group input-group-static">
                                        <label>Enter a company</label>
                                        <input type="text" name="company" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="input-group input-group-static">
                                        <label>Enter a shorter company name</label>
                                        <input type="text" name="shorter_company" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- form edit company -->
            <div class="col-12" id="form-edit-company" style="display: none;">
                <div class="card mb-4">
                    <div class="card-header pb-4">
                        <h6>Edit Company</h6>
                        <p class="text-sm mb-0">
                            Fill out the edit company form below.
                        </p>
                    </div>
                    <div class="card-body px-4 pt-0 pb-0">
                        <form action="{{ url('company-update') }}" method="POST">
                            @csrf
                            <input type="hidden" id="edit-id" name="id">
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                    <div class="input-group input-group-static">
                                        <label>Enter a company</label>
                                        <input type="text" name="company" id="edit-company" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <div class="input-group input-group-static">
                                        <label>Enter a shorter company name</label>
                                        <input type="text" name="shorter_company" id="edit-shorter-company" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
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
                    <h6>List Companies</h6>
                    <p class="text-sm mb-0">
                        View all list of companies in the system.
                    </p>
                </div>
                @if (count($companies) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Company</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shorter</th>
                                    <th class="text-center text-uppercase text-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companies as $c)
                                <tr data-id="{{ $c->id_company }}">
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-sm font-weight-normal text-secondary mb-0">{{ $loop->iteration }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="name-company-selected">
                                        <p class="text-sm font-weight-normal mb-0">{{ $c->name }}</p>
                                    </td>
                                    <td class="shorter-company-selected align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $c->shorter ?? '-' }}</p>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="mx-4 btn-edit-company" id="btn-edit-company">
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
<script>
    setTimeout(function() {
        var errorMessage = document.getElementById('error-message');
        if (errorMessage) {
            errorMessage.style.opacity = '0';
            setTimeout(function() {
                errorMessage.style.display = 'none';
            }, 1000);
        }
    }, 3500);

    document.addEventListener("DOMContentLoaded", function() {
        const toggleFormButton = document.getElementById('btn-new-company');
        const myForm = document.getElementById('form-new-company');

        toggleFormButton.addEventListener('click', function() {
            if (myForm.style.display === 'none') {
                myForm.style.display = 'block';
            }

            if (myEditForm.style.display === 'block') {
                myEditForm.style.display = 'none';
            }
        });

        const myEditForm = document.getElementById('form-edit-company');
        var editButtons = document.querySelectorAll(".btn-edit-company");

        editButtons.forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();

                var row = this.closest("tr");
                var id = row.getAttribute("data-id");
                var company = row.querySelector(".name-company-selected").textContent;
                var shorter_company = row.querySelector(".shorter-company-selected").textContent;

                document.getElementById("edit-id").value = id;
                document.getElementById("edit-company").value = company.trim();
                document.getElementById("edit-shorter-company").value = shorter_company.trim();

                if (myEditForm.style.display === 'none') {
                    myEditForm.style.display = 'block';
                }

                if (myForm.style.display === 'block') {
                    myForm.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection