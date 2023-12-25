<script setup lang="ts">
import { RouterView } from 'vue-router';
import useStore from '@/stores';
import SnackBar from '@cores/components/alert/SnackBar.vue';

const { app } = useStore();
</script>

<template>
  <RouterView />
  <snack-bar
    v-for="ntf of app.notifications"
    :id="ntf.id"
    :key="'sn' + ntf.id"
    :show="ntf.show"
    :location="ntf.location"
    :icon="ntf.icon"
    :message="ntf.message"
    :timeout="ntf.timeout"
    :type="ntf.type"
    :color="ntf.color"
  />
</template>
