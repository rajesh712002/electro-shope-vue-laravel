<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav ml-auto">
            <!-- Fullscreen Toggle -->
            <li class="nav-item">
                <button @click="toggleFullscreen" class="nav-link">
                    <i class="fas fa-expand-arrows-alt"></i>
                </button>
            </li>

            <!-- Dropdown for Admin Profile -->
            <li class="nav-item dropdown" ref="dropdownMenu">
                <a @click.prevent="toggleDropdown" class="nav-link p-0 pr-3">
                    <img :src="getAdminAvatar()" class="img-circle elevation-2" width="40" height="40" alt="Admin Avatar" />
                </a>
                <div v-show="isDropdownOpen" class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
                    <h4 class="h4 mb-0"><strong>{{ adminUser.name }}</strong></h4>
                    <div class="mb-3">{{ adminUser.email }}</div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-cog mr-2"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <router-link to="#" class="dropdown-item">
                        <i class="fas fa-lock mr-2"></i> Change Password
                    </router-link>
                    <div class="dropdown-divider"></div>
                    <a @click="logout" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
import { ref, onMounted, onUnmounted } from "vue";
import axios from "axios";

export default {
    setup() {
        const adminUser = ref({
            name: "Admin",
            email: "admin@example.com",
        });

        const isDropdownOpen = ref(false);
        const dropdownMenu = ref(null);

        // Fetch Admin Data from API
        const fetchAdminUser = async () => {
            try {
                const response = await axios.get("/api/admin/user"); // Update API URL accordingly
                adminUser.value = response.data;
            } catch (error) {
                console.error("Error fetching admin user:", error);
            }
        };

        // Toggle Fullscreen Mode
        const toggleFullscreen = () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        };

        // Toggle Dropdown Menu
        const toggleDropdown = (event) => {
            isDropdownOpen.value = !isDropdownOpen.value;
            event.stopPropagation();
        };

        // Close Dropdown When Clicking Outside
        const closeDropdown = (event) => {
            if (dropdownMenu.value && !dropdownMenu.value.contains(event.target)) {
                isDropdownOpen.value = false;
            }
        };

        // Logout Admin
        const logout = async () => {
            try {
                await axios.post("/api/admin/logout"); // Update API route accordingly
                window.location.href = "/admin/login";
            } catch (error) {
                console.error("Logout failed:", error);
            }
        };

        // Get Admin Avatar
        const getAdminAvatar = () => {
            return "/admin_assets/img/avatar5.png"; // Update dynamically if needed
        };

        // Fetch Admin User on Component Mount
        onMounted(() => {
            fetchAdminUser();
            document.addEventListener("click", closeDropdown);
        });

        onUnmounted(() => {
            document.removeEventListener("click", closeDropdown);
        });

        return {
            adminUser,
            isDropdownOpen,
            toggleFullscreen,
            toggleDropdown,
            logout,
            getAdminAvatar,
            dropdownMenu,
        };
    },
};
</script>
