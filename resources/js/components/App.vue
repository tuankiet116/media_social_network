<template>
    <MenuComponent :user="user"></MenuComponent>
    <router-view :key="$route.fullPath"></router-view>
    <ProgressBarComponent v-if="getPostProgressUpload" :percent-value="getPostProgressUpload" class="progress-bar" />
</template>


<script>
import { detectUser } from '../api/api';
import MenuComponent from './ChildComponents/MenuComponent.vue';
import DashboardComponent from './ChildComponents/DashboardComponent.vue';
import ProgressBarComponent from './Common/ProgressBarComponent.vue';
import { mapGetters } from 'vuex';

export default {
    data() {
        return {};
    },
    components: {
        MenuComponent,
        DashboardComponent,
        ProgressBarComponent
    },
    computed: {
        user() {
            return this.$store.state.user;
        },
        ...mapGetters([
            'getPostProgressUpload'
        ])
    },
    beforeCreate() {
        detectUser().then(result => {
            sessionStorage.setItem("user", JSON.stringify(result.data));
        }).catch(err => {
            sessionStorage.removeItem("user");
        });
        this.$store.commit('getUserInformation');
    },
    mounted() {
        // window.Echo.channel('post.list')
        // .listen('EventListPost', (e) => {
        //     console.log(e);
        // })
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
