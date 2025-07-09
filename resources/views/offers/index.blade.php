<x-app-layout>
<div class="row">
    <x-slot:title>Offers</x-slot>
    
    <div class="col-12">
        <div class="card">
            <x-datatable>
                <x-card-header title="Offers List">                    
                    <x-dropdown label="Filter" class="py-0" icon group>
                        <x-dropdown-link>Best Offer</x-dropdown-link>
                        <x-dropdown-link>Recent Offer</x-dropdown-link>
                    </x-dropdown>
                </x-card-header>

                <x-table.filter />                                 

                <x-slot:head>
                    <x-table.heading sortable multi-column >Post</x-table.heading>
                    <x-table.heading sortable multi-column >Offer</x-table.heading>
                    <x-table.heading sortable multi-column >Offer Amount</x-table.heading>
                    <x-table.heading sortable multi-column>Status</x-table.heading>
                    <x-table.heading class="text-end">Actions</x-table.heading>
                </x-slot>

                <x-slot:body wire:loading.class="loader">
                    @forelse ($offers as $offer)
                        <x-table.row>
                            <x-table.cell>
                                <div class="d-flex flex-column">
                                    <span class="emp_name text-truncate">{{ $offer['post'] }}</span>
                                    <small class="emp_post text-truncate text-muted">
                                        Web & Development <small>></small> Software Engineer
                                    </small>
                                </div>
                            </x-table.cell>
                            <x-table.cell>{{ $offer['name'] }}</x-table.cell>
                            <x-table.cell>
                                <span class="badge bg-label-info">${{ rand(100, 999) }}</span>
                            </x-table.cell>
                            <x-table.cell>
                                <span class="badge bg-label-success">Active</span>
                            </x-table.cell>
                            <x-table.cell>
                                <x-dropdown>
                                    <x-dropdown-link>Details</x-dropdown-link>
                                    <x-dropdown-link>Delete</x-dropdown-link>
                                </x-dropdown>
                            </x-table.cell>
                        </x-table.row>
                    @empty
                        <x-table.row>
                            <x-table.cell colspan="7">
                                <div class="d-flex justify-content-center align-items-center">
                                    <span class="font-medium py-8 text-cool-gray-400 text-xl">No offers found...</span>
                                </div>
                            </x-table.cell>
                        </x-table.row>
                    @endforelse
                </x-slot>

                {{-- <x-slot:footer>
                    {{ $offers->links() }}               
                </x-slot> --}}
            </x-datatable>
        </div>
    </div>
</div>
</x-app-layout>