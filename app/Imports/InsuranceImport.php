<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Customer;
use App\Models\Shipper;
use App\Models\Insurance;
use App\Models\SeaShipmentLine;

class InsuranceImport implements ToCollection
{
    /**
     * @param Collection $collection
     */

    private $logErrors = [];

    public function collection(Collection $collection)
    {
        $rowNumber = 0;
        foreach ($collection as $row) {
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
            
            if ($row[3]) {
                $expanded_marking = [];
                
                if (strpos($row[3], '-') !== false) {
                    list($prefix, $endRange) = explode('-', $row[3]);
                    list($mainPrefix, $startRange) = explode('#', $prefix);
                    $main = $mainPrefix;
                    $startNum = intval($startRange);

                    for ($num = $startNum; $num <= $endRange; $num++) {
                        $expanded_marking[] = "$main#$num";
                    }

                } else {
                    $expanded_marking[] = $row[3];
                }

                foreach ($expanded_marking as $marking) {
                    $checkSeaShipmentLine = SeaShipmentLine::where('marking', strtoupper($marking))->first();

                    if ($checkSeaShipmentLine) {
                        Insurance::insert([
                            'id_sea_shipment_line' => $checkSeaShipmentLine->id_sea_shipment_line,
                            'id_customer' => $IdCustomer,
                            'id_shipper' => $IdShipper,
                            'charge' => $row[1],
                            'charge' => $row[4],
                        ]);
                    }
                }
            }

            // Next row
            $rowNumber++;
        }
    }

    public function getLogErrors()
    {
        return $this->logErrors;
    }
}
