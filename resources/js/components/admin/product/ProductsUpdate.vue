<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Update Product</h1>
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
                                                <input type="text" v-model="product.prod_name" class="form-control"
                                                    placeholder="Product Name">
                                                <p v-if="errors.name" class="text-danger">{{ errors.name }}</p>
                                            </div>

                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" v-model="product.slug" class="form-control"
                                                    placeholder="Slug">
                                                <p v-if="errors.slug" class="text-danger">{{ errors.slug }}</p>
                                            </div>

                                            <!-- <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea v-model="product.description" cols="30" rows="5"
                                                    class="form-control" placeholder="Description"></textarea>
                                                <p v-if="errors.description" class="text-danger">{{ errors.description
                                                }}</p>
                                            </div> -->

                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <Editor :modelValue="product.description"
                                                    @update:modelValue="product.description = $event"
                                                    api-key="adkflfpe6mrdbxryjc4huob43fi29gg6o1a9gjfbf22la31k" :init="{
                                                        height: 300,
                                                        menubar: false,
                                                        plugins: 'lists link image preview code table media paste textpattern',
                                                        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | table | code preview',
                                                    }" />
                                                <p v-if="errors.description" class="text-danger">{{ errors.description
                                                }}</p>
                                            </div>
                                        </div>
                                    </div>

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
                                            <h2 class="h4 mb-3">Product Brand</h2>
                                            <div class="mb-3">
                                                <select v-model="product.brand" class="form-control">
                                                    <option value="">---select---</option>
                                                    <!-- <option v-for="(name, id) in brands" :key="id" :value="id">{{ name
                                                        }}</option> -->
                                                    <option v-for="(name, id) in brands" :key="id" :value="id">
                                                        {{ name }}
                                                    </option>
                                                </select>
                                                <p v-if="errors.brand" class="text-danger">{{ errors.brand }}</p>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Update</button>
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
import Editor from '@tinymce/tinymce-vue';


export default {
    components: {
        AdminLayout, Editor
    },
    data() {
        return {
            product: {
                id: null,
                name: '',
                slug: '',
                description: '',
                price: '',
                qty: '',
                sku: '',
                compare_price: '',
                status: '',
                category: '',
                sub_category: '',
                brand: '',
                imageFiles: [],
                imageArray: []
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
                url: "/api/images",
                paramName: "image",
                maxFiles: 5,
                acceptedFiles: "image/*",
                autoProcessQueue: true,
                addRemoveLinks: true,
            });

            this.funDropzone();
        },

        funDropzone() {
            this.dropzone.on("success", (file, response) => {
                if (response.image_id) {
                    this.product.imageArray = this.product.imageArray || [];
                    this.product.imageArray.push(response.image_id);
                }

                let html = `<div class="col-md-3" style="width: 18rem;">
                    <input type="hidden" name="image_array[]" value="${response.image_id}">
                    <img src="${response.ImagePath}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <a href="#" class="btn btn-danger" data-file="${file.name}">Delete</a>
                    </div>
                </div>`;
                document.getElementById("productImages").insertAdjacentHTML("beforeend", html);
            });
        },

        async fetchSubCategories() {
            if (!this.product.category) {
                this.sub_categories = {};
                this.product.sub_category = '';
                return;
            }

            try {
                const response = await axios.get(`/api/get-subcategories/${this.product.category}`);
                this.sub_categories = response.data || {};
            } catch (error) {
                console.error("Error fetching subcategories:", error);
            }
        },

        async fetchProductData() {
            try {
                const product_id = this.$route.params.id;
                const response = await axios.get(`/api/product-show/${product_id}`);
                console.log('hii', response)
                // this.product.brand = response.data.product.brand_id;

                this.product = response.data.product;
                this.categories = response.data.category || {};
                this.brands = response.data.brand || {};
                this.sub_categories = response.data.sub_category || {};

                this.product.category = response.data.product.category_id;
                // Fetch subcategories dynamically
                await this.fetchSubCategories();

                // Then set the subcategory
                this.product.sub_category = response.data.product.sub_category_id;

                // Set brand
                this.product.brand = response.data.product.brand_id;

            } catch (error) {
                console.error("Error fetching product data:", error);
            }
        },

        async submitProductForm() {
            let formData = new FormData();

            formData.append("id", this.product.id);
            formData.append("name", this.product.prod_name);
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

            // this.product.imageArray.forEach((id, index) => {
            //     formData.append(`image_array[${index}]`, id);
            // });

            // this.product.imageFiles.forEach((file, index) => {
            //     formData.append(`images[${index}]`, file);
            // });

            try {
                formData.append("_method", "PUT");
                const response = await axios.post(`/api/update-product/${this.product.id}`, formData, {
                    headers: { "Content-Type": "multipart/form-data" },
                });
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
                id: null,
                prod_name: '',
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
        this.fetchProductData();
    },

    watch: {
        "product.category": function () {
            this.fetchSubCategories();
        }
    }
};
</script>
