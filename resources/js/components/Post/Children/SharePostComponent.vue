<template>
    <div class="is-rounded box share-post p-0" v-if="post">
        <div class="post-desc pt-4" ref="desc_share" @click="handleClick($event, post.id)"
            v-html="post.post_description"></div>
        <div class="has-text-centered">
            <video v-if="post.src" width="800" controls>
                <source :src="'/api/post/stream/' + post.src" type="video/mp4" />
            </video>
        </div>
        <hr class="split-post-user m-0" />
        <div class="user-info pb-2">
            <template v-if="post.community">
                <figure class="image user_image is-32x32" @mouseover="handleShowUserCard">
                    <router-link :to="{ path: '/community/' + post.community.id }">
                        <img class="is-rounded avatar-image" :src="post.community.image" />
                    </router-link>
                    <div class="user-card">
                        <KeepAlive>
                            <CommunityInfoCard v-if="displayUserInformation" :community="post.community" />
                        </KeepAlive>
                    </div>
                </figure>
                <div class="post_user is-flex">
                    <div class="user_name" @mouseover="handleShowUserCard">
                        <router-link :to="{
                            path: '/community/' + post.community.id,
                        }">
                            <strong>{{
                                post.community.community_name
                            }}</strong>
                        </router-link>
                        <div class="user-card">
                            <KeepAlive>
                                <CommunityInfoCard v-if="displayUserInformation" :community="post.community" />
                            </KeepAlive>
                        </div>
                    </div>
                    <span class="ml-2"> {{ $t("post.post_by") }} </span>
                    <div class="user_name ml-2" @mouseover="handleShowUserCard">
                        <router-link :to="{ path: '/profile/' + post.user.id }">
                            <strong>{{ post.user.name }}</strong>
                        </router-link>
                        <div class="user-card">
                            <KeepAlive>
                                <UserInforCard v-if="displayUserInformation" :user="post.user" />
                            </KeepAlive>
                        </div>
                    </div>
                    <p class="ml-2">
                        <i class="fa-regular fa-clock"></i>&nbsp;
                        <small>{{ timeSharePostCreated }}</small>
                    </p>
                </div>
            </template>
            <template v-else>
                <figure class="image user_image is-32x32" @mouseover="handleShowUserCard">
                    <router-link :to="{ path: '/profile/' + post.user.id }">
                        <img class="is-rounded avatar-image" :src="post.user.image" />
                    </router-link>
                    <div class="user-card">
                        <KeepAlive>
                            <UserInforCard v-if="displayUserInformation" :user="post.user" />
                        </KeepAlive>
                    </div>
                </figure>
                <div class="post_user is-flex">
                    <div class="user_name" @mouseover="handleShowUserCard">
                        <router-link :to="{ path: '/profile/' + post.user.id }">
                            <strong>{{ post.user.name }}</strong>
                        </router-link>
                        <div class="user-card">
                            <KeepAlive>
                                <UserInforCard v-if="displayUserInformation" :user="post.user" />
                            </KeepAlive>
                        </div>
                    </div>
                    <p class="ml-2">
                        <i class="fa-regular fa-clock"></i>&nbsp;
                        <small>{{ timeSharePostCreated }}</small>
                    </p>
                </div>
            </template>
        </div>
    </div>
    <vue-easy-lightbox @scroll.prevent :minZoom="1" :visible="showImage" :imgs="images" :index="imageIndex"
        @hide="handleHide"></vue-easy-lightbox>
</template>
<script>
import { calculateTime } from "../../../helpers/common";
import UserInforCard from "../../Common/UserInforCard.vue";
import CommunityInfoCard from "../../Common/CommunityInfoCard.vue";
import { mapGetters } from "vuex";
export default {
    components: {
        UserInforCard,
        CommunityInfoCard
    },
    props: ["post"],
    data() {
        return {
            displayUserInformation: false,
            showImage: false,
            imageIndex: 0,
            images: []
        };
    },
    computed: {
        ...mapGetters({ user: "getUser" }),
        timeSharePostCreated() {
            return calculateTime(this.post.created_at, this);
        }
    },
    methods: {
        handleShowUserCard() {
            this.displayUserInformation = true;
        },
        handleClick(event, shareId) {
            if (event.target.tagName == 'IMG' && event.target.src != null) {
                let imgTags = jQuery(this.$refs.desc_share).find('img');
                this.images = [];
                imgTags.each((index, img) => {
                    this.images.push(img.src);
                    if (event.target.src == img.src) {
                        this.imageIndex = index;
                    }
                });
                this.showImage = true;
                let TopScroll = window.pageYOffset || document.documentElement.scrollTop;
                let LeftScroll = window.pageXOffset || document.documentElement.scrollLeft;

                // if scroll happens, set it to the previous value
                window.onscroll = function () {
                    window.scrollTo(LeftScroll, TopScroll);
                };
            } else {
                this.$router.push({ name: 'post_detail', params: { id: shareId } })
            }
        },
        handleHide() {
            this.showImage = false;
            window.onscroll = function () { };
        }
    },
};
</script>
<style scoped>

.post_user {
    margin: 0.2rem;
    position: relative;
}

.post_user .user-card {
    top: 2.5rem !important;
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

.split-post-user {
    margin: 0.5rem 0;
}

.avatar-image {
    height: 32px !important;
}

.post-desc /deep/ .image {
    max-width: 800px !important;
}

.share-post {
    max-width: 800px;
    border-radius: 20px;
    margin: auto;
    border: solid 1px black;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .2);
    cursor: pointer;
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

@media screen and (max-width: 450px) {

    .post-desc /deep/ .image {
        max-width: 300px !important;
    }
}
</style>
