<template>
    <div id="setting" class="container">
        <div class="content">
            <h2><span><i class="fa-solid fa-gear"></i> Setting</span></h2>
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
                <router-view :user="user"></router-view>
            </div>
        </div>
    </div>
</template>
<script>
import { getProfile } from '../../api/user';
import authMixin from '../../mixins';
export default {
    data() {
        return {
            user: null
        };
    },
    mixins: [authMixin],
    mounted() {
        this.getUserInformation();
    },
    methods: {
        getUserInformation() {
            getProfile().then(result => {
                this.user = result.data;
            }).catch(error => {
                console.log(error)
            })
        }
    },
}
</script>