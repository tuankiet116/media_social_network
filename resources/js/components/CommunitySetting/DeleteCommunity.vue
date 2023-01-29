<template>
    <button class="button is-danger" @click="isShow = true">
        Delete Community
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
            messageConfirm: 'If you delete this community, all of the post will be deleted and could be revert. Are you sure?'
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