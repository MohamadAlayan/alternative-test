<script setup lang="ts">
import { ref } from 'vue';
import DataTable from '@cores/components/tables/DataTable.vue';

const tableHeaders = ref([
  {
    text: 'ID',
    value: 'id'
  },
  {
    text: 'Email',
    value: 'email'
  }
]);
</script>

<template>
  <h1>Users</h1>
  <data-table base-route="user-management/user/" :headers="tableHeaders" />
</template>

<style scoped></style>
