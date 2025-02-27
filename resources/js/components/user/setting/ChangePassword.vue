<template>
    <Header />
    <main>
      <!-- Breadcrumb Section -->
      <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
          <ol class="breadcrumb primary-color mb-0">
            <li class="breadcrumb-item">
              <router-link class="white-text" to="/shop">Shop</router-link>
            </li>
            <li class="breadcrumb-item"><span class="white-text">My Account</span></li>
            <li class="breadcrumb-item">Settings</li>
          </ol>
        </div>
      </section>
  
      <!-- Change Password Section -->
      <section class="section-11">
        <div class="container mt-5">
          <div class="row">
            <div class="col-md-3">
              <SettingSideBar /> <!-- Replace with actual account panel component -->
            </div>
            <div class="col-md-9">
              <form @submit.prevent="changePassword">
                <div class="card">
                  <div class="card-header">
                    <h2 class="h5 mb-0 pt-2 pb-2">Change Password</h2>
                  </div>
  
                  <div class="card-body p-4">
                    <div class="row">
                      <div class="mb-3">
                        <label for="old_password">Old Password</label>
                        <input
                          type="password"
                          id="old_password"
                          v-model="form.old_password"
                          placeholder="Old Password"
                          class="form-control"
                          :class="{ 'is-invalid': errors.old_password }"
                        />
                        <p v-if="errors.old_password" class="invalid-feedback">{{ errors.old_password }}</p>
                      </div>
  
                      <div class="mb-3">
                        <label for="new_password">New Password</label>
                        <input
                          type="password"
                          id="new_password"
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
                          id="confirm_password"
                          v-model="form.confirm_password"
                          placeholder="Confirm New Password"
                          class="form-control"
                          :class="{ 'is-invalid': errors.confirm_password }"
                        />
                        <p v-if="errors.confirm_password" class="invalid-feedback">{{ errors.confirm_password }}</p>
                      </div>
  
                      <div class="dflex">
                        <button type="submit" class="btn btn-dark" :disabled="loading">
                          <span v-if="loading" class="spinner-border spinner-border-sm"></span>
                          Save Password
                        </button>
                      </div>
  
                      <!-- Success Message -->
                      <p v-if="successMessage" class="text-success mt-2">{{ successMessage }}</p>
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
  
  <script>
  import axios from "axios";
  import Header from "../include/Header.vue";
  import SettingSideBar from "./SettingSideBar.vue";
  export default {
    components: {
      Header,
      SettingSideBar,
    },
    data() {
      return {
        form: {
          old_password: "",
          new_password: "",
          confirm_password: "",
        },
        errors: {},
        successMessage: "",
        loading: false,
      };
    },
    methods: {
      // Change Password
      changePassword() {
        this.loading = true;
        this.errors = {};
        this.successMessage = "";
       
        axios
          .post("/api/change-password", this.form)
          .then((response) => {
            this.successMessage = "Password changed successfully!";
            this.form.old_password = "";
            this.form.new_password = "";
            this.form.confirm_password = "";
          })
          .catch((error) => {
            if (error.response && error.response.data.errors) {
              this.errors = error.response.data.errors;
            } else {
              this.errors.general = "Something went wrong. Please try again.";
            }
          })
          .finally(() => {
            this.loading = false;
          });
      },
    },
  };
  </script>
  
  <style scoped>
  /* Additional styling if needed */
  </style>
  