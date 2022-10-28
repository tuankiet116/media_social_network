<template>
    <div class="box">
        <video v-if="userPost.src" :src="userPost.src"></video>
    </div>
</template>
<script>
import CommentComponent from '../Children/CommentComponent.vue';
export default {
    components: {CommentComponent},
    props: ['post'],
    data() {
        return {
            userPost: this.post
        };
    }
}
</script>
<style scoped>
    .box {
        margin: 5rem 30rem;
    }
</style>