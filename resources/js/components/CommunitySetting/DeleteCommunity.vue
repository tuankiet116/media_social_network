<template>
    <button class="button is-danger" @click="isShow = true">
        {{ $t('community_setting.delete') }}
    </button>
    <ConfirmDeleteComponent v-if="isShow" :message="messageConfirm"
        @confirm="handleConfirm" @cancel="hideConfirm" />
</template>
<script>
import ConfirmDeleteComponent from '../Common/ConfirmDeleteComponent.vue';
export default {
    components: { ConfirmDeleteComponent },
    props: ['community'],
    emits: ['updated'],
    data() {
        return {
            isShow: false,
            messageConfirm: this.$t('community_setting.delete_warning')
        }
    },
    methods: {
        handleConfirm() {

        },
        hideConfirm() {
            this.isShow = false;
        }
    }
}
</script>