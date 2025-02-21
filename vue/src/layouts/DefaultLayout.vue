<!-- layouts/DefaultLayout.vue -->
<template>
  <div class="layout">
    <Sidebar />
    <div class="content-wrapper">
      <Header />
      <!-- <div class="breadcrumb-container">
        <Breadcrumb />
      </div> -->
      <div class="main-content">
        <router-view />
      </div>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { computed } from 'vue';
import { useRoute } from 'vue-router';
import Sidebar from "@/components/Sidebar.vue";
import Header from "@/components/Header.vue";
import Breadcrumb from "@/components/App/Breadcrumb.vue";

const route = useRoute();
</script>

<style scoped>
.layout {
  display: flex;
  min-height: 100vh;
}

.content-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.breadcrumb-container {
  padding: 0.5rem;
  background-color: white;
  margin-left: 8px;
}

.main-content {
  flex: 1;
}
</style>