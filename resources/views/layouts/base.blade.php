<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('') }}asset/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('') }}asset/assets/img/favicon.png">
    <title>
        @yield('title', 'Dashboard')
    </title>
    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('') }}asset/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('') }}asset/assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('') }}asset/assets/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <!-- Include jQuery from CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Include Select2 from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup {
            font-size: 0.9rem; /* Sesuaikan ukuran font */
            padding: 1em !important; /* Sesuaikan padding */
            border-radius: 0.5em; /* Sesuaikan radius border */
        }
        .swal2-title {
            font-size: 1.1rem; /* Sesuaikan ukuran judul */
        }
        .swal2-content {
            font-size: 0.9rem; /* Sesuaikan ukuran konten */
        }
        .swal2-top-end-container {
            top: 1em !important;
            right: 1em !important;
        }
    </style>

    <!-- customer style for select2 -->
    <style>
        .select2-container--default .select2-selection--single {
            border: none;
            font-size: small;
        }

        .select2-container--default .select2-selection--multiple {
            border: none;
            border-bottom: 1px solid #ced4da;
            border-radius: 0px;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: none;
            border-bottom: 1px solid #ced4da;
            border-radius: 0px;
        }
    </style>
</head>

<body class="g-sidenav-show bg-gray-200">
    <!-- sidenav -->
    @include('layouts.sidenav')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- navbar -->
        @include('layouts.navbar')
        
        <!-- content -->
        @yield('content')

        <!-- footer -->
        @include('layouts.footer')
    </main>

    <!-- plugin -->
    @include('layouts.plugin')

    <!--   Core JS Files   -->
    <script src="{{ asset('') }}asset/assets/js/core/popper.min.js"></script>
    <script src="{{ asset('') }}asset/assets/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('') }}asset/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('') }}asset/assets/js/plugins/smooth-scrollbar.min.js"></script>
    <script src="{{ asset('') }}asset/assets/js/plugins/chartjs.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('') }}asset/assets/js/material-dashboard.min.js?v=3.0.0"></script>
    <!-- Include Select from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- font -->
    <script src="https://kit.fontawesome.com/80bacdb160.js" crossorigin="anonymous"></script>
</body>