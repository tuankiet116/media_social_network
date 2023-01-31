<template>
    <div v-if="user">
        <div class="field">
            <label class="label">{{ $t('user_setting.avatar.your_avatar') }}: </label>
            <div class="control is-grouped">
                <figure class="is-rounded image is-128x128">
                    <img class="is-rounded avatar" :src="avatar" />
                </figure>
                <input @change="previewImage" ref="file_open" class="is-hidden" type="file"
                    accept="image/png, image/jpeg" />
                <button @click="openFileExplorer" class="button">
                    {{ $t('user_setting.avatar.change_avatar') }}
                </button>
            </div>
        </div>
        <div v-if="defaults" class="content">
            <hr />
            <h6 class="has-text-centered">{{ $t('user_setting.avatar.or_choose_default') }}</h6>
        </div>
        <div class="columns is-centered">
            <div v-for="(image, index) in defaults" class="m-2 image-default-container">
                <div v-if="avatar == image" class="image-tick">
                    <img class="is-rounded" src="/images/defaults/tick_image.png" />
                </div>
                <figure class="is-rounded image is-128x128 default-image" @click="chooseImageDefault(image)">
                    <img class="is-128x128" :src="image" />
                </figure>
            </div>
        </div>
        <div class="field is-grouped mt-3 columns is-justify-content-end">
            <button @click="saveAvatar" class="button is-info is-1-desktop is-full-mobile">
                {{ $t('save') }}
            </button>
        </div>
    </div>
    <div v-else>
        <LoadingComponent />
    </div>
</template>

<script>
import { getProfile, listDefaultAvatar, saveUserImage } from "../../api/user";
import LoadingComponent from "../Common/LoadingComponent.vue";
import { useToast } from "vue-toastification";
export default {
    components: { LoadingComponent },
    data() {
        return {
            user: null,
            avatar: null,
            defaults: [],
        };
    },
    watch: {
        user(value) {
            this.avatar = value.image;
        },
    },
    mounted() {
        this.getUserInformation();
        this.getAvatarDefault();
    },
    methods: {
        getUserInformation() {
            getProfile()
                .then((result) => {
                    this.user = result.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getAvatarDefault() {
            listDefaultAvatar().then((result) => {
                this.defaults = result.data;
            });
        },
        openFileExplorer() {
            this.$refs.file_open.click();
        },
        async chooseImageDefault(image) {
            let imageObject = new Image();
            imageObject.src = image;
            this.avatar = image;
            this.$refs.file_open.value = null;
        },
        previewImage($event) {
            this.avatar = URL.createObjectURL($event.target.files[0]);
        },
        saveAvatar() {
            let form = new FormData();
            let fileNameDefault = this.avatar.split('/')[this.avatar.split('/').length - 1];
            let _this = this;

            form.append('default', fileNameDefault);
            form.append('avatar', this.$refs.file_open.files[0] ?? "");

            saveUserImage(form).then(result => {
                _this.$store.state.user = result.data;
                useToast().success(this.$t('user_setting.avatar.success_update'));
            }).catch((error) => {
                useToast().error(this.$t('user_setting.avatar.error_update'));
            });
        }
    },
};
</script>
<style scoped>
.image-default-container {
    position: relative;
}

.default-image {
    cursor: pointer;
}

.image-tick {
    position: absolute;
    width: 50%;
    height: 50%;
    top: -1rem;
    right: -1rem;
}

.avatar {
    height: 120px;
    object-fit: cover;
}
</style>
