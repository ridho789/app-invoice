@extends('layouts.base')
<!-- @section('title', 'Shipment') -->
@section('content')
<div class="container-fluid py-4">
    <!-- <div class="row mt-4 mb-4">
        <div class="col-lg-9 col-12 mx-auto position-relative">
            <div class="card">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-xl mt-n4 me-3 float-start">
                        <i class="material-icons opacity-10">event</i>
                    </div>
                    <h6 class="mb-0">New Shipment</h6>
                </div>
                <div class="card-body pt-2">
                    <form class="multisteps-form__form">
                        <div class="multisteps-form__panel border-radius-xl bg-white js-active" data-animation="FadeIn">
                            <div class="multisteps-form__content">
                                <div class="row mt-3">
                                    <div class="col-12 col-sm-5">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Shipper</label>
                                            <input class="multisteps-form__input form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-2 mt-3 mt-sm-0">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">No.</label>
                                            <input class="multisteps-form__input form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-5 mt-3 mt-sm-0">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Date</label>
                                            <input class="multisteps-form__input form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 col-sm-6">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Consigne</label>
                                            <input class="multisteps-form__input form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mt-3 mt-sm-0">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Ship Name</label>
                                            <input class="multisteps-form__input form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 col-sm-6">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Total Number of Ships / BL</label>
                                            <input class="multisteps-form__input form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3 mt-3 mt-sm-0">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Total Weight</label>
                                            <input class="multisteps-form__input form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3 mt-3 mt-sm-0">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Etd</label>
                                            <input class="multisteps-form__input form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 col-sm-6">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Total Number of Packages</label>
                                            <input class="multisteps-form__input form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3 mt-3 mt-sm-0">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Total Volume</label>
                                            <input class="multisteps-form__input form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-3 mt-3 mt-sm-0">
                                        <div class="input-group input-group-dynamic">
                                            <label class="form-label">Eta</label>
                                            <input class="multisteps-form__input form-control" type="text" onfocus="focused(this)" onfocusout="defocused(this)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-5">
                            <a href="{{ url('/list_shipments') }}" type="button" name="button" class="btn btn-light m-0">Cancel</a>
                            <button type="button" name="button" class="btn bg-gradient-dark m-0 ms-2">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
    <div class="row">
        <!-- <div id="form-new-bill-recap">
            <div class="card mb-4">
                <div class="card-header p-3 pt-2">
                    <div class="icon icon-lg icon-shape bg-gradient-dark shadow text-center border-radius-xl mt-n4 me-3 float-start">
                        <i class="material-icons opacity-10">event</i>
                    </div>
                    <h6 class="mb-0">Form Shipment</h6>
                </div>
                <div class="card-body px-4 pt-0 pb-0 mt-3">
                    <form class="form" action="{{ url('bill_recap-store') }}" method="POST">
                        @csrf
                        <div class="form-bill-recap mb-5">
                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</label>
                                <input type="text" name="no" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</label>
                                <input type="text" name="shipper" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</label>
                                <input type="text" name="customer" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ship</label>
                                <input type="text" name="ship" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Ships</label>
                                <input type="text" name="tot_ship" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Packages</label>
                                <input type="text" name="tot_pack" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Weight</label>
                                <input type="text" name="tot_weight" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Volume</label>
                                <input type="text" name="tot_vol" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Etd</label>
                                <input type="date" name="etd" class="form-control" required>
                            </div>

                            <div class="input-group input-group-static">
                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Eta</label>
                                <input type="date" name="eta" class="form-control" required>
                            </div>
                        </div>

                        <h6>Shipment Line</h6>
                        <hr>

                        <div class="form-bill-recap mb-4">
                            <div class="sub-form-recaping">
                                <div class="header-grouping">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">IN</label>
                                </div>
                                <div class="input-grouping">
                                    <div class="input-grouping">
                                        <div class="input-group input-group-static" style="width: 100px;">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</label>
                                            <input type="date" name="date" class="form-control" required>
                                        </div>

                                        <div class="input-group input-group-static" style="width: 130px;">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. BL</label>
                                            <input type="text" name="date" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="sub-form-recaping mx-3">
                                        <div class="header-grouping">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder">Size MKT</label>
                                        </div>
                                        <div class="input-grouping">
                                            <div class="input-group input-group-static" style="width: 40px;">
                                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pkg</label>
                                                <input type="text" name="date" class="form-control" required>
                                            </div>

                                            <div class="input-group input-group-static" style="width: 50px;">
                                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">KG</label>
                                                <input type="text" name="date" class="form-control" required>
                                            </div>

                                            <div class="input-group input-group-static" style="width: 50px;">
                                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">M3</label>
                                                <input type="text" name="date" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sub-form-recaping">
                                        <div class="header-grouping">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder text-danger">Warehouse</label>
                                        </div>
                                        <div class="input-grouping">
                                            <div class="input-group input-group-static" style="width: 50px;">
                                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">KG</label>
                                                <input type="text" name="date" class="form-control" required>
                                            </div>

                                            <div class="input-group input-group-static" style="width: 50px;">
                                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">M3</label>
                                                <input type="text" name="date" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sub-form-recaping mx-3">
                                        <div class="header-grouping">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder">SIze C&G</label>
                                        </div>
                                        <div class="input-grouping">
                                            <div class="input-group input-group-static" style="width: 50px;">
                                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">KG</label>
                                                <input type="text" name="date" class="form-control" required>
                                            </div>

                                            <div class="input-group input-group-static" style="width: 50px;">
                                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">M3</label>
                                                <input type="text" name="date" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="sub-form-recaping">
                                <div class="header-grouping">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">OUT</label>
                                </div>
                                <div class="input-grouping">
                                    <div class="input-grouping">
                                        <div class="input-group input-group-static" style="width: 100px;">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</label>
                                            <input type="date" name="date" class="form-control" required>
                                        </div>

                                        <div class="input-group input-group-static" style="width: 100px;">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Aju</label>
                                            <input type="text" name="date" class="form-control" required>
                                        </div>

                                        <div class="input-group input-group-static" style="width: 130px;">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Inv</label>
                                            <input type="text" name="date" class="form-control" required>
                                        </div>

                                        <div class="input-group input-group-static" style="width: 55px;">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pkg</label>
                                            <input type="text" name="date" class="form-control" required>
                                        </div>

                                        <div class="input-group input-group-static" style="width: 55px;">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">KG</label>
                                            <input type="text" name="date" class="form-control" required>
                                        </div>

                                        <div class="input-group input-group-static" style="width: 55px;">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Est M3</label>
                                            <input type="text" name="date" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="sub-form-recaping mx-3">
                                        <div class="header-grouping">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder">Total M3</label>
                                        </div>
                                        <div class="input-grouping">
                                            <div class="input-group input-group-static" style="width: 55px;">
                                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">KG</label>
                                                <input type="text" name="date" class="form-control" required>
                                            </div>

                                            <div class="input-group input-group-static" style="width: 55px;">
                                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">M3</label>
                                                <input type="text" name="date" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="sub-form-recaping">
                                        <div class="header-grouping">
                                            <label class="text-uppercase text-secondary text-xxs font-weight-bolder">Difference</label>
                                        </div>
                                        <div class="input-grouping">
                                            <div class="input-group input-group-static" style="width: auto;">
                                                <label class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">M3</label>
                                                <input type="text" name="date" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" id="submitBtnBill" class="btn btn-primary btn-sm">Submit</button>
                    </form>
                </div>
            </div>
        </div> -->

        <div>
            <div class="card mb-4">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" rowspan="2">BL Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Total Packages <br> pkgs</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Total Weight <br> kgs</th>
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
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <p class="text-xs text-secondary mb-0">-</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <!-- total cbm -->
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <!-- ### -->
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mt-5">
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
                </div>
                <div class="card-body px-4 pt-0 pb-0">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No.</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Shipper</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ship</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Ships</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Packages</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Weight</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Volume</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Etd</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Eta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <p class="text-xs text-secondary mb-0">-</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive py-3">
                        <!-- <h6>List of Shipment Sea Freight</h6> -->
                        <p class="text-sm mb-0">
                            List of sea freight shipment.
                        </p>
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">No.</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" rowspan="2">Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2" rowspan="2">Code</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Marking</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="1" colspan="2">Quantity</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Weight <br> kg</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="1" colspan="3">Dimension</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="1" colspan="2">Total CBM</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">Desc</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7" rowspan="2">State</th>
                                </tr>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pkgs</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Loose</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">p</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">l</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">t</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">i</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ii</th>
                                </tr>

                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <p class="text-xs text-secondary mb-0">-</p>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">-</p>
                                    </td>
                                    <td>
                                        <p class="text-xs text-secondary mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <!-- qty -->
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <!-- ### -->
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <!-- dimension -->
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <!-- ### -->
                                    <!-- total cbm -->
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <!-- ### -->
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-normal">-</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .form-bill-recap {
        display: flex;
        overflow-x: auto;
    }

    .input-group-static {
        margin-right: 10px;
    }

    .sub-form-bill-recap {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        overflow-x: auto;
    }

    .sub-form-recaping {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .header-grouping {
        margin-left: -5px;
        display: flex;
        justify-content: space-between;
    }

    .input-grouping {
        display: flex;
    }
</style>
@endsection