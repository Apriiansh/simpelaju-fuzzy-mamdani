<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-2.5 bg-forest border border-forest/10 rounded-xl font-bold text-xs text-cream uppercase tracking-widest hover:bg-forest/90 hover:shadow-lg hover:shadow-forest/20 active:bg-forest/95 focus:outline-none focus:ring-2 focus:ring-forest focus:ring-offset-2 transition-all duration-300 shadow-sm']) }}>
    {{ $slot }}
</button>
