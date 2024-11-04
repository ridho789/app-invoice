<?php

namespace App\Observers;

use App\Models\SeaShipment;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistorySeaShipmentObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the SeaShipment "created" event.
     */
    public function created(SeaShipment $seaShipment): void
    {
        //
    }

    /**
     * Handle the SeaShipment "updated" event.
     */
    public function updated(SeaShipment $seaShipment): void
    {
        $extingHistorySeaShipment = History::where('id_history', $seaShipment->id_history)->first();

        if ($extingHistorySeaShipment) {
            $extingHistorySeaShipment->update([
                'older_data' => json_encode($seaShipment->getOriginal()),
                'changed_data' => json_encode($seaShipment->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistorySeaShipment->revcount
            ]);

        } else {
            $newSeaShipmentHistory = History::create([
                'id_changed_data' => $seaShipment->id_sea_shipment,
                'scope' => 'seaShipment',
                'older_data' => json_encode($seaShipment->getOriginal()),
                'changed_data' => json_encode($seaShipment->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newSeaShipmentHistory->id_history;
            SeaShipment::where('id_sea_shipment', $seaShipment->id_sea_shipment)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the SeaShipment "deleted" event.
     */
    public function deleted(SeaShipment $seaShipment): void
    {
        //
    }

    /**
     * Handle the SeaShipment "restored" event.
     */
    public function restored(SeaShipment $seaShipment): void
    {
        //
    }

    /**
     * Handle the SeaShipment "force deleted" event.
     */
    public function forceDeleted(SeaShipment $seaShipment): void
    {
        //
    }
}
