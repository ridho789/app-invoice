<?php

namespace App\Observers;
use App\Models\Origin;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryOriginObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Origin "created" event.
     */
    public function created(Origin $origin): void
    {
        //
    }

    /**
     * Handle the Origin "updated" event.
     */
    public function updated(Origin $origin): void
    {
        $extingHistoryOrigin = History::where('id_history', $origin->id_history)->first();

        if ($extingHistoryOrigin) {
            $extingHistoryOrigin->update([
                'older_data' => json_encode($origin->getOriginal()),
                'changed_data' => json_encode($origin->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryOrigin->revcount
            ]);

        } else {
            $newOriginHistory = History::create([
                'id_changed_data' => $origin->id_origin,
                'scope' => 'Origin',
                'older_data' => json_encode($origin->getOriginal()),
                'changed_data' => json_encode($origin->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newOriginHistory->id_history;
            Origin::where('id_origin', $origin->id_origin)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the Origin "deleted" event.
     */
    public function deleted(Origin $origin): void
    {
        //
    }

    /**
     * Handle the Origin "restored" event.
     */
    public function restored(Origin $origin): void
    {
        //
    }

    /**
     * Handle the Origin "force deleted" event.
     */
    public function forceDeleted(Origin $origin): void
    {
        //
    }
}
