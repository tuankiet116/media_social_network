<template>
    <div v-if="userInformation == null" class="card" style="padding: 20px">
        <p class="content">{{ $t('loading') }}</p>
        <loading-component :style="'position: initial;'"/>
    </div>
    <div v-else class="card">
        <div class="card-image">
            <figure class="image is-2by1">
                <img :src="userInformation.banner" alt="Image">
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
                <router-link :to="{ path: '/profile/' + user.id }">
                    <div class="media-left">
                        <figure class="image is-48x48">
                            <img :src="userInformation.image" class="avatar-image is-rounded" alt="Image" style="height: 48px">
                        </figure>
                    </div>
                    <div class="media-content">
                        <p class="title is-4">{{ userInformation.name }}</p>
                    </div>
                </router-link>
            </div>

            <div class="content">
                <h4>{{ $t('user_page.introduce') }}</h4>
                <blockquote v-if="userInformation.user_information && userInformation.user_school.length">
                    <p v-if="userInformation.user_information?.living_place">
                        {{ $t('user_page.living') }} {{ userInformation.user_information.living_place }}
                    </p>
                    <p v-for="user_school in userInformation.user_school">
                        <span v-if="user_school.end_year < new Date().getFullYear()">
                            {{ $t('user_page.graduated') }} {{ user_school.school_name }}
                        </span>
                        <span v-else>
                            {{ $t('user_page.studying') }} {{ user_school.school_name }}
                        </span>
                    </p>
                </blockquote>
                <blockquote v-else>
                    <p>{{ $t('user_page.no_infor') }}</p>
                </blockquote>
            </div>
        </div>
    </div>
</template>

<script>
import { getUserProfile } from '../../api/user';
import LoadingComponent from './LoadingComponent.vue';

export default {
  components: { LoadingComponent },
    data() {
        return {
            userInformation: null
        };
    },
    props: ['user'],
    mounted() {
        if (!this.userInformation) {
            this.loadUserInformation();
        }
    },
    methods: {
        loadUserInformation() {
            getUserProfile(this.user.id).then(result => {
                this.userInformation = result.data;
            });
        }
    }
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