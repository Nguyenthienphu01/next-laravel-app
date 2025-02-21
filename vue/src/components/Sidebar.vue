<template>
  <div class="sidebar-wrapper" :class="{ collapsed: !isSidebarOpen }">
    <div class="sidebar" :class="{ collapsed: !isSidebarOpen }">
      <div class="sidebar-header">
        <img src="/logo.png" alt="Logo" class="logo" />
        <span v-show="isSidebarOpen" class="title">Admin Panel</span>
      </div>
      <div v-if="!isSidebarOpen" class="ellipsis-separator">
        <span>• • •</span>
      </div>
      <div class="nav-container">
        <!-- Render each menu group -->
        <template
          v-for="(group, groupIndex) in menuGroups"
          :key="'group-' + groupIndex"
        >
          <!-- Menu items in the group -->
          <nav class="nav-section">
            <router-link
              v-for="item in group.items"
              :key="item.path"
              :to="item.path"
              class="nav-item"
              :class="{ active: route.path.includes(item.path) }"
            >
              <div class="icon-wrapper">
                <component :is="item.icon" class="w-5 h-5" />
              </div>
              <span v-show="isSidebarOpen" class="nav-text">{{
                item.name
              }}</span>
            </router-link>
          </nav>

          <!-- Add ellipsis separator between groups when collapsed (except after last group) -->
          <div
            v-if="!isSidebarOpen && groupIndex < menuGroups.length - 1"
            class="ellipsis-separator"
          >
            <span>• • •</span>
          </div>
        </template>
      </div>

      <button
        class="toggle-btn"
        :class="{ collapsed: !isSidebarOpen }"
        @click="toggleSidebar"
      >
        <ChevronLeft
          class="w-4 h-4"
          :class="{ 'rotate-180': !isSidebarOpen }"
        />
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import {
  Users,
  Package,
  Tags,
  BarChart,
  ChevronLeft,
  History,
  Settings,
  Grid,
  Calendar,
  User,
  Copy,
  FileText,
  MessageCircle,
  Mail,
  File,
  Clock,
  Box,
  Library,
} from "lucide-vue-next";

const route = useRoute();

// Reorganize menu items into groups
const menuGroups = [
  {
    items: [
      {
        name: "Library",
        path: "/library",
        icon: Library,
      },
    ],
  },
  {
    items: [
      // {
      //   name: "History",
      //   path: "/history",
      //   icon: History,
      // },
      {
        name: "Setting",
        path: "/setting",
        icon: Settings,
      },
    ],
  },
];

// Original menu items kept for reference
const originalMenuItems = [
  {
    name: "Library",
    path: "/library",
    icon: Library,
  },
  // {
  //   name: "History",
  //   path: "/history",
  //   icon: History,
  // },
  {
    name: "Setting",
    path: "/setting",
    icon: Settings,
  },
];

const isSidebarOpen = ref(false);

onMounted(() => {
  const savedState = localStorage.getItem("sidebarOpen");
  isSidebarOpen.value = savedState === "true";
});

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
  localStorage.setItem("sidebarOpen", isSidebarOpen.value);
};
</script>

<style scoped>
.sidebar-header {
  display: flex;
  align-items: center;
  padding: 14px 15px;
  background-color: white;
}

.logo {
  width: 32px;
  height: 32px;
  margin-left: 4px;
  margin-right: 12px;
}

.title {
  font-size: 20px;
  font-weight: 600;
  color: rgb(6, 6, 8);
  white-space: nowrap;
  opacity: 1;
  transition: opacity 0.3s ease;
}

.sidebar.collapsed .title {
  opacity: 0;
  width: 0;
}

.sidebar-wrapper {
  position: relative;
  height: 100vh;
  transition: all 0.3s ease;
}

.sidebar {
  width: 250px;
  height: 100%;
  background-color: white;
  transition: all 0.3s ease;
  position: relative;
  border-right: 1px solid rgba(0, 0, 0, 0.1);
}

.sidebar.collapsed {
  width: 70px;
}

.nav-container {
  display: flex;
  flex-direction: column;
  height: calc(100% - 60px);
  overflow-y: auto;
}

.nav-section {
  padding: 0px 10px;
  display: flex;
  flex-direction: column;
  gap: 8px;
  margin-bottom: 10px;
}

.nav-item {
  display: flex;
  align-items: center;
  padding: 12px 15px;
  color: rgb(71 85 105);
  text-decoration: none;
  border-radius: 8px;
  transition: all 0.3s ease;
  white-space: nowrap;
}

.icon-wrapper {
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-right: 12px;
}

.nav-text {
  font-size: 14px;
  opacity: 1;
  transition: opacity 0.3s ease;
}

.nav-item:hover {
  background-color: rgb(241 245 249);
  color: rgb(15 23 42);
  transform: translateX(5px);
}

.nav-item.active {
  background-color: rgb(239 246 255);
  color: rgb(37 99 235);
}

.ellipsis-separator {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 20px;
  color: rgb(148 163 184);
  font-size: 12px;
  margin: 5px 0;
}

.toggle-btn {
  position: absolute;
  top: 50%;
  right: -12px;
  width: 24px;
  height: 24px;
  background: white;
  border: 1px solid rgb(226 232 240);
  border-radius: 50%;
  color: rgb(148 163 184);
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transform: translateY(-50%);
  transition: all 0.3s ease;
  z-index: 10;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.toggle-btn:hover {
  color: rgb(51 65 85);
}

.rotate-180 {
  transform: rotate(180deg);
}

.collapsed .nav-text {
  opacity: 0;
  width: 0;
}
</style>
