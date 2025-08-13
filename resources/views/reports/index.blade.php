<x-app-layout>
    <div class="page-header flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold">Reports for {{ $book->name }}</h1>
        <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">Back to Book</a>
    </div>

    <!-- Report Filter Form -->
    <div class="card mb-6">
        <div class="card-body">
            <form id="report-form" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
                <div class="form-group">
                    <label for="report_type" class="form-label">Report Type</label>
                    <select id="report_type" name="report_type" class="form-select">
                        <option value="summary">Transaction Summary</option>
                        <option value="category_wise">Category-wise Report</option>
                        <option value="member_wise">Member-wise Report</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" id="start_date" name="start_date" class="form-input">
                </div>
                <div class="form-group">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" id="end_date" name="end_date" class="form-input">
                </div>
                <div class="md:col-span-3 flex justify-end">
                    <button type="submit" class="btn btn-primary flex items-center">
                        <svg id="spinner" class="w-4 h-4 mr-2 animate-spin hidden" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Report Results -->
    <div id="report-results" class="mt-8 hidden">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-semibold" id="report-title"></h3>
                <div id="download-buttons" class="flex space-x-2 hidden">
                    <a href="#" id="download-csv" class="btn btn-sm btn-secondary" title="Download CSV">CSV</a>
                    <a href="#" id="download-pdf" class="btn btn-sm btn-danger" title="Download PDF">PDF</a>
                </div>
            </div>
            <div class="card-body overflow-x-auto">
                <div id="report-content"></div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('report-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const spinner = document.getElementById('spinner');
            spinner.classList.remove('hidden');

            const formData = new FormData(this);
            const resultsContainer = document.getElementById('report-results');
            const contentContainer = document.getElementById('report-content');
            const titleContainer = document.getElementById('report-title');
            const downloadContainer = document.getElementById('download-buttons');

            resultsContainer.classList.remove('hidden');
            contentContainer.innerHTML = '<p>Loading report...</p>';
            downloadContainer.classList.add('hidden');

            fetch('{{ route("reports.generate", $book) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: new URLSearchParams(formData)
            })
            .then(response => response.json())
            .then(data => {
                spinner.classList.add('hidden');

                if (data.success) {
                    titleContainer.textContent = formData.get('report_type').replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    renderReport(data.data, formData.get('report_type'));
                    updateDownloadLinks();
                    downloadContainer.classList.remove('hidden');
                } else {
                    contentContainer.innerHTML = '<div class="bg-red-100 text-red-800 p-4 rounded">Error generating report.</div>';
                }
            })
            .catch(error => {
                spinner.classList.add('hidden');
                console.error(error);
                contentContainer.innerHTML = '<div class="bg-red-100 text-red-800 p-4 rounded">An unexpected error occurred.</div>';
            });
        });

        function updateDownloadLinks() {
            const form = document.getElementById('report-form');
            const formData = new FormData(form);
            const params = new URLSearchParams(formData).toString();

            document.getElementById('download-csv').href = `{{ route('reports.download', $book) }}?format=csv&${params}`;
            document.getElementById('download-pdf').href = `{{ route('reports.download', $book) }}?format=pdf&${params}`;
        }

        function renderReport(data, type) {
            const contentContainer = document.getElementById('report-content');
            let html = '';
            let previousBalance = 0;

            const bookCurrency = "{{ $book->currency }}";
            const formatCurrency = amount => new Intl.NumberFormat('en-US', { style: 'currency', currency: bookCurrency }).format(amount);

            switch (type) {
                case 'summary':
                    const netBalance = data.total_income - data.total_expense;

                    // Summary Cards
                    html += `
                    <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem; margin-bottom: 1.5rem;
                        @media (min-width: 768px) { grid-template-columns: repeat(3, 1fr); }">
                        <div style="padding: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-align: center; transition: box-shadow 0.3s;"
                            onmouseover="this.style.boxShadow='0 4px 6px rgba(0,0,0,0.15)';"
                            onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)';">
                            <p style="font-size: 0.875rem; color: #4B5563; margin-bottom: 0.5rem;">Total Cash In</p>
                            <p style="font-size: 1.5rem; font-weight: bold; color: #047857;">${formatCurrency(data.total_income)}</p>
                        </div>
                        <div style="padding: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-align: center; transition: box-shadow 0.3s;"
                            onmouseover="this.style.boxShadow='0 4px 6px rgba(0,0,0,0.15)';"
                            onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)';">
                            <p style="font-size: 0.875rem; color: #4B5563; margin-bottom: 0.5rem;">Total Cash Out</p>
                            <p style="font-size: 1.5rem; font-weight: bold; color: #B91C1C;">${formatCurrency(data.total_expense)}</p>
                        </div>
                        <div style="padding: 1rem; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-align: center; transition: box-shadow 0.3s;"
                            onmouseover="this.style.boxShadow='0 4px 6px rgba(0,0,0,0.15)';"
                            onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)';">
                            <p style="font-size: 0.875rem; color: #4B5563; margin-bottom: 0.5rem;">Net Balance</p>
                            <p style="font-size: 1.5rem; font-weight: bold; color: #1D4ED8;">${formatCurrency(netBalance)}</p>
                        </div>
                    </div>`;

                    // Transactions Table
                    html += `
                    <div style="width: 100%; overflow-x: auto;">
                        <table class="table" style="width: 100%; border-collapse: collapse; min-width: 800px;">
                            <thead class="bg-gray-100 sticky top-0">
                                <tr>
                                    <th class="px-2 py-1 border">Date</th>
                                    <th class="px-2 py-1 border">Description</th>
                                    <th class="px-2 py-1 border">Category</th>
                                    <th class="px-2 py-1 border">Mode</th>
                                    <th class="px-2 py-1 border">Member</th>
                                    <th class="px-2 py-1 border">Type</th>
                                    <th class="px-2 py-1 border text-right">Cash In</th>
                                    <th class="px-2 py-1 border text-right">Cash Out</th>
                                    <th class="px-2 py-1 border text-right">Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.transactions.map(t => {
                                    const amount = parseFloat(t.amount);
                                    const balance = t.type === 'income' ? previousBalance + amount : previousBalance - amount;
                                    previousBalance = balance;
                                    return `
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-2 py-1 border">${new Date(t.transaction_date).toLocaleString()}</td>
                                        <td class="px-2 py-1 border">${t.description || '-'}</td>
                                        <td class="px-2 py-1 border">${t.category ? t.category.name : '-'}</td>
                                        <td class="px-2 py-1 border">${t.mode || '-'}</td>
                                        <td class="px-2 py-1 border">${t.user ? t.user.name : '-'}</td>
                                        <td class="px-2 py-1 border">
                                            <span class="badge ${t.type === 'income' ? 'badge-success' : 'badge-danger'}">
                                                ${t.type === 'income' ? 'Income' : 'Expense'}
                                            </span>
                                        </td>
                                        <td class="px-2 py-1 border text-right">${t.type === 'income' ? formatCurrency(amount) : ''}</td>
                                        <td class="px-2 py-1 border text-right">${t.type === 'expense' ? formatCurrency(amount) : ''}</td>
                                        <td class="px-2 py-1 border text-right">${formatCurrency(balance)}</td>
                                    </tr>`;
                                }).join('')}
                            </tbody>
                            <tfoot class="bg-gray-100 font-semibold">
                                <tr>
                                    <th colspan="6" class="text-right px-2 py-1 border">Total</th>
                                    <th class="text-right px-2 py-1 border">${formatCurrency(data.total_income)}</th>
                                    <th class="text-right px-2 py-1 border">${formatCurrency(data.total_expense)}</th>
                                    <th class="text-right px-2 py-1 border">${formatCurrency(netBalance)}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>`;
                    break;

                case 'category_wise':
                case 'member_wise':
                    const isCategory = type === 'category_wise';
                    html += `
                    <div class="overflow-x-auto">
                        <table class="table w-full border-collapse">
                            <thead class="bg-gray-100 sticky top-0">
                                <tr>
                                    <th class="px-2 py-1 border">${isCategory ? 'Category' : 'Member'}</th>
                                    <th class="px-2 py-1 border">Type</th>
                                    <th class="px-2 py-1 border text-right">Total Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${data.map(item => `
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-2 py-1 border">${isCategory ? (item.category ? item.category.name : 'Uncategorized') : (item.user ? item.user.name : 'Unknown')}</td>
                                        <td class="px-2 py-1 border">
                                            <span class="badge ${item.type === 'income' ? 'badge-success' : 'badge-danger'}">
                                                ${item.type === 'income' ? 'Income' : 'Expense'}
                                            </span>
                                        </td>
                                        <td class="px-2 py-1 border text-right">${formatCurrency(item.total)}</td>
                                    </tr>`).join('')}
                            </tbody>
                        </table>
                    </div>`;
                    break;
            }

            contentContainer.innerHTML = html;
        }
    </script>
</x-app-layout>
