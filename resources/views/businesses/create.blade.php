<x-app-layout>
    <div style="margin-bottom: 2rem;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <a href="{{ route('businesses.index') }}" style="color: var(--gray-400); text-decoration: none; display: flex; align-items: center; transition: color 0.2s ease;" onmouseover="this.style.color='var(--gray-600)'" onmouseout="this.style.color='var(--gray-400)'">
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin: 0;">Create Business</h1>
                <p style="margin-top: 0.5rem; color: var(--gray-600); margin-bottom: 0;">Add a new business entity to your account.</p>
            </div>
        </div>
    </div>

    <div style="max-width: 600px; margin: 0 auto;">
        <form method="POST" action="{{ route('businesses.store') }}" class="card">
            @csrf

            <div class="card-header">
                <h3 class="card-title">Business Information</h3>
                <p style="margin-top: 0.25rem; font-size: 0.875rem; color: var(--gray-600);">Enter the basic details to get started with your new business.</p>
            </div>

            <div class="card-body" style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div class="form-group">
                    <x-input-label for="name" :value="__('Business Name')" />
                    <x-text-input id="name" name="name" type="text" class="form-input" :value="old('name')" required autofocus placeholder="Enter your business name" />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="form-group">
                    <x-input-label for="currency" :value="__('Default Currency')" />
                    <select id="currency" name="currency" class="form-select" required>
                        <option value="">Select a currency</option>
                        <option value="BDT" {{ old('currency', 'BDT') == 'BDT' ? 'selected' : '' }}>BDT - Bangladeshi Taka</option>
                        <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                        <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                        <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                        <option value="JPY" {{ old('currency') == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen</option>
                        <option value="CAD" {{ old('currency') == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                        <option value="AUD" {{ old('currency') == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                        <option value="CHF" {{ old('currency') == 'CHF' ? 'selected' : '' }}>CHF - Swiss Franc</option>
                        <option value="CNY" {{ old('currency') == 'CNY' ? 'selected' : '' }}>CNY - Chinese Yuan</option>
                        <option value="INR" {{ old('currency') == 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                        <option value="BRL" {{ old('currency') == 'BRL' ? 'selected' : '' }}>BRL - Brazilian Real</option>
                        <option value="MXN" {{ old('currency') == 'MXN' ? 'selected' : '' }}>MXN - Mexican Peso</option>
                        <option value="ZAR" {{ old('currency') == 'ZAR' ? 'selected' : '' }}>ZAR - South African Rand</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('currency')" />
                    <p style="font-size: 0.875rem; color: var(--gray-500); margin-top: 0.5rem;">This will be used as the default currency for all transactions in this business.</p>
                </div>
            </div>

            <div class="card-footer" style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="{{ route('businesses.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    Create Business
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
