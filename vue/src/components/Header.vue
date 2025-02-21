<template>
  <header class="header">
    <div v-if="isAuthenticated" class="user-info">
      <div class="dropdown" @click.stop="toggleDropdown">
        <img
          v-if="imageUrl"
          :src="imageUrl"
          alt="User Avatar"
          class="user-avatar"
        />
        <span class="username">{{ userInfo?.name }}</span>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          fill="currentColor"
          class="dropdown-icon"
        >
          <path
            fill-rule="evenodd"
            d="M12 14.5a1 1 0 0 0 .7-.3l3.5-3.5a1 1 0 0 0-1.4-1.4L12 12.1 9.2 9.3a1 1 0 0 0-1.4 1.4l3.5 3.5a1 1 0 0 0 .7.3Z"
            clip-rule="evenodd"
          />
        </svg>
        <ul v-if="isDropdownOpen" class="dropdown-menu">
          <li @click="goToProfile">Profile</li>
          <li @click="logout">Logout</li>
        </ul>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from "vue";
import { useAuthStore } from "@/stores/authStore";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const isAuthenticated = computed(() => authStore.isAuthenticated);
const userInfo = computed(() => authStore.userInfo);

const router = useRouter();
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
  isDropdownOpen.value = !isDropdownOpen.value;
};

const goToProfile = () => {
  router.push({ name: "Profile" });
  isDropdownOpen.value = false;
};

const logout = async () => {
  try {
    await authStore.logout();
    router.push({ name: "Login" });
    isDropdownOpen.value = false;
  } catch (error) {
    console.error("Logout failed:", error);
  }
};

const closeDropdown = (event: Event) => {
  const dropdownElement = document.querySelector(".dropdown");
  if (dropdownElement && !dropdownElement.contains(event.target as Node)) {
    isDropdownOpen.value = false;
  }
};

const imageUrl = computed(() => {
  if (authStore.userInfo?.image) {
    return `${import.meta.env.VITE_API_URL}/storage/${
      authStore.userInfo.image
    }`;
  }
  return null;
});

onMounted(() => {
  document.addEventListener("click", closeDropdown);
});

onUnmounted(() => {
  document.removeEventListener("click", closeDropdown);
});
</script>

<style scoped>
.header {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  padding: 14px 20px;
  background-color: white;
  border-bottom: 1px solid rgba(0, 0, 0, 0.1);
  width: 100%;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 15px;
  position: relative;
}

.dropdown {
  display: flex;
  align-items: center;
  gap: 5px;
  cursor: pointer;
  position: relative;
}

.dropdown-icon {
  width: 14px;
  height: 14px;
  transition: transform 0.3s ease;
  color: #000;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  right: 0;
  background: white;
  color: black;
  border-radius: 6px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  min-width: 120px;
  z-index: 10;
}

.dropdown-menu li {
  padding: 10px;
  cursor: pointer;
  font-size: 14px;
  transition: background 0.3s;
}

.dropdown-menu li:hover {
  background: #f0f0f0;
}

.logout-btn {
  display: none;
}

.user-avatar {
  width: 32px;
  height: 32px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 8px;
  border: 2px solid #ffffff;
}

.username {
  color: rgb(12, 9, 9);
}

.sidebar-header {
  display: flex;
  align-items: center;
  justify-content: center;
}

.logo {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 10px;
}

.title {
  font-size: 18px;
  font-weight: bold;
}
</style>
