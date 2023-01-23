<template>
    <div class="container">
        <CommentComponent ref="comment" v-for="(comment, index) in comments" :comment="comment"
            @deleteComment="$emit('deleteComment', $event)" @displayReply="hiddenReply(index)"
            @isEditting="$emit('isEditting')" />
    </div>
    <div class="load-more">
        <a v-if="isLoadMore && comments.length" @click="loadComments">{{ $t('load_more') }}</a>
    </div>
</template>

<script>
import CommentComponent from './CommentComponent.vue';

export default {
    components: {
        CommentComponent
    },
    props: ['comments'],
    emits: ['isEditting', 'deleteComment', 'loadListComment'],
    data() {
        return {
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

.load-more {
    text-align: right;
    margin-right: 1rem;
    margin-top: 1rem;
}

.load-more a {
    color: black;
    text-decoration: underline;
}
</style>