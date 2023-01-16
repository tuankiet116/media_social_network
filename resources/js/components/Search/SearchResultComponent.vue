<template>
    <div v-if="!isNotFound" v-for="r in results">
        <PostComponent :post="r"/>
    </div>
    <div v-else>
        <NotFoundComponent/>
    </div>
</template>
<script>
import authMixin from '../../mixins';
import { searchAll } from '../../api/search';
import PostComponent from '../Post/Children/PostComponent.vue';
import NotFoundComponent from '../Common/errors/NotFoundComponent.vue';
export default {
    components: { PostComponent, NotFoundComponent },
    data() {
        return {
            keyword: this.$route.params.keyword,
            results: [],
            offset: 0,
            isNotFound: false
        }
    },
    mixins: [authMixin],
    mounted() {
        this.search();
    },
    methods: {
        async search() {
            await searchAll(this.keyword).then(res => {
                console.log(res);
                this.results = res.data.posts;
                this.offset = res.data.offset;
                if (!res.data.posts.length) {
                    this.isNotFound = true
                }
            });
        }
    }
}
</script>
<style scoped>
/deep/ .post-box {
    margin-right: auto !important;
}
</style>
