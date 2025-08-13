@php
    $output = fopen('php://output', 'w');

    // Add BOM for Excel to detect UTF-8
    fwrite($output, "\xEF\xBB\xBF");

    if ($report_type === 'summary') {
        // CSV header
        fputcsv($output, ['Date', 'Description', 'Category', 'Mode', 'Member', 'Type', 'Cash In', 'Cash Out', 'Balance']);

        $previousBalance = 0;

        foreach ($data['transactions'] as $t) {
            $amount = (float) $t->amount;
            $balance = $t->type === 'income' ? $previousBalance + $amount : $previousBalance - $amount;
            $previousBalance = $balance;

            fputcsv($output, [
                \Carbon\Carbon::parse($t->transaction_date)->format('Y-m-d H:i:s'),
                $t->description ?? '-',
                $t->category->name ?? '-',
                $t->mode ?? '-',
                $t->user->name ?? '-',
                $t->type === 'income' ? 'Income' : 'Expense',
                $t->type === 'income' ? number_format($amount, 2) : '',
                $t->type === 'expense' ? number_format($amount, 2) : '',
                number_format($balance, 2),
            ]);
        }

        // Footer totals
        fputcsv($output, [
            'Total',
            '',
            '',
            '',
            '',
            '',
            number_format($data['total_income'], 2),
            number_format($data['total_expense'], 2),
            number_format($data['total_income'] - $data['total_expense'], 2),
        ]);

    } else {
        // Category-wise or Member-wise
        $header = $report_type === 'category_wise' ? 'Category' : 'Member';
        fputcsv($output, [$header, 'Type', 'Total Amount']);

        foreach ($data as $item) {
            fputcsv($output, [
                $report_type === 'category_wise' ? ($item->category->name ?? 'Uncategorized') : ($item->user->name ?? 'Unknown'),
                $item->type === 'income' ? 'Income' : 'Expense',
                number_format($item->total, 2),
            ]);
        }
    }

    fclose($output);
@endphp
