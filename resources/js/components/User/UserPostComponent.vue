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
            <div class="box">
                No Post Yet
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
            outOfPost: false
        };
    },
    props: ['user'],
    components: { PostComponent },
    mounted() {
    },
    computed: {
        currentUser() {
            return this.user;
        }
    },
    mounted() {
        document.addEventListener('scroll', this.handleLoadPost);
        this.fetchPost(this.user);
    },
    watch: {
        user(value) {
            this.fetchPost(value);
        }
    },
    methods: {
        fetchPost(currentUser = null) {
            let userId = currentUser?.id ?? this.$route.params.id;
            if (userId) {
                getPostsByUser(this.offset, userId).then(result => {
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