@props([
    'label' => null,
    'name' => null,
    'hint' => null,
    'id' => null,
])

@php
    $id = $id ?? $name;
    $hasError = $name && $errors->has($name);
    $field = 'w-full appearance-none rounded-lg border bg-white px-3 py-2 pr-9 text-sm text-ink shadow-xs transition outline-none focus:ring-2 '
        . ($hasError
            ? 'border-red-300 focus:border-red-400 focus:ring-red-500/25'
            : 'border-line-strong focus:border-brand-500 focus:ring-brand-500/25');
@endphp

<div>
    @if($label)
        <label @if($id) for="{{ $id }}" @endif class="block text-sm font-medium text-ink mb-1.5">{{ $label }}</label>
    @endif
    <div class="relative">
        <select @if($name) name="{{ $name }}" @endif @if($id) id="{{ $id }}" @endif
            {{ $attributes->merge(['class' => $field]) }}>
            {{ $slot }}
        </select>
        <x-icon name="chevron-down" class="w-4 h-4 text-faint absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none" />
    </div>
    @if($hint && !$hasError)
        <p class="mt-1.5 text-xs text-muted">{{ $hint }}</p>
    @endif
    @if($hasError)
        <p class="mt-1.5 text-xs text-red-600">{{ $errors->first($name) }}</p>
    @endif
</div>
