<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Customer;
use App\Models\Shipper;
use App\Models\Ship;
use App\Models\AirShipment;
use App\Models\AirShipmentLine;
use App\Models\Origin;

class AirShipmentImport implements ToCollection
{
    protected $logErrors = []; 

    public function collection(Collection $collection)
    {
        $currentRow = 0;
        $existingShipment = null; // To keep track of the existing shipment

        foreach ($collection as $row) {
            $currentRow++;

            if ($currentRow > 1) { // Start processing from row 2 onwards
                $IdShipper = null;
                $IdCustomer = null;

                // Shipper
                if (!empty($row[2])) {
                    $checkShipper = Shipper::where('name', 'like', '%' . $row[2] . '%')->first();
                    if (!$checkShipper) {
                        $checkShipper = Shipper::create(['name' => strtoupper($row[2])]);
                    }

                    $IdShipper = $checkShipper->id_shipper;
                }

                // Customer
                if (!empty($row[1])) {
                    $checkCustomer = Customer::where('name', 'like', '%' . $row[1] . '%')->first();
                    if (!$checkCustomer) {
                        $checkCustomer = Customer::create(['name' => strtoupper($row[1]), 'shipper_ids' => $IdShipper]);
                    }

                    $IdCustomer = $checkCustomer->id_customer;

                    $checkShipperIds = $checkCustomer->shipper_ids;
                    if ($checkShipperIds && strpos($checkShipperIds, $IdShipper) === false) {
                        $checkShipperIds .= ",$IdShipper";
                        Customer::where('id_customer', $IdCustomer)->update(['shipper_ids' => $checkShipperIds]);
                    }
                }

                // Origin
                $IdOrigin = null;
                if ($row[6]) {
                    $checkOrigin = Origin::where('name', 'like', '%' . $row[3] . '%')->first();
                    if (!$checkOrigin) {
                        $checkOrigin = Origin::create(['name' => strtoupper($row[3])]);
                    }

                    // IdOrigin
                    $IdOrigin = $checkOrigin->id_origin;
                }

                // Membuat nilai unik untuk mengecek keberadaan air shipment
                $valueKey =  $IdShipper . \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])->format('Y-m-d') .$IdCustomer;

                // Cek apakah air shipment sudah ada
                if (!$existingShipment || $existingShipment->value_key !== $valueKey) {
                    // Jika belum ada dalam cache atau value_key berbeda, cari di database
                    $existingShipment = AirShipment::where('value_key', $valueKey)->first();

                    if (!$existingShipment) {
                        // Jika belum ada di database, buat data baru di tbl_air_shipment
                        $dataAirShipment = [
                            'id_origin' => $IdOrigin,
                            'vessel_sin' => strtoupper($row[4]),
                            'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]),
                            'id_shipper' => $IdShipper,
                            'id_customer' => $IdCustomer,
                            'value_key' => $valueKey
                        ];

                        try {
                            $existingShipment = AirShipment::create($dataAirShipment);
                        } catch (\Exception $e) {
                            $this->logErrors[] = "Error saat membuat air shipment pada baris {$currentRow}: " . $e->getMessage();
                            continue;
                        }
                    }
                }

                // Buat atau tambahkan data ke tbl_air_shipment_line
                $dataShipmentLine = [
                    'id_air_shipment' => $existingShipment->id_air_shipment ,
                    'date' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]),
                    'marking' => strtoupper($row[7]),
                    'koli' => is_numeric($row[8]) ? floatval($row[8]) : null,
                    'qty_pkgs' => is_numeric($row[9]) ? floatval($row[9]) : null,
                    'qty_loose' => is_numeric($row[10]) ? floatval($row[10]) : null,
                    'qty' => is_numeric($row[11]) ? floatval($row[11]) : null,
                    'unit' => strtoupper($row[12]),
                    'note' => strtoupper($row[13]),

                ];

                try {
                    AirShipmentLine::create($dataShipmentLine);
                } catch (\Exception $e) {
                    $this->logErrors[] = "Error saat membuat air shipment line pada baris {$currentRow}: " . $e->getMessage();
                }
            }
        }
    }

    public function getLogErrors()
    {
        return $this->logErrors;
    }
}
