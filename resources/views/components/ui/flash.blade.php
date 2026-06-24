{{-- Reusable flash + validation messages (Tailwind + Alpine dismiss) --}}
@php
    $alerts = [];
    if (session('success')) $alerts[] = ['tone' => 'green', 'icon' => 'check-circle', 'text' => session('success')];
    if (session('error'))   $alerts[] = ['tone' => 'red',   'icon' => 'alert-triangle', 'text' => session('error')];
    $tones = [
        'green' => 'bg-green-50 border-green-200 text-green-800 [&_svg]:text-green-600',
        'red'   => 'bg-red-50 border-red-200 text-red-800 [&_svg]:text-red-600',
        'amber' => 'bg-amber-50 border-amber-200 text-amber-800 [&_svg]:text-amber-600',
    ];
@endphp

@foreach($alerts as $a)
    <div x-data="{ show: true }" x-show="show" x-transition
         class="mb-4 flex items-start gap-3 rounded-xl border px-4 py-3 text-sm {{ $tones[$a['tone']] }}">
        <x-icon :name="$a['icon']" class="w-5 h-5 mt-0.5 shrink-0" />
        <div class="flex-1">{{ $a['text'] }}</div>
        <button type="button" @click="show=false" class="shrink-0 opacity-60 hover:opacity-100"><x-icon name="x" class="w-4 h-4" /></button>
    </div>
@endforeach

@if($errors->any())
    <div x-data="{ show: true }" x-show="show"
         class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
        <div class="flex items-center gap-2 font-semibold">
            <x-icon name="alert-triangle" class="w-5 h-5 text-red-600" /> Please fix the following:
            <button type="button" @click="show=false" class="ml-auto opacity-60 hover:opacity-100"><x-icon name="x" class="w-4 h-4" /></button>
        </div>
        <ul class="mt-2 ml-7 list-disc space-y-0.5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
