<template>
    <div class="container">
        <CommentComponent ref="comment" v-for="(comment, index) in comments" :comment="comment"
            @deleteComment="$emit('deleteComment', $event)" @displayReply="hiddenReply(index)" />
        <div v-if="isLoadMoreWrapper" class="wrapper" ref="wrapper">
        </div>
        <button v-if="isLoadMore && comments.length" class="button is-small is-info is-rounded"
            @click="loadComments">Show More</button>
    </div>
</template>

<script>
import CommentComponent from './Common/CommentComponent.vue';

export default {
    components: {
        CommentComponent
    },
    props: ['comments'],
    data() {
        return {
            isLoadMoreWrapper: true,
            isLoadMore: true,
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
            this.isLoadMoreWrapper = false;
        },
        hiddenReply(indexComponentException) {
            this.$refs.comment.forEach(function (component, index) {
                if (index !== indexComponentException) {
                    component.displayReply = false;
                }
            });
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
    bottom: -0.8rem;
    margin-left: auto;
    margin-right: auto;
    width: 100px;
}
</style>