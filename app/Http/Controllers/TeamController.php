<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $business = $request->attributes->get('activeBusiness');
        $members = $business->users()->get();
        return view('settings.index', compact('business','members'));
    }

    public function updateBusiness(Request $request)
    {
        $business = $request->attributes->get('activeBusiness');
        $data = $request->validate(['name' => 'required|string|max:255', 'currency' => 'required|string|size:3']);
        $business->update($data);
        return back();
    }

    public function invite(Request $request)
    {
        $business = $request->attributes->get('activeBusiness');
        $data = $request->validate(['email' => 'required|email', 'role' => 'required|in:owner,admin,staff']);
        $user = User::where('email', $data['email'])->first();
        if (!$user) {
            return back()->withErrors(['email' => 'User not found. Create an account first.']);
        }
        $business->users()->syncWithoutDetaching([$user->id => ['role' => $data['role']]]);
        return back();
    }

    public function updateRole(Request $request, User $user)
    {
        $business = $request->attributes->get('activeBusiness');
        $data = $request->validate(['role' => 'required|in:owner,admin,staff']);
        // Prevent removing last owner
        if ($data['role'] !== 'owner') {
            $ownerCount = $business->users()->wherePivot('role','owner')->count();
            if ($ownerCount <= 1 && $business->users()->wherePivot('role','owner')->where('users.id', $user->id)->exists()) {
                return back()->withErrors(['role' => 'Cannot demote the last owner.']);
            }
        }
        $business->users()->updateExistingPivot($user->id, ['role' => $data['role']]);
        return back();
    }

    public function remove(Request $request, User $user)
    {
        $business = $request->attributes->get('activeBusiness');
        // Prevent removing last owner
        if ($business->users()->wherePivot('role','owner')->where('users.id', $user->id)->exists()) {
            $ownerCount = $business->users()->wherePivot('role','owner')->count();
            if ($ownerCount <= 1) {
                return back()->withErrors(['member' => 'Cannot remove the last owner.']);
            }
        }
        $business->users()->detach($user->id);
        return back();
    }
}
