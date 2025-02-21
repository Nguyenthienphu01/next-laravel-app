<template>
  <div class="change-password-container">
    <h2>Change Password</h2>
    <form @submit.prevent="changePassword">
      <div class="form-group">
        <label for="oldPassword">Old Password</label>
        <input
          type="password"
          v-model="oldPassword"
          id="oldPassword"
          placeholder="Enter old password"
        />
      </div>
      <div class="form-group">
        <label for="newPassword">New Password</label>
        <input
          type="password"
          v-model="newPassword"
          id="newPassword"
          placeholder="Enter new password"
        />
      </div>
      <div class="form-group">
        <label for="confirmPassword">Confirm New Password</label>
        <input
          type="password"
          v-model="confirmPassword"
          id="confirmPassword"
          placeholder="Confirm new password"
        />
      </div>
      <button type="submit" class="btn-submit">Change Password</button>
    </form>
    <footer class="footer">© 2025 Your Company. All rights reserved.</footer>
  </div>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import AuthService from "@/services/AuthService";

const router = useRouter();

const oldPassword = ref("");
const newPassword = ref("");
const confirmPassword = ref("");

const changePassword = async () => {
  if (newPassword.value !== confirmPassword.value) {
    alert("New password and confirm password do not match!");
    return;
  }

  try {
    const data = {
      old_password: oldPassword.value,
      new_password: newPassword.value,
      new_password_confirmation: confirmPassword.value,
    };
    await AuthService.changePassword(data);
    alert("Password changed successfully!");
    localStorage.removeItem("userToken");
    router.push({ name: "Login" });
  } catch (error) {
    console.error(error);
    alert("Failed to change password");
  }
};
</script>

<style scoped>
.change-password-container {
  max-width: 400px;
  margin: 50px auto;
  padding: 20px;
  background-color: #ffffff;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  font-family: Arial, sans-serif;
}

.change-password-container h2 {
  text-align: center;
  margin-bottom: 20px;
  font-size: 24px;
  font-weight: bold;
  color: #333333;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-size: 14px;
  color: #555555;
}

.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #cccccc;
  border-radius: 4px;
  font-size: 14px;
  box-sizing: border-box;
}

.btn-submit {
  width: 100%;
  padding: 10px;
  background-color: #333333;
  color: #ffffff;
  border: none;
  border-radius: 4px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-submit:hover {
  background-color: #555555;
}

.footer {
  margin-top: 20px;
  text-align: center;
  font-size: 12px;
  color: #aaaaaa;
}
</style>
