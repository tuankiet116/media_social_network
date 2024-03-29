<template>
    <MenuComponent :user="getUser"></MenuComponent>
    <router-view ref="child" :key="$route.fullPath"></router-view>
    <ProgressBarComponent v-if="getPostProgressUpload" :percent-value="getPostProgressUpload" class="progress-bar" />
    <VideoReceiverCall v-if="userCall" :user-call="userCall" />
    <VideoChatComponent v-if="call_uuid" :call_uuid="call_uuid"/>
    <MenuMobileComponent />
</template>


<script>
import MenuComponent from './MenuComponent.vue';
import MenuMobileComponent from './MenuMobileComponent.vue';
import ProgressBarComponent from './Common/ProgressBarComponent.vue';
import VideoReceiverCall from './Common/VideoReceiverCall.vue';
import VideoChatComponent from './Video/VideoChatComponent.vue';
import { mapGetters } from 'vuex';
import { getUnreadChat } from '../api/chat';
import authMixin from '../mixins';

export default {
    data() {
        return {
            call_uuid: null,
            userCall: null
        };
    },
    mixins: [authMixin],
    components: {
        MenuComponent,
        ProgressBarComponent,
        MenuMobileComponent,
        VideoReceiverCall,
        VideoChatComponent
    },
    computed: {
        ...mapGetters([
            'getPostProgressUpload',
            'getUser'
        ])
    },
    watch: {
        auth: function (data) {
            if (data) {
                this.getUnreadMessageCount();
                this.createEchoListeningMessage();
                this.createEchoListeningVideoCall();
            }
        },
        '$store.state.videoUUID': function(data) {
            this.call_uuid = data;
        }
    },
    methods: {
        getUnreadMessageCount() {
            getUnreadChat().then(result => {
                this.$store.state.unreadMessages.push(...result.data);
            });
        },
        createEchoListeningMessage() {
            let user = JSON.parse(sessionStorage.getItem('user'));
            if (user) {
                Echo.private('fd25b0f2-fdaa-4c67-a8d4-f09c48e6790a.' + user.id)
                    .listen('.message', (result) => {
                        let userMessage = result.userMessage;
                        userMessage.user_receive = result.userSendMessage;
                        userMessage.lastMessage = result.message;
                        let unreadExist = this.$store.state.unreadMessages.find((val) => val.id == userMessage.id);
                        let newMessageIdx = this.$store.state.newChat.findIndex((val) => val.id == userMessage.id);
                        if (!unreadExist) {
                            this.$store.state.unreadMessages.unshift(result.userMessage);
                        }

                        if (newMessageIdx !== -1) {
                            this.$store.state.newChat.splice(newMessageIdx, 1);
                        }
                        this.$store.state.newChat.unshift(result.userMessage);
                        this.$store.state.messages.push(result.message);
                    });
            }
        },
        createEchoListeningVideoCall() {
            let user = JSON.parse(sessionStorage.getItem('user'));
            if (user) {
                Echo.private('video-chat-incomming.' + user.id)
                    .listen('.incomming', (data) => {
                        this.$store.state.videoUUID = data.videoChat.uuid;
                        this.userCall = data.caller;
                    });
            }
        }
    }
}
</script>

<style scoped>
.progress-bar {
    position: fixed;
    left: 50%;
    transform: translateX(-50%);
    animation: showon 1s;
    bottom: 10px;
}

@keyframes showon {
    from {
        bottom: 0;
    }

    to {
        bottom: 10px;
    }
}
</style>
