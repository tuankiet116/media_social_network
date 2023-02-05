<template>
    <div class="box container">
        <div class="is-flex">
            <span class="is-size-3 has-text-left create_post_title">
                {{ $t("create_post.title") }}
            </span>
            <vue-select class="search_community" :options="communities" label="community_name"
                @search="fetchCommunities" @open="fetchCommunities" v-model="community">
                <template v-slot:option="option">
                    <div class="is-flex m-0 p-0">
                        <figure class="image is-32x32 m-0 p-0">
                            <img class="is-rounded m-0 p-0 avatar-image" :src="option.image" />
                        </figure>
                        <p class="ml-2">{{ option.community_name }}</p>
                    </div>
                </template>
            </vue-select>
        </div>

        <div class="field">
            <label class="label">{{ $t("create_post.post_desc") }}</label>
            <ckeditor ref="editor" class="input is-primary" :editor="editor" v-model="post.description"
                :config="editorConfig"></ckeditor>
            <p v-if="errors.description" class="help is-danger">
                {{ errors.description }}
            </p>
        </div>

        <div class="field" v-if="sharePost == null">
            <label class="label">{{ $t("create_post.post_video") }}</label>
            <div class="file is-large is-boxed" v-show="post.file == ''">
                <label class="file-label">
                    <input class="file-input" ref="video" type="file" accept="video/*"
                        @change="handleFileUpload($event)" />
                    <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label"> Upload Video </span>
                    </span>
                </label>
            </div>
            <div class="box video-preview-box has-text-centered" v-show="post.file != ''">
                <video ref="video_preview" id="video-preview" controls />
                <div class="has-text-right">
                    <button class="button is-info" @click="handleCancelVideo($event)">
                        {{ $t("create_post.cancel_video") }}
                    </button>
                </div>
            </div>
        </div>
        <PostShareComponent :post="sharePost"/>
        <div class="buttons is-right mt-5">
            <button class="button is-primary" :class="{ 'is-loading': isHandlePreview }"
                @click="handleUploadPost()">
                {{ $t("create_post.create") }}
            </button>
            <button class="button is-light">
                {{ $t("create_post.cancel") }}
            </button>
        </div>
    </div>
</template>
<script>
import { createPost, getPost } from "../../api/post";
import { useToast } from "vue-toastification";
import ClassicEditor from "../../../Libraries/CKEditor5/build/ckeditor";
import { getCommunitiesAPI } from "../../api/community";
import PostShareComponent from "./Children/SharePostComponent.vue";
export default {
    components: { PostShareComponent, PostShareComponent },
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
                description: "",
                file: "",
            },
            errors: {
                title: "",
                description: "",
                file: "",
            },
            communities: [],
            community: null,
            isHandlePreview: false,
            sharePost: null
        };
    },
    mounted() {
        if(this.$route.query.post && !isNaN(this.$route.query.post)) {
            this.getPost();
        }
    },
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
                _this.communities = result.data.flatMap(r => r.community ?? []);
            });
            if (loading) loading(false);
        },
        async previewVideo() {
            let video = this.$refs.video_preview;
            video.src = URL.createObjectURL(this.post.file);
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
            if (!this.post.description)
                this.errors.description = this.$t(
                    "create_post.validate_description"
                );
            else this.errors.description = "";
        },
        async handleUploadPost() {
            let form = new FormData();
            let _this = this;
            form.append("description", this.post.description);
            form.append("video", this.post.file);
            if (this.community) {
                form.append("community", this.community.id);
            }
            if (this.sharePost) {
                form.append("share", this.sharePost?.id);
            }
            form.append(
                "_token",
                document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content")
            );

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
                        if (progressEvent.loaded == 0) {
                            this.$router.push({ name: "home" });
                        }
                    },
                })
                    .then((result) => {
                        useToast().success(messageSuccess);
                        this.$router.push({ name: "home" });
                    })
                    .catch((err) => {
                        useToast().error(messageFailed);
                    })
                    .finally(() => {
                        _this.$store.state.postUploadProgress = 0;
                    });
            }
        },
        async getPost() {
            let idPost = this.$route.query.post;
            getPost(idPost).then(result => {
                if (result.data) {
                    this.sharePost = result.data;
                } else {
                    useToast().error(this.$t('post.error_get_post', {
                        position: "top-center",
                        hideProgressBar: true
                    }));
                    this.$router.push({ name: 'home' });
                }
            }).catch(result => {
                useToast().error(this.$t('post.error_get_post', {
                    position: "top-center",
                    hideProgressBar: true
                }));
                this.$router.push({ name: 'home' });
            });
        },
    },
};
</script>
<style scoped>
.container {
    margin: 5rem auto;
    background-color: white;
    border-radius: 20px;
    max-width: 800px !important;
}

@media screen and (min-device-width: 481px) and (max-device-width: 821px) {
    .container {
        margin: 0 !important;
    }
}

@media screen and (max-width: 480px) {
    .container {
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
