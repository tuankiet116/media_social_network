<template>
    <div class="box">
        <div class="user-info">

        </div>
        <div class="post-desc" v-html="post.post_description"></div>
        <video class="has-text-centered" v-if="userPost.src" width="450" controls>
            <source :src="'/api/post/stream/' + userPost.src" type="video/mp4">
        </video>
    </div>
</template>
<script>
import CommentComponent from '../Children/CommentComponent.vue';
export default {
    components: { CommentComponent },
    props: ['post'],
    data() {
        return {
            userPost: this.post
        };
    }
}
</script>
<style scoped>
.box {
    margin: 5rem 30rem;
}
</style>