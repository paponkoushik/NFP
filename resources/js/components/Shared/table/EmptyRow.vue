<script setup>
    defineProps({
        colspan: {
            type: [String, Number],
            default: 0
        },

        msg: {
            default: 'Result not found!'
        }
    });
</script>

<template>
    <Row class="bg-lighter">
        <Cell class="border-0" :colspan="colspan">
            <div class="d-flex flex-column justify-content-center align-items-center pb-5 pt-3">
                <img src="/assets/img/empty-folder.png" alt="EMPTY RESULT" class="w-px-150">
                <span class="font-medium fw-semibold py-8 text-cool-gray-400 text-uppercase text-xl">{{ msg }}</span>
            </div>
        </Cell>
    </Row>
</template>