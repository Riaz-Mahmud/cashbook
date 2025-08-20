<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Log;
use App\Notifications\TransactionCreated;
use App\Notifications\TransactionDeleted;
use App\Notifications\TransactionUpdated;
use Illuminate\Notifications\Notification;

class TransactionObserver
{
    /**
     * Handle the Transaction "created" event.
     */
    public function created(Transaction $transaction): void
    {
        $this->notifyUsers($transaction, new TransactionCreated($transaction));
    }

    /**
     * Handle the Transaction "updated" event.
     */
    public function updated(Transaction $transaction): void
    {
        $this->notifyUsers($transaction, new TransactionUpdated($transaction));
    }

    /**
     * Handle the Transaction "deleted" event.
     */
    public function deleted(Transaction $transaction): void
    {
        $this->notifyUsers($transaction, new TransactionDeleted($transaction));
    }

    /**
     * Handle the Transaction "restored" event.
     */
    public function restored(Transaction $transaction): void
    {
        //
    }

    /**
     * Handle the Transaction "force deleted" event.
     */
    public function forceDeleted(Transaction $transaction): void
    {
        //
    }

    protected function notifyUsers(Transaction $transaction, Notification $notification)
    {
        Log::info('Notifying users for transaction', ['transaction_id' => $transaction->id]);
        $book = $transaction->book;
        $user = $transaction->user;

        // Notify all users in the book except the creator
        $notifiables = $book->users()->where('users.id', '!=', $user->id)->get();

        foreach ($notifiables as $n) {
            Log::info('Notifying user', ['user_id' => $n->name, 'transaction_id' => $transaction->id]);
            $n->notify($notification);
        }
    }
}
