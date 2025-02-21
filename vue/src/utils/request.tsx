import axios, { AxiosInstance } from 'axios'
import { useAuthStore } from "@/stores/authStore";

const request: AxiosInstance = axios.create({
    baseURL: `http://localhost:8000/api/v1`,
    timeout: 0, // request timeout
    headers: {
        'Cache-Control': 'no-cache',
        'Content-type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'Access-Control-Allow-Origin': '*',
    },
    // withCredentials: true,
})

request.interceptors.request.use(
    (config) => {
      const authStore = useAuthStore();
      const token = authStore.userToken;
      if (token) {
        config.headers.Authorization = `Bearer ${token}`;
      }
      return config;
    },
    (error) => Promise.reject(error)
  );

  request.interceptors.response.use(
    (response) => {
        return response.data
    },
)

export default request