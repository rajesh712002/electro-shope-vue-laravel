<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <button @click="toggleSidebar" class="nav-link"><i class="fas fa-bars"></i></button>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <button @click="toggleFullscreen" class="nav-link">
                    <i class="fas fa-expand-arrows-alt"></i>
                </button>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link p-0 pr-3" data-toggle="dropdown">
                    <!-- <img src="/admin_assets/img/avatar5.png" class="img-circle elevation-2" width="40" height="40" /> -->

                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
                    <h4 class="h4 mb-0"><strong>{{ adminUser.name }}</strong></h4>
                    <div class="mb-3">{{ adminUser.email }}</div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user-cog mr-2"></i> Settings
                    </a>
                    <a href="/admin/change-password" class="dropdown-item">
                        <i class="fas fa-lock mr-2"></i> Change Password
                    </a>
                    <a @click="logout" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>
            </li>
        </ul>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            adminUser: {
                name: "Admin",
                email: "admin@example.com",
            },
        };
    },
    methods: {
        toggleSidebar() {
            document.body.classList.toggle("sidebar-collapse");
        },
        toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
            } else if (document.exitFullscreen) {
                document.exitFullscreen();
            }
        },
        logout() {
            axios.post("/admin/logout").then(() => {
                window.location.href = "/admin/login";
            });
        },
    },
};
</script>
