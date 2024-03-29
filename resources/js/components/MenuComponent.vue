<template>
    <div style="position:sticky; top: 0; z-index: 20">
        <nav class="navbar is-flex" role="navigation" aria-label="main navigation" :style="!user ? 'display:flex' : ''">
            <div class="navbar-brand">
                <router-link @click="increaseKey" class="navbar-item" :to="{ name: 'home' }">
                    <img src="/images/defaults/brand.png">
                </router-link>
            </div>
            <div class="navbar-menu">
                <div class="navbar-start">
                    <router-link @click="updateHome" class="navbar-item" :to="{ name: 'home' }">
                        {{ $t('homepage') }}
                    </router-link>
                </div>
            </div>
            <div class="control search-box is-flex is-align-items-center" @keypress.enter="redirectSearch">
                <input class="input is-rounded" type="search" @click="openSearch = true" v-model="search"
                    :placeholder="$t('search')">
            </div>
            <div class="navbar-end buttons-auth is-pulled-right" v-if="user == null">
                <div class="navbar-item items-button">
                    <div class="buttons">
                        <a class="button is-primary" href="/user/login">
                            <strong>{{ $t('login') }}</strong>
                        </a>
                        <a class="button is-light" href="/user/register">
                            {{ $t('signup') }}
                        </a>
                    </div>
                </div>
            </div>

            <div id="navbar-menus-user" class="navbar-menu is-active is-hidden-mobile" v-else>
                <div class="navbar-end">
                    <div v-if="user.groups.length" class="navbar-item has-dropdown is-hoverable" style="height: 100%;">
                        <a class="navbar-link">
                            {{ $t('community_text') }}
                        </a>
                        <div class="navbar-dropdown">
                            <router-link v-for="gr of user.groups" @click="increaseKey" class="navbar-item"
                                :to="{ path: `/community/${gr.id}` }">
                                <figure class="is-64x64 image">
                                    <img class="is-rounded avatar-image" :src="gr.image" />
                                </figure>
                                <p class="m-2">{{ gr.community_name }}</p>
                            </router-link>
                            <hr class="navbar-divider">
                            <!-- <router-link @click="increaseKey" class="navbar-item"
                                :to="{ name: 'profile_list_post', params: { id: user.id } }">
                                See All Community
                            </router-link> -->
                        </div>
                    </div>
                    <router-link @click="increaseKey" class="navbar-item is-hidden-mobile"
                        :to="{ name: 'create_post' }">
                        <i class="fa-regular fa-square-plus"></i>
                        <span>&nbsp;{{ $t('menu.create_post') }}</span>
                    </router-link>
                    <a class="navbar-item is-hidden-mobile" @click="markReadAllNotification" data-show="quickview"
                        data-target="quickviewDefault">
                        <i class="fa-solid fa-bell"></i>
                        <span>&nbsp;{{ $t('menu.notification') }}</span>
                        <span v-if="unreadNotifications" class="badge">&nbsp;{{ unreadNotifications }}</span>
                    </a>
                    <router-link class="navbar-item is-hidden-mobile" :to="{ name: 'list_chat' }">
                        <i class="fa-solid fa-comments"></i>
                        <span>&nbsp;{{ $t('chat.title') }}</span>
                        <span v-if="unreadMessagesCount" class="badge">&nbsp;{{ unreadMessagesCount }}</span>
                    </router-link>
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            <strong>{{ user.name }}</strong>
                            <figure class="image ml-2">
                                <img class="is-rounded avatar-image" :src="user.image">
                            </figure>
                        </a>
                        <div class="navbar-dropdown">
                            <router-link @click="increaseKey" class="navbar-item"
                                :to="{ name: 'profile_list_post', params: { id: user.id } }">
                                {{ $t('profile') }}
                            </router-link>
                            <hr class="navbar-divider">
                            <a class="navbar-item" @click="logout">
                                {{ $t('logout') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <SearchBoxComponent v-if="openSearch" :keywords="search" @redirectSearch="openSearch = false"
            class="search-box-result" />
    </div>
    <NotificationComponent />
</template>

<script>
import NotificationComponent from './Common/NotificationComponent.vue';
import SearchBoxComponent from './Search/SearchBoxComponent.vue';
import { detectMobile } from '../helpers/common';
import { markReadAll } from '../api/notification';
export default {
    props: ["user"],
    data() {
        return {
            showNav: false,
            keyComponent: 0,
            search: "",
            openSearch: false,
            unreadNotifications: 0,
            unreadMessagesCount: 0
        };
    },
    watch: {
        '$store.getters.getUnreadNotifications': function (data) {
            this.unreadNotifications = data;
        },
        '$store.getters.getUnreadMessages': {
            handler: function (data) {
                this.unreadMessagesCount = data.length;
            },
            deep: true
        }
    },
    mounted() {
        document.querySelector('body').addEventListener('click', this.handleClickOutside);
    },
    methods: {
        logout() {
            sessionStorage.removeItem("user");
            this.$store.commit("logoutUser");
        },
        increaseKey() {
            this.keyComponent++;
            this.$emit("increaseKey", this.keyComponent);
        },
        redirectSearch() {
            let routerName = this.$route.name;
            if (routerName == 'search_page' ||
                routerName == 'search_user' ||
                routerName == 'search_post' ||
                routerName == 'search_community')
                if (this.search) {
                    this.$router.push({ name: routerName, params: { keyword: this.search } });
                }
        },
        isMobile() {
            return detectMobile();
        },
        handleClickOutside(event) {
            if (!event.target.closest('.search-box-result') && !event.target.closest('.search-box')) {
                this.openSearch = false;
            }
        },
        markReadAllNotification() {
            markReadAll().then(result => {
                if (result) {
                    this.$store.state.unreadNotifications = 0;
                }
            });
        },
        updateHome() {
            this.$store.state.eventUpdateDashboard = true;
        }
    },
    components: { NotificationComponent, SearchBoxComponent }
}
</script>

<style scoped>
.navbar {
    position: sticky;
    top: 0;
    box-shadow: 0 2px 4px 0 rgba(0, 0, 0, .2);
}

.navbar-menu {
    flex-grow: 0 !important;
    padding: 0;
    margin: 0;
    box-shadow: none;
}

.navbar img {
    max-height: fit-content;
    width: 60px;
    height: 60px;
}

.navbar-link {
    display: flex;
    align-items: center;
}

.search-box {
    margin: auto;
    margin-left: 0;
}

.search-box-result {
    position: absolute;
    width: 30rem;
}

.badge {
    padding: 2px;
    background: crimson;
    border-radius: 100%;
    width: 32px;
    height: 32px;
    align-items: center;
    display: flex;
    justify-content: center;
}

.navbar-end {
    align-items: center !important;
}

.navbar-end a {
    height: 100% !important;
}

@media screen and (max-width: 768px) {
    .navbar {
        padding: 0 !important;
    }

    .navbar img {
        max-height: fit-content;
        width: 20px;
        height: 20px;
    }

    .buttons>.button {
        width: 65px !important;
        font-size: 10px;
    }

    .buttons-auth {
        display: flex;
        align-items: center;
        width: -webkit-fill-available;
    }

    .items-button {
        position: fixed;
        right: 0;
    }

    .search-box-result {
        width: 20rem;
    }
}
</style>