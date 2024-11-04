<?php

namespace App\Http\Controllers;

use App\Models\AirBillRecap;
use App\Models\AirShipment;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\BillRecap;
use App\Models\SeaShipment;
use Illuminate\Support\Facades\Crypt;

class BillRecapController extends Controller
{
    public function index() {
        $bills = BillRecap::all();
        $seaShipmentIds = $bills->pluck('id_sea_shipment')->unique();
        $seaShipments = SeaShipment::whereIn('id_sea_shipment', $seaShipmentIds)->get()->keyBy('id_sea_shipment');
        $customerName = Customer::pluck('name', 'id_customer');

        $airBills= AirBillRecap::all();
        $airShipmentIds = $airBills->pluck('id_air_shipment')->unique();
        $airShipments = AirShipment::whereIn('id_air_shipment', $airShipmentIds)->get()->keyBy('id_air_shipment');

        return view('/bill_recap.list_bill_recap', compact('bills', 'customerName', 'seaShipments', 'airBills', 'airShipments'));
    }

    public function create() {
        $customers = Customer::all();
        $bill = '';
        return view('/bill_recap.form_bill_recap', compact('customers', 'bill'));
    }

    public function store(Request $request) {
        $paymentAmount = preg_replace("/[^0-9]/", "", explode(",", $request->payment_amount)[0]);
        $remainingBill = preg_replace("/[^0-9]/", "", explode(",", $request->remaining_bill)[0]);

        BillRecap::insert([
            'payment_date' => $request->payment_date,
            'payment_amount' => $paymentAmount,
            'remaining_bill' => $remainingBill,
            'overdue_bill' => $request->overdue_bill,
        ]);

        return redirect('/list_bill_recap');
    }

    public function edit($id) {
        $id = Crypt::decrypt($id);
        $customers = Customer::all();
        $bill = BillRecap::where('id_bill_recap', $id)->first();
        $seaShipment = SeaShipment::where('id_sea_shipment', $bill->id_sea_shipment)->first();
        
        return view('/bill_recap.form_bill_recap', compact('customers', 'bill', 'seaShipment'));
    }

    public function update(Request $request) {
        $paymentAmount = preg_replace("/[^0-9]/", "", explode(",", $request->payment_amount)[0]);
        $remainingBill = preg_replace("/[^0-9]/", "", explode(",", $request->remaining_bill)[0]);

        BillRecap::where('id_bill_recap', $request->id)->update([
            'payment_date' => $request->payment_date,
            'payment_amount' => $paymentAmount,
            'remaining_bill' => $remainingBill,
            'overdue_bill' => $request->overdue_bill,
        ]);

        return redirect('/list_bill_recap');
    }
}
