<?php

namespace App\Observers;

use App\Models\Ship;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryShipObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Ship "created" event.
     */
    public function created(Ship $ship): void
    {
        //
    }

    /**
     * Handle the Ship "updated" event.
     */
    public function updated(Ship $ship): void
    {
        $extingHistoryShip = History::where('id_history', $ship->id_history)->first();

        if ($extingHistoryShip) {
            $extingHistoryShip->update([
                'older_data' => json_encode($ship->getOriginal()),
                'changed_data' => json_encode($ship->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryShip->revcount
            ]);

        } else {
            $newShipHistory = History::create([
                'id_changed_data' => $ship->id_ship,
                'scope' => 'ship',
                'older_data' => json_encode($ship->getOriginal()),
                'changed_data' => json_encode($ship->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newShipHistory->id_history;
            Ship::where('id_ship', $ship->id_ship)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the Ship "deleted" event.
     */
    public function deleted(Ship $ship): void
    {
        //
    }

    /**
     * Handle the Ship "restored" event.
     */
    public function restored(Ship $ship): void
    {
        //
    }

    /**
     * Handle the Ship "force deleted" event.
     */
    public function forceDeleted(Ship $ship): void
    {
        //
    }
}
