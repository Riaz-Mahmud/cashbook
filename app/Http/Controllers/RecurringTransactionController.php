<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Category;
use App\Models\RecurringTransaction;
use Illuminate\Http\Request;

class RecurringTransactionController extends Controller
{
    public function index(Request $request)
    {
        $business = $request->attributes->get('activeBusiness');
        $items = RecurringTransaction::where('business_id', $business->id)->with(['book','category'])->get();
        return view('recurring.index', compact('items'));
    }

    public function create(Request $request)
    {
        $business = $request->attributes->get('activeBusiness');
        $books = Book::where('business_id', $business->id)->get();
        $categories = Category::where('business_id', $business->id)->get();
        return view('recurring.create', compact('books','categories'));
    }

    public function store(Request $request)
    {
        $business = $request->attributes->get('activeBusiness');
        $data = $request->validate([
            'book_id' => 'required|exists:books,id',
            'category_id' => 'nullable|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'frequency' => 'required|in:daily,weekly,monthly',
            'next_due_date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        $item = RecurringTransaction::create($data + [
            'business_id' => $business->id,
            'user_id' => $request->user()->id,
        ]);
        ActivityLog::create([
            'action' => 'recurring.created',
            'user_id' => $request->user()->id,
            'business_id' => $business->id,
            'subject_type' => RecurringTransaction::class,
            'subject_id' => $item->id,
        ]);
        return redirect()->route('recurring-transactions.index');
    }

    public function edit(Request $request, RecurringTransaction $recurring_transaction)
    {
        $business = $request->attributes->get('activeBusiness');
        abort_unless($recurring_transaction->business_id === $business->id, 404);
        $books = Book::where('business_id', $business->id)->get();
        $categories = Category::where('business_id', $business->id)->get();
        return view('recurring.edit', ['item' => $recurring_transaction, 'books' => $books, 'categories' => $categories]);
    }

    public function update(Request $request, RecurringTransaction $recurring_transaction)
    {
        $business = $request->attributes->get('activeBusiness');
        abort_unless($recurring_transaction->business_id === $business->id, 404);
        $data = $request->validate([
            'book_id' => 'required|exists:books,id',
            'category_id' => 'nullable|exists:categories,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|in:income,expense',
            'frequency' => 'required|in:daily,weekly,monthly',
            'next_due_date' => 'required|date',
            'description' => 'nullable|string',
        ]);
        $recurring_transaction->update($data);
        ActivityLog::create([
            'action' => 'recurring.updated',
            'user_id' => $request->user()->id,
            'business_id' => $business->id,
            'subject_type' => RecurringTransaction::class,
            'subject_id' => $recurring_transaction->id,
        ]);
        return redirect()->route('recurring-transactions.index');
    }

    public function destroy(Request $request, RecurringTransaction $recurring_transaction)
    {
        $business = $request->attributes->get('activeBusiness');
        abort_unless($recurring_transaction->business_id === $business->id, 404);
        $recurring_transaction->delete();
        ActivityLog::create([
            'action' => 'recurring.deleted',
            'user_id' => $request->user()->id,
            'business_id' => $business->id,
            'subject_type' => RecurringTransaction::class,
            'subject_id' => $recurring_transaction->id,
        ]);
        return redirect()->route('recurring-transactions.index');
    }
}
