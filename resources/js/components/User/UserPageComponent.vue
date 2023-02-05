<template>
    <div id="profile" class="profile">
        <div class="profile-banner" :style="{ 'background-image': 'url(' + user.banner + ')' }"></div>
        <div class="profile-picture is-mobile">
            <div class="level m-0" v-if="Object.keys(user).length">
                <div v-if="!isMe && auth" class="level-item is-justify-content-right">
                    <router-link :to="{ name: 'message', params: { id: user.id } }" class="button is-rounded">
                        <span>
                            <i class="fa-solid fa-message"></i>
                            {{ $t('user_page.chat') }}
                        </span>
                    </router-link>
                </div>
                <div class="level-item middle-item" :class="{ 'pl-5': isMe || !auth }">
                    <div>
                        <figure class="image is-128x128">
                            <img class="is-rounded avatar-image" :src="user.image" />
                        </figure>
                    </div>
                </div>
                <div v-if="auth" class="level-item is-justify-content-left">
                    <a v-if="!isMe && auth" class="button is-rounded" @click="handleFollowUser">
                        <span v-if="user.isFollowed">
                            <i class="fa-solid fa-check"></i>
                            {{ $t('user_page.followed') }}
                        </span>
                        <span v-else>
                            <i class="fa-solid fa-plus"></i>
                            {{ $t('user_page.follow') }}
                        </span>
                    </a>
                    <router-link v-else class="button is-rounded" :to="{ name: 'edit_profile_basic' }">
                        {{ $t('edit') }}
                    </router-link>
                </div>
            </div>
            <div class="columns">
                <div class="has-text-weight-bold is-size-5 has-text-centered column"
                    :class="{ 'is-one-fifth': isMe || !auth }">
                    <span>{{ user.name }}</span>
                </div>
            </div>
            <br />
        </div>
        <div class="profile-menu level is-mobile box">
            <div class="level-item is-justify-content-center is-align-items-center">
                <router-link class="heading" :to="{ name: 'profile_list_post' }">
                    <span>
                        <i class="fa-solid fa-message"></i>
                        {{ $t('user_page.post') }}
                    </span>
                </router-link>
            </div>
            <div class="level-item is-justify-content-center is-align-items-center">
                <router-link class="heading" :to="{ name: 'profile_list_follower' }">
                    <span>
                        <strong>{{ user.follower_count }}</strong>
                        {{ $t('user_page.follow') }}
                    </span>
                </router-link>
            </div>
            <div class="level-item is-justify-content-center is-align-items-center">
                <router-link class="heading" :to="{ name: 'profile_list_following' }">
                    <span>
                        <strong>{{ user.following_count }}</strong>
                        {{ $t('user_page.following') }}
                    </span>
                </router-link>
            </div>
        </div>
        <div>
            <router-view :key="$route.fullPath" :user="user"></router-view>
        </div>
    </div>
</template>
<script>
import { getUserProfile, getProfile, followUser, unfollowUser } from "../../api/user";

export default {
    data() {
        return {
            userId: this.$route.params.id,
            user: {},
        };
    },
    mounted() {
        this.getUserInformation();
    },
    computed: {
        isMe() {
            let user = this.$store.getters.getUser;
            if (user !== null && user?.id == this.user?.id) {
                return true;
            }
            return false;
        },
        auth() {
            return this.$store.getters.getUser;
        }
    },
    methods: {
        getUserInformation() {
            let guestID = this.userId;
            if (guestID) {
                getUserProfile(guestID)
                    .then((result) => {
                        this.user = result.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            } else {
                getProfile()
                    .then((result) => {
                        this.user = result.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
        handleFollowUser() {
            if (this.user.isFollowed) {
                this.unfollowUser();
                this.user.isFollowed = false;
            } else {
                this.followUser();
                this.user.isFollowed = true;
            }
        },
        followUser() {
            let data = {
                user_id: this.user.id,
            };
            followUser(data).then(result => {
                this.user.follower_count = result.data.follower_count;
            });
        },
        unfollowUser() {
            let data = {
                user_id: this.user.id,
            };
            unfollowUser(data).then(result => {
                this.user.follower_count = result.data.follower_count;
            });
        }
    },
};
</script>
<style scoped>
.profile-banner {
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
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

.avatar-image {
    height: 120px;
    object-fit: cover;
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
