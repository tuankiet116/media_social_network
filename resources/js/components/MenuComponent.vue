<template>
    <nav id="navbar" class="navbar" role="navigation" aria-label="main navigation"
        :style="!user ? 'display:flex' : ''">
        <div class="navbar-brand">
            <router-link @click="increaseKey" class="navbar-item" :to="{ name: 'home' }">
                <img src="/images/defaults/brand.png">
            </router-link>
            <a v-if="user !== null" role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
                @click="showNav = !showNav" :class="{ 'is-active': showNav }">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div id="navbar-menus" class="navbar-menu">
            <div class="navbar-start">
                <router-link @click="increaseKey" class="navbar-item" :to="{ name: 'home' }">
                    {{ $t('homepage') }}
                </router-link>
            </div>
        </div>
        <div class="control has-icons-right search-box">
            <input class="input is-rounded" type="search" placeholder="Search...">
            <span class="icon is-small is-right">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
                    <path fill="#ddd"
                        d="M23.822 20.88l-6.353-6.354c.93-1.465 1.467-3.2 1.467-5.059.001-5.219-4.247-9.467-9.468-9.467s-9.468 4.248-9.468 9.468c0 5.221 4.247 9.469 9.468 9.469 1.768 0 3.421-.487 4.839-1.333l6.396 6.396 3.119-3.12zm-20.294-11.412c0-3.273 2.665-5.938 5.939-5.938 3.275 0 5.94 2.664 5.94 5.938 0 3.275-2.665 5.939-5.94 5.939-3.274 0-5.939-2.664-5.939-5.939z" />
                </svg>
            </span>
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

        <div id="navbar-menus-user" class="navbar-menu" v-else :class="{ 'is-active': showNav }">
            <div class="navbar-end">
                <router-link @click="increaseKey" class="navbar-item is-hidden-mobile" :to="{ name: 'create_post' }">
                    <i class="fa-regular fa-square-plus"></i>
                    <span>&nbsp;{{ $t('menu.create_post') }}</span>
                </router-link>
                <div class="navbar-item is-hidden-mobile has-dropdown is-hoverable">
                    <a class="navbar-link">
                        <i class="fa-solid fa-bell"></i>
                        <span>&nbsp;{{ $t('menu.notification') }}</span>
                    </a>
                    <NotificationComponent />
                </div>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        <strong>{{ user.name }}</strong>
                        <span>
                            <img class="is-rounded" :src="user.image">
                        </span>
                    </a>
                    <div class="navbar-dropdown">
                        <router-link @click="increaseKey" class="navbar-item" :to="{ path: '/profile' }">
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
</template>

<script>
import NotificationComponent from './Common/NotificationComponent.vue';

export default {
    props: ["user"],
    data() {
        return {
            showNav: false,
            keyComponent: 0
        };
    },
    methods: {
        logout() {
            sessionStorage.removeItem("user");
            this.$store.commit("logoutUser");
        },
        increaseKey() {
            this.keyComponent++;
            this.$emit("increaseKey", this.keyComponent);
        }
    },
    components: { NotificationComponent }
}
</script>

<style scoped>
.navbar {
    background-color: #19B3E6;
    padding: 0 10px;
    position: sticky;
    top: 0;
}

.navbar-menu {
    flex-grow: 0 !important;
}

.navbar-start>a {
    color: white;
}

.navbar-start>a:hover,
a:focus {
    color: black;
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
    width: 30rem;
    margin-left: 0;
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
}
</style>