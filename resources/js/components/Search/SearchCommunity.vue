<template>
    <div v-if="results.length" v-for="r in results">
        <router-link class="box is-flex mb-1 p-2" :to="{ name: 'community_page', params: { id: r.id } }" @click="insertHistory(r.id)">
            <figure class="image is-64x64">
                <img class="is-rounded avatar-image" :src="r.image" />
            </figure>
            <div class="content is-flex is-justify-content-center is-align-items-center ml-2 mb-0">
                <h5>
                    {{ r.community_name }}
                </h5>
            </div>
            <div v-if="r.isJoined" class="is-flex justify-content-center is-align-items-center" style="margin-left: auto">
                <button class="button is-info is-rounded disabled">
                    {{ $t('community.followed') }}
                </button>
            </div>
        </router-link>
    </div>
    <LoadingComponent v-if="isLoading" />
    <NotFoundSearchComponent v-if="isNotFound" />
</template>
<script>
import authMixin from '../../mixins';
import { searchCommunity, insertHistorySearch } from '../../api/search';
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
            await searchCommunity(this.keyword).then(res => {
                console.log(res);
                this.results = res.data.communities;
                this.offset = res.data.offset;
                if (!res.data.communities.length) {
                    this.isNotFound = true
                }
            });
            this.isLoading = false;
        },
        async insertHistory(communityId) {
            let data = {
                keyword: this.keyword,
                result_id: communityId,
                result_type: 'SEARCH_TYPE_COMMUNITY'
            }
            await insertHistorySearch(data);
        }
    }
}
</script>
<style scoped>
/deep/ .post-box {
    margin-right: auto !important;
}

.avatar-image {
    width: 64px;
    height: 64px;
}
</style>
