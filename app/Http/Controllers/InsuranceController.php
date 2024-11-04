<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Insurance;
use App\Models\Customer;
use App\Models\Shipper;
use App\Models\SeaShipmentLine;
use App\Imports\InsuranceImport;
use Maatwebsite\Excel\Facades\Excel;

class InsuranceController extends Controller
{
    public function index() {
        $insurances = Insurance::join('tbl_customers', 'tbl_insurances.id_customer', '=', 'tbl_customers.id_customer')
           ->orderBy('tbl_customers.name')
           ->get();

        $seaShipmentLine = SeaShipmentLine::pluck('marking', 'id_sea_shipment_line');
        $customer = Customer::pluck('name', 'id_customer');
        $shipper = Shipper::pluck('name', 'id_shipper');
        $logErrors = '';
        return view('main.insurance', compact('insurances', 'seaShipmentLine', 'customer', 'shipper', 'logErrors'));
    }

    public function update(Request $request) {
        $numericCharge = preg_replace("/[^0-9]/", "", explode(",", $request->charge)[0]);
        if ($request->charge[0] === '-') {
            $numericCharge *= -1;
        }

        Insurance::where('id_insurance', $request->id)->update([
            'idr' => $numericCharge
        ]);

        return redirect()->back();
    }

    public function importInsurances(Request $request) {
        $request->validate([
            'file' => 'required|mimes:xlsx|max:2048',
        ]);

        try {
            $file = $request->file('file');
            $import = new InsuranceImport;
            Excel::import($import, $file);
            $logErrors = $import->getLogErrors();

            if ($logErrors) {
                return redirect('insurance')->with('logErrors', $logErrors);

            } else {
                return redirect('insurance');
            }

        } catch (\Exception $e) {
            $sqlErrors = $e->getMessage();

            if (!empty($sqlErrors)){
                $logErrors = $sqlErrors;
            }

            return redirect('insurance')->with('logErrors', $logErrors);
        }
    }
}
