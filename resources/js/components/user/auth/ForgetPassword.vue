<template>
    <div>
      <main>
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
          <header class="bg-dark">
            <div class="container">
              <nav class="navbar navbar-expand-xl" id="navbar"></nav>
            </div>
          </header>
          <div class="container">
            <div class="light-font">
              <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item">
                  <router-link class="white-text" to="/">Home</router-link>
                </li>
                <li class="breadcrumb-item">
                  <router-link class="white-text" to="/user-login">Login</router-link>
                </li>
              </ol>
            </div>
          </div>
        </section>
        <section class="section-10">
          <div class="container">
            <div class="login-form">
              <form @submit.prevent="submitForm">
                <div class="row d-flex justify-content-center" v-if="successMessage">
                  <div class="col-md-10">
                    <div class="alert alert-success">{{ successMessage }}</div>
                  </div>
                </div>
                <h4 class="modal-title">Enter Email For Login</h4>
                <div class="form-group">
                  <input type="email" v-model="email" class="form-control" :class="{ 'is-invalid': errors.email }" placeholder="Enter Email" />
                  <p class="invalid-feedback" v-if="errors.email">{{ errors.email }}</p>
                </div>
                <div class="form-group small">
                  <router-link to="/user-login" class="forgot-link">Login</router-link>
                </div>
                <input type="submit" class="btn btn-dark btn-block btn-lg" value="Send" />
              </form>
            </div>
          </div>
        </section>
      </main>
    </div>
  </template>
  
  <script>
  import axios from "axios";
  export default {
    data() {
      return {
        email: "",
        errors: {},
        successMessage: ""
      };
    },
    methods: {
      async submitForm() {
        try {
          const response = await axios.post("/api/user/forgot-password", {
            email: this.email
          });
          console.log(response)
          this.successMessage = response.data.message;
          this.errors = {};
        } catch (error) {
          if (error.response && error.response.data.errors) {
            this.errors = error.response.data.errors;
          } else {
            console.error("An error occurred:", error);
          }
        }
      }
    }
  };
  </script>
  
  <style scoped>
  .section-10 {
    padding: 20px;
  }
  .login-form {
    width: 400px;
    margin: 50px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    text-align: center;
  }
  button {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
  }
  button:hover {
    background-color: #0056b3;
  }
  </style>
  