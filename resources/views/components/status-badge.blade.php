@props(['variant' => 'neutral'])

@php
    $classes = [
        'neutral' => 'bg-slate-100 text-slate-700 ring-slate-200',
        'amber' => 'bg-amber-100 text-amber-800 ring-amber-200',
        'green' => 'bg-emerald-100 text-emerald-800 ring-emerald-200',
        'sky' => 'bg-sky-100 text-sky-800 ring-sky-200',
        'red' => 'bg-rose-100 text-rose-800 ring-rose-200',
    ][$variant] ?? 'bg-slate-100 text-slate-700 ring-slate-200';
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset '.$classes]) }}>
    {{ $slot }}
</span>
