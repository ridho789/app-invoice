<?php

namespace App\Observers;
use App\Models\Banker;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryBankerObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Banker "created" event.
     */
    public function created(Banker $banker): void
    {
        //
    }

    /**
     * Handle the Banker "updated" event.
     */
    public function updated(Banker $banker): void
    {
        $extingHistoryBanker = History::where('id_history', $banker->id_history)->first();

        if ($extingHistoryBanker) {
            $extingHistoryBanker->update([
                'older_data' => json_encode($banker->getOriginal()),
                'changed_data' => json_encode($banker->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryBanker->revcount
            ]);

        } else {
            $newBankerHistory = History::create([
                'id_changed_data' => $banker->id_banker,
                'scope' => 'Banker',
                'older_data' => json_encode($banker->getOriginal()),
                'changed_data' => json_encode($banker->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newBankerHistory->id_history;
            Banker::where('id_banker', $banker->id_banker)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the Banker "deleted" event.
     */
    public function deleted(Banker $banker): void
    {
        //
    }

    /**
     * Handle the Banker "restored" event.
     */
    public function restored(Banker $banker): void
    {
        //
    }

    /**
     * Handle the Banker "force deleted" event.
     */
    public function forceDeleted(Banker $banker): void
    {
        //
    }
}
