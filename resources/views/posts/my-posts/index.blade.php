<x-app-layout>
    <x-slot:title>Our Posts</x-slot>

    <post title="Our Posts" user_id="{{ auth()->user()->id }}"></post>
</x-app-layout>
