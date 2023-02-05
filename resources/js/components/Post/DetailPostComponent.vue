<template>
    <div id="post">
        <div v-if="!isNotFound" :class="{ 'box': !isMobile() }" class="post-box mt-5 mb-5 column is-two-thirds-tablet is-one-desktop 
        is-half-fullhd mx-sm-5">
            <div v-if="post" ref="post" class="post">
                <canvas ref="canvas"></canvas>
                <div class="user-info">
                    <template v-if="post.community">
                        <figure class="image user_image is-32x32" @mouseover="handleShowUserCard">
                            <router-link :to="{ path: '/community/' + post.community.id }">
                                <img class="is-rounded avatar-image" :src="post.community.image">
                            </router-link>
                            <div class="user-card">
                                <KeepAlive>
                                    <CommunityInfoCard v-if="displayUserInformation" :community="post.community" />
                                </KeepAlive>
                            </div>
                        </figure>
                        <div class="post_user is-flex">
                            <div class="user_name" @mouseover="handleShowUserCard">
                                <router-link :to="{ path: '/community/' + post.community.id }">
                                    <strong>{{ post.community.community_name }}</strong>
                                </router-link>
                                <div class="user-card">
                                    <KeepAlive>
                                        <CommunityInfoCard v-if="displayUserInformation" :community="post.community" />
                                    </KeepAlive>
                                </div>
                            </div>
                            <span class="ml-2"> {{ $t("post.post_by") }} </span>
                            <div class="user_name ml-2" @mouseover="handleShowUserCard">
                                <router-link :to="{ path: '/profile/' + post.user.id }">
                                    <strong>{{ post.user.name }}</strong>
                                </router-link>
                                <div class="user-card">
                                    <KeepAlive>
                                        <UserInforCard v-if="displayUserInformation" :user="post.user" />
                                    </KeepAlive>
                                </div>
                            </div>
                            <p class="ml-2">
                                <i class="fa-regular fa-clock"></i>&nbsp;
                                <small>{{ timeCreated }}</small>
                            </p>
                        </div>
                    </template>
                    <template v-else>
                        <figure class="image user_image is-32x32" @mouseover="handleShowUserCard">
                            <router-link :to="{ path: '/profile/' + post.user.id }">
                                <img class="is-rounded avatar-image" :src="post.user.image">
                            </router-link>
                            <div class="user-card">
                                <KeepAlive>
                                    <UserInforCard v-if="displayUserInformation" :user="post.user" />
                                </KeepAlive>
                            </div>
                        </figure>
                        <div class="post_user is-flex">
                            <div class="user_name" @mouseover="handleShowUserCard">
                                <router-link :to="{ path: '/profile/' + post.user.id }">
                                    <strong>{{ post.user.name }}</strong>
                                </router-link>
                                <div class="user-card">
                                    <KeepAlive>
                                        <UserInforCard v-if="displayUserInformation" :user="post.user" />
                                    </KeepAlive>
                                </div>
                            </div>
                            <p class="ml-2">
                                <i class="fa-regular fa-clock"></i>&nbsp;
                                <small>{{ timeCreated }}</small>
                            </p>
                        </div>
                    </template>
                    <figure v-outsider="handleUnDisplayHelper" class="dots-container is-rounded">
                        <button class="button is-rounded is-small" @click="this.displayHelper = !this.displayHelper;">
                            <i class="fa-solid fa-ellipsis"></i>
                        </button>
                        <div href="#" class="arrow-box box" v-show="displayHelper">
                            <a v-if="user && (user.id == post.user_id || (post.community && user.id == post.community.user_id))"
                                class="navbar-item" @click="isShowConfirmPost = true">
                                <span>{{ $t('delete') }}</span>
                                <i class="fa-solid fa-trash"></i>
                            </a>
                            <hr />
                            <a v-if="user && user.id == post.user_id"
                                @click="$router.push({ name: 'edit_post', params: { id: post.id } })"
                                class="navbar-item">
                                <span>{{ $t('edit') }}</span>
                                <i class="fas fa-edit"></i>
                            </a>
                            <hr />
                            <a class="navbar-item" @click="displayHelper = false">
                                <span>{{ $t('close') }}</span>
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>
                    </figure>
                </div>
                <hr class="split-post-user">
                <div class="title">
                    <strong>{{ post.title }}</strong>
                </div>
                <div class="post-desc" ref="desc" @click="handleClick($event)" v-html="post.post_description"></div>
                <div class="has-text-centered">
                    <video v-if="post.src" width="800" controls>
                        <source :src="'/api/post/stream/' + post.src" type="video/mp4">
                    </video>
                </div>
                <div class="is-rounded box share-post p-0" v-if="post.share">
                    <div class="post-desc pt-4" ref="desc_share" @click="handleClick($event, post.share.id)"
                        v-html="post.share.post_description">
                    </div>
                    <div class="has-text-centered">
                        <video v-if="post.share.src" width="800" controls>
                            <source :src="'/api/post/stream/' + post.share.src" type="video/mp4" />
                        </video>
                    </div>
                    <hr class="split-post-user m-0" />
                    <div class="user-info pb-2">
                        <template v-if="post.share.community">
                            <figure class="image user_image is-32x32" @mouseover="handleShowUserCard">
                                <router-link :to="{ path: '/community/' + post.share.community.id }">
                                    <img class="is-rounded avatar-image" :src="post.share.community.image" />
                                </router-link>
                                <div class="user-card">
                                    <KeepAlive>
                                        <CommunityInfoCard v-if="displayUserInformation"
                                            :community="post.share.community" />
                                    </KeepAlive>
                                </div>
                            </figure>
                            <div class="post_user is-flex">
                                <div class="user_name" @mouseover="handleShowUserCard">
                                    <router-link :to="{
                                        path: '/community/' + post.share.community.id,
                                    }">
                                        <strong>{{
                                            post.share.community.community_name
                                        }}</strong>
                                    </router-link>
                                    <div class="user-card">
                                        <KeepAlive>
                                            <CommunityInfoCard v-if="displayUserInformation"
                                                :community="post.share.community" />
                                        </KeepAlive>
                                    </div>
                                </div>
                                <span class="ml-2"> {{ $t("post.post_by") }} </span>
                                <div class="user_name ml-2" @mouseover="handleShowUserCard">
                                    <router-link :to="{ path: '/profile/' + post.share.user.id }">
                                        <strong>{{ post.share.user.name }}</strong>
                                    </router-link>
                                    <div class="user-card">
                                        <KeepAlive>
                                            <UserInforCard v-if="displayUserInformation" :user="post.share.user" />
                                        </KeepAlive>
                                    </div>
                                </div>
                                <p class="ml-2">
                                    <i class="fa-regular fa-clock"></i>&nbsp;
                                    <small>{{ timeSharePostCreated }}</small>
                                </p>
                            </div>
                        </template>
                        <template v-else>
                            <figure class="image user_image is-32x32" @mouseover="handleShowUserCard">
                                <router-link :to="{ path: '/profile/' + post.share.user.id }">
                                    <img class="is-rounded avatar-image" :src="post.share.user.image" />
                                </router-link>
                                <div class="user-card">
                                    <KeepAlive>
                                        <UserInforCard v-if="displayUserInformation" :user="post.share.user" />
                                    </KeepAlive>
                                </div>
                            </figure>
                            <div class="post_user is-flex">
                                <div class="user_name" @mouseover="handleShowUserCard">
                                    <router-link :to="{ path: '/profile/' + post.share.user.id }">
                                        <strong>{{ post.share.user.name }}</strong>
                                    </router-link>
                                    <div class="user-card">
                                        <KeepAlive>
                                            <UserInforCard v-if="displayUserInformation" :user="post.share.user" />
                                        </KeepAlive>
                                    </div>
                                </div>
                                <p class="ml-2">
                                    <i class="fa-regular fa-clock"></i>&nbsp;
                                    <small>{{ timeSharePostCreated }}</small>
                                </p>
                            </div>
                        </template>
                    </div>
                </div>
                <ReactionComponent class="box-reactions" @focusComment="handleFocusComment" :post="post" />
            </div>
            <article v-if="focusComment && user" class="media">
                <figure class="media-left">
                    <p class="image is-32x32">
                        <img class="is-rounded avatar-image" :src="user.image">
                    </p>
                </figure>
                <div class="box comment-box">
                    <div class="media-content">
                        <div class="field">
                            <p class="control">
                                <textarea @keyup.enter="handleCommentToPost" v-model="commentContent" class="textarea"
                                    placeholder="Add a comment..." autofocus>
                                </textarea>
                            </p>
                        </div>
                        <nav class="level is-mobile">
                            <div class="level-left">
                                <div class="level-item">
                                    <a @click="handleCommentToPost" class="button is-small is-info">Submit</a>
                                </div>
                                <div class="level-item">
                                    <a @click="focusComment = false" class="button is-small is-light">{{
                                        $t('cancel')
                                    }}</a>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </article>
            <ListCommentComponent ref="listComment" @loadListComment="handleLoadListComment($event)"
                @deleteComment="handleDeleteComment($event)" @isEditting="focusComment = false" :comments="comments" />
            <hr />
        </div>
        <div v-else>
            <NotFoundComponent />
        </div>
        <ConfirmDeleteComponent v-if="isShowConfirmPost" :message="$t('post.confirm_delete')"
            @confirm="handleDeletePost" @cancel="isShowConfirmPost = false" />
        <vue-easy-lightbox :minZoom="1" :visible="showImage" :imgs="images" :index="imageIndex"
            @hide="handleHide"></vue-easy-lightbox>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import { createComment, getListCommentAPI, deleteCommentAPI, deletePost, getPost } from '../../api/post';
