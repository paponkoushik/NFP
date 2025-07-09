@props(['src' => asset('assets/img/logo-dark.png'), 'height' => '90px'])

<img src="{{ $src }}" style="height: {{ $height }};" {{ $attributes }} alt="Logo" />