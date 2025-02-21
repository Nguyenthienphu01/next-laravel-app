<template>
  <div class="login-container">
    <Alert
      v-model:show="alert.show"
      :message="alert.message"
      :type="alert.type"
      :duration="3000"
    />

    <div class="login-box">
      <h1>Login</h1>
      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <input
            type="email"
            v-model="form.email"
            placeholder="Email"
            required
          />
        </div>

        <div class="form-group">
          <input
            type="password"
            v-model="form.password"
            placeholder="Password"
            required
          />
        </div>

        <button type="submit" class="btn">Sign In</button>

        <div class="options">
          <a href="#">Forgot your password?</a>
          <a href="#">Create account</a>
        </div>
      </form>
    </div>
  </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";
import AuthService from "@/services/AuthService";
import { useAuthStore } from "@/stores/authStore";
import Alert from "@/components/Alert.vue";

const router = useRouter();
const authStore = useAuthStore();

const form = reactive({
  email: "",
  password: "",
});

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

const handleLogin = async () => {
  try {
    const response = await AuthService.login(form);

    const { user, token } = response.data;
    const userData = {
      id: user.id,
      name: user.name,
      email: user.email,
      phone: user.phone,
      role: user.role,
      image: user.image,
    };

    authStore.setUser(userData, token);
    showAlert("Login successful!", "success");

    router.push({ name: "Dashboard" });
  } catch (error) {
    console.error("Login error:", error);
    showAlert(
      error.response?.data?.message || "Login failed! Please try again.",
      "error"
    );
  }
};
</script>

<style scoped>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f9f9f9;
  margin: 0;
}

.login-box {
  background-color: #ffffff;
  border-radius: 8px;
  padding: 2rem;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
  width: 320px;
}

h1 {
  font-size: 24px;
  margin-bottom: 1.5rem;
  font-weight: bold;
}

.form-group {
  margin-bottom: 1rem;
}

input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  background-color: #f8f8f8;
  font-size: 14px;
  outline: none;
  transition: all 0.3s;
  box-sizing: border-box;
}

input[type="email"]:focus,
input[type="password"]:focus {
  border-color: #333;
  background-color: #ffffff;
}

.btn {
  width: 50%;
  padding: 10px;
  border: none;
  border-radius: 4px;
  background-color: #333;
  color: white;
  font-size: 16px;
  cursor: pointer;
  margin-top: 1rem;
  transition: all 0.3s;
}

.btn:hover {
  background-color: #555;
}

.options {
  margin-top: 1rem;
  font-size: 14px;
  color: #555;
}

.options a {
  display: block;
  margin: 0.5rem 0;
  color: #333;
  text-decoration: none;
  transition: color 0.3s;
}

.options a:hover {
  color: #007bff;
}
</style>
