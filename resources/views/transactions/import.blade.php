<x-app-layout>
    <div class="page-header">
        <h1 class="page-title">Bulk Import Transactions</h1>
        <a href="{{ route('books.show', $book) }}" class="btn btn-secondary">Back to Book</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('transactions.import.store', $book) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="csv_file" class="form-label">CSV File</label>
                    <input type="file" name="csv_file" id="csv_file" class="form-input" required>
                    <p class="mt-2 text-sm text-gray-500">
                        Please ensure your CSV file has the following columns in this order:
                        <strong>Date, Time, Remark, Category, Mode, Cash In, Cash Out</strong>.
                    </p>
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit" class="btn btn-primary">Import Transactions</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
