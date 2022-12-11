<template>
    <div v-if="userInformation == null">
        Loading...
    </div>
    <div v-else class="card">
        <div class="card-image">
            <figure class="image is-4by3">
                <img :src="userInformation.banner" alt="Placeholder image">
            </figure>
        </div>
        <div class="card-content">
            <div class="media">
                <div class="media-left">
                    <figure class="image is-48x48">
                        <img :src="userInformation.image" alt="Placeholder image">
                    </figure>
                </div>
                <div class="media-content">
                    <p class="title is-4">{{ userInformation.name }}</p>
                </div>
            </div>

            <div class="content">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                Phasellus nec iaculis mauris. <a>@bulmaio</a>.
                <a href="#">#css</a> <a href="#">#responsive</a>
                <br>
                <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
            </div>
        </div>
    </div>
</template>

<script>
import { getUserProfile } from '../../../api/api';

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