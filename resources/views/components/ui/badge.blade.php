@props([
    'color' => 'gray', // gray | brand | green | amber | red | blue | purple
])

@php
    $colors = [
        'gray'   => 'bg-subtle text-gray-600 ring-line-strong',
        'brand'  => 'bg-brand-50 text-brand-700 ring-brand-200',
        'green'  => 'bg-green-50 text-green-700 ring-green-200',
        'amber'  => 'bg-amber-50 text-amber-700 ring-amber-200',
        'red'    => 'bg-red-50 text-red-700 ring-red-200',
        'blue'   => 'bg-blue-50 text-blue-700 ring-blue-200',
        'purple' => 'bg-purple-50 text-purple-700 ring-purple-200',
    ];
    $cls = $colors[$color] ?? $colors['gray'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset $cls [&_svg]:w-3.5 [&_svg]:h-3.5"]) }}>
    {{ $slot }}
</span>
