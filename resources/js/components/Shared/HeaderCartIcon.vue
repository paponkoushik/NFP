<script setup>
    import { onMounted } from 'vue';
    import { useDocumentStore } from "@/stores/DocumentStore";

    const store = useDocumentStore();

    onMounted(async () =>{
        await store.getCartItems()
    })
</script>

<template>
    <li class="nav-item me-2 me-xl-0 dropdown-notifications navbar-dropdown me-3 me-xl-1">
        <a class="nav-link hide-arrow"
            href="/checkout"
            data-bs-auto-close="outside"
            aria-expanded="false"
            data-bs-toggle="tooltip"
            data-bs-offset="0,4"
            data-bs-placement="bottom"
            data-bs-html="true"
            data-bs-original-title="Cart"
        >
            <i class="bx bx-cart bx-sm"></i>
            <span v-if="store.cartItems?.length > 0"
                  class="badge bg-danger rounded-pill badge-notifications" style="top: auto">{{ store.cartItems.length }}</span>
        </a>
    </li>
</template>
