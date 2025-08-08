<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BusinessSwitcherController extends Controller
{
    public function switch(Request $request, Business $business): RedirectResponse
    {
        // Ensure user belongs to business
        abort_unless($request->user()->businesses()->whereKey($business->id)->exists(), 403);
        session(['active_business_id' => $business->id]);
    return redirect()->route('books.index');
    }
}
