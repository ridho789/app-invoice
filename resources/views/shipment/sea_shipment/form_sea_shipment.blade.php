@extends('layouts.base')
<!-- @section('title', 'Sea Freight Shipment') -->
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div>
            @if ($groupSeaShipmentLines)
            <div class="card mb-5">
                <div class="card-header pb-2">
                    <h6>Summary of Sea Freight Shipment</h6>
                    <p class="text-sm mb-0">
                        Summary of Sea Freight shipment.
                    </p>
                </div>
                <div class="card-body px-4 pt-0 pb-0 mb-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">No.</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">BL Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Total Packages</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Total Heavy</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="1" colspan="3">Total CBM</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Description</th>
                                </tr>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">i</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ii</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">sf</th>
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($groupSeaShipmentLines as $date => $gsl)
                                <tr>
                                    <td width=5%>
                                        <div class="d-flex px-3 py-1">
                                            <p class="text-xs text-secondary mb-0">{{ $loop->iteration }}.</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M-y') }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">{{ $gsl['total_qty_pkgs'] }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        @php
                                            $totalWeight = $gsl['total_weight'] / 1000;
                                        @endphp
                                        <span class="text-secondary text-xs font-weight-normal">{{ $totalWeight != 0 ? $totalWeight . ' T' : '-' }}</span>
                                    </td>
                                    <!-- total cbm -->
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">{{ $gsl['total_cbm1'] > 0 ? round($gsl['total_cbm1'], 3) . ' M3' : '-' }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">{{ $gsl['total_cbm2'] > 0 ? round($gsl['total_cbm2'], 3) . ' M3' : '-' }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">{{ $gsl['cbm_difference'] > 0 ? round($gsl['cbm_difference'], 3) . ' M3' : '-' }}</span>
                                    </td>
                                    <!-- ### -->
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <div class="card mt-0 p-0">
                <!-- <div class="card-header pb-4">
                    <h6>Shipment Sea Freight</h6>
                    <p class="text-sm mb-0">
                        Main shipment sea freight.
                    </p>
                </div> -->
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-xl mt-n4 me-3 float-start">
                        <i class="material-icons opacity-10">event</i>
                    </div>
                    <h6 class="mb-0">Sea Freight Shipment</h6>
                    <p class="text-sm mb-0">
                        List of sea freight shipment.
                    </p>
                </div>
                <div class="card-body px-4 pt-0 pb-0">
                    @if ($seaShipment)
                    <form id="form-sea-freight" method="POST" enctype="multipart/form-data" action="{{ url('sea_shipment-update') }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Aju</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ship</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Origin</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Ships</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Packages</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Heavy</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Volume</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Etd</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Eta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <input type="hidden" name="id_sea_shipment" value="{{ $seaShipment->id_sea_shipment }}">
                                                <input type="text" class="form-control" name="no_aju" value="{{ $seaShipment->no_aju ?? '-' }}" 
                                                oninput="this.value = this.value.toUpperCase()" placeholder="...">
                                            </div>
                                        </td>
                                        <td class="align-middle text-center" width=5.5%>
                                            <input type="date" class="form-control" name="date" value="{{ $seaShipment->date }}">
                                        </td>
                                        <td class="align-middle text-center" width=10%>
                                            <select class="form-select text-xs select-cust" name="id_customer" required>
                                                <option value="">...</option>
                                                @foreach ($customers as $c)
                                                <option value="{{ $c->id_customer }}" data-shipper-ids="{{ $c->shipper_ids }}" 
                                                    {{ old('id_customer', $seaShipment->id_customer) == $c->id_customer ? 'selected' : '' }}>{{ $c->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center" width=10%>
                                            <select class="form-select text-xs select-shipper" name="id_shipper" required>
                                                <option value="">...</option>
                                                @foreach ($shippers as $s)
                                                <option value="{{ $s->id_shipper }}" 
                                                    {{ old('id_shipper', $seaShipment->id_shipper) == $s->id_shipper ? 'selected' : '' }}>{{ $s->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center" width=10%>
                                            <select class="form-select text-xs select-ship" name="id_ship">
                                                <option value="">...</option>
                                                @foreach ($ships as $s)
                                                <option value="{{ $s->id_ship }}" 
                                                    {{ old('id_ship', $seaShipment->id_ship) == $s->id_ship ? 'selected' : '' }}>{{ $s->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center" width=7.5%>
                                            <select class="form-select text-xs select-origin" name="id_origin" required>
                                                <option value="">...</option>
                                                @foreach ($origins as $o)
                                                <option value="{{ $o->id_origin }}" 
                                                    {{ old('id_origin', $seaShipment->id_origin) == $o->id_origin ? 'selected' : '' }}>{{ $o->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="text" class="form-control text-center" name="tot_ships" placeholder="..." style="background-color: #fff;" disabled>
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="text" class="form-control text-center" name="tot_pkgs" placeholder="..." style="background-color: #fff;" disabled>
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="text" class="form-control text-center" name="tot_weight" placeholder="..." style="background-color: #fff;" disabled>
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="text" class="form-control text-center" name="tot_vol" placeholder="..." style="background-color: #fff;" disabled>
                                        </td>
                                        <td class="align-middle text-center" width=5.5%>
                                            <input type="date" class="form-control" name="etd" value="{{ $seaShipment->etd }}" required>
                                        </td>
                                        <td class="align-middle text-center" width=5.5%>
                                            <input type="date" class="form-control" name="eta" value="{{ $seaShipment->eta }}">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive py-3 mt-3">
                            <!-- <h6>List of Shipment Sea Freight</h6> -->
                            <p class="text-sm mb-0">
                                <!-- List of sea freight shipment. -->
                            </p>
                            <table class="table table-bordered align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">No.</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">BL Date</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Code</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Marking</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="1" colspan="4">Quantity</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">H <br> kg</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="1" colspan="3">Dimension</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="1" colspan="2">Total CBM</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">LTS</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Qty</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Unit</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Desc</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">State</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2"></th>
                                    </tr>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" colspan="2">Pkgs</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" colspan="2">Loose</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">p</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">l</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">t</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">i</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ii</th>
                                    </tr>

                                </thead>
                                <tbody id="shipmentTableBody">
                                    @foreach($seaShipmentLines as $ssl)
                                    <tr>
                                        <input type="hidden" name="id_sea_shipment_line[]" value="{{ $ssl->id_sea_shipment_line }}">
                                        <td class="align-middle text-center text-sm" width=2.5%>
                                            <div class="d-flex px-3 py-1">
                                                {{ $loop->iteration }}.
                                            </div>
                                        </td>
                                        <td class="align-middle text-center" width=7.5%>
                                            <input type="date" class="form-control text-center" name="bldate[]" value="{{ $ssl->date }}" style="border: 0px;" required>
                                        </td>
                                        <td class="align-middle text-center" width=7.5%>
                                            <input type="text" class="form-control text-center" name="code[]" value="{{ $ssl->code }}" 
                                            oninput="this.value = this.value.toUpperCase()" placeholder="..." style="border: 0px;">
                                        </td>
                                        <td class="align-middle text-center" width=15.5%>
                                            <input type="text" class="form-control text-center" name="marking[]" value="{{ $ssl->marking ?? '-' }}" 
                                            oninput="this.value = this.value.toUpperCase()" placeholder="..." style="border: 0px;">
                                        </td>
                                        <!-- qty -->
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="qty_pkgs[]" value="{{ $ssl->qty_pkgs }}" 
                                            placeholder="..." style="border: 0px;" min="1">
                                        </td>
                                        <td class="align-middle" width=5%>
                                            <select class="form-select text-center text-xs select-uom-pkgs" name="id_uom_pkgs[]" style="border: 0px;">
                                                <option value="" data-name="">-</option>
                                                @foreach ($uoms as $o)
                                                <option value="{{ $o->id_uom }}" data-name="{{ $o->name }}" 
                                                    {{ old('id_uom_pkgs', $ssl->id_uom_pkgs) == $o->id_uom ? 'selected' : '' }}>{{ $o->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="qty_loose[]" value="{{ $ssl->qty_loose }}" 
                                            placeholder="..." style="border: 0px;" min="1">
                                        </td>
                                        <td class="align-middle" width=5%>
                                            <select class="form-select text-center text-xs select-uom-loose" name="id_uom_loose[]" style="border: 0px;">
                                                <option value="" data-name="">-</option>
                                                @foreach ($uoms as $o)
                                                <option value="{{ $o->id_uom }}" data-name="{{ $o->name }}" 
                                                    {{ old('id_uom_loose', $ssl->id_uom_loose) == $o->id_uom ? 'selected' : '' }}>{{ $o->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <!-- ### -->
                                        <td class="align-middle text-center" width=5%>
                                            <input type="text" class="form-control text-center input-weight" name="weight[]" value="{{ $ssl->weight }}" placeholder="..." style="border: 0px;">
                                        </td>
                                        <!-- dimension -->
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="p[]" value="{{ $ssl->dimension_p ?? '-' }}" 
                                            placeholder="..." style="border: 0px;" min="1" >
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="l[]" value="{{ $ssl->dimension_l ?? '-' }}" 
                                            placeholder="..." style="border: 0px;" min="1" >
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="t[]" value="{{ $ssl->dimension_t ?? '-' }}" 
                                            placeholder="..." style="border: 0px;" min="1" >
                                        </td>
                                        <!-- ### -->
                                        <!-- total cbm -->
                                        <td class="align-middle text-center" width=5%>
                                            <input type="text" class="form-control text-center" name="cbm1[]" 
                                            value="{{ isset($ssl->tot_cbm_1) && $ssl->tot_cbm_1 !== null ? round($ssl->tot_cbm_1, 3) : '' }}" 
                                            placeholder="..." style="border: 0px;">
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="text" class="form-control text-center" name="cbm2[]" 
                                            value="{{ isset($ssl->tot_cbm_2) && $ssl->tot_cbm_2 !== null ? round($ssl->tot_cbm_2, 3) : '' }}" 
                                            placeholder="..." style="border: 0px;">
                                        </td>
                                        <!-- ### -->
                                        <td class="align-middle text-center" width=5%>
                                            <input type="text" class="form-control text-center input-lts" name="lts[]" value="{{ $ssl->lts }}" 
                                            oninput="this.value = this.value.toUpperCase(); checkLTS(this);" placeholder="..." style="border: 0px;">
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center input-qty" name="qty[]" value="{{ $ssl->qty }}" min="1" placeholder="..." style="border: 0px;">
                                        </td>
                                        <td class="align-middle" width=5%>
                                            <select class="form-select text-center text-xs select-unit" name="id_unit[]" style="border: none;">
                                                <option value="" data-name="">-</option>
                                                @foreach ($units as $u)
                                                <option value="{{ $u->id_unit }}" data-name="{{ $u->name }}" 
                                                    {{ old('id_unit', $ssl->id_unit) == $u->id_unit ? 'selected' : '' }}>{{ $u->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center" width=7.5%>
                                            <input type="text" class="form-control text-center" name="desc[]" value="{{ $ssl->desc }}" placeholder="..." style="border: 0px;">
                                        </td>
                                        <td class="align-middle" width=7.5%>
                                            <select class="form-select text-center text-xs select-state" name="id_state[]" style="border: 0px;">
                                                <option value="" data-name="">-</option>
                                                @foreach ($states as $s)
                                                <option value="{{ $s->id_state }}" data-name="{{ $s->name }}" 
                                                    {{ old('id_state', $ssl->id_state) == $s->id_state ? 'selected' : '' }}>{{ $s->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center">
                                            <a href="javascript:void(0);" onclick="confirmShipmentLineDelete({{ $ssl->id_sea_shipment_line }}, {{ $loop->iteration }})">
                                                <i class="material-icons text-primary position-relative text-lg">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- inside new line -->
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-1">
                            <button id="addRowButton" class="btn btn-outline-primary btn-sm" type="button" style="border: none;">
                                <span class="btn-inner--text"><u>+</u> Add new line</span>
                            </button>
                        </div>
                        
                        <!-- Upload shipment status -->
                        <div>
                            <label for="files" class="drop-container" id="dropcontainer" style="margin-left: 0;">
                                <span class="drop-title">Drop file here</span>
                                or
                                <input type="file" id="files" name="file_shipment_status" accept="application/pdf">
                            </label>
                        </div>

                        <div class="mt-3 mb-3">
                            <span style="font-size: 15.5px; color: #444; font-weight: bold;">Uploaded File</span>
                            @if ($seaShipment->file_shipment_status)
                                <ul>
                                    <li>
                                        <a href="{{ asset('storage/' . $seaShipment->file_shipment_status) }}" target="_blank">
                                            <span style="font-size: 14.5px;">{{ $seaShipment->file_shipment_status }}</span>
                                        </a>
                                        <a class="ms-2" href="javascript:void(0);" onclick="confirmDeleteFile('{{ Crypt::encrypt($seaShipment->id_sea_shipment) }}')">
                                            <i class="material-icons text-primary position-relative text-lg">delete</i>
                                        </a>
                                    </li>
                                </ul>
                            @else
                                <p style="font-size: 14.5px;">No file uploaded yet.</p>
                            @endif
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary btn-sm">Update</button>
                            <button type="button" class="btn btn-secondary btn-sm ms-2 btn-setup">Setup</button>
                        </div>
                    </form>
                    @else
                    <form id="form-sea-freight" method="POST" action="{{ url('sea_shipment-store') }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Aju</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ship</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Origin</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Ships</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Packages</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Heavy</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Volume</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Etd</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Eta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex px-3 py-1">
                                                <input type="text" class="form-control" name="number" oninput="this.value = this.value.toUpperCase()" placeholder="...">
                                            </div>
                                        </td>
                                        <td class="align-middle text-center" width=5.5%>
                                            <input type="date" class="form-control" name="date">
                                        </td>
                                        <td class="align-middle text-center" width=10%>
                                            <select class="form-select text-xs select-cust" name="id_customer" required>
                                                <option value="">...</option>
                                                @foreach ($customers as $c)
                                                <option value="{{ $c->id_customer }}" data-shipper-ids="{{ $c->shipper_ids }}">{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center" width=10%>
                                            <select class="form-select text-xs select-shipper" name="id_shipper" required>
                                                <option value="">...</option>
                                                @foreach ($shippers as $s)
                                                <option value="{{ $s->id_shipper }}">{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center" width=10%>
                                            <select class="form-select text-xs select-ship" name="id_ship">
                                                <option value="">...</option>
                                                @foreach ($ships as $s)
                                                <option value="{{ $s->id_ship }}">{{ $s->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center" width=7.5%>
                                            <select class="form-select text-xs select-origin" name="id_origin" required>
                                                <option value="">...</option>
                                                @foreach ($origins as $o)
                                                <option value="{{ $o->id_origin }}">{{ $o->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="text" class="form-control text-center" name="tot_ships" placeholder="..." style="background-color: #fff;" disabled>
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="text" class="form-control text-center" name="tot_pkgs" placeholder="..." style="background-color: #fff;" disabled>
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="text" class="form-control text-center" name="tot_weight" placeholder="..." style="background-color: #fff;" disabled>
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="text" class="form-control text-center" name="tot_vol" placeholder="..." style="background-color: #fff;" disabled>
                                        </td>
                                        <td class="align-middle text-center" width=5.5%>
                                            <input type="date" class="form-control" name="etd" required>
                                        </td>
                                        <td class="align-middle text-center" width=5.5%>
                                            <input type="date" class="form-control" name="eta">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive py-3 mt-3">
                            <!-- <h6>List of Shipment Sea Freight</h6> -->
                            <p class="text-sm mb-0">
                                <!-- List of sea freight shipment. -->
                            </p>
                            <table class="table table-bordered align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">No.</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">BL Date</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Code</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Marking</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="1" colspan="4">Quantity</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">H <br> kg</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="1" colspan="3">Dimension</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="1" colspan="2">Total CBM</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Lts</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Qty</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Unit</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Desc</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">State</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2"></th>
                                    </tr>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" colspan="2">Pkgs</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" colspan="2">Loose</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">p</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">l</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">t</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">i</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ii</th>
                                    </tr>

                                </thead>
                                <tbody id="shipmentTableBody">
                                    <tr>
                                        <td width=2.5%>
                                            <div class="align-middle text-center text-sm d-flex px-3 py-1">
                                                1.
                                            </div>
                                        </td>
                                        <td class="align-middle text-center" width=7.5%>
                                            <input type="date" class="form-control text-center" name="bldate[]" style="border: 0px;" required>
                                        </td>
                                        <td class="align-middle text-center" width=7.5%>
                                            <input type="text" class="form-control text-center" name="code[]" oninput="this.value = this.value.toUpperCase()" 
                                            placeholder="..." style="border: 0px;">
                                        </td>
                                        <td class="align-middle text-center" width=15.5%>
                                            <input type="text" class="form-control text-center" name="marking[]" oninput="this.value = this.value.toUpperCase()" 
                                            placeholder="..." style="border: 0px;">
                                        </td>
                                        <!-- qty -->
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="qty_pkgs[]" placeholder="..." style="border: 0px;" min="1">
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <select class="form-select text-center text-xs" name="id_uom_pkgs[]" style="border: 0px;">
                                                <option value="" data-name="">-</option>
                                                @foreach ($uoms as $o)
                                                <option value="{{ $o->id_uom }}" data-name="{{ $o->name }}" 
                                                    {{ old('id_uom_pkgs') == $o->id_uom ? 'selected' : '' }}>{{ $o->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="qty_loose[]" placeholder="..." style="border: 0px;" min="1">
                                        </td>
                                        <td class="align-middle" width=5%>
                                            <select class="form-select text-center text-xs" name="id_uom_loose[]" style="border: 0px;">
                                                <option value="" data-name="">-</option>
                                                @foreach ($uoms as $o)
                                                <option value="{{ $o->id_uom }}" data-name="{{ $o->name }}" 
                                                    {{ old('id_uom_loose') == $o->id_uom ? 'selected' : '' }}>{{ $o->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <!-- ### -->
                                        <td class="align-middle text-center" width=5%>
                                            <input type="text" class="form-control text-center input-weight" name="weight[]" placeholder="..." style="border: 0px;">
                                        </td>
                                        <!-- dimension -->
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="p[]" placeholder="..." style="border: 0px;" min="1" >
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="l[]" placeholder="..." style="border: 0px;" min="1" >
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="t[]" placeholder="..." style="border: 0px;" min="1" >
                                        </td>
                                        <!-- ### -->
                                        <!-- total cbm -->
                                        <td class="align-middle text-center" width=5%>
                                            <input type="text" class="form-control text-center" name="cbm1[]" placeholder="..." style="border: 0px;">
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="text" class="form-control text-center" name="cbm2[]" placeholder="..." style="border: 0px;">
                                        </td>
                                        <!-- ### -->
                                        <td class="align-middle text-center" width=5%>
                                            <input type="text" class="form-control text-center input-lts" name="lts[]" oninput="this.value = this.value.toUpperCase()" 
                                            placeholder="..." style="border: 0px;">
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="number" class="form-control text-center input-qty" name="qty[]" placeholder="..." style="border: 0px;" min="1">
                                        </td>
                                        <td class="align-middle text-center">
                                            <select class="form-select text-center text-xs select-unit" name="id_unit[]" style="border: none;">
                                                <option value="" data-name="">-</option>
                                                @foreach ($units as $u)
                                                <option value="{{ $u->id_unit }}" data-name="{{ $u->name }}"
                                                    {{ old('id_unit') == $u->id_unit ? 'selected' : '' }}>{{ $u->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center">
                                            <input type="text" class="form-control text-center" name="desc[]" placeholder="..." style="border: 0px;">
                                        </td>
                                        <td class="align-middle" width=7.5%>
                                            <select class="form-select text-center text-xs select-state" name="id_state[]" style="border: 0px;">
                                                <option value="" data-name="">-</option>
                                                @foreach ($states as $s)
                                                <option value="{{ $s->id_state }}" data-name="{{ $s->name }}" 
                                                    {{ old('id_state') == $s->id_state ? 'selected' : '' }}>{{ $s->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mb-1">
                            <button id="addRowButton" class="btn btn-outline-primary btn-sm" type="button" style="border: none;">
                                <span class="btn-inner--text"><u>+</u> Add new line</span>
                            </button>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                    @endif 
                </div>
            </div>
        </div>
    </div>
</div>
@if ($seaShipment)
<!-- Modal - SetPrint -->
<div class="modal fade" id="setPrintModal" tabindex="-1" role="dialog" aria-labelledby="setPrintModalLabel" aria-hidden="true">
    @if (in_array($originName[$seaShipment->id_origin], ['SIN-BTH', 'SIN-JKT']))
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
    @else
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    @endif
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-normal text-xs" id="setPrintModalLabel"><i class="material-icons text-xs">priority_high</i>
                    <b>Before printing the document, make sure youve filled in all the required (<span class="text-primary">*</span>) data.</b>
                </h5>
            </div>
            <form id="seaShipmentForm" action="{{ url('print-sea-shipment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if (in_array($originName[$seaShipment->id_origin], ['SIN-BTH', 'SIN-JKT']))
                        <div class="row">
                            <div class="col-4">
                                <h5 class="text-sm">Basic Setup</h5>
                                <input type="hidden" name="id" value="{{ $seaShipment->id_sea_shipment }}">
                                <div class="input-group input-group-static mb-4">
                                    <label>Invoice No. <span class="text-danger">*</span></label>
                                    @if ($seaShipment->no_inv)
                                        <input type="text" class="form-control" name="inv_no" value="{{ old('inv_no', $seaShipment->no_inv) }}" placeholder="..." required>
                                    @else
                                        <input type="text" class="form-control" name="inv_no" value="{{ old('inv_no', $seaShipment->id_sea_shipment) }}" placeholder="..." required>
                                    @endif
                                </div>
            
                                <div class="input-group input-group-static mb-1">
                                    <label class="text-sm">Company <span class="text-danger">*</span></label>
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <select class="form-select select-company" name="id_company" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;" required>
                                        <option value="">...</option>
                                        @foreach ($companies as $c)
                                        <option value="{{ $c->id_company }}" {{ old('id_company', $customer->id_company) == $c->id_company ? 'selected' : '' }}>{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="input-group input-group-static mb-4">
                                    <div class="col-5">
                                        <label>Term <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="term" name="term" min="1" value="{{ old('term', $seaShipment->term) }}" placeholder="..." required>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-6">
                                        <label>Payment Due</label>
                                        <input type="date" class="form-control" id="payment_due" name="payment_due" value="{{ old('payment_due', $seaShipment->etd) }}" readonly>
                                    </div>
                                </div>
            
                                <div class="input-group input-group-static mb-4">
                                    <div class="col-5">
                                        <div class="input-group input-group-static mb-1">
                                            <label class="text-sm">Banker</label>
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <select class="form-select select-banker" name="id_banker" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                                <option value="">...</option>
                                                @foreach ($bankers as $b)
                                                <option value="{{ $b->id_banker }}" {{ old('id_banker', $customer->id_banker) == $b->id_banker ? 'selected' : '' }}>{{ $b->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-6">
                                        <div class="input-group input-group-static mb-1">
                                            <label class="text-sm">Account</label>
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <select class="form-select select-account" name="id_account" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                                <option value="">...</option>
                                                @foreach ($accounts as $a)
                                                <option value="{{ $a->id_account }}" {{ old('id_account', $customer->id_account) == $a->id_account ? 'selected' : '' }}>{{ $a->account_no }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group input-group-static">
                                    <div class="form-check form-check-inline" style="padding-left: 0;">
                                        <input type="hidden" name="is_weight" value="{{ $seaShipment->is_weight }}">
                                        <input type="hidden" name="is_bill_weight" value="{{ $customer->is_bill_weight }}">
                                        <input class="form-check-input" type="checkbox" id="isWeight">
                                        <label class="form-check-label mb-1 mx-2" for="isWeight">Click to switch billing by <span class="text-primary">heavy</span></label>
                                        @if ($isWeight)
                                            <label class="form-check-label mb-1 text-xs">Recommended to enable heavy billing - 
                                                Total Weight <b>{{ $totalWeightOverall / 1000 }} T</b> <u>></u> Total CBM <b>{{ $totalCbmOverall }} M3</b>
                                            </label>
                                        @else
                                            @if ($customer->is_bill_weight)
                                            <label class="form-check-label mb-1 text-xs">This particular customer has been set up for heavy-based billing</label>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-4">
                                <h5 class="text-sm">Fee Setup</h5>
                                @if ($groupSeaShipmentLines)
                                    <!-- Tagihan selisih -->
                                    @if ($checkCbmDiff)
                                        @if (count($billDiff) > 0)
                                            <div class="input-group input-group-static">
                                                <label class="text-sm">Diff SIN-BTH <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="input-group input-group-static mb-4">
                                                <div class="col-5">
                                                    <select class="form-select select-diff" name="bill_diff" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                                        <option value="">...</option>
                                                        @foreach ($billDiff as $b)
                                                        <option 
                                                            value="{{ $b->id_pricelist }}" {{ old('bill_diff', $seaShipment->bill_diff) == $b->id_pricelist ? 'selected' : '' }}>
                                                            {{ 'Rp ' . number_format($b->price ?? 0, 0, ',', '.') }}
                                                        </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-1"></div>
                                                <div class="col-6">
                                                    <input type="text" class="form-control custom_bill_diff" style="margin-top: 2.15px;" name="custom_bill_diff" 
                                                    placeholder="Enter special price..">
                                                </div>
                                            </div>
                                        @else
                                            <div class="input-group input-group-static mb-4">
                                                <label class="text-sm" style="margin-bottom: 2px;">Diff SIN-BTH <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control custom_bill_diff" style="margin-bottom: 2px;" name="custom_bill_diff" 
                                                placeholder="Enter price.." required>
                                            </div>
                                        @endif
                                    @endif
                                    
                                    <!-- Tagihan customer -->
                                    @if (count($pricelist) > 0)
                                        <div class="input-group input-group-static" style="margin-bottom: 3.15px;">
                                            <label class="text-sm">Customer Bill <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="input-group input-group-static mb-4">
                                            <div class="col-5">
                                                <select class="form-select select-diff" name="pricelist" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                                    <option value="">...</option>
                                                    @foreach ($pricelist as $p)
                                                    <option 
                                                        value="{{ $p->id_pricelist }}" {{ old('pricelist', $seaShipment->pricelist) == $p->id_pricelist ? 'selected' : '' }}>
                                                        {{ 'Rp ' . number_format($p->price ?? 0, 0, ',', '.') }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-1"></div>
                                            <div class="col-6">
                                                <input type="text" class="form-control custom_pricelist" style="margin-top: 2.75px;" name="custom_pricelist" 
                                                placeholder="Enter special price..">
                                            </div>
                                        </div>
                                    @else
                                        <div class="input-group input-group-static mb-4">
                                            <label class="text-sm" style="margin-bottom: {{ count($billDiff) > 0 ? '5.5px' : '2.5px' }};">
                                                Customer Bill <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" class="form-control custom_pricelist" name="custom_pricelist" placeholder="Enter price.." required>
                                        </div>
                                    @endif

                                    <!-- cas -->
                                    <!-- @if (count($groupedLTS) > 0)
                                        <div class="accordion-1">
                                            <div class="row">
                                                <div class="accordion" id="accordionLTS">
                                                    <div class="accordion-item mb-4">
                                                        <div class="accordion-header" id="headingOne" style="margin-top: -1.7px;">
                                                            <label style="margin-left: 0; margin-bottom: 8.5px;">Additional Bill</label>
                                                            <button class="accordion-button border-bottom font-weight-bold collapsed" type="button" data-bs-toggle="collapse" 
                                                                data-bs-target="#collapseOneLTS" aria-expanded="false" aria-controls="collapseOneLTS" 
                                                                style="padding: 0rem 0.5rem;">
                                                                <label class="font-weight-normal" style="margin-left: -7.5px;">
                                                                    <b style="color: #344767;">List Cas LTS</b>
                                                                </label>
                                                                <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3 collapse-icon" aria-hidden="true"></i>
                                                                <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3 collapse-icon d-none" aria-hidden="true"></i>
                                                            </button>
                                                        </div>

                                                        <div id="collapseOneLTS" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionLTS">
                                                            <div class="accordion-body" style="padding: 0.5rem 0rem 0rem;">
                                                                @foreach ($groupedLTS as $data)
                                                                    @if ($data)
                                                                    <div class="input-group input-group-static mb-1">
                                                                        <div class="col-5">
                                                                            <input type="text" class="form-control lts_code" name="lts_code[]" value="{{ $data }}" readonly>
                                                                        </div>
                                                                        <div class="col-1"></div>
                                                                        <div class="col-6">
                                                                            <input type="text" class="form-control lts_bill" name="lts_bill[]" placeholder="Enter price..">
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif -->
                                @else
                                    <p>No data can be processed</p>
                                @endif
                            </div>
                            <div class="col-4">
                                <h5 class="text-sm">Advanced Setup</h5>
                                @if ($groupSeaShipmentLines)
                                    <div class="input-group input-group-static mb-0">
                                        <label class="text-sm">Invoice Type <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="input-group input-group-static mb-4">
                                        <select class="form-select text-left" id="inv_type" name="inv_type" 
                                        style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;" required>
                                            <option value="" {{ old('inv_type', $customer->inv_type) == '' ? 'selected' : '' }}>...</option>
                                            <option value="basic" {{ old('inv_type', $customer->inv_type) == 'basic' ? 'selected' : '' }} selected>Basic</option>
                                            <option value="separate" {{ old('inv_type', $customer->inv_type) == 'separate' ? 'selected' : '' }}>Separate</option>
                                        </select>
                                    </div>
                                    
                                    <div class="accordion-1">
                                        <div class="row">
                                            <div class="accordion" id="accordionRental">
                                                @foreach ($groupSeaShipmentLines as $date => $gsl)
                                                @php
                                                    $checkSeaShipmentBill = null;
                                                    if (count($seaShipmentBill) > 0) {
                                                        $checkSeaShipmentBill = $seaShipmentBill->where('date', $date)->first();
                                                    }
                                                @endphp
                                                <div class="accordion-item mb-4">
                                                    <div class="accordion-header" id="headingOne-{{ $loop->index }}">
                                                        <label style="margin-left: 0;">Other Setup</label>
                                                        <button class="accordion-button border-bottom font-weight-bold collapsed" type="button" data-bs-toggle="collapse" 
                                                            data-bs-target="#collapseOne-{{ $loop->index }}" aria-expanded="false" aria-controls="collapseOne-{{ $loop->index }}" 
                                                            style="padding: 0.05rem 0.5rem;">
                                                            <label class="font-weight-normal" style="margin-left: -7.5px;">
                                                                <b style="color: #344767;">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-M-y') }}</b>
                                                                <input type="hidden" class="form-control" id="dateBL" name="dateBL[]" value="{{ $date }}">
                                                            </label>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3 collapse-icon" aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3 collapse-icon d-none" aria-hidden="true"></i>
                                                        </button>
                                                    </div>

                                                    <div id="collapseOne-{{ $loop->index }}" class="accordion-collapse collapse" aria-labelledby="headingOne-{{ $loop->index }}" 
                                                    data-bs-parent="#accordionRental">
                                                        <div class="accordion-body" style="padding: 1.7rem 0rem;">
                                                            <div class="input-group input-group-static mb-4">
                                                                <label>Code - Narita / CNG / Other</label>
                                                                <input type="text" class="form-control" id="codeShipment-{{ $loop->index }}" name="codeShipment[]" 
                                                                value="{{ old('codeShipment', $checkSeaShipmentBill ? $checkSeaShipmentBill->code : '') }}" 
                                                                oninput="this.value = this.value.toUpperCase()" placeholder="...">
                                                            </div>

                                                            <div class="input-group input-group-static mb-4" style="display: none;">
                                                                <div class="col-5">
                                                                    <label>BL</label>
                                                                    <input type="text" class="form-control bl" id="bl-{{ $loop->index }}" name="bl[]" 
                                                                    value="{{ old('bl', $checkSeaShipmentBill ? $checkSeaShipmentBill->bl : '') }}" placeholder="...">
                                                                </div>
                                                                <div class="col-1"></div>
                                                                <div class="col-6">
                                                                    <label>Permit</label>
                                                                    <input type="text" class="form-control permit" id="permit-{{ $loop->index }}" name="permit[]" 
                                                                    value="{{ old('permit', $checkSeaShipmentBill ? $checkSeaShipmentBill->permit : '') }}" placeholder="...">
                                                                </div>
                                                            </div>

                                                            <div class="input-group input-group-static mb-4" style="display: none;">
                                                                <div class="col-5">
                                                                    <label>Insurance</label>
                                                                    <input type="text" class="form-control insurance" id="insurance-{{ $loop->index }}" name="insurance[]" 
                                                                    value="{{ old('insurance', $checkSeaShipmentBill ? $checkSeaShipmentBill->insurance : '') }}" placeholder="...">
                                                                </div>
                                                                <div class="col-1"></div>
                                                                <div class="col-6">
                                                                    <label>Transport</label>
                                                                    <input type="text" class="form-control transport" name="transport[]" id="transport-{{ $loop->index }}" 
                                                                    value="{{ old('transport', $checkSeaShipmentBill ? $checkSeaShipmentBill->transport : '') }}" placeholder="...">
                                                                </div>
                                                            </div>

                                                            <div class="input-group input-group-static">
                                                                <div>
                                                                    <button id="addButton" class="btn btn-outline-primary btn-sm" type="button">
                                                                        <span class="btn-inner--text">+ Add another bill</span>
                                                                    </button>
                                                                </div>

                                                                <div id="inputGroupContainer" class="input-group input-group-static">
                                                                    <!-- Input groups (another bill) will be appended here -->
                                                                    @php
                                                                        $checkSeaShipmentAnotherBill = null;
                                                                        if (isset($seaShipmentAnotherBill) && count($seaShipmentAnotherBill) > 0) {
                                                                            $checkSeaShipmentAnotherBill = $seaShipmentAnotherBill->where('id_sea_shipment', $seaShipment->id_sea_shipment)->all();
                                                                        }
                                                                    @endphp
                                                                    @if($checkSeaShipmentAnotherBill && count($checkSeaShipmentAnotherBill) > 0)
                                                                        @foreach($checkSeaShipmentAnotherBill as $index => $data)
                                                                            <input type="hidden" name="idAnotherBill[]" value="{{ $data->id_sea_shipment_other_bill }}">
                                                                            <input type="hidden" name="dateAnotherBL[]" value="{{ $date }}">
                                                                            <div class="input-group input-group-static mb-4">
                                                                                <div class="col-3">
                                                                                    <div class="input-group input-group-static mb-1">
                                                                                        <label class="text-sm">Desc</label>
                                                                                    </div>
                                                                                    <div class="input-group input-group-static mb-0">
                                                                                        <select class="form-select" name="id_desc[]" 
                                                                                        style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                                                                            <option value="">...</option>
                                                                                            @foreach ($descs as $d)
                                                                                            <option value="{{ $d->id_desc }}" {{ old('id_desc.' . $index, $data->id_desc) == 
                                                                                                $d->id_desc ? 'selected' : '' }}>{{ $d->name }}
                                                                                            </option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-1"></div>
                                                                                <div class="col-3">
                                                                                    <label>Charge</label>
                                                                                    <input type="text" class="form-control anotherBill" name="anotherBill[]" 
                                                                                    value="{{ old('anotherBill.' . $index, $data->charge) }}" placeholder="...">
                                                                                </div>
                                                                                <div class="col-1"></div>
                                                                                <div class="col-4">
                                                                                    <label>Note</label>
                                                                                    <input type="text" class="form-control anotherBillNote" name="anotherBillNote[]" 
                                                                                    value="{{ old('anotherBillNote.' . $index, $data->note) }}" placeholder="...">                    
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Template for input another bill -->
                                                            <template id="inputGroupTemplate">
                                                                <input type="hidden" name="idAnotherBill[]" value="">
                                                                <input type="hidden" name="dateAnotherBL[]" value="{{ $date }}">
                                                                <div class="input-group input-group-static mb-4">
                                                                    <div class="col-3">
                                                                        <label>Desc</label>
                                                                        <div class="input-group input-group-static">
                                                                            <select class="form-select" name="id_desc[]" 
                                                                            style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                                                                <option value="">...</option>
                                                                                @foreach ($descs as $d)
                                                                                <option value="{{ $d->id_desc }}" {{ old('id_desc') == $d->id_desc ? 'selected' : '' }}>{{ $d->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-1"></div>
                                                                    <div class="col-3">
                                                                        <label>Charge</label>
                                                                        <input type="text" class="form-control anotherBill" name="anotherBill[]" placeholder="...">                    
                                                                    </div>
                                                                    <div class="col-1"></div>
                                                                    <div class="col-4">
                                                                        <label>Note</label>
                                                                        <input type="text" class="form-control anotherBillNote" name="anotherBillNote[]" placeholder="...">                    
                                                                    </div>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p>No data can be processed</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-6">
                                <h5 class="text-sm">Basic Setup</h5>
                                <input type="hidden" name="id" value="{{ $seaShipment->id_sea_shipment }}">
                                <input type="hidden" name="dateBL" value="{{ $seaShipment->date }}">
                                <div class="input-group input-group-static mb-4">
                                    <label>Invoice No. <span class="text-danger">*</span></label>
                                    @if ($seaShipment->no_inv)
                                        <input type="text" class="form-control" name="inv_no" value="{{ old('inv_no', $seaShipment->no_inv) }}" placeholder="..." required>
                                    @else
                                        <input type="text" class="form-control" name="inv_no" value="{{ old('inv_no', $seaShipment->id_sea_shipment) }}" placeholder="..." required>
                                    @endif
                                </div>
            
                                <div class="input-group input-group-static mb-1">
                                    <label class="text-sm">Company <span class="text-danger">*</span></label>
                                </div>
                                <div class="input-group input-group-static mb-4">
                                    <select class="form-select select-company" name="id_company" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;" required>
                                        <option value="">...</option>
                                        @foreach ($companies as $c)
                                        <option value="{{ $c->id_company }}" {{ old('id_company', $customer->id_company) == $c->id_company ? 'selected' : '' }}>{{ $c->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="input-group input-group-static mb-4">
                                    <div class="col-5">
                                        <label>Term <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="term" name="term" min="1" value="{{ old('term', $seaShipment->term) }}" placeholder="..." required>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-6">
                                        <label>Payment Due</label>
                                        <input type="date" class="form-control" id="payment_due" name="payment_due" value="{{ old('payment_due', $seaShipment->etd) }}" readonly>
                                    </div>
                                </div>
            
                                <div class="input-group input-group-static mb-4">
                                    <div class="col-5">
                                        <div class="input-group input-group-static mb-1">
                                            <label class="text-sm">Banker</label>
                                        </div>
                                        <select class="form-select select-banker" name="id_banker" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                            <option value="">...</option>
                                            @foreach ($bankers as $b)
                                            <option value="{{ $b->id_banker }}" {{ old('id_banker', $customer->id_banker) == $b->id_banker ? 'selected' : '' }}>{{ $b->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-1"></div>
                                    <div class="col-6">
                                        <div class="input-group input-group-static mb-1">
                                            <label class="text-sm">Account</label>
                                        </div>
                                        <select class="form-select select-account" name="id_account" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                            <option value="">...</option>
                                            @foreach ($accounts as $a)
                                            <option value="{{ $a->id_account }}" {{ old('id_account', $customer->id_account) == $a->id_account ? 'selected' : '' }}>{{ $a->account_no }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
        
                                <div class="input-group input-group-static">
                                    <div>
                                        <button id="addButton" class="btn btn-outline-primary btn-sm" type="button">
                                            <span class="btn-inner--text">+ Add another bill</span>
                                        </button>
                                    </div>
        
                                    <div id="inputGroupContainer" class="input-group input-group-static">
                                        <!-- Input groups (another bill) will be appended here -->
                                        @php
                                            $checkSeaShipmentAnotherBill = null;
                                            if (isset($seaShipmentAnotherBill) && count($seaShipmentAnotherBill) > 0) {
                                                $checkSeaShipmentAnotherBill = $seaShipmentAnotherBill->where('id_sea_shipment', $seaShipment->id_sea_shipment)->all();
                                            }
                                        @endphp
                                        @if($checkSeaShipmentAnotherBill && count($checkSeaShipmentAnotherBill) > 0)
                                            @foreach($checkSeaShipmentAnotherBill as $data)
                                                <input type="hidden" name="idAnotherBill[]" value="{{ $data->id_sea_shipment_other_bill }}">
                                                <input type="hidden" name="dateAnotherBL[]" value="{{ $seaShipment->date }}">
                                                <div class="input-group input-group-static mb-4">
                                                    <div class="col-3">
                                                        <div class="input-group input-group-static mb-1">
                                                            <label class="text-sm">Desc</label>
                                                        </div>
                                                        <div class="input-group input-group-static mb-0">
                                                            <select class="form-select" name="id_desc[]" 
                                                            style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                                                <option value="">...</option>
                                                                @foreach ($descs as $d)
                                                                <option value="{{ $d->id_desc }}" {{ old('id_desc.' . $loop->index, $data->id_desc) == 
                                                                    $d->id_desc ? 'selected' : '' }}>{{ $d->name }}
                                                                </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-1"></div>
                                                    <div class="col-3">
                                                        <label>Charge</label>
                                                        <input type="text" class="form-control anotherBill" name="anotherBill[]" 
                                                        value="{{ old('anotherBill.' . $loop->index, $data->charge) }}" placeholder="...">
                                                    </div>
                                                    <div class="col-1"></div>
                                                    <div class="col-4">
                                                        <label>Note</label>
                                                        <input type="text" class="form-control anotherBillNote" name="anotherBillNote[]" 
                                                        value="{{ old('anotherBillNote.' . $loop->index, $data->note) }}" placeholder="...">                    
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
        
                                <!-- Template for input another bill -->
                                <template id="inputGroupTemplate">
                                    <input type="hidden" name="idAnotherBill[]" value="">
                                    <input type="hidden" name="dateAnotherBL[]" value="{{ $seaShipment->date }}">
                                    <div class="input-group input-group-static mb-4">
                                        <div class="col-3">
                                            <div class="input-group input-group-static mb-1">
                                                <label class="text-sm">Desc</label>
                                            </div>
                                            <div class="input-group input-group-static mb-0">
                                                <select class="form-select" name="id_desc[]" 
                                                style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                                    <option value="">...</option>
                                                    @foreach ($descs as $d)
                                                    <option value="{{ $d->id_desc }}" {{ old('id_desc') == $d->id_desc ? 'selected' : '' }}>{{ $d->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-1"></div>
                                        <div class="col-3">
                                            <label>Charge</label>
                                            <input type="text" class="form-control anotherBill" name="anotherBill[]" placeholder="...">                    
                                        </div>
                                        <div class="col-1"></div>
                                        <div class="col-4">
                                            <label>Note</label>
                                            <input type="text" class="form-control anotherBillNote" name="anotherBillNote[]" placeholder="...">                    
                                        </div>
                                    </div>
                                </template>
                                
                                <div class="input-group input-group-static">
                                    <div class="form-check form-check-inline" style="padding-left: 0;">
                                        <input type="hidden" name="is_weight" value="{{ $seaShipment->is_weight }}">
                                        <input type="hidden" name="is_bill_weight" value="{{ $customer->is_bill_weight }}">
                                        <input class="form-check-input" type="checkbox" id="isWeight">
                                        <label class="form-check-label mb-1 mx-2" for="isWeight">Click to switch billing by <span class="text-primary">heavy</span></label>
                                        @if ($isWeight)
                                            <label class="form-check-label mb-1 text-xs">Recommended to enable heavy billing - 
                                                Total Weight <b>{{ $totalWeightOverall / 1000 }} T</b> <u>></u> Total CBM <b>{{ $totalCbmOverall }} M3</b>
                                            </label>
                                        @else
                                            @if ($customer->is_bill_weight)
                                            <label class="form-check-label mb-1 text-xs">This particular customer has been set up for heavy-based billing</label>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <h5 class="text-sm">Fee Setup</h5>
                                <!-- Tagihan customer -->
                                @if (count($pricelist) > 0)
                                    <div class="input-group input-group-static">
                                        <label class="text-sm">Customer Bill <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="input-group input-group-static mb-4">
                                        <div class="col-5">
                                            <select class="form-select select-diff" name="pricelist" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                                <option value="">...</option>
                                                @foreach ($pricelist as $p)
                                                <option 
                                                    value="{{ $p->id_pricelist }}" {{ old('pricelist', $seaShipment->pricelist) == $p->id_pricelist ? 'selected' : '' }}>
                                                    {{ 'Rp ' . number_format($p->price ?? 0, 0, ',', '.') }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-1"></div>
                                        <div class="col-6">
                                            <input type="text" class="form-control custom_pricelist" style="margin-top: 2.5px;" name="custom_pricelist" 
                                            placeholder="Enter special price..">
                                        </div>
                                    </div>
                                @else
                                    <div class="input-group input-group-static mb-4">
                                        <label class="text-sm" style="margin-bottom: 1.5px;">Customer Bill <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control custom_pricelist" name="custom_pricelist" placeholder="Enter price.." required>
                                    </div>
                                @endif

                                <!-- cas -->
                                <!-- @if (count($groupedLTS) > 0)
                                    <div class="accordion-1">
                                        <div class="row">
                                            <div class="accordion" id="accordionLTS">
                                                <div class="accordion-item mb-4">
                                                    <div class="accordion-header" id="headingOne" style="margin-top: -5px;">
                                                        <label style="margin-left: 0; margin-top: 9px;">Additional Bill</label>
                                                        <button class="accordion-button border-bottom font-weight-bold collapsed" type="button" data-bs-toggle="collapse" 
                                                            data-bs-target="#collapseOneLTS" aria-expanded="false" aria-controls="collapseOneLTS" 
                                                            style="padding: 0rem 0.5rem;">
                                                            <label class="font-weight-normal" style="margin-left: -7.5px;">
                                                                <b style="color: #344767;">List Cas LTS</b>
                                                            </label>
                                                            <i class="collapse-close fa fa-plus text-xs pt-1 position-absolute end-0 me-3 collapse-icon" aria-hidden="true"></i>
                                                            <i class="collapse-open fa fa-minus text-xs pt-1 position-absolute end-0 me-3 collapse-icon d-none" aria-hidden="true"></i>
                                                        </button>
                                                    </div>

                                                    <div id="collapseOneLTS" class="accordion-collapse collapse" aria-labelledby="headingOne" 
                                                    data-bs-parent="#accordionLTS">
                                                        <div class="accordion-body" style="padding: 0.3rem 0rem 0rem;">
                                                        @foreach ($groupedLTS as $data)
                                                            @if ($data)
                                                            <div class="input-group input-group-static mb-1">
                                                                    <div class="col-5">
                                                                        <input type="text" class="form-control lts_code" name="lts_code[]" value="{{ $data }}" readonly>
                                                                    </div>
                                                                    <div class="col-1"></div>
                                                                    <div class="col-6">
                                                                        <input type="text" class="form-control lts_bill" name="lts_bill[]" placeholder="Enter price..">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif -->
                            </div>
                        </div>
                    @endif
                    
                    <hr>
                    <div class="text-start mt-4">
                        @php
                            $hasNullState = $seaShipmentLines->whereNull('id_state')->isNotEmpty();
                        @endphp
                        <button type="submit" class="btn bg-gradient-primary btn-sm" name="is_update" value="true" {{ $hasNullState ? '' : 'disabled' }}>Update Data</button>
                        <button type="submit" class="btn bg-gradient-secondary btn-sm ms-2" name="is_print" value="true" {{ $hasNullState ? '' : 'disabled' }}>Print Invoice</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Error -->
@if(session('isValid') === false)
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'The shipment data entered is already in the system',
            position: 'top',
            width: '445px',
            toast: true,
            showConfirmButton: false,
            timer: 6500,
            timerProgressBar: true,
            customClass: {
                container: 'swal2-top-end-container'
            }
        });
    </script>
@endif

<style>
    .drop-container {
        position: relative;
        display: flex;
        gap: 10px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 150px;
        width: 100%;
        padding: 20px;
        border-radius: 10px;
        border: 1.5px dashed #555;
        color: #444;
        cursor: pointer;
        transition: background .2s ease-in-out, border .2s ease-in-out;
    }

    .drop-container:hover {
        background: #eee;
        border-color: #111;
    }

    .drop-container:hover .drop-title {
        color: #222;
    }

    .drop-title {
        color: #444;
        font-size: 20px;
        font-weight: bold;
        text-align: center;
        transition: color .2s ease-in-out;
    }

    .error-highlight {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
    }

</style>

<script>
    // select2
    $(document).ready(function() {
        $('.select-cust').select2();
        $('.select-shipper').select2();
        $('.select-origin').select2();
        $('.select-ship').select2({
            tags: true
        });
    });

    function confirmShipmentLineDelete(id, number) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You sure you want to delete the data in row ' + number + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                let deleteUrl = '{{ url("sea_shipment_line-delete") }}/' + id;
                window.location.href = deleteUrl;
            }
        });
    }

    function confirmDeleteFile(encryptedId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to delete route with the encrypted ID
                window.location.href = '/sea_shipment/delete-file/' + encryptedId;
            }
        })
    }

    $('.select-cust').change(function() {
        var selectedCustomerId = $(this).val();
        var selectedCustomerShipperIds = $('option:selected', this).data('shipper-ids');

        var $selectShipper = $('.select-shipper');
        $('.select-shipper').val(null).trigger('change');
        $selectShipper.find('option').prop('disabled', true);

        if (selectedCustomerShipperIds) {
            if (typeof selectedCustomerShipperIds === 'string') {
                var shipperIdsArray = selectedCustomerShipperIds.split(',');

                $.each(shipperIdsArray, function(index, value) {
                    var shipperName = $('option[value="' + value + '"]', $selectShipper).text();
                    var existingOption = $selectShipper.find('option[value="' + value + '"]');
                    if (existingOption.length) {
                        existingOption.prop('disabled', false);
                    }
                });

            } else {
                var shipperId = selectedCustomerShipperIds;
                var shipperName = $('option[value="' + shipperId + '"]', $selectShipper).text();
                var existingOption = $selectShipper.find('option[value="' + shipperId + '"]');
                if (existingOption.length) {
                    existingOption.prop('disabled', false);
                }
            }
        }
    });

    // Function to update total ships
    function updateTotalShips() {
        var blDates = [];
        var rows = document.querySelectorAll('input[name="bldate[]"]');

        rows.forEach(function(row) {
            if (row.value.trim() !== '') {
                blDates.push(row.value.trim());
            }
        });

        var uniqueBlDates = Array.from(new Set(blDates));
        document.querySelector('input[name="tot_ships"]').value = uniqueBlDates.length;
    }

    updateTotalShips();

    var blDateInputs = document.querySelectorAll('input[name="bldate[]"]');
    blDateInputs.forEach(function(input) {
        input.addEventListener('change', updateTotalShips);
    });

    // Function to update total packages
    function calculateTotalPackages() {
        var totalPackages = 0;
        var rows = document.querySelectorAll('input[name="qty_pkgs[]"]');
        
        rows.forEach(function(row) {
            if (row.value.trim() !== '') {
                totalPackages += parseInt(row.value) || 0;
            }
        });

        document.querySelector('input[name="tot_pkgs"]').value = totalPackages;
    }

    calculateTotalPackages();

    // Function to update total weight
    function calculateTotalWeight() {
        var totalWeight = 0;
        var rows = document.querySelectorAll('input[name="weight[]"]');
        
        rows.forEach(function(row) {
            if (row.value.trim() !== '') {
                totalWeight += parseFloat(row.value) || 0;
            }
        });

        document.querySelector('input[name="tot_weight"]').value = totalWeight / 1000;
    }

    calculateTotalWeight();

    // Function to update total volume
    function calculateTotalVolume() {
        var totalVolume = 0;
        var rows = document.querySelectorAll('tr');
        var volumel = 0;

        rows.forEach(function(row) {
            var inputPl = row.querySelector('input[name="p[]"]');
            var inputLl = row.querySelector('input[name="l[]"]');
            var inputTl = row.querySelector('input[name="t[]"]');
            var inputQtyLoose = row.querySelector('input[name="qty_loose[]"]');

            if (inputPl && inputLl && inputTl && inputQtyLoose) {
                var pl = parseFloat(inputPl.value) || 0;
                var ll = parseFloat(inputLl.value) || 0;
                var tl = parseFloat(inputTl.value) || 0;

                volumel += ((pl * ll * tl) / 1000000) * inputQtyLoose.value;
            }
        });

        document.querySelector('input[name="tot_vol"]').value = volumel.toFixed(3);
    }


    calculateTotalVolume();

    var qtyPkgInputs = document.querySelectorAll('input[name="weight[]"]');
    qtyPkgInputs.forEach(function(input) {
        input.addEventListener('change', calculateTotalWeight);
    });

    // Update CBM
    var inputsP = document.querySelectorAll('input[name="p[]"]');
    var inputsL = document.querySelectorAll('input[name="l[]"]');
    var inputsT = document.querySelectorAll('input[name="t[]"]');

    inputsP.forEach(function(input, index) {
        input.addEventListener('input', function() {
            updateCBM(index);

            // update volume
            calculateTotalVolume();
        });
    });

    inputsL.forEach(function(input, index) {
        input.addEventListener('input', function() {
            updateCBM(index);

            // update volume
            calculateTotalVolume();
        });
    });

    inputsT.forEach(function(input, index) {
        input.addEventListener('input', function() {
            updateCBM(index);

            // update volume
            calculateTotalVolume();
        });
    });

    function updateCBM(index) {
        var row = inputsP[index].closest('tr');
        var p = parseFloat(inputsP[index].value);
        var l = parseFloat(inputsL[index].value);
        var t = parseFloat(inputsT[index].value);

        var volume = ((p * l * t) / 1000000).toFixed(3);

        var inputCBM1 = row.querySelector('input[name="cbm1[]"]');
        var inputCBM2 = row.querySelector('input[name="cbm2[]"]');

        var inputQtyPkgs = row.querySelector('input[name="qty_pkgs[]"]');
        var inputQtyLoose = row.querySelector('input[name="qty_loose[]"]');

        if (inputQtyPkgs.value && inputQtyPkgs.value != '-') {
            inputCBM1.value = volume * inputQtyPkgs.value;
        } else {
            inputCBM1.value = '';
        }

        if (inputQtyLoose.value && inputQtyLoose.value != '-') {
            inputCBM2.value = volume * inputQtyLoose.value;
        } else {
            inputCBM2.value = '';
        }
    }

    // set value unit qty pkgs and unit qty looose
    var QtyPkgs = document.querySelectorAll('input[name="qty_pkgs[]"]');
    QtyPkgs.forEach(function(input, index) {
        input.addEventListener('change', function() {
            // update CBM
            updateCBM(index);

            // update total package
            calculateTotalPackages();

            var row = input.closest('tr');
            var unitQtyPkgs = row.querySelector('select[name="id_uom_pkgs[]"]');

            if (!input.value || input.value === '0') {
                unitQtyPkgs.value = '';
                unitQtyPkgs.removeAttribute('required');

            } else {
                unitQtyPkgs.setAttribute('required', 'required');
            }
        });
    });

    var QtyLoose = document.querySelectorAll('input[name="qty_loose[]"]');
    QtyLoose.forEach(function(input, index) {
        input.addEventListener('change', function() {
            // update CBM
            updateCBM(index);

            // update volume
            calculateTotalVolume();
            
            var row = QtyLoose[index].closest('tr');
            var unitQtyLoose = row.querySelector('select[name="id_uom_loose[]"]');

            if (!input.value || input.value === '0') {
                unitQtyLoose.value = '';
                unitQtyLoose.removeAttribute('required');

            }else {
                unitQtyLoose.setAttribute('required', 'required');
            }
        });
    });

    // Function to add days to a date
    function addDays(date, days) {
        var result = new Date(date);
        result.setDate(result.getDate() + days);
        return result;
    }

    // Original payment due date
    var paymentDueElement = document.getElementById('payment_due');
    var originalPaymentDue = null;

    if (paymentDueElement) {
        originalPaymentDue = paymentDueElement.value;
    }

    // Function to update payment due date based on term
    function updatePaymentDue() {
        var term = parseInt(document.getElementById('term').value);

        if (!isNaN(term) && term > 0) {
            var newPaymentDue = addDays(originalPaymentDue, term);
            document.getElementById('payment_due').valueAsDate = newPaymentDue;

        } else {
            var paymentDueElement = document.getElementById('payment_due');
            if (paymentDueElement) {
                document.getElementById('payment_due').valueAsDate = new Date(originalPaymentDue);
            }
        }
    }

    // Event listener for term input
    var termElement = document.getElementById('term');

    if (termElement) {
        termElement.addEventListener('input', updatePaymentDue);
    }

    // Currency
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

    // Function to check the LTS input and add/remove required attribute
    function checkLTS(element) {
        const ltsValue = element.value.toUpperCase();
        const parentRow = element.closest('tr');
        const qtyInput = parentRow.querySelector('.input-qty');
        const selectUnit = parentRow.querySelector('.select-unit');

        if (!['LP', 'LPI', 'LPM', 'LPM/LPI', 'LPI/LPM'].includes(ltsValue)) {
            qtyInput.removeAttribute('required');

            // Remove qty
            if (qtyInput.value) {
                qtyInput.value = null;
            }

            // Remove select unit
            const selectedOption = selectUnit.options[selectUnit.selectedIndex];
            const selectedName = selectedOption.getAttribute('data-name');

            const pcsOption = selectUnit.querySelector('option[data-name=""]');
            pcsOption.selected = true;

        } else {
            qtyInput.setAttribute('required', 'required');

            // Set select unit to PCS
            const selectedOption = selectUnit.options[selectUnit.selectedIndex];
            const selectedName = selectedOption.getAttribute('data-name');

            if (selectedName !== 'PCS') {
                const pcsOption = selectUnit.querySelector('option[data-name="PCS"]');
                if (pcsOption) {
                    pcsOption.selected = true;
                }
            }
        }
    }

    // Function to check unit
    function checkUnit(element) {
        const parentRow = element.closest('tr');
        const selectUnit = parentRow.querySelector('.select-unit');
        const inputWeight = parentRow.querySelector('.input-weight');

        const selectedOption = selectUnit.options[selectUnit.selectedIndex];
        const selectedName = selectedOption.getAttribute('data-name');

        if (!['T'].includes(selectedName)) {
            inputWeight.removeAttribute('required');

        } else {
            inputWeight.setAttribute('required', 'required');
        }
    }

    // Configuration changed bill by weight
    var isSwitchBillingWeight = document.getElementById('isWeight');
    if (isSwitchBillingWeight) {
        isSwitchBillingWeight.addEventListener('click', function () {
            var isWeightInvoice = isSwitchBillingWeight.checked ? 1 : 0;
            var hiddenValueIsWeightInvoice = document.querySelector("input[name='is_weight']");
            hiddenValueIsWeightInvoice.value = isWeightInvoice;
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Checkbox switch billing by weight
        var totalWeight = document.querySelector("input[name='tot_weight']");
        var isSwitchBillingWeight = document.getElementById('isWeight');
        var hiddenValueIsWeightInvoice = document.querySelector("input[name='is_weight']");
        var hiddenValueIsBillWeightInvoice = document.querySelector("input[name='is_bill_weight']");

        // Set up in customer
        if (hiddenValueIsBillWeightInvoice) {
            if (hiddenValueIsBillWeightInvoice.value && hiddenValueIsBillWeightInvoice.value === '1') {
                isSwitchBillingWeight.checked = true;
            }
        }

        // Set up in shipment
        if (hiddenValueIsWeightInvoice) {
            if (hiddenValueIsWeightInvoice.value && hiddenValueIsWeightInvoice.value !== '0') {
                isSwitchBillingWeight.checked = true;
            }
        }

        if (totalWeight.value === '0') {
            if (isSwitchBillingWeight) {
                isSwitchBillingWeight.setAttribute('disabled', 'disabled');
                isSwitchBillingWeight.checked = false;
                hiddenValueIsWeightInvoice.value = 0;
            }

        } else {
            if (isSwitchBillingWeight) {
                isSwitchBillingWeight.removeAttribute('disabled', 'disabled');
            }
        }

        // Form 
        const form = document.getElementById('seaShipmentForm');
        if (form) {
            form.addEventListener('submit', function(event) {
                const isPrintButton = event.submitter.name === 'is_print';
                if (isPrintButton) {
                    form.setAttribute('target', '_blank');
                } else {
                    form.removeAttribute('target');
                }
            });
        }
        
        // Function to add days to a date
        function addDays(date, days) {
            var result = new Date(date);
            result.setDate(result.getDate() + days);
            return result;
        }

        // Original payment due date
        var paymentDueElement = document.getElementById('payment_due');
        var originalPaymentDue = null;

        if (paymentDueElement) {
            originalPaymentDue = paymentDueElement.value;
        }

        // Function to update payment due date based on term
        var termElement = document.getElementById('term');
        var term = 0;
        if (termElement) {
            var termValue = termElement.value;
            if (!isNaN(termValue)) {
                term = parseInt(termValue, 10);
            }
        }

        if (!isNaN(term) && term > 0) {
            var newPaymentDue = addDays(originalPaymentDue, term);
            document.getElementById('payment_due').valueAsDate = newPaymentDue;

        } else {
            var paymentDueElement = document.getElementById('payment_due');
            if (paymentDueElement) {
                document.getElementById('payment_due').valueAsDate = new Date(originalPaymentDue);
            }
        }

        function formatInputs() {
            let priceBillDiff = document.querySelectorAll(".custom_bill_diff");
            priceBillDiff.forEach(function(billDiff) {
                if (billDiff.value.trim() !== "") {
                    billDiff.value = formatCurrency(billDiff.value);
                }
                billDiff.addEventListener("input", function() {
                    if (this.value.trim() !== "") {
                        this.value = formatCurrency(this.value);
                    }
                });
            });

            let pricelist = document.querySelectorAll(".custom_pricelist");
            pricelist.forEach(function(priceC) {
                if (priceC.value.trim() !== "") {
                    priceC.value = formatCurrency(priceC.value);
                }
                priceC.addEventListener("input", function() {
                    if (this.value.trim() !== "") {
                        this.value = formatCurrency(this.value);
                    }
                });
            });

            // let ltsBill = document.querySelectorAll(".lts_bill");
            // ltsBill.forEach(function(lts) {
            //     if (lts.value.trim() !== "") {
            //         lts.value = formatCurrency(lts.value);
            //     }
            //     lts.addEventListener("input", function() {
            //         if (this.value.trim() !== "") {
            //             this.value = formatCurrency(this.value);
            //         }
            //     });
            // });

            let priceBillTransport = document.querySelectorAll(".transport");
            priceBillTransport.forEach(function(billTransport) {
                if (billTransport.value.trim() !== "") {
                    billTransport.value = formatCurrency(billTransport.value);
                }
                billTransport.addEventListener("input", function() {
                    if (this.value.trim() !== "") {
                        this.value = formatCurrency(this.value);
                    }
                });
            });

            let pricebl = document.querySelectorAll(".bl");
            pricebl.forEach(function(bl) {
                if (bl.value.trim() !== "") {
                    bl.value = formatCurrency(bl.value);
                }
                bl.addEventListener("input", function() {
                    if (this.value.trim() !== "") {
                        this.value = formatCurrency(this.value);
                    }
                });
            });

            let pricepermit = document.querySelectorAll(".permit");
            pricepermit.forEach(function(permit) {
                if (permit.value.trim() !== "") {
                    permit.value = formatCurrency(permit.value);
                }
                permit.addEventListener("input", function() {
                    if (this.value.trim() !== "") {
                        this.value = formatCurrency(this.value);
                    }
                });
            });

            let priceinsurance = document.querySelectorAll(".insurance");
            priceinsurance.forEach(function(insurance) {
                if (insurance.value.trim() !== "") {
                    insurance.value = formatCurrency(insurance.value);
                }
                insurance.addEventListener("input", function() {
                    if (this.value.trim() !== "") {
                        this.value = formatCurrency(this.value);
                    }
                });
            });

            let priceAnotherBill = document.querySelectorAll(".anotherBill");
            priceAnotherBill.forEach(function(anotherBill) {
                if (anotherBill.value.trim() !== "") {
                    anotherBill.value = formatCurrency(anotherBill.value);
                }
                anotherBill.addEventListener("input", function() {
                    if (this.value.trim() !== "") {
                        this.value = formatCurrency(this.value);
                    }
                });
            });
        }

        $('#setPrintModal').on('shown.bs.modal', function() {
            formatInputs();
        });

        var accordionButtons = document.querySelectorAll('.accordion-button');

        accordionButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                var icons = this.querySelectorAll('.collapse-icon');
                icons.forEach(function (icon) {
                    icon.classList.toggle('d-none');
                });
            });
        });

        // Apply the checkLTS function on page load for existing values
        document.querySelectorAll('.input-lts').forEach(function(input) {
            input.addEventListener('change', function() {
                checkLTS(input);
            });
        });

        // Apply the checkUnit function on page load for existing values
        document.querySelectorAll('.select-unit').forEach(function(select) {
            select.addEventListener('change', function() {
                checkUnit(select);
            });
        });

        // Add to another bill
        const accordionItems = document.querySelectorAll('.accordion-item');
        if (accordionItems.length > 0) {
            accordionItems.forEach(item => {
                const addButton = item.querySelector('#addButton');
                const inputGroupContainer = item.querySelector('#inputGroupContainer');
                const inputGroupTemplate = item.querySelector('#inputGroupTemplate');

                if (addButton && inputGroupContainer && inputGroupTemplate) {
                    // Disable addButton initially
                    addButton.disabled = true;

                    item.addEventListener('show.bs.collapse', function () {
                        // Enable addButton when the accordion-item is opened
                        addButton.disabled = false;
                    });

                    item.addEventListener('hide.bs.collapse', function () {
                        // Disable addButton when the accordion-item is closed
                        addButton.disabled = true;
                    });

                    addButton.addEventListener('click', function() {
                        const newInputGroup = document.importNode(inputGroupTemplate.content, true);
                        inputGroupContainer.appendChild(newInputGroup);
                        formatInputs();
                    });
                }
            });

        } else {
            const addButton = document.getElementById('addButton');
            const inputGroupContainer = document.getElementById('inputGroupContainer');

            const inputGroupTemplateElement = document.getElementById('inputGroupTemplate');
            if (inputGroupTemplateElement) {
                const inputGroupTemplate = inputGroupTemplateElement.content;
            }
    
            if (addButton) {
                addButton.addEventListener('click', function() {
                    const newInputGroup = document.importNode(inputGroupTemplate.content, true);
                    inputGroupContainer.appendChild(newInputGroup);
                    formatInputs();
                });
            }
        }

    });

    // Check LTS = LP, LPI, LPM, LPM/LPI, LPI/LPM
    var setupButton = document.querySelector('.btn-setup');
    if (setupButton) {
        setupButton.addEventListener('click', function(event) {
            let isValid = true;
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const ltsInput = row.querySelector('.input-lts');
                const qtyInput = row.querySelector('.input-qty');
                const unitInput = row.querySelector('.select-unit');

                // Menambahkan dan menghapus tanda merah
                const errorClass = 'error-highlight';

                if (ltsInput && qtyInput && unitInput) {
                    const lts = ltsInput.value;
                    const qty = qtyInput.value;
                    const unit = unitInput.value;

                    if (['LP', 'LPM', 'LPI', 'LPM/LPI', 'LPI/LPM'].includes(lts)) {
                        qtyInput.required = true;
                        unitInput.required = true;

                        // Menandai baris dengan masalah
                        if (!qty || !unit) {
                            isValid = false;
                            row.classList.add(errorClass);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Please fill in the Qty and Unit fields for LTS values LP, LPM, LPI, LPM/LPI or LPI/LPM',
                                position: 'top',
                                width: '655px',
                                toast: true,
                                showConfirmButton: false,
                                timer: 7500,
                                timerProgressBar: true,
                                customClass: {
                                    container: 'swal2-top-end-container'
                                }
                            });
                        } else {
                            // Menghapus tanda merah jika sudah diisi
                            row.classList.remove(errorClass);
                        }
                    } else {
                        qtyInput.required = false;
                        unitInput.required = false;
                        row.classList.remove(errorClass); // Pastikan tanda merah dihapus untuk LTS yang tidak memerlukan Qty dan Unit
                    }
                }
            });

            if (isValid) {
                const printModal = new bootstrap.Modal(document.getElementById('setPrintModal'));
                printModal.show();
            }
        });
    }

    // Add new line
    document.getElementById('addRowButton').addEventListener('click', function () {
        const tableBody = document.getElementById('shipmentTableBody');
        const rowCount = tableBody.rows.length + 1;

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
        <input type="hidden" name="id_sea_shipment_line[]" value="">
        <td class="align-middle text-center text-sm" width="2.5%">
            <div class="d-flex px-3 py-1 row-number">${rowCount}.</div>
        </td>
        <td class="align-middle text-center" width="7.5%">
            <input type="date" class="form-control text-center" name="bldate[]" value="" style="border: 0px;" required>
        </td>
        <td class="align-middle text-center" width="7.5%">
            <input type="text" class="form-control text-center" name="code[]" value="" 
            oninput="this.value = this.value.toUpperCase()" placeholder="..." style="border: 0px;">
        </td>
        <td class="align-middle text-center" width="15.5%">
            <input type="text" class="form-control text-center" name="marking[]" value="" 
            oninput="this.value = this.value.toUpperCase()" placeholder="..." style="border: 0px;">
        </td>
        <!-- qty -->
        <td class="align-middle text-center" width="5%">
            <input type="number" class="form-control text-center" name="qty_pkgs[]" value="" 
            placeholder="..." style="border: 0px;" min="1">
        </td>
        <td class="align-middle" width="5%">
            <select class="form-select text-center text-xs" name="id_uom_pkgs[]" style="border: 0px;">
                <option value="" data-name="">-</option>
                @foreach ($uoms as $o)
                <option value="{{ $o->id_uom }}" data-name="{{ $o->name }}" 
                    {{ old('id_uom_pkgs') == $o->id_uom ? 'selected' : '' }}>{{ $o->name }}
                </option>
                @endforeach
            </select>
        </td>
        <td class="align-middle text-center" width="5%">
            <input type="number" class="form-control text-center" name="qty_loose[]" value="" 
            placeholder="..." style="border: 0px;" min="1">
        </td>
        <td class="align-middle" width="5%">
            <select class="form-select text-center text-xs" name="id_uom_loose[]" style="border: 0px;">
                <option value="" data-name="">-</option>
                @foreach ($uoms as $o)
                <option value="{{ $o->id_uom }}" data-name="{{ $o->name }}" 
                    {{ old('id_uom_loose') == $o->id_uom ? 'selected' : '' }}>{{ $o->name }}
                </option>
                @endforeach
            </select>
        </td>
        <!-- ### -->
        <td class="align-middle text-center" width="5%">
            <input type="text" class="form-control text-center input-weight" name="weight[]" value="" placeholder="..." style="border: 0px;">
        </td>
        <!-- dimension -->
        <td class="align-middle text-center" width="5%">
            <input type="number" class="form-control text-center" name="p[]" value="" 
            placeholder="..." style="border: 0px;" min="1" required>
        </td>
        <td class="align-middle text-center" width="5%">
            <input type="number" class="form-control text-center" name="l[]" value="" 
            placeholder="..." style="border: 0px;" min="1" required>
        </td>
        <td class="align-middle text-center" width="5%">
            <input type="number" class="form-control text-center" name="t[]" value="" 
            placeholder="..." style="border: 0px;" min="1" required>
        </td>
        <!-- ### -->
        <!-- total cbm -->
        <td class="align-middle text-center" width="5%">
            <input type="text" class="form-control text-center" name="cbm1[]" value="" placeholder="..." style="border: 0px;">
        </td>
        <td class="align-middle text-center" width="5%">
            <input type="text" class="form-control text-center" name="cbm2[]" value="" placeholder="..." style="border: 0px;">
        </td>
        <!-- ### -->
        <td class="align-middle text-center" width="5%">
            <input type="text" class="form-control text-center input-lts" name="lts[]" value="" 
            oninput="this.value = this.value.toUpperCase(); checkLTS(this);" placeholder="..." style="border: 0px;">
        </td>
        <td class="align-middle text-center" width="5%">
            <input type="number" class="form-control text-center input-qty" name="qty[]" value="" min="1" placeholder="..." style="border: 0px;">
        </td>
        <td class="align-middle" width="5%">
            <select class="form-select text-center text-xs select-unit" name="id_unit[]" style="border: none;">
                <option value="" data-name="">-</option>
                @foreach ($units as $u)
                <option value="{{ $u->id_unit }}" data-name="{{ $u->name }}">{{ $u->name }}</option>
                @endforeach
            </select>
        </td>
        <td class="align-middle text-center" width="7.5%">
            <input type="text" class="form-control text-center" name="desc[]" value="" placeholder="..." style="border: 0px;">
        </td>
        <td class="align-middle" width="7.5%">
            <select class="form-select text-center text-xs select-state" name="id_state[]" style="border: 0px;">
                <option value="" data-name="">-</option>
                @foreach ($states as $s)
                <option value="{{ $s->id_state }}" data-name="{{ $s->name }}" 
                    {{ old('id_state') == $s->id_state ? 'selected' : '' }}>{{ $s->name }}
                </option>
                @endforeach
            </select>
        </td>
        <td class="align-middle text-center">
            <a href="javascript:void(0);" onclick="confirmNewShipmentLineDelete(this)">
                <i class="material-icons text-primary position-relative text-lg">delete</i>
            </a>
        </td>
        `;
        tableBody.appendChild(newRow);

        // Update row numbers for all rows
        updateRowNumbers();

        // Trigger function
        updateTotalShips();
        calculateTotalPackages();
        calculateTotalWeight();
        calculateTotalVolume();

        // Update CBM
        var inputsP = document.querySelectorAll('input[name="p[]"]');
        var inputsL = document.querySelectorAll('input[name="l[]"]');
        var inputsT = document.querySelectorAll('input[name="t[]"]');

        inputsP.forEach(function(input, index) {
            input.addEventListener('input', function() {
                updateCBM(index);

                // update volume
                calculateTotalVolume();
            });
        });

        inputsL.forEach(function(input, index) {
            input.addEventListener('input', function() {
                updateCBM(index);

                // update volume
                calculateTotalVolume();
            });
        });

        inputsT.forEach(function(input, index) {
            input.addEventListener('input', function() {
                updateCBM(index);

                // update volume
                calculateTotalVolume();
            });
        });

        function updateCBM(index) {
            var row = inputsP[index].closest('tr');
            var p = parseFloat(inputsP[index].value);
            var l = parseFloat(inputsL[index].value);
            var t = parseFloat(inputsT[index].value);

            var volume = ((p * l * t) / 1000000).toFixed(3);

            var inputCBM1 = row.querySelector('input[name="cbm1[]"]');
            var inputCBM2 = row.querySelector('input[name="cbm2[]"]');

            var inputQtyPkgs = row.querySelector('input[name="qty_pkgs[]"]');
            var inputQtyLoose = row.querySelector('input[name="qty_loose[]"]');

            if (inputQtyPkgs.value && inputQtyPkgs.value != '-') {
                inputCBM1.value = volume * inputQtyPkgs.value;
            } else {
                inputCBM1.value = '';
            }

            if (inputQtyLoose.value && inputQtyLoose.value != '-') {
                inputCBM2.value = volume * inputQtyLoose.value;
            } else {
                inputCBM2.value = '';
            }
        }

        // set value unit qty pkgs and unit qty looose
        var QtyPkgs = document.querySelectorAll('input[name="qty_pkgs[]"]');
        QtyPkgs.forEach(function(input, index) {
            input.addEventListener('change', function() {
                // update CBM
                updateCBM(index);

                // update total package
                calculateTotalPackages();

                var row = input.closest('tr');
                var unitQtyPkgs = row.querySelector('select[name="id_uom_pkgs[]"]');

                if (!input.value || input.value === '0') {
                    unitQtyPkgs.value = '';
                    unitQtyPkgs.removeAttribute('required');

                } else {
                    unitQtyPkgs.setAttribute('required', 'required');
                }
            });
        });

        var QtyLoose = document.querySelectorAll('input[name="qty_loose[]"]');
        QtyLoose.forEach(function(input, index) {
            input.addEventListener('change', function() {
                // update CBM
                updateCBM(index);

                // update volume
                calculateTotalVolume();
                
                var row = QtyLoose[index].closest('tr');
                var unitQtyLoose = row.querySelector('select[name="id_uom_loose[]"]');

                if (!input.value || input.value === '0') {
                    unitQtyLoose.value = '';
                    unitQtyLoose.removeAttribute('required');

                }else {
                    unitQtyLoose.setAttribute('required', 'required');
                }
            });
        });

        function updateRowNumbers() {
            const rows = document.querySelectorAll('#shipmentTableBody tr');
            rows.forEach((row, index) => {
                const numberCell = row.querySelector('td:first-child div');
                if (numberCell) {
                    numberCell.innerText = `${index + 1}.`;
                }
            });
        }
    });

    // Confirm to delete shipment line
    function confirmNewShipmentLineDelete(element) {
        const row = element.closest('tr');
        const rowNumber = row.querySelector('.row-number').textContent.trim().replace('.', '');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You sure you want to delete row number ' + rowNumber + '?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const row = element.closest('tr');
                row.remove();
                updateRowNumbers();
            }
        });
    }

    // Fungsi untuk memperbarui nomor baris
    function updateRowNumbers() {
        const rows = document.querySelectorAll('#shipmentTableBody tr');
        rows.forEach((row, index) => {
            const numberCell = row.querySelector('.row-number');
            if (numberCell) {
                numberCell.textContent = `${index + 1}.`;
            }
        });
    }

    // Drag or Drop File
    document.addEventListener('DOMContentLoaded', (event) => {
        let dropContainer = document.getElementById('dropcontainer');
        let fileInput = document.getElementById('files');

        if (dropContainer) {
            dropContainer.addEventListener('dragover', (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropContainer.classList.add('dragover');
            });

            dropContainer.addEventListener('dragleave', (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropContainer.classList.remove('dragover');
            });

            dropContainer.addEventListener('drop', (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropContainer.classList.remove('dragover');

                if (e.dataTransfer.files.length) {
                    fileInput.files = e.dataTransfer.files;
                }
            });
        }
    });
</script>
@endsection