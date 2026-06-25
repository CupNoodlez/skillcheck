@props([
    'href' => null,
    'danger' => false,
])

@php
    $cls = 'flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm transition-colors [&_svg]:w-4 [&_svg]:h-4 '
        . ($danger ? 'text-red-600 hover:bg-red-50' : 'text-gray-700 hover:bg-subtle hover:text-ink');
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $cls]) }}>{{ $slot }}</a>
@else
    <button type="button" {{ $attributes->merge(['class' => $cls]) }}>{{ $slot }}</button>
@endif
