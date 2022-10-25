<template>
    <MenuComponent :user="user"></MenuComponent>
</template>


<script>
    import MenuComponent from './ChildComponents/MenuComponent.vue';
    import Echo from 'laravel-echo';

    export default {
        data() {
            return {
                
            };
        },
        components: {
            MenuComponent
        },
        computed: {
            user() {
                return this.$store.state.user;
            }
        },
        async beforeMount() {
            await this.$store.commit('getUserInformation');
        },
        mounted() {
            window.Echo.channel('post.list')
            .listen('EventListPost', (e) => {
                console.log(e);
            })
        }
    }
</script>
