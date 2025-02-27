<template>
  <main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
      <header class="bg-dark">
        <div class="container">
          <nav class="navbar navbar-expand-xl"></nav>
        </div>
      </header>
      <div class="container">
        <div class="light-font">
          <ol class="breadcrumb primary-color mb-0">
            <li class="breadcrumb-item">
              <router-link class="white-text" to="/">Home</router-link>
            </li>
            <li class="breadcrumb-item">
              <router-link class="white-text" to="/shop">Shop</router-link>
            </li>
            <li class="breadcrumb-item">Login</li>
          </ol>
        </div>
      </div>
    </section>

    <section class="section-10">
      <div class="container">
        <div class="login-form">
          <div v-if="successMessage" class="alert alert-success">
            {{ successMessage }}
          </div>
          <div v-if="errorMessage" class="alert alert-danger">
            {{ errorMessage }}
          </div>
          <h4 class="modal-title">Login to Your Account</h4>
          <form @submit.prevent="handleLogin">
            <div class="form-group">
              <input type="email" v-model="email" class="form-control" :class="{ 'is-invalid': errors.email }"
                placeholder="Enter Email" />
              <p v-if="errors.email" class="invalid-feedback">{{ errors.email }}</p>
            </div>

            <div class="form-group">
              <input type="password" v-model="password" class="form-control" :class="{ 'is-invalid': errors.password }"
                placeholder="Enter Password" />
              <p v-if="errors.password" class="invalid-feedback">{{ errors.password }}</p>
            </div>

            <div class="form-group small">
              <router-link to="/forgot-password" class="forgot-link">Forgot Password?</router-link>
            </div>

            <button type="submit" class="btn btn-dark btn-block btn-lg">Login</button>
          </form>

          <div class="text-center small">
            Don't have an account?
            <router-link to="/register">Sign up</router-link>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      email: "",
      password: "",
      errors: {},
      successMessage: "",
    };
  },
  methods: {
    async handleLogin() {
      this.errors = {};
      this.successMessage = "";
      this.errorMessage = "";

      try {
        let response = await axios.post("/api/user-login", {
          email: this.email,
          password: this.password,
        });

        console.log('user',response);

        if ( response.data.success) {
          localStorage.setItem("auth_token", response.data.token); // Store token
          localStorage.setItem("user", JSON.stringify(response.data.user)); // Store user data

          this.successMessage = response.data.success;

          setTimeout(() => {
            this.$router.push("/");
          }, 1000);
        }
      } catch (error) {
        console.log(error);
        this.errorMessage = error.response?.data?.message || "Login failed.";
      }
    }


  },
};
</script>

<style scoped>
/* Add your custom styles here */
</style>
