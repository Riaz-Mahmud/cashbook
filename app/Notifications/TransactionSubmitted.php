<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionSubmitted extends Notification implements ShouldQueue
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
            ->subject('New Transaction Submitted - '.($biz->name ?? 'CashBook'))
            ->greeting('Hello')
            ->line('A new transaction was submitted and is awaiting approval:')
            ->line('Amount: '.$t->amount.' ('.$t->type.')')
            ->line('Book ID: '.$t->book_id)
            ->line('Date: '.$t->transaction_date?->toDateString())
            ->action('Review Transactions', url(route('transactions.index')))
            ->line('Thank you for using CashBook!');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'transaction_id' => $this->transaction->id,
            'business_id' => $this->transaction->business_id,
            'action' => 'submitted',
        ];
    }
}
