@props(['label', 'value', 'accent' => 'blue'])

@php
    $accents = [
        'blue'   => ['bar' => 'bg-mauro-blue',   'chip' => 'bg-mauro-blue-light text-mauro-blue-dark'],
        'yellow' => ['bar' => 'bg-mauro-yellow', 'chip' => 'bg-mauro-yellow/15 text-mauro-yellow-dark'],
        'dark'   => ['bar' => 'bg-mauro-dark',   'chip' => 'bg-gray-100 text-mauro-dark'],
        'slate'  => ['bar' => 'bg-mauro-slate',  'chip' => 'bg-gray-100 text-mauro-slate'],
    ];
    $a = $accents[$accent] ?? $accents['blue'];
@endphp

<div class="relative overflow-hidden rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
    <span class="absolute inset-y-0 left-0 w-1 {{ $a['bar'] }}"></span>
    <div class="flex items-center justify-between">
        <div>
            <p class="text-3xl font-bold text-mauro-dark leading-none">{{ $value }}</p>
            <p class="mt-2 text-sm font-medium text-gray-500">{{ $label }}</p>
        </div>
        <span class="inline-flex h-11 w-11 items-center justify-center rounded-lg {{ $a['chip'] }}">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">{{ $icon }}</svg>
        </span>
    </div>
</div>
