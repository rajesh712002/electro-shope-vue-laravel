<template>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-3">
          <!-- Account Panel (if needed) -->
        </div>
        <div class="col-md-9">
          <div class="card">
            <div v-if="successMessage" class="col-md-10">
              <div class="alert alert-success">
                {{ successMessage }}
              </div>
            </div>
  
            <div class="card-header">
              <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
            </div>
  
            <div class="card-body p-4">
              <form @submit.prevent="submitForm">
                <input type="hidden" v-model="form.token" />
  
                <div class="mb-3">
                  <label for="new_password">New Password</label>
                  <input 
                    type="password" 
                    v-model="form.new_password" 
                    placeholder="New Password" 
                    class="form-control" 
                    :class="{ 'is-invalid': errors.new_password }"
                  />
                  <p v-if="errors.new_password" class="invalid-feedback">{{ errors.new_password }}</p>
                </div>
  
                <div class="mb-3">
                  <label for="confirm_password">Confirm Password</label>
                  <input 
                    type="password" 
                    v-model="form.confirm_password" 
                    placeholder="Confirm New Password" 
                    class="form-control" 
                    :class="{ 'is-invalid': errors.confirm_password }"
                  />
                  <p v-if="errors.confirm_password" class="invalid-feedback">{{ errors.confirm_password }}</p>
                </div>
  
                <div class="d-flex">
                  <button type="submit" class="btn btn-dark">Save Password</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  export default {
    data() {
      return {
        form: {
          token: "",
          new_password: "",
          confirm_password: "",
        },
        errors: {},
        successMessage: "",
      };
    },
    mounted() {
      // Get the token from URL query params
      this.form.token = this.$route.params.token || "";
      console.log('hii', this.form.token )
     
    },
    methods: {
      async submitForm() {
        this.errors = {}; // Reset errors
        this.successMessage = ""; // Reset success message
  
        try {
          const response = await axios.post("/api/resest-forgot-password-email", this.form)
  
          this.successMessage = "Password reset successfully!";
          this.form.new_password = "";
          this.form.confirm_password = "";
        } catch (error) {
          if (error.errors) {
            this.errors = error.errors;
          } else {
            console.error("Unexpected error:", error);
          }
        }
      },
    },
  };
  
  </script>
  
  <style>
  .invalid-feedback {
    color: red;
  }
  </style>
  