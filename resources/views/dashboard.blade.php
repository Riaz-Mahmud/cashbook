<x-app-layout>
    @if($activeBusiness)
        @if(isset($hasAccess) && !$hasAccess)
            <!-- No Access Message for Staff -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-subtitle">Welcome to {{ $activeBusiness->name }}.</p>
                </div>
            </div>

            <div class="card" style="text-align: center; padding: 3rem; margin-top: 2rem;">
                <svg style="width: 4rem; height: 4rem; color: var(--gray-400); margin: 0 auto 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <h3 style="font-size: 1.125rem; font-weight: 600; color: var(--gray-900); margin-bottom: 0.5rem;">No Books Assigned</h3>
                <p style="font-size: 0.875rem; color: var(--gray-500); margin-bottom: 1.5rem;">
                    You don't have access to any books in this business yet.<br>
                    Contact your business owner or administrator to get access to books so you can view transactions and data.
                </p>
                <p style="font-size: 0.75rem; color: var(--gray-400);">
                    Role: {{ ucfirst($role ?? 'staff') }}
                </p>
            </div>
        @else
            <!-- Page Header -->
            <div class="page-header">
                <div>
                    <h1 class="page-title">Dashboard</h1>
                    <p class="page-subtitle">Welcome back! Here's what's happening with {{ $activeBusiness->name }}.</p>
                </div>
            </div>

        <!-- Stats Cards -->
        <div class="stats-grid">
            <div class="stat-card success">
                <div class="flex items-center mb-3">
                    <div style="width: 32px; height: 32px; background: #dcfce7; border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                        <svg style="width: 20px; height: 20px; color: var(--success-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="stat-label">Total Income</div>
                        <div class="stat-value">{{ $activeBusiness->currency }} {{ number_format(array_sum($incomeSeries), 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card danger">
                <div class="flex items-center mb-3">
                    <div style="width: 32px; height: 32px; background: #fee2e2; border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                        <svg style="width: 20px; height: 20px; color: var(--danger-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="stat-label">Total Expense</div>
                        <div class="stat-value">{{ $activeBusiness->currency }} {{ number_format(array_sum($expenseSeries), 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="flex items-center mb-3">
                    <div style="width: 32px; height: 32px; background: #eff6ff; border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                        <svg style="width: 20px; height: 20px; color: var(--primary-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="stat-label">Net Profit</div>
                        <div class="stat-value">{{ $activeBusiness->currency }} {{ number_format(array_sum($incomeSeries) - array_sum($expenseSeries), 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="stat-card warning">
                <div class="flex items-center mb-3">
                    <div style="width: 32px; height: 32px; background: #fef3c7; border-radius: var(--border-radius); display: flex; align-items: center; justify-content: center; margin-right: 1rem;">
                        <svg style="width: 20px; height: 20px; color: var(--warning-color);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="stat-label">
                            @if(in_array($role ?? '', ['owner', 'admin']))
                                Books
                            @else
                                Accessible Books
                            @endif
                        </div>
                        <div class="stat-value">{{ isset($accessibleBookIds) ? $accessibleBookIds->count() : 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid grid-cols-2" style="margin-top: 2rem;">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Income vs Expense (30 days)</h3>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Spending by Category</h3>
                </div>
                <div class="card-body">
                    <div style="position: relative; height: 300px; width: 100%;">
                        <canvas id="donutChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div style="margin-top: 2rem;">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Transactions</h3>
                </div>
                <div class="card-body" style="padding: 0;">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th style="text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                if (isset($accessibleBookIds) && $accessibleBookIds->isNotEmpty()) {
                                    $recentTransactions = \App\Models\Transaction::where('business_id', $activeBusiness->id)
                                        ->whereIn('book_id', $accessibleBookIds)
                                        ->with(['category', 'book'])
                                        ->orderBy('transaction_date', 'desc')
                                        ->limit(5)
                                        ->get();
                                } else {
                                    $recentTransactions = collect();
                                }
                            @endphp
                            @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->transaction_date->format('M j, Y') }}</td>
                                    <td>{{ $transaction->description ?: 'No description' }}</td>
                                    <td>{{ $transaction->category?->name ?: '—' }}</td>
                                    <td>
                                        <span class="badge {{ $transaction->type === 'income' ? 'badge-success' : 'badge-danger' }}">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    </td>
                                    <td style="text-align: right; font-weight: 600; color: {{ $transaction->type === 'income' ? 'var(--success-color)' : 'var(--danger-color)' }};">
                                        {{ $activeBusiness->currency }} {{ number_format($transaction->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; color: var(--gray-500);">
                                        @if(isset($hasAccess) && !$hasAccess)
                                            No accessible transactions
                                        @else
                                            No transactions yet
                                        @endif
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($recentTransactions->count() > 0)
                    <div class="card-footer">
                        <a href="{{ route('transactions.index') }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">View all transactions →</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Charts Script -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            // Line Chart
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: @json($lineLabels),
                    datasets: [
                        {
                            label: 'Income',
                            data: @json($incomeSeries),
                            borderColor: 'rgb(34, 197, 94)',
                            backgroundColor: 'rgba(34, 197, 94, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Expense',
                            data: @json($expenseSeries),
                            borderColor: 'rgb(239, 68, 68)',
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '{{ $activeBusiness->currency }} ' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': {{ $activeBusiness->currency }} ' + context.parsed.y.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            // Donut Chart
            const donutCtx = document.getElementById('donutChart').getContext('2d');
            new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($categoryLabels),
                    datasets: [{
                        data: @json($categorySeries),
                        backgroundColor: [
                            '#3B82F6', '#EF4444', '#10B981', '#F59E0B', '#8B5CF6',
                            '#06B6D4', '#F97316', '#84CC16', '#EC4899', '#6B7280'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': {{ $activeBusiness->currency }} ' + context.parsed.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        </script>
        @endif
    @else
        <!-- No Business Selected -->
        <div class="card" style="text-align: center; padding: 4rem 2rem; margin-top: 2rem; background: linear-gradient(135deg, var(--gray-50) 0%, white 100%); border: 2px dashed var(--gray-300);">
            <div style="max-width: 400px; margin: 0 auto;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary-color), #3b82f6); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 32px rgba(59, 130, 246, 0.2);">
                    <svg style="width: 40px; height: 40px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>

                <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.75rem; letter-spacing: -0.025em;">
                    No Business Selected
                </h3>

                <p style="font-size: 1rem; color: var(--gray-600); margin-bottom: 2rem; line-height: 1.6;">
                    Choose a business from the dropdown above to view your dashboard and start managing your finances.
                </p>

                <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                    <a href="{{ route('businesses.create') }}"
                       style="display: inline-flex; align-items: center; padding: 0.75rem 2rem; background: linear-gradient(135deg, var(--primary-color), #3b82f6); color: white; text-decoration: none; border-radius: var(--border-radius); font-weight: 600; font-size: 0.875rem; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); transition: all 0.2s ease; border: none;"
                       onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(59, 130, 246, 0.4)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(59, 130, 246, 0.3)'">
                        <svg style="width: 16px; height: 16px; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Your First Business
                    </a>

                    <p style="font-size: 0.75rem; color: var(--gray-400); margin-top: 0.5rem;">
                        Or select an existing business from the dropdown menu
                    </p>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
