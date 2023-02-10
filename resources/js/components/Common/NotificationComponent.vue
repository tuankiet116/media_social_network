<template>
    <div id="quickviewDefault" class="quickview">
        <header class="quickview-header">
            <div class="content mt-2">
                <h4 class="has-text-weight-bold">
                    {{ $t('notification.notification') }}
                </h4>
            </div>
            <span class="delete" data-dismiss="quickview"></span>
        </header>

        <div class="quickview-body">
            <template v-for="noti, index in notifications">
                <div class="quickview-block pt-5 pb-5" :class="{ 'read': noti.read }">
                    <router-link v-if="noti.community_sender"
                        @click="handleGotoNotification(noti.id, 'community_page', noti.community_sender.id)"
                        :to="{ name: 'community_page', params: { id: noti.community_sender.id } }" style="color: black">
                        <div class="columns is-align-items-center ml-2" style="flex-wrap: wrap;">
                            <div class="upper-image column-1">
                                <router-link class="is-flex is-align-items-center" style="color: black"
                                    :to="{ name: 'community_page', params: { id: noti.community_sender.id } }">
                                    <figure class="image avatar-image is-64x64">
                                        <img class="is-rounded" :src="noti.community_sender.image" />
                                    </figure>
                                </router-link>
                                <router-link v-if="noti.user_sender" class="is-flex is-align-items-center wrap-image"
                                    style="color: black"
                                    :to="{ name: 'profile_list_post', params: { id: noti.user_sender.id } }">
                                    <figure class="image avatar-image is-48x48">
                                        <img class="is-rounded" :src="noti.user_sender.image" />
                                    </figure>
                                    &nbsp;
                                </router-link>
                            </div>
                            <div class="column m-0 p-0">
                                <span v-if="noti.user_sender" class="has-text-weight-bold">
                                    {{ noti.user_sender.name }}
                                </span>
                                <!-- TODO -->
                                &nbsp;
                                <span v-if="noti.type == 'NOTIFICATION_JOIN_COMMUNITY'">
                                    {{ $t('notification.join_community') }}
                                </span>
                                <span v-if="noti.type == 'NOTIFICATION_LEAVE_COMMUNITY'">
                                    {{ $t('notification.leave_community') }}
                                </span>
                                <span v-if="noti.type == 'NOTIFICATION_COMMUNITY_DEL_POST'">
                                    {{ $t('notification.community_del_post') }}
                                </span>
                                <span v-if="noti.type == 'NOTIFICATION_COMMUNITY_DEL_MEMBER'">
                                    {{ $t('notification.community_del_member') }}
                                </span>
                            </div>
                        </div>
                    </router-link>
                    <router-link v-else-if="noti.user_sender && noti.post_id"
                        @click="handleGotoNotification(noti.id, 'post_detail', noti.post_id)"
                        :to="{ name: 'post_detail', params: { id: noti.post_id } }" style="color: black">
                        <div class="columns is-align-items-center ml-2" style="flex-wrap: wrap;">
                            <router-link class="is-flex is-align-items-center column-1" style="color: black"
                                :to="{ name: 'profile_list_post', params: { id: noti.user_sender.id } }">
                                <figure class="image avatar-image is-64x64">
                                    <img class="is-rounded" :src="noti.user_sender.image" />
                                </figure>
                            </router-link>

                            <div class="column m-0 p-0">
                                <span class="has-text-weight-bold">
                                    {{ noti.user_sender.name }}
                                </span>
                                &nbsp;
                                <span v-if="noti.type == 'NOTIFICATION_USER_COMMENT_POST'">
                                    {{ $t('notification.comment_post') }}
                                </span>
                                <span v-if="noti.type == 'NOTIFICATION_USER_REACT_POST'">
                                    {{ $t('notification.react_post') }}
                                </span>
                                <span v-if="noti.type == 'NOTIFICATION_USER_REPLY_COMMENT'">
                                    {{ $t('notification.reply_comment') }}
                                </span>
                                <span v-if="noti.type == 'NOTIFICATION_USER_REACT_COMMENT'">
                                    {{ $t('notification.react_comment') }}
                                </span>
                                <span v-if="noti.type == 'NOTIFICATION_USER_REPLY_COMMENT_IN_POST'">
                                    {{ $t('notification.reply_comment_post') }}
                                </span>
                                <span v-if="noti.type == 'NOTIFICATION_USER_SHARE_POST'">
                                    {{ $t('notification.share_post') }}
                                </span>
                                <span v-if="noti.type == 'NOTIFICATION_INSERT_POST_COMMUNITY'">
                                    {{ $t('notification.insert_post_community') }}
                                </span>
                            </div>
                        </div>
                    </router-link>
                    <router-link v-else-if="noti.user_sender && !noti.post_id"
                        @click="handleGotoNotification(noti.id, 'profile_list_post', noti.user_id)"
                        :to="{ name: 'profile_list_post', params: { id: noti.user_id } }" style="color: black">
                        <div class="columns is-align-items-center ml-2" style="flex-wrap: wrap;">
                            <router-link class="is-flex is-align-items-center column-1" style="color: black"
                                :to="{ name: 'profile_list_post', params: { id: noti.user_sender.id } }">
                                <figure class="image avatar-image is-64x64">
                                    <img class="is-rounded" :src="noti.user_sender.image" />
                                </figure>
                            </router-link>

                            <div class="column m-0 p-0">
                                <span class="has-text-weight-bold">
                                    {{ noti.user_sender.name }}
                                </span>
                                &nbsp;
                                <span v-if="noti.type == 'NOTIFICATION_FOLLOW_USER'">
                                    {{ $t('notification.follow_user') }}
                                </span>
                            </div>
                        </div>
                    </router-link>
                </div>
                <hr v-if="index !== notifications.length - 1" class="m-0">
            </template>
            <ObserverComponent v-if="notifications.length" @intersect="getNotifications" style="height: 1rem;"/>
            <div class="quickview-block is-flex is-justify-content-center is-align-items-center" v-if="offset == null">
                <span class="has-text-weight-bold">{{ $t('notification.no_more') }}</span>
            </div>
        </div>
    </div>
