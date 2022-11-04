<template>
    <div class="box column is-two-thirds-tablet is-one-desktop is-one-third-widescreen is-half-fullhd mx-sm-5">
        <div class="user-info">
            <figure class="image is-32x32">
                <img class="is-rounded" src="/images/default/avatar_default.png">
            </figure>
            <strong>{{ post.user.name }}</strong>
        </div>
        <hr>
        <div class="title">
            <span class="is-size-4">{{ post.title }}</span>
        </div>
        <div class="post-desc" v-html="post.post_description"></div>
        <div class="has-text-centered">
            <video v-if="userPost.src" width="600" controls>
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
    margin: 3% auto 0 auto;
    max-width: 600px;
}

.user-info {
    display: flex;
    align-items: center;
    width: fit-content;
}

.user-info>strong{
    margin-left: 1rem;
}
.user-info img{
    background-color: blueviolet;
}

.post-desc{
    margin-bottom: 1rem;
}

.title {
    margin-bottom: 0.5rem;
}

hr {
    margin: 1rem 0;
}

@media screen and (max-width: 480px) {
    .box {
        margin-left: 15px;
        margin-right: 15px;
    }
}
</style>