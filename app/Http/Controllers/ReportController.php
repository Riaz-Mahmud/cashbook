<?php

namespace App\Http\Controllers;

use App\Exports\TransactionsExport;
use App\Models\Book;
use App\Models\Category;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $business = $request->attributes->get('activeBusiness');
        $books = Book::where('business_id', $business->id)->get();
        $categories = Category::where('business_id', $business->id)->get();
        return view('reports.index', compact('books','categories'));
    }

    public function export(Request $request)
    {
        $business = $request->attributes->get('activeBusiness');
        $data = $request->validate([
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
            'book_id' => 'nullable|exists:books,id',
            'format' => 'required|in:pdf,xlsx',
        ]);

        $dateStr = now()->format('Y-m-d');
        $filename = 'Report_'.$business->name.'_'.$dateStr;

        if ($data['format'] === 'xlsx') {
            return Excel::download(new TransactionsExport($business->id, $data['from'] ?? null, $data['to'] ?? null, $data['category_id'] ?? null, $data['book_id'] ?? null), $filename.'.xlsx');
        }

        // PDF
        $q = Transaction::where('business_id', $business->id)
            ->where('status', 'approved')
            ->with(['book','category']);
        if (!empty($data['from'])) $q->whereDate('transaction_date', '>=', $data['from']);
        if (!empty($data['to'])) $q->whereDate('transaction_date', '<=', $data['to']);
        if (!empty($data['category_id'])) $q->where('category_id', $data['category_id']);
        if (!empty($data['book_id'])) $q->where('book_id', $data['book_id']);
        $transactions = $q->orderBy('transaction_date')->get();

        $pdf = Pdf::loadView('reports.pdf', compact('business','transactions'));
        return $pdf->download($filename.'.pdf');
    }
}
