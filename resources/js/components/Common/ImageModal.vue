<template>
    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-content">
            <p class="image is-4by3">
                <img @scroll="zoomImage($event)" :src="image">
            </p>
        </div>
        <button class="modal-close is-large" @click="closeHandle" aria-label="close"></button>
    </div>
</template>
<script>
export default {
    props: ['image'],
    data() {
        return {}
    },
    methods: {
        closeHandle() {
            this.$emit('close');
        },
        zoomImage(event) {
            debugger
        }
    }
}
</script>