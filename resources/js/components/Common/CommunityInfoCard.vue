<template>
    <div v-if="communityInformation == null" class="card" style="padding: 20px">
        <p class="content">Loading...</p>
        <LoadingComponent :style="'position: initial;'"/>
    </div>
    <div v-else class="card">
        <div class="card-image">
            <figure class="image is-2by1">
                <img :src="communityInformation.background" alt="Image">
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
                <router-link :to="{ path: '/community/' + community.id }">
                    <div class="media-left">
                        <figure class="image is-48x48">
                            <img class="avatar-image" :src="communityInformation.image" alt="Image">
                        </figure>
                    </div>
                    <div class="media-content">
                        <p class="title is-4">{{ communityInformation.community_name }}</p>
                    </div>
                </router-link>
            </div>

            <div class="content">
                
            </div>
        </div>
    </div>
</template>

<script>
import { getCommunityAPI } from '../../api/community';
import LoadingComponent from './LoadingComponent.vue';

export default {
    data() {
        return {
            communityInformation: null
        };
    },
    props: ["community"],
    mounted() {
        if (!this.communityInformation) {
            this.loadcommunityInformation();
        }
    },
    methods: {
        loadcommunityInformation() {
            getCommunityAPI(this.community.id).then(result => {
                this.communityInformation = result.data;
            });
        }
    },
    components: { LoadingComponent }
}
</script>
<style scoped>
figure {
    padding: 0;
    margin: 0;
}

img {
    margin: 0;
}
</style>