<template>
<<<<<<< HEAD
    <MenuComponent @increaseKey="handleKeyComponent($event)" :user="getUser"></MenuComponent>
=======
    <div class="home"></div>
    <MenuComponent @increaseKey="handleKeyComponent($event)" :user="user"></MenuComponent>
>>>>>>> c745c9a (fix ui for dashboard and post)
    <router-view :key="key"></router-view>
    <ProgressBarComponent v-if="getPostProgressUpload" :percent-value="getPostProgressUpload" class="progress-bar" />
</template>


<script>
import MenuComponent from './MenuComponent.vue';
import ProgressBarComponent from './Common/ProgressBarComponent.vue';
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            key: 0,
            user: null
        };
    },
    components: {
        MenuComponent,
        ProgressBarComponent
    },
    computed: {
        ...mapGetters([
            'getPostProgressUpload',
            'getUser'
        ])
    },
    methods: {
        handleKeyComponent(keyComponent) {
            this.key = keyComponent;
        }
    }
}
</script>

<style scoped>
    .home {
        background-color: rgb(245, 245, 245) !important;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
    }
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
