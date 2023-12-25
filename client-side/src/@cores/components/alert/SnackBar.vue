<script setup lang="ts">
import { ref } from 'vue';

interface SnackbarProps {
  id: number;
  show: boolean;
  icon: string;
  message: string;
  timeout: number;
  type: string;
  color: string;
}

const props = defineProps<SnackbarProps>();

const visible = ref(props.show);
</script>

<template>
  <v-snackbar
    v-model="visible"
    :timeout="props.timeout"
    :color="props.color"
    :multi-line="true"
    v-bind="$attrs"
    transition="scroll-y-transition"
  >
    <v-icon :icon="props.icon" color="white" style="top: -2px" />
    {{ props.message }}
    <template #actions>
      <v-btn color="red" variant="text" @click="visible = false">
        <v-icon icon="mdi-close" color="white" />
      </v-btn>
    </template>
  </v-snackbar>
</template>

<style scoped></style>
