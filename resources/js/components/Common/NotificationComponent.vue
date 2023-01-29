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
            <div class="quickview-block pt-3 pb-3" v-for="noti in notifications" :class="{ 'read': noti.read }">
                {{ noti.id }}
                <router-link v-if="noti.community_sender" @click="markRead(noti.id)"
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
                            &nbsp;
                            <span v-if="noti.type == 'NOTIFICATION_JOIN_COMMUNITY'">
                                {{ $t('notification.join_community') }}
                            </span>
                            <span v-if="noti.type == 'NOTIFICATION_LEAVE_COMMUNITY'">
                                {{ $t('notification.leave_community') }}
                            </span>
                        </div>
                    </div>
                </router-link>
                <router-link v-else-if="noti.user_sender && noti.post_id" @click="markRead(noti.id)"
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
                        </div>
                    </div>
                    <hr>
                </router-link>
            </div>
            <div class="quickview-block is-flex is-justify-content-center is-align-items-center" v-if="offset == null">
                <span class="has-text-weight-bold">{{ $t('notification.no_more') }}</span>
            </div>
            <ObserverComponent @intersect="getNotifications" />
        </div>

        <footer class="quickview-footer">

        </footer>
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
            user: JSON.parse(sessionStorage.getItem('user'))
        }
    },
    components: { ObserverComponent },
    mounted() {
        this.getCountUnreadNotification();
        this.createEchoListening(this.user);
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
        createEchoListening(user) {
            if (user) {
                Echo.private('9a2fadf0-c697-4b83-ba75-89873b996845.' + user.id)
                    .listen('.notification', (result) => {
                        this.$store.state.unreadNotifications += 1;
                        this.notifications.unshift(result.notification);
                        this.createToast(result.notification);
                        this.offset++;
                    });
            }
        },
        markRead(id) {
            markRead(id).then(result => {
                if (result.data == true) {
                    let notiIndex = this.notifications.findIndex(noti => noti.id == id);
                    this.notifications[notiIndex].read = 1;
                }
            })
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
</style>