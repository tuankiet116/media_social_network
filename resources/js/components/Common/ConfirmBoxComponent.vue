<template>
    <div class="modal">
        <div class="modal-background"></div>
        <div class="modal-content" v-html="message">
        </div>
        <button class="modal-close is-large" aria-label="close"></button>
    </div>
</template>
<script>
    export default {
        props: ['message'],
        data() {
            return {
            }
        }
    }
</script>