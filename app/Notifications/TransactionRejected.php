<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionRejected extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Transaction $transaction)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $t = $this->transaction;
        $biz = $t->business;
        return (new MailMessage)
            ->subject('Transaction Rejected - '.($biz->name ?? 'CashBook'))
            ->greeting('Hello')
            ->line('Your transaction was rejected:')
            ->line('Amount: '.$t->amount.' ('.$t->type.')')
            ->line('Book ID: '.$t->book_id)
            ->line('Date: '.$t->transaction_date?->toDateString())
            ->action('View Transactions', url(route('transactions.index')))
            ->line('Thanks!');
    }
}
