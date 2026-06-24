@props([
    'user' => null,
    'size' => 'md', // xs | sm | md | lg | xl
])

@php
    $user = $user ?? auth()->user();
    $picture = $user?->profile_picture;
    $initial = strtoupper(substr($user->username ?? 'G', 0, 1));
    $sizes = [
        'xs' => 'w-7 h-7 text-[0.65rem]',
        'sm' => 'w-8 h-8 text-xs',
        'md' => 'w-10 h-10 text-sm',
        'lg' => 'w-14 h-14 text-lg',
        'xl' => 'w-28 h-28 text-4xl',
    ];
    $cls = $sizes[$size] ?? $sizes['md'];
@endphp

@if($picture)
    <img src="{{ asset('storage/' . $picture) }}" alt="{{ $user->username ?? 'User' }}"
        {{ $attributes->merge(['class' => "$cls rounded-full object-cover ring-2 ring-white shadow-sm"]) }}>
@else
    <span {{ $attributes->merge(['class' => "$cls rounded-full inline-flex items-center justify-center font-semibold text-white bg-linear-to-br from-brand-400 to-brand-700 ring-2 ring-white shadow-sm"]) }}>
        {{ $initial }}
    </span>
@endif
