<template>
    <div id="modal-js" class="modal is-active">
        <div class="modal-background" @click="closeModal"></div>

        <div class="modal-content">
            <div class="box">
                <p>{{ message }}</p>
                <div class="buttons is-justify-content-center">
                    <button class="button is-primary" @click="handleConfirm">OK</button>
                    <button class="button" @click="closeModal">{{ $t('cancel') }}</button>
                </div>
            </div>
        </div>

        <button class="modal-close is-large" aria-label="close" @click="closeModal"></button>
    </div>
</template>
<script>
export default {
    props: ['message'],
    data() {
        return {
        }
    },
    methods: {
        closeModal() {
            this.$emit('cancel')
        },
        handleConfirm() {
            this.$emit('confirm');
        }
    }
}
</script>