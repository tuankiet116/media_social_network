<template>
    <MenuComponent :user="user"></MenuComponent>
</template>


<script>
    import MenuComponent from './ChildComponents/MenuComponent.vue';

    export default {
        data() {
            return {
                user: null
            };
        },
        components: {
            MenuComponent
        },
        beforeMount() {
            this.$store.commit('getUserInformation');
        },
        mounted() {
            this.user = this.$store.state.user;
        }
    }
</script>
