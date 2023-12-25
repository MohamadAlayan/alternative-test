import { useAuthStore } from '@/stores/useAuthStore';
import { useAppStore } from '@/stores/useAppStore';
import { usePageStore } from '@/stores/usePageStore';

const useStore = () => ({
  auth: useAuthStore(),
  app: useAppStore(),
  page: usePageStore()
});

export default useStore;
