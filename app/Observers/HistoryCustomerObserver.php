<?php

namespace App\Observers;

use App\Models\Customer;
use App\Models\History;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class HistoryCustomerObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        $extingHistoryCustomer = History::where('id_history', $customer->id_history)->first();

        if ($extingHistoryCustomer) {
            $extingHistoryCustomer->update([
                'older_data' => json_encode($customer->getOriginal()),
                'changed_data' => json_encode($customer->getChanges()),
                'user_id' => auth()->id(),
                'revcount' => ++$extingHistoryCustomer->revcount
            ]);

        } else {
            $newCustomerHistory = History::create([
                'id_changed_data' => $customer->id_customer,
                'scope' => 'customer',
                'older_data' => json_encode($customer->getOriginal()),
                'changed_data' => json_encode($customer->getChanges()),
                'action' => 'update',
                'user_id' => auth()->id(),
                'revcount' => 1
            ]);

            $id_history = $newCustomerHistory->id_history;
            Customer::where('id_customer', $customer->id_customer)->update([
                'id_history' => $id_history
            ]);
        }
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
