@props([
    'header',
    'p',
    'pre' => false, // when true, render <pre> wrapper (for whitespace-preserving fields)
    'colspan' => '' // allow setting column span classes like 'md:col-span-2'
])

<div {{ $attributes->merge(['class' => "bg-gray-100 dark:bg-gray-600 p-3 rounded {$colspan}"]) }}>
    <h4 class="font-semibold text-gray-700 dark:text-gray-300">{{ $header }}</h4>
    @if($pre)
        <p class="text-gray-900 dark:text-gray-100 whitespace-pre-line">{{ $p }}</p>
    @else
        <p class="text-gray-900 dark:text-gray-100">{{ $p }}</p>
    @endif
</div>
