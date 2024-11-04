<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cas;
use App\Models\Customer;
use App\Models\Shipper;
use App\Models\Unit;
use App\Models\Origin;
use App\Imports\CasImport;
use Maatwebsite\Excel\Facades\Excel;

class CasController extends Controller
{
    public function index() {
        $cas = Cas::leftJoin('tbl_customers', 'tbl_cas.id_customer', '=', 'tbl_customers.id_customer')
            ->orderBy('tbl_customers.name')
            ->orderByRaw("CASE WHEN tbl_cas.start_period IS NULL THEN 0 ELSE 1 END")
            ->orderBy('tbl_cas.start_period')
            ->get();

        $customer = Customer::pluck('name', 'id_customer');
        $shipper = Shipper::pluck('name', 'id_shipper');
        $unit = Unit::pluck('name', 'id_unit');
        $origin = Origin::pluck('name', 'id_origin');
        $customers = Customer::orderBy('name')->get();
        $shippers = Shipper::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();
        $origins = Origin::orderBy('name')->get();
        $logErrors = '';
        return view('main.cas', compact('cas', 'customer', 'shipper', 'unit', 'origin', 'customers', 'shippers', 'units', 'origins', 'logErrors'));
    }

    public function store(Request $request) {
        $numericNewCharge = preg_replace("/[^0-9]/", "", explode(",", $request->new_charge)[0]);
        if ($request->new_charge[0] === '-') {
            $numericNewCharge *= -1;
        }

        $dataNewCas = [
            'id_customer' => $request->id_customer,
            'id_shipper' => $request->id_shipper,
            'id_unit' => $request->id_unit,
            'lts' => $request->new_lts,
            'charge' => $numericNewCharge,
            'id_origin' => $request->id_origin,
            'desc' => $request->new_desc,
            'start_period' => $request->new_start_period,
            'end_period' => $request->new_end_period
        ];

        $exitingCas = Cas::where('id_customer', $request->id_customer)->where('id_shipper', $request->id_shipper)->where('lts', $request->new_lts)->where('charge', $numericNewCharge)
            ->where('id_origin', $request->id_origin)->where('id_unit', $request->id_unit)->where('desc', $request->new_desc)
            ->where('start_period', $request->new_start_period)->where('end_period', $request->new_end_period)->first();

        $dataCustomer = Customer::where('id_customer', $request->id_customer)->first();
        $dataShipper = Shipper::where('id_shipper', $request->id_shipper)->first();
        $dataUnit = Unit::where('id_unit', $request->id_unit)->first();
        $dataOrigin = Origin::where('id_origin', $request->id_origin)->first();

        $customerName = 'null';
        if ($dataCustomer) {
            $customerName = $dataCustomer->name;
        } 

        $shipperName = 'null';
        if ($dataShipper) {
            $shipperName = $dataShipper->name;
        }
        
        $unitName = 'null';
        if ($dataUnit) {
            $unitName = $dataUnit->name;
        }

        $originName = 'null';
        if ($dataOrigin) {
            $originName = $dataOrigin->name;
        }

        $startPeriod = 'null';
        if ($request->new_start_period) {
            $startPeriod = \Carbon\Carbon::createFromFormat('Y-m-d', $request->new_start_period)->format('d-M-y');
        }

        $endPeriod = 'null';
        if ($request->new_end_period) {
            $endPeriod = \Carbon\Carbon::createFromFormat('Y-m-d', $request->new_end_period)->format('d-M-y');
        }

        if ($exitingCas) {
            $logErrors = 'Customer: ' . $customerName . ' - ' . 'Shipper: ' . $shipperName . ' - ' . 'LTS: ' . $request->new_lts . ' - ' . 'Charge: ' . $request->new_charge . ' - ' . 
            'Origin: ' . $originName . ' - ' . 'Unit: ' . $unitName . ' - ' . 'Desc: ' . $request->new_desc . ' - ' . 'Start Period: ' . $startPeriod . ' - ' . 'End Period: ' . $endPeriod . ', already in the system';
            
            return redirect('cas')->with('logErrors', $logErrors);

        } else {
            Cas::create($dataNewCas);
            return redirect('cas');
        }
    }

    public function update(Request $request) {
        $numericCharge = preg_replace("/[^0-9]/", "", explode(",", $request->charge)[0]);
        if ($request->charge[0] === '-') {
            $numericCharge *= -1;
        }

        $cas = Cas::find($request->id);

        if ($cas) {
            $cas->id_customer = $request->id_customer;
            $cas->id_shipper = $request->id_shipper;
            $cas->id_unit = $request->id_unit;
            $cas->lts = $request->lts;
            $cas->charge = $numericCharge;
            $cas->id_origin = $request->id_origin;
            $cas->desc = $request->desc;
            $cas->start_period = $request->start_period;
            $cas->end_period = $request->end_period;

            $cas->save();
        }

        return redirect('cas');
    }

    public function importCas(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xlsx|max:2048',
        ]);

        try {
            $file = $request->file('file');
            $import = new CasImport;
            Excel::import($import, $file);
            $logErrors = $import->getLogErrors();

            if ($logErrors) {
                return redirect('cas')->with('logErrors', $logErrors);

            } else {
                return redirect('cas');
            }

        } catch (\Exception $e) {
            $sqlErrors = $e->getMessage();

            if (!empty($sqlErrors)){
                $logErrors = $sqlErrors;
            }

            return redirect('cas')->with('logErrors', $logErrors);
        }
    }
}
