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
                <button class="button is-link" @click="updateInformation">Submit</button>
            </div>
            <div class="control">
                <button class="button is-link is-light">{{ $t('cancel') }}</button>
            </div>
        </div>
    </div>
</template>
<script>
import { emit } from 'process';
import { updateCommunityInfo } from '../../api/community';
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
            this.community_rule = value?.rule ?? "";
        },
    },
    methods: {
        updateInformation() {
            let data = {
                'community_name': this.community_name,
                'rule': this.community_rule
            };
            let communityId = this.community.id;
            updateCommunityInfo(data, communityId).then(result => {
                this.$emit('updated', result.data);
            });
        }
    }
};
</script>
