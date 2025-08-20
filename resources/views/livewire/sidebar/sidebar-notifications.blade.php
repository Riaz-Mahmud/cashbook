<div wire:poll.10s>
    <a href="{{ route('notifications.index') }}"
    class="nav-link {{ Route::is('notifications.index') ? 'active' : '' }}"
    style="border: 1px solid var(--gray-200); border-radius: 6px; padding: 0.5rem 1rem; display: flex; align-items: center; gap: 0.5rem; position: relative;">
        <!-- Bell Icon -->
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" width="24" height="24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 22a2 2 0 002-2H10a2 2 0 002 2zm6-6V8a6 6 0 10-12 0v8l-2 2v1h16v-1l-2-2z"/>
        </svg>
        <span>Notifications</span>

        @if($unreadCount > 0)
            <span style="background: red; color: white; font-size: 0.75rem; border-radius: 9999px;
                        padding: 0 6px; margin-left: auto;">
                {{ $unreadCount }}
            </span>
        @endif
    </a>

</div>
