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
                    <a class="level-item" @click="handleDisplaySubComment">
                        <span class="icon is-small"><i class="fas fa-reply"></i></span>
                    </a>
                    <a class="level-item">
                        <span class="icon is-small"><i class="fas fa-heart"></i></span>
                    </a>
                </div>
            </nav>
            <article v-if="displaySubComment && user" class="media sub-comment">
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
                                <a class="button is-info">Submit</a>
                            </div>
                        </div>
                    </nav>
                </div>
            </article>
        </div>
    </article>
</template>

<script>
export default {
    props: ['comment'],
    data() {
        return {
            displaySubComment: false,
            isShowDetail: false
        }
    },
    computed: {
        user() {
            return this.$store.getters.getUser;
        }
    },
    methods: {
        handleDisplaySubComment() {
            this.displaySubComment = !this.displaySubComment;
        }
    }

}
</script>