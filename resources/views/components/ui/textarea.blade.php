@props([
    'label' => null,
    'name' => null,
    'hint' => null,
    'id' => null,
    'rows' => 4,
])

@php
    $id = $id ?? $name;
    $hasError = $name && $errors->has($name);
    $field = 'w-full rounded-lg border bg-white px-3 py-2 text-sm text-ink placeholder:text-faint shadow-xs transition outline-none focus:ring-2 '
        . ($hasError
            ? 'border-red-300 focus:border-red-400 focus:ring-red-500/25'
            : 'border-line-strong focus:border-brand-500 focus:ring-brand-500/25');
@endphp

<div>
    @if($label)
        <label @if($id) for="{{ $id }}" @endif class="block text-sm font-medium text-ink mb-1.5">{{ $label }}</label>
    @endif
    <textarea @if($name) name="{{ $name }}" @endif @if($id) id="{{ $id }}" @endif rows="{{ $rows }}"
        {{ $attributes->merge(['class' => $field]) }}>{{ $slot }}</textarea>
    @if($hint && !$hasError)
        <p class="mt-1.5 text-xs text-muted">{{ $hint }}</p>
    @endif
    @if($hasError)
        <p class="mt-1.5 text-xs text-red-600">{{ $errors->first($name) }}</p>
    @endif
</div>
