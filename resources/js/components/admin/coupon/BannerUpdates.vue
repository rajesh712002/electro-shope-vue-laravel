<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Edit Banner</h1>
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
                                        <!-- title -->
                                        <div class="col-md-6 mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" v-model="form.title" class="form-control"
                                                placeholder="Banner Name" />
                                            <p v-if="errors.title" class="text-danger">{{ errors.title }}</p>
                                        </div>

                                        <!-- Image -->
                                        <div class="col-md-6 mb-3">
                                            <label for="image">Banner Image</label>
                                            <input type="file" @change="handleFileUpload" class="form-control" />
                                            <p v-if="errors.image" class="text-danger">{{ errors.image }}</p>

                                            <!-- Image Preview -->
                                            <div v-if="form.image_preview">
                                                <img :src="form.image_preview" alt="Banner Image" class="mt-2"
                                                    style="max-width: 150px;" />
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-6 mb-3">
                                            <label for="status">Status</label>
                                            <select v-model="form.status" class="form-control">
                                                <option value="">---select---</option>
                                                <option value="1">Active</option>
                                                <option value="0">Block</option>
                                            </select>
                                            <p v-if="errors.status" class="text-danger">{{ errors.status }}</p>
                                        </div>

                                        <!-- Description -->
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
                                <button type="submit" class="btn btn-primary">Update</button>
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

export default {
    components: {
        AdminLayout
    },

    data() {
        return {
            form: {
                title: '',
                image: null,
                image_preview: null, // Holds the existing image URL
                status: '',
                description: '',
            },
            errors: {},
            successMessage: null,
            isLoading: false,
        };
    },

    mounted() {
        this.loadBannerData();
    },

    methods: {
        async loadBannerData() {
            this.isLoading = true;
            const bannerId = this.$route.params.id; // Get the banner ID from the route
            try {
                const response = await axios.get(`/api/banner-show/${bannerId}`);
                console.log(response);

                if (response.data && response.data.banner) {
                    this.form = response.data.banner;
                } else {
                    console.error("Invalid API Response:", response.data);
                }
            } catch (error) {
                console.error("Error loading banner data", error);
            } finally {
                this.isLoading = false;
            }
        },

        handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.image = file;
                this.form.image_preview = URL.createObjectURL(file); // Show preview of new image
            }
        },

       
        async submitForm() {
            this.isLoading = true;
            try {
                const bannerId = this.$route.params.id;
                const formData = new FormData();
                formData.append("name", this.form.name);
                formData.append("status", this.form.status);
                formData.append("description", this.form.description);

                if (this.form.image) {
                    formData.append("image", this.form.image);
                }

                // Laravel fix: Use _method=PUT if necessary
                formData.append("_method", "PUT");

                const response = await axios.post(`/api/update-banners/${bannerId}`, formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                });

                this.successMessage =  response.data.success;
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            } finally {
                this.isLoading = false;
            }
        },


        resetForm() {
            this.loadBannerData(); // Reload the existing data instead of clearing the form
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
