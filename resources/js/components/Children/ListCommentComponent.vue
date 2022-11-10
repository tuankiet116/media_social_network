<template>
    <div class="container">
        <CommentComponent v-for="comment in post.comments" :comment="comment" />
        <div v-if="!isLoadMore" class="wrapper" ref="wrapper">
            <button class="button is-small is-info is-rounded" @click="loadComments">Show More</button>
        </div>
        <div v-if="post.comments.length">
            <button class="button is-small is-info is-rounded" @click="loadComments">Show More</button>
        </div>
    </div>
</template>

<script>
import CommentComponent from './Common/CommentComponent.vue';

export default {
    components: {
        CommentComponent
    },
    props: ['post'],
    data() {
        return {
            isLoadMore: false,
            comments: this.post.comments,
            offset: 0
        }
    },
    computed: {
        user() {
            return this.$store.getters.getUser;
        }
    },
    methods: {
        loadComments() {
            this.$emit('loadListComment', this.offset);
            this.isLoadMore = true;
        }
    }
}
</script>
<style scoped>
.container {
    position: relative;
}

.wrapper {
    position: absolute;
    background-image: linear-gradient(to top, rgba(152, 152, 235, 0.5), white);
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
}

button {
    position: absolute;
    left: 0;
    right: 0;
    bottom: -1rem;
    margin-left: auto;
    margin-right: auto;
    width: 100px;
}
</style>