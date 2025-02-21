import { defineStore } from 'pinia'
import AuthService from '../services/AuthService'

interface UserState {
  userInfo: any | null;
  userToken: any | null;
}

export const useAuthStore = defineStore('auth', {
  state: (): UserState => ({
    userInfo: JSON.parse(localStorage.getItem('userInfo') || 'null'),
    userToken: JSON.parse(localStorage.getItem('userToken') || 'null'),
  }),

  getters: {
    isAuthenticated(): boolean {
      return !!this.userToken
    }
  },

  actions: {
    setUser(userData: any, token: string) {
      this.userInfo = userData
      this.userToken = token
      localStorage.setItem('userInfo', JSON.stringify(userData))
      localStorage.setItem('userToken', JSON.stringify(token))
    },

    async logout() {
      try {
          await AuthService.logout();
          
          this.clearStoreAuth();
      } catch (error) {
          console.error('Logout failed:', error);
          throw error;
      }
    },

    clearStoreAuth() {
      this.userInfo = null;
      this.userToken = null;
      localStorage.removeItem('userToken');
      localStorage.removeItem('userInfo');
    },

    updateUserInfo(newInfo: any) {
      this.userInfo = { ...this.userInfo, ...newInfo };
      localStorage.removeItem('userInfo')
      localStorage.setItem('userInfo', JSON.stringify(newInfo))
    }
  }
})