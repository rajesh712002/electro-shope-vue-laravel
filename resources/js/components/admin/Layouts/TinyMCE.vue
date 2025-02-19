<template>
  <div class="mb-3">
    <label for="description">Description</label>
    <Editor
      :modelValue="product.description"
      @update:modelValue="product.description = $event"
      api-key="adkflfpe6mrdbxryjc4huob43fi29gg6o1a9gjfbf22la31k"
      :init="{
        height: 300,
        menubar: false,
        plugins: 'lists link image preview code table media paste textpattern',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | table | code preview',
      }"
    />
    <p v-if="errors.description" class="text-danger">{{ errors.description }}</p>
  </div>
</template>

<script>
import Editor from '@tinymce/tinymce-vue';

export default {
  components: { Editor },
  data() {
    return {
      product: {
        description: '' // Ensure this is properly bound
      },
      errors: {} // Track validation errors
    };
  }
};
</script>
