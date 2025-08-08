
<x-app-layout>
    <div style="margin-bottom: 2.5rem;">
        @if (session('status'))
            <div style="margin-bottom: 1.5rem; background: var(--success-bg, #ecfdf5); border: 1px solid var(--success-color, #bbf7d0); color: var(--success-color, #15803d); border-radius: 0.5rem; padding: 1rem 1.5rem; font-weight: 500;">
                {{ session('status') }}
            </div>
        @endif
        <div style="display: flex; align-items: center; gap: 1.25rem;">
            <a href="{{ route('businesses.show', $business) }}" style="color: var(--gray-400); text-decoration: none; display: flex; align-items: center; transition: color 0.2s;" onmouseover="this.style.color='var(--gray-600)'" onmouseout="this.style.color='var(--gray-400)'">
                <svg style="width: 1.5rem; height: 1.5rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin: 0;">Edit Business</h1>
                <p style="margin-top: 0.5rem; color: var(--gray-600); margin-bottom: 0;">Update {{ $business->name }} information.</p>
            </div>
        </div>
    </div>


    <div style="max-width: 40rem; margin: 0 auto;">
        <form method="POST" action="{{ route('businesses.update', $business) }}" style="background: #fff; box-shadow: 0 2px 8px 0 rgba(0,0,0,0.04); border-radius: var(--border-radius, 0.75rem); overflow: hidden;">
            @csrf
            @method('PUT')
            <div style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--gray-200, #e5e7eb); background: var(--gray-50, #f9fafb);">
                <h3 style="font-size: 1.125rem; font-weight: 500; color: var(--gray-900); margin: 0;">Business Information</h3>
                <p style="margin-top: 0.25rem; color: var(--gray-600); font-size: 0.95rem;">Update the details for your business.</p>
            </div>
            <div style="padding: 2rem; display: flex; flex-direction: column; gap: 2rem;">
                <div>
                    <x-input-label for="name" :value="__('Business Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $business->name)" required autofocus />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>
                <div>
                    <x-input-label for="currency" :value="__('Default Currency')" />
                    <select id="currency" name="currency" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="BDT" {{ old('currency', $business->currency) == 'BDT' ? 'selected' : '' }}>BDT - Bangladeshi Taka</option>
                        <option value="USD" {{ old('currency', $business->currency) == 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                        <option value="EUR" {{ old('currency', $business->currency) == 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                        <option value="GBP" {{ old('currency', $business->currency) == 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                        <option value="JPY" {{ old('currency', $business->currency) == 'JPY' ? 'selected' : '' }}>JPY - Japanese Yen</option>
                        <option value="CAD" {{ old('currency', $business->currency) == 'CAD' ? 'selected' : '' }}>CAD - Canadian Dollar</option>
                        <option value="AUD" {{ old('currency', $business->currency) == 'AUD' ? 'selected' : '' }}>AUD - Australian Dollar</option>
                        <option value="CHF" {{ old('currency', $business->currency) == 'CHF' ? 'selected' : '' }}>CHF - Swiss Franc</option>
                        <option value="CNY" {{ old('currency', $business->currency) == 'CNY' ? 'selected' : '' }}>CNY - Chinese Yuan</option>
                        <option value="INR" {{ old('currency', $business->currency) == 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('currency')" />
                </div>
            </div>
            <div style="padding: 1.5rem 2rem; background: var(--gray-50, #f9fafb); border-top: 1px solid var(--gray-200, #e5e7eb); display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="{{ route('businesses.show', $business) }}" style="display: inline-flex; align-items: center; padding: 0.75rem 1.5rem; background: #fff; border: 1px solid var(--gray-300, #d1d5db); border-radius: 0.5rem; font-weight: 600; font-size: 0.85rem; color: var(--gray-700, #374151); text-transform: uppercase; letter-spacing: 0.05em; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.01); transition: background 0.2s, color 0.2s; text-decoration: none;" onmouseover="this.style.background='var(--gray-100, #f3f4f6)'" onmouseout="this.style.background='#fff'">
                    Cancel
                </a>
                <x-primary-button>
                    Update Business
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
