import { fileURLToPath, URL } from 'node:url';

import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
      '@images': fileURLToPath(new URL('./src/assets/img', import.meta.url)),
      '@svgs': fileURLToPath(new URL('./src/assets/svg', import.meta.url)),
      '@cores': fileURLToPath(new URL('./src/@cores', import.meta.url)),
      '@dialogs': fileURLToPath(new URL('./src/components/@dialogs', import.meta.url)),
      '@composables': fileURLToPath(new URL('./src/composables', import.meta.url)),
      '@constants': fileURLToPath(new URL('./src/constants', import.meta.url))
    }
  }
});
