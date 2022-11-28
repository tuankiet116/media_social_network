<template>
    <div>
        <div v-if="posts.lenght">

        </div>
        <PostComponent @post-deleted="handleRemovePost" v-for="post in posts" :post="post" />
    </div>
</template>
<script>
import PostComponent from '../Post/Children/PostComponent.vue';
export default {
    data() {
        return {
            posts: []
        };
    },
    props: ['user'],
    components: { PostComponent },
    mounted() {
        this.fetchPost();
    },
    methods: {
        fetchPost() {
            let userId = this.$route.params?.id ?? this.user.id;
            if (userId) {
                
            }
        }
    }
}
</script>