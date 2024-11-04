@extends('layouts.base')
<!-- @section('title', 'Air Freight Shipment') -->
@section('content')
<div class="container-fluid py-4" >
    <div class="row" >
        <div>
            @if ($groupAirShipmentLines)
            <!-- <div class="card mb-5">
                <div class="card-header pb-2">
                    <h6> Summary of Air Freight Shipment </h6>
                    <p class="text-sm mb-0">
                        Summary of Air Freight shipment.
                    </p>
                </div>
                <div class="card-body px-4 pt-0 pb-0 mb-3">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">No.</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">BL Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Total CTN</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Total KG</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupAirShipmentLines as $date => $gsl)
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
                                            <span class="text-secondary text-xs font-weight-normal">{{ $gsl['total_qty_loose'] }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-normal">-</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->
            @endif

            <div class="card mt-0 p-0">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-xl mt-n4 me-3 float-start">
                        <i class="material-icons opacity-10">event</i>
                    </div>
                    <h6 class="mb-0">Air Freight Shipment</h6>
                    <p class="text-sm mb-0">
                        List of air freight shipment.
                    </p>
                </div>
                <div class="card-body px-4 pt-0 pb-0">
                    @if ($airShipment)
                    <form id="form-air-freight" method="POST" enctype="multipart/form-data" action="{{ url('air_shipment-update') }}">
                        @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Origin</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vessel SIN</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Ctn</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Kg</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width=5%>
                                            <div class="d-flex px-3 py-1">
                                                <input type="hidden" name="id_air_shipment" value="{{ $airShipment->id_air_shipment }}">
                                                <input type="date" class="form-control" name="date" value="{{ $airShipment->date }}">
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <select class="form-select text-xs select-cust" name="id_customer" required>
                                                <option value="">...</option>
                                                @foreach ($customers as $c)
                                                    <option value="{{ $c->id_customer }}" data-shipper-ids="{{ $c->shipper_ids }}" 
                                                        {{ old('id_customer', $airShipment->id_customer) == $c->id_customer ? 'selected' : '' }}>{{ $c->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center">
                                            <select class="form-select text-xs select-shipper" name="id_shipper" required>
                                                <option value="">...</option>
                                                @foreach ($shippers as $s)
                                                    <option value="{{ $s->id_shipper }}" 
                                                        {{ old('id_shipper', $airShipment->id_shipper) == $s->id_shipper ? 'selected' : '' }}>{{ $s->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center">
                                            <select class="form-select text-xs select-origin" name="id_origin" required>
                                                <option value="">...</option>
                                                @foreach ($origins as $o)
                                                <option value="{{ $o->id_origin }}" 
                                                    {{ old('id_origin', $airShipment->id_origin) == $o->id_origin ? 'selected' : '' }}>{{ $o->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td class="align-middle text-center">
                                            <!-- <select class="form-select text-center text-xs" name="vessel_sin" style="border: 0px;" >
                                                <option value="" {{ old('vessel_sin', $airShipment->vessel_sin) == '' ? 'selected' : '' }}>...</option>
                                                <option value="NARITA/CNG" {{ old('vessel_sin', $airShipment->vessel_sin) == 'NARITA/CNG' ? 'selected' : '' }}> NARITA / CNG </option>
                                            </select> -->
                                            <input type="text" class="form-control text-center" name="vessel_sin" value="{{ $airShipment->vessel_sin }}" placeholder="..." style="border: 0px;">
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="text" class="form-control text-center" name="tot_pkgs" placeholder="..." style="background-color: #fff;" disabled>
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="text" class="form-control text-center" name="tot_loose" placeholder="..." style="background-color: #fff;" disabled>
                                        </td>
                                </tbody>
                            </table>
                        </div>

                        <div class="table-responsive py-3 mt-3">
                            <!-- <h6>List of Shipment Air Freight</h6> -->
                            <p class="text-sm mb-0">
                                <!-- List of air freight shipment. -->
                            </p>
                            <table class="table table-bordered align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">No.</th>
                                        <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">BL Date</th> -->
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Marking</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Koli</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">CTN</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">KG</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Qty</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Unit</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Note</th>
                                    </tr>

                                </thead>
                                <tbody id="shipmentTableBody">
                                    @foreach($airShipmentLines as $asl)
                                    <tr>
                                        <input type="hidden" name="id_air_shipment_line[]" value="{{ $asl->id_air_shipment_line }}">
                                        <td class="align-middle text-center text-sm" width=2%>
                                            <div class="d-flex px-3 py-1">
                                                {{ $loop->iteration }}.
                                            </div>
                                        </td>
                                        <!-- <td class="align-middle text-center" width=7%>
                                            <input type="date" class="form-control text-center" name="bldate[]" value="{{ $asl->date }}" style="border: 0px;" required>
                                        </td> -->
                                        <td class="align-middle text-center" width=15%>
                                            <input type="text" class="form-control text-center" name="marking[]" value="{{ $asl->marking ?? '-' }}" 
                                            oninput="this.value = this.value.toUpperCase()" placeholder="..." style="border: 0px;" required>
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="koli[]" value="{{ $asl->koli }}" 
                                            placeholder="..." style="border: 0px;" min="1">
                                        </td>
                                        <!-- qty -->
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="qty_pkgs[]" value="{{ $asl->qty_pkgs }}" 
                                            placeholder="..." style="border: 0px;" min="1">
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="qty_loose[]" value="{{ $asl->qty_loose }}" 
                                            placeholder="..." style="border: 0px;" min="1">
                                        </td>
                                        <td class="align-middle text-center" width=5%>
                                            <input type="number" class="form-control text-center" name="qty[]" value="{{ $asl->qty }}" 
                                            placeholder="..." style="border: 0px;" min="1">
                                        </td>
                                        <td class="align-middle" width=5%>
                                            <select class="form-select text-center text-xs" name="unit[]" style="border: 0px;">
                                                <option value="" {{ old('unit', $asl->unit) == '' ? 'selected' : '' }}>-</option>
                                                <option value="PCS" {{ old('unit', $asl->unit) == 'PCS' ? 'selected' : '' }}>PCS</option>
                                                <option value="CSE" {{ old('unit', $asl->unit) == 'CSE' ? 'selected' : '' }}>CSE</option>
                                                <option value="CTN" {{ old('unit', $asl->unit) == 'CTN' ? 'selected' : '' }}>CTN</option>
                                                <option value="PKG" {{ old('unit', $asl->unit) == 'PKG' ? 'selected' : '' }}>PKG</option>
                                                <option value="PLT" {{ old('unit', $asl->unit) == 'PLT' ? 'selected' : '' }}>PLT</option>
                                            </select>
                                        </td>
                                        <td class="align-middle text-center" width=12%>
                                            <input type="text" class="form-control text-center" name="note[]" value="{{ $asl->note }}" placeholder="..." style="border: 0px;">
                                        </td>
                                        <td class="align-middle text-center" width=2%>
                                            <a href="javascript:void(0);" onclick="confirmShipmentLineDelete({{ $asl->id_air_shipment_line }}, {{ $loop->iteration }})">
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
                        <div class="d-flex justify-content-center input-group input-group-dynamic mb-3">
                            <div>
                                <label for="files" class="drop-container" id="dropcontainer" >
                                    <span class="drop-title">Drop file here</span>
                                    or
                                    <input type="file" id="files" name="file_shipment_status" accept="application/pdf">
                                </label>
                            </div>
                        </div>
                        
                        <div class="mt-3 mb-3" style="margin-left: 0.01cm;">
                            <span style="font-size: 15.5px; color: #444; font-weight: bold;">Uploaded File</span>
                            @if ($airShipment->file_shipment_status)
                                <ul>
                                    <li>
                                        <a href="{{ asset('storage/' . $airShipment->file_shipment_status) }}" target="_blank">
                                            <span style="font-size: 14.5px;">{{ $airShipment->file_shipment_status }}</span>
                                        </a>
                                        <a class="ms-2" href="javascript:void(0);" onclick="confirmDeleteFile('{{ Crypt::encrypt($airShipment->id_air_shipment) }}')">
                                            <i class="material-icons text-primary position-relative text-lg">delete</i>
                                        </a>
                                    </li>
                                </ul>
                            @else
                                <p style="font-size: 14.5px;">No file uploaded yet.</p>
                            @endif
                            <div>
                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                <button type="button" class="btn btn-secondary btn-sm ms-2 btn-setup" id="mbtn" data-toggle="modal" data-target="#setPrintModal"> Setup</button>
                            </div>
                        </div>
                        
                    </form>
                    @else
                    <div class="card-body px-4 pt-0 pb-0">
                        <form id="form-air-freight" method="POST" action="{{ url('air_shipment-store') }}">
                            @csrf
                            <div class="table-responsive">
                                <table class="table table-bordered align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">BL</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Origin</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vessel SIN</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Ctn</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Kg</th>    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="align-middle text-center">
                                                <input type="date" class="form-control text-center" name="date" style="border: 0px;" required>
                                            </td>
                                            <td class="align-middle text-center">
                                                <input type="date" class="form-control text-center" name="bl" style="border: 0px;" required>
                                            </td>
                                            <td class="align-middle text-center">
                                                <select class="form-select text-xs select-cust" name="id_customer" required>
                                                    <option value="">...</option>
                                                    @foreach ($customers as $c)
                                                    <option value="{{ $c->id_customer }}" data-shipper-ids="{{ $c->shipper_ids }}">{{ $c->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="align-middle text-center">
                                                <select class="form-select text-xs select-shipper" name="id_shipper" required>
                                                    <option value="">...</option>
                                                    @foreach ($shippers as $s)
                                                    <option value="{{ $s->id_shipper }}">{{ $s->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="align-middle text-center">
                                                <select class="form-select text-xs select-origin" name="id_origin" required>
                                                    <option value="">...</option>
                                                    @foreach ($origins as $o)
                                                        <option value="{{ $o->id_origin }}">{{ $o->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="align-middle text-center">
                                                <!-- <select class="form-select text-center text-xs" name="vessel_sin" style="border: 0px;">
                                                    <option value="">...</option>
                                                    <option value="NARITA/CNG"> NARITA / CNG </option>
                                                </select> -->
                                                <input type="text" class="form-control text-center" name="vessel_sin" placeholder="..." style="border: 0px;">
                                            </td>
                                            <td class="align-middle text-center" width=5%>
                                                <input type="text" class="form-control text-center" name="tot_pkgs" placeholder="..." style="background-color: #fff;" disabled>
                                            </td>
                                            <td class="align-middle text-center" width=5%>
                                                <input type="text" class="form-control text-center" name="tot_loose" placeholder="..." style="background-color: #fff;" disabled>
                                            </td>    
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                    
                            <div class="table-responsive py-3 mt-3">
                                <table class="table table-bordered align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">No.</th>
                                            <!-- <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">BL Date</th> -->
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Marking</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Koli</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">CTN</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">KG</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Qty</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Unit</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Note</th>
                                        </tr>
                                    </thead>
                                    <tbody id="shipmentTableBody">
                                        <tr>
                                            <td width=2%>
                                                <div class="align-middle text-center text-sm d-flex px-3 py-1">
                                                    1.
                                                </div>
                                            </td>
                                            <!-- <td class="align-middle text-center" width=6%>
                                                <input type="date" class="form-control text-center" name="bldate[]" style="border: 0px;" required>
                                            </td> -->
                                            <td class="align-middle text-center" width=15%>
                                                <input type="text" class="form-control text-center" name="marking[]" oninput="this.value = this.value.toUpperCase()"
                                                placeholder="..." style="border: 0px;" required>
                                            </td>
                                            <td class="align-middle text-center" width=5%>
                                                <input type="number" class="form-control text-center" name="koli[]" placeholder="..." style="border: 0px;" min="1">
                                            </td>
                                            <td class="align-middle text-center" width=5%>
                                                <input type="number" class="form-control text-center" name="qty_pkgs[]" placeholder="..." style="border: 0px;" min="1">
                                            </td>
                                            <td class="align-middle text-center" width=5%>
                                                <input type="number" class="form-control text-center" name="qty_loose[]" placeholder="..." style="border: 0px;" min="1">
                                            </td>
                                            <td class="align-middle text-center" width=5%>
                                                <input type="number" class="form-control text-center" name="qty[]" placeholder="..." style="border: 0px;" min="1">
                                            </td>
                                            <td class="align-middle" width=5%>
                                                <!-- <select class="form-select text-center text-xs" name="unit[]" style="border: 0px;">
                                                    <option value="">...</option>
                                                    <option value="PCS">PCS</option>
                                                    <option value="CSE">CSE</option>
                                                    <option value="CTN">CTN</option>
                                                    <option value="PKG">PKG</option>
                                                    <option value="PLT">PLT</option>
                                                </select> -->
                                                <select class="form-select text-xs select-unit" name="unit[]">
                                                    <option value="">...</option>
                                                    @foreach ($units as $u)
                                                        <option value="{{ $u->id_unit }}">{{ $u->name }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="align-middle text-center" width=col-16%>
                                                <input type="text" class="form-control text-center" name="note[]" placeholder="..." style="border: 0px;">
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
                    </div>
                    @endif 
                </div>
            </div>
        </div>
    </div>
</div>


{{--  <!-- The Modal -->  --}}
@if ($airShipment)
    <div class="container">    
        <div id="setPrintModal" class="modal">
            <div class="modal-content animate-top">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal text-xs" id="setPrintModalLabel">
                        <i class="material-icons text-xs">priority_high</i>
                        <b>Before printing the document, make sure youve filled in all the required (<span class="text-primary">*</span>) data.</b>
                    </h5>
                </div>
                <br>
                <form id="airShipmentForm" action="{{ url('print-air-shipment') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <h5 class="text-sm">Form</h5>
                    <input type="hidden" name="id" value="{{ $airShipment->id_air_shipment }}">
                    <input type="hidden" name="dateBL" value="{{ $airShipment->date }}">
                    <div class="input-group input-group-static mb-4">
                        <label>Invoice No. <span class="text-danger">*</span></label>
                        @if ($airShipment->no_inv)
                            <input type="text" class="form-control" name="inv_no" value="{{ old('inv_no', $airShipment->no_inv) }}" placeholder="..." required>
                        @else
                            <input type="text" class="form-control" name="inv_no" value="{{ old('inv_no', $airShipment->id_air_shipment) }}" placeholder="..." required>
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
                            <input type="number" class="form-control" id="term" name="term" min="1" value="{{ old('term', $airShipment->term) }}" placeholder="..." required>
                        </div>
                        <div class="col-1"></div>
                        <div class="col-6">
                            <label>Payment Due</label>
                            <input type="date" class="form-control" id="payment_due" name="payment_due" value="{{ old('payment_due', $airShipment->date) }}" readonly>
                        </div>
                    </div>
                    <div class="input-group input-group-static mb-4">
                        <div class="col-5">
                            <label>Banker</label>
                            <input type="text" class="form-control" name="banker" value="{{ old('banker') }}" placeholder="...">
                        </div>
                        <div class="col-1"></div>
                        <div class="col-6">
                            <label>Account No.</label>
                            <input type="text" class="form-control" name="account_no" value="{{ old('account_no') }}" placeholder="...">
                        </div>
                    </div>
                    
                    <div class="accordion-item">
                        <div class="input-group input-group-static">
                            <div>
                                <button id="addAnotherBillButton" class="btn btn-outline-primary btn-sm" type="button">
                                    <span class="btn-inner--text">+ Add another bill</span>
                                </button>
                            </div>

                            <div id="inputGroupContainer" class="input-group input-group-static">
                                @php
                                    $checkAirShipmentAnotherBill = null;
                                    if (isset($airShipmentAnotherBill) && count($airShipmentAnotherBill) > 0) {
                                        $checkAirShipmentAnotherBill = $airShipmentAnotherBill->where('date', $date)->all();
                                    }
                                @endphp

                                @if($checkAirShipmentAnotherBill)
                                    @foreach($checkAirShipmentAnotherBill as $index => $data)
                                        <input type="hidden" name="idAnotherBill[]" value="{{ $data->id_air_shipment_other_bill }}">
                                        <input type="hidden" name="dateAnotherBL[]" value="{{ $date }}">

                                        <div class="input-group input-group-static mb-4">
                                            <div class="col-5">
                                                <div class="input-group input-group-static mb-1">
                                                    <label class="text-sm">Desc</label>
                                                </div>
                                                <div class="input-group input-group-static mb-0">
                                                    <select class="form-select select-company" name="id_desc[]" style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
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
                                            <div class="col-6">
                                                <label>Charge</label>
                                                <input type="text" class="form-control anotherBill" name="anotherBill[]" 
                                                value="{{ old('anotherBill.' . $index, $data->charge) }}" placeholder="...">
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                {{--  <p>{{ $date }}</p>  --}}

                            </div>
                        </div>

                        {{--  <!-- Template for input another bill -->  --}}
                        <template id="inputGroupTemplate">
                            <input type="hidden" name="idAnotherBill[]" value="">
                            <input type="hidden" name="dateAnotherBL[]" value="{{ $date }}">
                            <div class="input-group input-group-static mb-4">
                                <div class="col-5">
                                    <div class="input-group input-group-static mb-1">
                                        <label class="text-sm">Desc</label>
                                    </div>
                                    <div class="input-group input-group-static mb-0">
                                        <select class="form-select select-company" name="id_desc[]" 
                                        style="border: none; border-bottom: 1px solid #ced4da; border-radius: 0px;">
                                            <option value="">...</option>
                                            @foreach ($descs as $d)
                                                <option value="{{ $d->id_desc }}" {{ old('id_desc') == $d->id_desc ? 'selected' : '' }}>{{ $d->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-1"></div>
                                <div class="col-6">
                                    <label>Charge</label>
                                    <input type="text" class="form-control anotherBill" name="anotherBill[]" placeholder="...">                    
                                </div>
                            </div>
                        </template>
                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="submit" class="btn bg-gradient-secondary btn-sm" name="is_update" value="true">Update Setup</button>
                        <button type="submit" class="btn bg-gradient-primary btn-sm ms-2" name="is_print" value="true">Print Invoice</button>        
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

<style>
    .flex-container {
        display: flex;
        justify-content: center;
        width: 100%; 
    }

    .drop-container {
        position: relative;
        display: flex;
        gap: 10px;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 150px;
        flex-grow: 1;
        width: 81vw;
        min-width: 780px; 
        max-width: 1550px; 
        border-radius: 10px;
        border: 1.5px dashed #555;
        color: #444;
        cursor: pointer;
        transition: background .2s ease-in-out, border .2s ease-in-out;
        box-sizing: border-box;
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

    /* Modal */
    .modal {
        display: none; 
        position: fixed; 
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%; 
        height: 100%; 
        overflow: auto; 
        background-color: rgb(0,0,0); 
        background-color: rgba(0,0,0,0.4); 
        padding-top: 60px; 
    }

    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: 5% auto; 
        padding: 20px;
        border: 1px solid #888;
        width: 33%; 
        box-shadow: 0 5px 15px rgba(0,0,0,0.5);
        animation: animate-top 0.4s;
    }

    @keyframes animate-top {
        from {top:-300px; opacity:0} 
        to {top:0; opacity:1}
    }
</style>


<script>
    // select2
    $(document).ready(function() {
        $('.select-cust').select2();
        $('.select-shipper').select2();
        $('.select-origin').select2();
        $('.select-unit').select2();
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
                let deleteUrl = '{{ url("air_shipment_line-delete") }}/' + id;
                window.location.href = deleteUrl;
            }
        });
    }

    function addEventListenersToNewRow(row) {
        var qtyPkgsInput = row.querySelector('input[name="qty_pkgs[]"]');
        if (qtyPkgsInput) {
            qtyPkgsInput.addEventListener('change', function() {
                // Update total packages
                calculateTotalPackages();
            });
        }

        var qtyLooseInput = row.querySelector('input[name="qty_loose[]"]');
        if (qtyLooseInput) {
            qtyLooseInput.addEventListener('change', function() {
                // Update total loose
                calculateTotalLoose();
            });
        }
    }

    //add new line
    document.getElementById('addRowButton').addEventListener('click', function () {
        const tableBody = document.getElementById('shipmentTableBody');
        const rowCount = tableBody.rows.length + 1;
    
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
        <input type="hidden" name="id_air_shipment_line[]" value="">
        <td class="align-middle text-center text-sm" width="2%">
            <div class="d-flex px-3 py-1">${rowCount}.</div>
        </td>
        <td class="align-middle text-center" width="6%">
            <input type="date" class="form-control text-center" name="bldate[]" value="" style="border: 0px;" required>
        </td>
        <td class="align-middle text-center" width=15%>
            <input type="text" class="form-control text-center" name="marking[]" oninput="this.value = this.value.toUpperCase()"
            placeholder="..." style="border: 0px;" required>
        </td>
        <td class="align-middle text-center" width=5%>
            <input type="number" class="form-control text-center" name="koli[]" placeholder="..." style="border: 0px;" min="1">
        </td>
        <td class="align-middle text-center" width=5%>
            <input type="number" class="form-control text-center" name="qty_pkgs[]" placeholder="..." style="border: 0px;" min="1">
        </td>
        <td class="align-middle text-center" width=5%>
            <input type="number" class="form-control text-center" name="qty_loose[]" placeholder="..." style="border: 0px;" min="1">
        </td>
        <td class="align-middle text-center" width=5%>
            <input type="number" class="form-control text-center" name="qty[]" placeholder="..." style="border: 0px;" min="1">
        </td>
        <td class="align-middle" width=5%>
            <select class="form-select text-center text-xs" name="unit[]" style="border: 0px;">
                <option value="">...</option>
                <option value="PCS">PCS</option>
                <option value="CSE">CSE</option>
                <option value="CTN">CTN</option>
                <option value="PKG">PKG</option>
                <option value="PLT">PLT</option>
            </select>
        </td>
        <td class="align-middle text-center" width=col-16%>
            <input type="text" class="form-control text-center" name="note[]" placeholder="..." style="border: 0px;">
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
        
    
        // Add event listeners to the new row inputs
        addEventListenersToNewRow(newRow);
    
        // Update totals initially
        calculateTotalPackages();
        calculateTotalLoose();
    
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
    
    //MODAL / POP UP
    var modal = $('#setPrintModal');
    var btn = $("#mbtn");
    var span = $(".close");

    $(document).ready(function(){
        btn.on('click', function() {
            modal.show();
        });

    });

    $('body').bind('click', function(e){
        if($(e.target).hasClass("modal")){
            modal.hide();
        }
    });

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

    // Form 
    const form = document.getElementById('airShipmentForm');
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

    // another bill
    document.addEventListener('DOMContentLoaded', function() {
        const addButton = document.getElementById('addAnotherBillButton'); 
        const inputGroupContainer = document.getElementById('inputGroupContainer'); 
    
        const inputGroupTemplateElement = document.getElementById('inputGroupTemplate'); 
        let inputGroupTemplate;
    
        if (inputGroupTemplateElement) {
            inputGroupTemplate = inputGroupTemplateElement.content;
        }
    
        if (addButton && inputGroupTemplate) {
            addButton.addEventListener('click', function() {
                const newInputGroup = document.importNode(inputGroupTemplate, true); 
                inputGroupContainer.appendChild(newInputGroup); 
                formatInputs(); 
            });
        }
    });

   // Fungsi untuk menghitung total paket
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

    document.querySelectorAll('input[name="qty_pkgs[]"]').forEach(function(input) {
        input.addEventListener('input', calculateTotalPackages); 
    });

    calculateTotalPackages();


   // function to calculate tot_loose
   function calculateTotalLoose() {
    var totalLoose = 0;
    var rows = document.querySelectorAll('input[name="qty_loose[]"]');

    rows.forEach(function(row) {
        if (row.value.trim() !== '') {
            totalLoose += parseInt(row.value) || 0; 
        }
    });

        document.querySelector('input[name="tot_loose"]').value = totalLoose;
    }

    document.querySelectorAll('input[name="qty_loose[]"]').forEach(function(input) {
        input.addEventListener('input', calculateTotalLoose); 
    });

    calculateTotalLoose();

    //function to confirm delete file upload
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
                window.location.href = '/air_shipment/delete-file/' + encryptedId;
            }
        })
    }

    </script>
@endsection