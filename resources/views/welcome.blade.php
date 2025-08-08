<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'CashBook') }} - 100% Free Cash Management</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Custom CSS -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <!-- Alpine.js -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body>
        <!-- Navigation -->
        <header class="app-header">
            <div class="header-content">
                <div class="flex items-center">
                    <h1 class="app-logo">CashBook</h1>
                </div>
                <nav class="nav-menu">
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                        </li>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="hero-section">
            <div style="max-width: 1200px; margin: 0 auto;">
                <h1 class="hero-title">Professional Cash Management. 100% Free.</h1>
                <p class="hero-subtitle">
                    CashBook is <span style="color: #22c55e; font-weight: 600;">completely free</span> for everyone. No subscriptions, no credit card required, no hidden fees.<br>
                    Streamline your business finances with powerful cash flow tracking, multi-business support, and comprehensive reporting tools.
                </p>
                <div style="margin-top: 2rem;">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-lg">Go to Dashboard</a>
                    @else
                        <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                            <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Create Free Account</a>
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3);">Sign In</a>
                        </div>
                    @endauth
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section style="padding: 4rem 0;">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                <div class="text-center mb-8">
                    <h2 class="page-title">Everything you need to manage your cash flow</h2>
                    <p class="page-subtitle">Powerful features designed for modern businesses</p>
                </div>

                <div class="feature-grid">
                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="feature-title">Multiple Cash Books</h3>
                        <p class="feature-description">
                            Organize your finances with unlimited cash books. Track different projects,
                            departments, or business units separately with ease.
                        </p>
                    </div>

                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-4m-5 0H3m2 0h4M9 7h6m-6 4h6m-6 4h3"></path>
                            </svg>
                        </div>
                        <h3 class="feature-title">Multi-Business Support</h3>
                        <p class="feature-description">
                            Manage multiple businesses from one account. Switch between businesses
                            seamlessly and keep all your financial data organized.
                        </p>
                    </div>

                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="feature-title">Advanced Analytics</h3>
                        <p class="feature-description">
                            Get insights into your cash flow with detailed reports, charts, and analytics.
                            Make informed decisions with real-time financial data.
                        </p>
                    </div>

                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="feature-title">Secure & Reliable</h3>
                        <p class="feature-description">
                            Your financial data is protected with enterprise-grade security.
                            Regular backups and secure hosting ensure your data is always safe.
                        </p>
                    </div>

                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="feature-title">Transaction Management</h3>
                        <p class="feature-description">
                            Record income and expenses with detailed categorization.
                            Upload receipts, add notes, and track every transaction efficiently.
                        </p>
                    </div>

                    <div class="feature-card fade-in">
                        <div class="feature-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="feature-title">Lightning Fast</h3>
                        <p class="feature-description">
                            Built for speed and efficiency. Quick data entry, instant search,
                            and responsive design make managing finances a breeze.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section style="background: var(--gray-100); padding: 4rem 0;">
            <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem;">
                <div class="text-center mb-8">
                    <h2 class="page-title">Trusted by businesses worldwide</h2>
                    <p class="page-subtitle">Join thousands of businesses managing their cash flow with CashBook</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-card text-center">
                        <div class="stat-value">10,000+</div>
                        <div class="stat-label">Active Users</div>
                    </div>
                    <div class="stat-card text-center">
                        <div class="stat-value">$50M+</div>
                        <div class="stat-label">Tracked Revenue</div>
                    </div>
                    <div class="stat-card text-center">
                        <div class="stat-value">99.9%</div>
                        <div class="stat-label">Uptime</div>
                    </div>
                    <div class="stat-card text-center">
                        <div class="stat-value">24/7</div>
                        <div class="stat-label">Support</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="hero-section" style="padding: 3rem 2rem;">
            <div style="max-width: 800px; margin: 0 auto;">
                <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 1rem;">Ready to take control of your cash flow?</h2>
                <p style="font-size: 1.125rem; margin-bottom: 2rem; opacity: 0.9;">
                    CashBook is <span style="color: #22c55e; font-weight: 600;">100% free</span> for everyone. No subscriptions, no credit card required, no limits.
                </p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Create Your Free Account</a>
                @endguest
            </div>
        </section>

        <!-- Footer -->
        <footer style="background: var(--gray-800); color: white; padding: 2rem;">
            <div style="max-width: 1200px; margin: 0 auto; text-center;">
                <p style="margin-bottom: 1rem;">&copy; {{ date('Y') }} CashBook. All rights reserved.</p>
                <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
                    <a href="{{ route('privacy') }}" style="color: var(--gray-400); text-decoration: none;">Privacy Policy</a>
                    <a href="#" style="color: var(--gray-400); text-decoration: none;">Terms of Service</a>
                    <a href="#" style="color: var(--gray-400); text-decoration: none;">Support</a>
                    <a href="#" style="color: var(--gray-400); text-decoration: none;">Contact</a>
                </div>
            </div>
        </footer>
    </body>
</html>
