<template>
    <div class="box column is-three-quarters-mobile is-two-thirds-tablet is-one-desktop is-one-third-widescreen is-half-fullhd">
        <div class="user-info">

        </div>
        <div class="post-desc" v-html="post.post_description"></div>
        <div class="has-text-centered">
            <video v-if="userPost.src" width="450" controls>
                <source :src="'/api/post/stream/' + userPost.src" type="video/mp4">
            </video>
        </div>
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
    margin: 2% auto 0 auto;
}
</style>