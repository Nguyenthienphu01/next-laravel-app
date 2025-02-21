<template>
  <div class="history-container">
    <h1 class="title">System History</h1>
    <div class="header">
      <div class="filter-section">
        <div class="date-range">
          <SelectBox
            v-model="filters.module"
            :options="MODULE_OPTIONS"
            placeholder="Tất cả hoạt động"
          />
          <SelectBox
            v-model="filters.action"
            :options="ACTION_OPTIONS"
            placeholder="Tất cả hành động"
          />
          <DatePicker v-model="filters.dateFrom" placeholder="Từ ngày" />
          <DatePicker v-model="filters.dateTo" placeholder="Đến ngày" />
        </div>
      </div>
      <div class="filter-search">
        <SearchInput
          v-model="filters.search"
          placeholder="Search..."
          @update:modelValue="debounceSearch"
        />
      </div>
    </div>

    <HistoryTable :activities="activities" :loading="loading" />
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, watch, onMounted } from "vue";
import HistoryService from "@/services/System/HistoryService";

import SelectBox from "@/components/SelectBox.vue";
import DatePicker from "@/components/DatePicker.vue";
import SearchInput from "@/components/SearchInput.vue";
import HistoryTable from "@/components/HistoryTable.vue";
import { MODULE_OPTIONS, ACTION_OPTIONS } from "@/constants/System/index";

const activities = ref([]);
const pagination = ref(null);
const loading = ref(false);
const filters = reactive({
  module: "",
  action: "",
  dateFrom: "",
  dateTo: "",
  search: "",
  page: 1,
  per_page: 10,
});

// Debounce search function
let searchTimeout;
const debounceSearch = () => {
  clearTimeout(searchTimeout);
  searchTimeout = setTimeout(() => {
    filters.page = 1; // Reset to first page when searching
    fetchActivities();
  }, 500);
};

const fetchActivities = async () => {
  try {
    loading.value = true;
    const response = await HistoryService.getHistory(filters);

    activities.value = response.data.data;
    pagination.value = {
      current_page: response.data.data.current_page,
      from: response.data.data.from,
      to: response.data.data.to,
      total: response.data.data.total,
      last_page: response.data.data.last_page,
    };
  } catch (error) {
    console.error("Error fetching activities:", error);
    activities.value = [];
  } finally {
    loading.value = false;
  }
};

// Watch for filter changes
watch(
  () => ({
    module: filters.module,
    action: filters.action,
    dateFrom: filters.dateFrom,
    dateTo: filters.dateTo,
  }),
  () => {
    filters.page = 1; // Reset to first page when filters change
    fetchActivities();
  },
  { deep: true }
);

const changePage = (page) => {
  filters.page = page;
  fetchActivities();
};

onMounted(fetchActivities);
</script>

<style scoped>
.history-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 1rem;
  position: relative;
  background-color: #f8fafc;
  min-height: 100vh;
}

.header {
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
  background-color: white;
  padding: 1.5rem 2rem;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

.title {
  font-size: 1.75rem;
  color: #1e293b;
  font-weight: 600;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid #e2e8f0;
  margin-bottom: 1.5rem;
}

.filter-section {
  display: flex;
  gap: 1rem;
  align-items: center;
  margin-bottom: 1rem;
}

.date-range {
  display: flex;
  gap: 0.5rem;
  width: 100%;
}

.filter-search {
  width: 50%;
}

/* Responsive Design */
@media (max-width: 768px) {
  .header {
    flex-direction: column;
    gap: 1.5rem;
    padding: 1.25rem;
  }

  .filter-section {
    width: 100%;
    flex-wrap: wrap;
    justify-content: space-between;
  }

  .filter-section > * {
    flex: 1 1 45%;
    min-width: 140px;
  }
}

@media (max-width: 480px) {
  .history-container {
    padding: 1rem;
  }

  .filter-section > * {
    flex: 1 1 100%;
  }
}
</style>
