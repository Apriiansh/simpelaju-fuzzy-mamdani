@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-xs text-forest/70 uppercase tracking-widest mb-1']) }}>
    {{ $value ?? $slot }}
</label>
