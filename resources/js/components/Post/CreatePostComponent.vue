<template>
    <div class="box container">
        <div class="is-flex">
            <span class="is-size-3 has-text-left create_post_title">
                {{ $t("create_post.title") }}
            </span>
            <vue-select
                class="search_community"
                :options="communities"
                label="community_name"
                @search="fetchCommunities"
                @open="fetchCommunities"
                v-model="community"
            >
                <template v-slot:option="option">
                    <div class="is-flex m-0 p-0">
                        <figure class="image is-32x32 m-0 p-0">
                            <img class="is-rounded m-0 p-0" :src="option.image"/>
                        </figure>
                        <p class="ml-2">{{ option.community_name }}</p>
                    </div>
                </template>
            </vue-select>
        </div>
        <div class="field">
            <label class="label">{{ $t("create_post.post_title") }}</label>
            <input class="input is-primary" v-model="post.title" type="text" />
            <p v-if="errors.title" class="help is-danger">{{ errors.title }}</p>
        </div>

        <div class="field">
            <label class="label">{{ $t("create_post.post_desc") }}</label>
            <ckeditor
                ref="editor"
                class="input is-primary"
                :editor="editor"
                v-model="post.description"
                :config="editorConfig"
            ></ckeditor>
            <p v-if="errors.description" class="help is-danger">
                {{ errors.description }}
            </p>
        </div>

        <div class="field">
            <label class="label">{{ $t("create_post.post_video") }}</label>
            <div class="file is-large is-boxed" v-show="post.file == ''">
                <label class="file-label">
                    <input
                        class="file-input"
                        ref="video"
                        type="file"
                        accept="video/*"
                        @change="handleFileUpload($event)"
                    />
                    <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label"> Upload Video </span>
                    </span>
                </label>
            </div>
            <div
                class="box video-preview-box has-text-centered"
                v-show="post.file != ''"
            >
                <video id="video-preview" controls />
                <div class="has-text-right">
                    <button
                        class="button is-info"
                        @click="handleCancelVideo($event)"
                    >
                        {{ $t("create_post.cancel_video") }}
                    </button>
                </div>
            </div>
            <div class="buttons is-right mt-5">
                <button class="button is-primary" @click="handleUploadPost()">
                    {{ $t("create_post.create") }}
                </button>
                <button class="button is-light">
                    {{ $t("create_post.cancel") }}
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import { createPost } from "../../api/post";
import { useToast } from "vue-toastification";
import ClassicEditor from "../../../Libraries/CKEditor5/build/ckeditor";
import authMixin from "../../mixins";
import { getCommunitiesAPI } from "../../api/community";
export default {
    mixins: [authMixin],
    data() {
        return {
            editor: ClassicEditor,
            editorConfig: {
                ckfinder: {
                    uploadUrl:
                        "/api/ckfinder/upload?_token=" +
                        document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    options: {
                        resourceType: "Images",
                    },
                },
                image: {
                    resizeUnit: "px",
                    resizeOptions: [
                        {
                            name: "resizeImage:original",
                            label: "Original",
                            value: null,
                        },
                        {
                            name: "resizeImage:100",
                            label: "100px",
                            value: "100",
                        },
                        {
                            name: "resizeImage:200",
                            label: "200px",
                            value: "200",
                        },
                    ],
                },
            },
            post: {
                title: "",
                description: "",
                file: "",
            },
            errors: {
                title: "",
                description: "",
                file: "",
            },
            communities: [],
            community: null
        };
    },
    mounted() {},
    computed: {
        user() {
            let user = this.$store.getters.getUser;
            if (user == null) {
                this.$router.push({ name: "home" });
            }
            return user;
        },
    },
    methods: {
        async fetchCommunities(search, loading) {
            let _this = this;
            if (loading) loading(true);
            let data = {
                search: search ?? '',
            };
            await getCommunitiesAPI(data).then(function (result) {
                _this.communities = result.data.flatMap(r => r.community??[]);
            });
            if (loading) loading(false);
        },
        previewVideo() {
            let video = document.getElementById("video-preview");
            let reader = new FileReader();

            reader.readAsDataURL(this.post.file);
            reader.addEventListener("load", function () {
                video.src = reader.result;
            });
        },
        handleFileUpload(event) {
            this.post.file = event.target.files[0];
            this.previewVideo();
        },
        handleCancelVideo(event) {
            this.post.file = "";
            this.$refs.video.value = null;
        },
        validateData() {
            if (!this.post.title)
                this.errors.title = this.$t("create_post.validate_title");
            else this.errors.title = "";
            if (!this.post.description)
                this.errors.description = this.$t(
                    "create_post.validate_description"
                );
            else this.errors.description = "";
        },
        async handleUploadPost() {
            let form = new FormData();
            var _this = this;
            form.append("title", this.post.title);
            form.append("description", this.post.description);
            form.append("video", this.post.file);
            form.append(
                "_token",
                document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")
            );
            form.append("community", this.community?.id ?? 0);

            this.validateData();
            if (!this.errors.title && !this.errors.description) {
                let messageSuccess = this.$t("create_post.success");
                let messageFailed = this.$t("create_post.failed");

                await createPost(form, {
                    header: { "Contect-type": "multipart/form-data" },
                    onUploadProgress: (progressEvent) => {
                        let progress = Math.round(
                            (progressEvent.loaded * 100) / progressEvent.total
                        );
                        _this.$store.state.postUploadProgress = progress;
                        this.$router.push({ name: "home" });
                    },
                })
                    .then((result) => {
                        useToast().success(messageSuccess);
                    })
                    .catch((err) => {
                        useToast().error(messageFailed);
                    })
                    .finally(() => {
                        _this.$store.state.postUploadProgress = 0;
                    });
            }
        },
    },
};
</script>
<style scoped>
.container {
    margin: 10rem 20rem;
    background-color: whitesmoke;
    max-width: none !important;
}

@media screen and (min-device-width: 481px) and (max-device-width: 768px) {
    .container {
        margin: 5rem 2rem !important;
    }
}

@media screen and (max-width: 480px) {
    .container {
        margin: 4rem 0 4rem 0 !important;
        padding: 30px 10px;
    }

    .create_post_title {
        font-size: 20px !important;
    }
}

.file-label {
    width: 100%;
    text-align: center;
}

.video-preview-box {
    max-height: 500px;
}

video {
    max-width: 100%;
    max-height: 300px;
    width: auto;
}

.search_community {
    width: 150px;
    margin-left: auto;
}
</style>
