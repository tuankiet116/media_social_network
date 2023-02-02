<template>
    <div>
        <div class="field">
            <label>{{ $t('community_setting.name') }}:</label>
            <input type="text" v-model="community_name" class="input" />
        </div>
        <div class="field">
            <label>{{ $t('community_setting.rule') }}:</label>
            <div class="control">
                <ckeditor ref="editor" class="input is-primary" :editor="editor" v-model="community_rule"
                    :config="editorConfig"></ckeditor>
            </div>
        </div>
        <div class="field is-grouped">
            <div class="control">
                <button class="button is-link" @click="updateInformation">{{ $t('save') }}</button>
            </div>
            <div class="control">
                <button class="button is-link is-light">{{ $t('cancel') }}</button>
            </div>
        </div>
    </div>
</template>
<script>
import { updateCommunityInfo } from '../../api/community';
import ClassicEditor from "../../../Libraries/CKEditor5/build/ckeditor";

export default {
    props: ["community"],
    data() {
        return {
            community_name: "",
            community_rule: "",
            editor: ClassicEditor,
            editorConfig: {
                toolbar: ['fontfamily', 'fontsize', '|', 'bold', 'italic', 'link', 'undo', 'redo']
            }
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
