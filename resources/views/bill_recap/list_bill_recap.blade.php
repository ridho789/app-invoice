@extends('layouts.base')
<!-- @section('title', 'Bill Recap (SOA)') -->
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-5">
                    <h6>List Bill Recap (SOA)</h6>
                    <p class="text-sm mb-0">
                        View all list of bill recap in the system.
                    </p>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if (count($bills) > 0)
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Load Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Inv</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Freight</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Units</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Price</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Amount</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Remaining Bill</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Overdue Bill</th>
                                    <th class="text-center text-uppercase text-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bills as $b)
                                @php
                                    $seaShipment = $seaShipments->get($b->id_sea_shipment);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-sm font-weight-normal text-secondary mb-0">{{ $customerName[$seaShipment->id_customer] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $seaShipment->etd)->format('d-M-y') }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <a href="{{ url('sea_shipment-edit', ['id' => Crypt::encrypt($b->id_sea_shipment )]) }}" target="_blank">
                                            <p class="text-sm font-weight-normal mb-0 text-info">{{ $b->inv_no }}</p>
                                        </a>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ $b->freight_type }}</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <p class="text-sm font-weight-normal mb-0">{{ $b->size }}</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ 'Rp ' . number_format($b->unit_price ?? 0, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">{{ 'Rp ' . number_format($b->amount ?? 0, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if (!empty($b->payment_date))
                                            <p class="text-sm font-weight-normal mb-0">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $b->payment_date)->format('d-M-y') }}</p>
                                        @else
                                            <p class="text-sm font-weight-normal mb-0">-</p>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if (!empty($b->payment_amount))
                                            <p class="text-sm font-weight-normal mb-0">{{ 'Rp ' . number_format($b->payment_amount ?? 0, 0, ',', '.') ?? '-' }}</p>
                                        @else
                                            <p class="text-sm font-weight-normal mb-0">-</p>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if ($b->remaining_bill)
                                            <p class="text-sm font-weight-normal mb-0">{{ 'Rp ' . number_format($b->remaining_bill ?? 0, 0, ',', '.') ?? '-' }}</p>
                                        @else
                                            <p class="text-sm font-weight-normal mb-0">-</p>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @if (!empty($b->overdue_bill))
                                            <p class="text-sm font-weight-normal mb-0">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $b->overdue_bill)->format('d-M-y') }}</p>
                                        @else
                                            <p class="text-sm font-weight-normal mb-0">-</p>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ url('bill_recap-edit', ['id' => Crypt::encrypt($b->id_bill_recap)]) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                            <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Load Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No. Inv</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Freight</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Size</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Price</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Amount</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Remaining Bill</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Overdue Bill</th>
                                    <th class="text-center text-uppercase text-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-sm font-weight-normal text-secondary mb-0">-</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <p class="text-sm font-weight-normal mb-0">-</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                @if (count($bills) == 0)
                <div class="card-body px-0 pt-0 pb-0 mt-4">
                    <div class="d-flex justify-content-center mb-3">
                        <span class="text-xs mb-3"><i>No available data to display..</i></span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-5">
                    <h6>AIR FREIGHT</h6>
                    {{--  <h6>List Bill Recap (SOA)</h6>  --}}
                    <p class="text-sm mb-0">
                        View all list of bill recap in the system.
                    </p>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @if (count($airBills) > 0)
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Customer</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Load Date</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No. Inv</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Freight</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Total Units</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Price</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Date</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Amount</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Remaining Bill</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Overdue Bill</th>
                                        <th class="text-center text-uppercase text-secondary"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($airBills as $bil)
                                        @php
                                            $airShipment = $airShipments->get($bil->id_air_shipment);
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="d-flex px-3 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <p class="text-sm font-weight-normal text-secondary mb-0">{{ $customerName[$airShipment->id_customer] }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="text-sm font-weight-normal mb-0">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $airShipment->date)->format('d-M-y') }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <a href="{{ url('air_shipment-edit', ['id' => Crypt::encrypt($bil->id_air_shipment )]) }}" target="_blank">
                                                    <p class="text-sm font-weight-normal mb-0 text-info">{{ $bil->inv_no }}</p>
                                                </a>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-normal mb-0">{{ $bil->freight_type }}</p>
                                            </td>
                                            <td class="align-middle text-end">
                                                <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                                    <p class="text-sm font-weight-normal mb-0">{{ $bil->size }}</p>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-normal mb-0">{{ 'Rp ' . number_format($bil->unit_price ?? 0, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <p class="text-sm font-weight-normal mb-0">{{ 'Rp ' . number_format($bil->amount ?? 0, 0, ',', '.') }}</p>
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if (!empty($bil->payment_date))
                                                    <p class="text-sm font-weight-normal mb-0">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $bil->payment_date)->format('d-M-y') }}</p>
                                                @else
                                                    <p class="text-sm font-weight-normal mb-0">-</p>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if (!empty($bil->payment_amount))
                                                    <p class="text-sm font-weight-normal mb-0">{{ 'Rp ' . number_format($bil->payment_amount ?? 0, 0, ',', '.') ?? '-' }}</p>
                                                @else
                                                    <p class="text-sm font-weight-normal mb-0">-</p>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if ($bil->remaining_bill)
                                                    <p class="text-sm font-weight-normal mb-0">{{ 'Rp ' . number_format($bil->remaining_bill ?? 0, 0, ',', '.') ?? '-' }}</p>
                                                @else
                                                    <p class="text-sm font-weight-normal mb-0">-</p>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                @if (!empty($bil->overdue_bill))
                                                    <p class="text-sm font-weight-normal mb-0">{{ \Carbon\Carbon::createFromFormat('Y-m-d', $bil->overdue_bill)->format('d-M-y') }}</p>
                                                @else
                                                    <p class="text-sm font-weight-normal mb-0">-</p>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('bill_recap-editair', ['id' => Crypt::encrypt($bil->id_air_bill_recap)]) }}" class="mx-3" data-bs-toggle="tooltip" data-bs-original-title="Edit">
                                                    <i class="material-icons text-secondary position-relative text-lg">drive_file_rename_outline</i>
                                                </a>
                                            </td> 
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Load Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No. Inv</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Freight</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Size</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Unit Price</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Amount</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Payment Amount</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Remaining Bill</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Overdue Bill</th>
                                    <th class="text-center text-uppercase text-secondary"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex px-3 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-sm font-weight-normal text-secondary mb-0">-</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-end">
                                        <div class="d-flex px-3 py-1 justify-content-center align-items-center">
                                            <p class="text-sm font-weight-normal mb-0">-</p>
                                        </div>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-sm font-weight-normal mb-0">-</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
                @if (count($airBills) == 0)
                <div class="card-body px-0 pt-0 pb-0 mt-4">
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