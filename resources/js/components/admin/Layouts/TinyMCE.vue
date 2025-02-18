<template>
    <textarea cols="30" rows="5" class="form-control" placeholder="Description" ref="editor"></textarea>
  </template>
  
  <script>
  import tinymce from 'tinymce/tinymce';
  import 'tinymce/themes/silver/theme';
  import 'tinymce/icons/default/icons';
  import 'tinymce/plugins/lists';
  import 'tinymce/plugins/link';
  import 'tinymce/plugins/image';
  import 'tinymce/plugins/preview';
  import 'tinymce/plugins/code';
  import 'tinymce/plugins/table';
  import 'tinymce/plugins/media';
  import 'tinymce/plugins/textcolor';
  import 'tinymce/plugins/paste';
  
  export default {
    props: {
      modelValue: String, // v-model support
    },
    mounted() {
      tinymce.init({
        target: this.$refs.editor,
        plugins: 'lists link image preview code table media textcolor paste',
        toolbar:
          'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | table | forecolor backcolor | code preview | save',
        menubar: false,
        branding: false,
        cleanup: true,
        setup: (editor) => {
          editor.on('input', () => {
            this.$emit('update:modelValue', editor.getContent());
          });
  
          editor.ui.registry.addButton('save', {
            text: 'Save',
            onAction: () => {
              alert('Save functionality needs to be implemented!');
            },
          });
        },
        image_advtab: true,
        media_dimensions: false,
        image_caption: true,
      });
    },
    beforeUnmount() {
      tinymce.remove();
    },
  };
  </script>
  