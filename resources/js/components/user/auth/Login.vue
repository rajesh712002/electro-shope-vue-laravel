<template>
    <div class="login-box">
      <!-- /.login-logo -->
      <div class="card card-outline card-primary">
        <div class="card-header text-center">
          <a href="#" class="h3">Administrative Panel</a>
        </div>
        <div class="card-body">
          <p class="login-box-msg">Sign in to start your session</p>
          <form @submit.prevent="handleSubmit">
            <div class="row d-flex justify-content-center">
              <div v-if="successMessage" class="col-md-10">
                <div class="alert alert-success">
                  {{ successMessage }}
                </div>
              </div>
            </div>
  
            <div class="input-group mb-3">
              <input
                v-model="email"
                type="email"
                name="email"
                id="email"
                class="form-control"
                :class="{ 'is-invalid': errors.email }"
                placeholder="Email"
              />
              <div v-if="errors.email" class="invalid-feedback">
                {{ errors.email }}
              </div>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
  
            <div class="input-group mb-3">
              <input
                v-model="password"
                type="password"
                name="password"
                id="password"
                class="form-control"
                :class="{ 'is-invalid': errors.password }"
                placeholder="Password"
              />
              <div v-if="errors.password" class="invalid-feedback">
                {{ errors.password }}
              </div>
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
            <a href="forgot-password.html">I forgot my password</a>
          </p>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        email: '',
        password: '',
        errors: {},
        successMessage: ''
      };
    },
    methods: {
      handleSubmit() {
        // Here, you can handle the form submission logic,
        // e.g., sending data to a backend API.
        const formData = {
          email: this.email,
          password: this.password
        };
  
        // Example: submit the data (you'd replace this with actual API call)
        axios
          .post('/admin/check', formData)
          .then((response) => {
            if (response.data.success) {
              this.successMessage = response.data.success;
            }
          })
          .catch((error) => {
            if (error.response && error.response.data.errors) {
              this.errors = error.response.data.errors;
            }
          });
      }
    }
  };
  </script>
  
  <style scoped>
  /* Add custom styles here */
  </style>
  