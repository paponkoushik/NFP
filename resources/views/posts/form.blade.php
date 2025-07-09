<x-app-layout>
    @php
        $post = $post ?? null;
        $title = $post ? 'Post Edit' : 'Post Create';
    @endphp

    <x-slot:title>{{ $title }}</x-slot>

    <post-form
        :post="{{ json_encode($post) }}"
        :types="{{ json_encode(postTypes()) }}"
        :locations="{{ json_encode($locations) }}"
        :categories="{{ json_encode($categories) }}"
    ></post-form>
</x-app-layout>
