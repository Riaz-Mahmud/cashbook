<x-app-layout>
    <div class="page-header">
        <h1 class="page-title">Reports for {{ $book->name }}</h1>
        <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">Back to Book</a>
    </div>

    <div class="card">
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
                    <button type="submit" class="btn btn-primary">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <div id="report-results" class="mt-8" style="display: none;">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-semibold" id="report-title"></h3>
                <!-- Download Buttons -->
                <div id="download-buttons" style="display: none;">
                    <a href="#" id="download-csv" class="btn btn-sm btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        CSV
                    </a>
                    <a href="#" id="download-pdf" class="btn btn-sm btn-danger ml-2">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        PDF
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="report-content"></div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('report-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const resultsContainer = document.getElementById('report-results');
            const contentContainer = document.getElementById('report-content');
            const titleContainer = document.getElementById('report-title');
            const downloadContainer = document.getElementById('download-buttons');

            resultsContainer.style.display = 'block';
            contentContainer.innerHTML = '<p>Loading report...</p>';
            downloadContainer.style.display = 'none';

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
                if (data.success) {
                    titleContainer.textContent = formData.get('report_type').replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    renderReport(data.data, formData.get('report_type'));
                    updateDownloadLinks();
                    downloadContainer.style.display = 'flex';
                } else {
                    contentContainer.innerHTML = '<p class="text-red-600">Error generating report.</p>';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                contentContainer.innerHTML = '<p class="text-red-600">An unexpected error occurred.</p>';
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

            switch (type) {
                case 'summary':
                    const netBalance = data.total_income - data.total_expense;
                    html = `
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div class="p-4 bg-green-100 rounded-lg text-center">
                                <p class="text-sm text-green-700">Total Income</p>
                                <p class="text-2xl font-bold text-green-900">${formatCurrency(data.total_income)}</p>
                            </div>
                            <div class="p-4 bg-red-100 rounded-lg text-center">
                                <p class="text-sm text-red-700">Total Expense</p>
                                <p class="text-2xl font-bold text-red-900">${formatCurrency(data.total_expense)}</p>
                            </div>
                            <div class="p-4 bg-blue-100 rounded-lg text-center">
                                <p class="text-sm text-blue-700">Net Balance</p>
                                <p class="text-2xl font-bold text-blue-900">${formatCurrency(netBalance)}</p>
                            </div>
                        </div>
                        <h4 class="font-semibold mt-6 mb-2">Transactions</h4>
                        <table class="table w-full">
                            <thead><tr><th>Date</th><th>Description</th><th>Type</th><th class="text-right">Amount</th></tr></thead>
                            <tbody>
                                ${data.transactions.map(t => `
                                    <tr>
                                        <td>${new Date(t.transaction_date).toLocaleDateString()}</td>
                                        <td>${t.description || 'N/A'}</td>
                                        <td><span class="badge ${t.type === 'income' ? 'badge-success' : 'badge-danger'}">${t.type}</span></td>
                                        <td class="text-right">${formatCurrency(t.amount)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                    break;
                case 'category_wise':
                case 'member_wise':
                    const isCategory = type === 'category_wise';
                    html = `
                        <table class="table w-full">
                            <thead><tr><th>${isCategory ? 'Category' : 'Member'}</th><th>Type</th><th class="text-right">Total Amount</th></tr></thead>
                            <tbody>
                                ${data.map(item => `
                                    <tr>
                                        <td>${isCategory ? (item.category ? item.category.name : 'Uncategorized') : (item.user ? item.user.name : 'Unknown')}</td>
                                        <td><span class="badge ${item.type === 'income' ? 'badge-success' : 'badge-danger'}">${item.type}</span></td>
                                        <td class="text-right">${formatCurrency(item.total)}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    `;
                    break;
            }
            contentContainer.innerHTML = html;
        }

        function formatCurrency(amount) {
            return '{{ $book->currency }} ' + parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
        }
    </script>
</x-app-layout>
