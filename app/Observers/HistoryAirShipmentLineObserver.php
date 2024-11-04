<?php

namespace App\Observers;

use App\Models\AirShipmentLine;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryAirShipmentLineObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the AirShipmentLine "created" event.
     */
    public function created(AirShipmentLine $airShipmentLine): void
    {
        //
    }

    /**
     * Handle the AirShipmentLine "updated" event.
     */
    public function updated(AirShipmentLine $airShipmentLine): void
    {
        $extingHistoryAirShipmentLine = History::where('id_history', $airShipmentLine->id_history)->first();

        if ($extingHistoryAirShipmentLine) {
            $extingHistoryAirShipmentLine->update([
                'older_data' => json_encode($airShipmentLine->getOriginal()),
                'changed_data' => json_encode($airShipmentLine->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryAirShipmentLine->revcount
            ]);

        } else {
            $newAirShipmentLineHistory = History::create([
                'id_changed_data' => $airShipmentLine->id_air_shipment,
                'scope' => 'airShipmentLine',
                'older_data' => json_encode($airShipmentLine->getOriginal()),
                'changed_data' => json_encode($airShipmentLine->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newAirShipmentLineHistory->id_history;
            AirShipmentLine::where('id_air_shipment_line', $airShipmentLine->id_air_shipment_line)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the AirShipmentLine "deleted" event.
     */
    public function deleted(AirShipmentLine $airShipmentLine): void
    {
        //
    }

    /**
     * Handle the AirShipmentLine "restored" event.
     */
    public function restored(AirShipmentLine $airShipmentLine): void
    {
        //
    }

    /**
     * Handle the AirShipmentLine "force deleted" event.
     */
    public function forceDeleted(AirShipmentLine $airShipmentLine): void
    {
        //
    }
}
