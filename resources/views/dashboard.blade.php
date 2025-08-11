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

            <div style="padding: 20px; font-family: Arial, sans-serif;">
                {{-- Search & Sort --}}
                <div class="search-sort-container">
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <input id="bookSearchInput" type="text" placeholder="Search by book name...">
                        <select id="bookSortSelect">
                            <option value="updated_desc">Sort By : Last Updated</option>
                            <option value="name_asc">Sort By : Name (A-Z)</option>
                            <option value="net_high_low">Sort By : Net Balance (High to Low)</option>
                            <option value="net_low_high">Sort By : Net Balance (Low to High)</option>
                            <option value="created_desc">Sort By : Last Created</option>
                        </select>
                    </div>
                    <a href="{{ route('books.create') }}"
                    style="padding: 8px 16px; background: #2563eb; color: white; text-decoration: none; border-radius: 6px; font-size: 14px; font-weight: bold; text-align: center;">
                        Add New Book
                    </a>
                </div>

                <div class="main-grid">

                    {{-- Left Side (Books List) --}}
                    <div>
                        <div id="booksContainer">
                            @forelse($accessibleBooks as $book)
                                @php
                                    $allTransactions = $book->transactions;
                                    $totalIncome = $allTransactions->where('type', 'income')->sum('amount');
                                    $totalExpense = $allTransactions->where('type', 'expense')->sum('amount');
                                    $netBalance = ($totalIncome ?? 0) - ($totalExpense ?? 0);
                                @endphp
                                <div
                                    class="book-item"
                                    data-name="{{ strtolower($book->name) }}"
                                    data-updated="{{ $book->updated_at->timestamp }}"
                                    data-created="{{ $book->created_at->timestamp }}"
                                    data-netbalance="{{ $netBalance }}"
                                    style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding: 12px 0;">

                                    <a href="{{ route('books.show', $book->id) }}" class="book-item-link">

                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="background: #f3e8ff; color: #7c3aed; border-radius: 50%; padding: 8px; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                                <img src="{{ Storage::url('images/logo.svg') }}" alt="Book Logo" style="width: 24px; height: 24px; object-fit: cover;">
                                            </div>
                                            <div class="book-name">
                                                <p style="margin: 0; font-weight: bold;">{{ $book['name'] }}</p>
                                                <p style="margin: 0; color: gray; font-size: 12px;">Updated {{ $book['updated_at']->diffForHumans() }}</p>
                                            </div>
                                        </div>
                                        <div style="font-weight: bold; color: {{ $netBalance < 0 ? '#dc2626' : '#16a34a' }};">
                                            {{ $book->currency }} {{ $netBalance >= 0 ? '' : '-' }} {{ number_format(abs($netBalance), 0) }}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        @if($accessibleBooks->isEmpty())
                            <div style="text-align: center; padding: 20px; color: gray;">
                                <p>No books available. Click the button above to add your first book.</p>
                                <a href="{{ route('books.create') }}" style="color: #2563eb; text-decoration: none; font-weight: bold; border: 1px solid #2563eb; padding: 8px 16px; border-radius: 6px; display: inline-block; margin-top: 10px;">
                                    Add Your First Book
                                </a>
                            </div>
                        @endif

                        {{-- Quick Add --}}
                        <div style="border: 1px solid #ddd; border-radius: 8px; margin-top: 20px; padding: 16px; background: white;">
                            <h3 style="margin-top: 0; font-weight: bold;">Add New Book</h3>
                            <p style="color: gray; font-size: 13px; margin-bottom: 12px;">Click to quickly add books for</p>
                            <div style="display: flex; flex-wrap: wrap; gap: 10px;">
                                <button style="padding: 6px 14px; border-radius: 20px; border: 1px solid #93c5fd; color: #2563eb; background: white; cursor: pointer;">
                                    August Expenses
                                </button>
                                <button style="padding: 6px 14px; border-radius: 20px; border: 1px solid #93c5fd; color: #2563eb; background: white; cursor: pointer;">
                                    Project Book
                                </button>
                                <button style="padding: 6px 14px; border-radius: 20px; border: 1px solid #93c5fd; color: #2563eb; background: white; cursor: pointer;">
                                    2025 Ledger
                                </button>
                                <button style="padding: 6px 14px; border-radius: 20px; border: 1px solid #93c5fd; color: #2563eb; background: white; cursor: pointer;">
                                    Payable Book
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Right Side (Help Box) --}}
                    <div class="help-box-desktop">
                        <div style="border: 1px solid #ddd; border-radius: 8px; padding: 16px; background: white;">
                            <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px;">
                                <div style="background: #f3f4f6; color: #4b5563; border-radius: 50%; padding: 8px;">
                                    ❓
                                </div>
                                <h3 style="margin: 0; font-weight: bold;">Need Help?</h3>
                            </div>
                            <p style="color: gray; font-size: 13px; margin-bottom: 12px;">
                                If you have any questions or need assistance, our support team is here to help you 24/7.
                            </p>
                            <button style="padding: 8px 16px; border-radius: 6px; border: none; background: #2563eb; color: white; cursor: pointer;">
                                Contact Support
                            </button>
                            <p style="font-size: 12px; color: gray; margin-top: 12px;">
                                Or visit our <a href="#" style="color: #2563eb; text-decoration: none;">Help Center</a> for FAQs and guides.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', () => {
                    const searchInput = document.getElementById('bookSearchInput');
                    const sortSelect = document.getElementById('bookSortSelect');
                    const booksContainer = document.getElementById('booksContainer');
                    let bookItems = Array.from(booksContainer.querySelectorAll('.book-item'));

                    function filterAndSortBooks() {
                        const query = searchInput.value.toLowerCase();
                        const sortBy = sortSelect.value;

                        // Filter items by search query
                        let filtered = bookItems.filter(item => {
                        return item.dataset.name.includes(query);
                        });

                        // Sort filtered items
                        filtered.sort((a, b) => {
                        switch (sortBy) {
                            case 'name_asc':
                            return a.dataset.name.localeCompare(b.dataset.name);
                            case 'net_high_low':
                            return parseFloat(b.dataset.netbalance) - parseFloat(a.dataset.netbalance);
                            case 'net_low_high':
                            return parseFloat(a.dataset.netbalance) - parseFloat(b.dataset.netbalance);
                            case 'created_desc':
                            return parseInt(b.dataset.created) - parseInt(a.dataset.created);
                            case 'updated_desc':
                            default:
                            return parseInt(b.dataset.updated) - parseInt(a.dataset.updated);
                        }
                        });

                        // Clear container and re-append filtered & sorted items
                        booksContainer.innerHTML = '';
                        filtered.forEach(item => booksContainer.appendChild(item));
                    }

                    // Run on input/select change
                    searchInput.addEventListener('input', filterAndSortBooks);
                    sortSelect.addEventListener('change', filterAndSortBooks);

                    // Initial call
                    filterAndSortBooks();
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
