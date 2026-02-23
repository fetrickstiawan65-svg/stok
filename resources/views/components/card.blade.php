@props(['title' => null, 'noPadding' => false])

<div {{ $attributes->merge(['class' => 'bg-white shadow-md rounded-lg overflow-hidden']) }}>
    @if($title)
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
        </div>
    @endif
    
    <div class="{{ $noPadding ? '' : 'p-6' }}">
        {{ $slot }}
    </div>
</div>
