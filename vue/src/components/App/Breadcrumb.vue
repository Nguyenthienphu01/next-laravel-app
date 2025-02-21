<!-- Breadcrumb.vue -->
<template>
  <nav class="breadcrumb" aria-label="breadcrumb">
    <ol class="items-center">
      <li
        v-for="(item, index) in currentBreadcrumbs"
        :key="item.path"
        class="flex items-center last:font-normal"
      >
        <router-link
          :to="item.path"
          :class="{ 'current-page': route.path === item.path }"
        >
          {{ item.label }}
        </router-link>
        <span
          v-if="index < currentBreadcrumbs.length - 1"
          class="mx-1 text-gray-400"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="size-6"
            width="12"
          >
            <path
              fill-rule="evenodd"
              d="M16.28 11.47a.75.75 0 0 1 0 1.06l-7.5 7.5a.75.75 0 0 1-1.06-1.06L14.69 12 7.72 5.03a.75.75 0 0 1 1.06-1.06l7.5 7.5Z"
              clip-rule="evenodd"
            />
          </svg>
        </span>
      </li>
    </ol>
  </nav>
</template>

<script setup>
import { computed } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();

const homeItem = { label: "Home", path: "/" };

const routeBreadcrumbMap = {
  "/": [homeItem],
  // account
  "/account-management": [
    homeItem,
    { label: "Account Management", path: "/account-management" },
  ],
  "/account-management/create-account": [
    homeItem,
    { label: "Account Management", path: "/account-management" },
    { label: "Create Account", path: "/account-management/create-account" },
  ],

  // product
  "/product-management": [
    homeItem,
    { label: "Product Management", path: "/product-management" },
  ],
  "/product-management/create-product": [
    homeItem,
    { label: "Product Management", path: "/product-management" },
    { label: "Create Product", path: "/product-management/create-product" },
  ],
};

const currentBreadcrumbs = computed(() => {
  if (route.path.includes("/product-management/edit-product/")) {
    return [
      homeItem,
      { label: "Product Management", path: "/product-management" },
      { label: "Edit Product", path: route.path }, 
    ];
  }

  if (routeBreadcrumbMap[route.path]) {
    return routeBreadcrumbMap[route.path];
  }

  const pathSegments = route.path.split("/").filter(Boolean);

  if (pathSegments.length === 0) return [homeItem];

  let breadcrumbs = [homeItem];
  let currentPath = "";

  pathSegments.forEach((segment, i) => {
    currentPath += "/" + segment;

    if (routeBreadcrumbMap["/" + segment]) {
      breadcrumbs.push({
        label: routeBreadcrumbMap["/" + segment][1]["label"],
        path: currentPath,
      });
    }
  });

  return breadcrumbs;
});
</script>

<style scoped>
.breadcrumb ol {
  list-style: none;
  margin: 0;
  padding: 0;
}

.breadcrumb a {
  color: black;
  text-decoration: none;
  font-size: 16px;
  line-height: 1.5;
}

.breadcrumb span {
  margin: 2px 6px;
  color: rgba(0, 0, 0, 0.45);
}

.current-page {
  color: rgb(37 99 235) !important;
}

.items-center {
  display: flex;
}
</style>
