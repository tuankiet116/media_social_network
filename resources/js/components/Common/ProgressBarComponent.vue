<template>
    <div class="box m-6">
        <span class="is-pulled-left">Your post is uploading...</span>
        <span class="is-pulled-right">Your post is uploading</span>
        <progress class="progress is-small is-info" :value="10" max="100">100%</progress>
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