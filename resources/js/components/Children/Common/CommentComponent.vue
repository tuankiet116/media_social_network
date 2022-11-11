<template>
    <article class="media">
        <figure class="media-left">
            <p class="image is-32x32">
                <img class="is-rounded" :src="comment.users.image">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>{{ comment.content }}</p>
            </div>
            <nav v-if="user" class="level is-mobile">
                <div class="level-left">
                    <a class="level-item" @click="handleDisplayReply">
                        <span class="icon is-small"><i class="fas fa-reply"></i></span>
                    </a>
                    <a class="level-item">
                        <span class="icon is-small"><i class="fas fa-heart"></i></span>
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
                                <a class="button is-info is-small">Submit</a>
                            </div>
                            <div class="level-item">
                                <a @click="displayReply = false" class="button is-light is-small">Cancel</a>
                            </div>
                        </div>
                        <div class="level-left">
                        </div>
                    </nav>
                </div>
            </article>
        </div>
        <figure class="media-right">
            <button class="delete" aria-label="delete"></button>
        </figure>
    </article>
</template>

<script>
export default {
    props: ['comment'],
    data() {
        return {
            displayReply: false,
            isShowDetail: false
        }
    },
    computed: {
        user() {
            return this.$store.getters.getUser;
        }
    },
    methods: {
        handleDisplayReply() {
            this.displayReply = !this.displayReply;
            this.$emit('displayReply');
        }
    }

}
</script>

<style scoped>
textarea {
    height: 4em;
    min-height: 4em !important;
}

.media {
    margin-right: 1rem;
}
</style>