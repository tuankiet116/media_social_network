<template>
    <MenuComponent :user="user"></MenuComponent>
    <router-view></router-view>
</template>


<script>
import { detectUser } from '../api/api';
import MenuComponent from './ChildComponents/MenuComponent.vue';
import DashboardComponent from './ChildComponents/DashboardComponent.vue';

export default {
    data() {
        return {
            
        };
    },
    components: {
        MenuComponent,
        DashboardComponent
    },
    computed: {
        user() {
            return this.$store.state.user;
        }
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
