import { defineStore } from 'pinia';
import api from '@/config/axios';
import { useLocalStorage } from '@vueuse/core';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    token: useLocalStorage('token', null),
    user: useLocalStorage('user', {
      first_name: '',
      last_name: ''
    })
  }),
  getters: {
    isAuthenticated: (state) => !!state.token
  },
  actions: {
    async login(params) {
      const response = await api.post('login', params);
      if (response.data.success) {
        this.token = response.data.content.token;
        this.user = response.data.content.user;
        return true;
      }
    },
    async logout() {
      try {
        const response = await api.get('logout');
        if (response.data.success) {
          const keysToRemove = ['token', 'user'];
          keysToRemove.forEach((key) => {
            localStorage.removeItem(key);
          });
          this.$reset();
        }
        return response.data;
      } catch (error) {
        return await Promise.reject(error);
      }
    }
  }
});
