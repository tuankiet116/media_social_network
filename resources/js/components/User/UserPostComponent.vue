<template>
    <div class="columns">
        <div class="column cl-infor">
            <div class="box content">
                <h4>Giới Thiệu</h4>
                <blockquote v-if="user.user_information && user.user_school.length">
                    <p v-if="user.user_information?.living_place">
                        Đang sống ở {{ user.user_information.living_place }}
                    </p>
                    <p v-for="user_school in user.user_school">
                        <span v-if="user_school.end_year < new Date().getFullYear()">
                            Đã tốt nghiệp {{ user_school.school_name }}
                        </span>
                        <span v-else>
                            Đang học {{ user_school.school_name }}
                        </span>
                    </p>
                </blockquote>
                <blockquote v-else>
                    <p>No Information</p>
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
            <div class="box has-text-centered">
                <p class="content is-size-5">Let's share your first Amazing Things to The Community! </p>
                <figure class="image is-128x128" style="margin: auto">
                    <img src="../../../images/gifs/waving_stitch.gif"/>
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