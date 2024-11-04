<?php

namespace App\Observers;

use App\Models\Shipper;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryShipperObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Shipper "created" event.
     */
    public function created(Shipper $shipper): void
    {
        //
    }

    /**
     * Handle the Shipper "updated" event.
     */
    public function updated(Shipper $shipper): void
    {
        $extingHistoryShipper = History::where('id_history', $shipper->id_history)->first();

        if ($extingHistoryShipper) {
            $extingHistoryShipper->update([
                'older_data' => json_encode($shipper->getOriginal()),
                'changed_data' => json_encode($shipper->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryShipper->revcount
            ]);

        } else {
            $newShipperHistory = History::create([
                'id_changed_data' => $shipper->id_shipper,
                'scope' => 'shipper',
                'older_data' => json_encode($shipper->getOriginal()),
                'changed_data' => json_encode($shipper->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newShipperHistory->id_history;
            Shipper::where('id_shipper', $shipper->id_shipper)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the Shipper "deleted" event.
     */
    public function deleted(Shipper $shipper): void
    {
        //
    }

    /**
     * Handle the Shipper "restored" event.
     */
    public function restored(Shipper $shipper): void
    {
        //
    }

    /**
     * Handle the Shipper "force deleted" event.
     */
    public function forceDeleted(Shipper $shipper): void
    {
        //
    }
}
