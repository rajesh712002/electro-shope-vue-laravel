<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Create Brand</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <router-link to="/brands" class="btn btn-primary">Back</router-link>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="row d-flex justify-content-center" v-if="successMessage">
                    <div class="col-md-10 mt-4">
                        <div class="alert alert-success">
                            <b>{{ successMessage }}</b>
                        </div>
                    </div>
                </div>
                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <form @submit.prevent="submitForm" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input v-model="form.name" type="text" id="name" class="form-control"
                                                    placeholder="Brand Name" />
                                                <p v-if="errors.name" class="text-danger">{{ errors.name }}</p>
                                            </div>
                                        </div>

                                        <!-- Slug -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input v-model="form.slug" type="text" id="slug" class="form-control"
                                                    placeholder="Slug" />
                                                <p v-if="errors.slug" class="text-danger">{{ errors.slug }}</p>
                                            </div>
                                        </div>

                                        <!-- Image -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="image">Photo</label>
                                                <input type="file" id="image" class="form-control form-control-lg"
                                                    @change="handleFileChange" />
                                                <p v-if="errors.image" class="text-danger">{{ errors.image }}</p>
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status">Status</label>
                                                <select v-model="form.status" id="status" class="form-control">
                                                    <option value="">---select---</option>
                                                    <option value="1">Active</option>
                                                    <option value="0">Blocked</option>
                                                </select>
                                                <p v-if="errors.status" class="text-danger">{{ errors.status }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <button type="reset" class="btn btn-outline-dark ml-3"
                                    @click="resetForm">Cancel</button>
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
import axios from "axios";
export default {
    components: {
        AdminLayout
    },
    data() {
        return {
            form: {
                name: '',
                slug: '',
                image: null,
                status: '',
            },
            errors: [{}],
            successMessage: null,
            isLoading: false,
        };
    },
    methods: {
        async submitForm() {

            try {
                const formData = new FormData();
                formData.append('name', this.form.name);
                formData.append('slug', this.form.slug);
                formData.append('image', this.form.image);
                formData.append('status', this.form.status);
                const response = await axios.post('/api/create-brand', formData);
                this.successMessage = response.data.success;
                this.resetForm();
                // Handle success (show a success message or redirect)
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        },
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.image = file;
            }
        },
        resetForm() {
            this.form = {
                name: '',
                slug: '',
                image: null,
                status: '',
            };
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