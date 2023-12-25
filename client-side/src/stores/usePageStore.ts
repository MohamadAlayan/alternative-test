import { defineStore } from 'pinia';
import api from '@/config/axios';

export const usePageStore = defineStore('page', {
  state: () => ({
    storeBaseUrl: '/page/'
  }),
  getters: {},
  actions: {
    async getAll() {
      try {
        const response = await api.get(this.storeBaseUrl + 'all');
        return response.data.content;
      } catch (error) {
        return await Promise.reject(error);
      }
    },
    async create(data: any) {
      try {
        return await api.post(this.storeBaseUrl, data);
      } catch (error) {
        return await Promise.reject(error);
      }
    },
    async update(data: any) {
      try {
        return await api.put(this.storeBaseUrl + data.id.toString() + '?uuid=' + data.uuid, data);
      } catch (error) {
        return await Promise.reject(error);
      }
    },
    async delete(id: number, uuid: string) {
      try {
        return await api.delete(this.storeBaseUrl + uuid);
      } catch (error) {
        return await Promise.reject(error);
      }
    },
    async getPage(params: any) {
      try {
        const response = await api.post(this.storeBaseUrl + 'getPage', params);
        return response.data.content;
      } catch (error) {
        return await Promise.reject(error);
      }
    }
  }
});
