<template>
  <div class="search-input-wrapper">
    <input
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
      type="text"
      :placeholder="placeholder"
      class="search-input"
    />
    <Search class="search-icon" :style="{ width: '18px', height: '18px' }" />
  </div>
</template>

<script setup>
import { Search } from "lucide-vue-next";

defineProps({
  modelValue: {
    type: String,
    default: "",
  },
  placeholder: {
    type: String,
    default: "Search...",
  },
});

defineEmits(["update:modelValue"]);
</script>

<style scoped>
.search-input-wrapper {
  position: relative;
  width: 100%;
}

.search-icon {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: #9ca3af;
}

.search-input {
  width: 100%;
  padding: 11px 24px 10px 16px;
  border: 1px solid #e5e7eb;
  border-radius: 6px;
  outline: none;
  transition: all 0.3s;
}

.search-input:focus {
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
}
</style>
