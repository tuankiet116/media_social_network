<template>
    <div class="user-info is-flex is-align-items-center m-2 p-1" v-if="userChat">
        <figure class="image is-64x64">
            <img class="is-rounded" style="height: 64px; width: 64px; object-fit:cover" :src="userChat.image" />
        </figure>
        <strong class="ml-2">{{ userChat.name }}</strong>
        <router-link class="button is-rounded" :to="{ name: 'profile_list_post', params: { id: userChat.id } }">
            {{ $t('chat.info') }}
        </router-link>
    </div>
    <div class="fill-message p-2">
        <ObserverComponent @intersect="loadMoreMessage" />
        <template v-if="user" v-for="(item, index) in messages">
            <div :id="item.id" v-if="item.sender == $route.params.id && userChat"
                class="message-left is-align-items-center">
                <div v-if="!isConnectPrevious(index)" class="is-flex">
                    <figure class="image is-48x48">
                        <img class="is-rounded avatar-image" :src="userChat.image" />
                    </figure>
                    <p class="name" v-if="!isConnectPrevious(index)">{{ userChat.name }}</p>
                </div>
                <div class="mb-1">
                    <p class="message-content p-2 ml-2">
                        {{ item.message }}
                    </p>
                </div>
            </div>
            <div :id="item.id" v-if="item.sender == user.id" class="message-right mr-1 is-align-items-center">
                <div v-if="!isConnectPrevious(index)" class="is-flex">
                    <p v-if="!isConnectPrevious(index)" class="name mr-1">{{ user.name }}</p>
                    <figure class="image is-48x48">
                        <img class="is-rounded avatar-image" :src="user.image" />
                    </figure>
                </div>
                <div class="message-content-right mb-1">
                    <span class="message-content p-2">
                        {{ item.message }}
                    </span>
                </div>
            </div>
        </template>
    </div>
    <div class="is-flex m-2 send-message">
        <input ref="input" class="input" type="textarea" v-model="chatMessage" @keyup.enter="sendMessage" />
        <button @click="sendMessage" class="button is-info ml-2">{{ $t('chat.send') }}</button>
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
            userChat: null
        }
    },
    props: ['user'],
    components: { ObserverComponent },
    mounted() {
        document.onreadystatechange = () => {
            if (document.readyState == "complete") {
                this.scrollBottomChat();
            }
        }
        this.getUserSender();
        this.$refs.input.focus();
    },
    watch: {
        '$store.getters.getMessages': {
            handler: async function (data) {
                let _this = this;
                let messages = await data.flatMap(function (val) {
                    if (val.sender == _this.userChat.id) return val;
                    else return [];
                });
                if (messages[messages.length - 1]) {
                    await this.messages.push(messages[messages.length - 1]);
                }
                this.scrollBottomChat();
            },
            deep: true
        }
    },
    methods: {
        async loadMoreMessage() {
            if (this.offset !== null) {
                let currentViewId = this.messages[0]?.id;
                await getMessages(this.$route.params.id, this.offset).then(result => {
                    let messages = result.data.messages.reverse();
                    this.messages.unshift(...messages);
                    this.offset = result.data.offset;
                });
                if (currentViewId) {
                    document.getElementById(currentViewId).scrollIntoView();
                }
            }
        },
        async sendMessage() {
            if (this.chatMessage) {
                let data = {
                    to: this.$route.params.id,
                    message: this.chatMessage
                };
                this.chatMessage = "";
                await sendMessage(data).then(result => {
                    this.messages.push(result.data.message);
                    this.offset !== null ? this.offset += 1 : this.offset = null;
                    let newMessageIdx = this.$store.state.newChat.findIndex((val) => val.id == result.data.chat.id);
                    if (newMessageIdx !== -1) {
                        this.$store.state.newChat.splice(newMessageIdx, 1);
                    }
                    this.$store.state.newChat.unshift(result.data.chat);
                }).catch(error => {
                    debugger
                });
                this.scrollBottomChat();
            }
        },
        scrollBottomChat() {
            document.querySelector('.fill-message').scrollTo(0, document.querySelector('.fill-message').scrollHeight);
        },
        getUserSender() {
            getUserProfile(this.$route.params.id).then(result => {
                this.userChat = result.data;
            });
        },
        isConnectPrevious(index) {
            if (index !== 0 && this.messages[index].sender == this.messages[index - 1].sender) {
                return true;
            }
            return false;
        }
    },
    unmounted() {
        this.$store.state.messages = [];
    }
}
</script>
<style scoped>
.message-left .message-content {
    background-color: #a1ddff;
    border-radius: 5px 20px 5px;
    max-width: 300px;
    word-wrap: break-word;
    width: fit-content;
    margin-left: 48px !important;
}

.message-right {
    margin-left: auto !important;
    width: fit-content;
}

.message-right .message-content {
    background-color: #a1ddff;
    border-radius: 20px 0px 20px 5px;
    max-width: 300px;
    word-wrap: break-word;
}

.message-right .message-content-right {
    margin-left: auto !important;
    width: fit-content;
    margin-right: 48px;
    margin-bottom: 0.8rem !important;
}

.message-right .name {
    margin-left: auto;
}

.send-message {
    width: 100%;
    bottom: 2rem;
}

.fill-message {
    height: 90%;
    width: 100%;
    bottom: 8rem;
    overflow: auto;
}

.name {
    height: 48px;
    display: flex;
    align-items: center;
}

figure img {
    background-color: blueviolet;
}

.avatar-image {
    width: 48px;
    height: 48px;
}

.user-info {
    background-color: rgb(81 136 65);
    color: white;
    border-radius: 10px;
}

.user-info .button {
    margin-left: auto;
}
</style>
