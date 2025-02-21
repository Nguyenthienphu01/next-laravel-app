<!-- components/Alert.vue -->
<template>
  <transition name="fade">
    <div v-if="show" :class="['alert', `alert-${type}`]">
      <div class="alert-content">
        <span class="alert-message">{{ message }}</span>
        <button v-if="dismissible" @click="handleDismiss" class="alert-close">
          ×
        </button>
      </div>
    </div>
  </transition>
</template>

<script lang="ts" setup>
import { defineProps, defineEmits, watch, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  show: {
    type: Boolean,
    default: false
  },
  message: {
    type: String,
    required: true
  },
  type: {
    type: String,
    default: 'info',
    validator: (value: string) => ['success', 'error', 'info', 'warning'].includes(value)
  },
  dismissible: {
    type: Boolean,
    default: true
  },
  duration: {
    type: Number,
    default: 3000 // 3 seconds
  }
});

const emit = defineEmits(['update:show']);

const handleDismiss = () => {
  emit('update:show', false);
};

let timer: ReturnType<typeof setTimeout> | null = null;

watch(() => props.show, (newVal) => {
  if (newVal && props.duration > 0) {
    timer = setTimeout(() => {
      emit('update:show', false);
    }, props.duration);
  }
});

onUnmounted(() => {
  if (timer) {
    clearTimeout(timer);
  }
});
</script>

<style scoped>
.alert {
  position: fixed;
  top: 20px;
  right: 20px;
  padding: 1rem;
  border-radius: 4px;
  min-width: 300px;
  z-index: 1000;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.alert-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.alert-error {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}

.alert-info {
  background-color: #cce5ff;
  color: #004085;
  border: 1px solid #b8daff;
}

.alert-warning {
  background-color: #fff3cd;
  color: #856404;
  border: 1px solid #ffeeba;
}

.alert-close {
  background: none;
  border: none;
  font-size: 1.5rem;
  line-height: 1;
  padding: 0 0.5rem;
  cursor: pointer;
  opacity: 0.5;
}

.alert-close:hover {
  opacity: 1;
}

/* Transition animations */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease, transform 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
</style> 