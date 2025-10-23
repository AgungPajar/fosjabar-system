@props(['name', 'class' => 'h-5 w-5'])

@php
    $icons = [
        'home' => 'fa-solid fa-house',
        'users' => 'fa-solid fa-users',
        'newspaper' => 'fa-regular fa-newspaper',
        'plus' => 'fa-solid fa-plus',
        'tag' => 'fa-solid fa-tag',
    ];

    $iconClass = $icons[$name] ?? 'fa-solid fa-circle';
@endphp

<span class="inline-flex items-center justify-center {{ $class }}" {{ $attributes }}>
    <i class="fa-fw {{ $iconClass }}"></i>
</span>
