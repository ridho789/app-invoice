<?php

namespace App\Observers;
use App\Models\AirShipmentAnotherBill;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryAirShipmentAnotherBillObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the AirShipmentAnotherBill "created" event.
     */
    public function created(AirShipmentAnotherBill $AirShipmentAnotherBill): void
    {
        //
    }

    /**
     * Handle the AirShipmentAnotherBill "updated" event.
     */
    public function updated(AirShipmentAnotherBill $AirShipmentAnotherBill): void
    {
        $extingHistoryAirShipmentAnotherBill = History::where('id_history', $AirShipmentAnotherBill->id_history)->first();

        if ($extingHistoryAirShipmentAnotherBill) {
            $extingHistoryAirShipmentAnotherBill->update([
                'older_data' => json_encode($AirShipmentAnotherBill->getOriginal()),
                'changed_data' => json_encode($AirShipmentAnotherBill->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryAirShipmentAnotherBill->revcount
            ]);

        } else {
            $newAirShipmentAnotherBillHistory = History::create([
                'id_changed_data' => $AirShipmentAnotherBill->id_air_shipment,
                'scope' => 'AirShipmentAnotherBill',
                'older_data' => json_encode($AirShipmentAnotherBill->getOriginal()),
                'changed_data' => json_encode($AirShipmentAnotherBill->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newAirShipmentAnotherBillHistory->id_history;
            AirShipmentAnotherBill::where('id_air_shipment_other_bill', $AirShipmentAnotherBill->id_air_shipment_other_bill)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the AirShipmentAnotherBill "deleted" event.
     */
    public function deleted(AirShipmentAnotherBill $AirShipmentAnotherBill): void
    {
        //
    }

    /**
     * Handle the AirShipmentAnotherBill "restored" event.
     */
    public function restored(AirShipmentAnotherBill $AirShipmentAnotherBill): void
    {
        //
    }

    /**
     * Handle the AirShipmentAnotherBill "force deleted" event.
     */
    public function forceDeleted(AirShipmentAnotherBill $AirShipmentAnotherBill): void
    {
        //
    }
}
