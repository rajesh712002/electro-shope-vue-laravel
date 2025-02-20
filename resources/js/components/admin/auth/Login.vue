<template>
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h3">Administrative Panel</a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <!-- Success Message -->
        <div v-if="successMessage" class="alert alert-success">
          {{ successMessage }}
        </div>

        <!-- Error Message -->
        <div v-if="errorMessage" class="alert alert-danger">
          {{ errorMessage }}
        </div>

        <form @submit.prevent="handleLogin">
          <!-- Email Input -->
          <div class="input-group mb-3">
            <input v-model="email" type="email" class="form-control" :class="{ 'is-invalid': errors.email }" placeholder="Email" />
            <div v-if="errors.email" class="invalid-feedback">{{ errors.email }}</div>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>

          <!-- Password Input -->
          <div class="input-group mb-3">
            <input v-model="password" type="password" class="form-control" :class="{ 'is-invalid': errors.password }" placeholder="Password" />
            <div v-if="errors.password" class="invalid-feedback">{{ errors.password }}</div>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </div>
          </div>
        </form>

        <p class="mb-1 mt-3">
          <!-- Uncomment if you have forgot password -->
          <!-- <a href="#">I forgot my password</a> -->
        </p>
      </div>
    </div>
  </div>
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
      errorMessage: ""
    };
  },
  methods: {
    async handleLogin() {
      this.errors = {}; // Clear errors
      this.successMessage = "";
      this.errorMessage = "";

      try {
        let response = await axios.post(`/api/admin-login`, {
          email: this.email,
          password: this.password
        });

        if (response.data.success) {
          this.successMessage = response.data.success;
          // Redirect admin after successful login
          setTimeout(() => {
            this.$router.push("/deshboard");
          }, 1000);
        }
      } catch (error) {
        if (error.response) {
          if (error.response.status === 422) {
            // Validation errors
            this.errors = error.response.data.errors;
          } else {
            // Authentication error
            this.errorMessage = error.response.data.message || "Login failed. Please try again.";
          }
        } else {
          this.errorMessage = "An error occurred. Please check your connection.";
        }
      }
    }
  }
};

</script>

<style scoped>
.login-box {
  width: 400px; /* Adjust width as needed */
  margin: auto;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
}
</style>
