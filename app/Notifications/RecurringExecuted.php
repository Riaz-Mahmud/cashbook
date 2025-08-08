<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecurringExecuted extends Notification implements ShouldQueue
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
            ->subject('Recurring Transaction Executed - '.($biz->name ?? 'CashBook'))
            ->greeting('Hello')
            ->line('A recurring transaction ran automatically:')
            ->line('Amount: '.$t->amount.' ('.$t->type.')')
            ->line('Book ID: '.$t->book_id)
            ->line('Date: '.$t->transaction_date?->toDateString())
            ->action('View Transactions', url(route('transactions.index')))
            ->line('This is an automated message.');
    }
}
