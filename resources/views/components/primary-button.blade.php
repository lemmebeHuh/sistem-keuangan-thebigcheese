<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-brand-red border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-opacity-80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-red transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
