<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionsExport implements FromView
{
    public function __construct(
        protected int $businessId,
        protected ?string $from = null,
        protected ?string $to = null,
        protected ?int $categoryId = null,
        protected ?int $bookId = null,
    ) {}

    public function view(): View
    {
        $q = Transaction::where('business_id', $this->businessId)
            ->where('status', 'approved')
            ->with(['book','category']);
        if ($this->from) { $q->whereDate('transaction_date', '>=', $this->from); }
        if ($this->to) { $q->whereDate('transaction_date', '<=', $this->to); }
        if ($this->categoryId) { $q->where('category_id', $this->categoryId); }
        if ($this->bookId) { $q->where('book_id', $this->bookId); }
        $transactions = $q->orderBy('transaction_date')->get();
        return view('reports.export_table', compact('transactions'));
    }
}
