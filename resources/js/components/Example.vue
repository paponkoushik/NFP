<script setup>
import { useIsLoading } from "@/composables/useIsLoading.js";
import { useUrlFunc } from "@/composables/useUrlFunc.js";
import { useDemoStore } from "@/stores/DemoStore";
import { onMounted, reactive, ref } from "vue";

let { getUrlParams, buildURLQuery, buildQueryString } = useUrlFunc();

onMounted(() => {
    console.log("Hello World");

    console.log(getUrlParams("http://nfp.local/dashboard?name=abc&age=12"));
    console.log(
        buildURLQuery(
            { country: "BD" },
            "http://nfp.local/dashboard?name=abc&age=12"
        )
    );
    console.log(
        buildQueryString(
            { country: "BD" },
            "http://nfp.local/dashboard?name=abc&age=12"
        )
    );
    console.log("Query Params = ", buildURLQuery(getUrlParams()));
    console.log("isLoading: ", useIsLoading(true));

    flash("Working from composition API Component");
});

let message = ref("Hello world is ref");
// let message1 = $ref("Hello world is ref");

setTimeout(() => {
    message.value = "Ref updated!!";

    console.log(message);
}, 2500);

console.log(message);
console.log(message1);
setTimeout(() => {
    message1 =
        "You explicity avoid .value inside component using $ref raectitity transform";
}, 1500);

// use pinia
let demoStore = useDemoStore();
demoStore.fill();

// Form
let form = reactive({
    name: "test",
    age: "",
});
</script>

<template>
    <h3>Vue3 Inline template no longer available...</h3>
    <input type="text" class="form-control w-50" v-model="message" />
    <p>{{ message }}</p>
    <h3>Using Ref raectivity transform</h3>
    <input type="text" class="form-control w-50" v-model="message1" />
    <p>{{ message1 }}</p>

    <h3>Use State Management using Pinia</h3>
    <span class="badge bg-primary">Total Item: {{ demoStore.totalItems }}</span>
    <a
        href="javascript:"
        class="badge bg-warning ms-2 cursor"
        @click="
            demoStore.addItems(2, {
                id: null,
                name: 'New Item',
                status: 'active',
            })
        "
        >Add Item</a
    >
    <ul>
        <li v-for="item in demoStore.items" :key="item.id">
            {{ item.name }}
        </li>
    </ul>

    <VField
        v-model="form.name"
        name="form.name"
        type="text"
        placeholder="Who are you"
        rules="required"
    ></VField>
    <slot></slot>
</template>
