<template>
    <MenuComponent :user="user"></MenuComponent>
</template>


<script>
    import MenuComponent from './ChildComponents/MenuComponent.vue';

    export default {
        data() {
            return {
            };
        },
        components: {
            MenuComponent
        },
        mounted() {
            let _this = this;
            debugger
            this.$store.commit('getUserInformation')
        }
    }
</script>
