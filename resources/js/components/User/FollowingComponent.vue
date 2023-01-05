<template>
    <div class="columns">
        <div class="row" v-for="i in Math.ceil(following_users.length / 2)">
            <div v-for="user in following_users.slice((i - 1) * 2, i * 2)">
                {{ user }}
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            following_users: []
        };
    },
    methods: {
        getFollowing() {
            
        }
    }
}
</script>