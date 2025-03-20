<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Create Category</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <router-link to="/categories" class="btn btn-primary">Back</router-link>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>

                <!-- Success Message -->
                <div class="row d-flex justify-content-center" v-if="successMessage">
                    <div class="col-md-10 mt-4">
                        <div class="alert alert-success">
                            <b>{{ successMessage }}</b>
                        </div>
                    </div>
                </div>

                <!-- Main content -->
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
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input v-model="form.name" type="text" id="name" class="form-control"
                                                    placeholder="Category Name" />
                                                <p v-if="errors.name" class="text-danger">{{ errors.name }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input v-model="form.slug" type="text" id="slug" class="form-control"
                                                    placeholder="Slug" />
                                                <p v-if="errors.slug" class="text-danger">{{ errors.slug }}</p>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label" for="image">Photo</label>
                                                <input type="file" id="image" class="form-control form-control-lg"
                                                    @change="handleFileChange" />
                                                <p v-if="errors.image" class="text-danger">{{ errors.image }}</p>
                                            </div>
                                        </div>

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
                                <button type="reset" @click="resetForm" class="btn btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </section>
                <!-- /.content -->
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
                name: "",
                slug: "",
                image: null,
                status: "",
            },
            errors: [{}],
            successMessage: null,
            isLoading: false,
        };
    },
    methods: {
       
        handleFileChange(event) {
            const file = event.target.files[0];
            if (file) {
                this.form.image = file;
            }
        },
        async submitForm() {
            this.isLoading = true;
            try {
                const formData = new FormData();
                formData.append("name", this.form.name);
                formData.append("slug", this.form.slug);
                formData.append("image", this.form.image);
                formData.append("status", this.form.status);

                const response = await axios.post(`/api/create-category`,formData);

                this.successMessage = response.data.success;
                console.log(this.successMessage)
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
            this.form = {
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