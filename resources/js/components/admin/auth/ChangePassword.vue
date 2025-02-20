<template>
    <AdminLayout>
        <template v-slot:content>
            <main>
                <section class="section-11">
                    <div class="container mt-5">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- Account Panel Component (if needed) -->
                                <!-- <AccountPanel /> -->
                            </div>
                            <div class="col-md-9">
                                <form @submit.prevent="handleChangePassword">
                                    <div class="card">
                                        <div class="card-header">
                                            <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                                        </div>

                                        <div class="card-body p-4">
                                            <div class="row">
                                                <div class="mb-3">
                                                    <label for="old_password">Old Password</label>
                                                    <input v-model="old_password" type="password" id="old_password"
                                                        placeholder="Old Password" class="form-control"
                                                        :class="{ 'is-invalid': errors.old_password }" />
                                                    <p v-if="errors.old_password" class="invalid-feedback">{{
                                                        errors.old_password }}</p>
                                                </div>
                                                <br>
                                                <div class="mb-3">
                                                    <label for="new_password">New Password</label>
                                                    <input v-model="new_password" type="password" id="new_password"
                                                        placeholder="New Password" class="form-control"
                                                        :class="{ 'is-invalid': errors.new_password }" />
                                                    <p v-if="errors.new_password" class="invalid-feedback">{{
                                                        errors.new_password }}</p>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="confirm_password">Confirm Password</label>
                                                    <input v-model="confirm_password" type="password"
                                                        id="confirm_password" placeholder="Confirm New Password"
                                                        class="form-control"
                                                        :class="{ 'is-invalid': errors.confirm_password }" />
                                                    <p v-if="errors.confirm_password" class="invalid-feedback">{{
                                                        errors.confirm_password }}</p>
                                                </div>

                                                <div class="dflex">
                                                    <button type="submit" class="btn btn-dark">Save Password</button>
                                                    <button type="reset" class="btn btn-secondary ms-2"
                                                        @click="resetForm">Cancel</button>
                                                </div>

                                                <p v-if="successMessage" class="text-success mt-3">{{ successMessage }}
                                                </p>
                                                <p v-if="errorMessage" class="text-danger mt-3">{{ errorMessage }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
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
            old_password: "",
            new_password: "",
            confirm_password: "",
            errors: {},
            successMessage: "",
            errorMessage: "",
        };
    },
    methods: {
        async handleChangePassword() {
    this.errors = {};
    this.successMessage = "";
    this.errorMessage = "";

    try {
        let response = await axios.post(`/api/admin/change-password`, 
            {
                old_password: this.old_password,
                new_password: this.new_password,
                confirm_password: this.confirm_password,
                _method: "PUT" // Include this inside the request payload, not as a separate config
            }
        );

        if (response.data.success) {
            this.successMessage = response.data.success;
            this.resetForm();
        }
    } catch (error) {
        if (error.response && error.response.status === 422) {
            this.errors = error.response.data.errors;
        } else {
            this.errorMessage = "An error occurred. Please try again.";
        }
    }
},

        resetForm() {
            this.old_password = "";
            this.new_password = "";
            this.confirm_password = "";
            this.errors = {};
            this.successMessage = "";
            this.errorMessage = "";
        },
    },
};
</script>

<style scoped>
/* Add any required styling */
</style>