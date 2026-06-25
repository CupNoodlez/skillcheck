@props([
    'align' => 'right', // right | left
    'width' => 'w-56',
])

<div x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false" {{ $attributes->merge(['class' => 'relative']) }}>
    <div @click="open = !open" class="contents">{{ $trigger }}</div>

    <div x-show="open" x-cloak
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="absolute z-40 mt-2 {{ $width }} {{ $align === 'right' ? 'right-0 origin-top-right' : 'left-0 origin-top-left' }} rounded-xl border border-line bg-white p-1.5 shadow-pop">
        {{ $slot }}
    </div>
</div>
