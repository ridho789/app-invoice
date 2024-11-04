<?php

namespace App\Observers;
use App\Models\SeaShipmentBill;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistorySeaShipmentBillObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the SeaShipmentBill "created" event.
     */
    public function created(SeaShipmentBill $SeaShipmentBill): void
    {
        //
    }

    /**
     * Handle the SeaShipmentBill "updated" event.
     */
    public function updated(SeaShipmentBill $SeaShipmentBill): void
    {
        $extingHistorySeaShipmentBill = History::where('id_history', $SeaShipmentBill->id_history)->first();

        if ($extingHistorySeaShipmentBill) {
            $extingHistorySeaShipmentBill->update([
                'older_data' => json_encode($SeaShipmentBill->getOriginal()),
                'changed_data' => json_encode($SeaShipmentBill->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistorySeaShipmentBill->revcount
            ]);

        } else {
            $newSeaShipmentBillHistory = History::create([
                'id_changed_data' => $SeaShipmentBill->id_sea_shipment,
                'scope' => 'SeaShipmentBill',
                'older_data' => json_encode($SeaShipmentBill->getOriginal()),
                'changed_data' => json_encode($SeaShipmentBill->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newSeaShipmentBillHistory->id_history;
            SeaShipmentBill::where('id_sea_shipment_bill', $SeaShipmentBill->id_sea_shipment_bill)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the SeaShipmentBill "deleted" event.
     */
    public function deleted(SeaShipmentBill $SeaShipmentBill): void
    {
        //
    }

    /**
     * Handle the SeaShipmentBill "restored" event.
     */
    public function restored(SeaShipmentBill $SeaShipmentBill): void
    {
        //
    }

    /**
     * Handle the SeaShipmentBill "force deleted" event.
     */
    public function forceDeleted(SeaShipmentBill $SeaShipmentBill): void
    {
        //
    }
}
