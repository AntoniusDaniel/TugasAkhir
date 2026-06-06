@props(['messages'])

@if ($messages)
    <p {{ $attributes->merge(['class' => 'mt-1 text-sm text-rose-600']) }}>{{ $messages[0] }}</p>
@endif
