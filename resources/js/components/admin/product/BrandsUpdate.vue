<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <!-- Page Header -->
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Edit Brand</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <router-link to="/brands" class="btn btn-primary">Back</router-link>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Success Message -->
                <div v-if="successMessage" class="alert alert-success text-center mt-3">
                    <b>{{ successMessage }}</b>
                </div>

                <!-- Loading Spinner -->
                <section class="content">
                    <div v-if="isLoading" class="overlay">
                        <div class="spinner-container">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>

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
                                                <label class="form-label" for="image">Photo</label>
                                                <input type="file" id="image" class="form-control"
                                                    @change="handleFileChange" />
                                                <p v-if="errors.image" class="text-danger">{{ errors.image }}</p>

                                                <div v-if="form.image_preview">
                                                    <img :src="form.image_preview" alt="Brand Image" class="mt-2"
                                                        style="max-width: 150px;" />
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

                            <!-- Buttons -->
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
import AdminLayout from "../../admin/Layouts/AdminLayout.vue";
import axios from "axios";

export default {
    components: {
        AdminLayout,
    },
    data() {
        return {
            form: {
                name: "",
                slug: "",
                image: null,
                image_preview: null, // Preview existing image
                status: "",
            },
            errors: {},
            successMessage: null,
            isLoading: false,
        };
    },
    mounted() {
        this.loadBrandData();
    },
    methods: {
        async loadBrandData() {
            this.isLoading = true;
            const brandId = this.$route.params.id;
            console.log(brandId)
            try {
                const response = await axios.get(`/api/brand-show/${brandId}`);
            console.log(response)

                if (response.data && response.data.brand) {
                    this.form = response.data.brand;
                } else {
                    console.error("Invalid API Response:", response.data);
                }
            } catch (error) {
                console.error("Error loading brand data", error);
            } finally {
                this.isLoading = false;
            }
        },

        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.image = file;
                this.form.image_preview = URL.createObjectURL(file); // Show preview of the new image
            }
        },

        async submitForm() {
            this.isLoading = true;
            try {
                const brandId = this.$route.params.id;
                const formData = new FormData();
                formData.append("name", this.form.name);
                formData.append("slug", this.form.slug);
                formData.append("status", this.form.status);

                if (this.form.image) {
                    formData.append("image", this.form.image);
                }

                formData.append("_method", "PUT"); // Laravel handles PUT better with _method=PUT

                const response = await axios.post(`/api/update-brand/${brandId}`, formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                });
            
                this.successMessage = response.data.success;
                this.resetForm();

            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            } finally {
                this.isLoading = false;
            }
        },

        resetForm() {
            this.form = { name: "", slug: "", image: null, status: "" }; // Reset to the last loaded brand data
            this.errors = {};
        },
    },
};
</script>

<style scoped>
.overlay {
    display: flex;
    justify-content: center;
    align-items: center;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
}

.spinner-container {
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>
