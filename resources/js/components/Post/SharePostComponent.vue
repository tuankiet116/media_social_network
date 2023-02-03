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
            <label class="label">{{ $t("create_post.post_title") }}</label>
            <input class="input is-primary" v-model="post.title" type="text" />
            <p v-if="errors.title" class="help is-danger">{{ errors.title }}</p>
        </div>

        <div class="field">
            <label class="label">{{ $t("create_post.post_desc") }}</label>
            <ckeditor ref="editor" class="input is-primary" :editor="editor" v-model="post.description"
                :config="editorConfig"></ckeditor>
            <p v-if="errors.description" class="help is-danger">
                {{ errors.description }}
            </p>
        </div>
        <div class="is-rounded box share-post" v-if="sharePost">
            <div class="title">
                <strong>{{ sharePost.title }}</strong>
            </div>
            <div class="post-desc" ref="desc" @click="handleClick($event)" v-html="sharePost.post_description"></div>
            <div class="has-text-centered">
                <video v-if="sharePost.src" width="800" controls>
                    <source :src="'/api/post/stream/' + sharePost.src" type="video/mp4" />
                </video>
            </div>
            <hr class="split-post-user" />
            <div class="user-info">
                <template v-if="sharePost.community">
                    <figure class="image user_image is-32x32" @mouseover="handleShowUserCard">
                        <router-link :to="{ path: '/community/' + sharePost.community.id }">
                            <img class="is-rounded avatar-image" :src="sharePost.community.image" />
                        </router-link>
                        <div class="user-card">
                            <KeepAlive>
                                <CommunityInfoCard v-if="displayUserInformation" :community="sharePost.community" />
                            </KeepAlive>
                        </div>
                    </figure>
                    <div class="post_user is-flex">
                        <div class="user_name" @mouseover="handleShowUserCard">
                            <router-link :to="{
                                path: '/community/' + sharePost.community.id,
                            }">
                                <strong>{{
                                    sharePost.community.community_name
                                }}</strong>
                            </router-link>
                            <div class="user-card">
                                <KeepAlive>
                                    <CommunityInfoCard v-if="displayUserInformation" :community="sharePost.community" />
                                </KeepAlive>
                            </div>
                        </div>
                        <span class="ml-2"> {{ $t("post.post_by") }} </span>
                        <div class="user_name ml-2" @mouseover="handleShowUserCard">
                            <router-link :to="{ path: '/profile/' + sharePost.user.id }">
                                <strong>{{ sharePost.user.name }}</strong>
                            </router-link>
                            <div class="user-card">
                                <KeepAlive>
                                    <UserInforCard v-if="displayUserInformation" :user="sharePost.user" />
                                </KeepAlive>
                            </div>
                        </div>
                        <p class="ml-2">
                            <i class="fa-regular fa-clock"></i>&nbsp;
                            <small>{{ timeCreated }}</small>
                        </p>
                    </div>
                </template>
                <template v-else>
                    <figure class="image user_image is-32x32" @mouseover="handleShowUserCard">
                        <router-link :to="{ path: '/profile/' + sharePost.user.id }">
                            <img class="is-rounded avatar-image" :src="sharePost.user.image" />
                        </router-link>
                        <div class="user-card">
                            <KeepAlive>
                                <UserInforCard v-if="displayUserInformation" :user="sharePost.user" />
                            </KeepAlive>
                        </div>
                    </figure>
                    <div class="post_user is-flex">
                        <div class="user_name" @mouseover="handleShowUserCard">
                            <router-link :to="{ path: '/profile/' + sharePost.user.id }">
                                <strong>{{ sharePost.user.name }}</strong>
                            </router-link>
                            <div class="user-card">
                                <KeepAlive>
                                    <UserInforCard v-if="displayUserInformation" :user="sharePost.user" />
                                </KeepAlive>
                            </div>
                        </div>
                        <p class="ml-2">
                            <i class="fa-regular fa-clock"></i>&nbsp;
                            <small>{{ timeCreated }}</small>
                        </p>
                    </div>
                </template>
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
import { getPost } from "../../api/post";
import UserInforCard from "../Common/UserInforCard.vue";
import CommunityInfoCard from "../Common/CommunityInfoCard.vue";
import { calculateTime } from "../../helpers/common"

export default {
    mixins: [authMixin],
    components: { UserInforCard, CommunityInfoCard },
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
            community: null,
            isHandlePreview: false,
            sharePost: null,
            displayUserInformation: false
        };
    },
    mounted() {
        if (this.$route.query.post && !isNaN(this.$route.query.post)) {
            this.getPost();
        } else {
            this.$router.go(-1);
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
        timeCreated() {
            return calculateTime(this.sharePost.created_at, this);
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
            let _this = this;
            form.append("title", this.post.title);
            form.append("description", this.post.description);
            form.append("video", this.post.file);
            form.append("community", this.community?.id ?? 0);
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
        handleShowUserCard() {
            this.displayUserInformation = true;
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

.search_community {
    width: 150px;
    margin-left: auto;
}

.post-box {
    margin: auto;
    max-width: 800px;
    margin-bottom: 2rem;
}

.post_user {
    margin: 0.2rem;
}

.user-info {
    display: flex;
    width: fit-content;
    padding: 0.5rem 0.5rem 0 0.5rem;
}

.user-info>strong {
    margin-left: 1rem;
}

.post-desc {
    margin-bottom: 1rem;
    padding: 0 0.5rem;
}

.title {
    margin-bottom: 0.5rem;
    padding: 0 0.5rem;
    font-size: 20px;
}

.split-post-user {
    margin: 0.5rem 0;
}

.avatar-image {
    height: 32px !important;
}

.post-desc /deep/ .image {
    max-width: 600px !important;
}

@media screen and (max-width: 754px) {
}


.user-card {
    position: absolute;
    z-index: 10;
    width: 300px;
    display: none;
    top: 3rem;
}

.user_name:hover .user-card {
    display: block;
    transform: translate(0, -20px);
    transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
}

.user_image:hover .user-card {
    display: block;
    transform: translate(0, -20px);
    transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
}

.share-post {
    max-width: 600px;
    border-radius: 20px;
    margin: auto;
}

@media screen and (max-width: 450px) {

    .post-desc /deep/ .image {
        max-width: 300px !important;
    }
}
</style>
