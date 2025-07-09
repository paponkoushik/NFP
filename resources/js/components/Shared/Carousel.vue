<script setup>
    import { onMounted, ref, nextTick } from 'vue';
    import Flickity from 'flickity';
    import 'flickity-fullscreen';

    const props = defineProps({
        wraparound: { default: true },
        autoplay: { default: false },
        lazyload: { default: true },
        fullscreen: { default: true },
        fade: { default: true },
        prevNextButtons: { default: true },
    });

    const el = ref(null);

    onMounted(async () => {
        await nextTick();

        new Flickity(el.value, {
            groupCells: true,
            pageDots: false,
            //wrapAround: this.wraparound,
            //autoPlay: this.autoplay,
            cellAlign: 'left',
            fullscreen: props.fullscreen,
            lazyLoad: props.lazyload,
            fade: props.fade,
            //contain: true,
            prevNextButtons: props.prevNextButtons,
        });
    });
</script>

<template>
    <div ref="el">
        <slot></slot>
    </div>
</template>