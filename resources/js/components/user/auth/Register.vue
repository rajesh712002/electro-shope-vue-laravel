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
              <li class="breadcrumb-item">Register</li>
            </ol>
          </div>
        </div>
      </section>
  
      <section class="section-10">
        <div class="container">
          <div class="login-form">
            <h4 class="modal-title">Register Now</h4><br>
  
            <div v-if="successMessage" class="alert alert-success">
              {{ successMessage }}
            </div>
  
            <form @submit.prevent="handleRegister">
              <div>
                <h5>Name</h5>
              </div>
              <div class="form-group">
                <input
                  type="text"
                  v-model="name"
                  class="form-control"
                  :class="{ 'is-invalid': errors.name }"
                  placeholder="Name"
                />
                <p v-if="errors.name" class="invalid-feedback">{{ errors.name }}</p>
              </div>
  
              <div>
                <h5>Email</h5>
              </div>
              <div class="form-group">
                <input
                  type="email"
                  v-model="email"
                  class="form-control"
                  :class="{ 'is-invalid': errors.email }"
                  placeholder="Enter Email"
                />
                <p v-if="errors.email" class="invalid-feedback">{{ errors.email }}</p>
              </div>
  
              <div>
                <h5>Mobile No</h5>
              </div>
              <div class="form-group">
                <input
                  type="text"
                  v-model="phone"
                  class="form-control"
                  :class="{ 'is-invalid': errors.phone }"
                  placeholder="Enter Mobile No"
                />
                <p v-if="errors.phone" class="invalid-feedback">{{ errors.phone }}</p>
              </div>
  
              <div>
                <h5>Password</h5>
              </div>
              <div class="form-group">
                <input
                  type="password"
                  v-model="password"
                  class="form-control"
                  :class="{ 'is-invalid': errors.password }"
                  placeholder="Enter Password"
                />
                <p v-if="errors.password" class="invalid-feedback">{{ errors.password }}</p>
              </div>
  
              <div>
                <h5>Confirm Password</h5>
              </div>
              <div class="form-group">
                <input
                  type="password"
                  v-model="confirmPassword"
                  class="form-control"
                  :class="{ 'is-invalid': errors.confirmPassword }"
                  placeholder="Confirm Password"
                />
                <p v-if="errors.confirmPassword" class="invalid-feedback">{{ errors.confirmPassword }}</p>
              </div><br>
  
              <button type="submit" class="btn btn-dark btn-block btn-lg">Register</button>
            </form>
  
            <div class="text-center small">
              Already have an account?
              <router-link to="/login">Login Now</router-link>
            </div>
          </div>
        </div>
      </section>
    </main>
  </template>
  
  <script>
  export default {
    data() {
      return {
        name: "",
        email: "",
        phone: "",
        password: "",
        confirmPassword: "",
        errors: {},
        successMessage: "",
      };
    },
    methods: {
      async handleRegister() {
        this.errors = {}; 
  
        if (!this.name) this.errors.name = "Name is required";
        if (!this.email) this.errors.email = "Email is required";
        if (!this.phone) this.errors.phone = "Mobile number is required";
        if (!this.password) this.errors.password = "Password is required";
        if (this.password !== this.confirmPassword)
          this.errors.confirmPassword = "Passwords do not match";
  
        if (Object.keys(this.errors).length > 0) return;
  
        try {
          const response = await fetch("/api/user-register", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({
              name: this.name,
              email: this.email,
              phone: this.phone,
              password: this.password,
            }),
          });
  
          const data = await response.json();
  
          if (!response.ok) {
            this.errors.email = data.message || "Registration failed";
          } else {
            this.successMessage = "Registration successful!";
            this.$router.push("/user-login"); // Redirect to login
          }
        } catch (error) {
          this.errors.email = "Something went wrong. Please try again.";
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Add any custom styling */
  </style>
  