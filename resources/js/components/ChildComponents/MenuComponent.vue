<template>
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <router-link class="navbar-item" :to="{ name: 'home'}">
                <img src="/images/default/brand.png">
            </router-link>


            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar-menus">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbar-menus" class="navbar-menu">
            <div class="navbar-start">
                <router-link class="navbar-item" :to="{ name: 'home'}">
                    {{ $t('homepage') }}
                </router-link>

                <a class="navbar-item">
                    {{ $t('film_feed') }}
                </a>

                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">
                        More
                    </a>

                    <div class="navbar-dropdown">
                        <a class="navbar-item">
                            About
                        </a>
                        <a class="navbar-item">
                            Jobs
                        </a>
                        <a class="navbar-item">
                            Contact
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item">
                            Report an issue
                        </a>
                    </div>
                </div>
            </div>

            <div class="navbar-end" v-if="user==null">
                <div class="navbar-item">
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
            <div class="navbar-end" v-else>
                <router-link class="navbar-item" :to="{name: 'create_post'}">
                    <i class="fa-regular fa-square-plus"></i>
                    <span>&nbsp;{{ $t('menu.create_post') }}</span>
                </router-link>
                <div class="navbar-item has-dropdown is-hoverable">
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
        return {};
    },
    methods: {
        logout() {
            sessionStorage.removeItem("user");
            this.$store.commit('logoutUser');
        }
    }
}
</script>

<style scoped>
.navbar {
    background-color: rgba(24, 68, 151, 0.437);
    padding: 0 10px;
}

.navbar img {
    max-height: fit-content;
    width: 60px;
    height: 60px;
}
</style>