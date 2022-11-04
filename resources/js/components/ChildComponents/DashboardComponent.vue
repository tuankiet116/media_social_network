<template>
    <div class="post">
        <PostComponent v-for="post in posts" :post="post" />
    </div>
</template>
<script>
import { getPosts } from '../../api/api';
import PostComponent from '../Children/PostComponent.vue';

export default {
    components: {PostComponent},
    data() {
        return {
            posts: []
        }
    },
    mounted() {
        this.fetchPost();
    },
    methods: {
        fetchPost() {
            let offset = this.$store.state.offset;
            let _this = this;
            getPosts({ offset: offset }).then((result) => {
                _this.posts = result.data.data;
            }).catch(err => {
                console.log(err);
            });
        }
    }
}
</script>
<style scoped>
.post>.box:nth-child(1) {
    margin-top: 15vh !important;
}
</style>