<template>
    <div class="box">
        <h1 class="is-size-1 has-text-left">{{ $t('create_post.title') }}</h1>
        <div class="field">
            <label class="label">{{ $t('create_post.post_title') }}</label>
            <input class="input is-primary" v-model="post.title" type="text"/>
        </div>

        <div class="field">
            <label class="label">{{ $t('create_post.post_title') }}</label>
            <ckeditor class="input is-primary" :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
        </div>

        <div class="box">

        </div>
        <video id="video-preview" controls v-show="post.file != ''" />
        <input type="file" accept="video/*" @change="handleFileUpload($event)" />
    </div>
</template>
<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
export default {
    data() {
        return {
            editor: ClassicEditor,
            editorData: "",
            editorConfig: {
            },
            post: {
                title: "",
                description: "",
                file: ""
            }
        }
    },
    methods: {
        previewVideo() {
            let video = document.getElementById('video-preview');
            let reader = new FileReader();

            reader.readAsDataURL(this.file);
            reader.addEventListener('load', function () {
                video.src = reader.result;
            });
        },
        handleFileUpload(event) {
            this.file = event.target.files[0];
            this.previewVideo();
        },
    }
}
</script>
<style scoped>
.box {
    margin: 4rem;
}
</style>