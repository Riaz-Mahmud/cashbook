<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CashBook') }}</title>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Custom CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- jQuery and DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <style>
            body.app-layout {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                margin: 0;
            }
            .app-main {
                flex: 1 0 auto; /* grow and take available space */
            }
            .app-footer {
                flex-shrink: 0;
                background-color: var(--gray-100);
                border-top: 1px solid var(--gray-300);
                padding: 1rem 2rem;
                font-size: 0.875rem;
                color: var(--gray-600);
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
        </style>
    </head>
    <body class="app-layout" x-data="{ sidebarOpen: false }">
        <!-- Top Navigation -->
        <header class="app-header">
            <div class="header-content">
                <!-- Mobile Sidebar Toggle Button -->
                <button class="mobile-sidebar-toggle" @click="sidebarOpen = true">
                    ⋮
                </button>
                <!-- Left: Logo -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="app-logo-link">
                        <img src="{{ Storage::url('images/logo.svg') }}" alt="CashBook Logo" class="app-logo-icon">
                        <span class="app-logo-text">CashBook</span>
                    </a>
                </div>

                <!-- Center: Business Selector -->
                <div class="flex items-center">
                    @if($activeBusiness ?? null)
                        <div class="dropdown" x-data="{ open: false }">
                            <button @click="open = !open" class="btn btn-secondary">
                                <div style="width: 8px; height: 8px; background: var(--success-color); border-radius: 50%; margin-right: 8px;"></div>
                                <span>{{ $activeBusiness->name }}</span>
                                <svg style="width: 16px; height: 16px; margin-left: 8px;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="dropdown-menu slide-down" style="min-width: 250px; left: 50%; transform: translateX(-50%);">
                                @foreach(Auth::user()->businesses as $business)
                                    <form method="POST" action="{{ route('business.switch', $business) }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item {{ $business->id === $activeBusiness->id ? 'bg-gray-50' : '' }}">
                                            <div class="flex items-center">
                                                <div style="width: 8px; height: 8px; background: {{ $business->id === $activeBusiness->id ? 'var(--primary-color)' : 'var(--gray-400)' }}; border-radius: 50%; margin-right: 12px;"></div>
                                                <div>
                                                    <div>{{ $business->name }}</div>
                                                    <div style="font-size: 0.75rem; color: var(--gray-500);">{{ $business->currency }}</div>
                                                </div>
                                            </div>
                                        </button>
                                    </form>
                                @endforeach
                                <div class="dropdown-divider"></div>
                                <a href="{{ route('businesses.create') }}" class="dropdown-item" style="color: var(--primary-color);">
                                    + New Business
                                </a>
                            </div>
                        </div>
                    @else
                        <span style="color: var(--gray-500); font-size: 0.875rem;">No business selected</span>
                    @endif
                </div>

                <!-- Right: User Menu -->
                <div class="flex items-center">
                    <div class="dropdown" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center" style="background: transparent; border: none; padding: 0; cursor: pointer;">
                            <div style="width: 32px; height: 32px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 8px;">
                                <span style="color: white; font-weight: 500; font-size: 0.875rem;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <span style="color: var(--gray-700); font-weight: 500;">{{ Auth::user()->name }}</span>
                            <svg style="width: 16px; height: 16px; margin-left: 4px; color: var(--gray-400);" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="dropdown-menu slide-down">
                            <div style="padding: 0.75rem 1rem; border-bottom: 1px solid var(--gray-200);">
                                <div style="font-weight: 500; color: var(--gray-900);">{{ Auth::user()->name }}</div>
                                <div style="font-size: 0.75rem; color: var(--gray-500);">{{ Auth::user()->email }}</div>
                            </div>
                            <a href="{{ route('dashboard') }}" class="dropdown-item">Dashboard</a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">Profile</a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item" style="color: var(--danger-color);">Sign out</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </header>

        <!-- Main Content -->
        <div class="app-main">
            <!-- Sidebar -->
            @if($activeBusiness ?? null)
                <aside
                    class="app-sidebar"
                    :class="{ 'open': sidebarOpen }"
                    @click.away="sidebarOpen = false">
                    <div class="sidebar-section">
                        @if (Route::currentRouteName() === 'dashboard')
                            <h2 class="sidebar-title">Dashboard</h2>
                            {{-- show user name and image and show profile link --}}
                            <nav class="sidebar-nav" style="border: 1px solid var(--gray-200); border-radius: 6px;">
                                <a href="{{ route('profile.edit') }}" class="nav-link" style="margin-bottom: 0;">
                                    <div class="flex items-center">
                                        <div class="avatar" style="width: 32px; height: 32px; background: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 8px;">
                                            <span style="color: white; font-weight: 500; font-size: 0.875rem;">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                        </div>
                                        <span>{{ Auth::user()->name }}</span>
                                    </div>
                                </a>
                            </nav>
                        @else
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="sidebar-title">Books</h2>
                                @php
                                    $userRole = Auth::user()->businesses()->where('business_id', $activeBusiness->id)->value('role');
                                @endphp
                                @if(in_array($userRole, ['owner', 'admin']))
                                    <a href="{{ route('books.create') }}" class="btn btn-primary btn-sm">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                            <nav class="sidebar-nav">
                                @php
                                    $user = Auth::user();
                                    $role = $user->businesses()->where('business_id', $activeBusiness->id)->value('role');

                                    if (in_array($role, ['owner', 'admin'])) {
                                        // Owners and admins can see all books
                                        $books = \App\Models\Book::where('business_id', $activeBusiness->id)->latest('updated_at')->get();
                                    } else {
                                        // Staff can only see books they are assigned to
                                        $assignedBookIds = $user->books()->where('business_id', $activeBusiness->id)->pluck('books.id');
                                        $books = \App\Models\Book::where('business_id', $activeBusiness->id)
                                                    ->whereIn('id', $assignedBookIds)
                                                    ->latest('updated_at')
                                                    ->get();
                                    }

                                    $selectedBookId = request()->route('book')?->id ?? request()->get('book');
                                @endphp

                                @forelse($books as $book)
                                    <a href="{{ route('books.show', $book) }}" class="nav-link {{ $selectedBookId == $book->id ? 'active' : '' }}" style="border: 1px solid var(--gray-200); border-radius: 6px; padding: 0.5rem 1rem; display: flex; align-items: center; gap: 0.5rem;">
                                        <span>{{ $book->name }}</span>
                                    </a>
                                @empty
                                    <div class="text-center" style="padding: 1.5rem 0;">
                                        @if(in_array($role, ['owner', 'admin']))
                                            <p style="color: var(--gray-500); font-size: 0.875rem; margin-bottom: 1rem;">No books yet</p>
                                            <a href="{{ route('books.create') }}" class="btn btn-primary btn-sm">Create Book</a>
                                        @else
                                            <p style="color: var(--gray-500); font-size: 0.875rem;">No books assigned to you</p>
                                        @endif
                                    </div>
                                @endforelse
                            </nav>
                        @endif
                    </div>
                </aside>
            @endif

            <!-- Main content -->
            <main class="app-content">
                {{ $slot }}
            </main>
        </div>

        <!-- Footer -->
        <footer class="app-footer" style="display: flex; justify-content: space-between; align-items: center; padding: 1rem;">
            <div class="footer-left" style="font-size: 0.75rem; color: var(--gray-500);">
                &copy; {{ date('Y') }} CashBook. All rights reserved.
                <div class="footer-center" style="font-size: 0.65rem; color: var(--gray-400);">
                    &copy; Riaz
                </div>
            </div>
            <div class="footer-right" style="display: flex; align-items: center; gap: 1rem;">
                <span>Version 1.0.0</span>
                <a href="https://github.com/Riaz-Mahmud/cashbook" target="_blank" rel="noopener noreferrer" style="color: var(--primary-color); text-decoration: none; display: flex; align-items: center; gap: 0.25rem;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" width="16" height="16" aria-hidden="true">
                    <path d="M12 0C5.373 0 0 5.373 0 12c0 5.303 3.438 9.8 8.205 11.387.6.113.82-.258.82-.577v-2.234c-3.338.726-4.033-1.61-4.033-1.61-.546-1.387-1.333-1.756-1.333-1.756-1.09-.745.083-.73.083-.73 1.205.085 1.84 1.238 1.84 1.238 1.07 1.835 2.807 1.305 3.492.997.108-.775.418-1.305.76-1.605-2.665-.303-5.467-1.333-5.467-5.933 0-1.31.468-2.38 1.236-3.22-.124-.303-.536-1.523.117-3.176 0 0 1.008-.322 3.301 1.23a11.5 11.5 0 013.003-.404c1.018.005 2.044.138 3.003.404 2.291-1.552 3.297-1.23 3.297-1.23.655 1.653.243 2.873.12 3.176.77.84 1.235 1.91 1.235 3.22 0 4.61-2.807 5.627-5.48 5.922.43.372.823 1.103.823 2.222v3.293c0 .319.217.694.825.576C20.565 21.796 24 17.298 24 12c0-6.627-5.373-12-12-12z"/>
                </svg>
                <span>GitHub Repo</span>
                </a>
            </div>
        </footer>

    </body>
</html>
