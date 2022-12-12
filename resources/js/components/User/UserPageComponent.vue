<template>
    <div id="profile" class="profile">
        <div class="profile-banner" :style="{ 'background-image': 'url(' + user.banner + ')'}">
        </div>
        <div class="profile-picture level is-mobile">
            <div v-if="!auth" class="level-item is-justify-content-right">
                <a class="button is-rounded">
                    <span><i class="fa-solid fa-message"></i> Chat</span>
                </a>
            </div>
            <div class="level-item middle-item" :class="{ 'pl-5': auth }">
                <div>
                    <figure class="image is-128x128">
                        <img class="is-rounded" :src="user.image">
                    </figure>
                    <div class="mt-2 has-text-centered">
                        <span>{{ user.name }}</span>
                    </div>
                </div>
            </div>
            <div class="level-item is-justify-content-left">
                <a v-if="!auth" class="button is-rounded">
                    <span><i class="fa-solid fa-plus"></i> Follow</span>
                </a>
                <router-link v-else class="button is-rounded" :to="{name: 'edit_profile'}">
                    Edit
                </router-link>
            </div>
            <br>
        </div>
        <div class="profile-menu level is-mobile box">
            <div class="level-item is-justify-content-center is-align-items-center">
                <router-link class="heading" :to="{name: 'list_post'}">
                    <span><i class="fa-solid fa-message"></i> Bài viết</span>
                </router-link>
            </div>
            <div class="level-item is-justify-content-center is-align-items-center">
                <a class="heading">
                    <span><i class="fa-solid fa-message"></i> Theo dõi</span>
                </a>
            </div>
            <div class="level-item is-justify-content-center is-align-items-center">
                <a class="heading">
                    <span><i class="fa-solid fa-message"></i> Đang Theo Dõi</span>
                </a>
            </div>
        </div>
        <div>
            <router-view :user="user"></router-view>
        </div>
    </div>
</template>
<script>
import authMixin from '../../mixins';
import { getUserProfile, getProfile } from '../../api/api';

export default {
    mixins: [authMixin],
    data() {
        return {
            user: {},
        };
    },
    mounted() {
        let height = document.getElementById('navbar').offsetHeight;
        let profile = document.getElementById('profile');
        if (profile) {
            profile.style.marginTop = Number(height) + 'px';
            profile.style.marginBottom = Number(height / 2) + 'px';
        }
        this.getUserInformation();
    },
    computed: {
        auth() {
            let user = this.$store.getters.getUser;
            if (user?.id == this.user?.id) {
                return true;
            }
            return false;
        }
    },
    methods: {
        getUserInformation() {
            let guestID = this.$route.params?.id;
            if (guestID) {
                getUserProfile(guestID).then(result => {
                    this.user = result.data;
                }).catch(error => {
                    console.log(error)
                })
            } else {
                getProfile().then(result => {
                    this.user = result.data;
                }).catch(error => {
                    console.log(error)
                })
            }
        }
    }
}
</script>
<style scoped>
.profile-banner {
    background-size: cover;
    background-repeat: no-repeat;
    max-width: 1000px;
    height: 400px;
}

.profile-picture {
    position: relative;
    bottom: 5rem;
}

.profile-picture img {
    border: white solid 4px;
    background-color: white;
}

.middle-item {
    flex-grow: 0 !important;
}

.profile {
    max-width: 1000px;
    margin: auto;
}

.level-item .button {
    margin-top: 2rem;
    width: 100px;
}

.profile-menu {
    margin-top: -5rem;
}

.heading {
    font-size: 15px;
}

@media screen and (min-width: 731px) {
    .profile-banner {
        border-radius: 0 0 20px 20px;
    }
}

@media screen and (max-width: 731px) {
    .profile-banner {
        border-radius: 0 0 20px 20px;
    }

    .profile-picture {
        bottom: 12rem !important;
        color: white;
        font-size: large;
        font-weight: 600;
    }
}
</style>