<template>
    <div v-if="userInformation == null">
        Loading...
    </div>
    <div v-else class="card">
        <div class="card-image">
            <figure class="image is-2by1">
                <img :src="userInformation.banner" alt="Placeholder image">
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
                <router-link :to="{ path: '/profile/' + user.id }">
                    <div class="media-left">
                        <figure class="image is-48x48">
                            <img :src="userInformation.image" alt="Placeholder image">
                        </figure>
                    </div>
                    <div class="media-content">
                        <p class="title is-4">{{ userInformation.name }}</p>
                    </div>
                </router-link>
            </div>

            <div class="content">
                <h4>Giới Thiệu</h4>
                <blockquote v-if="userInformation.user_information && userInformation.user_school.length">
                    <p v-if="userInformation.user_information?.living_place">
                        Đang sống ở {{ userInformation.user_information.living_place }}
                    </p>
                    <p v-for="user_school in userInformation.user_school">
                        <span v-if="user_school.end_year < new Date().getFullYear()">
                            Đã tốt nghiệp {{ user_school.school_name }}
                        </span>
                        <span v-else>
                            Đang học {{ user_school.school_name }}
                        </span>
                    </p>
                </blockquote>
                <blockquote v-else>
                    <p>No Information</p>
                </blockquote>
            </div>
        </div>
    </div>
</template>

<script>
import { getUserProfile } from '../../api/api';

export default {
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