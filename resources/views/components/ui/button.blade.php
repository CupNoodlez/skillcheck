@props([
    'variant' => 'primary', // primary | secondary | ghost | danger | danger-soft | subtle
    'size' => 'md',         // sm | md | lg
    'href' => null,
    'type' => 'button',
])

@php
    $base = 'inline-flex items-center justify-center gap-2 font-medium rounded-lg border transition-all duration-200 disabled:opacity-50 disabled:pointer-events-none whitespace-nowrap select-none';
    $variants = [
        'primary'     => 'bg-linear-to-r from-brand-700 to-brand-800 border-transparent text-white hover:from-brand-600 hover:to-brand-700 glow-effect shadow-md',
        'secondary'   => 'bg-white/80 backdrop-blur-xs border-line-strong text-ink hover:bg-subtle shadow-xs hover-lift',
        'ghost'       => 'bg-transparent border-transparent text-muted hover:bg-brand-50 hover:text-brand-800 transition-colors',
        'danger'      => 'bg-linear-to-r from-red-600 to-red-700 border-transparent text-white hover:from-red-500 hover:to-red-600 shadow-md hover-lift',
        'danger-soft' => 'bg-white border-red-200 text-red-600 hover:bg-red-50 shadow-xs hover-lift',
        'subtle'      => 'bg-brand-50 border-transparent text-brand-800 hover:bg-brand-100 hover-lift',
    ];
    $sizes = [
        'sm' => 'text-sm px-3 py-1.5 [&_svg]:w-4 [&_svg]:h-4',
        'md' => 'text-sm px-4 py-2 [&_svg]:w-4 [&_svg]:h-4',
        'lg' => 'text-base px-5 py-2.5 [&_svg]:w-5 [&_svg]:h-5',
    ];
    $classes = $base . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>{{ $slot }}</button>
@endif
