<template>
  <div class="history-table">
    <div class="history-grid">
      <div
        v-for="activity in activities"
        :key="activity.id"
        class="history-card"
        :class="getModuleClass(activity.module)"
      >
        <div class="activity-header">
          <div class="module-info">
            <span
              class="module-icon"
              :class="getModuleIconClass(activity.module)"
            >
              <component :is="getModuleIcon(activity.module)" size="18" />
            </span>
            <span class="module-name">{{
              getModuleName(activity.module)
            }}</span>
          </div>
          <span class="activity-date">
            <Clock size="14" />
            {{ formatDate(activity.created_at) }}
          </span>
        </div>

        <div class="activity-content">
          <div class="action-info">
            <span class="action-badge" :class="getActionClass(activity.action)">
              <component :is="getActionIcon(activity.action)" size="14" />
              {{ getActionName(activity.action) }}
            </span>
            <span class="user-info">
              <span class="user-avatar">
                <User size="16" />
              </span>
              {{ activity.user?.name || "Admin" }}
            </span>
          </div>

          <div class="detail-info">
            <p class="activity-description">{{ activity.description }}</p>
            <div v-if="activity.changes" class="changes-detail">
              <div
                v-for="(change, field) in activity.changes"
                :key="field"
                class="change-item"
              >
                <span class="field-name">{{ formatFieldName(field) }}</span>
                <span class="old-value">{{ formatValue(change.old) }}</span>
                <span class="arrow">
                  <ArrowRight size="14" />
                </span>
                <span class="new-value">{{ formatValue(change.new) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div v-if="loading" class="loading-overlay">
      <div class="spinner"></div>
    </div>

    <div v-if="!loading && activities.length === 0" class="no-results">
      <FileSearch size="48" class="mb-4" />
      <p>Không tìm thấy hoạt động nào</p>
    </div>
  </div>
</template>

<script setup lang="ts">
import { defineProps } from "vue";
import {
  Package,
  ShoppingBag,
  Users,
  Folder,
  Settings,
  Clock,
  User,
  PlusCircle,
  Edit,
  Trash,
  LogIn,
  LogOut,
  ArrowRight,
  FileSearch,
} from "lucide-vue-next";

const props = defineProps({
  activities: {
    type: Array,
    required: true,
    default: () => [],
  },
  loading: {
    type: Boolean,
    default: false,
  },
});

const getModuleName = (module) => {
  const moduleMap = {
    order: "Đơn hàng",
    product: "Sản phẩm",
    account: "Tài khoản",
    category: "Danh mục",
    setting: "Cài đặt",
  };
  return moduleMap[module] || module;
};

const getActionName = (action) => {
  const actionMap = {
    create: "Tạo mới",
    update: "Cập nhật",
    delete: "Xóa",
    login: "Đăng nhập",
    logout: "Đăng xuất",
  };
  return actionMap[action] || action;
};

const getModuleIcon = (module) => {
  const iconMap = {
    order: ShoppingBag,
    product: Package,
    account: Users,
    category: Folder,
    setting: Settings,
  };
  return iconMap[module] || Package;
};

const getActionIcon = (action) => {
  const iconMap = {
    create: PlusCircle,
    update: Edit,
    delete: Trash,
    login: LogIn,
    logout: LogOut,
  };
  return iconMap[action] || Edit;
};

const getModuleClass = (module) => `module-${module}`;
const getModuleIconClass = (module) => `icon-${module}`;
const getActionClass = (action) => `action-${action}`;

const formatDate = (date) => {
  return new Date(date).toLocaleString("vi-VN", {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
};

const formatFieldName = (fieldName) => {
  // Convert camelCase or snake_case to Title Case with spaces
  return fieldName
    .replace(/_/g, " ")
    .replace(/([A-Z])/g, " $1")
    .replace(/^./, (str) => str.toUpperCase())
    .trim();
};

const formatValue = (value) => {
  if (value === null || value === undefined) return "—";
  if (typeof value === "boolean") return value ? "Có" : "Không";
  return value.toString();
};
</script>

<style scoped>
.history-table {
  position: relative;
}

.history-grid {
  display: flex;
  flex-direction: column;
  gap: 1.25rem;
}

.history-card {
  background-color: white;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  border-left: 4px solid transparent;
  position: relative;
  overflow: hidden;
}

.history-card::before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(
    to right,
    rgba(255, 255, 255, 0.02),
    rgba(255, 255, 255, 0.05)
  );
  opacity: 0;
  transition: opacity 0.3s ease;
}

.history-card:hover {
  transform: translateY(-3px);
  box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
}

.history-card:hover::before {
  opacity: 1;
}

.module-order {
  border-left-color: #4299e1;
}
.module-product {
  border-left-color: #10b981;
}
.module-account {
  border-left-color: #f59e0b;
}
.module-category {
  border-left-color: #8b5cf6;
}
.module-setting {
  border-left-color: #64748b;
}

.activity-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.25rem;
}

.module-info {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.module-icon {
  width: 36px;
  height: 36px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
}

.icon-order {
  background-color: #e0f2fe;
  color: #0284c7;
}
.icon-product {
  background-color: #ecfdf5;
  color: #059669;
}
.icon-account {
  background-color: #fef3c7;
  color: #d97706;
}
.icon-category {
  background-color: #f3e8ff;
  color: #7c3aed;
}
.icon-setting {
  background-color: #f1f5f9;
  color: #475569;
}

.module-name {
  font-weight: 600;
  font-size: 1.05rem;
  color: #334155;
}

.activity-date {
  color: #64748b;
  font-size: 0.875rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.action-info {
  display: flex;
  align-items: center;
  gap: 1.25rem;
  margin-bottom: 1.25rem;
}

.action-badge {
  padding: 0.35rem 0.85rem;
  border-radius: 20px;
  font-size: 0.875rem;
  font-weight: 500;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.action-create {
  background-color: #ecfdf5;
  color: #059669;
}
.action-update {
  background-color: #e0f2fe;
  color: #0284c7;
}
.action-delete {
  background-color: #fee2e2;
  color: #e11d48;
}
.action-login {
  background-color: #f1f5f9;
  color: #475569;
}
.action-logout {
  background-color: #f1f5f9;
  color: #475569;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #475569;
  font-size: 0.925rem;
}

.user-avatar {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background-color: #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #64748b;
}

.detail-info {
  margin-top: 1rem;
  padding-top: 1rem;
  border-top: 1px solid #e2e8f0;
}

.activity-description {
  color: #334155;
  margin: 0 0 1.25rem 0;
  line-height: 1.5;
}

.changes-detail {
  background-color: #f8fafc;
  border-radius: 8px;
  padding: 1.25rem;
  border: 1px solid #e2e8f0;
}

.change-item {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 0.75rem;
  font-size: 0.875rem;
  line-height: 1.5;
}

.change-item:last-child {
  margin-bottom: 0;
}

.field-name {
  color: #64748b;
  font-weight: 600;
  min-width: 100px;
}

.old-value {
  color: #dc2626;
  background-color: rgba(254, 226, 226, 0.4);
  padding: 0.15rem 0.5rem;
  border-radius: 4px;
  max-width: 100%;
  word-break: break-word;
}

.arrow {
  color: #64748b;
  display: flex;
  align-items: center;
}

.new-value {
  color: #16a34a;
  background-color: rgba(236, 253, 245, 0.4);
  padding: 0.15rem 0.5rem;
  border-radius: 4px;
  max-width: 100%;
  word-break: break-word;
}

.loading-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(255, 255, 255, 0.92);
  display: flex;
  justify-content: center;
  align-items: center;
  backdrop-filter: blur(2px);
  z-index: 50;
}

.spinner {
  width: 40px;
  height: 40px;
  border: 3px solid #e2e8f0;
  border-top-color: #4299e1;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

.no-results {
  text-align: center;
  padding: 4rem 2rem;
  color: #64748b;
  font-size: 1.1rem;
  background-color: white;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

/* Responsive Design */
@media (max-width: 768px) {
  .activity-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.75rem;
  }

  .activity-date {
    margin-left: 0.5rem;
  }

  .action-info {
    flex-wrap: wrap;
  }

  .change-item {
    flex-direction: column;
    gap: 0.5rem;
  }

  .arrow {
    transform: rotate(90deg);
    margin: 0.5rem 0;
  }
}
</style>
