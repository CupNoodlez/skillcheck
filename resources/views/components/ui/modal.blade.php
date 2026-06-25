@props([
    'title' => null,
    'size' => 'max-w-lg',
])

{{-- Usage:
    <x-ui.modal title="Import">
        <x-slot:trigger>
            <x-ui.button>Open</x-ui.button>
        </x-slot:trigger>
        ...body...
    </x-ui.modal>
--}}
<div x-data="{ open: false }" @keydown.escape.window="open = false" class="inline">
    @isset($trigger)
        <div @click="open = true" class="contents">{{ $trigger }}</div>
    @endisset

    <template x-teleport="body">
        <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto p-4 sm:p-6">
            <div x-show="open" x-transition.opacity @click="open = false"
                 class="fixed inset-0 bg-gray-900/40 backdrop-blur-[1px]"></div>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-[0.99]"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 class="relative w-full {{ $size }} my-8 rounded-2xl bg-white shadow-lg ring-1 ring-line">
                <div class="flex items-center justify-between gap-4 border-b border-line px-5 py-4">
                    <h3 class="text-base font-semibold text-ink">{{ $title }}</h3>
                    <button type="button" @click="open = false" class="text-faint hover:text-ink transition">
                        <x-icon name="x" class="w-5 h-5" />
                    </button>
                </div>
                <div class="px-5 py-5 sc-scroll max-h-[70vh] overflow-y-auto">
                    {{ $slot }}
                </div>
                @isset($footer)
                    <div class="flex items-center justify-end gap-2 border-t border-line px-5 py-4">
                        {{ $footer }}
                    </div>
                @endisset
            </div>
        </div>
    </template>
</div>
