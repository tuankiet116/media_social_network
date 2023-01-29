<template>
    <MenuComponent :user="getUser"></MenuComponent>
    <router-view :key="$route.fullPath"></router-view>
    <ProgressBarComponent v-if="getPostProgressUpload" :percent-value="getPostProgressUpload" class="progress-bar" />
    <MenuMobileComponent />
</template>


<script>
import MenuComponent from './MenuComponent.vue';
import MenuMobileComponent from './MenuMobileComponent.vue';
import ProgressBarComponent from './Common/ProgressBarComponent.vue';
import { mapGetters } from 'vuex';
import { getUnreadChat } from '../api/chat';

export default {
    data() {
        return {
        };
    },
    components: {
        MenuComponent,
        ProgressBarComponent,
        MenuMobileComponent
    },
    computed: {
        ...mapGetters([
            'getPostProgressUpload',
            'getUser'
        ])
    },
    mounted() {
        this.getUnreadMessageCount();
    },
    methods: {
        getUnreadMessageCount() {
            getUnreadChat().then(result => {
                this.$store.state.unreadMessages.push(...result.data);
            });
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
