<template>
    <div class="box m-0 p-1" v-if="notifications.length">
        
    </div>
    <div v-else>

    </div>
</template>
<script>
export default {
    data() {
        return {
            notifications: []
        }
    },
    mounted() {
        let user = this.$store.state.user;
        Echo.private('user_notification.' + user.id)
            .listen('Modules\\User\\Events\\NotificationEvent', (result) => {
            debugger
        })
    },
    methods: {
    }
}
</script>
<style scoped>
figure .avatar-image {
    height: 48px;
    width: 48px;
}
</style>