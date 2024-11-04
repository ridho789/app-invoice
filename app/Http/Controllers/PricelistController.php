<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pricelist;
use App\Models\Customer;
use App\Models\Shipper;
use App\Models\Origin;
use App\Imports\PricelistImport;
use Maatwebsite\Excel\Facades\Excel;

class PricelistController extends Controller
{
    public function index() {
        $pricelists = Pricelist::leftJoin('tbl_customers', 'tbl_pricelists.id_customer', '=', 'tbl_customers.id_customer')
            ->orderBy('tbl_customers.name')
            ->orderByRaw("CASE WHEN tbl_pricelists.start_period IS NULL THEN 0 ELSE 1 END")
            ->orderBy('tbl_pricelists.start_period')
            ->get();

        $customer = Customer::pluck('name', 'id_customer');
        $shipper = Shipper::pluck('name', 'id_shipper');
        $origin = Origin::pluck('name', 'id_origin');
        $customers = Customer::orderBy('name')->get();
        $shippers = Shipper::orderBy('name')->get();
        $origins = Origin::orderBy('name')->get();
        $logErrors = '';
        return view('main.pricelist', compact('pricelists', 'customer', 'shipper', 'origin', 'customers',  'origins', 'shippers', 'logErrors'));
    }

    public function store(Request $request) {
        $numericNewPrice = preg_replace("/[^0-9]/", "", explode(",", $request->price)[0]);
        if ($request->price[0] === '-') {
            $numericNewPrice *= -1;
        }

        $dataNewPricelist = [
            'id_customer' => $request->id_customer,
            'id_shipper' => $request->id_shipper,
            'id_origin' => $request->id_origin,
            'price' => $numericNewPrice,
            'type' => $request->type,
            'start_period' => $request->start_period,
            'end_period' => $request->end_period
        ];

        $exitingPricelist = Pricelist::where('id_customer', $request->id_customer)->where('id_shipper', $request->id_shipper)->where('id_origin', $request->id_origin)
            ->where('price', $numericNewPrice)->where('type', $request->type)->where('start_period', $request->start_period)->where('end_period', $request->end_period)->first();

        $dataCustomer = Customer::where('id_customer', $request->id_customer)->first();
        $dataShipper = Shipper::where('id_shipper', $request->id_shipper)->first();
        $dataOrigin = Origin::where('id_origin', $request->id_origin)->first();

        $customerName = 'null';
        if ($dataCustomer) {
            $customerName = $dataCustomer->name;
        } 

        $shipperName = 'null';
        if ($dataShipper) {
            $shipperName = $dataShipper->name;
        }

        $originName = 'null';
        if ($dataOrigin) {
            $originName = $dataOrigin->name;
        }
        
        $startPeriod = 'null';
        if ($request->start_period) {
            $startPeriod = \Carbon\Carbon::createFromFormat('Y-m-d', $request->start_period)->format('d-M-y');
        }

        $endPeriod = 'null';
        if ($request->end_period) {
            $endPeriod = \Carbon\Carbon::createFromFormat('Y-m-d', $request->end_period)->format('d-M-y');
        }

        if ($exitingPricelist) {
            $logErrors = 'Customer: ' . $customerName . ' - ' . 'Shipper: ' . $shipperName . ' - ' . 'Origin: ' . $originName . ' - ' . 'Price: ' . 
            $request->price . ' - ' . 'Type: ' . $request->type . ' - ' . 'Start Period: ' . $startPeriod . ' - ' . 'End Period: ' . $endPeriod . ', already in the system';
            
            return redirect('pricelist')->with('logErrors', $logErrors);

        } else {
            Pricelist::create($dataNewPricelist);
            return redirect('pricelist');
        }
    }

    public function update(Request $request) {
        $numericPrice = preg_replace("/[^0-9]/", "", explode(",", $request->price)[0]);
        if ($request->price[0] === '-') {
            $numericPrice *= -1;
        }

        $pricelist = Pricelist::find($request->id);

        if ($pricelist) {
            $pricelist->id_customer = $request->id_customer;
            $pricelist->id_shipper = $request->id_shipper;
            $pricelist->id_origin = $request->id_origin;
            $pricelist->price = $numericPrice;
            $pricelist->type = $request->type;
            $pricelist->start_period = $request->start_period;
            $pricelist->end_period = $request->end_period;

            $pricelist->save();
        }

        return redirect('pricelist');
    }

    public function importPricelist(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xlsx|max:2048',
        ]);

        try {
            $file = $request->file('file');
            $import = new PricelistImport;
            Excel::import($import, $file);
            $logErrors = $import->getLogErrors();

            if ($logErrors) {
                return redirect('pricelist')->with('logErrors', $logErrors);

            } else {
                return redirect('pricelist');
            }

        } catch (\Exception $e) {
            $sqlErrors = $e->getMessage();

            if (!empty($sqlErrors)){
                $logErrors = $sqlErrors;
            }

            return redirect('pricelist')->with('logErrors', $logErrors);
        }
    }
}
