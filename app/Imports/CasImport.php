<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Cas;
use App\Models\Shipper;
use App\Models\Customer;
use App\Models\Origin;
use App\Models\Unit;

class CasImport implements ToCollection
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
            if ($row[4]) {
                $checkOrigin = Origin::where('name', 'like', '%' . $row[4] . '%')->first();
                if (empty($checkOrigin)) {
                    $checkOrigin = Origin::create(['name' => strtoupper($row[4])]);
                }

                // IdShipper
                $IdOrigin = $checkOrigin->id_origin;
            }

            // Unit
            $IdUnit = null;
            if ($row[5]) {
                $checkUnit = Unit::where('name', 'like', '%' . $row[5] . '%')->first();
                if (empty($checkUnit)) {
                    $checkUnit = Unit::create(['name' => strtoupper($row[5])]);
                }

                // IdShipper
                $IdUnit = $checkUnit->id_unit;
            }

            $startPeriod = null;
            $endPeriod = null;
    
            if ($row[7]) {
                $startPeriod = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[7]);
            }
    
            if ($row[8]) {
                $endPeriod = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[8]);
            }

            if ($startPeriod && $endPeriod && ($startPeriod > $endPeriod)) {
                $errorMessage = 'Error importing data: End Period cannot be earlier than Start Period in the row: ' . $currentRow;
                $this->logErrors[] = $errorMessage;
                continue;
            }
            
            $dataCas = [
                'id_customer' => $IdCustomer,
                'id_shipper' => $IdShipper,
                'lts' => strtoupper($row[2]),
                'charge' => $row[3],
                'id_origin' => $IdOrigin,
                'id_unit' => $IdUnit,
                'desc' => $row[6],
                'start_period' => $startPeriod,
                'end_period' => $endPeriod
            ];
    
            $exitingCas = Cas::where('id_customer', $IdCustomer)->where('id_shipper', $IdShipper)->where('lts', $row[2])->where('charge', $row[3])->where('id_unit', $IdUnit)
            ->where('id_origin', $IdOrigin)->where('desc', $row[5])->where('start_period', $startPeriod)->where('end_period', $endPeriod)->first();
            
            if ($exitingCas) {
                $errorMessage = 'Error importing data: The data in the row ' . $currentRow . ' already exists in the system ';
                $this->logErrors[] = $errorMessage;
    
            } else {
                Cas::create($dataCas);
            }
        }
    }

    public function getLogErrors()
    {
        return $this->logErrors;
    }
}
