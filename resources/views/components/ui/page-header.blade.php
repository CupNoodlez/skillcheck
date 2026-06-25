@props([
    'title' => '',
    'subtitle' => null,
])

<div {{ $attributes->merge(['class' => 'mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between']) }}>
    <div class="min-w-0">
        @isset($breadcrumb)
            <div class="mb-1.5">{{ $breadcrumb }}</div>
        @endisset
        <h1 class="text-xl font-semibold tracking-tight text-ink sm:text-2xl">{{ $title }}</h1>
        @if($subtitle)
            <p class="mt-1 text-sm text-muted">{{ $subtitle }}</p>
        @endif
    </div>
    @isset($actions)
        <div class="flex flex-wrap items-center gap-2 shrink-0">{{ $actions }}</div>
    @endisset
</div>
