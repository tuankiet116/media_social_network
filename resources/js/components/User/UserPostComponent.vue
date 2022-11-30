<template>
    <div class="columns">
        <div class="column">
            <div class="box content">
                <h4>Giới Thiệu</h4>
                <blockquote>
                    <p>Đang sống ở Hà Nội</p>
                    <p>Đã học THPT Lê Quý Đôn-Đống Đa</p>
                    <p>Gõ Phím Tại Pirago</p>
                    <p>Đã Tốt Nghiệp Trường Đời</p>
                </blockquote>
            </div>
        </div>
        <div class="column is-three-fifths-desktop">
            <PostComponent @post-deleted="handleRemovePost" v-for="post in posts" :post="post"/>
        </div>
    </div>
</template>
<script>
import { getPostsByUser } from '../../api/api';
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
        user(value){
            this.fetchPost(value);
        }
    },
    methods: {
        fetchPost(currentUser = null) {
            let userId = currentUser?.id ?? this.$route.params.id ;
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
</style>