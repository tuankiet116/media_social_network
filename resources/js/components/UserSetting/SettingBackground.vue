<template>
    <div v-if="user">
        <div class="field">
            <label class="label">{{ $t('user_setting.background.your_background') }}: </label>
            <div class="control is-grouped">
                <figure class="image">
                    <img class="background" :src="background" />
                </figure>
                <input
                    @change="previewImage"
                    ref="file_open"
                    class="is-hidden"
                    type="file"
                    accept="image/png, image/jpeg"
                />
                <button @click="openFileExplorer" class="button">
                    {{ $t('user_setting.background.change_background') }}
                </button>
            </div>
        </div>
        <div class="field is-grouped mt-3 columns is-justify-content-end">
            <button
                @click="saveBackground"
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
import { getProfile, saveUserBackground } from "../../api/user";
import LoadingComponent from "../Common/LoadingComponent.vue";
import { useToast } from "vue-toastification";

export default {
    components: { LoadingComponent },
    data() {
        return {
            user: null,
            background: null
        };
    },
    watch: {
        user(value) {
            this.background = value.banner;
        },
    },
    mounted() {
        this.getUserInformation();
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
        openFileExplorer() {
            this.$refs.file_open.click();
        },
        async chooseImageDefault(image) {
            let imageObject = new Image();
            imageObject.src = image;
            this.background = image;
            this.$refs.file_open.value = null;
        },
        previewImage($event) {
            this.background = URL.createObjectURL($event.target.files[0]);
        },
        saveBackground() {
            let form = new FormData();
            let _this = this;
            form.append('background', this.$refs.file_open.files[0] ?? "");

            saveUserBackground(form).then(result => {
                _this.$store.state.user = result.data;
                useToast().success(this.$t('user_setting.background.success_update'));
            }).catch((err) => {
                useToast().error(this.$t('user_setting.background.error_update'));
            });
        }
    },
};
</script>
<style scoped>

.background{
    height: 20rem !important;
    object-fit: cover;
    width: 50rem !important;
    border-radius: 0 0 20px 20px;
}

@media only screen and (max-width: 540px) {

    .background {
        height: 7rem !important;
        width: 14rem !important;
    }
}

@media only screen and (max-width: 320px) {
    .background{
        height: 5rem !important;
        width: 10rem !important;
    }
}
</style>
