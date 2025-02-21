<template>
  <div class="profile-form">
    <h2>Profile</h2>
    <form>
      <div class="form-group">
        <label>User name</label>
        <input type="text" id="name" v-model="name" placeholder="User name" />
        <span class="icon">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="size-6"
            width="24"
          >
            <path
              fill-rule="evenodd"
              d="M18.685 19.097A9.723 9.723 0 0 0 21.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 0 0 3.065 7.097A9.716 9.716 0 0 0 12 21.75a9.716 9.716 0 0 0 6.685-2.653Zm-12.54-1.285A7.486 7.486 0 0 1 12 15a7.486 7.486 0 0 1 5.855 2.812A8.224 8.224 0 0 1 12 20.25a8.224 8.224 0 0 1-5.855-2.438ZM15.75 9a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"
              clip-rule="evenodd"
            />
          </svg>
        </span>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" id="email" v-model="email" placeholder="Email" />
        <span class="icon">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="size-6"
            width="20"
          >
            <path
              d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z"
            />
            <path
              d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z"
            />
          </svg>
        </span>
      </div>
      <div class="form-group">
        <label>Phone</label>
        <input type="text" id="phone" v-model="phone" placeholder="Phone" />
        <span class="icon">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="size-6"
            width="20"
          >
            <path
              fill-rule="evenodd"
              d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z"
              clip-rule="evenodd"
            />
          </svg>
        </span>
      </div>
      <div class="form-group">
        <label>Role</label>
        <SelectBox v-model="selectedRole" :options="roleOptions" />
      </div>
      <div class="upload-section">
        <label>Upload Profile</label>
        <div class="file-input">
          <input
            type="file"
            id="profilePicture"
            @change="onFileChange"
            accept="image/png, image/jpeg"
          />
          <span class="file-name">{{ fileName || "No file chosen" }}</span>
        </div>
        <div class="profile-preview" v-if="imageUrl">
          <img :src="imageUrl" alt="Profile Image" class="profile-picture" />
        </div>
      </div>
      <button
        type="submit"
        class="update-btn"
        @click="handleSubmit"
        :disabled="!hasChanges"
      >
        Update Profile
      </button>
    </form>
  
    <Alert
      v-model:show="alert.show"
      :message="alert.message"
      :type="alert.type"
      :duration="3000"
    />
  </div>
</template>

<script lang="ts" setup>
import { onMounted, ref, computed, reactive, watch } from "vue";
import { useRouter } from "vue-router";
import { useRoute } from "vue-router";
import { useAuthStore } from "@/stores/authStore";
import AccountService from "@/services/AccountService";
import Alert from "@/components/Alert.vue";
import SelectBox from "@/components/SelectBox.vue";

const route = useRoute();
const router = useRouter();

const authStore = useAuthStore();
const fileName = ref("");

const name = ref(authStore.userInfo?.name);
const email = ref(authStore.userInfo?.email);
const phone = ref(authStore.userInfo?.phone);
const selectedRole = ref(authStore.userInfo?.role);
const uploadedImage = ref(null);

const roleOptions = [
  { value: "1", label: "Super Admin" },
  { value: "2", label: "User" },
];

const alert = reactive({
  show: false,
  message: "",
  type: "info",
});

const showAlert = (
  message: string,
  type: "success" | "error" | "info" | "warning"
) => {
  alert.show = true;
  alert.message = message;
  alert.type = type;
};

const imageUrl = computed(() => {
  if (uploadedImage.value) {
    return uploadedImage.value;
  } else if (authStore.userInfo?.image) {
    return `${import.meta.env.VITE_API_URL}/storage/${
      authStore.userInfo.image
    }`;
  }
  return null;
});

const onFileChange = (e: Event) => {
  const target = e.target as HTMLInputElement;
  if (target.files?.[0]) {
    const file = target.files[0];
    fileName.value = file.name;
    uploadedImage.value = URL.createObjectURL(file);
  }
};

const hasChanges = computed(() => {
  return (
    name.value !== authStore.userInfo?.name ||
    email.value !== authStore.userInfo?.email ||
    phone.value !== authStore.userInfo?.phone ||
    selectedRole.value !== authStore.userInfo?.role ||
    uploadedImage.value !== null
  );
});

const handleSubmit = async (e: Event) => {
  e.preventDefault();

  try {
    const formData = new FormData();
    formData.append("name", name.value);
    formData.append("email", email.value);
    formData.append("phone", phone.value);
    formData.append("role", selectedRole.value);

    if (uploadedImage.value) {
      const fileInput = document.getElementById(
        "profilePicture"
      ) as HTMLInputElement;
      if (fileInput.files?.[0]) {
        formData.append("image", fileInput.files[0]);
      }
    }

    const { data } = await AccountService.updateAccount(
      authStore.userInfo.id,
      formData
    );

    if (data) {
      authStore.updateUserInfo(data[0]);
      showAlert("Cập nhật thành công!", "success");
      router.push({ name: "Profile" });
    }
  } catch (error) {
    console.error("Update failed:", error);
    showAlert(
      error.response?.data?.message || "Cập nhật thất bại! Vui lòng thử lại.",
      "error"
    );
  }
};
</script>

<style scoped>
.profile-form {
  width: 600px;
  min-width: 500px;
  margin: 0 auto;
  margin-top: 40px;
  padding: 30px;
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.profile-form h2 {
  text-align: center;
  margin-bottom: 30px;
  font-size: 25px;
  font-weight: 600;
  color: #333;
}

.form-group {
  position: relative;
  margin-bottom: 20px;
}

.form-group input {
  width: 100%;
  padding: 12px;
  padding-right: 35px;
  border: 1px solid #e0e0e0;
  border-radius: 4px;
  font-size: 14px;
  color: #333;
  background-color: white;
  box-sizing: border-box;
}

.form-group input::placeholder {
  color: #999;
}

.form-group .icon {
  position: absolute;
  right: 12px;
  top: 72%;
  transform: translateY(-50%);
  color: #999;
  font-size: 16px;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  color: #333;
  font-size: 14px;
}

.upload-section {
  margin-top: 20px;
  margin-bottom: 20px;
}

.upload-section label {
  display: block;
  margin-bottom: 8px;
  color: #333;
  font-size: 14px;
}

.file-input {
  position: relative;
  margin-bottom: 20px;
}

.file-input input[type="file"] {
  width: 100%;
  padding: 8px;
  border: 1px solid #e0e0e0;
  border-radius: 4px;
  background-color: white;
  box-sizing: border-box;
}

.profile-preview {
  text-align: center;
  margin-bottom: 20px;
}

.profile-picture {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  object-fit: cover;
  margin: 0 auto;
  display: block;
  border: 3px solid #fff;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.update-btn {
  width: 100%;
  padding: 12px;
  background-color: #2c3e50;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 14px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.update-btn:hover {
  background-color: #333;
}

.file-input input[type="file"] {
  padding: 8px;
  font-size: 14px;
}

.file-input .file-name {
  color: #666;
  font-size: 14px;
  margin-left: 8px;
}

input:focus {
  outline: none;
  border-color: #999;
}

.update-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  background-color: #cccccc;
  color: #666666;
}

.role-select {
  width: 100%;
  padding: 12px;
  border: 1px solid #e0e0e0;
  border-radius: 4px;
  font-size: 14px;
  color: #333;
  background-color: white;
  box-sizing: border-box;
}

.role-select:focus {
  outline: none;
  border-color: #999;
}
</style>
