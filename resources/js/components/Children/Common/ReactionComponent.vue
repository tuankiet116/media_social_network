<template>
    <div class="reactions columns" v-if="user">
        <div class="column">
            <button ref="button" class="button btn" @click="likeHandle">
                <span v-if="like">🎉</span>
                <i v-else class="fa-regular fa-thumbs-up"></i>
                <span>Like</span>
            </button>
        </div>
        <div class="column">
            <button class="btn button" @click="$emit('focusComment')">
                <i class="fa-regular fa-message"></i>
                <span>Comment</span>
            </button>
        </div>
        <div class="column">
            <button class="btn button">
                <i class="fa-solid fa-share"></i>
                <span>Share</span>
            </button>
        </div>
    </div>
    <div class="columns" v-else>
        <div class="column no-reactions">
            <span>{{ $t('post.auth_react') }} &nbsp; &nbsp;</span>
            <a href='/user/login' class='button is-small is-info'>Đăng Nhập</a>
        </div>
    </div>
</template>
<script>
import confetti from 'canvas-confetti';
import { mapGetters } from 'vuex';
import { reactPostAPI } from '../../../api/api';

export default {
    props: ['post'],
    data() {
        return {
            like: this.post.isLiked
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
            reactPostAPI(data).then(function (result) {
                _this.$emit('postRefresh');
            }).catch(function (err) {});
        }
    }
}
</script>

<style scoped>
.reactions.button:hover {
    background-color: gainsboro;
}

.reactions .button:focus,
.reactions .button:focus-within {
    box-shadow: none;
}

.reactions .button {
    background-color: #ffffff;
    color: black;
    border: 0;
    font-size: 1rem;
    display: flex;
    gap: 0.5em;
    margin: 0 auto;
    width: 100%;
}

.reactions .button:active {
    transform: scale(1.01);
}

.reactions .buttons-contain {
    position: relative;
}

.liked>.fa-thumbs-up {
    animation: like-animation 0.5s;
    color: blue;
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
