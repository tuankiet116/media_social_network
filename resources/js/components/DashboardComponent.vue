<template>
    <div id="post-container">
        <LoadingComponent v-if="loading" />
        <div id="create-post" class="post">
            <div v-if="user" class="box post-box column is-two-thirds-tablet is-one-desktop 
            is-one-third-widescreen is-half-fullhd mx-sm-5 is-flex is-align-items-center">
                <img class="image is-32x32 mr-2" :src="user?.image" />
                <input @click="$router.push({ name: 'create_post' })" class="input" placeholder="Create Post">
            </div>
            <div v-else @click="redirectLogin" class="box post-box column is-two-thirds-tablet is-one-desktop 
            is-one-third-widescreen is-half-fullhd mx-sm-5 is-flex is-align-items-center">
                <input class="input" placeholder="Create Post">
            </div>
        </div>
        <div class="post">
            <PostComponent @post-deleted="handleRemovePost" v-for="post in posts" :post="post" />
        </div>
    </div>
</template>
<script>
import { getPosts } from '../api/api';
import authMixin from '../mixins';
import PostComponent from './Post/Children/PostComponent.vue';
import LoadingComponent from './Common/LoadingComponent.vue';
import { mapGetters } from 'vuex';

export default {
    components: {
        PostComponent,
        LoadingComponent
    },
    mixins: [authMixin],
    data() {
        return {
            loading: true,
            posts: []
        }
    },
    computed: {
        ...mapGetters({ user: 'getUser' }),
    },
    mounted() {
        this.fetchPost();
        this.loading = false;
        let height = document.getElementById('navbar').offsetHeight;
        let createPostEl = document.getElementById('create-post');
        if (createPostEl) {
            createPostEl.style.marginTop = Number(height) + Number(height / 2) + 'px';
            createPostEl.style.marginBottom = Number(height / 2) + 'px';
        }
        document.addEventListener('scroll', this.handleLoadPost);
    },
    methods: {
        fetchPost() {
            let offset = this.$store.state.offset;
            let _this = this;
            getPosts({ offset: offset }).then((result) => {
                _this.posts = result.data.data;
                this.$store.state.offset = result.data.offset;
            }).catch(err => {
                console.log(err);
            });
        },
        handleLoadPost(e) {
            let currentScrollPosition = document.documentElement.scrollTop;
            if (currentScrollPosition >= (document.documentElement.scrollHeight - 1000)) {
                this.fetchPost();
            }
        },
        handleRemovePost(postID) {
            let postIndex = this.posts.findIndex(p => {
                return p.id == postID;
            });
            this.posts.splice(postIndex, 1);
        },
        redirectLogin() {
            window.location.replace('user/login');
        }
    },
    beforeUnmount() {
        document.removeEventListener("scroll", this.handleLoadPost);
    },
}
</script>
<style scoped>
#create-post .box {
    margin-left: auto;
    margin-right: auto;
    max-width: 600px;
}

#create-post .box textarea {
    height: 50px;
}
</style>