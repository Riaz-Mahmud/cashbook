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
        return ['mail', 'database'];
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
            ->action('View Transactions', url(route('books.show', ['book' => $t->book_id])))
            ->line('Thanks!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'transaction_id' => $this->transaction->id,
            'amount' => $this->transaction->amount,
            'type' => $this->transaction->type,
            'book_id' => $this->transaction->book_id,
            'transaction_date' => $this->transaction->transaction_date?->toDateString(),
            'title' => 'Transaction Approved',
            'message' => 'Your transaction has been approved by the ' . ($this->transaction->user->name ?? 'system'),
            'link' => route('books.show', ['book' => $this->transaction->book_id]),
        ];
    }
}
