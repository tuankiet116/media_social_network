<template>
    <div id="profile" class="profile">
        <div
            class="profile-banner"
            :style="{ 'background-image': 'url(' + community.background + ')' }"
        ></div>
        <div class="profile-picture level is-mobile">
            <div
                v-if="!isMine && auth"
                class="level-item is-justify-content-right"
            >
                <a class="button is-rounded">
                    <span>
                        <i class="fa-solid fa-message"></i>
                        Chat
                    </span>
                </a>
            </div>
            <div class="level-item middle-item" :class="{ 'pl-5': isMine }">
                <div>
                    <figure class="image is-128x128">
                        <img class="is-rounded avatar-image" :src="community.image" />
                    </figure>
                    <div class="mt-2 has-text-centered">
                        <span>{{ community.community_name }}</span>
                    </div>
                </div>
            </div>
            <div v-if="auth" class="level-item is-justify-content-left">
                <a v-if="!isMine && auth" class="button is-rounded">
                    <span>
                        <i class="fa-solid fa-plus"></i>
                        Join
                    </span>
                </a>
                <router-link
                    v-else
                    class="button btn-setting is-rounded"
                    :to="{
                        name: 'community_setting_basic',
                        params: { id: community.id },
                    }"
                >
                    <span>
                        <i class="fa-solid fa-gear"></i> Setting Community
                    </span>
                </router-link>
            </div>
            <br />
        </div>
        <div class="profile-menu level is-mobile box">
            <div
                class="level-item is-justify-content-center is-align-items-center"
            >
                <router-link class="heading" :to="{ name: 'community_page' }">
                    <span>
                        <i class="fa-solid fa-message"></i>
                        Bài viết
                    </span>
                </router-link>
            </div>
        </div>
        <div>
            <router-view :community="community"></router-view>
        </div>
    </div>
</template>
<script>
import authMixin from "../../mixins";
import { getCommunityAPI } from "../../api/community";

export default {
    mixins: [authMixin],
    data() {
        return {
            community: {},
        };
    },
    mounted() {
        this.getCommunity();
    },
    computed: {
        isMine() {
            let user = this.$store.getters.getUser;
            if (user !== null && user?.id == this.community?.user_id) {
                return true;
            }
            return false;
        },
    },
    methods: {
        getCommunity() {
            let id = this.$route.params?.id;
            if (id) {
                getCommunityAPI(id)
                    .then((result) => {
                        this.community = result.data;
                    })
                    .catch((error) => {
                        console.log(error);
                    });
            }
        },
    },
};
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

.btn-setting {
    width: fit-content !important;
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
