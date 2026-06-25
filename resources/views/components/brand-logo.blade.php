@props([
    'variant' => 'wide', // wide | square
    'height' => 36,
    'alt' => 'SkillCheck',
])

@php
    $src = $variant === 'square'
        ? asset('images/logo_skillcheck_square.png')
        : asset('images/logo_skillcheck_wide.png');
@endphp

<img
    src="{{ $src }}"
    alt="{{ $alt }}"
    {{ $attributes->merge(['class' => 'd-inline-block align-middle']) }}
    style="height: {{ $height }}px; width: auto;"
>
