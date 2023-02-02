<template>
    <div class="columns mt-2 chat-container ">
        <div v-if="isMobile() && $route.params.id == null || !isMobile()"
            class="column is-2-desktop is-4-tablet chat-list">
            <div class="link-chat" v-for="item in chat">
                <router-link @click="markRead(item.id)" class="is-flex is-align-items-center"
                    :to="{ name: 'message', params: { id: item.user_receive_id } }">
                    <i v-if="!item.read" class="fa-solid fa-circle" style="font-size: 10px;"></i>
                    <div class="columns is-mobile">
                        <div class="column is-3 is-justify-content-center is-flex mb-2 p-0"
                            :class="{ 'ml-2': item.read }">
                            <figure class="image is-64x64">
                                <img class="is-rounded avatar-image" :src="item.user_receive.image" />
                            </figure>
                        </div>
                        <div class="column pl-1">
                            <p class="is-flex">
                                <strong>{{ item.user_receive.name }}</strong>
                                <span style="margin-left:auto">{{ calculateTime(item.last_time_message) }}</span>
                            </p>
                            <p><span v-if="item.lastMessage.sender == user.id">{{ $t( 'chat.you') }}:</span> {{
                                item.lastMessage.message
                            }}</p>
                        </div>
                    </div>
                </router-link>
            </div>
            <ObserverComponent @intersect="loadMoreChatList" />
        </div>
        <div v-if="isMobile() && $route.params.id || !isMobile()" class="column">
            <router-link :to="{ name: 'chat' }" class="button ml-2">
                <i class="fa-solid fa-left-long"></i> &nbsp;{{ $t('chat.back') }}
            </router-link>
            <div class="field is-horizontal m-2">
                <div class="field-label is-normal" style="flex-grow: 0.5;">
                    <label class="label">{{ $t('chat.message_to') }}:</label>
                </div>
                <div class="field-body">
                    <div class="field search-user-container">
                        <p class="control">
                            <input class="input" v-model="keyword" type="text" placeholder="Search User">
                        </p>
                        <nav class="panel search-user" v-if="isDisplaySearch">
                            <p class="panel-heading">
                                {{ $t('chat.user') }}
                            </p>
                            <template v-for="user in userAccounts">
                                <router-link class="panel-block" :to="{ name: 'message', params: { id: user.id } }">
                                    <span class="panel-icon">
                                        <figure class="image">
                                            <img :src="user.image" />
                                        </figure>
                                    </span>
                                    {{ user.name }}
                                </router-link>
                            </template>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="message" style="height: 75vh; background-color:white;">
                <div v-if="idChat == null" class="content is-flex is-justify-content-center is-align-items-center m-2"
                    style="background-color:white; height: 100%">
                    <h3>{{ $t('chat.welcome_chat') }}</h3>
                    <figure class="image is-128x128">
                        <img src="../../../images/defaults/chat.png" />
                    </figure>
                </div>
                <router-view v-else></router-view>
            </div>
        </div>
    </div>
</template>
<script>
import authMixin from '../../mixins';
import ObserverComponent from '../Common/ObserverComponent.vue';
import { detectMobile, calculateTime } from '../../helpers/common';
import { searchUser } from '../../api/search';
import { listChat, markReadChat } from '../../api/chat';
export default {
    components: { ObserverComponent },
    data() {
        return {
            idChat: this.$route.params.id ?? null,
            keyword: "",
            isDisplaySearch: false,
            userAccounts: [],
            offset: 0,
            chat: [],
            user: JSON.parse(sessionStorage.getItem('user'))
        };
    },
    watch: {
        auth(data) {
            if (!data) {
                window.location.replace('user/login')
            }
        },
        keyword(value) {
            if (value) {
                this.isDisplaySearch = true;
                this.searchUser();
            } else {
                this.isDisplaySearch = false;
            }
        },
        '$store.getters.getNewChat': {
            handler: function (data) {
                let newChat = data[0];
                if (newChat) {
                    let newChatExist = this.chat.findIndex((val => val.id == newChat.id));
                    if (newChatExist !== -1) {
                        this.chat.splice(newChatExist, 1);
                    }
                    this.chat.unshift(newChat);
                }
            },
            deep: true
        }
    },
    computed: {
        height: () => {
            return window.innerHeight;
        }
    },
    mixins: [authMixin],
    methods: {
        loadMoreChatList() {
            if (this.offset !== null && this.user) {
                listChat(this.offset).then(result => {
                    this.offset = result.data.offset;
                    this.chat.push(...result.data.chat_list);
                });
            }
        },
        isMobile() {
            return detectMobile();
        },
        searchUser() {
            searchUser(this.keyword).then(result => {
                this.userAccounts = result.data.users;
            });
        },
        calculateTime(time) {
            return calculateTime(time, this)
        },
        markRead(idChat) {
            markReadChat({
                'id_chat': idChat
            }).then(result => {
                let chatIdex = this.$store.state.unreadMessages.findIndex((val) => val.id == idChat);
                let chatInCurrent = this.chat.find(val => val.id == idChat);
                chatInCurrent.read = 1;
                if (chatIdex !== -1) {
                    this.$store.state.unreadMessages.splice(chatIdex, 1);
                }
            });
        }
    },
    unmounted() {
        this.$store.state.newChat = [];
    }
}
</script>
<style>
.chat-list {
    border-right: 1px solid black;
    max-width: 100%;
    overflow: auto;
}

.chat-container {
    max-height: 90%;
}

.columns {
    margin: 0;
}

.link-chat a {
    color: black
}

.link-chat:hover {
    background-color: #C5C5C5;
}

.search-user-container {
    position: relative;
}

.search-user {
    position: absolute;
    width: 100%;
    z-index: 1;
}

.search-user a {
    background-color: white;
}
</style>