<?php


namespace App\Policies;

use App\Models\Business;
use App\Models\User;

class BusinessPolicy
{
    public function update(User $user, Business $business): bool
    {
        $role = $user->businesses()->where('business_id', $business->id)->value('role');
        return in_array($role, ['owner','admin']);
    }

    public function delete(User $user, Business $business): bool
    {
        $role = $user->businesses()->where('business_id', $business->id)->value('role');
        return $role === 'owner';
    }

    public function view(User $user, Business $business): bool
    {
        // Allow any user attached to the business to view it
        return $user->businesses()->where('business_id', $business->id)->exists();
    }

    public function create(User $user): bool
    {
        // Any authenticated user can create a business
        return $user->exists;
    }

    public function switch(User $user, Business $business): bool
    {
        // Allow switching to any business the user is attached to
        return $user->businesses()->where('business_id', $business->id)->exists();
    }
}
