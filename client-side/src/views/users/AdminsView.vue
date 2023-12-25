<script setup lang="ts">
import DataTable from '@cores/components/tables/DataTable.vue';
import { ref } from 'vue';

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
  <h1>Admins</h1>
  <data-table base-route="user-management/admin/" :headers="tableHeaders" />
</template>

<style scoped></style>
