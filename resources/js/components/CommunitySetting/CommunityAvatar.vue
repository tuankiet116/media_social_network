<template>
    <div v-if="community">
        <div class="field">
            <label class="label">{{ $t('community_setting.avatar.title') }}: </label>
            <div class="control is-grouped">
                <figure class="is-rounded image is-128x128">
                    <img class="is-rounded avatar" :src="avatar" />
                </figure>
                <input
                    @change="previewImage"
                    ref="file_open"
                    class="is-hidden"
                    type="file"
                    accept="image/png, image/jpeg"
                />
                <button @click="openFileExplorer" class="button">
                    {{ $t('community_setting.avatar.change_avatar') }}
                </button>
            </div>
        </div>
        <div class="field is-grouped mt-3 columns is-justify-content-end">
            <button
                @click="saveAvatar"
                class="button is-info is-1-desktop is-full-mobile"
            >
                {{ $t('save') }}
            </button>
        </div>
    </div>
    <div v-else>
        <LoadingComponent />
    </div>
</template>

<script>
import { updateCommunityAvatar } from "../../api/community";
import LoadingComponent from "../Common/LoadingComponent.vue";
import { useToast } from "vue-toastification";
export default {
    components: { LoadingComponent },
    props: ['community'],
    data() {
        return {
            avatar: null,
            defaults: [],
        };
    },
    watch: {
        community(value) {
            this.avatar = value.image;
        },
    },
    methods: {
        openFileExplorer() {
            this.$refs.file_open.click();
        },
        previewImage($event) {
            this.avatar = URL.createObjectURL($event.target.files[0]);
        },
        saveAvatar() {
            let form = new FormData();
            let _this = this;
            form.append('avatar', this.$refs.file_open.files[0] ?? "");

            updateCommunityAvatar(form, this.community.id).then(result => {
                this.$emit('updated', result.data);
            }).catch((error) => {
                useToast().error(this.$t('community_setting.avatar.success_update'));
            });
        }
    },
};
</script>
<style scoped>

.avatar {
    height: 120px;
    object-fit: cover;
}
</style>
