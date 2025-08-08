<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Category;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index(Request $request)
    {
        $business = $request->attributes->get('activeBusiness');
        $month = $request->input('month', now()->format('Y-m-01'));
        $budgets = Budget::where('business_id', $business->id)->where('month', $month)->with('category')->get();
        $categories = Category::where('business_id', $business->id)->get();
        return view('budgets.index', compact('budgets','categories','month'));
    }

    public function store(Request $request)
    {
        $business = $request->attributes->get('activeBusiness');
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'month' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);
        Budget::updateOrCreate([
            'business_id' => $business->id,
            'category_id' => $data['category_id'],
            'month' => $data['month'],
        ], [ 'amount' => $data['amount'] ]);
        return back();
    }

    public function destroy(Request $request, Budget $budget)
    {
        $business = $request->attributes->get('activeBusiness');
        abort_unless($budget->business_id === $business->id, 404);
        $budget->delete();
        return back();
    }
}
