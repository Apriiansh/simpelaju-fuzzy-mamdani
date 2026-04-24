@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-premium-border/40 bg-white/50 focus:border-forest focus:ring-forest rounded-xl shadow-sm transition-all duration-300']) }}>
