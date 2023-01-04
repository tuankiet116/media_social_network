<template>
    <article class="media">
        <figure class="media-left">
            <div class="image is-32x32 user_image">
                <router-link :to="{ path: '/profile/' + comment.users.id }">
                    <img class="is-rounded avatar-image" :src="comment.users.image">
                </router-link>
                <div class="user-card">
                    <UserInforCard :user="comment.users" />
                </div>
            </div>
        </figure>
        <article v-if="isEditting && user" class="media comment-box">
            <div class="box comment-box">
                <div class="media-content">
                    <div class="field">
                        <p class="control">
                            <textarea v-model="content" class="textarea" placeholder="Add a comment..." autofocus>
                            </textarea>
                        </p>
                    </div>
                    <nav class="level">
                        <div class="level-left">
                            <div class="level-item">
                                <a @click="handleEdit" class="button is-small is-info">Edit</a>
                            </div>
                            <div class="level-item">
                                <a @click="hideEdit" class="button is-small is-light">Cancel</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </article>
        <div class="media comment-box" v-else>
            <div class="media-content">
                <div class="content">
                    <div class="contain-infor">
                        <div class="user_name">
                            <router-link :to="{ path: '/profile/' + comment.users.id }">
                                <strong>{{ comment.users.name }}</strong>&nbsp;&nbsp;
                            </router-link>
                            <div class="user-card">
                                <UserInforCard :user="comment.users" />
                            </div>
                        </div>
                        <span>
                            <small>{{ createTime }}</small>&nbsp;
                            <i class="fa-regular fa-clock"></i>
                        </span>
                        <figure v-outsider="handleUnDisplayHelper" class="media-right dots-container is-rounded">
                            <button class="button is-rounded is-small"
                                @click="this.displayHelper = !this.displayHelper;">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <div href="#" class="arrow-box box" v-show="displayHelper">
                                <a v-if="user && user.id == comment.user_id" class="navbar-item"
                                    @click="handleDeleteReply">
                                    <span>Delete</span>
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                                <hr />
                                <a v-if="user && user.id == comment.user_id" class="navbar-item" @click="showEdit">
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
                    <div class="content box is-rounded">
                        {{ comment.content }}
                    </div>
                </div>

                <nav v-if="user" class="level is-mobile">
                    <div class="level-left">
                        <a class="level-item button is-small" @click="handleLikeComment">
                            <span>{{ comment.likes_count }}</span>
                            <span class="icon is-small">
                                <i v-if="!isLiked" class="fa-regular fa-thumbs-up"></i>
                                <i v-else class="fa-solid fa-thumbs-up liked"></i>
                            </span>
                        </a>
                        <a class="level-item button is-small" @click="handleDisplayReply">
                            <span>{{ comment.amountReply }}</span>
                            <span class="icon is-small"><i class="fas fa-reply"></i></span>
                        </a>
                    </div>
                </nav>
            </div>
        </div>
    </article>
</template>

<script>
import { getRepliesCommentsAPI, likeCommentAPI, replyCommentAPI, updateCommentAPI } from '../../../api/post';
import { calculateTime } from '../../../helpers/common';
import UserInforCard from '../../Common/UserInforCard.vue';

export default {
    props: ["comment"],
    emits: ['displayReply', 'deleteReply', 'isEditting'],
    components: { UserInforCard },
    data() {
        return {
            isEditting: false,
            displayHelper: false,
            content: this.comment.content
        };
    },
    computed: {
        user() {
            return this.$store.getters.getUser;
        },
        createTime() {
            return calculateTime(this.comment.created_at, this);
        },
        isLiked() {
            return this.comment.isLiked
        }
    },
    methods: {
        handleDisplayReply() {
            this.$emit("displayReply");
        },
        handleUnDisplayHelper() {
            this.displayHelper = false;
        },
        handleDeleteReply() {
            this.$emit('deleteReply', this.comment.id);
        },
        handleLikeComment() {
            let data = {
                comment_id: this.comment.id,
                like: !this.isLiked
            }
            this.comment.likes_count++;
            this.comment.isLiked = !this.comment.isLiked;
            likeCommentAPI(data).then(result => {
                this.comment.likes_count = result.data.likes_number;
            }).catch((err) => {
                console.log(err);
            });
        },
        showEdit() {
            this.isEditting = true;
            this.$emit('isEditting');
        },
        hideEdit() {
            this.isEditting = false;
            this.displayHelper = false;
            this.content = this.comment.content;
        },
        handleEdit() {
            let data = {
                id: this.comment.id,
                content: this.content,
            }
            let _this = this;
            updateCommentAPI(data).then(result => {
                if (result.data == true) {
                    _this.comment.content = _this.content
                    _this.hideEdit();
                }
            });
        },
        handleReply() {
            let data = {
                content: this.contentReply,
                belong_id: this.comment.id,
                post_id: this.comment.post_id
            }
            replyCommentAPI(data).then(result => {
                debugger
            }).catch(err => {
                console.log(err);
            });
        },
        loadReplies() {
            let _this = this;
            getRepliesCommentsAPI(this.comment.id, this.offsetReply).then(result => {
                _this.replies = result.data.replies;
                _this.offsetReply = result.data.offset;
            }).catch(error => {
                console.log(error);
            });
        }
    },
}
</script>

<style scoped>
textarea {
    height: 4em;
    min-height: 4em !important;
}

.comment-box {
    width: 100%;
    position: relative;
    margin: 0 !important;
    border: none;
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
    top: 0.5rem;
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

hr {
    padding: 0;
    margin: 0;
}

.contain-infor {
    display: flex;
    align-items: center;
}

.dots-container {
    margin: 0 0 0 auto !important;
}

.liked {
    color: blue;
}

.user-card {
    position: absolute;
    z-index: 10;
    width: 300px;
    display: none;
    top: 3rem;
}

.user_name:hover .user-card {
    display: block;
    transform: translate(0, -20px);
    transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
}

.user_image:hover .user-card {
    display: block;
    transform: translate(0, -20px);
    transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
}

strong {
    color: black;
    cursor: pointer;
}
</style>