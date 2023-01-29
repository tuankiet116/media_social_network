<template>
    <div class="fill-message">
        <ObserverComponent @intersect="loadMoreMessage" />
        <template v-if="user" v-for="item in messages">
            <div v-if="item.sender == $route.params.id && userChat" class="message-left is-flex">
                <div>
                    <figure class="image is-48x48">
                        <img class="is-rounded" :src="userChat.image" />
                    </figure>
                </div>
                <div>
                    <p class="name">{{ userChat.name }}</p>
                    <p class="message-content p-2 ml-2">
                        {{ item.message }}
                    </p>
                </div>
            </div>
            <div v-if="item.sender == user.id" class="message-right is-flex mr-1 mb-2">
                <div class="message-content-right">
                    <p class="name">{{ user.name }}</p>
                    <span class="message-content p-2 mr-1">
                        {{ item.message }}
                    </span>
                </div>
                <div>
                    <figure class="image is-48x48">
                        <img class="is-rounded" :src="user.image" />
                    </figure>
                </div>
            </div>
        </template>
    </div>
    <div class="is-flex m-2 send-message">
        <input class="input" type="textarea" v-model="chatMessage" />
        <button @click="sendMessage" class="button is-info ml-2">Send</button>
    </div>
</template>
<script>
import ObserverComponent from '../Common/ObserverComponent.vue';
import { sendMessage, getMessages } from '../../api/chat';
import { getUserProfile } from '../../api/user';
export default {
    data() {
        return {
            messages: [],
            chatMessage: "",
            offset: 0,
            user: JSON.parse(sessionStorage.getItem('user')),
            userChat: null
        }
    },
    components: { ObserverComponent },
    mounted() {
        document.onreadystatechange = () => {
            if (document.readyState == "complete") {
                this.scrollBottomChat();
            }
        }
        this.getUserSender();
    },
    watch: {
        '$store.getters.getMessages': {
            handler: function (data) {
                let messages = data.map((val) => {
                    if (val.sender == this.userChat.id) return val;
                })
                this.messages.push(...messages);
                this.scrollBottomChat();
            },
            deep: true
        }
    },
    methods: {
        loadMoreMessage() {
            if (this.offset !== null) {
                getMessages(this.$route.params.id, this.offset).then(result => {
                    let messages = result.data.messages.reverse();
                    this.messages.push(...messages);
                    this.offset = result.data.offset;
                });
            }
        },
        sendMessage() {
            if (this.chatMessage) {
                let data = {
                    to: this.$route.params.id,
                    message: this.chatMessage
                };
                sendMessage(data).then(result => {
                    this.messages.push(result.data);
                    this.offset += 1;
                }).catch(error => {
                    debugger
                })
            }
        },
        scrollBottomChat() {
            document.querySelector('.fill-message').scrollTo(0, document.querySelector('.fill-message').scrollHeight);
        },
        getUserSender() {
            getUserProfile(this.$route.params.id).then(result => {
                this.userChat = result.data;
            });
        }
    }
}
</script>
<style scoped>
.message-left .message-content {
    background-color: #a1ddff;
    border-radius: 5px 20px 5px;
    max-width: 300px;
    word-wrap: break-word;
}

.message-right .message-content {
    background-color: #a1ddff;
    border-radius: 20px 0px 20px 5px;
    max-width: 300px;
    word-wrap: break-word;
}

.message-right .message-content-right {
    margin-left: auto !important;
}

.send-message {
    width: 100%;
    bottom: 2rem;
}

.fill-message {
    height: 100%;
    width: 100%;
    bottom: 8rem;
    overflow: auto;
}

.name {
    height: 48px;
    display: flex;
    align-items: center;
}
</style>
