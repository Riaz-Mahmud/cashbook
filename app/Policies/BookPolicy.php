<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function view(User $user, Book $book): bool
    {
        $role = $user->businesses()->where('business_id', $book->business_id)->value('role');
        if (in_array($role, ['owner','admin'])) { return true; }
        if ($role === 'staff') {
            return $user->belongsToMany(\App\Models\Book::class, 'book_user')->where('books.id', $book->id)->exists();
        }
        return false;
    }
    public function update(User $user, Book $book): bool
    {
        $role = $user->businesses()->where('business_id', $book->business_id)->value('role');
        return in_array($role, ['owner','admin']);
    }

    public function delete(User $user, Book $book): bool
    {
        $role = $user->businesses()->where('business_id', $book->business_id)->value('role');
        return in_array($role, ['owner']);
    }
}
