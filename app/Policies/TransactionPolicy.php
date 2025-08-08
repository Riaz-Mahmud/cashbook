<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    public function approve(User $user, Transaction $transaction): bool
    {
        // Check business-level permissions first
        $businessRole = $user->businesses()->where('business_id', $transaction->business_id)->value('role');
        if (in_array($businessRole, ['owner', 'admin'])) {
            return true;
        }

        // Check book-level permissions
        $bookRole = $user->getBookRole($transaction->book);
        return $bookRole === 'manager';
    }

    public function view(User $user, Transaction $transaction): bool
    {
        // Check business-level permissions first
        $businessRole = $user->businesses()->where('business_id', $transaction->business_id)->value('role');
        if (in_array($businessRole, ['owner', 'admin'])) {
            return true;
        }

        // Check book-level permissions
        return $user->canViewBook($transaction->book);
    }

    public function update(User $user, Transaction $transaction): bool
    {
        // Check business-level permissions first
        $businessRole = $user->businesses()->where('business_id', $transaction->business_id)->value('role');
        if (in_array($businessRole, ['owner', 'admin'])) {
            return true;
        }

        // Check book-level permissions
        $bookRole = $user->getBookRole($transaction->book);

        // Managers can edit any transaction
        if ($bookRole === 'manager') {
            return true;
        }

        // Editors can only edit their own transactions
        if ($bookRole === 'editor') {
            return $transaction->user_id === $user->id;
        }

        return false;
    }

    public function delete(User $user, Transaction $transaction): bool
    {
        // Check business-level permissions first
        $businessRole = $user->businesses()->where('business_id', $transaction->business_id)->value('role');
        if (in_array($businessRole, ['owner', 'admin'])) {
            return true;
        }

        // Check book-level permissions
        $bookRole = $user->getBookRole($transaction->book);

        // Managers can delete any transaction
        if ($bookRole === 'manager') {
            return true;
        }

        // Editors can only delete their own transactions
        if ($bookRole === 'editor') {
            return $transaction->user_id === $user->id;
        }

        return false;
    }
}
