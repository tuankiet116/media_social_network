<template>
    <div id="post">
        <div v-if="!isNotFound" class="box post-box column is-two-thirds-tablet is-one-desktop 
        is-one-third-widescreen is-half-fullhd mx-sm-5">
            <div v-if="post" ref="post" class="post">
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
                            <a v-if="user && user.id == post.user_id" class="navbar-item"
                                @click="isShowConfirmPost = true">
                                <span>Delete</span>
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <hr />
                            <a v-if="user && user.id == post.user_id"
                                @click="$router.push({ name: 'edit_post', params: { id: post.id } })"
                                class="navbar-item">
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
            <article v-if="focusComment && user" class="media">
                <figure class="media-left ml-2">
                    <p class="image is-32x32">
                        <img class="is-rounded" :src="user.image">
                    </p>
                </figure>
                <div class="box comment-box">
                    <div class="media-content">
                        <div class="field">
                            <p class="control">
                                <textarea v-model="commentContent" class="textarea" placeholder="Add a comment..."
                                    autofocus>
                                </textarea>
                            </p>
                        </div>
                        <nav class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <a @click="handleCommentToPost" class="button is-small is-info">Submit</a>
                                </div>
                                <div class="level-item">
                                    <a @click="focusComment = false" class="button is-small is-light">Cancel</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </article>
            <ListCommentComponent ref="listComment" 
                @loadListComment="handleLoadListComment($event)"
                @hiddenCommentInput="focusComment = false" 
                @deleteComment="showConfirmDeleteComment($event)"
                @isEditting="focusComment = false"
                :comments="comments" />
            <hr />
        </div>
        <div v-else>
            <NotFoundComponent />
        </div>
        <ConfirmDeleteComponent v-if="isShowConfirmComment" :message="$t('comment.confirm_delete')"
            @confirm="handleDeleteComment" @cancel="hideConfirmDeleteComment" />
        <ConfirmDeleteComponent v-if="isShowConfirmPost" :message="$t('post.confirm_delete')"
            @confirm="handleDeletePost" @cancel="isShowConfirmPost = false" />
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import { createComment, getListCommentAPI, deleteCommentAPI, deletePost, getPost } from '../../api/api';
import ListCommentComponent from './Children/ListCommentComponent.vue';
import ReactionComponent from './Children/ReactionComponent.vue';
import ConfirmDeleteComponent from '../Common/ConfirmDeleteComponent.vue';
import { calculateTime } from '../../helpers/common';
import NotFoundComponent from '../Common/NotFoundComponent.vue';
import authMixin from '../../mixins';

export default {
    components: {
        ListCommentComponent,
        ReactionComponent,
        ConfirmDeleteComponent,
        NotFoundComponent
    },
    mixins: [authMixin],
    emits: ['postDeleted'],
    data() {
        return {
            comments: [],
            focusComment: false,
            commentContent: "",
            isShowConfirmComment: false,
            idCommentDelete: null,
            displayHelper: false,
            isShowConfirmPost: false,
            post: null,
            id: this.$route.params.id,
            isNotFound: false
        };
    },
    computed: {
        ...mapGetters({ user: 'getUser' }),
        timeCreated() {
            return calculateTime(this.post.created_at, this)
        }
    },
    mounted() {
        let height = document.getElementById('navbar').offsetHeight;
        let postEl = document.getElementById('post');
        if (postEl) {
            postEl.style.marginTop = Number(height) + Number(height / 2) + 'px';
            postEl.style.marginBottom = Number(height / 2) + 'px';
        }
        this.fetchPost();
    },
    methods: {
        fetchPost() {
            let _this = this;
            getPost(this.id).then(result => {
                _this.post = result.data;
                _this.handleLoadListComment(0);
                _this.isNotFound = false;
            }).catch(error => {
                _this.post = null;
                _this.isNotFound = true;
            });
        },
        handleUnDisplayHelper() {
            this.displayHelper = false;
        },
        handleFocusComment() {
            this.focusComment = !this.focusComment;
            this.$refs.listComment.loadComments();
            this.$refs.listComment.$refs.comment.forEach((cm) => {
                cm.hideEdit();
            })
        },
        handleCommentToPost() {
            let _this = this;
            if (this.commentContent == "") return;
            let data = {
                content: this.commentContent,
                post_id: this.post.id,
                parent_id: null
            }

            createComment(data).then(function (result) {
                _this.comments.unshift(result.data);
                _this.focusComment = false;
                _this.commentContent = "";
                _this.post.comments_count++;
            }).catch(function (error) {
                console.log(error);
            });
        },
        handleLoadListComment(offset) {
            let _this = this;
            this.focusComment = true;
            this.$refs.listComment.isLoadMoreWrapper = false;
            getListCommentAPI(this.$route.params.id, offset).then(function (result) {
                if (result.data.comments.length == 0) {
                    _this.$refs.listComment.isLoadMore = false;
                } else if (result.data.comments.length >= _this.comments.length) {
                    _this.comments = result.data.comments;
                    _this.$refs.listComment.offset = result.data.offset;
                } else {
                    _this.comments.push(...result.data.comments);
                    _this.$refs.listComment.offset = result.data.offset;
                }
            }).catch(function (error) {
                if (!_this.user) {
                    window.location.href = '/user/login';
                }
            });
        },
        handleDeleteComment() {
            let _this = this;
            deleteCommentAPI(this.idCommentDelete).then(result => {
                if (result.data == true) {
                    let indexComment = _this.comments.findIndex(cm => cm.id == _this.idCommentDelete);
                    _this.comments.splice(indexComment, 1);
                    _this.post.comments_count--;
                    _this.idCommentDelete = null;
                    _this.isShowConfirmComment = false;
                }
            })
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
                _this.$router.push({ name: 'home' });
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