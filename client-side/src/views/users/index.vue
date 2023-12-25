<script setup lang="ts">
import { ref } from 'vue';
import UsersView from '@/views/users/UsersView.vue';
import AdminsView from '@/views/users/AdminsView.vue';

const chosenTab = ref(0);
const tabs = ref([
  {
    title: 'admins',
    value: 0
  },
  {
    title: 'users',
    value: 1
  }
]);
</script>

<template>
  <v-tabs v-model="chosenTab" bg-color="background" color="primary">
    <v-tab v-for="tab in tabs" :key="tab.value" :value="tab.value">
      {{ $t(tab.title) }}
    </v-tab>
  </v-tabs>
  <v-container fluid>
    <v-window v-model="chosenTab">
      <v-window-item :value="0">
        <admins-view />
      </v-window-item>
      <v-window-item :value="1">
        <users-view />
      </v-window-item>
    </v-window>
  </v-container>
</template>

<style scoped></style>
