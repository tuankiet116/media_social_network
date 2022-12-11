<template>
    <div class="box post-box column is-two-thirds-tablet is-one-desktop is-one-third-widescreen is-half-fullhd mx-sm-5">
        <div ref="post" class="post">
            <canvas ref="canvas"></canvas>
            <div class="user-info">
                <figure class="image user_image is-32x32" @mouseover="handleShowUserCard">
                    <router-link :to="{ path: '/profile/' + post.user.id }">
                        <img class="is-rounded" :src="post.user.image">
                    </router-link>
                    <div class="user-card">
                        <KeepAlive>
                            <UserInforCard v-if="displayUserInformation" :user="post.user" />
                        </KeepAlive>
                    </div>
                </figure>
                <div class="post_user">
                    <div class="user_name" @mouseover="handleShowUserCard">
                        <strong>{{ post.user.name }}</strong>
                        <div class="user-card">
                            <KeepAlive>
                                <UserInforCard v-if="displayUserInformation" :user="post.user" />
                            </KeepAlive>
                        </div>
                    </div>
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
                <div>
                    <!-- <UserInforCard/> -->
                </div>
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
            <ReactionComponent @focusComment="redirect" :post="post" />
        </div>
        <ListCommentComponent ref="listComment" @loadListComment="redirect($event)"
            @deleteComment="showConfirmDeleteComment($event)" :comments="comments" />
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
import UserInforCard from './UserInforCard.vue';

export default {
    components: {
        ListCommentComponent,
        ReactionComponent,
        ConfirmDeleteComponent,
        UserInforCard
    },
    props: ['post'],
    emits: ['postDeleted'],
    data() {
        return {
            comments: this.post.comments,
            focusComment: false,
            isShowConfirmComment: false,
            idCommentDelete: null,
            displayHelper: false,
            isShowConfirmPost: false,
            displayUserInformation: false
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
        },
        handleShowUserCard() {
            this.displayUserInformation = true;
        }
    }
}
</script>
<style scoped>
canvas {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: none;
}

.post-box {
    margin: auto;
    max-width: 600px;
    margin-bottom: 2rem;
}

.post_user {
    margin: 0.2rem;
}

.post {
    position: relative;
    cursor: pointer;
}

.user-info {
    display: flex;
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

.split-reaction-post {
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
</style>