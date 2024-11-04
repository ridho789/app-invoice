@extends('layouts.base')
<!-- @section('title', 'Origins') -->
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12 d-flex ms-auto">
            <div>
                <button class="btn btn-icon bg-gradient-primary" id="btn-new-origin">
                    new origin
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

        <!-- form new origin -->
        <div class="col-12" id="form-new-origin" style="display: none;">
            <div class="card mb-4">
                <div class="card-header pb-4">
                    <h6>New Origin</h6>
                    <p class="text-sm mb-0">
                        Fill out the new origin form below.
                    </p>
                </div>
                <div class="card-body px-4 pt-0 pb-0">
                    <form action="{{ url('origin-store') }}" method="POST">
                        @csrf
                        <div class="input-group input-group-static mb-4">
                            <label>Enter a origin</label>
                            <input type="text" name="origin" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- form edit origin -->
        <div class="col-12" id="form-edit-origin" style="display: none;">
            <div class="card mb-4">
                <div class="card-header pb-4">
                    <h6>Edit Origin</h6>
                    <p class="text-sm mb-0">
                        Fill out the edit origin form below.
                    </p>
                </div>
                <div class="card-body px-4 pt-0 pb-0">
                    <form action="{{ url('origin-update') }}" method="POST">
                        @csrf
                        <input type="hidden" id="edit-id" name="id">
                        <div class="input-group input-group-static mb-4">
                            <label>Enter a origin</label>
                            <input type="text" name="origin" id="edit-origin" class="form-control" oninput="this.value = this.value.toUpperCase()" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-5">
                    <h6>List Origins</h6>
                    <p class="text-sm mb-0">
                        View all list of origins in the system.
                    </p>
                </div>
                @if (count($origins) > 0)
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Origin</th>
                                    <th class="text-center text-uppercase text-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($origins as $o)
                                <tr data-id="{{ $o->id_origin }}">
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-sm font-weight-normal text-secondary mb-0">{{ $loop->iteration }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="name-origin-selected">
                                        <p class="text-sm font-weight-normal mb-0">{{ $o->name }}</p>
                                    </td>
                                    <td class="text-end">
                                        <a href="#" class="mx-4 btn-edit-origin" id="btn-edit-origin">
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
        const toggleFormButton = document.getElementById('btn-new-origin');
        const myForm = document.getElementById('form-new-origin');

        toggleFormButton.addEventListener('click', function() {
            if (myForm.style.display === 'none') {
                myForm.style.display = 'block';
            }

            if (myEditForm.style.display === 'block') {
                myEditForm.style.display = 'none';
            }
        });

        const myEditForm = document.getElementById('form-edit-origin');
        var editButtons = document.querySelectorAll(".btn-edit-origin");

        editButtons.forEach(function(button) {
            button.addEventListener("click", function(event) {
                event.preventDefault();

                var row = this.closest("tr");
                var id = row.getAttribute("data-id");
                var origin = row.querySelector(".name-origin-selected").textContent;

                document.getElementById("edit-id").value = id;
                document.getElementById("edit-origin").value = origin.trim();

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