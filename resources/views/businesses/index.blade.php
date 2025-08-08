<x-app-layout>
    <div class="page-header">
        <div>
            <h1 class="page-title">Businesses</h1>
            <p class="page-subtitle">Manage your business entities and switch between them.</p>
        </div>
        <a href="{{ route('businesses.create') }}" class="btn btn-primary">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Business
        </a>
    </div>

    @if($businesses->count() > 0)
        <div class="grid grid-cols-3">
            @foreach($businesses as $business)
                <div class="business-card card {{ auth()->user()->current_business_id == $business->id ? 'active' : '' }}">
                    <div class="card-body">
                        <div class="business-header">
                            <div class="flex items-center">
                                <div class="business-icon">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h3"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="business-name">{{ $business->name }}</h3>
                                    @if(auth()->user()->current_business_id == $business->id)
                                        <span class="badge badge-success">Active</span>
                                    @endif
                                </div>
                            </div>
                            <div class="dropdown" x-data="{ open: false }">
                                <button @click="open = !open" style="padding: 0.5rem; color: var(--gray-400);">
                                    <svg style="width: 20px; height: 20px;" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition class="dropdown-menu">
                                    @if(auth()->user()->current_business_id != $business->id)
                                        <form method="POST" action="{{ route('business.switch', $business) }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                Switch to this business
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('businesses.show', $business) }}" class="dropdown-item">View Details</a>
                                    <a href="{{ route('businesses.edit', $business) }}" class="dropdown-item">Edit</a>
                                    @if($businesses->count() > 1)
                                        <form method="POST" action="{{ route('businesses.destroy', $business) }}" onsubmit="return confirm('Are you sure you want to delete this business?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" style="color: var(--danger-color);">Delete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($business->description)
                            <p class="text-gray-600 text-sm mb-4">{{ $business->description }}</p>
                        @endif

                        <div class="space-y-3">
                            @if($business->tax_number)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Tax ID: {{ $business->tax_number }}
                                </div>
                            @endif

                            @if($business->email)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                    {{ $business->email }}
                                </div>
                            @endif

                            @if($business->phone)
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ $business->phone }}
                                </div>
                            @endif

                            @if($business->address)
                                <div class="flex items-start text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $business->address }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="grid grid-cols-3 gap-4 text-center">
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">{{ $business->books_count ?? 0 }}</div>
                                    <div class="text-xs text-gray-600">Books</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">{{ $business->transactions_count ?? 0 }}</div>
                                    <div class="text-xs text-gray-600">Transactions</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-900">{{ $business->created_at->format('Y') }}</div>
                                    <div class="text-xs text-gray-600">Since</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $businesses->links() }}
        </div>
    @else
        <div class="card" style="text-align: center; padding: 4rem 2rem; margin: 3rem auto 0; max-width: 420px; background: linear-gradient(135deg, var(--gray-50) 0%, white 100%); border: 2px dashed var(--gray-300); box-shadow: 0 4px 24px rgba(59,130,246,0.06);">
            <div style="max-width: 340px; margin: 0 auto;">
                <div style="width: 72px; height: 72px; background: linear-gradient(135deg, var(--primary-color), #3b82f6); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 32px rgba(59, 130, 246, 0.12);">
                    <svg style="width: 36px; height: 36px; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h3" />
                    </svg>
                </div>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.75rem; letter-spacing: -0.01em;">No Businesses Found</h3>
                <p style="font-size: 1rem; color: var(--gray-600); margin-bottom: 2rem; line-height: 1.6;">Get started by creating your first business. You can manage multiple businesses and switch between them anytime.</p>
                <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center;">
                    <a href="{{ route('businesses.create') }}" class="btn btn-primary" style="display: inline-flex; align-items: center; padding: 0.75rem 2rem; font-size: 1rem; font-weight: 600; border-radius: var(--border-radius); box-shadow: 0 4px 12px rgba(59,130,246,0.10);">
                        <svg style="width: 18px; height: 18px; margin-right: 0.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Business
                    </a>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
