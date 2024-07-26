@props(['value'])

<span {{ $attributes->merge(['class' => '']) }}>
    {{ $value ?? $slot }}
</span>
