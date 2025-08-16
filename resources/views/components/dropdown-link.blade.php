@props(['href', 'method' => 'GET'])

@php
    $attributes = $attributes->merge(['class' => 'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out']);
@endphp

@if ($method === 'GET')
    <a href="{{ $href }}" {{ $attributes }}>
        {{ $slot }}
    </a>
@else
    <form method="POST" action="{{ $href }}">
        @csrf
        @if ($method !== 'POST')
            @method($method)
        @endif

        <a href="{{ $href }}" {{ $attributes }}
                onclick="event.preventDefault();
                            this.closest('form').submit();">
            {{ $slot }}
        </a>
    </form>
@endif
    