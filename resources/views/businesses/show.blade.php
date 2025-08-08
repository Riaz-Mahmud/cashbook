
<x-app-layout>
    <div style="margin-bottom: 2.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 2rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 1.25rem;">
                <a href="{{ route('businesses.index') }}" style="color: var(--gray-400); text-decoration: none; display: flex; align-items: center; transition: color 0.2s;" onmouseover="this.style.color='var(--gray-600)'" onmouseout="this.style.color='var(--gray-400)'">
                    <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin: 0;">{{ $business->name }}</h1>
                    <p style="margin-top: 0.5rem; color: var(--gray-600); margin-bottom: 0;">Business details and information.</p>
                </div>
            </div>
            <div style="display: flex; gap: 0.75rem;">
                @if(auth()->user()->current_business_id != $business->id)
                    <form method="POST" action="{{ route('business.switch', $business) }}">
                        @csrf
                        <button type="submit" class="btn btn-success" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Switch to this Business
                        </button>
                    </form>
                @endif
                <a href="{{ route('businesses.edit', $business) }}" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </div>

    @if(auth()->user()->current_business_id == $business->id)
        <div style="margin-bottom: 2rem;">
            <div style="background: var(--success-bg, #ecfdf5); border: 1px solid var(--success-color, #bbf7d0); border-radius: var(--border-radius); padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                <svg style="width: 1.25rem; height: 1.25rem; color: var(--success-color, #22c55e); flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span style="font-size: 1rem; font-weight: 500; color: var(--success-color, #15803d);">This is your currently active business</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Business Information -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Business Information</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Business Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $business->name }}</dd>
                        </div>

                        @if($business->description)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $business->description }}</dd>
                            </div>
                        @endif

                        @if($business->tax_number)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tax ID/Registration Number</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $business->tax_number }}</dd>
                            </div>
                        @endif

                        @if($business->currency)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Default Currency</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $business->currency }}</dd>
                            </div>
                        @endif

                        @if($business->email)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Email</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="mailto:{{ $business->email }}" class="text-indigo-600 hover:text-indigo-500">{{ $business->email }}</a>
                                </dd>
                            </div>
                        @endif

                        @if($business->phone)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Phone</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="tel:{{ $business->phone }}" class="text-indigo-600 hover:text-indigo-500">{{ $business->phone }}</a>
                                </dd>
                            </div>
                        @endif

                        @if($business->website)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Website</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="{{ $business->website }}" target="_blank" class="text-indigo-600 hover:text-indigo-500">{{ $business->website }}</a>
                                </dd>
                            </div>
                        @endif

                        @if($business->address || $business->city || $business->state || $business->postal_code || $business->country)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Address</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($business->address)
                                        {{ $business->address }}<br>
                                    @endif
                                    @if($business->city || $business->state || $business->postal_code)
                                        {{ $business->city }}@if($business->city && ($business->state || $business->postal_code)), @endif{{ $business->state }} {{ $business->postal_code }}<br>
                                    @endif
                                    @if($business->country)
                                        {{ $business->country }}
                                    @endif
                                </dd>
                            </div>
                        @endif

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $business->created_at->format('F j, Y') }}</dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $business->updated_at->format('F j, Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Statistics & Quick Actions -->
        <div class="space-y-6">
            <!-- Statistics -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Statistics</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Books</span>
                            <span class="text-sm font-medium text-gray-900">{{ $business->books_count ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Transactions</span>
                            <span class="text-sm font-medium text-gray-900">{{ $business->transactions_count ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Categories</span>
                            <span class="text-sm font-medium text-gray-900">{{ $business->categories_count ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Quick Actions</h3>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('books.index') }}" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        View Books
                    </a>
                    <a href="{{ route('transactions.index') }}" class="block w-full text-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        View Transactions
                    </a>
                    <a href="{{ route('books.create') }}" class="block w-full text-center px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium hover:bg-indigo-700">
                        Create New Book
                    </a>
                </div>
            </div>

            <!-- Danger Zone -->
            @if($businesses_count > 1)
                <div class="bg-white shadow rounded-lg border border-red-200">
                    <div class="px-6 py-4 border-b border-red-200">
                        <h3 class="text-lg font-medium text-red-900">Danger Zone</h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-red-600 mb-4">Once you delete a business, there is no going back. Please be certain.</p>
                        <form method="POST" action="{{ route('businesses.destroy', $business) }}" onsubmit="return confirm('Are you sure you want to delete this business? This action cannot be undone and will delete all associated books and transactions.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Delete Business
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
