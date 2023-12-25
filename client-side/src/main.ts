import { createApp } from 'vue';
import { createPinia } from 'pinia';

import App from '@/App.vue';
import Particles from 'vue3-particles';
import router from '@/router';
import vuetify from '@/config/vuetify';
import i18n from '@/config/i18n';
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import '@/assets/scss/main.scss';

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.use(vuetify);
app.use(i18n);
app.use(Particles);

// Import Component
app.component('EasyDataTable', Vue3EasyDataTable);

app.mount('#app');
