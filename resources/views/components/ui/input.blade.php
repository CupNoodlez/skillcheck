@props([
    'label' => null,
    'name' => null,
    'hint' => null,
    'id' => null,
])

@php
    $id = $id ?? $name;
    $hasError = $name && $errors->has($name);
    $field = 'w-full rounded-lg border bg-white/90 backdrop-blur-xs px-3 py-2 text-sm text-ink placeholder:text-faint shadow-xs transition-all duration-200 outline-none focus:ring-2 '
        . ($hasError
            ? 'border-red-300 focus:border-red-400 focus:ring-red-500/25 focus:bg-red-50/50'
            : 'border-line-strong focus:border-brand-400 focus:ring-brand-400/40 focus:bg-brand-50/50');
@endphp

<div>
    @if($label)
        <label @if($id) for="{{ $id }}" @endif class="block text-sm font-medium text-ink mb-1.5">{{ $label }}</label>
    @endif
    <input @if($name) name="{{ $name }}" @endif @if($id) id="{{ $id }}" @endif
        {{ $attributes->merge(['class' => $field, 'type' => 'text']) }}>
    @if($hint && !$hasError)
        <p class="mt-1.5 text-xs text-muted">{{ $hint }}</p>
    @endif
    @if($hasError)
        <p class="mt-1.5 text-xs text-red-600">{{ $errors->first($name) }}</p>
    @endif
</div>
