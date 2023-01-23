<template>
    <div id="quickviewDefault" class="quickview">
        <header class="quickview-header">
            <p class="title">Quickview title</p>
            <span class="delete" data-dismiss="quickview"></span>
        </header>

        <div class="quickview-body">
            <div class="quickview-block">
                ...
            </div>
        </div>

        <footer class="quickview-footer">

        </footer>
    </div>
</template>
<script>
export default {
    data() {
        return {
            notifications: [],
            offset: 0
        }
    },
    watch: {
        '$store.getters.getUser': function(data) {
            this.createEchoListening(data);
        }
    },
    methods: {
        getNotifications() {

        },
        createEchoListening(user) {
            window.Echo.private('user_notification.' + user.id)
            .listen('.Modules\\User\\Events\\NotificationEvent', (result) => {
                console.log(result);
            })
        }
    }
}
</script>
<style scoped>
figure .avatar-image {
    height: 48px;
    width: 48px;
}
</style>