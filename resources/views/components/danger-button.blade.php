<button {{ $attributes->merge(['type' => 'submit', 'style' => 'display: inline-flex; align-items: center; padding: 0.5rem 1rem; background-color: #dc2626; border: 1px solid transparent; border-radius: 0.375rem; font-weight: 600; font-size: 0.75rem; color: #fff; text-transform: uppercase; letter-spacing: 0.1em;']) }}>
    {{ $slot }}
</button>
