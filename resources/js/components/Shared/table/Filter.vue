<script setup>
    import { ref } from "vue";
    import { debounce } from "lodash";

    defineProps({
        totalItem: {
            type: Number,
            default: 0
        },

        limits: {
            type: Array,
            default: () => [10, 20, 50, 100]
        },
    });

    const emit = defineEmits(['event-action']);

    let search = ref('');

    const handleSearch = debounce(function (e) {
        const currentStr = e.target.value;
        const prevStr = search.value;
        
        if ((prevStr == "" || currentStr === prevStr) && (currentStr.length < 1 || currentStr === prevStr || currentStr.replace(/\s/g, "") == "")) {
            return;
        }
        search = currentStr;
       
        emit('event-action', 'query', currentStr);
    }, 500);
</script>

<template>
    <div class="d-flex justify-content-between align-items-center row">
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_length" id="DataTables_Table_0_length">
                <label v-if="totalItem > 10">
                    Show
                    <select
                        name="dt_length"
                        aria-controls="DataTables_Table_0" 
                        class="form-select form-select-sm"
                        @change="$emit('event-action', 'limit', $event.target.value)"
                    >
                        <option v-for="limit in limits" :value="limit" :key="limit" v-text="limit"></option>
                    </select>
                    entries
                </label>
            </div>
        </div>

        <slot></slot>

        <div
            class="col-sm-12 col-md-6"
            v-if="search || totalItem > 1"
        >
            <div id="DataTables_Table_0_filter" class="dataTables_filter">
                <label>
                    Search:
                    <input
                        type="search"
                        @keyup="handleSearch"
                        @click="handleSearch"
                        class="form-control form-control-sm"
                        aria-controls="DataTables_Table_0"
                        placeholder="Search.."
                    />
                </label>
            </div>
        </div>
    </div>
</template>
