<?php

namespace App\Observers;
use App\Models\Uom;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryUomObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Uom "created" event.
     */
    public function created(Uom $uom): void
    {
        //
    }

    /**
     * Handle the Uom "updated" event.
     */
    public function updated(Uom $uom): void
    {
        $extingHistoryUom = History::where('id_history', $uom->id_history)->first();

        if ($extingHistoryUom) {
            $extingHistoryUom->update([
                'older_data' => json_encode($uom->getOriginal()),
                'changed_data' => json_encode($uom->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryUom->revcount
            ]);

        } else {
            $newUomHistory = History::create([
                'id_changed_data' => $uom->id_uom,
                'scope' => 'Uom',
                'older_data' => json_encode($uom->getOriginal()),
                'changed_data' => json_encode($uom->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newUomHistory->id_history;
            Uom::where('id_uom', $uom->id_uom)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the Uom "deleted" event.
     */
    public function deleted(Uom $uom): void
    {
        //
    }

    /**
     * Handle the Uom "restored" event.
     */
    public function restored(Uom $uom): void
    {
        //
    }

    /**
     * Handle the Uom "force deleted" event.
     */
    public function forceDeleted(Uom $uom): void
    {
        //
    }
}
