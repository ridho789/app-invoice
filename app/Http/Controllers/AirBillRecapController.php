<?php

namespace App\Http\Controllers;

use App\Models\AirBillRecap;
use App\Models\AirShipment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class AirBillRecapController extends Controller
{
    public function index() {

        $billsAir = AirBillRecap::all();
        $airShipmentIds = $billsAir->pluck('id_air_shipment')->unique();
        $airShipments = AirShipment::whereIn('id_air_shipment', $airShipmentIds)->get()->keyBy('id_air_shipment');
        $customerAirName = Customer::pluck('name', 'id_customer');

        return view('/bill_recap.list_bill_recap', compact('bills', 'customerName', 'billsAir', 'airShipments'));
    }

    public function store(Request $request) {
        $paymentAmount = preg_replace("/[^0-9]/", "", explode(",", $request->payment_amount)[0]);
        $remainingBill = preg_replace("/[^0-9]/", "", explode(",", $request->remaining_bill)[0]);

        AirBillRecap::insert([
            'payment_date' => $request->payment_date,
            'payment_amount' => $paymentAmount,
            'remaining_bill' => $remainingBill,
            'overdue_bill' => $request->overdue_bill,
        ]);

        return redirect('bill_recap.form_air_bill_recap');
    }
      
    public function edit($id) {
        
        $id = Crypt::decrypt($id);
        $customers = Customer::all();
        $airBill = AirBillRecap::where('id_air_bill_recap', $id)->first();
        $airShipment = AirShipment::where('id_air_shipment',$airBill->id_air_shipment)->first();
        
        return view('/bill_recap.form_air_bill_recap', compact('customers', 'airBill', 'airShipment'));
    }

    public function update(Request $request) {
        $paymentAmount = preg_replace("/[^0-9]/", "", explode(",", $request->payment_amount)[0]);
        $remainingBill = preg_replace("/[^0-9]/", "", explode(",", $request->remaining_bill)[0]);

        AirBillRecap::where('id_air_bill_recap', $request->id)->update([
            'payment_date' => $request->payment_date,
            'payment_amount' => $paymentAmount,
            'remaining_bill' => $remainingBill,
            'overdue_bill' => $request->overdue_bill,
        ]);

        return redirect('/list_bill_recap');
    }


}
