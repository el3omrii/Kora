@props(['active'])

@php
$classes = ($active ?? false)
            ? 'py-2.5 px-4 flex items-center space-x-2 hover:bg-gray-800 hover:text-white rounded border-b-2 border-indigo-400 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out bg-gray-800 text-white'
            : 'py-2.5 px-4 flex items-center space-x-2 hover:bg-gray-800 hover:text-white rounded focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
@endphp

<!-- BASIC LINK -->
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>