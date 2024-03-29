<template>
    <div class="columns">
        <div class="column cl-infor">
            <div class="box content">
                <h4>{{ $t('user_page.introduce') }}</h4>
                <blockquote v-if="user.user_information && user.user_school.length">
                    <p v-if="user.user_information?.living_place">
                        {{ $t('user_page.living') }}
                        <strong>
                            <a :href="'https://maps.google.com/?q=' + user.user_information.living_place">
                                {{ user.user_information.living_place }} <i class="fa-solid fa-link"></i>
                            </a>
                        </strong>
                    </p>
                    <p v-if="user.user_information?.working_place">
                        {{ $t('user_page.working') }}
                        <strong>
                            <a :href="'https://maps.google.com/?q=' + user.user_information.working_place">
                                {{ user.user_information.working_place }} <i class="fa-solid fa-link"></i>
                            </a>
                        </strong>
                    </p>
                    <p v-for="user_school in user.user_school">
                        <span v-if="new Date(user_school.end) < new Date()">
                            {{ $t('user_page.graduated') }}
                            <strong>
                                <a :href="'https://maps.google.com/?q=' + user_school.school_name">
                                    {{ user_school.school_name }} <i class="fa-solid fa-link"></i>
                                </a>
                            </strong>
                        </span>
                        <span v-else>
                            {{ $t('user_page.studying') }}
                            <strong>
                                <a :href="'https://maps.google.com/?q=' + user_school.school_name">
                                    {{ user_school.school_name }} <i class="fa-solid fa-link"></i>
                                </a>
                            </strong>
                        </span>
                    </p>
                </blockquote>
                <blockquote v-else>
                    <p>{{ $t('user_page.no_infor') }}</p>
                </blockquote>
            </div>
        </div>
        <div v-if="posts.length" class="column is-three-fifths-desktop">
            <PostComponent @post-deleted="handleRemovePost" v-for="post in posts" :post="post" />
        </div>
        <div v-else class="column is-three-fifths-desktop has-text-centered">
            <div v-if="user && isMe"
                class="box post-box column is-two-thirds-tablet is-one-desktop is-one-third-widescreen is-half-fullhd mx-sm-5 is-flex is-align-items-center">
                <figure class="image is-32x32 mr-2">
                    <img class="mr-2 avatar-image is-rounded" :src="user?.image" />
                </figure>
                <input @click="$router.push({ name: 'create_post' })" class="input" placeholder="Create Post" />
            </div>
            <div v-if="isMe" class="box has-text-centered">
                <p class="content is-size-5">{{ $t('user_page.share_first_thing') }}</p>
                <figure class="image is-128x128" style="margin: auto">
                    <img src="../../../images/gifs/waving_stitch.gif" />
                </figure>
            </div>
            <div v-else class="box has-text-centered">
                <p class="content is-size-5">{{ $t('user_page.welcome_to_page') }} </p>
                <figure class="image is-128x128" style="margin: auto">
                    <img src="../../../images/gifs/waving_stitch.gif" />
                </figure>
            </div>
        </div>
    </div>
</template>
<script>
import { getPostsByUser } from '../../api/post';
import PostComponent from '../Post/Children/PostComponent.vue';
export default {
    data() {
        return {
            posts: [],
            offset: 0,
            isLoadMore: true,
            outOfPost: false,
            userId: this.$route.params.id
        };
    },
    props: ['user'],
    components: { PostComponent },
    mounted() {
        document.addEventListener('scroll', this.handleLoadPost);
        this.posts = [];
        this.fetchPost(this.user);
    },
    methods: {
        async fetchPost() {
            let userId = this.userId;
            if (userId) {
                await getPostsByUser(this.offset, userId).then(result => {
                    if (result.data.data.length == 0) {
                        this.outOfPost = true;
                    }
                    this.posts.push(...result.data.data);
                    this.offset = result.data.offset;
                }).catch(err => {
                    console.log(err);
                });
            }
        },
        handleRemovePost(postID) {
            let postIndex = this.posts.findIndex(p => {
                return p.id == postID;
            });
            this.posts.splice(postIndex, 1);
        },
        handleLoadPost(e) {
            if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight - 100
                && this.isLoadMore && !this.outOfPost) {
                this.isLoadMore = false;
                this.fetchPost(this.user);
            }
        },
        isMe() {
            return this.user.id == this.$store.state.user.id
        }
    },
    beforeUnmount() {
        document.removeEventListener("scroll", this.handleLoadPost);
    },
}
</script>
<style scoped>
/deep/ .post-box {
    width: 100%;
}

.cl-infor {
    position: sticky;
}
</style>