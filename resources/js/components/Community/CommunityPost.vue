<template>
    <div class="columns">
        <div v-if="posts.length" class="column is-three-fifths-desktop">
            <PostComponent @post-deleted="handleRemovePost" v-for="post in posts" :post="post" />
        </div>
        <div v-else class="column is-three-fifths-desktop has-text-centered">
            <div class="box">
                <div>
                </div>
                {{ $t('community.no_post') }}
            </div>
        </div>
        <div class="column">
            <CommunityCardComponent class="card_community" :community="community"/>
        </div>
    </div>
</template>
<script>
import { getCommunityPostsAPI } from '../../api/community';
import PostComponent from '../Post/Children/PostComponent.vue';
import CommunityCardComponent from './CommunityCardComponent.vue';
export default {
    data() {
        return {
            posts: [],
            offset: 0,
            isLoadMore: true,
            outOfPost: false
        };
    },
    props: ['community'],
    components: { PostComponent, CommunityCardComponent },
    mounted() {
        document.addEventListener('scroll', this.handleLoadPost);
        this.fetchPost();
    },
    methods: {
        fetchPost() {
            let communityID = this.$route.params.id;
            if (communityID) {
                getCommunityPostsAPI(communityID, this.offset).then(result => {
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
                this.fetchPost();
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

.card_community {
    position: sticky;
    top: 8rem;
}
</style>