<template>
    <article class="media">
        <figure class="media-left">
            <p class="image is-64x64">
                <img src="https://bulma.io/images/placeholders/128x128.png">
            </p>
        </figure>
        <div class="media-content">
            <div class="content">
                <p>
                    <strong>John Smith</strong> <small>@johnsmith</small> <small>31m</small>
                    <br>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin ornare magna eros, eu pellentesque
                    tortor vestibulum ut. Maecenas non massa sem. Etiam finibus odio quis feugiat facilisis.
                </p>
            </div>
            <nav class="level is-mobile">
                <div class="level-left">
                    <a class="level-item">
                        <span class="icon is-small"><i class="fas fa-reply"></i></span>
                    </a>
                    <a class="level-item" @click="handleDisplaySubComment">
                        <span class="icon is-small"><i class="fas fa-retweet"></i></span>
                    </a>
                    <a class="level-item">
                        <span class="icon is-small"><i class="fas fa-heart"></i></span>
                    </a>
                </div>
            </nav>
            <article v-if="displaySubComment" class="media sub-comment">
                <figure class="media-left">
                    <p class="image is-64x64">
                        <img class="is-rounded" :src="user.image">
                    </p>
                </figure>
                <div class="media-content">
                    <div class="field">
                        <p class="control">
                            <textarea class="textarea" placeholder="Add a comment..."></textarea>
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
        <div class="media-right">
            <button class="delete"></button>
        </div>
    </article>
    <article class="media">
        <figure class="media-left">
            <p class="image is-64x64">
                <img class="is-rounded" :src="user.image">
            </p>
        </figure>
        <div class="media-content">
            <div class="field">
                <p class="control">
                    <textarea class="textarea" placeholder="Add a comment..."></textarea>
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
</template>

<script>
export default {
    data() {
        return {
            displaySubComment: false
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