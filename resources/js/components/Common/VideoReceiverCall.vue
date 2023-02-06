<template>
    <div v-if="userCall" id="modal-js" class="modal" :class="{ 'is-active': userCall }">
        <div class="modal-background" @click="closeModal"></div>

        <div class="modal-content">
            <div class="box">
                <p>{{ userCall.name }} đang gọi cho bạn</p>
                <div class="buttons is-justify-content-center">
                    <button class="button is-primary" @click="except">Chấp nhận</button>
                    <button class="button is-danger" @click="decline">Từ chối</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            userCall: null,
        };
    },
    watch: {
        '$store.state.user': function(user) {
            if (user) {
                Echo.private('video-chat-incomming.' + user.id).listen('.receive-video-chat', function (result) {
                    debugger
                });
            }
        }
    },
    mounted() {
    },
    methods: {
        except() {

        },
        decline() {

        }
    }
}
</script>