<?php

namespace App\Http\Controllers;

use App\Models\AirBillRecap;
use App\Models\AirShipment;
use App\Models\AirShipmentAnotherBill;
use App\Models\AirShipmentBill;
use App\Models\AirShipmentLine;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Desc;
use App\Models\History;
use App\Models\Origin;
use App\Models\SeaShipment;
use App\Models\Shipper;
use App\Models\Unit;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;


class AirController extends Controller
{
   
    public function index() {
        $seaShipment = SeaShipment::count();
        $airShipment = AirShipment::count();
        $logErrors = '';
        return view('shipment.list_shipments', compact('seaShipment', 'airShipment', 'logErrors'));
    }

    public function createAirShipment() {
        $airShipment = '';
        $airShipmentLines = '';
        $groupAirShipmentLines = '';
        $customers = Customer::orderBy('name')->get();
        $shippers = Shipper::orderBy('name')->get();
        $origins = Origin::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        return view('shipment.air_shipment.form_air_shipment', compact('airShipment', 'airShipmentLines', 'customers', 'shippers', 'origins', 'units', 'groupAirShipmentLines'));
    }

    public function listAirShipment() {
        $allAirShipment = AirShipment::select(
            'tbl_air_shipment.*',
            'tbl_customers.id_company as customer_id_company',
            'tbl_companies.id_company as company_id_company'
        )
        ->leftJoin('tbl_customers', 'tbl_air_shipment.id_customer', '=', 'tbl_customers.id_customer')
        ->leftJoin('tbl_companies', 'tbl_customers.id_company', '=', 'tbl_companies.id_company')
        ->orderBy('tbl_companies.id_company')
        ->get();

        $customer = Customer::pluck('name', 'id_customer');
        $shipper = Shipper::pluck('name', 'id_shipper');
        $origin = Origin::pluck('name', 'id_origin');
        
        return view('shipment.air_shipment.list_air_shipment', compact('allAirShipment','customer','origin', 'shipper'));
    }

    public function storeAirShipment(Request $request)
    {
        $customer = Customer::where('id_customer', $request->id_customer)->first();
        $shipperIds = $customer->shipper_ids;
        $shipperIdsArray = explode(",", $shipperIds);
    
        if (!in_array($request->id_shipper, $shipperIdsArray)) {
            Customer::where('id_customer', $request->id_customer)->update([
                'shipper_ids' => $shipperIds . ',' . $request->id_shipper,
            ]);
        }
    
        $dataAirShipment = [
            'date' => $request->date,
            'bl' => $request->bl,
            'id_customer' => $request->id_customer,
            'id_shipper' => $request->id_shipper,
            'id_origin' => strtoupper($request->id_origin),
            'vessel_sin' => strtoupper($request->vessel_sin),
        ];
    
        $checkAirShipment = AirShipment::where('id_customer', $request->id_customer)->where('id_shipper', $request->id_shipper)->where('id_origin', $request->id_origin)
            ->where('date', $request->date)->where('bl', $request->bl)->first();
    
        if (!$checkAirShipment) {

            $createdAirShipment = AirShipment::create($dataAirShipment);
            $airShipmentId = $createdAirShipment->id_air_shipment;
    
            foreach ($request->marking as $index => $marking) {
                $dataAirShipmentLine = [
                    'id_air_shipment' => $airShipmentId,
                    'marking' => strtoupper($marking),
                    'koli' => $request->koli[$index],
                    'ctn' => $request->ctn[$index],
                    'kg' => $request->kg[$index],
                    'qty' => $request->qty[$index],
                    'unit' => $request->unit[$index],
                    'note' => $request->note[$index],
                ];
    
                AirShipmentLine::create($dataAirShipmentLine);
            }
    
            $encryptedId = Crypt::encrypt($airShipmentId);
            return redirect("/air_shipment-edit/{$encryptedId}");

        } else {
            return redirect()->back()->with([
                'error' => 'Already exists in the system',
                'error_type' => 'duplicate-alert',
                'input' => $request->all(),
                'isValid' => false,
            ]);
        }
    }
    
    public function editAirShipment($id)
    {
        $id = Crypt::decrypt($id);

        $airShipment = AirShipment::where('id_air_shipment', $id)->first();
        $airShipmentLines = AirShipmentLine::where('id_air_shipment', $airShipment->id_air_shipment)->orderBy('marking')->orderBy('id_air_shipment_line')->get();
        $airShipmentAnotherBill = AirShipmentAnotherBill::where('id_air_shipment', $airShipment->id_air_shipment)->orderBy('date')->get();
        $origins = Origin::orderBy('name')->get();
        $originName = Origin::pluck('name', 'id_origin');

        $totalqtyOverall = 0;

        // Mengelompokkan data berdasarkan tanggal
        $groupAirShipmentLines = $airShipmentLines->groupBy(function ($item) {
            return $item->date;
        })->map(function ($group) use (&$totalqtyOverall) {
            $totals = [
                'total_qty_pkgs' => $group->filter(function ($item) {
                    return is_numeric($item->qty_pkgs);
                })->sum('qty_pkgs'),
                'total_qty_loose' => $group->filter(function ($item) {
                    return is_numeric($item->qty_loose);
                })->sum('qty_loose')
            ];

            return $totals;
        });

        // Mengambil data customer, shipper, dan company
        $customers = Customer::orderBy('name')->get();
        $customer = Customer::where('id_customer', $airShipment->id_customer)->first();
        $shippers = Shipper::orderBy('name')->get();
        $companies = Company::orderBy('name')->get();
        $descs = Desc::orderBy('name')->get();
        $units = Unit::orderBy('name')->get();

        // Mengirim data ke view
        return view('shipment.air_shipment.form_air_shipment', compact('airShipment','airShipmentLines','customers', 'customer', 'shippers', 'companies', 
        'groupAirShipmentLines', 'descs', 'units', 'totalqtyOverall', 'airShipmentAnotherBill','origins', 'originName'));
    }
 
