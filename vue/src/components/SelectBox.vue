<template>
  <div class="custom-select" @keydown="handleKeyDown" @blur="handleBlur">
    <label v-if="label" :for="id" class="select-label">{{ label }}</label>
    <div
      :id="id"
      class="select-value"
      tabindex="0"
      role="combobox"
      :aria-expanded="isOpen"
      :aria-controls="`${id}-listbox`"
      :aria-labelledby="label ? `${id}-label` : undefined"
      @click="toggleDropdown"
      ref="selectRef"
    >
      <span :class="{ placeholder: !selectedOption }">
        {{ selectedOption?.label || placeholder }}
      </span>
      <span :class="['icon', isOpen ? 'rotate' : '']">
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="size-6"
          width="16"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="m19.5 8.25-7.5 7.5-7.5-7.5"
          />
        </svg>
      </span>
    </div>

    <div
      v-if="isOpen"
      class="select-options"
      :id="`${id}-listbox`"
      role="listbox"
      ref="optionsRef"
    >
      <div
        v-for="(option, index) in options"
        :key="option.value"
        class="select-option"
        :class="{
          selected: option.value === modelValue,
          focused: focusedIndex === index,
        }"
        role="option"
        :aria-selected="option.value === modelValue"
        @click="selectOption(option)"
        @mouseover="focusedIndex = index"
      >
        {{ option.label }}
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted } from "vue";

const props = defineProps({
  modelValue: {
    type: [String, Number],
    required: true,
  },
  options: {
    type: Array,
    required: true,
  },
  placeholder: {
    type: String,
    default: "Select value",
  },
  label: {
    type: String,
    default: "",
  },
  id: {
    type: String,
    default: () => `select-${Math.random().toString(36).substr(2, 9)}`,
  },
});

const emit = defineEmits(["update:modelValue", "change"]);

const isOpen = ref(false);
const focusedIndex = ref(-1);
const selectRef = ref(null);
const optionsRef = ref(null);

const selectedOption = ref(
  props.options.find((option) => option.value === props.modelValue)
);

watch(
  () => props.modelValue,
  (newValue) => {
    selectedOption.value = props.options.find(
      (option) => option.value === newValue
    );
  }
);

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
  if (isOpen.value) {
    focusedIndex.value = props.options.findIndex(
      (option) => option.value === props.modelValue
    );
  }
};

const selectOption = (option) => {
  selectedOption.value = option;
  isOpen.value = false;
  emit("update:modelValue", option.value);
  emit("change", option.value);
  selectRef.value?.focus();
};

const handleKeyDown = (e) => {
  if (
    !isOpen.value &&
    (e.key === "Enter" || e.key === " " || e.key === "ArrowDown")
  ) {
    e.preventDefault();
    isOpen.value = true;
    return;
  }

  if (isOpen.value) {
    switch (e.key) {
      case "Escape":
        isOpen.value = false;
        selectRef.value?.focus();
        break;
      case "ArrowDown":
        e.preventDefault();
        focusedIndex.value = Math.min(
          focusedIndex.value + 1,
          props.options.length - 1
        );
        scrollToFocused();
        break;
      case "ArrowUp":
        e.preventDefault();
        focusedIndex.value = Math.max(focusedIndex.value - 1, 0);
        scrollToFocused();
        break;
      case "Enter":
        e.preventDefault();
        if (focusedIndex.value >= 0) {
          selectOption(props.options[focusedIndex.value]);
        }
        break;
    }
  }
};

const scrollToFocused = () => {
  if (optionsRef.value) {
    const focusedElement = optionsRef.value.children[focusedIndex.value];
    if (focusedElement) {
      focusedElement.scrollIntoView({ block: "nearest" });
    }
  }
};

const handleBlur = (e) => {
  // Check if the related target is inside the select component
  if (!e.currentTarget.contains(e.relatedTarget)) {
    isOpen.value = false;
    focusedIndex.value = -1;
  }
};

// Close dropdown when clicking outside
const handleClickOutside = (e) => {
  if (selectRef.value && !selectRef.value.contains(e.target)) {
    isOpen.value = false;
    focusedIndex.value = -1;
  }
};

onMounted(() => {
  document.addEventListener("click", handleClickOutside);
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>

<style scoped>
.custom-select {
  position: relative;
  width: 100%;
  font-size: 14px;
  color: #333;
}

.select-label {
  display: block;
  margin-bottom: 6px;
  font-weight: 500;
}

.select-value {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.25rem 13px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  background-color: white;
  cursor: pointer;
  min-height: 38px;
  outline: none;
  width: 100%;
}

.select-value span:first-child {
  flex: 1;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  margin-right: 8px;
}

.icon {
  flex-shrink: 0;
}

.placeholder {
  color: #718096;
}

.select-value:focus {
  border-color: #2196f3;
  box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.1);
}

.select-value .icon {
  transition: transform 0.3s;
  color: #999;
}

.select-value .icon.rotate {
  transform: rotate(180deg);
}

.select-options {
  position: absolute;
  top: 100%;
  left: 0;
  width: 100%;
  max-height: 200px;
  overflow-y: auto;
  border: 1px solid #e0e0e0;
  border-radius: 4px;
  background-color: white;
  z-index: 100;
  margin-top: 4px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.select-option {
  padding: 8px 12px;
  cursor: pointer;
}

.select-option:hover {
  background-color: #f5f5f5;
}

.select-option.selected {
  background-color: #e3f2fd;
  color: #1976d2;
}

.select-option.focused {
  background-color: #f5f5f5;
}

.size-6 {
  margin-top: 4px;
}
</style>
