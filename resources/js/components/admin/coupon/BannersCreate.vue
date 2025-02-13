<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Create Banner</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <router-link to="/banners" class="btn btn-primary">Back</router-link>
                            </div>
                        </div>
                    </div>
                </section>

                <div class="row d-flex justify-content-center">
                    <div v-if="successMessage" class="col-md-10 mt-4">
                        <div class="alert alert-success">
                            <b>{{ successMessage }}</b>
                        </div>
                    </div>
                </div>

                <section class="content">
                    <div class="container-fluid">
                        <form @submit.prevent="submitForm" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" v-model="form.name" class="form-control"
                                                placeholder="Banner Name" />
                                            <p v-if="errors.name" class="text-danger">{{ errors.name }}</p>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="image">Banner Image</label>
                                            <input type="file" @change="handleFileUpload" class="form-control" />
                                            <p v-if="errors.image" class="text-danger">{{ errors.image }}</p>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="status">Status</label>
                                            <select v-model="form.status" class="form-control">
                                                <option value="">---select---</option>
                                                <option value="1">Active</option>
                                                <option value="0">Block</option>
                                            </select>
                                            <p v-if="errors.status" class="text-danger">{{ errors.status }}</p>
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="description">Description</label>
                                            <textarea v-model="form.description" id="description" class="form-control"
                                                placeholder="Description"></textarea>
                                            <p v-if="errors.description" class="text-danger">{{ errors.description }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <button type="reset" @click="resetForm" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </template>
    </AdminLayout>
</template>

<script>
import AdminLayout from '../../admin/Layouts/AdminLayout.vue';
import axios from 'axios';
import tinymce from 'tinymce';
export default {
    components: {
        AdminLayout
    },


    data() {
        return {
            form: {
                name: '',
                image: null,
                status: '',
                description: '',
            },
            errors: {},
            successMessage: null,
            isLoading: false,
        };
    },
    // mounted() {
    //     tinymce.init({
    //         selector: '#description',
    //         plugins: 'lists link image preview code table media textcolor paste',
    //         toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | table | forecolor backcolor | code preview | save',
    //         menubar: false,
    //         branding: false,
    //         cleanup: true,
    //         setup: (editor) => {
    //             editor.ui.registry.addButton('save', {
    //                 text: 'Save',
    //                 onAction: () => alert('Save functionality needs to be implemented!'),
    //             });
    //         },
    //         image_advtab: true,
    //         media_dimensions: false,
    //         image_caption: true,
    //     });
    // },
    methods: {
        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.image = file;
            }
        },
        async submitForm() {
            // this.errors = {};
            
            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('image', this.form.image);
                formData.append('status', this.form.status);
                formData.append('description', this.form.description);
                const response = await axios.post('/api/create-banner', formData);
                this.successMessage = response.data.success;
                console.log(this.successMessage )
                // this.resetForm();
                // this.successMessage = response.data.message;
                this.resetForm();
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        },
        resetForm() {
            this.form = { name: '', image: null, status: '', description: '' };
            this.errors = {};
        },
    },
};
</script>

<style scoped>
.text-danger {
    color: red;
}
</style>