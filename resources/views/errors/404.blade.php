<x-guest-layout>
    <style>
        /* Override guest layout container styles for this page */
        .auth-container {
            width: 100vw !important;
            height: 100vh;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            padding: 0 !important;
            background-color: #f9fafb; /* Optional background color */
        }
        .auth-card {
            width: 100% !important;
            max-width: none !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            padding: 2rem !important;
        }
    </style>

    <div style="
        width: 100%;
        text-align: center;
        color: #1a202c;
    ">
        <h1 style="font-size: 6rem; font-weight: 900; color: #e53e3e; margin-bottom: 1rem;">404</h1>
        <h2 style="font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">Page Not Found</h2>
        <p style="font-size: 1.125rem; color: #718096; margin-bottom: 2rem;">
            Sorry, the page you are looking for does not exist or has been moved.
        </p>

        {{-- go back --}}
        <a href="javascript:history.back()" style="
            background-color: #e2e8f0;
            color: #2d3748;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(226, 232, 240, 0.4);
            margin-right: 1rem;
        ">
            Go Back
        </a>
        <a href="{{ url('/') }}" style="
            background-color: #3b82f6;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.375rem;
            font-weight: 600;
            text-decoration: none;
            box-shadow: 0 2px 6px rgba(59, 130, 246, 0.4);
            display: inline-block;
        ">
            Go to Homepage
        </a>
    </div>
</x-guest-layout>
