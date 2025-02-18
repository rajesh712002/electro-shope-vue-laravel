<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Create Product</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <router-link to="/products" class="btn btn-primary">Back</router-link>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="content">
                    <form @submit.prevent="submitProductForm" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" v-model="product.name" class="form-control"
                                                    placeholder="Product Name">
                                                <p v-if="errors.name" class="text-danger">{{ errors.name }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" v-model="product.slug" class="form-control"
                                                    placeholder="Slug">
                                                <p v-if="errors.slug" class="text-danger">{{ errors.slug }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea v-model="product.description" cols="30" rows="5"
                                                    class="form-control" placeholder="Description"></textarea>
                                                <p v-if="errors.description" class="text-danger">{{ errors.description
                                                }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- ✅ Dropzone File Upload -->
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Product Images</h2>
                                            <form ref="dropzoneForm" class="dropzone"></form>
                                            <p v-if="errors.image" class="text-danger">{{ errors.image }}</p>
                                        </div>
                                    </div>

                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Pricing</h2>
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input type="text" v-model="product.price" class="form-control"
                                                    placeholder="Price">
                                                <p v-if="errors.price" class="text-danger">{{ errors.price }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" v-model="product.compare_price" class="form-control"
                                                    placeholder="Compare Price">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Inventory</h2>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="sku">SKU (Stock Keeping Unit)</label>
                                                        <input type="text" v-model="product.sku" class="form-control"
                                                            placeholder="SKU">
                                                        <p v-if="errors.sku" class="text-danger">{{ errors.sku }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="mb-3">
                                                        <div class="custom-control custom-checkbox">
                                                            <input class="custom-control-input" type="checkbox"
                                                                v-model="product.track_qty">
                                                            <label for="track_qty" class="custom-control-label">Track
                                                                Quantity</label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="number" v-model="product.qty" min="0"
                                                            class="form-control" placeholder="Qty">
                                                        <p v-if="errors.qty" class="text-danger">{{ errors.qty }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Product Status</h2>
                                            <select v-model="product.status" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                  
                                    <div class="mb-3">
                                        <label for="category">Category</label>
                                        <select v-model="product.category" class="form-control">
                                            <option value="">--- Select ---</option>
                                            <option v-for="(name, id) in categories" :key="id" :value="id">{{ name }}
                                            </option>
                                        </select>
                                        <p v-if="errors.category" class="text-danger">{{ errors.category }}</p>
                                    </div>
                                    <label for="category">Sub Category</label>
                                    <select v-model="product.sub_category" class="form-control">
                                        <option value="">--- Select Subcategory ---</option>
                                        <option v-for="subcategory in sub_categories" :key="subcategory.id"
                                            :value="subcategory.id">
                                            {{ subcategory.subcate_name }}
                                        </option>
                                    </select>

                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <h2 class="h4 mb-3">Product brand</h2>
                                            <div class="mb-3">
                                                <select v-model="product.brand" class="form-control">
                                                    <option value="">---select---</option>
                                                    <option v-for="(name, id) in brands" :key="id" :value="id">{{ name
                                                        }}</option>
                                                </select>
                                                <p v-if="errors.brand" class="text-danger">{{ errors.brand }}</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>

                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <button type="reset" @click="resetForm" class="btn btn-secondary">Cancel</button>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </template>
    </AdminLayout>
</template>


<script>
import axios from "axios";
import Dropzone from "dropzone";
import "dropzone/dist/dropzone.css";
import AdminLayout from "../../admin/Layouts/AdminLayout.vue";

export default {
    components: {
        AdminLayout
    },
    data() {
        return {
            product: {
                name: '',
                slug: '',
                description: '',
                price: '',
                qty:'',
                sku:'',
                compare_price: '',
                status: 1,
                category: '',
                sub_category: '', 
                brand:'',
                imageFiles: []
            },
            errors: {},
            categories: {},
            sub_categories: {}, 
            brands: {}, 
        };
    },
    methods: {
        initDropzone() {
            this.dropzone = new Dropzone(this.$refs.dropzoneForm, {
                url: "api/images", // Prevent auto-uploading, handle manually
                autoProcessQueue: false,
                maxFiles: 5,
                addRemoveLinks: true,
                acceptedFiles: "image/*",
                init: function () {
                    this.on("addedfile", (file) => {
                        this.product.imageFiles.push(file);
                    });
                    this.on("removedfile", (file) => {
                        this.product.imageFiles = this.product.imageFiles.filter(f => f !== file);
                    });
                },
            });
        },

        async fetchSubCategories() {
            if (!this.product.category) {
                this.sub_categories = {}; // Reset subcategories if no category selected
                this.product.sub_category = ''; // Reset selected subcategory
                return;
            }

            try {
                const response = await axios.get(`/api/get-subcategories/${this.product.category}`);
                console.log(response)

                this.sub_categories = response.data || {};
            } catch (error) {
                console.error("Error fetching subcategories:", error);
            }
        },

        async submitProductForm() {
            let formData = new FormData();

            formData.append("name", this.product.name);
            formData.append("slug", this.product.slug);
            formData.append("description", this.product.description);
            formData.append("price", this.product.price);
            formData.append("qty", this.product.qty);
            formData.append("sku", this.product.sku);
            formData.append("compare_price", this.product.compare_price);
            formData.append("status", this.product.status);
            formData.append("category", this.product.category);
            formData.append("sub_category", this.product.sub_category);
            formData.append("brand", this.product.brand);


            // Append Images
            this.product.imageFiles.forEach((file, index) => {
                formData.append(`images[${index}]`, file);
            });

            try {
                const response = await axios.post(`/api/create-products`, formData, {
                    headers: { "Content-Type": "multipart/form-data" }
                });
                console.log(response)
                alert(response.data.success);
                this.resetForm();
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        },

        resetForm() {
            this.product = {
                name: '',
                slug: '',
                description: '',
                price: '',
                compare_price: '',
                status: 1,
                category: '',
                sub_category: '',
                imageFiles: []
            };
            this.dropzone.removeAllFiles();
        }
    },

    async mounted() {
        this.initDropzone();

        try {
            const response = await axios.get('/api/show-data');
            console.log(response)
            this.categories = response.data.category || {};
            this.brands = response.data.brand || {};
        } catch (error) {
            console.error("Error fetching data:", error);
        }
    },

    watch: {
        "product.category": function () {
            this.fetchSubCategories(); // Call fetchSubCategories when category changes
        }
    }
};
</script>

<style scoped>
.dropzone {
    border: 2px dashed #007bff;
    padding: 20px;
    background: #f8f9fa;
    text-align: center;
    color: #007bff;
    font-size: 1rem;
}
</style>
