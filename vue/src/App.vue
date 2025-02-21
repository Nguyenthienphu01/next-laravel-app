<template>
  <div class="app-container">
    <router-view />
  </div>
</template>

<script>
export default {
  name: "App",
};
</script>

<style>
.app-container {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
}

.content {
  flex-grow: 1;
  padding: 20px;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
</style>
