<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="alert alert-success" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            @if($errors->get('email'))
                <div class="form-error">{{ implode(', ', $errors->get('email')) }}</div>
            @endif
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" />
            @if($errors->get('password'))
                <div class="form-error">{{ implode(', ', $errors->get('password')) }}</div>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="form-group">
            <label for="remember_me" style="display: flex; align-items: center;">
                <input id="remember_me" type="checkbox" name="remember" style="margin-right: 8px;">
                <span class="form-label" style="margin-bottom: 0;">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size: 0.875rem; color: var(--primary-color); text-decoration: none;">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button type="submit" class="btn btn-primary">
                {{ __('Log in') }}
            </button>
        </div>

        <div class="text-center mt-4">
            <span style="font-size: 0.875rem; color: var(--gray-600);">Don't have an account?</span>
            <a href="{{ route('register') }}" style="font-size: 0.875rem; color: var(--primary-color); text-decoration: none; margin-left: 0.5rem;">Sign up</a>
        </div>
    </form>
</x-guest-layout>
