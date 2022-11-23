<template>
    <div class="navbar-dropdown is-active">
        <a class="navbar-item">
            {{ $t('profile') }}
        </a>
        <hr class="navbar-divider">
        <a class="navbar-item">
            {{ $t('logout') }}
        </a>
    </div>
</template>
<script>
export default {
    data() {
        return {};
    },
    mounted() {
        Echo.private('user_notification').listen('Modules\\User\\Events\\NotificationEvent', (result) => {
            debugger
        })
    }
}
</script>