import ListCommentComponent from './Children/ListCommentComponent.vue';
import ReactionComponent from './Children/ReactionComponent.vue';
import ConfirmDeleteComponent from '../Common/ConfirmDeleteComponent.vue';
import { calculateTime, detectMobile } from '../../helpers/common';
import NotFoundComponent from '../Common/errors/NotFoundComponent.vue';
import UserInforCard from '../Common/UserInforCard.vue';
import CommunityInfoCard from '../Common/CommunityInfoCard.vue';

export default {
    components: {
        ListCommentComponent,
        ReactionComponent,
        ConfirmDeleteComponent,
        NotFoundComponent,
        UserInforCard,
        CommunityInfoCard
    },
    emits: ['postDeleted'],
    data() {
        return {
            comments: [],
            focusComment: false,
            commentContent: "",
            displayHelper: false,
            isShowConfirmPost: false,
            post: null,
            id: this.$route.params.id,
            isNotFound: false,
            displayUserInformation: false,
            showImage: false,
            imageIndex: 0,
            images: []
        };
    },
    computed: {
        ...mapGetters({ user: 'getUser' }),
        timeCreated() {
            return calculateTime(this.post.created_at, this)
        },
        timeSharePostCreated() {
            return calculateTime(this.post.share.created_at, this);
        }
    },
    mounted() {
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
            this.$refs.listComment.$refs.comment?.forEach((cm) => {
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
                _this.$refs.listComment.offset++;
            }).catch(function (error) {
                console.log(error);
            });
        },
        handleLoadListComment(offset) {
            let _this = this;
            this.focusComment = true;
            if (this.$route.params.id) {
                getListCommentAPI(this.$route.params.id, offset).then(function (result) {
                    if (result.data.comments.length == 0) {
                        _this.$refs.listComment.isLoadMore = false;
                    } else if (result.data.comments.length > _this.comments.length) {
                        _this.comments = result.data.comments;
                        _this.$refs.listComment.offset = result.data.offset;
                    } else {
                        _this.comments.push(...result.data.comments);
                        _this.$refs.listComment.offset = result.data.offset;
                    }
                }).catch(function (error) {
                });
            }
        },
        handleDeleteComment(idCommentDelete) {
            deleteCommentAPI(idCommentDelete).then(result => {
                if (result.data == true) {
                    let indexComment = this.comments.findIndex(cm => cm.id == idCommentDelete);
                    this.comments.splice(indexComment, 1);
                    this.post.comments_count--;
                    _this.$refs.listComment.offset--;
                }
            })
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
        },
        handleShowUserCard(event) {
            this.displayUserInformation = true;
        },
        isMobile() {
            return detectMobile();
        },
        handleClick(event, shareId = null) {
            if (event.target.tagName == 'IMG' && event.target.src != null) {
                let imgTags = jQuery(this.$refs.desc).find('img');
                if (shareId) {
                    imgTags = jQuery(this.$refs.desc_share).find('img');
                }
                this.images = [];
                imgTags.each((index, img) => {
                    this.images.push(img.src);
                    if (event.target.src == img.src) {
                        this.imageIndex = index;
                    }
                });
                this.showImage = true;
                jQuery('body').css('height', '100vh');
                jQuery('body').css('overflow-y', 'hidden;')
            } else if (shareId) {
                this.$router.push({ name: 'post_detail', params: { id: shareId } })
            }
        },
        handleHide() {
            this.showImage = false;
            jQuery('body').css('height', '100%');
            jQuery('body').css('overflow-y', 'auto;')
        }
    }
}
</script>
<style scoped>
.post-box {
    margin: auto;
    max-width: 800px;
    border-radius: 20px;
    background-color: white;
}

.post_user {
    margin: 0.2rem;
    position: relative;
}

.post_user .user-card {
    top: 2.5rem !important;
}

.comment-box {
    width: 100%;
}

.post {
    position: relative;
}

.user-info {
    display: flex;
    width: fit-content;
    padding: 0.5rem 0.5rem 0 0.5rem;
    cursor: pointer;
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
        border-radius: 0 !important;
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

.is-32x32 .avatar-image {
    height: 32px;
}

.share-post {
    max-width: 800px;
    border-radius: 20px;
    margin: auto;
    border: solid 1px black;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .2);
    cursor: pointer;
}

@media screen and (max-width: 450px) {
    .box-reactions /deep/ button {
        font-size: 10px !important;
    }
}
</style>