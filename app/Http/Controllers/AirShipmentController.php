<?php

namespace App\Http\Controllers;

use App\Imports\AirShipmentImport;
use App\Models\AirBillRecap;
use App\Models\AirShipment;
use App\Models\AirShipmentAnotherBill;
use App\Models\AirShipmentBill;
use App\Models\AirShipmentLine;
use App\Models\Cas;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Desc;
use App\Models\Pricelist;
use App\Models\SeaShipment;
use App\Models\Shipper;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Mpdf\Mpdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Log;

class AirShipmentController extends Controller
{
    public function index() 
    {
        $seaShipment = SeaShipment::count();
        $airShipment = AirShipment::count();
        $logErrors = '';
        return view('shipment.list_shipments', compact('seaShipment','airShipment' , 'logErrors'));
    }

    public function importAirShipment(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx|max:2048',
        ]);

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file);
            $sheetNames = $spreadsheet->getSheetNames();

            $import = new AirShipmentImport($sheetNames);
            Excel::import($import, $file);
            $logErrors = $import->getLogErrors();

            if ($logErrors) {
                return redirect('list_shipments')->with('logErrors', $logErrors);
            } else {
                return redirect('list_air_shipment');
            }

        } catch (\Exception $e) {
            $sqlErrors = $e->getMessage();

            if (!empty($sqlErrors)){
                $logErrors = $sqlErrors;
            }

            return redirect('list_shipments')->with('logErrors', $logErrors);
        }
    }

    public function printAirShipment(Request $request){
        $id_air_shipment = $request->id;
        $airShipment = AirShipment::where('id_air_shipment', $id_air_shipment)->firstOrFail();
        $airShipmentLines = AirShipmentLine::where('id_air_shipment', $airShipment->id_air_shipment)->orderBy('date')->orderBy('id_air_shipment_line')->get();
        $airShipmentBill = AirShipmentBill::where('id_air_shipment', $airShipment->id_air_shipment)->orderBy('date')->get();

        $customer = Customer::where('id_customer', $airShipment->id_customer)->firstOrFail();
        $shipper = Shipper::where('id_shipper', $airShipment->id_shipper)->first();
        $company = Company::where('id_company', $request->id_company)->first();
        $descsData = collect(Desc::orderBy('name')->get());

        $pricelist = Pricelist::where('id_customer', $airShipment->id_customer)->value('price') ?? 0;
        $cas = Cas::where('id_customer', $airShipment->id_customer)->value('charge') ?? 0;


        // Helper function for Roman numerals
        function romanNumerals($number) {
            $romanDigits = ['', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
            return ($number > 0 && $number <= 12) ? $romanDigits[$number] : '';
        }

        $invNumber = $request->inv_no;
        if (strpos($invNumber, '-') !== false) {
            list($numberPart, $suffixPart) = explode('-', $invNumber);
            $formattedNumberPart = sprintf("%03d", $numberPart);
            $invNumber = $formattedNumberPart . '-' . $suffixPart;
        } else {
            $invNumber = sprintf("%03d", $invNumber);
        }

        $month = ltrim(date("m", strtotime($airShipment->date)), '0');
        $monthRoman = romanNumerals($month);
        $year = date("Y", strtotime($airShipment->date));


        // Update company if changed in customer
        if ($customer->id_company != $request->id_company) {
            $customer->id_company = $request->id_company;
            $customer->save();
        }

        $invNameGenerate = "{$invNumber}/{$company->shorter}/INV/{$monthRoman}/{$year}";
        $titleInv = "{$customer->name}-{$shipper->name}-{$invNumber}/{$company->shorter}/INV/{$monthRoman}/{$year}";

        // Calculate payment due
        $shipmentDate = new DateTime($airShipment->date);
        $termInterval = new DateInterval('P' . $request->term . 'D');
        $shipmentDate->add($termInterval);

        $paymentDue = $shipmentDate->format('Y-m-d');

        // Set company-specific data
        $companyData = [
            'KPN' => ['path' => 'KPN.png', 'name' => 'PT KARYA PUTRA NATUNA'],
            'BMM' => ['path' => 'BMM.png', 'name' => 'PT BEVI MARGI MULYA'],
            'BMA' => ['path' => 'BMA.png', 'name' => 'PT BIEMAN MAKMUR ABADI'],
            'SMK' => ['path' => 'SMK.jpg', 'name' => 'PT SURYA MAKMUR KREASI'],
            'SMD' => ['path' => 'SMD.png', 'name' => 'SEMADI'],
            'SNM' => ['path' => 'SNM.jpg', 'name' => 'PT SETIA NEGARA MAJU']
        ];

        $imagePath = public_path('asset/assets/img/KOP/' . $companyData[$company->shorter]['path']);
        $imageContent = file_get_contents($imagePath);
        $companyName = $companyData[$company->shorter]['name'];



        $origin = $airShipment->origin;
        $discount = $customer->discount;

        // Calculate amounts
        $totalpkgs = $totalloose = $totalAmount = 0;
        foreach ($airShipmentLines as $line) {
            $amount = $pricelist * $line->qty_loose;
            $totalAmount += $amount;
            $totalpkgs += $line->qty_pkgs;
            $totalloose += $line->qty_loose;
        }

        $totalanotherBillOverall = 0;       

        // Another bill
        $dataAnotherBill = [
            'id' => $request->idAnotherBill,
            'date' => $request->dateAnotherBL,
            'desc' => $request->id_desc,
            'charge' => $request->anotherBill
        ];


        if ($dataAnotherBill) {
            $ids = is_array($dataAnotherBill["id"]) ? $dataAnotherBill["id"] : [$dataAnotherBill["id"]];
            $dates = is_array($dataAnotherBill["date"]) ? $dataAnotherBill["date"] : [$dataAnotherBill["date"]];
            $descs = is_array($dataAnotherBill["desc"]) ? $dataAnotherBill["desc"] : [$dataAnotherBill["desc"]];
            $charges = is_array($dataAnotherBill["charge"]) ? $dataAnotherBill["charge"] : [$dataAnotherBill["charge"]];
            $dateCount = count($dates);

            for ($indexDate = 0; $indexDate < $dateCount; $indexDate++) {
                $id = isset($ids[$indexDate]) ? $ids[$indexDate] : null;
                $date = isset($dates[$indexDate]) ? $dates[$indexDate] : null;
                $desc = isset($descs[$indexDate]) ? $descs[$indexDate] : null;
                $charge = isset($charges[$indexDate]) ? $charges[$indexDate] : null;
                $anotherBillValue = $charge ? preg_replace("/[^0-9]/", "", $charge) : null;

                $totalanotherBillOverall += $anotherBillValue;

                if ($id) {
                    $checkAirShipmentAnotherBill = AirShipmentAnotherBill::where('id_air_shipment_other_bill', $id)
                    // ->where('id_air_shipment', $airShipment->id_air_shipment)
                    ->firstOrFail();

                    // Skip processing if both desc and charge are null or 0
                    if (is_null($desc) && ($anotherBillValue == 0 || is_null($anotherBillValue))) {
                        if ($checkAirShipmentAnotherBill) {
                            $checkAirShipmentAnotherBill->delete();
                        }
                        continue;
                    }

                    if ($checkAirShipmentAnotherBill) {
                        $checkAirShipmentAnotherBill->id_desc = $desc;
                        $checkAirShipmentAnotherBill->charge = $anotherBillValue;
                        $checkAirShipmentAnotherBill->save();
                    }
                    
                } else {

                    if ($desc && ($anotherBillValue != 0 || $anotherBillValue)) {
                        AirShipmentAnotherBill::create([
                            'id_air_shipment' => $airShipment->id_air_shipment,
                            'date' => $date,
                            'id_desc' => $desc,
                            'charge' => $anotherBillValue,
                        ]);
                    }
                }
            }
        }
            
        // dd($date);

        // update data in shipment
        $airShipment->no_inv = $request->inv_no;
        $airShipment->term = $request->term;
        $airShipment->save();


        if ($request->is_print) {

            $airShipment->is_printed = true;
            $airShipment->printcount += 1;
            $airShipment->printdate = Carbon::now()->addHours(7);
            $airShipment->save();

            $pdf = PDF::loadView('pdf.generate_air_invoice', [
                'customer' => $customer,
                'shipper' => $shipper,
                'airShipment' => $airShipment,
                'airShipmentLines' => $airShipmentLines,
                'airShipmentBill' => $airShipmentBill,
                'pricelist' => $pricelist,
                'term' => $request->term,
                'paymentDue' => $paymentDue,
                'banker' => $request->banker,
                'account_no' => $request->account_no,
                'imageContent' => $imageContent,
                'invNameGenerate' => $invNameGenerate,
                'titleInv' => $titleInv,
                'companyName' => $companyName,
                'id_origin' => $origin,
                'totalpkgs' => $totalpkgs,
                'totalloose' => $totalloose,
                'discount' => $discount,
                'cas' => $cas,
                'dataAnotherBill' => $dataAnotherBill,
                'descsData' => $descsData,

            ])->setPaper('folio', 'portrait');

            $totalAllAmount = 0;
            $totalCasAllAmount = 0; 
            $totalEqual100 = 0;

            $totalAllAmount += $totalloose * $pricelist;

            foreach ($airShipmentLines as $line) {
                if ($line->qty_loose >= 100) {
                    $totalEqual100 += $line->qty_loose * $cas;
                }
            }

            $totalCasAllAmount = $totalAllAmount + $totalEqual100;

            $additionalCharges = AirShipmentAnotherBill::where('id_air_shipment', $airShipment->id_air_shipment)->sum('charge');

            $totalCasAllAmount += $additionalCharges;

            try {
                $existingEntry = AirBillRecap::where('id_air_shipment', $airShipment->id_air_shipment)->first();

                if (!$existingEntry) {
                    AirBillRecap::create([
                        'id_air_shipment' => $airShipment->id_air_shipment,
                        'inv_no' => $invNameGenerate,
                        'freight_type' => 'AIR FREIGHT',
                        'size' => $totalloose,
                        'unit_price' => $pricelist,
                        'amount' => $totalCasAllAmount, 
                    ]);
                } else {
                    $existingEntry->inv_no = $invNameGenerate;
                    $existingEntry->size = $totalloose;
                    $existingEntry->unit_price = $pricelist;
                    $existingEntry->amount = $totalCasAllAmount; 
                    $existingEntry->save();
                }
            } catch (\Exception $e) {
                Log::error('Error saving AirBillRecap: ' . $e->getMessage());
            }


            $output = $pdf->output();
            $tempInvoicePath = storage_path('app/temp_invoice.pdf');
            file_put_contents($tempInvoicePath, $output);
    
            if ($airShipment->file_shipment_status) {
                $uploadedFile = storage_path('app/public/' . $airShipment->file_shipment_status);
    
                $mpdf = new Mpdf();
    
                $pageCount1 = $mpdf->SetSourceFile($tempInvoicePath);
                for ($pageNo = 1; $pageNo <= $pageCount1; $pageNo++) {
                    $tplId = $mpdf->ImportPage($pageNo);
                    $mpdf->AddPage();
                    $mpdf->UseTemplate($tplId);
                }
    
                $pageCount2 = $mpdf->SetSourceFile($uploadedFile);
                for ($pageNo = 1; $pageNo <= $pageCount2; $pageNo++) {
                    $tplId = $mpdf->ImportPage($pageNo);
                    $mpdf->AddPage();
                    $mpdf->UseTemplate($tplId);
                }
    
                return response()->stream(function () use ($mpdf) {
                    echo $mpdf->Output('', 'S');
                }, 200, [
                    'Content-Type' => 'application/pdf',
                    'Content-Disposition' => 'inline; filename="' . ($descs->name ?? 'default_name') . '_' . $customer->name . '-' . $shipper->name . '-' . $invNumber . '_' . $company->shorter . '_' . 'INV_' . $monthRoman . '_' . $year . '.pdf"',
                ]);
                
            } else {
                return $pdf->stream($customer->name . '-' . $shipper->name . '-' . $invNumber . '_' . $company->shorter . '_' . 'INV_' . $monthRoman . '_' . $year . '.pdf');
            }
        }

        if ($request->is_update) {
            return redirect()->back();
        }
    }

}
