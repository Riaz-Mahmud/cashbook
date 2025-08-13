<!DOCTYPE html>
<html>
<head>
    <title>Report</title>
    <style>
        @font-face {
            font-family: 'Nikosh';
            src: url("{{ storage_path('fonts/Nikosh.ttf') }}") format("truetype");
        }
        body {
            font-family: 'Nikosh', sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #111;
        }
        h1, h2, h3 {
            text-align: center;
            margin-bottom: 5px;
        }
        h3 { margin-top: 20px; }

        .summary-box {
            border: 1px solid #ddd;
            padding: 10px 15px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
            display: flex;
            justify-content: space-around;
        }
        .summary-box div {
            font-size: 14px;
            font-weight: bold;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 6px 8px;
            word-wrap: break-word;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: left;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .table tbody tr:nth-child(even) { background-color: #fcfcfc; }
        .table tbody tr:hover { background-color: #f1f7ff; }

        .text-right { text-align: right; }
        .badge {
            padding: 3px 7px;
            border-radius: 4px;
            color: white;
            font-size: 11px;
            font-weight: bold;
            box-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        .badge-success { background-color: #059669; }
        .badge-danger { background-color: #dc2626; }

        tfoot th {
            background-color: #e5e7eb;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1 style="font-family: 'Nikosh';">{{ $book->name }}</h1>
    <h2>{{ ucwords(str_replace('_', ' ', $report_type)) }} Report</h2>

    @if($report_type === 'summary')
        <div class="summary-box">
            <div>Cash In: {{ $book->currency }} {{ number_format($data['total_income'], 2) }}</div>
            <div>Cash Out: {{ $book->currency }} {{ number_format($data['total_expense'], 2) }}</div>
            <div>Net Balance: {{ $book->currency }} {{ number_format($data['total_income'] - $data['total_expense'], 2) }}</div>
        </div>

        <h3>Transactions</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Mode</th>
                    <th>Member</th>
                    <th>Type</th>
                    <th class="text-right">Cash In</th>
                    <th class="text-right">Cash Out</th>
                    <th class="text-right">Balance</th>
                </tr>
            </thead>
            <tbody>
                @php $previousBalance = 0; @endphp
                @foreach($data['transactions'] as $t)
                @php
                    $amount = (float)$t->amount;
                    $balance = $t->type === 'income' ? $previousBalance + $amount : $previousBalance - $amount;
                    $previousBalance = $balance;
                @endphp
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->transaction_date)->format('Y-m-d H:i:s') }}</td>
                    <td>{{ $t->description ?? '-' }}</td>
                    <td>{{ $t->category->name ?? '-' }}</td>
                    <td>{{ $t->mode }}</td>
                    <td>{{ $t->user->name ?? '-' }}</td>
                    <td>
                        <span class="badge {{ $t->type === 'income' ? 'badge-success' : 'badge-danger' }}">
                            {{ $t->type === 'income' ? 'Income' : 'Expense' }}
                        </span>
                    </td>
                    <td class="text-right">{{ $t->type === 'income' ? number_format($amount, 2) : '' }}</td>
                    <td class="text-right">{{ $t->type === 'expense' ? number_format($amount, 2) : '' }}</td>
                    <td class="text-right">{{ number_format($balance, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="6" class="text-right">Total ({{ $book->currency }})</th>
                    <th class="text-right">{{ number_format($data['total_income'], 2) }}</th>
                    <th class="text-right">{{ number_format($data['total_expense'], 2) }}</th>
                    <th class="text-right">{{ number_format($data['total_income'] - $data['total_expense'], 2) }}</th>
                </tr>
            </tfoot>
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
                    <td>
                        <span class="badge {{ $item->type === 'income' ? 'badge-success' : 'badge-danger' }}">
                            {{ $item->type === 'income' ? 'Income' : 'Expense' }}
                        </span>
                    </td>
                    <td class="text-right">{{ number_format($item->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>

