<template>
    <div :class="['d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar', { 'sidebar-narrow': isNarrow }]" :style="sidebarStyle">
        <div class="d-flex align-items-center justify-content-between">
            <a href="/" class="d-flex align-items-center text-white text-decoration-none">
                <span class="fs-4" v-if="!isNarrow">Digiance</span>
            </a>
            <button @click="toggleSidebar" class="btn btn-outline-light">
                <i class="bi bi-layout-sidebar-inset"></i>
            </button>
        </div>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link" :class="{ active: isActive('/dashboard') }" title="Dashboard">
                    <i class="bi bi-speedometer2"></i>
                    <span v-if="!isNarrow" class="ms-2">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="/posts" class="nav-link" :class="{ active: isActive('/posts') }" title="Posts">
                    <i class="bi bi-newspaper"></i>
                    <span v-if="!isNarrow" class="ms-2">Posts</span>
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong v-if="!isNarrow">mdo</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">New project...</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isNarrow: window.innerWidth < 767, // Automatically narrow on mobile
        };
    },
    computed: {
        sidebarStyle() {
            return this.isNarrow ? { width: '80px' } : { width: '280px' };
        }
    },
    methods: {
        toggleSidebar() {
            this.isNarrow = !this.isNarrow;
        },
        isActive(path) {
            return window.location.pathname === path; // Compare current path with provided path
        }
    }
}
</script>

<style>
    .sidebar-narrow {
        transition: width 0.3s ease;
    }
</style>
