<template>
    <AdminLayout>
        <template v-slot:content>
            <div class="content-wrapper">
                <section class="content-header">
                    <div class="container-fluid my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Create Coupon Code</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <router-link to="/coupons" class="btn btn-primary">Back</router-link>
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

                <section class="content">
                    <div class="container-fluid">
                        <form @submit.prevent="submitForm">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6" v-for="(field, key) in formFields" :key="key">
                                            <div class="mb-3">
                                                <label :for="key">{{ field.label }}</label>
                                                <input v-if="field.type === 'text'" :type="field.type" :name="key"
                                                    :id="key" v-model="form[key]" class="form-control"
                                                    :placeholder="field.placeholder" />
                                                <select v-else-if="field.type === 'select'" v-model="form[key]"
                                                    class="form-control">
                                                    <option v-for="option in field.options" :key="option.value"
                                                        :value="option.value">
                                                        {{ option.label }}
                                                    </option>
                                                </select>
                                                <textarea v-else-if="field.type === 'textarea'" v-model="form[key]"
                                                    class="form-control" :placeholder="field.placeholder"></textarea>
                                                <p class="text-danger" v-if="errors[key]">{{ errors[key][0] }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pb-5 pt-3">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <button type="reset" class="btn btn-secondary" @click="resetForm">Cancel</button>
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
// import $ from "jquery";
// import "jquery-datetimepicker";

export default {
    components: {
        AdminLayout
    },
    data() {
        return {
            form: {
                code: "",
                name: "",
                max_uses: "",
                max_uses_user: "",
                type: "fixed",
                discount_amount: "",
                min_amount: "",
                status: "",
                starts_at: "",
                expires_at: "",
                description: "",
            },
            formFields: {
                code: { label: "Code", type: "text", placeholder: "Coupon Code" },
                name: { label: "Name", type: "text", placeholder: "Coupon Name" },
                max_uses: { label: "Max Uses", type: "text", placeholder: "Max Uses" },
                max_uses_user: { label: "Max Uses User", type: "text", placeholder: "Max Uses per User" },
                type: {
                    label: "Type",
                    type: "select",
                    options: [
                        { value: "fixed", label: "Fixed" },
                        { value: "percent", label: "Percent" }
                    ]
                },
                discount_amount: { label: "Discount Amount", type: "text", placeholder: "Discount Amount" },
                min_amount: { label: "Minimum Amount", type: "text", placeholder: "Minimum Amount" },
                status: {
                    label: "Status",
                    type: "select",
                    options: [
                        { value: "", label: "---Select---" },
                        { value: "1", label: "Active" },
                        { value: "0", label: "Blocked" }
                    ]
                },
                starts_at: { label: "Starts At", type: "text", placeholder: "YYYY-MM-DD HH:MM:SS" },
                expires_at: { label: "Expires At", type: "text", placeholder: "YYYY-MM-DD HH:MM:SS" },
                description: { label: "Description", type: "textarea", placeholder: "Description" },
            },
            successMessage:null,
            errors: {},
        };
    },
    // mounted() {
    //     $("#starts_at").datetimepicker({ format: "Y-m-d H:i:s" });
    //     $("#expires_at").datetimepicker({ format: "Y-m-d H:i:s" });
    // },
    methods: {
        async submitForm() {
            try {
                const response = await axios.post(`/api/create-coupon`, this.form);
                this.successMessage = response.data.message;
                this.resetForm();
            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errors = error.response.data.errors;
                }
            }
        },
        resetForm() {
            this.form = {
                code: "",
                name: "",
                max_uses: "",
                max_uses_user: "",
                type: "fixed",
                discount_amount: "",
                min_amount: "",
                status: "",
                starts_at: "",
                expires_at: "",
                description: "",
            };
            this.errors = {};
        },
    },
};
</script>

<style>
.text-danger {
    color: red;
}
</style>
