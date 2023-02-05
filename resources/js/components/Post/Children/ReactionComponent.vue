<template>
    <div>
        <a @click="showModalUserLike" class="show-users" v-if="post.isLiked">
            You <span v-if="post.reaction_user_count > 1"> and {{ post.reaction_user_count - 1 }} people</span> loved
            this post</a>
        <a @click="showModalUserLike" class="show-users" v-else>
            {{ post.reaction_user_count }} people loved this post</a>
        <hr class="m-0" />
        <div class="reactions columns is-mobile m-0" v-if="user">
            <div class="column is-flex">
                <div style="margin:auto">
                    <button ref="button" class="button btn m-0" @click="likeHandle">
                        <span v-if="like">🎉</span>
                        <i v-else class="fa-regular fa-thumbs-up"></i>
                        <span>{{ $t('post.love') }}</span>
                    </button>
                </div>
            </div>
            <div class="column">
                <button class="btn button is-flex" @click="$emit('focusComment')">
                    <i class="fa-regular fa-message"></i>
                    <span>{{ $t('post.comment') }}</span>
                    |
                    <span>{{ post.comments_count }}</span>
                </button>
            </div>
            <div class="column">
                <button class="btn button is-flex" @click="sharePost">
                    <i class="fa-solid fa-share"></i>
                    <span>{{ $t('post.share') }}</span>
                    |
                    <span>{{ post.shared_count }}</span>
                </button>
            </div>
        </div>
        <div class="columns" v-else>
            <div class="column no-reactions">
                <span>{{ $t('post.auth_react') }} &nbsp; &nbsp;</span>
                <a href='/user/login' class='button is-small is-info'>{{ $t('login') }}</a>
            </div>
        </div>
        <UserLikeComponent @close="showModalLikes = false" v-if="showModalLikes" :post="post"/>
    </div>
</template>
<script>
import confetti from 'canvas-confetti';
import { mapGetters } from 'vuex';
import { reactPostAPI } from '../../../api/post';
import UserLikeComponent from './UserLikeComponent';

export default {
    props: ['post'],
    emits: ['focusComment'],
    components: { UserLikeComponent },
    data() {
        return {
            like: this.post.isLiked,
            showModalLikes: false
        };
    },
    computed: {
        ...mapGetters({ user: 'getUser' })
    },
    methods: {
        async likeHandle() {
            if (this.like) {
                this.like = !this.like;
                this.reactPost();
            } else {
                let canvas = this.$refs.button.closest('.post').childNodes[0];
                canvas.style = "display: block";
                this.$refs.button.classList.add('liked');
                setTimeout(async () => {
                    this.like = !this.like;
                    this.reactPost();
                    this.$refs.button.classList.remove('liked');
                    if (this.like) {
                        canvas.confetti = canvas.confetti || confetti.create(canvas, { resize: true });
                        await canvas.confetti({
                            spread: 70,
                            origin: { y: 1.2 }
                        });
                    }
                    canvas.style = "display: none";
                }, 500);
            }
        },
        reactPost() {
            let data = {
                postId: this.post.id,
                like: this.like
            }
            let _this = this;
            this.post.isLiked = this.like;
            if (this.like) {
                this.post.reaction_user_count++;
            }
            else {
                this.post.reaction_user_count--;
            }
            reactPostAPI(data).then(function (result) {
                _this.post.reaction_user_count = result.data.amount_reaction;
            }).catch(function (err) { });
        },
        sharePost() {
            this.$router.push({ name: 'create_post', query: { post: this.post.id } })
        },
        showModalUserLike() {
            this.showModalLikes = true;
        }
    }
}
</script>

<style scoped>
.show-users {
    box-shadow: initial !important;
    padding: 2rem;
}

.reactions .column {
    margin: 0 !important;
    padding: 0 !important
}

.reactions.btn:hover {
    background-color: gainsboro;
}

.reactions .btn:focus,
.reactions .btn:focus-within {
    box-shadow: none;
}

.reactions .btn {
    background-color: #ffffff;
    color: black;
    border: 0;
    font-size: 1rem;
    gap: 0.5em;
    margin: 0 auto;
}

.reactions .btn:active {
    transform: scale(1.01);
}

.liked>.fa-thumbs-up {
    animation: like-animation 0.5s;
    color: blue;
}

@media screen and (max-width: 480px) {
    span {
        font-size: 10px;
    }
}

@keyframes like-animation {
    from {
        transform: scale(0.5);
    }

    to {
        transform: scale(1.5);
    }
}
</style>
