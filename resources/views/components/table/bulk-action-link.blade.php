<x-dropdown-link {{ $attributes->merge(['class' => 'text-uppercase']) }} wire:click="$emit('swalConfirm', 'bulk-delete', 'deleteSelected', 'Yes, delete it!', 'This action is irreversible.')">
    <i class="bx bx-trash align-text-bottom"></i> Delete
</x-dropdown-link>