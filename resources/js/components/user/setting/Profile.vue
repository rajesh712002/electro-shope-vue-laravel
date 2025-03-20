<template>
  <div>
    <Header />
    <main>
      <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
          <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
              <li class="breadcrumb-item">
                <router-link class="white-text" to="/shop">Shop</router-link>
              </li>
              <li class="breadcrumb-item">
                My Account
              </li>
              <li class="breadcrumb-item">Settings</li>
            </ol>
          </div>
        </div>
      </section>

      <section class="section-11">
        <div class="container mt-5">
          <div class="row">
            <div class="col-md-3">
              <SettingSideBar />
            </div>
            <div class="col-md-9">
              <form @submit.prevent="updateProfile">
                <div class="card">
                  <div class="card-header">
                    <h2 class="h5 mb-0 pt-2 pb-2">Personal Information</h2>
                  </div>
                  <div class="card-body p-4">
                    <div class="row">
                      <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" id="name" v-model="profile.name" placeholder="Enter Your Name"
                          class="form-control" />
                        <p class="text-danger" v-if="errors.name">{{ errors.name[0] }}</p>
                      </div>
                      <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="text" id="email" v-model="profile.email" placeholder="Enter Your Email"
                          class="form-control" />
                        <p class="text-danger" v-if="errors.email">{{ errors.email[0] }}</p>
                      </div>
                      <div class="mb-3">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" v-model="profile.phone" placeholder="Enter Your Phone"
                          class="form-control" />
                        <p class="text-danger" v-if="errors.phone">{{ errors.phone[0] }}</p>
                      </div>
                      <div class="d-flex">
                        <button type="submit" class="btn btn-dark">Update</button>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>
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
      profile: {}, 
      errors: {}   
    };
  },
  mounted() {
    this.fetchProfile();
  },
  methods: {
    async fetchProfile() {
      try {
        const response = await axios.get("/api/get-profile");
        this.profile = response.data.user[0] || {}; // Ensure it's always an object
      } catch (error) {
        console.error("Error fetching profile:", error);
      }
    },

    async updateProfile() {
      try {
        await axios.post("/api/change-profile", this.profile);
        alert("Profile updated successfully!");
        this.errors = {}; // Clear errors on success
      } catch (error) {
        if (error.response && error.response.data.errors) {
          this.errors = error.response.data.errors; // Assign error messages
        } else {
          console.error("Error updating profile:", error);
        }
      }
    }
  }
};
</script>
