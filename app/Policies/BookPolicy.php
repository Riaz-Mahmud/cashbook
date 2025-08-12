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
        // Owner, Admin, or Manager have full view rights
        if ($user->canManageBook($book)) {
            return true;
        }

        $role = $user->getBookRole($book);

        // Staff can view only if directly assigned to the book
        if ($role === 'staff') {
            return $user->books()
                ->where('books.id', $book->id)
                ->exists();
        }

        return false;
    }

    /**
     * Check if user can update the book.
     */
    public function update(User $user, Book $book): bool
    {
        // Manager role can update (includes owner/admin)
        return $user->getBookRole($book);
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
