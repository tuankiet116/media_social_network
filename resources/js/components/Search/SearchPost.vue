<template>
    <div v-if="!isNotFound" v-for="r in results">
        <PostComponent :post="r"/>
    </div>
    <div v-else>
        <NotFoundSearchComponent/>
    </div>
    <div v-if="isLoading">
        <LoadingComponent/>
    </div>
</template>
<script>
import authMixin from '../../mixins';
import { searchPost } from '../../api/search';
import PostComponent from '../Post/Children/PostComponent.vue';
import NotFoundSearchComponent from '../Common/errors/NotFoundSearchComponent.vue';
import LoadingComponent from '../Common/LoadingComponent.vue';
export default {
    components: { PostComponent, NotFoundSearchComponent, LoadingComponent },
    data() {
        return {
            keyword: this.$route.params.keyword,
            results: [],
            offset: 0,
            isNotFound: false,
            isLoading: false
        }
    },
    mixins: [authMixin],
    mounted() {
        this.search();
    },
    methods: {
        async search() {
            this.isLoading = true;
            await searchPost(this.keyword).then(res => {
                console.log(res);
                this.results = res.data.posts;
                this.offset = res.data.offset;
                if (!res.data.posts.length) {
                    this.isNotFound = true
                }
            });
            this.isLoading = false;
        }
    }
}
</script>
<style scoped>
/deep/ .post-box {
    margin-right: auto !important;
}
</style>
