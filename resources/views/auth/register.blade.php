<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">{{ __('Name') }}</label>
            <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            @if($errors->get('name'))
                <div class="form-error">{{ implode(', ', $errors->get('name')) }}</div>
            @endif
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            @if($errors->get('email'))
                <div class="form-error">{{ implode(', ', $errors->get('email')) }}</div>
            @endif
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">{{ __('Password') }}</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
            @if($errors->get('password'))
                <div class="form-error">{{ implode(', ', $errors->get('password')) }}</div>
            @endif
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" />
            @if($errors->get('password_confirmation'))
                <div class="form-error">{{ implode(', ', $errors->get('password_confirmation')) }}</div>
            @endif
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" style="font-size: 0.875rem; color: var(--primary-color); text-decoration: none;">
                {{ __('Already registered?') }}
            </a>

            <button type="submit" class="btn btn-primary">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</x-guest-layout>
