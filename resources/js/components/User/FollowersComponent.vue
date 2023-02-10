<template>
    <div class="box container" :style="{ 'min-height: unset': !followers.length }">
        <div v-if="followers.length" class="columns"
            v-for="i in Math.ceil(followers.length / 2)">
            <div class="column" v-for="user in followers.slice((i - 1) * 2, i * 2)">
                <div class="is-flex">
                    <div class="user_image" @mouseover="displayUserInformation = true">
                        <router-link :to="{ name: 'profile_list_post', params: { id: user.follower.id } }">
                            <figure class="image is-64x64 avatar-image">
                                <img class="is-rounded" :src="user.follower.image" />
                            </figure>
                        </router-link>
                        <div class="user-card">
                            <KeepAlive>
                                <UserInforCard v-if="displayUserInformation" :user="user.follower" />
                            </KeepAlive>
                        </div>
                    </div>
                    <div class="is-justify-content-left ml-2 user_name">
                        <router-link :to="{ name: 'profile_list_post', params: { id: user.follower.id } }">
                            {{ user.follower.name }}
                        </router-link>
                        <div class="user-card">
                            <KeepAlive>
                                <UserInforCard v-if="displayUserInformation" :user="user.follower" />
                            </KeepAlive>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class=" has-text-centered">
            <p class="content is-size-4">{{ $t('user_page.no_follower') }}</p>
            <figure>
                <img src="../../../images/gifs/sad_stitch.gif"/>
            </figure>
        </div>
    </div>
</template>
<script>
import { getFollower } from '../../api/user';
import UserInforCard from '../Common/UserInforCard.vue';
export default {
    props: ['user'],
    components: { UserInforCard },
    data() {
        return {
            followers: [],
            offset: 0,
            displayUserInformation: false
        };
    },
    mounted() {
        this.getFollower();
    },
    watch: {
        user() {
            this.followers = [];
            this.getFollower();
        }
    },
    methods: {
        getFollower() {
            if (!this.user.id) return;
            getFollower(this.user.id, this.offset).then(result => {
                this.followers = result.data.followers;
                this.offset = result.data.offset;
            });
        }
    }
}
</script>
<style scoped>
.container {
    min-height: 20rem;
}

.user-card {
    position: absolute;
    z-index: 10;
    width: 300px;
    display: none;
    top: 5rem;
}

.user_name {
    display: flex;
    align-items: center;
}

.user_name:hover .user-card {
    display: block;
    transform: translate(0, -20px);
    transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
}

.user_image:hover .user-card {
    display: block;
    transform: translate(0, -20px);
    transition: all 0.5s cubic-bezier(0.75, -0.02, 0.2, 0.97);
}
</style>