</template>
<script>
import { useToast } from 'vue-toastification';
import { getNotifications, countUnreadNotifications, markRead } from '../../api/notification';
import ObserverComponent from '../Common/ObserverComponent.vue';
export default {
    data() {
        return {
            notifications: [],
            offset: 0,
            connected: false,
            user: null
        }
    },
    components: { ObserverComponent },
    watch: {
        '$store.state.user': function (data) {
            if (data && this.connected == false) {
                this.user = data;
                this.connected = true;
                this.createEchoListening();
                this.getCountUnreadNotification();
                this.getNotifications();
            } else {
                this.notifications = [];
            }
        }
    },
    methods: {
        getNotifications() {
            if (this.offset !== null && this.user) {
                getNotifications(this.offset).then(result => {
                    this.offset = result.data.offset;
                    this.notifications.push(...result.data.notifications);
                });
            }
        },
        getCountUnreadNotification() {
            if (this.user) {
                countUnreadNotifications().then(result => {
                    this.$store.state.unreadNotifications = result.data.count;
                });
            }
        },
        createEchoListening() {
            if (this.user) {
                Echo.private('9a2fadf0-c697-4b83-ba75-89873b996845.' + this.user.id)
                    .listen('.notification', (result) => {
                        this.$store.state.unreadNotifications += 1;
                        this.notifications.unshift(result.notification);
                        this.createToast(result.notification);
                        this.offset++;
                    });
            }
        },
        handleGotoNotification(id, routerName, paramID) {
            markRead(id).then(result => {
                if (result.data == true) {
                    let notiIndex = this.notifications.findIndex(noti => noti.id == id);
                    this.notifications[notiIndex].read = 1;
                }
            });
            if (this.$route.name == routerName && this.$route.params.id == paramID) {
                if (routerName == 'community_page') {
                    this.$store.state.eventUpdateCommunityPost = true;
                }
            }
        },
        createToast(notification) {
            let contentNotification = '';
            if (notification.user_sender) {
                contentNotification += `${notification.user_sender.name} `;
            } else if (notification.community_sender) {
                contentNotification += `${notification.community_sender.community_name} `;
            }

            switch (notification.type) {
                case 'NOTIFICATION_USER_COMMENT_POST':
                    contentNotification += this.$t('notification.comment_post');
                    break;
                case 'NOTIFICATION_USER_REACT_POST':
                    contentNotification += this.$t('notification.react_post');
                    break;
                case 'NOTIFICATION_USER_SHARE_POST':
                    contentNotification += this.$t('notification.share_post');
                    break;
                case 'NOTIFICATION_USER_REPLY_COMMENT':
                    contentNotification += this.$t('notification.reply_comment');
                    break;
                case 'NOTIFICATION_USER_REACT_COMMENT':
                    contentNotification += this.$t('notification.react_comment');
                    break;
                case 'NOTIFICATION_USER_REPLY_COMMENT_IN_POST':
                    contentNotification += this.$t('notification.reply_comment_post');
                    break;
                case 'NOTIFICATION_JOIN_COMMUNITY':
                    contentNotification += this.$t('notification.join_community');
                    break;
                case 'NOTIFICATION_LEAVE_COMMUNITY':
                    contentNotification += this.$t('notification.leave_community');
                    break;
                case 'NOTIFICATION_INSERT_POST_COMMUNITY':
                    contentNotification += this.$t('notification.insert_post_community');
                    break;
                case 'NOTIFICATION_COMMUNITY_DEL_POST':
                    contentNotification += this.$t('notification.community_del_post');
                    break;
                case 'NOTIFICATION_COMMUNITY_DEL_MEMBER':
                    contentNotification += this.$t('notification.community_del_member');
                    break;
                case 'NOTIFICATION_FOLLOW_USER':
                    contentNotification += this.$t('notification.follow_user');
                    break;
            }

            useToast().info(contentNotification, {
                position: "bottom-left",
                hideProgressBar: true
            });
        }
    }
}
</script>
<style scoped>
figure .avatar-image {
    height: 48px;
    width: 48px;
}

.read {
    background-color: #eceef2;
}

hr {
    margin: 0;
    border: solid rgb(96, 96, 96) 1px;
}

.upper-image {
    position: relative;
}

.wrap-image {
    position: absolute;
    bottom: -1rem;
    right: -1.5rem;
}

.column {
    width: 100%;
    display: contents;
}

.quickview-body {
    overflow-x: hidden;
}
</style>