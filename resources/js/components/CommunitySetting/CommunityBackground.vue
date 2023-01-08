<template>
    <div v-if="community">
        <div class="field">
            <label class="label">Your Background: </label>
            <div class="control is-grouped">
                <figure class="image">
                    <img class="background" :src="background" />
                </figure>
                <input @change="previewImage" ref="file_open" class="is-hidden" type="file"
                    accept="image/png, image/jpeg" />
                <button @click="openFileExplorer" class="button">
                    Change Background
                </button>
            </div>
        </div>
        <div class="field is-grouped mt-3 columns is-justify-content-end">
            <button @click="saveBackground" class="button is-info is-1-desktop is-full-mobile">
                Save
            </button>
        </div>
    </div>
    <div v-else>
        <LoadingComponent />
    </div>
</template>

<script>
import { updateCommunityBackground } from "../../api/community";
import LoadingComponent from "../Common/LoadingComponent.vue";
import { useToast } from "vue-toastification";

export default {
    components: { LoadingComponent },
    props: ['community'],
    data() {
        return {
            user: null,
            background: null
        };
    },
    watch: {
        community(value) {
            this.background = value.background;
        },
    },
    methods: {
        openFileExplorer() {
            this.$refs.file_open.click();
        },
        previewImage($event) {
            this.background = URL.createObjectURL($event.target.files[0]);
        },
        saveBackground() {
            let form = new FormData();
            form.append('background', this.$refs.file_open.files[0] ?? "");

            updateCommunityBackground(form, this.community.id).then(result => {
                this.$emit('updated', result.data);
            }).catch((err) => {
                useToast().error('Error on updating background image');
            });
        }
    },
};
</script>
<style scoped>
.background {
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
    .background {
        height: 5rem !important;
        width: 10rem !important;
    }
}
</style>
