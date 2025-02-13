<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Update Sub Category</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <router-link to="/subcategories" class="btn btn-primary">Back</router-link>
                            </div>
                        </div>
                    </div>
                </section>

                <div v-if="successMessage" class="alert alert-success">
                    <b>{{ successMessage }}</b>
                </div>

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
                                                        {{ value }}
                                                    </option>
                                                </select>
                                                <p v-if="errors.category" class="text-danger">{{ errors.category }}</p>
                                            </div>
                                        </div>

                                        <!-- Name -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input v-model="form.subcate_name" type="text" id="name"
                                                    class="form-control" placeholder="Name" />
                                                <p v-if="errors.subcate_name" class="text-danger">{{ errors.subcate_name
                                                    }}</p>
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

                                        <!-- Image Upload -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="image">Photo</label>
                                                <input type="file" id="image" class="form-control"
                                                    @change="handleFileChange" />
                                                <p v-if="errors.image" class="text-danger">{{ errors.image }}</p>
                                                <div v-if="form.image_preview">
                                                    <img :src="form.image_preview" alt="Preview" width="100"
                                                        class="mt-2">
                                                </div>
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
                                <button type="submit" class="btn btn-primary">Update</button>
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

export default {
    components: {
        AdminLayout,
    },
    data() {
        return {
            form: {
                category: "",
                subcate_name: "",
                slug: "",
                image: null,
                image_preview: null, // To show existing image preview
                status: "",
            },
            categories: {}, // Store categories from backend
            successMessage: "",
            errors: {},
        };
    },
    mounted() {
        this.fetchCategories();
        this.fetchSubcategory();
    },
    methods: {
        // Fetch categories for dropdown
        async fetchCategories() {
            try {
                const response = await axios.get(`http://127.0.0.1:8001/api/category-show-all`);
                console.log(response)
                this.categories = response.data.categories;
            } catch (error) {
                console.error("Error fetching categories:", error);
            }
        },

        // Fetch existing subcategory data for update
        async fetchSubcategory() {
            const subcategoryId = this.$route.params.id; // Get ID from route params
            try {
                const response = await axios.get(`http://127.0.0.1:8001/api/subcategory-show/${subcategoryId}`);
                console.log(response);

                if (response.data && response.data.subcategory) {
                    const subcategory = response.data.subcategory;

                    // Set form data (category should be set to subcate_id, NOT name)
                    this.form = {
                        category: subcategory.subcate_id, // Ensure this is an ID, not a name
                        subcate_name: subcategory.subcate_name,
                        slug: subcategory.slug,
                        image_preview: subcategory.image ? `http://127.0.0.1:8001/uploads/${subcategory.image}` : null,
                        status: subcategory.status,
                    };
                } else {
                    console.error("Invalid API Response:", response.data);
                }
            } catch (error) {
                console.error("Error fetching subcategory:", error);
            }
        },


        // Handle file upload
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.image = file;
                this.form.image_preview = URL.createObjectURL(file);
            }
        },

        // Submit form for updating the subcategory
        async submitForm() {
            const subcategoryId = this.$route.params.id;
            try {
                const formData = new FormData();
                formData.append("_method", "PUT"); // Laravel requires this for PUT requests with FormData
                formData.append("category", this.form.category);
                formData.append("subcate_name", this.form.subcate_name);
                formData.append("slug", this.form.slug);
                if (this.form.image) {
                    formData.append("image", this.form.image);
                }
                formData.append("status", this.form.status);

                const response = await axios.post(
                    `http://127.0.0.1:8001/api/update-subcategory/${subcategoryId}`,
                    formData
                );

                this.successMessage = response.data.success;
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        },
    },
};
</script>

<style scoped>
.text-danger {
    color: red;
}
</style>
