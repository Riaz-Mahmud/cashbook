<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CashBook') }}</title>

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
    </head>
    <body class="app-layout">
        <!-- Top Navigation -->
        <header class="app-header">
            <div class="header-content">
                <!-- Left: Logo -->
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="app-logo">CashBook</a>
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
                        <button @click="open = !open" class="flex items-center">
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
                            @if(($activeBusiness?->id) && in_array(Auth::user()->businesses()->where('business_id', $activeBusiness->id)->value('role'), ['owner','admin']))
                                <a href="{{ route('settings.index') }}" class="dropdown-item">Settings</a>
                            @endif
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
                <aside class="app-sidebar">
                    <div class="sidebar-section">
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
                                    $books = \App\Models\Book::where('business_id', $activeBusiness->id)->get();
                                } else {
                                    // Staff can only see books they are assigned to
                                    $assignedBookIds = $user->books()->where('business_id', $activeBusiness->id)->pluck('books.id');
                                    $books = \App\Models\Book::where('business_id', $activeBusiness->id)
                                                ->whereIn('id', $assignedBookIds)
                                                ->get();
                                }

                                $selectedBookId = request()->route('book')?->id ?? request()->get('book');
                            @endphp

                            @forelse($books as $book)
                                <a href="{{ route('books.show', $book) }}" class="nav-link {{ $selectedBookId == $book->id ? 'active' : '' }}">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
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
                    </div>
                </aside>
            @endif

            <!-- Main content -->
            <main class="app-content">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