    public function updateAirShipment(Request $request) 
    {
        
        $customer = Customer::where('id_customer', $request->id_customer)->first();
        $shipperIds = $customer->shipper_ids;
        $shipperIdsArray = explode(",", $shipperIds);

        if (!in_array($request->id_shipper, $shipperIdsArray)) {
            Customer::where('id_customer', $request->id_customer)->update([
                'shipper_ids' => $shipperIds . ',' . $request->id_shipper,
            ]);
        }

        $AirShipment = AirShipment::find($request->id_air_shipment);

        if ($AirShipment) {
            $AirShipment->date = $request->date;
            $AirShipment->bl = $request->bl;
            $AirShipment->id_customer = $request->id_customer;
            $AirShipment->id_shipper = $request->id_shipper;
            $AirShipment->id_origin = $request->id_origin;
            $AirShipment->vessel_sin = $request->vessel_sin;
        }

        // File
        $request->validate([
            'file_shipment_status' => 'mimes:pdf|max:2048',
        ]);

        if ($request->file('file_shipment_status')) {
            $file = $request->file('file_shipment_status');
            $dateTime = new DateTime();
            $dateTime->modify('+7 hours');
            $currentDateTime = $dateTime->format('d_m_Y_H_i_s');
            $fileName = $currentDateTime . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('ShipmentStatus', $fileName, 'public');
        
            if ($AirShipment) {
                $AirShipment->file_shipment_status = $filePath;
            }
        }

        // Save
        $AirShipment->save();
        
        foreach ($request->id_air_shipment_line as $index => $idAirShipmentLine) {
            $airShipmentLine = AirShipmentLine::find($idAirShipmentLine);
        
            $data = [
                'id_air_shipment' => $request->id_air_shipment,
                'marking' => strtoupper($request->marking[$index]),
                'koli' =>$request->koli[$index],
                'ctn' => $request->ctn[$index],
                'kg' => $request->kg[$index],
                'qty' => $request->qty[$index],
                'unit' => $request->unit[$index],
                'note' => $request->note[$index],
            ];
        
            if ($airShipmentLine) {
                $airShipmentLine->update($data);

            } else {
                // Buat data baru di AirShipmentLine jika tidak ada
                AirShipmentLine::create($data + ['id_air_shipment_line' => $idAirShipmentLine]);
            }
        }

        return redirect()->back();
    }

    public function deleteAirShipment($id) {
        AirShipmentLine::where('id_air_shipment', $id)->delete();
        AirShipmentBill::where('id_air_shipment', $id)->delete();
        AirShipmentAnotherBill::where('id_air_shipment', $id)->delete();
        AirBillRecap::where('id_air_shipment', $id)->delete();
        History::where('id_changed_data', $id)->delete();
        AirShipment::where('id_air_shipment', $id)->delete();

        if (count(AirShipment::all()) == 0) {
            return redirect('list_shipments');
            
        } else {
            return redirect()->back();
        }
    }

    public function deleteAirShipmentLine($id) {
        AirShipmentLine::where('id_air_shipment_line', $id)->delete();
        return redirect()->back();
    }

    public function deleteMultiAirShipment(Request $request) {
        // Convert comma-separated string to array
        $ids = explode(',', $request->ids);
        
        // Validate that each element in the array is an integer
        $validatedIds = array_filter($ids, function($id) {
            return is_numeric($id);
        });
        
        AirShipmentLine::whereIn('id_air_shipment', $validatedIds)->delete();
        AirShipmentBill::whereIn('id_air_shipment', $validatedIds)->delete();
        AirShipmentAnotherBill::whereIn('id_air_shipment', $validatedIds)->delete();
        AirBillRecap::whereIn('id_air_shipment', $validatedIds)->delete();
        History::whereIn('id_changed_data', $validatedIds)->delete();
        AirShipment::whereIn('id_air_shipment', $validatedIds)->delete();

        if (count(AirShipment::all()) == 0) {
            return redirect('list_shipments');
            
        } else {
            return redirect()->back();
        }
    }

    public function deleteFile($encryptedId) {
        // Dekripsi ID
        $id = Crypt::decrypt($encryptedId);

        $airShipment = AirShipment::findOrFail($id);
        if ($airShipment->file_shipment_status) {
            // Hapus file dari storage
            Storage::delete('public/' . $airShipment->file_shipment_status);
            $airShipment->file_shipment_status = null;
            $airShipment->save();

            return redirect()->back()->with('success', 'File has been deleted successfully.');
        }

        return redirect()->back()->with('error', 'No file found to delete.');
    }

}
