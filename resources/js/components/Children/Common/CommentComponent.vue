<template>
    <article class="media">
        <figure class="media-left">
            <p class="image is-32x32">
                <img class="is-rounded" :src="comment.users.image">
            </p>
        </figure>
        <div class="media comment-box">
            <div class="media-content">
                <div class="content">
                    <p class="contain-infor">
                        <span>
                            <strong>{{ comment.users.name }}</strong>&nbsp;&nbsp;
                            <small>{{ createTime }}</small>&nbsp;
                            <i class="fa-regular fa-clock"></i>
                        </span>
                    <figure v-outsider="handleUnDisplayHelper" class="media-right dots-container is-rounded">
                        <button class="button is-rounded is-small" @click="this.displayHelper = !this.displayHelper;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <div href="#" class="arrow-box box" v-show="displayHelper">
                            <a v-if="user && user.id == comment.user_id" class="navbar-item"
                                @click="handleDeleteComment">
                                <span>Delete</span>
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <hr />
                            <a class="navbar-item">
                                <span>Report</span>
                                <i class="fa-solid fa-flag"></i>
                            </a>
                            <hr />
                            <a class="navbar-item" @click="displayHelper = false">
                                <span>Close</span>
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>
                    </figure>
                    </p>
                    <div class="content box is-rounded">
                        {{ comment.content }}
                    </div>
                </div>

                <nav v-if="user" class="level is-mobile">
                    <div class="level-left">
                        <a class="level-item">
                            <span class="icon is-small">
                                <i class="fa-regular fa-thumbs-up"></i>
                            </span>
                        </a>
                        <a class="level-item" @click="handleDisplayReply">
                            <span class="icon is-small"><i class="fas fa-reply"></i></span>
                        </a>
                    </div>
                </nav>
                <article v-if="displayReply && user" class="media sub-comment">
                    <figure class="media-left">
                        <p class="image is-32x32">
                            <img class="is-rounded" :src="user.image">
                        </p>
                    </figure>
                    <div class="media-content">
                        <div class="field">
                            <p class="control">
                                <textarea class="textarea" ref="comment_reply" autofocus></textarea>
                            </p>
                        </div>
                        <nav class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <a class="button is-info is-rounded is-small">Submit</a>
                                </div>
                                <div class="level-item">
                                    <a @click="displayReply = false"
                                        class="button is-light is-small is-rounded">Cancel</a>
                                </div>
                            </div>
                            <div class="level-left">
                            </div>
                        </nav>
                    </div>
                </article>
            </div>
        </div>
    </article>
</template>

<script>
import { calculateTime } from '../../../helpers/common';

export default {
    props: ["comment"],
    emits: ['displayReply', 'deleteComment'],
    data() {
        return {
            displayReply: false,
            isShowDetail: false,
            displayHelper: false
        };
    },
    computed: {
        user() {
            return this.$store.getters.getUser;
        },
        createTime() {
            return calculateTime(this.comment.created_at, this);
        }
    },
    methods: {
        handleDisplayReply() {
            this.displayReply = !this.displayReply;
            this.$emit("displayReply");
        },
        handleUnDisplayHelper() {
            this.displayHelper = false;
        },
        handleDeleteComment() {
            this.$emit('deleteComment', this.comment.id);
        }
    },
}
</script>

<style scoped>
textarea {
    height: 4em;
    min-height: 4em !important;
}

.media {
    margin-right: 0.5rem;
    border: none !important;
    margin-top: 0;
    padding-top: 0.5rem;
}

.comment-box {
    width: 100%;
    position: relative;
    margin: 0 !important;
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
</style>