<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionApproved extends Notification implements ShouldQueue
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
            ->subject('Transaction Approved - '.($biz->name ?? 'CashBook'))
            ->greeting('Hello')
            ->line('Your transaction was approved:')
            ->line('Amount: '.$t->amount.' ('.$t->type.')')
            ->line('Book ID: '.$t->book_id)
            ->line('Date: '.$t->transaction_date?->toDateString())
            ->action('View Transactions', url(route('transactions.index')))
            ->line('Thanks!');
    }
}
