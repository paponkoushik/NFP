<x-app-layout>
    <div class="row">
        <x-slot:title>Legal Requests</x-slot>
        
        <legal-request :can="@js($can)" :statuses="@js($statuses)"></legal-request>
    </div>
</x-app-layout>