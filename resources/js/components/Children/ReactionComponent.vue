<template>
    <div class="reactions columns">
        <div class="column">
            <button ref="button" class="button btn" @click="likeHandle">
                <span v-if="like">🎉</span>
                <i v-else class="fa-regular fa-thumbs-up"></i>
                <span>Like</span>
            </button>
        </div>
        <div class="column">
            <button class="btn button">
                <i class="fa-regular fa-message"></i>
                <span>Comment</span>
            </button>
        </div>
        <div class="column flex">
            <button class="btn button">
                <i class="fa-solid fa-share"></i>
                <span>Share</span>
            </button>
        </div>
    </div>
</template>
<script>
import confetti from 'canvas-confetti';
export default {
    props: ['canvas'],
    data() {
        return {
            like: false
        };
    },
    mounted() {
    },
    methods: {
        async likeHandle() {
            if (this.like) {
                this.like = !this.like;
            } else {
                let canvas = this.$refs.button.closest('.box').childNodes[0];
                canvas.style = "display: block";
                this.$refs.button.classList.add('liked');
                setTimeout(async () => {
                    this.like = !this.like;
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
        }
    }
}
</script>

<style scoped>
.button:hover {
    background-color: gainsboro;
}

.button:focus,
.button:focus-within {
    box-shadow: none;
}

.button {
    background-color: #ffffff;
    color: black;
    border: 0;
    font-size: 1rem;
    display: flex;
    gap: 0.5em;
    margin: 0 auto;
    width: 100%;
}

.button:active {
    transform: scale(1.01);
}

.buttons-contain {
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
