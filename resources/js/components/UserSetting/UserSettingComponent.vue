<template>
    <div id="setting" class="container mt-5">
        <div class="content">
            <h3><span><i class="fa-solid fa-gear"></i> Setting Your Profile</span></h3>
        </div>
        <div class="box columns">
            <div class="column is-2 is-flex-tablet">
                <aside class="menu">
                    <p class="menu-label">
                        General
                    </p>
                    <ul class="menu-list">
                        <li>
                            <router-link :to="{ name: 'edit_profile_basic' }"
                                :class="{ 'is-active': $route.name == 'edit_profile_basic' }">
                                Basic Information
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'edit_profile_avatar' }"
                                :class="{ 'is-active': $route.name == 'edit_profile_avatar' }">
                                Avatar
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'edit_profile_background' }"
                                :class="{ 'is-active': $route.name == 'edit_profile_background' }">
                                Background
                            </router-link>
                        </li>
                    </ul>
                    <p class="menu-label">
                        Account
                    </p>
                    <ul class="menu-list">
                        <li>
                            <router-link :to="{ name: 'edit_profile_password' }"
                                :class="{ 'is-active': $route.name == 'edit_profile_password' }">
                                Password Settings
                            </router-link>
                        </li>
                    </ul>
                </aside>
            </div>
            <div class="column">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>
<script>
import authMixin from '../../mixins';
export default {
    mixins: [authMixin]
}
</script>