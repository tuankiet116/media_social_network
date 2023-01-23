<template>
    <div class="container">
        <ReplyComponent ref="comment" v-for="(comment, index) in comments" :comment="comment"
            @deleteReply="$emit('deleteReply', $event)" @displayReply="hiddenReply(index)"
            @isEditting="$emit('isEditting')" />
    </div>
    <div class="load-more">
        <a v-if="isLoadMore && comments.length" @click="loadReplies">{{ $t('load_more') }}</a>
    </div>
</template>

<script>
import ReplyComponent from './ReplyComponent.vue';

export default {
    components: {
        ReplyComponent
    },
    props: ['comments'],
    emits: ['isEditting', 'deleteReply', 'loadReplies'],
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
        loadReplies() {
            this.$emit('loadReplies', this.offset);
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
    margin-right: 1rem;
    margin-top: 1rem;
    text-align: right;
}

.load-more a {
    color: black;
    text-decoration: underline;
}
</style>