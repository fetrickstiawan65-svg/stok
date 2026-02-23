@props(['color' => 'gray', 'size' => 'md'])

@php
$colors = [
    'gray' => 'bg-gray-100 text-gray-800',
    'blue' => 'bg-blue-100 text-blue-800',
    'red' => 'bg-red-100 text-red-800',
    'green' => 'bg-green-100 text-green-800',
    'yellow' => 'bg-yellow-100 text-yellow-800',
    'primary' => 'bg-primary-100 text-primary-800',
    'accent' => 'bg-accent-100 text-accent-800',
];

$sizes = [
    'sm' => 'px-2 py-0.5 text-xs',
    'md' => 'px-2.5 py-1 text-sm',
    'lg' => 'px-3 py-1.5 text-base',
];

$classes = 'inline-flex items-center rounded-full font-medium ' . ($colors[$color] ?? $colors['gray']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
