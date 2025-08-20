<x-app-layout>
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: #1a202c; margin-bottom: 0.5rem;">Notifications</h1>
        <p style="color: #718096; font-size: 1rem; margin-top: 0.5rem;">Here is a list of all your notifications.</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 1rem; max-width: 800px; margin: 0 auto;">
        @forelse($notifications as $notification)
            <div style="
                background-color: #f7fafc;
                padding: 1rem;
                border-radius: 0.5rem;
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                box-shadow: 0 2px 6px rgba(0,0,0,0.1);
                transition: transform 0.2s, box-shadow 0.2s;
            "
            onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)';"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 6px rgba(0,0,0,0.1)';">
                <div>
                    <p style="font-weight: 600; color: #2d3748; margin-bottom: 0.25rem; font-size: 1rem;">
                        {{ $notification->data['title'] }}
                    </p>
                    <p style="color: #4a5568; font-size: 0.875rem; margin-bottom: 0.25rem;">
                        {{ $notification->data['message'] }}
                    </p>
                    <p style="color: #a0aec0; font-size: 0.75rem;">
                        {{ $notification->data['timestamp'] }}
                    </p>
                </div>
                <a href="{{ $notification->data['link'] }}" style="
                    margin-top: 0.5rem;
                    background-color: #3182ce;
                    color: white;
                    padding: 0.5rem 1rem;
                    border-radius: 0.375rem;
                    font-size: 0.875rem;
                    text-align: center;
                    text-decoration: none;
                    display: inline-block;
                    width: fit-content;
                ">
                    View
                </a>
            </div>
        @empty
            <p style="color: #718096; text-align: center; font-size: 1rem;">You have no notifications.</p>
        @endforelse
    </div>

    <!-- Pagination -->

    {{ $notifications->links('vendor.pagination.custom', ['notifications' => $notifications]) }}


    <!-- Responsive adjustments -->
    <style>
        @media (min-width: 640px) {
            div[style*="flex-direction: column; gap: 1rem;"] > div {
                flex-direction: row !important;
                justify-content: space-between !important;
                align-items: center !important;
            }
            div[style*="flex-direction: column; gap: 1rem;"] > div > a {
                margin-top: 0 !important;
            }
        }
    </style>
</x-app-layout>
