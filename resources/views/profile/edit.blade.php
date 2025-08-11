<x-app-layout>
    <div style="margin-bottom: 2.5rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin: 0;">Profile</h1>
        <p style="margin-top: 0.5rem; color: var(--gray-600); margin-bottom: 0;">Manage your account settings and preferences.</p>
    </div>

    <div style="display: flex; flex-direction: column; gap: 2.5rem;">
        <div style="background: #fff; box-shadow: 0 2px 8px 0 rgba(0,0,0,0.04); border-radius: var(--border-radius, 0.75rem); overflow: hidden;">
            <div style="padding: 1.25rem 2rem; border-bottom: 1px solid var(--gray-200, #e5e7eb); background: var(--gray-50, #f9fafb);">
                <h3 style="font-size: 1.125rem; font-weight: 500; color: var(--gray-900); margin: 0;">Profile Information</h3>
                <p style="margin-top: 0.25rem; color: var(--gray-600); font-size: 0.95rem;">Update your account's profile information and email address.</p>
            </div>
            <form method="POST" action="{{ route('profile.update') }}" style="padding: 2rem; display: flex; flex-direction: column; gap: 2rem;">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input
                        id="name"
                        name="name"
                        type="text"
                        style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid var(--gray-300, #d1d5db); border-radius: 0.5rem; font-size: 0.95rem; color: var(--gray-900); background: #fff; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.3)'"
                        onblur="this.style.borderColor='var(--gray-300, #d1d5db)'; this.style.boxShadow='none'"
                        :value="old('name', $user->name)"
                        required
                        autofocus
                        autocomplete="name"
                    />

                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid var(--gray-300, #d1d5db); border-radius: 0.5rem; font-size: 0.95rem; color: var(--gray-900); background: #fff; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.3)'"
                        onblur="this.style.borderColor='var(--gray-300, #d1d5db)'; this.style.boxShadow='none'"
                        :value="old('email', $user->email)"
                        required
                        autocomplete="username"
                    />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                        <div>
                            <p style="font-size: 0.95rem; margin-top: 0.5rem; color: var(--gray-800);">
                                {{ __('Your email address is unverified.') }}

                                <button form="send-verification" style="text-decoration: underline; font-size: 0.95rem; color: var(--gray-600); background: none; border: none; cursor: pointer; padding: 0; margin-left: 0.5rem;" onmouseover="this.style.color='var(--gray-900)'" onmouseout="this.style.color='var(--gray-600)'">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p style="margin-top: 0.5rem; font-weight: 500; font-size: 0.95rem; color: #22c55e;">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <x-primary-button style="padding: 0.75rem 1.5rem; background: #3b82f6; color: #fff; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.01); transition: background 0.2s, color 0.2s;">
                        {{ __('Save') }}
                    </x-primary-button>

                    @if (session('status') === 'profile-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" style="font-size: 0.95rem; color: var(--gray-600);">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>

        <div style="background: #fff; box-shadow: 0 2px 8px 0 rgba(0,0,0,0.04); border-radius: var(--border-radius, 0.75rem); overflow: hidden;">
            <div style="padding: 1.25rem 2rem; border-bottom: 1px solid var(--gray-200, #e5e7eb); background: var(--gray-50, #f9fafb);">
                <h3 style="font-size: 1.125rem; font-weight: 500; color: var(--gray-900); margin: 0;">Update Password</h3>
                <p style="margin-top: 0.25rem; color: var(--gray-600); font-size: 0.95rem;">Ensure your account is using a long, random password to stay secure.</p>
            </div>
            <form method="post" action="{{ route('password.update') }}" style="padding: 2rem; display: flex; flex-direction: column; gap: 2rem;">
                @csrf
                @method('put')

                <div>
                    <x-input-label for="update_password_current_password" :value="__('Current Password')" />
                    <x-text-input
                        id="update_password_current_password"
                        name="current_password"
                        type="password"
                        style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid var(--gray-300, #d1d5db); border-radius: 0.5rem; font-size: 0.95rem; color: var(--gray-900); background: #fff; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.3)'"
                        onblur="this.style.borderColor='var(--gray-300, #d1d5db)'; this.style.boxShadow='none'"
                        autocomplete="current-password"
                    />
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password" :value="__('New Password')" />
                    <x-text-input
                        id="update_password_password"
                        name="password"
                        type="password"
                        style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid var(--gray-300, #d1d5db); border-radius: 0.5rem; font-size: 0.95rem; color: var(--gray-900); background: #fff; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.3)'"
                        onblur="this.style.borderColor='var(--gray-300, #d1d5db)'; this.style.boxShadow='none'"
                        autocomplete="new-password"
                    />
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input
                        id="update_password_password_confirmation"
                        name="password_confirmation"
                        type="password"
                        style="width: 100%; padding: 0.625rem 0.75rem; border: 1px solid var(--gray-300, #d1d5db); border-radius: 0.5rem; font-size: 0.95rem; color: var(--gray-900); background: #fff; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                        onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.3)'"
                        onblur="this.style.borderColor='var(--gray-300, #d1d5db)'; this.style.boxShadow='none'"
                        autocomplete="new-password"
                    />
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
                </div>

                <div style="display: flex; align-items: center; gap: 1.5rem;">
                    <x-primary-button style="padding: 0.75rem 1.5rem; background: #3b82f6; color: #fff; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.01); transition: background 0.2s, color 0.2s;">
                        {{ __('Save') }}
                    </x-primary-button>

                    @if (session('status') === 'password-updated')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" style="font-size: 0.95rem; color: var(--gray-600);">{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>
        </div>

        <div style="background: #fff; box-shadow: 0 2px 8px 0 rgba(0,0,0,0.04); border-radius: var(--border-radius, 0.75rem); overflow: hidden;">
            <div style="padding: 1.25rem 2rem; border-bottom: 1px solid var(--gray-200, #e5e7eb); background: var(--gray-50, #f9fafb);">
                <h3 style="font-size: 1.125rem; font-weight: 500; color: var(--gray-900); margin: 0;">Delete Account</h3>
                <p style="margin-top: 0.25rem; color: var(--gray-600); font-size: 0.95rem;">Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.</p>
            </div>
            <div style="padding: 2rem;">
                <button
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                    style="display: inline-flex; align-items: center; padding: 0.75rem 1.5rem; background: #dc2626; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.85rem; color: #fff; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.01); transition: background 0.2s, color 0.2s; cursor: pointer;"
                    onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'"
                >{{ __('Delete Account') }}</button>
            </div>
        </div>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" style="padding: 2rem;">
            @csrf
            @method('delete')

            <h2 style="font-size: 1.125rem; font-weight: 500; color: var(--gray-900);">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p style="margin-top: 0.5rem; color: var(--gray-600); font-size: 0.95rem;">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div style="margin-top: 1.5rem;">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    style="width: 75%; padding: 0.625rem 0.75rem; border: 1px solid var(--gray-300, #d1d5db); border-radius: 0.5rem; font-size: 0.95rem; color: var(--gray-900); background: #fff; outline: none; transition: border-color 0.2s, box-shadow 0.2s;"
                    onfocus="this.style.borderColor='#3b82f6'; this.style.boxShadow='0 0 0 3px rgba(59,130,246,0.3)'"
                    onblur="this.style.borderColor='var(--gray-300, #d1d5db)'; this.style.boxShadow='none'"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end; gap: 1rem;">
                <x-secondary-button x-on:click="$dispatch('close')" style="padding: 0.75rem 1.5rem; background: #f3f4f6; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.85rem; color: #374151; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.01); transition: background 0.2s, color 0.2s; cursor: pointer;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <button type="submit" style="display: inline-flex; align-items: center; padding: 0.75rem 1.5rem; background: #dc2626; border: none; border-radius: 0.5rem; font-weight: 600; font-size: 0.85rem; color: #fff; text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.01); transition: background 0.2s, color 0.2s; cursor: pointer;" onmouseover="this.style.background='#b91c1c'" onmouseout="this.style.background='#dc2626'">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
