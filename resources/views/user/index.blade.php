<x-app-layout>
    <div class="row">
        <x-slot:title>Users</x-slot>

        <user :roles="{{ json_encode(Auth::user()->role == 'legal-admin' ? USER_ROLES_LAWER : USER_ROLES) }}"></user>


    </div>
</x-app-layout>
