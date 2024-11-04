<?php

namespace App\Observers;

use App\Models\Cas;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryCasObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Cas "created" event.
     */
    public function created(Cas $cas): void
    {
        //
    }

    /**
     * Handle the Cas "updated" event.
     */
    public function updated(Cas $cas): void
    {
        $extingHistoryCas = History::where('id_history', $cas->id_history)->first();

        if ($extingHistoryCas) {
            $extingHistoryCas->update([
                'older_data' => json_encode($cas->getOriginal()),
                'changed_data' => json_encode($cas->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryCas->revcount
            ]);

        } else {
            $newCasHistory = History::create([
                'id_changed_data' => $cas->id_cas,
                'scope' => 'cas',
                'older_data' => json_encode($cas->getOriginal()),
                'changed_data' => json_encode($cas->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newCasHistory->id_history;
            Cas::where('id_cas', $cas->id_cas)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the Cas "deleted" event.
     */
    public function deleted(Cas $cas): void
    {
        //
    }

    /**
     * Handle the Cas "restored" event.
     */
    public function restored(Cas $cas): void
    {
        //
    }

    /**
     * Handle the Cas "force deleted" event.
     */
    public function forceDeleted(Cas $cas): void
    {
        //
    }
}
