<?php

namespace App\Observers;
use App\Models\SeaShipmentAnotherBill;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistorySeaShipmentAnotherBillObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the SeaShipmentAnotherBill "created" event.
     */
    public function created(SeaShipmentAnotherBill $SeaShipmentAnotherBill): void
    {
        //
    }

    /**
     * Handle the SeaShipmentAnotherBill "updated" event.
     */
    public function updated(SeaShipmentAnotherBill $SeaShipmentAnotherBill): void
    {
        $extingHistorySeaShipmentAnotherBill = History::where('id_history', $SeaShipmentAnotherBill->id_history)->first();

        if ($extingHistorySeaShipmentAnotherBill) {
            $extingHistorySeaShipmentAnotherBill->update([
                'older_data' => json_encode($SeaShipmentAnotherBill->getOriginal()),
                'changed_data' => json_encode($SeaShipmentAnotherBill->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistorySeaShipmentAnotherBill->revcount
            ]);

        } else {
            $newSeaShipmentAnotherBillHistory = History::create([
                'id_changed_data' => $SeaShipmentAnotherBill->id_sea_shipment,
                'scope' => 'SeaShipmentAnotherBill',
                'older_data' => json_encode($SeaShipmentAnotherBill->getOriginal()),
                'changed_data' => json_encode($SeaShipmentAnotherBill->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newSeaShipmentAnotherBillHistory->id_history;
            SeaShipmentAnotherBill::where('id_sea_shipment_other_bill', $SeaShipmentAnotherBill->id_sea_shipment_other_bill)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the SeaShipmentAnotherBill "deleted" event.
     */
    public function deleted(SeaShipmentAnotherBill $SeaShipmentAnotherBill): void
    {
        //
    }

    /**
     * Handle the SeaShipmentAnotherBill "restored" event.
     */
    public function restored(SeaShipmentAnotherBill $SeaShipmentAnotherBill): void
    {
        //
    }

    /**
     * Handle the SeaShipmentAnotherBill "force deleted" event.
     */
    public function forceDeleted(SeaShipmentAnotherBill $SeaShipmentAnotherBill): void
    {
        //
    }
}
