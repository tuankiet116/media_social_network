<template v-for="(post, index) in posts">
    <PostComponent :post=post />
</template>
<script>
import { getPosts } from '../../api/api';
import PostComponent from '../Children/PostComponent.vue';

export default {
    components: [PostComponent],
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

</style>