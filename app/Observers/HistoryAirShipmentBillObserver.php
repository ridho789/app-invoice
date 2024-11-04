<?php

namespace App\Observers;
use App\Models\AirShipmentBill;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryAirShipmentBillObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the SeaShipmentBill "created" event.
     */
    public function created(AirShipmentBill $AirShipmentBill): void
    {
        //
    }

    /**
     * Handle the AirShipmentBill "updated" event.
     */
    public function updated(AirShipmentBill $AirShipmentBill): void
    {
        $extingHistorySeaShipmentBill = History::where('id_history', $AirShipmentBill->id_history)->first();

        if ($extingHistorySeaShipmentBill) {
            $extingHistorySeaShipmentBill->update([
                'older_data' => json_encode($AirShipmentBill->getOriginal()),
                'changed_data' => json_encode($AirShipmentBill->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistorySeaShipmentBill->revcount
            ]);

        } else {
            $newSeaShipmentBillHistory = History::create([
                'id_changed_data' => $AirShipmentBill->id_sea_shipment,
                'scope' => 'SeaShipmentBill',
                'older_data' => json_encode($AirShipmentBill->getOriginal()),
                'changed_data' => json_encode($AirShipmentBill->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newSeaShipmentBillHistory->id_history;
            AirShipmentBill::where('id_sea_shipment_bill', $AirShipmentBill->id_sea_shipment_bill)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the AirShipmentBill "deleted" event.
     */
    public function deleted(AirShipmentBill $AirShipmentBill): void
    {
        //
    }

    /**
     * Handle the AirShipmentBill "restored" event.
     */
    public function restored(AirShipmentBill $AirShipmentBill): void
    {
        //
    }

    /**
     * Handle the AirShipmentBill "force deleted" event.
     */
    public function forceDeleted(AirShipmentBill $AirShipmentBill): void
    {
        //
    }
}
