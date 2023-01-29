<template>
    <div class="columns mt-2 chat-container ">
        <div v-if="isMobile() && $route.params.id == null || !isMobile()"
            class="column is-2-desktop is-4-tablet chat-list">
            <template>

            </template>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <div class="columns is-mobile">
                <div class="column is-3 is-justify-content-center is-flex ml-2 p-0">
                    <figure class="image is-64x64">
                        <img class="is-rounded avatar-image"
                            src="https://images.unsplash.com/photo-1506803682981-6e718a9dd3ee?ixlib=rb-0.3.5&q=80&fm=jpg&crop=faces&fit=crop&h=200&w=200&s=c3a31eeb7efb4d533647e3cad1de9257" />
                    </figure>
                </div>
                <div class="column pl-1">
                    <p class="is-flex">
                        <strong>ABC</strong>
                        <span style="margin-left:auto">3 minutes</span>
                    </p>
                    <p><span>You:</span> asdfasfasfasfas...</p>
                </div>
            </div>
            <ObserverComponent @intersect="loadMoreChatList" />
        </div>
        <div v-if="isMobile() && $route.params.id || !isMobile()" class="column">
            <router-link :to="{ name: 'chat' }" class="button ml-2">
                <i class="fa-solid fa-left-long"></i> &nbsp;Back
            </router-link>
            <div class="field is-horizontal m-2">
                <div class="field-label is-normal" style="flex-grow: 0.5;">
                    <label class="label">Message To:</label>
                </div>
                <div class="field-body">
                    <div class="field">
                        <p class="control">
                            <input class="input" v-model="keyword" type="text" placeholder="Search User">
                        </p>
                        <nav class="panel" v-if="isDisplaySearch">
                            <p class="panel-heading">
                                User
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
                    <h3>Pick or search an user and let's chat!</h3>
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
import { detectMobile } from '../../helpers/common';
import { searchUser } from '../../api/search';
import { listChat } from '../../api/chat';
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
        auth (data) {
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
        }
    },
    computed: {
        height: () => {
            return window.innerHeight;
        }
    },
    mounted() {
        this.loadMoreChatList();
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
        }
    },
    unmounted() {
        this.$store.state.messages = [];
        this.$store.state.newMessages = [];
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
</style>