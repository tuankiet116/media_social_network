<template>
    <MenuComponent :user="user"></MenuComponent>
</template>


<script>
    import {detectUser} from '../api/userApi';
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
        mounted() {
            let _this = this;
            detectUser().then(result => {
                _this.user = result.data;    
            }).catch(err => _this.user = null);
        }
    }
</script>
