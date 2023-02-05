<template>
    <div id="setting" class="container mt-5">
        <div class="content">
            <h3><span><i class="fa-solid fa-gear"></i> {{ $t('user_setting.setting') }}</span></h3>
        </div>
        <div class="box columns">
            <div class="column is-2 is-flex-tablet">
                <aside class="menu">
                    <p class="menu-label">
                        {{ $t('user_setting.general') }}
                    </p>
                    <ul class="menu-list">
                        <li>
                            <router-link :to="{ name: 'edit_profile_basic' }"
                                :class="{ 'is-active': $route.name == 'edit_profile_basic' }">
                                {{ $t('user_setting.basic') }}
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'edit_profile_avatar' }"
                                :class="{ 'is-active': $route.name == 'edit_profile_avatar' }">
                                {{ $t('user_setting.avatar_setting') }}
                            </router-link>
                        </li>
                        <li>
                            <router-link :to="{ name: 'edit_profile_background' }"
                                :class="{ 'is-active': $route.name == 'edit_profile_background' }">
                                {{ $t('user_setting.background_setting') }}
                            </router-link>
                        </li>
                    </ul>
                    <p class="menu-label">
                        {{ $t('user_setting.account') }}
                    </p>
                    <ul class="menu-list">
                        <li>
                            <router-link :to="{ name: 'edit_profile_password' }"
                                :class="{ 'is-active': $route.name == 'edit_profile_password' }">
                                {{ $t('user_setting.password_setting') }}
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
export default {
}
</script>