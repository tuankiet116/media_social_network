<template>
    <MenuComponent :user="getUser"></MenuComponent>
    <router-view :key="$route.fullPath"></router-view>
    <ProgressBarComponent v-if="getPostProgressUpload" :percent-value="getPostProgressUpload" class="progress-bar" />
</template>


<script>
import MenuComponent from './MenuComponent.vue';
import ProgressBarComponent from './Common/ProgressBarComponent.vue';
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
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
