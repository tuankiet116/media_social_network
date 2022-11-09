<template>
    <div class="box column is-two-thirds-tablet is-one-desktop is-one-third-widescreen is-half-fullhd mx-sm-5">
        <div ref="post" class="post">
            <canvas ref="canvas"></canvas>
            <div class="user-info">
                <figure class="image is-32x32">
                    <img class="is-rounded" :src="userPost.user.image">
                </figure>
                <strong>{{ userPost.user.name }}</strong>
            </div>
            <hr class="split-post-user">
            <div class="title">
                <strong>{{ userPost.title }}</strong>
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
            <ReactionComponent @postRefresh="fetchPost" @loadListComment="loadListComment" :post="userPost" />
        </div>
        <article v-if="focusComment && user" class="media">
            <figure class="media-left">
                <p class="image is-64x64">
                    <img class="is-rounded" :src="user.image">
                </p>
            </figure>
            <div class="media-content">
                <div class="field">
                    <p class="control">
                        <textarea v-model="commentContent" class="textarea" placeholder="Add a comment..." autofocus>
                        </textarea>
                    </p>
                </div>
                <nav class="level">
                    <div class="level-left">
                        <div class="level-item">
                            <a @click="handleCommentToPost" class="button is-info">Submit</a>
                        </div>
                    </div>
                </nav>
            </div>
        </article>
        <ListCommentComponent v-if="userPost.comments.length" :post="userPost" />
        <hr/>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import { getPost, createComment } from '../../api/api';
import ListCommentComponent from './ListCommentComponent.vue';
import ReactionComponent from './Common/ReactionComponent.vue';
export default {
    components: {
        ListCommentComponent,
        ReactionComponent
    },
    props: ['post'],
    data() {
        return {
            userPost: this.post,
            focusComment: false,
            commentContent: "",
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
        loadListComment() {
            this.focusComment = !this.focusComment;
        },
        handleCommentToPost() {
            let _this = this;
            let data = {
                content: this.commentContent,
                post_id: this.userPost.id,
                parent_id: null
            }

            createComment(data).then(function(result) {
                _this.userPost.comments.unshift(result.data);
                _this.focusComment = false;
            }).catch(function(error) {
                console.log(error);
            });
        }
    }
}
</script>
<style scoped>
.box {
    margin: 3% auto 0 auto;
    max-width: 600px;
    padding: 0;
}

.post {
    position: relative;
}

.user-info {
    display: flex;
    align-items: center;
    width: fit-content;
    padding: 0.5rem 0.5rem 0 0.5rem;
}

.user-info>strong {
    margin-left: 1rem;
}

.user-info img {
    background-color: blueviolet;
}

.post-desc {
    margin-bottom: 1rem;
    padding: 0 0.5rem;
}

.title {
    margin-bottom: 0.5rem;
    padding: 0 0.5rem;
    font-size: 20px;
}

.split-post-user {
    margin: 0.5rem 0;
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