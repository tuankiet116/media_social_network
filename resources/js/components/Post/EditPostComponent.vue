<template>
    <div class="box container">
        <h1 class="is-size-3 has-text-left create_post_title">{{ $t('edit_post.title') }}</h1>
        <div class="field">
            <label class="label">{{ $t('edit_post.post_title') }}</label>
            <input class="input is-primary" v-model="post.title" type="text" />
            <p v-if="errors.title" class="help is-danger">{{ errors.title }}</p>
        </div>

        <div class="field">
            <label class="label">{{ $t('edit_post.post_desc') }}</label>
            <ckeditor ref="editor" class="input is-primary" :editor="editor" v-model="post.description"
                :config="editorConfig"></ckeditor>
            <p v-if="errors.description" class="help is-danger">{{ errors.description }}</p>
        </div>

        <div class="field">
            <div class="buttons is-right mt-5">
                <button class="button is-primary" @click="handleUploadPost()">{{ $t('edit_post.edit') }}</button>
                <button class="button is-light">{{ $t('edit_post.cancel') }}</button>
            </div>
        </div>
    </div>
</template>
<script>
import { updatePost, getPost } from '../../api/api';
import { useToast } from "vue-toastification";
import ClassicEditor from '../../../Libraries/CKEditor5/build/ckeditor';
import authMixin from '../../mixins';
export default {
    mixins: [authMixin],
    data() {
        return {
            editor: ClassicEditor,
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
                id: this.$route.params.id,
                title: "",
                description: ""
            },
            errors: {
                title: "",
                description: "",
                file: ""
            }
        }
    },
    mounted() {
        this.fetchPost();
    },
    computed: {
        user() {
            let user = this.$store.getters.getUser;
            if (user == null) {
                this.$router.push({name: 'home'});
            }
            return user;
        }
    },
    methods: {
        fetchPost() {
            let _this = this;
            getPost(this.post.id).then(result => {
                let data = result.data;
                _this.post.description = data.post_description;
                _this.post.title = data.title;
            }).catch(error => {

            });
        },
        validateData() {
            if (!this.post.title) this.errors.title = this.$t("create_post.validate_title");
            else this.errors.title = "";
            if (!this.post.description) this.errors.description = this.$t("create_post.validate_description");
            else this.errors.description = "";
        },
        async handleUploadPost() {
            let data = {
                id: this.post.id,
                title: this.post.title,
                post_description: this.post.description
            };
            let _this = this;
            this.validateData();
            if (!this.errors.title && !this.errors.description) {
                await updatePost(data).then(result => {
                    useToast().success(_this.$t('edit_post.success'));
                    _this.$router.go(-1);
                }).catch(err => {
                    useToast().error(_this.$t('edit_post.failed'));
                });
            }
        }
    }
}
</script>
<style scoped>
.container {
    margin: 10rem 20rem;
    background-color: whitesmoke;
    max-width: none !important;
}

@media screen and (min-device-width: 481px) and (max-device-width: 768px)  {
    .container {
        margin: 5rem 2rem !important;
    }
}

@media screen and (max-width: 480px) {
    .container {
        margin: 4rem 0 4rem 0!important;
        padding: 30px 10px;
    }

    .create_post_title {
        font-size: 20px !important;
    }
}
</style>