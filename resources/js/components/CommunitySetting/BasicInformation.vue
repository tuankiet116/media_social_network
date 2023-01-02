<template>
    <div>
        <div class="field">
            <label>Community Name:</label>
            <input type="text" v-model="community_name" class="input" />
        </div>
        <div class="field">
            <label>Community Rule:</label>
            <div class="control">
                <textarea class="textarea" v-model="community_rule"></textarea>
            </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link">Submit</button>
            </div>
            <div class="control">
                <button class="button is-link is-light">Cancel</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    props: ["community"],
    data() {
        return {
            community_name: "",
            community_rule: "",
        };
    },
    watch: {
        community(value) {
            this.community_name = value?.community_name ?? "";
            this.community_rule = value?.community_rule ?? "";
        },
    },
};
</script>
