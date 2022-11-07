<template>
    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation"
        :style="!user ? 'display:flex' : ''">
        <div class="navbar-brand">
            <router-link @click="increaseKey" class="navbar-item" :to="{ name: 'home' }">
                <img src="/images/default/brand.png">
            </router-link>
            <a v-if="user !== null" role="button" class="navbar-burger" aria-label="menu" aria-expanded="false"
                @click="showNav = !showNav" :class="{ 'is-active': showNav }">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbar-menus" class="navbar-menu is-hidden-mobile">
            <div class="navbar-start">
                <router-link  @click="increaseKey" class="navbar-item" :to="{ name: 'home' }">
                    {{ $t('homepage') }}
                </router-link>

                <a class="navbar-item">
                    {{ $t('film_feed') }}
                </a>
            </div>
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
                <div class="navbar-item has-dropdown is-hoverable user-nav" @click="showMenu">
                    <a class="navbar-link">
                        <strong>{{ user.name }}</strong>
                        <span>
                            <img class="is-rounded" src="/images/default/avatar_default.png">
                        </span>
                    </a>
                    <div class="navbar-dropdown">
                        <a class="navbar-item">
                            {{ $t('profile') }}
                        </a>
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
export default {
    props: ['user'],
    data() {
        return {
            showNav: false,
            keyComponent: 0
        };
    },
    methods: {
        logout() {
            sessionStorage.removeItem("user");
            this.$store.commit('logoutUser');
        },
        showMenu(e) {
            let classActive = document.getElementsByClassName('user-nav')[0].className.split(' ').find((c) => c == 'is-active');
            if (classActive) {
                document.getElementsByClassName('user-nav')[0].classList.remove('is-active');
            } else {
                document.getElementsByClassName('user-nav')[0].classList.add('is-active');
            }
        },
        increaseKey() {
            this.keyComponent++;
            this.$emit('increaseKey', this.keyComponent);
        }
    }
}
</script>

<style scoped>
.navbar {
    background-color: #4158D0;
    background-image: linear-gradient(43deg, #4158D0 0%, #C850C0 46%, #FFCC70 100%);
    padding: 0 10px;
}

.navbar-start>a {
    color: white;
}

.navbar-start>a:hover, a:focus{
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
    }

    .items-button {
        position: fixed;
        right: 0;
    }
}
</style>