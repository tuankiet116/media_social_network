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
@media screen and (min-width: 769px) {
    .post>.box:nth-child(1) {
        margin-top: 5% !important;
    }
}

@media screen and (min-device-width: 481px) and (max-device-width: 768px) { 
    .post>.box:nth-child(1) {
        margin-top: 10% !important;
    }
}

@media only screen and (max-device-width: 480px) {
    .post>.box:nth-child(1) {
        margin-top: calc(100%*0.2) !important;
    }
}
</style>