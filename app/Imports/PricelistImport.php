<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Customer;
use App\Models\Shipper;
use App\Models\Pricelist;
use App\Models\Origin;

class PricelistImport implements ToCollection
{
    /**
    * @param Collection $collection
    */

    private $logErrors = [];

    public function collection(Collection $collection)
    {
        $rowNumber = 0;
        $currentRow = 0;
        foreach ($collection as $row) {
            $currentRow++;
            if ($rowNumber < 1) {
                // Header column
                $headerColumn = $row->toArray();
                $rowNumber++;
                continue;
            }

            // Shipper
            $IdShipper = null;
            if ($row[1]) {
                $checkShipper = Shipper::where('name', 'like', '%' . $row[1] . '%')->first();
                if (empty($checkShipper)) {
                    $checkShipper = Shipper::create(['name' => strtoupper($row[1])]);
                }
                
                // IdShipper
                $IdShipper = $checkShipper->id_shipper;

            }

            // Customer
            $IdCustomer = null;
            if ($row[0]) {
                $checkCustomer = Customer::where('name', 'like', '%' . $row[0] . '%')->first();
                if (empty($checkCustomer)) {
                    $checkCustomer = Customer::create(['name' => strtoupper($row[0]), 'shipper_ids' => $IdShipper]);
                }
                
                // IdCustomer
                $IdCustomer = $checkCustomer->id_customer;


                $checkShipperIds = $checkCustomer->shipper_ids;
                if ($checkShipperIds && strpos($checkShipperIds, $IdShipper) === false) {
                    $checkShipperIds .= ",$IdShipper";
                    // Update shipper_ids in customer
                    Customer::where('id_customer', $IdCustomer)->update(['shipper_ids' => $checkShipperIds]);
                }
            }

            // Origin
            $IdOrigin = null;
            if ($row[2]) {
                $checkOrigin = Origin::where('name', 'like', '%' . $row[2] . '%')->first();
                if (empty($checkOrigin)) {
                    $checkOrigin = Origin::create(['name' => strtoupper($row[2])]);
                }
                
                // IdOrigin
                $IdOrigin = $checkOrigin->id_origin;

            }

            $startPeriod = null;
            $endPeriod = null;

            if ($row[5]) {
                $startPeriod = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]);
            }

            if ($row[6]) {
                $endPeriod = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6]);
            }

            if ($startPeriod && $endPeriod && ($startPeriod > $endPeriod)) {
                $errorMessage = 'Error importing data: End Period cannot be earlier than Start Period in the row: ' . $currentRow;
                $this->logErrors[] = $errorMessage;
                continue;
            }

            $dataPricelist = [
                'id_customer' => $IdCustomer,
                'id_shipper' => $IdShipper,
                'id_origin' => $IdOrigin,
                'price' => $row[3],
                'type' => $row[4],
                'start_period' => $startPeriod,
                'end_period' => $endPeriod
            ];

            $exitingPricelist = Pricelist::where('id_customer', $IdCustomer)->where('id_shipper', $IdShipper)->where('id_origin', $IdOrigin)->where('price', $row[3])
            ->where('type', $row[4])->where('start_period', $startPeriod)->where('end_period', $endPeriod)->first();
            
            if ($exitingPricelist) {
                $errorMessage = 'Error importing data: The data in the row ' . $currentRow . ' already exists in the system ';
                $this->logErrors[] = $errorMessage;

            } else {
                // Create pricelist
                Pricelist::create($dataPricelist);
            }
        }
    }

    public function getLogErrors()
    {
        return $this->logErrors;
    }
}
