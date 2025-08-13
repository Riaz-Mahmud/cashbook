<x-app-layout>
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-bottom: 2rem; gap: 1rem;">
        <div style="flex: 1 1 250px;">
            <h1 style="font-size: 2rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem;">Businesses</h1>
            <p style="font-size: 1rem; color: #6b7280; margin: 0;">Manage your business entities and switch between them.</p>
        </div>
        <a href="{{ route('businesses.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background-color: #4f46e5; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; font-weight: 600; font-size: 0.875rem; text-decoration: none; cursor: pointer; white-space: nowrap;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Business
        </a>
    </div>

    @if($businesses->count() > 0)
        <div style="display: flex; flex-wrap: wrap; gap: 1.5rem;">
            @foreach($businesses as $business)
                <div style="flex: 1 1 calc(33.333% - 1rem); min-width: 280px; background: white; border-radius: 0.5rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); border: 2px solid {{ auth()->user()->current_business_id == $business->id ? '#4f46e5' : 'transparent' }}; box-sizing: border-box;">
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                            <div style="display: flex; align-items: center; gap: 1rem; flex-wrap: wrap;">
                                <div style="color: #4f46e5; flex-shrink: 0;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 36px; height: 36px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h3"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 style="font-weight: 700; font-size: 1.25rem; color: #111827; margin: 0 0 0.25rem;">{{ $business->name }}</h3>
                                    @if(Session::get('active_business_id') == $business->id)
                                        <span style="display: inline-block; background-color: #10b981; color: white; font-size: 0.75rem; font-weight: 600; padding: 0.125rem 0.5rem; border-radius: 0.25rem; letter-spacing: 0.05em;">Active</span>
                                    @endif
                                </div>
                            </div>
                            <div style="position: relative;" x-data="{ open: false }">
                                <button @click="open = !open" type="button" style="background: transparent; border: none; padding: 0.25rem; color: #9ca3af; cursor: pointer;">
                                    <svg fill="currentColor" viewBox="0 0 20 20" style="width: 20px; height: 20px;">
                                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition style="position: absolute; right: 0; top: 100%; background: white; border: 1px solid #e5e7eb; border-radius: 0.375rem; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1); z-index: 10; width: 200px; padding: 0.5rem 0; display: none;" x-bind:style="{display: open ? 'block' : 'none'}">
                                    @if(auth()->user()->current_business_id != $business->id)
                                        <form method="POST" action="{{ route('business.switch', $business) }}">
                                            @csrf
                                            <button type="submit" style="width: 100%; text-align: left; padding: 0.5rem 1rem; background: transparent; border: none; font-size: 0.875rem; color: #374151; cursor: pointer; hover:background-color:#f3f4f6;">
                                                Switch to this business
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('businesses.show', $business) }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #374151; text-decoration: none; cursor: pointer;">View Details</a>
                                    <a href="{{ route('businesses.edit', $business) }}" style="display: block; padding: 0.5rem 1rem; font-size: 0.875rem; color: #374151; text-decoration: none; cursor: pointer;">Edit</a>
                                    @if($businesses->count() > 1)
                                        <form method="POST" action="{{ route('businesses.destroy', $business) }}" onsubmit="return confirm('Are you sure you want to delete this business?')" style="margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="width: 100%; text-align: left; padding: 0.5rem 1rem; background: transparent; border: none; font-size: 0.875rem; color: #b91c1c; cursor: pointer;">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>

                        @if($business->description)
                            <p style="color: #4b5563; font-size: 0.875rem; margin-bottom: 1rem;">{{ $business->description }}</p>
                        @endif

                        <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem; color: #4b5563; font-size: 0.875rem;">
                            @if($business->tax_number)
                                <div style="display: flex; align-items: center;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px; margin-right: 0.5rem;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Tax ID: {{ $business->tax_number }}
                                </div>
                            @endif
                            @if($business->email)
                                <div style="display: flex; align-items: center;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px; margin-right: 0.5rem;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                                    </svg>
                                    {{ $business->email }}
                                </div>
                            @endif
                            @if($business->phone)
                                <div style="display: flex; align-items: center;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px; margin-right: 0.5rem;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    {{ $business->phone }}
                                </div>
                            @endif
                            @if($business->address)
                                <div style="display: flex; align-items: flex-start;">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px; margin-right: 0.5rem; margin-top: 2px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ $business->address }}</span>
                                </div>
                            @endif
                        </div>

                        <div style="padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                            <div style="display: flex; justify-content: space-around; text-align: center; color: #4b5563;">
                                <div>
                                    <div style="font-size: 1.5rem; font-weight: 700; color: #111827;">{{ count($business->books) ?? 0 }}</div>
                                    <div style="font-size: 0.75rem;">Books</div>
                                </div>
                                <div>
                                    <div style="font-size: 1.5rem; font-weight: 700; color: #111827;">{{ count($business->transactions) ?? 0 }}</div>
                                    <div style="font-size: 0.75rem;">Transactions</div>
                                </div>
                                <div>
                                    <div style="font-size: 1.5rem; font-weight: 700; color: #111827;">{{ $business->created_at->format('Y') }}</div>
                                    <div style="font-size: 0.75rem;">Since</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div style="margin-top: 2rem;">
            {{ $businesses->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem 2rem; margin: 3rem auto 0; max-width: 420px; background: linear-gradient(135deg, #f9fafb 0%, white 100%); border: 2px dashed #d1d5db; box-shadow: 0 4px 24px rgba(59,130,246,0.06); border-radius: 0.5rem;">
            <div style="max-width: 340px; margin: 0 auto;">
                <div style="width: 72px; height: 72px; background: linear-gradient(135deg, #4f46e5, #3b82f6); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 32px rgba(59, 130, 246, 0.12);">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 36px; height: 36px; color: white;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h3"></path>
                    </svg>
                </div>
                <h2 style="font-weight: 700; font-size: 1.5rem; color: #374151; margin: 0 0 0.75rem;">You have no businesses yet.</h2>
                <p style="font-size: 1rem; color: #6b7280; margin: 0 0 1.5rem;">Get started by creating your first business entity.</p>
                <a href="{{ route('businesses.create') }}" style="display: inline-block; background-color: #4f46e5; color: white; padding: 0.75rem 1.5rem; font-weight: 600; border-radius: 0.375rem; font-size: 1rem; text-decoration: none; cursor: pointer;">
                    Create Business
                </a>
            </div>
        </div>
    @endif
</x-app-layout>
