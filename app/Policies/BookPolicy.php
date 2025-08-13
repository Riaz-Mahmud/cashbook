<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    /**
     * Check if user can view the book.
     */
    public function view(User $user, Book $book): bool
    {
        $role = $user->getBookRole($book);

        // Managers, editors, viewers can view
        return in_array($role, ['manager', 'editor', 'viewer']);
    }

    /**
     * Check if user can update the book.
     */
    public function update(User $user, Book $book): bool
    {
        // Manager role can update (includes owner/admin)
        return $user->canManageBook($book);
    }

    /**
     * Check if user can delete the book.
     */
    public function delete(User $user, Book $book): bool
    {
        // Manager role can delete (includes owner/admin)
        return $user->canManageBook($book);
    }
}
