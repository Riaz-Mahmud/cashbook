<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Category;
use App\Models\ActivityLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class TransactionImportController extends Controller
{
    /**
     * Show the form for uploading a CSV file.
     *
     * @param  \App\Models\Book  $book
     * @return \Illuminate\View\View
     */
    public function create(Book $book)
    {
        $this->authorize('update', $book);
        return view('transactions.import', compact('book'));
    }

    /**
     * Handle the import of a CSV file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Book  $book
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Book $book)
    {
        try {
            $this->authorize('update', $book);

            $request->validate([
                'csv_file' => 'required|file|mimes:csv,txt,xls,xlsx|max:2048',
            ]);

            // Load file via PhpSpreadsheet
            $spreadsheet = IOFactory::load($request->file('csv_file')->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, true, true);

            // First row is header
            $header = array_map('trim', $rows[1]);
            unset($rows[1]);

            $successCount = 0;
            $errorCount = 0;
            $errorLog = [];

            foreach ($rows as $rowIndex => $row) {
                // Map header to row values
                $data = [];
                foreach ($header as $key => $colName) {
                    $data[$colName] = isset($row[$key]) ? trim((string) $row[$key]) : null;
                }

                // --- Handle Date ---
                try {
                    if (is_numeric($data['Date'])) {
                        // Excel serial date
                        $data['Date'] = Carbon::instance(ExcelDate::excelToDateTimeObject($data['Date']))->format('Y-m-d');
                    } else {
                        $data['Date'] = Carbon::parse($data['Date'])->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                    $errorLog[] = "Row {$rowIndex}: Invalid Date - '{$data['Date']}'";
                    continue;
                }

                // --- Handle Time ---
                try {
                    if (!empty($data['Time'])) {
                        if (is_numeric($data['Time'])) {
                            $data['Time'] = Carbon::instance(ExcelDate::excelToDateTimeObject($data['Time']))->format('h:i A');
                        } else {
                            $data['Time'] = Carbon::parse($data['Time'])->format('h:i A');
                        }
                    } else {
                        $data['Time'] = '12:00 AM'; // default if missing
                    }
                } catch (\Exception $e) {
                    $errorCount++;
                    $errorLog[] = "Row {$rowIndex}: Invalid Time - '{$data['Time']}'";
                    continue;
                }

                // --- Validate amount ---
                if (empty($data['Cash In']) && empty($data['Cash Out'])) {
                    $errorCount++;
                    $errorLog[] = "Row {$rowIndex}: No Cash In or Cash Out value";
                    continue;
                }

                // --- Category ---
                $category = null;
                if (!empty($data['Category'])) {
                    $category = Category::firstOrCreate(
                        ['name' => $data['Category'], 'business_id' => $book->business_id],
                        ['type' => !empty($data['Cash In']) ? 'income' : 'expense']
                    );
                }

                // --- Create Transaction ---
                $transaction = Transaction::create([
                    'business_id' => $book->business_id,
                    'book_id' => $book->id,
                    'user_id' => Auth::id(),
                    'transaction_date' => Carbon::parse($data['Date'] . ' ' . $data['Time']),
                    'type' => !empty($data['Cash In']) ? 'income' : 'expense',
                    'status' => 'approved',
                    'amount' => !empty($data['Cash In']) ? $data['Cash In'] : $data['Cash Out'],
                    'description' => $data['Remark'],
                    'category_id' => $category ? $category->id : null,
                    'mode' => strtolower($data['Mode']),
                ]);

                // --- Log Activity ---
                ActivityLog::create([
                    'action' => 'transaction.imported',
                    'user_id' => Auth::id(),
                    'business_id' => $book->business_id,
                    'subject_type' => Transaction::class,
                    'subject_id' => $transaction->id,
                    'details' => [
                        'amount' => $transaction->amount,
                        'type' => !empty($data['Cash In']) ? 'income' : 'expense'
                    ],
                ]);

                $successCount++;
            }

            $notification = [
                'message' => "Imported {$successCount} transactions. Skipped {$errorCount} rows.",
                'alert-type' => $errorCount > 0 ? 'warning' : 'success'
            ];

            if ($errorCount > 0) {
                // You can log this somewhere else instead of dd()
                Log::warning('Transaction Import Skipped Rows', $errorLog);
            }

            // update book updated_at timestamp
            $book->touch();

            return redirect()->route('books.show', $book)->with($notification);

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'An error occurred while importing transactions: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

}
