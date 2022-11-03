<template>
    <div class="box m-6">
        <span class="is-pulled-left">Your post is uploading...</span>
        <span class="is-pulled-right">{{ percentValue }}%</span>
        <progress class="progress is-small is-info" :value="percentValue" max="100">{{ percentValue }}%</progress>
    </div>
</template>

<script>
export default {
    data() {
        return {};
    },
    props: ['percentValue']
}
</script>

<style scoped>
.box {
    margin: 0 !important;
}
</style>