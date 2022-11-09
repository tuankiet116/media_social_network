<template>
    <div ref="post"
        class="box column is-two-thirds-tablet is-one-desktop is-one-third-widescreen is-half-fullhd mx-sm-5">

        <canvas ref="canvas"></canvas>
        <div class="user-info">
            <figure class="image is-32x32">
                <img class="is-rounded" :src="userPost.user.image">
            </figure>
            <strong>{{ userPost.user.name }}</strong>
        </div>
        <hr>
        <div class="title">
            <span class="is-size-4">{{ userPost.title }}</span>
        </div>
        <div class="post-desc" v-html="post.post_description"></div>
        <div class="has-text-centered">
            <video v-if="userPost.src" width="600" controls>
                <source :src="'/api/post/stream/' + userPost.src" type="video/mp4">
            </video>
        </div>
        <div class="columns post-info">
            <div class="column post-info">
                <span class="ml-5 has-text-success-dark">
                    {{ userPost.reaction_user_count }} 🎉
                </span>
            </div>
            <div class="column post-info has-text-centered">
                <span>
                    {{ userPost.reaction_user_count }} comments
                </span>
            </div>
            <div class="column post-info">
                <span class="mr-5 is-pulled-right">
                    {{ userPost.reaction_user_count }} share
                </span>
            </div>
        </div>
        <hr class="split-reaction-post">
        <ReactionComponent @postRefresh="fetchPost" @displayComment="handleDisplayComment" :post="userPost" />
        <CommentComponent v-if="displayComment"/>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import { getPost } from '../../api/api';
import CommentComponent from '../Children/CommentComponent.vue';
import ReactionComponent from './ReactionComponent.vue';
export default {
    components: {
        CommentComponent,
        ReactionComponent
    },
    props: ['post'],
    data() {
        return {
            userPost: this.post,
            displayComment: false
        };
    },
    computed: {
        ...mapGetters({ user: 'getUser' })
    },
    methods: {
        fetchPost() {
            let _this = this;
            getPost(this.userPost.id).then((result) => {
                _this.userPost = result.data;
            });
        },
        handleDisplayComment() {
            this.displayComment = !this.displayComment;
        }
    }
}
</script>
<style scoped>
.box {
    margin: 3% auto 0 auto;
    max-width: 600px;
    position: relative;
}

.user-info {
    display: flex;
    align-items: center;
    width: fit-content;
}

.user-info>strong {
    margin-left: 1rem;
}

.user-info img {
    background-color: blueviolet;
}

.post-desc {
    margin-bottom: 1rem;
}

.title {
    margin-bottom: 0.5rem;
}

hr {
    margin: 1rem 0;
}

.split-reaction-post {
    margin: 0 !important;
}

.post-info {
    padding: 0 !important;
    margin: 0 !important;
}

.reactions {
    display: flex;
    align-content: center;
}

@media screen and (max-width: 480px) {
    .box {
        margin-left: 0;
        margin-right: 0;
    }
}

.overlay {
    position: absolute;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}

canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
}
</style>