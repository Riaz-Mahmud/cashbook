@php
    $output = fopen('php://output', 'w');
    if ($report_type === 'summary') {
        fputcsv($output, ['Date', 'Description', 'Type', 'Amount']);
        foreach ($data['transactions'] as $t) {
            fputcsv($output, [
                \Carbon\Carbon::parse($t->transaction_date)->format('Y-m-d'),
                $t->description ?? 'N/A',
                $t->type,
                $t->amount,
            ]);
        }
    } else {
        $header = $report_type === 'category_wise' ? 'Category' : 'Member';
        fputcsv($output, [$header, 'Type', 'Total Amount']);
        foreach ($data as $item) {
            fputcsv($output, [
                $report_type === 'category_wise' ? ($item->category->name ?? 'Uncategorized') : ($item->user->name ?? 'Unknown'),
                $item->type,
                $item->total,
            ]);
        }
    }
@endphp
