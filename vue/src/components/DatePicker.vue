<template>
  <div class="date-picker-container">
    <div class="date-input-wrapper" @click="toggleCalendar">
      <input
        type="text"
        :value="formattedDate"
        readonly
        class="date-input"
        :placeholder="placeholder"
      />
      <span class="calendar-icon">
        <Calendar size="18" />
      </span>
    </div>

    <div v-if="showCalendar" class="calendar-dropdown">
      <div class="calendar-header">
        <button @click="prevMonth" class="month-nav-btn">
          <ChevronLeft size="18" />
        </button>
        <span class="current-month">{{ monthYearText }}</span>
        <button @click="nextMonth" class="month-nav-btn">
          <ChevronRight size="18" />
        </button>
      </div>

      <div class="weekdays">
        <span v-for="day in weekDays" :key="day">{{ day }}</span>
      </div>

      <div class="calendar-days">
        <button
          v-for="{ date, current, today } in calendarDays"
          :key="date.toISOString()"
          :class="[
            'day-btn',
            {
              'other-month': !current,
              today: today,
              selected: isSelectedDate(date),
            },
          ]"
          @click="selectDate(date)"
        >
          {{ date.getDate() }}
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from "vue";
import { Calendar, ChevronLeft, ChevronRight } from "lucide-vue-next";

const props = defineProps({
  modelValue: {
    type: String,
    default: "",
  },
  placeholder: {
    type: String,
    default: "Select date",
  },
});

const emit = defineEmits(["update:modelValue"]);

const showCalendar = ref(false);
const currentMonth = ref(new Date());
const selectedDate = ref(props.modelValue ? new Date(props.modelValue) : null);

// Watch for external changes to modelValue
watch(
  () => props.modelValue,
  (newValue) => {
    if (newValue) {
      selectedDate.value = new Date(newValue);
    } else {
      selectedDate.value = null;
    }
  }
);

const weekDays = ["CN", "T2", "T3", "T4", "T5", "T6", "T7"];

const monthYearText = computed(() => {
  return currentMonth.value.toLocaleDateString("vi-VN", {
    month: "long",
    year: "numeric",
  });
});

const formattedDate = computed(() => {
  if (!selectedDate.value) return "";
  return selectedDate.value.toLocaleDateString("vi-VN", {
    day: "2-digit",
    month: "2-digit",
    year: "numeric",
  });
});

const calendarDays = computed(() => {
  const year = currentMonth.value.getFullYear();
  const month = currentMonth.value.getMonth();

  // First day of current month
  const firstDay = new Date(year, month, 1);
  // Last day of current month
  const lastDay = new Date(year, month + 1, 0);

  // Get the day of week for the first day (0 = Sunday, 6 = Saturday)
  const firstDayOfWeek = firstDay.getDay();

  // Calculate days from previous month to show
  const daysFromPrevMonth = firstDayOfWeek;

  // Get the date of the first displayed day
  const firstDisplayedDate = new Date(year, month, 1 - daysFromPrevMonth);

  // Calculate total days to display (6 weeks)
  const totalDays = 42;

  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const days = [];
  for (let i = 0; i < totalDays; i++) {
    const date = new Date(firstDisplayedDate);
    date.setDate(firstDisplayedDate.getDate() + i);

    days.push({
      date,
      current: date.getMonth() === month,
      today: date.getTime() === today.getTime(),
    });
  }

  return days;
});

const toggleCalendar = () => {
  showCalendar.value = !showCalendar.value;
};

const prevMonth = () => {
  currentMonth.value = new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth() - 1,
    1
  );
};

const nextMonth = () => {
  currentMonth.value = new Date(
    currentMonth.value.getFullYear(),
    currentMonth.value.getMonth() + 1,
    1
  );
};

const selectDate = (date) => {
  selectedDate.value = new Date(date);
  emit("update:modelValue", formatDateForModel(date));
  showCalendar.value = false;
};

const isSelectedDate = (date) => {
  if (!selectedDate.value) return false;

  return (
    date.getDate() === selectedDate.value.getDate() &&
    date.getMonth() === selectedDate.value.getMonth() &&
    date.getFullYear() === selectedDate.value.getFullYear()
  );
};

const formatDateForModel = (date) => {
  const year = date.getFullYear();
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const day = String(date.getDate()).padStart(2, "0");
  return `${year}-${month}-${day}`;
};

// Close calendar when clicking outside
const handleClickOutside = (event) => {
  const container = event.target.closest(".date-picker-container");
  if (!container && showCalendar.value) {
    showCalendar.value = false;
  }
};

onMounted(() => {
  document.addEventListener("click", handleClickOutside);

  // Initialize with current date if not provided
  if (props.modelValue) {
    currentMonth.value = new Date(props.modelValue);
  }
});

onUnmounted(() => {
  document.removeEventListener("click", handleClickOutside);
});
</script>

<style scoped>
.date-picker-container {
  position: relative;
  width: 100%;
}

.date-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
  cursor: pointer;
}

.date-input {
  width: 100%;
  padding: 0.65rem 0.8rem;
  padding-right: 35px; /* Make space for icon */
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  background-color: white;
  transition: all 0.2s ease;
  cursor: pointer;
}

.calendar-icon {
  position: absolute;
  right: 10px;
  top: 50%;
  transform: translateY(-50%);
  color: #718096;
  pointer-events: none;
  display: flex;
  align-items: center;
  justify-content: center;
}

.date-input:focus {
  outline: none;
  border-color: #4299e1;
  box-shadow: 0 0 0 2px rgba(66, 153, 225, 0.2);
}

.calendar-dropdown {
  position: absolute;
  top: calc(100% + 5px);
  left: 0;
  width: 280px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  z-index: 10;
  overflow: hidden;
  padding: 1rem;
  border: 1px solid #e2e8f0;
}

.calendar-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.month-nav-btn {
  background: transparent;
  border: none;
  color: #4a5568;
  cursor: pointer;
  padding: 5px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.month-nav-btn:hover {
  background-color: #f7fafc;
  color: #2d3748;
}

.current-month {
  font-weight: 500;
  color: #2d3748;
  font-size: 0.95rem;
  text-transform: capitalize;
}

.weekdays {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  margin-bottom: 0.5rem;
}

.weekdays span {
  text-align: center;
  font-size: 0.75rem;
  color: #718096;
  font-weight: 500;
  padding: 0.5rem 0;
}

.calendar-days {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
  gap: 2px;
}

.day-btn {
  background: transparent;
  border: none;
  height: 32px;
  width: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  cursor: pointer;
  font-size: 0.875rem;
  color: #2d3748;
  margin: 2px auto;
}

.day-btn:hover:not(.other-month) {
  background-color: #ebf8ff;
}

.other-month {
  color: #cbd5e0;
}

.today {
  font-weight: bold;
  color: #4299e1;
}

.selected {
  background-color: #4299e1 !important;
  color: white !important;
}
</style>
