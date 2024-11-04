<?php

namespace App\Observers;
use App\Models\Account;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryAccountObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Account "created" event.
     */
    public function created(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "updated" event.
     */
    public function updated(Account $account): void
    {
        $extingHistoryAccount = History::where('id_history', $account->id_history)->first();

        if ($extingHistoryAccount) {
            $extingHistoryAccount->update([
                'older_data' => json_encode($account->getOriginal()),
                'changed_data' => json_encode($account->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryAccount->revcount
            ]);

        } else {
            $newAccountHistory = History::create([
                'id_changed_data' => $account->id_account,
                'scope' => 'Account',
                'older_data' => json_encode($account->getOriginal()),
                'changed_data' => json_encode($account->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newAccountHistory->id_history;
            Account::where('id_account', $account->id_account)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the Account "deleted" event.
     */
    public function deleted(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "restored" event.
     */
    public function restored(Account $account): void
    {
        //
    }

    /**
     * Handle the Account "force deleted" event.
     */
    public function forceDeleted(Account $account): void
    {
        //
    }
}
