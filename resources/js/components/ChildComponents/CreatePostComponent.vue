<template>
    <div class="box">
        <h1 class="is-size-3 has-text-left">{{ $t('create_post.title') }}</h1>
        <div class="field">
            <label class="label">{{ $t('create_post.post_title') }}</label>
            <input class="input is-primary" v-model="post.title" type="text" />
        </div>

        <div class="field">
            <label class="label">{{ $t('create_post.post_desc') }}</label>
            <ckeditor class="input is-primary" :editor="editor" v-model="editorData" :config="editorConfig"></ckeditor>
        </div>

        <div class="field">
            <label class="label">{{ $t('create_post.post_video') }}</label>
            <div class="file is-large is-boxed" v-show="post.file == ''">
                <label class="file-label">
                    <input class="file-input" type="file" accept="video/*" @change="handleFileUpload($event)">
                    <span class="file-cta">
                        <span class="file-icon">
                            <i class="fas fa-upload"></i>
                        </span>
                        <span class="file-label">
                            Upload Video
                        </span>
                    </span>
                </label>
            </div>
            <div class="box video-preview-box has-text-centered" v-show="post.file != ''">
                <video id="video-preview" controls />
                <div class="has-text-right">
                    <button class="button is-info" @click="handleCancelVideo($event)">{{ $t('create_post.cancel_video')
                    }}</button>
                </div>
            </div>
            <div class="buttons is-right mt-5">
                <button class="button is-primary">{{ $t('create_post.create') }}</button>
                <button class="button is-light">{{ $t('create_post.cancel') }}</button>
            </div>
        </div>
    </div>
</template>
<script>
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import CKFinder from '@ckeditor/ckeditor5-ckfinder/src/ckfinder';
export default {
    data() {
        return {
            editor: ClassicEditor,
            editorData: "",
            editorConfig: {
                toolbar: ['ckfinder'],
                ckfinder: {
                    // Open the file manager in the pop-up window.
                    openerMethod: 'popup'
                }
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

            reader.readAsDataURL(this.post.file);
            reader.addEventListener('load', function () {
                video.src = reader.result;
            });
        },
        handleFileUpload(event) {
            this.post.file = event.target.files[0];
            this.previewVideo();
        },
        handleCancelVideo(event) {
            this.post.file = '';
        },
        handleUploadPost() {

        }
    }
}
</script>
<style scoped>
.box {
    margin: 4rem;
    background-color: whitesmoke;
}

.file-label {
    width: 100%;
    text-align: center;
}

.video-preview-box {
    max-height: 500px;
}

video {
    max-width: 100%;
    max-height: 300px;
    width: auto;
}
</style>