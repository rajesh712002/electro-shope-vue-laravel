<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Create Sub Category</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <router-link to="/subcategories" class="btn btn-primary">Back</router-link>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>

                <!-- Success Message -->
                <div v-if="successMessage" class="alert alert-success">
                    <b>{{ successMessage }}</b>
                </div>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <form @submit.prevent="submitForm" enctype="multipart/form-data">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Category Select -->
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="category">Category</label>
                                                <select v-model="form.category" id="category" class="form-control">
                                                    <option value="">---select---</option>
                                                    <option v-for="(value, key) in categories" :key="key" :value="key">
                                                        {{ value
                                                        }}</option>
                                                </select>
                                                <p v-if="errors.category" class="text-danger">{{ errors.category }}</p>
                                            </div>
                                        </div>

                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input v-model="form.name" type="text" id="name" class="form-control"
                                                    placeholder="Name" />
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
                                                <input type="file" id="image" class="form-control"
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
                                <router-link to="/admin/subcategory"
                                    class="btn btn-outline-dark ml-3">Cancel</router-link>
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
//   import Pagination from "@/components/Pagination.vue";

export default {
    components: {
        AdminLayout,
        // Pagination
    },
    data() {
        return {
            form: {
                category: "",
                name: "",
                slug: "",
                image: null,
                status: "",
            },
            categories: {}, // This will store categories from backend
            successMessage: "",
            errors: {},
        };
    },
    mounted() {
        this.fetchCategories();
    },
    methods: {
        async fetchCategories() {
            try {
                const response = await axios.get(`http://127.0.0.1:8001/api/category-show-all`);
                this.categories = response.data.categories; // Assuming it's an object with key-value pairs
                console.log(response);
            } catch (error) {
                console.error("Error fetching categories:", error);
            }
        },
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.image = file;
            }
        },
        async submitForm() {
            
            try {
                const formData = new FormData();
                formData.append("category", this.form.category);
                formData.append("name", this.form.name);
                formData.append("slug", this.form.slug);
                formData.append("image", this.form.image);
                formData.append("status", this.form.status);

                const response = await axios.post(`http://127.0.0.1:8001/api/create-subcategory`, formData);

                this.successMessage = response.data.success;
                // this.errors = {}; // Reset errors
                this.resetForm();
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        },
        resetForm() {
            this.form = {
                category: "",
                name: "",
                slug: "",
                image: null,
                status: "",
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