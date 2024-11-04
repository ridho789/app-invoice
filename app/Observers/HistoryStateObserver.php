<?php

namespace App\Observers;
use App\Models\History;
use App\Models\State;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryStateObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the State "created" event.
     */
    public function created(State $state): void
    {
        //
    }

    /**
     * Handle the State "updated" event.
     */
    public function updated(State $state): void
    {
        $extingHistoryState = History::where('id_history', $state->id_history)->first();

        if ($extingHistoryState) {
            $extingHistoryState->update([
                'older_data' => json_encode($state->getOriginal()),
                'changed_data' => json_encode($state->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryState->revcount
            ]);

        } else {
            $newStateHistory = History::create([
                'id_changed_data' => $state->id_state,
                'scope' => 'State',
                'older_data' => json_encode($state->getOriginal()),
                'changed_data' => json_encode($state->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newStateHistory->id_history;
            State::where('id_state', $state->id_state)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the State "deleted" event.
     */
    public function deleted(State $state): void
    {
        //
    }

    /**
     * Handle the State "restored" event.
     */
    public function restored(State $state): void
    {
        //
    }

    /**
     * Handle the State "force deleted" event.
     */
    public function forceDeleted(State $state): void
    {
        //
    }
}
