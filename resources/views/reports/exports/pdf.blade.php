<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; }
        .table th { background-color: #f2f2f2; text-align: left; }
        .text-right { text-align: right; }
        .badge { padding: 2px 6px; border-radius: 4px; color: white; }
        .badge-success { background-color: #059669; }
        .badge-danger { background-color: #dc2626; }
        h1, h2 { text-align: center; }
    </style>
</head>
<body>
    <h1>{{ $book->name }}</h1>
    <h2>{{ ucwords(str_replace('_', ' ', $report_type)) }} Report</h2>

    @if($report_type === 'summary')
        <h3>Summary</h3>
        <p><strong>Total Income:</strong> {{ $book->currency }} {{ number_format($data['total_income'], 2) }}</p>
        <p><strong>Total Expense:</strong> {{ $book->currency }} {{ number_format($data['total_expense'], 2) }}</p>
        <p><strong>Net Balance:</strong> {{ $book->currency }} {{ number_format($data['total_income'] - $data['total_expense'], 2) }}</p>
        <hr>
        <h3>Transactions</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Type</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['transactions'] as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->transaction_date)->format('Y-m-d') }}</td>
                    <td>{{ $t->description ?? 'N/A' }}</td>
                    <td><span class="badge {{ $t->type === 'income' ? 'badge-success' : 'badge-danger' }}">{{ $t->type }}</span></td>
                    <td class="text-right">{{ number_format($t->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>{{ $report_type === 'category_wise' ? 'Category' : 'Member' }}</th>
                    <th>Type</th>
                    <th class="text-right">Total Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $item)
                <tr>
                    <td>{{ $report_type === 'category_wise' ? ($item->category->name ?? 'Uncategorized') : ($item->user->name ?? 'Unknown') }}</td>
                    <td><span class="badge {{ $item->type === 'income' ? 'badge-success' : 'badge-danger' }}">{{ $item->type }}</span></td>
                    <td class="text-right">{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
