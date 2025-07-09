<script setup>
    defineProps({
        tableClass: {
            type: String,
        },

        theadClass: {
            type: String,
        },

        tbodyClass: {
            type: String,
        },
    })
</script>

<template>
    <div class="card-datatable table-responsive pt-0 pb-0">
        <div class="dataTables_wrapper dt-bootstrap5 no-footer">
            <!-- header & filter content goes here -->
            <slot></slot>

            <table
                :class="`datatables-basic table border-top dataTable no-footer dtr-column ${tableClass}`"
            >
                <thead :class="`datatables-basic table border-top dataTable no-footer dtr-column ${theadClass}`">
                    <tr>
                        <!-- table head goes here -->
                        <slot name="head"></slot>
                    </tr>
                </thead>

                <tbody :class="`divide-y divide-cool-gray-200 ${tbodyClass}`">
                    <!-- table body goes here -->
                    <slot name="body"></slot>
                </tbody>
            </table>

            <!-- pagination content goes here -->
            <slot name="footer"></slot>
        </div>
    </div>
</template>
