@props([
    'icon' => 'layers',
    'title' => 'Nothing here yet',
    'message' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center text-center px-6 py-14']) }}>
    <span class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-subtle text-faint mb-4">
        <x-icon :name="$icon" class="w-6 h-6" />
    </span>
    <h3 class="text-sm font-semibold text-ink">{{ $title }}</h3>
    @if($message)
        <p class="mt-1 text-sm text-muted max-w-sm">{{ $message }}</p>
    @endif
    @if(isset($action))
        <div class="mt-5">{{ $action }}</div>
    @endif
</div>
