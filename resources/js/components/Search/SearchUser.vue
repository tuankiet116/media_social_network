<template>
    <div v-if="results.length" v-for="r in results">
        <router-link class="box is-flex mb-1 p-2" :to="{ name: 'profile_list_post', params: { id: r.id } }">
            <figure class="image is-64x64">
                <img class="is-rounded avatar-image" :src="r.image"/>
            </figure>
            <div class="content is-flex is-justify-content-center is-align-items-center ml-2">
                <h5>
                    {{ r.name }}
                </h5>
            </div>
            <div v-if="r.isFollowed">
                <button class="button is-info">
                    Followed
                </button>
            </div>
        </router-link>
    </div>
    <LoadingComponent v-if="isLoading"/>
</template>
<script>
import authMixin from '../../mixins';
import { searchUser } from '../../api/search';
import PostComponent from '../Post/Children/PostComponent.vue';
import NotFoundComponent from '../Common/errors/NotFoundComponent.vue';
import LoadingComponent from '../Common/LoadingComponent.vue';
export default {
    components: { PostComponent, NotFoundComponent, LoadingComponent },
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
            await searchUser(this.keyword).then(res => {
                console.log(res);
                this.results = res.data.users;
                this.offset = res.data.offset;
                if (!res.data.users.length) {
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

.avatar-image {
    width: 64px;
    height: 64px;
}
</style>
