<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TransactionDeleted extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Transaction $transaction) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Transaction Deleted',
            'message' => "The transaction has been deleted by {$this->transaction->user->name} for {$this->transaction->book->currency} {$this->transaction->amount}",
            'link' => route('books.show', $this->transaction->book_id),
            'transaction_id' => $this->transaction->id,
            'type' => $this->transaction->type,
            'amount' => $this->transaction->amount,
            'status' => $this->transaction->status,
            'action' => 'deleted',
            'timestamp' => now(),
        ];
    }
}
