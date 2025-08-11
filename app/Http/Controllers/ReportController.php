<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;
use Illuminate\Support\Str;

class ReportController extends Controller
{
        /**
     * Display the reports page.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\View\View
     */
    public function index(Book $book)
    {
        $this->authorize('view', $book);

        return view('reports.index', [
            'book' => $book,
            'categories' => $book->business->categories()->orderBy('name')->get(),
            'members' => $book->users()->orderBy('name')->get(),
        ]);
    }

    /**
     * Generate a report based on the given criteria.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(Request $request, Book $book)
    {
        $this->authorize('view', $book);

        $request->validate([
            'report_type' => 'required|in:summary,category_wise,member_wise',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $reportData = $this->getReportData($request, $book);

        return response()->json(['success' => true, 'data' => $reportData]);
    }

    /**
     * Download a report in the specified format.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse|\Illuminate\Http\Response
     */
    public function download(Request $request, Book $book)
    {
        $this->authorize('view', $book);

        $request->validate([
            'report_type' => 'required|in:summary,category_wise,member_wise',
            'format' => 'required|in:csv,pdf',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $data = $this->getReportData($request, $book);
        $fileName = Str::slug($book->name . '-' . $request->report_type . '-report-' . now()->format('Y-m-d')) . '.' . $request->format;

        $viewData = [
            'data' => $data,
            'book' => $book,
            'report_type' => $request->report_type,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ];

        if ($request->format === 'pdf') {
            $pdf = app('dompdf.wrapper');
            $pdf->loadView('reports.exports.pdf', $viewData);
            return $pdf->download($fileName);
        }

        if ($request->format === 'csv') {
            // We use a Blade view for CSV as well for consistency
            $headers = [
                'Content-type'        => 'text/csv',
                'Content-Disposition' => 'attachment; filename=' . $fileName,
            ];
            return response()->make(view('reports.exports.csv', $viewData), 200, $headers);
        }
    }

    /**
     * Private helper to fetch and structure report data.
     */
    private function getReportData(Request $request, Book $book)
    {
        $query = Transaction::where('book_id', $book->id)->where('status', 'approved');

        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        switch ($request->report_type) {
            case 'summary':
                return $this->generateSummaryReport($query);
            case 'category_wise':
                return $this->generateCategoryWiseReport($query);
            case 'member_wise':
                return $this->generateMemberWiseReport($query);
        }
        return [];
    }

    private function generateSummaryReport($query)
    {
        return [
            'total_income' => (clone $query)->where('type', 'income')->sum('amount'),
            'total_expense' => (clone $query)->where('type', 'expense')->sum('amount'),
            'transactions' => (clone $query)->latest()->get(),
        ];
    }

    private function generateCategoryWiseReport($query)
    {
        return (clone $query)->with('category')
            ->select('category_id', 'type', DB::raw('SUM(amount) as total'))
            ->groupBy('category_id', 'type')
            ->get();
    }

    private function generateMemberWiseReport($query)
    {
        return (clone $query)->with('user')
            ->select('user_id', 'type', DB::raw('SUM(amount) as total'))
            ->groupBy('user_id', 'type')
            ->get();
    }
}
