<?php

namespace App\Observers;

use App\Models\AirShipment;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryAirShipmentObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the AirShipment "created" event.
     */
    public function created(AirShipment $airShipment): void
    {
        //
    }

    /**
     * Handle the AirShipment "updated" event.
     */
    public function updated(AirShipment $airShipment): void
    {
        $extingHistoryAirShipment = History::where('id_history', $airShipment->id_history)->first();

        if ($extingHistoryAirShipment) {
            $extingHistoryAirShipment->update([
                'older_data' => json_encode($airShipment->getOriginal()),
                'changed_data' => json_encode($airShipment->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryAirShipment->revcount
            ]);

        } else {
            $newAirShipmentHistory = History::create([
                'id_changed_data' => $airShipment->id_air_shipment,
                'scope' => 'airShipment',
                'older_data' => json_encode($airShipment->getOriginal()),
                'changed_data' => json_encode($airShipment->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newAirShipmentHistory->id_history;
            AirShipment::where('id_air_shipment', $airShipment->id_air_shipment)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the AirShipment "deleted" event.
     */
    public function deleted(AirShipment $airShipment): void
    {
        //
    }

    /**
     * Handle the AirShipment "restored" event.
     */
    public function restored(AirShipment $airShipment): void
    {
        //
    }

    /**
     * Handle the AirShipment "force deleted" event.
     */
    public function forceDeleted(AirShipment $airShipment): void
    {
        //
    }
}
