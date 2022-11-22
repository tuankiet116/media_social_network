<template>
    <div class="box post-box column is-two-thirds-tablet is-one-desktop is-one-third-widescreen is-half-fullhd mx-sm-5">
        <div ref="post" class="post">
            <canvas ref="canvas"></canvas>
            <div class="user-info">
                <figure class="image is-32x32">
                    <img class="is-rounded" :src="post.user.image">
                </figure>
                <div class="post_user">
                    <p><strong>{{ post.user.name }}</strong></p>
                    <p>
                        <i class="fa-regular fa-clock"></i>&nbsp;
                        <small>{{ timeCreated }}</small>
                    </p>
                </div>
                <figure v-outsider="handleUnDisplayHelper" class="dots-container is-rounded">
                    <button class="button is-rounded is-small" @click="this.displayHelper = !this.displayHelper;">
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <div href="#" class="arrow-box box" v-show="displayHelper">
                        <a v-if="user && user.id == post.user_id" class="navbar-item" @click="isShowConfirmPost = true">
                            <span>Delete</span>
                            <i class="fa-solid fa-trash"></i>
                        </a>
                        <hr />
                        <a v-if="user && user.id == post.user_id"
                            @click="$router.push({ name: 'edit_post', params: { id: post.id } })" class="navbar-item">
                            <span>Edit</span>
                            <i class="fas fa-edit"></i>
                        </a>
                        <hr />
                        <a class="navbar-item" @click="displayHelper = false">
                            <span>Close</span>
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </div>
                </figure>
            </div>
            <hr class="split-post-user">
            <div class="title">
                <strong>{{ post.title }}</strong>
            </div>
            <div class="post-desc" v-html="post.post_description"></div>
            <div class="has-text-centered">
                <video v-if="post.src" width="600" controls>
                    <source :src="'/api/post/stream/' + post.src" type="video/mp4">
                </video>
            </div>
            <hr class="split-reaction-post">
            <ReactionComponent @focusComment="handleFocusComment" :post="post" />
        </div>
        <ListCommentComponent ref="listComment" @loadListComment="redirect($event)"
            @hiddenCommentInput="focusComment = false" @deleteComment="showConfirmDeleteComment($event)"
            :comments="comments" />
        <hr />
    </div>
    <ConfirmDeleteComponent v-if="isShowConfirmPost" :message="$t('post.confirm_delete')" @confirm="handleDeletePost"
        @cancel="isShowConfirmPost = false" />
</template>
<script>
import { mapGetters } from 'vuex';
import { deletePost } from '../../../api/api';
import ListCommentComponent from './ListCommentComponent.vue';
import ReactionComponent from './ReactionComponent.vue';
import ConfirmDeleteComponent from '../../Common/ConfirmDeleteComponent.vue';
import { calculateTime } from '../../../helpers/common';

export default {
    components: {
        ListCommentComponent,
        ReactionComponent,
        ConfirmDeleteComponent
    },
    props: ['post'],
    emits: ['postDeleted'],
    data() {
        return {
            comments: this.post.comments,
            focusComment: false,
            commentContent: "",
            isShowConfirmComment: false,
            idCommentDelete: null,
            displayHelper: false,
            isShowConfirmPost: false
        };
    },
    computed: {
        ...mapGetters({ user: 'getUser' }),
        timeCreated() {
            return calculateTime(this.post.created_at, this)
        }
    },
    methods: {
        handleUnDisplayHelper() {
            this.displayHelper = false;
        },
        redirect(offset) {
            this.$router.push({ name: 'post_detail', params: { id: this.post.id } })
        },
        showConfirmDeleteComment(idCommentDelete) {
            this.isShowConfirmComment = true;
            this.idCommentDelete = idCommentDelete;
        },
        hideConfirmDeleteComment() {
            this.isShowConfirmComment = false;
            this.idCommentDelete = null;
        },
        async handleDeletePost() {
            let _this = this;
            await deletePost(this.post.id).then(result => {
                _this.$emit('postDeleted', this.post.id);
            }).catch(error => {
                console.log(error);
            });
            this.isShowConfirmPost = false;
        }
    }
}
</script>
<style scoped>
.post-box {
    margin: auto;
    max-width: 600px;
    padding: 0;
}

.post_user {
    margin: 0.2rem;
}

.comment-box {
    width: 100%;
}

.post {
    position: relative;
    cursor: pointer;
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

.split-reaction-post {
    margin: 0 !important;
}

.post-info {
    padding: 0 !important;
    margin: 0 !important;
}

.dots-container {
    position: absolute;
    right: 0.2rem;
}

@media screen and (max-width: 480px) {
    .post-box {
        margin-left: 0;
        margin-right: 0;
    }
}

canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
}

textarea {
    height: 4em;
    min-height: 4em !important;
}

.media {
    margin-right: 1rem;
}

.arrow-box {
    position: absolute;
    width: 220px;
    background: #19B3E6;
    line-height: 40px;
    margin-bottom: 30px;
    text-align: center;
    right: 2rem;
    padding: 0;
    top: 0;
}

.arrow-box a {
    color: white;
}

.arrow-box a:hover {
    color: black;
}

.arrow-box:before {
    content: "";
    position: absolute;
    right: -7px;
    top: 7px;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-left: 10px solid #19B3E6;
}

.arrow-box i {
    margin-left: auto;
}

.arrow-box hr {
    margin: 0 !important;
}
</style>