<template>
    <textarea id="editor"></textarea>
</template>
<script>
import ClassicEditor from '../../config/ckeditor';
export default {
    data() {
        return {};
    },
    mounted() {
        ClassicEditor.create(document.getElementById('editor'))
            .then(editor => {
                console.log('Editor was initialized', editor);
            })
            .catch(error => {
                console.error(error.stack);
            });
    }
}
</script>