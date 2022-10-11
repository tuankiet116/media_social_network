<template>
    <nav class="navbar" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item" href="https://bulma.io">
                <img src="/images/default/brand.png">
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbar-menus">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbar-menus" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item">
                    {{ $t('homepage') }}
                </a>

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

            <div class="navbar-end" v-if="user===null">
                <div class="navbar-item">
                    <div class="buttons">
                        <a class="button is-primary">
                            <strong>{{ $t('login') }}</strong>
                        </a>
                        <a class="button is-light">
                            {{ $t('login') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="navbar-end" v-else>
                <div class="navbar-item has-dropdown is-hoverable">

                    <a class="navbar-link">
                        <strong>AA</strong>
                        <span>
                            <img class="is-rounded" src="/images/default/avatar_default.png">
                        </span>
                    </a>
                    <div class="navbar-dropdown">
                        <a class="navbar-item">
                            {{ $t('profile') }}
                        </a>
                        <hr class="navbar-divider">
                        <a class="navbar-item" :click="logout()">
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
    data() {
        return {}
    },
    methods: {
        logout() {
            this.user = null;
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