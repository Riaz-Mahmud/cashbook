<!-- Inline-styled pagination -->
@if ($notifications->hasPages())
    <div style="display: flex; justify-content: center; gap: 0.5rem; margin-top: 2rem; flex-wrap: wrap;">
        {{-- Previous Page --}}
        @if ($notifications->onFirstPage())
            <span style="padding: 0.5rem 0.75rem; background-color: #e2e8f0; color: #718096; border-radius: 0.375rem;">&laquo; Prev</span>
        @else
            <a href="{{ $notifications->previousPageUrl() }}" style="padding: 0.5rem 0.75rem; background-color: #3182ce; color: white; border-radius: 0.375rem; text-decoration: none;">&laquo; Prev</a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($notifications->getUrlRange(1, $notifications->lastPage()) as $page => $url)
            @if ($page == $notifications->currentPage())
                <span style="padding: 0.5rem 0.75rem; background-color: #2d3748; color: white; border-radius: 0.375rem;">{{ $page }}</span>
            @else
                <a href="{{ $url }}" style="padding: 0.5rem 0.75rem; background-color: #e2e8f0; color: #2d3748; border-radius: 0.375rem; text-decoration: none;">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next Page --}}
        @if ($notifications->hasMorePages())
            <a href="{{ $notifications->nextPageUrl() }}" style="padding: 0.5rem 0.75rem; background-color: #3182ce; color: white; border-radius: 0.375rem; text-decoration: none;">Next &raquo;</a>
        @else
            <span style="padding: 0.5rem 0.75rem; background-color: #e2e8f0; color: #718096; border-radius: 0.375rem;">Next &raquo;</span>
        @endif
    </div>
@endif
