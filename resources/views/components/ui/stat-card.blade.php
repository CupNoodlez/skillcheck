@props([
    'label' => '',
    'value' => '',
    'icon' => 'circle',
    'tone' => 'brand', // brand | green | amber | blue | purple
    'sub' => null,
])

@php
    $tones = [
        'brand'  => 'bg-brand-50 text-brand-600',
        'green'  => 'bg-green-50 text-green-600',
        'amber'  => 'bg-amber-50 text-amber-600',
        'blue'   => 'bg-blue-50 text-blue-600',
        'purple' => 'bg-purple-50 text-purple-600',
    ];
    $toneCls = $tones[$tone] ?? $tones['brand'];
@endphp

<div {{ $attributes->merge(['class' => 'sc-card p-5 flex items-start justify-between gap-4']) }}>
    <div class="min-w-0">
        <p class="text-sm font-medium text-muted">{{ $label }}</p>
        <p class="mt-2 text-3xl font-semibold tracking-tight text-ink">{{ $value }}</p>
        @if($sub)
            <p class="mt-1 text-xs text-faint">{{ $sub }}</p>
        @endif
    </div>
    <span class="shrink-0 inline-flex items-center justify-center w-11 h-11 rounded-xl {{ $toneCls }}">
        <x-icon :name="$icon" class="w-5 h-5" />
    </span>
</div>
