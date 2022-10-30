<template>
    <div class="box container">
        <h1 class="is-size-3 has-text-left">{{ $t('create_post.title') }}</h1>
        <div class="field">
            <label class="label">{{ $t('create_post.post_title') }}</label>
            <input class="input is-primary" v-model="post.title" type="text" />
        </div>

        <div class="field">
            <label class="label">{{ $t('create_post.post_desc') }}</label>
            <!-- <ckeditor ref="editor" class="input is-primary" :editor="editor" v-model="post.description"
                :config="editorConfig"></ckeditor> -->
                <CKEditorComponent/>
        </div>

        <div class="field">
            <label class="label">{{ $t('create_post.post_video') }}</label>
            <div class="file is-large is-boxed" v-show="post.file == ''">
                <label class="file-label">
                    <input class="file-input" ref="video" type="file" accept="video/*"
                        @change="handleFileUpload($event)">
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
                <button class="button is-primary" @click="handleUploadPost()">{{ $t('create_post.create') }}</button>
                <button class="button is-light">{{ $t('create_post.cancel') }}</button>
            </div>
        </div>
    </div>
</template>
<script>
// import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import { createPost } from '../../api/api';
import { useToast } from "vue-toastification";
import CKEditorComponent from '../Children/CKEditorComponent.vue';
export default {
    components: {CKEditorComponent},
    data() {
        return {
            // editor: ClassicEditor,
            editorConfig: {
                ckfinder: {
                    uploadUrl: '/api/ckfinder/upload?_token=' + document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    options: {
                        resourceType: 'Images',
                    }
                },
                image: {
                    resizeUnit: 'px',
                    resizeOptions: [
                        {
                            name: 'resizeImage:original',
                            label: 'Original',
                            value: null
                        },
                        {
                            name: 'resizeImage:100',
                            label: '100px',
                            value: '100'
                        },
                        {
                            name: 'resizeImage:200',
                            label: '200px',
                            value: '200'
                        }
                    ]
                }
            },
            post: {
                title: "",
                description: "",
                file: ""
            }
        }
    },
    created() {
        if (!sessionStorage.getItem("user")) {
            this.$router.push({ name: 'home' });
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
            this.$refs.video.value = null;
        },
        async handleUploadPost() {
            let form = new FormData();
            var _this = this;
            form.append('title', this.post.title);
            form.append('description', this.post.description);
            form.append('video', this.post.file);
            form.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            await createPost(form, {
                header: { "Contect-type": "multipart/form-data" },
                onUploadProgress: progressEvent => {
                    _this.$store.state.postUploadProgress = Math.round(progressEvent.loaded / progressEvent.total);
                }
            }).then(result => {
                useToast().success(_this.$t('create_post.success'));
                this.$router.push({name: 'home'});
            }).catch(err => {
                console.log(err);
            });
        }
    }
}
</script>
<style scoped>
.container {
    margin: 4rem 30rem;
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