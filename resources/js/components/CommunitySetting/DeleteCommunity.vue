<template>
    <button class="button is-danger" :class="{ 'is-loading': loading }" @click="isShow = true">
        {{ $t('community_setting.delete') }}
    </button>
    <ConfirmDeleteComponent v-if="isShow" :message="messageConfirm" @confirm="handleConfirm" @cancel="hideConfirm" />
</template>
<script>
import ConfirmDeleteComponent from '../Common/ConfirmDeleteComponent.vue';
import { deleteCommunity } from '../../api/community';
import { useToast } from 'vue-toastification';
export default {
    components: { ConfirmDeleteComponent },
    props: ['community'],
    emits: ['updated'],
    data() {
        return {
            isShow: false,
            messageConfirm: this.$t('community_setting.delete_warning'),
            loading: false
        }
    },
    methods: {
        async handleConfirm() {
            this.loading = true;
            await deleteCommunity(this.community.id).then(result => {
                useToast().success(this.$t('community_setting.deleted'));
                this.$router.push({ name: "home" });
            }).catch(error => {
                useToast().error(this.$t('community_setting.deleted_fail'));
            });
            this.loading = false;
        },
        hideConfirm() {
            this.isShow = false;
        }
    }
}
</script>