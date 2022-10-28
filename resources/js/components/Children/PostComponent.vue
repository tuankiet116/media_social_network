<template>
    <div class="box has-text-centered">
        
        <video v-if="userPost.src" :key="video" width="450" controls>
            <source :src="userPost.src" type="video/mp4">
        </video>
    </div>
</template>
<script>
import CommentComponent from '../Children/CommentComponent.vue';
export default {
    components: { CommentComponent },
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