<template>
  <ul id="account-panel" class="nav nav-pills flex-column">
    <li class="nav-item">
      <router-link to="/profile" class="nav-link font-weight-bold">
        <i class="fas fa-user-alt"></i> My Profile
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/my-order" class="nav-link font-weight-bold">
        <i class="fas fa-shopping-bag"></i> My Orders
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/wishlist" class="nav-link font-weight-bold">
        <i class="fas fa-heart"></i> Wishlist
      </router-link>
    </li>
    <li class="nav-item">
      <router-link to="/user-change-password" class="nav-link font-weight-bold">
        <i class="fas fa-lock"></i> Change Password
      </router-link>
    </li>
    <li class="nav-item">
      <a href="#" @click.prevent="handleLogout" class="nav-link font-weight-bold">
        <i class="fas fa-sign-out-alt"></i> Logout
      </a>
      
    </li>
  </ul>
</template>

<script setup>
import { useRouter } from "vue-router";
import { useAuthStore } from "../../../stores/auth";

const authStore = useAuthStore();
const router = useRouter();

const handleLogout = () => {
  authStore.logout();
  router.push("/user-login"); // Redirect after logout
};
</script>

<style>
/* Add additional styling if needed */
</style>