<template>
    <LoadingComponent v-if="loading"/>
    <div class="post" ref="post">
        <PostComponent v-for="post in posts" :post="post" />
    </div>
</template>
<script>
import { getPosts } from '../api/api';
import authMixin from '../mixins';
import PostComponent from './Children/PostComponent.vue';
import LoadingComponent from './Common/LoadingComponent.vue';

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
    mounted() {
        this.fetchPost();
        this.loading = false;
        let height = document.getElementById('navbar').offsetHeight;
        this.$refs.post.style.marginTop = height + 'px';

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
        margin-top: 10% !important;
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

    .post {
        width: fit-content;
    }
}
</style>