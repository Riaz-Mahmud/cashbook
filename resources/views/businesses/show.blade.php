<x-app-layout>
    <div style="margin-bottom: 2.5rem;">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 2rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 1.25rem;">
                <a href="{{ route('businesses.index') }}" style="color: var(--gray-400); text-decoration: none; display: flex; align-items: center; transition: color 0.2s;"
                    onmouseover="this.style.color='var(--gray-600)'" onmouseout="this.style.color='var(--gray-400)'">
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
                        <button type="submit" style="display: inline-flex; align-items: center; gap: 0.5rem; background-color: #22c55e; border: none; padding: 0.375rem 0.75rem; border-radius: 0.375rem; color: white; font-weight: 600; cursor: pointer;">
                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                            Switch to this Business
                        </button>
                    </form>
                @endif
                <a href="{{ route('businesses.edit', $business) }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background-color: #4f46e5; padding: 0.375rem 0.75rem; border-radius: 0.375rem; color: white; font-weight: 600; text-decoration: none; cursor: pointer;">
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
            <div style="background-color: #ecfdf5; border: 1px solid #bbf7d0; border-radius: 0.375rem; padding: 1.25rem; display: flex; align-items: center; gap: 1rem;">
                <svg style="width: 1.25rem; height: 1.25rem; color: #22c55e; flex-shrink: 0;" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span style="font-size: 1rem; font-weight: 500; color: #15803d;">This is your currently active business</span>
            </div>
        </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr; gap: 2rem;">

        <div style="grid-column: span 1;">
            <div style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 0.5rem;">
                <div style="padding: 1.5rem 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827;">Business Information</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <dl style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem;">
                        <div>
                            <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Business Name</dt>
                            <dd style="margin-top: 0.25rem; font-size: 0.875rem; color: #111827;">{{ $business->name }}</dd>
                        </div>

                        @if($business->description)
                            <div style="grid-column: span 2;">
                                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Description</dt>
                                <dd style="margin-top: 0.25rem; font-size: 0.875rem; color: #111827;">{{ $business->description }}</dd>
                            </div>
                        @endif

                        @if($business->tax_number)
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Tax ID/Registration Number</dt>
                                <dd style="margin-top: 0.25rem; font-size: 0.875rem; color: #111827;">{{ $business->tax_number }}</dd>
                            </div>
                        @endif

                        @if($business->currency)
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Default Currency</dt>
                                <dd style="margin-top: 0.25rem; font-size: 0.875rem; color: #111827;">{{ $business->currency }}</dd>
                            </div>
                        @endif

                        @if($business->email)
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Email</dt>
                                <dd style="margin-top: 0.25rem; font-size: 0.875rem;">
                                    <a href="mailto:{{ $business->email }}" style="color: #4f46e5; text-decoration: underline;">{{ $business->email }}</a>
                                </dd>
                            </div>
                        @endif

                        @if($business->phone)
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Phone</dt>
                                <dd style="margin-top: 0.25rem; font-size: 0.875rem;">
                                    <a href="tel:{{ $business->phone }}" style="color: #4f46e5; text-decoration: underline;">{{ $business->phone }}</a>
                                </dd>
                            </div>
                        @endif

                        @if($business->website)
                            <div>
                                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Website</dt>
                                <dd style="margin-top: 0.25rem; font-size: 0.875rem;">
                                    <a href="{{ $business->website }}" target="_blank" style="color: #4f46e5; text-decoration: underline;">{{ $business->website }}</a>
                                </dd>
                            </div>
                        @endif

                        @if($business->address || $business->city || $business->state || $business->postal_code || $business->country)
                            <div style="grid-column: span 2;">
                                <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Address</dt>
                                <dd style="margin-top: 0.25rem; font-size: 0.875rem; color: #111827; white-space: pre-line;">
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
                            <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Created</dt>
                            <dd style="margin-top: 0.25rem; font-size: 0.875rem; color: #111827;">{{ $business->created_at->format('F j, Y') }}</dd>
                        </div>

                        <div>
                            <dt style="font-size: 0.875rem; font-weight: 500; color: #6b7280;">Last Updated</dt>
                            <dd style="margin-top: 0.25rem; font-size: 0.875rem; color: #111827;">{{ $business->updated_at->format('F j, Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 0.5rem;">
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827;">Statistics</h3>
                </div>
                <div style="padding: 1.5rem;">
                    <div style="display: flex; flex-direction: column; gap: 1rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="font-size: 0.875rem; color: #6b7280;">Books</span>
                            <span style="font-size: 0.875rem; font-weight: 600; color: #111827;">{{ count($business->books) ?? 0 }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="font-size: 0.875rem; color: #6b7280;">Transactions</span>
                            <span style="font-size: 0.875rem; font-weight: 600; color: #111827;">{{ count($business->transactions) ?? 0 }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="font-size: 0.875rem; color: #6b7280;">Categories</span>
                            <span style="font-size: 0.875rem; font-weight: 600; color: #111827;">{{ count($business->categories) ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 0.5rem;">
                <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #111827;">Quick Actions</h3>
                </div>
                <div style="padding: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                    <a href="{{ route('books.index') }}" style="display: block; width: 100%; text-align: center; padding: 0.5rem 1rem; border: 1px solid #d1d5db; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; color: #374151; text-decoration: none; background-color: white; cursor: pointer;">
                        View Books
                    </a>
                    <a href="{{ route('books.create') }}" style="display: block; width: 100%; text-align: center; padding: 0.5rem 1rem; background-color: #4f46e5; color: white; border-radius: 0.375rem; font-size: 0.875rem; font-weight: 500; text-decoration: none; cursor: pointer;">
                        Create New Book
                    </a>
                </div>
            </div>

            @if($businesses_count > 1)
                <div style="background: white; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border-radius: 0.5rem; border: 1px solid #fecaca;">
                    <div style="padding: 1.5rem; border-bottom: 1px solid #fecaca;">
                        <h3 style="font-size: 1.125rem; font-weight: 600; color: #b91c1c;">Danger Zone</h3>
                    </div>
                    <div style="padding: 1.5rem;">
                        <p style="font-size: 0.875rem; color: #b91c1c; margin-bottom: 1rem;">
                            Once you delete a business, there is no going back. Please be certain.
                        </p>
                        <form method="POST" action="{{ route('businesses.destroy', $business) }}" onsubmit="return confirm('Are you sure you want to delete this business? This action cannot be undone and will delete all associated books and transactions.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #dc2626; border: none; border-radius: 0.375rem; font-weight: 700; font-size: 0.75rem; color: white; text-transform: uppercase; letter-spacing: 0.05em; cursor: pointer;">
                                Delete Business
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
