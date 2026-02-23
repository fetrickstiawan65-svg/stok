@props(['message', 'icon' => null])

<div {{ $attributes->merge(['class' => 'rounded-lg p-4']) }}>
    <div class="flex items-start gap-3">
        @if($icon)
            <div class="flex-shrink-0">
                {!! $icon !!}
            </div>
        @endif
        <div class="flex-1">
            {{ $slot->isNotEmpty() ? $slot : $message }}
        </div>
    </div>
</div>
