<script setup lang="ts">
import { reactive } from 'vue';

const data = reactive({
  visible: false,
  title: 'title',
  message: 'message'
});

let confirmResolve = (value: boolean): void => {
  /* do nothing */
};

const agree = () => {
  confirmResolve(true);
  data.visible = false;
};

const cancel = () => {
  confirmResolve(false);
  data.visible = false;
};

const openDialog = (title: string, message: string): Promise<boolean> => {
  data.visible = true;
  data.title = title;
  data.message = message;

  return new Promise<boolean>((resolve) => {
    confirmResolve = resolve;
  });
};

defineExpose({ openDialog });
</script>

<template>
  <v-dialog v-model="data.visible" max-width="500px" transition="fade-transition" persistent v-bind="$attrs">
    <v-card>
      <v-card-title>
        {{ data.title }}
      </v-card-title>
      <v-card-text>
        {{ data.message }}
      </v-card-text>
      <v-card-actions class="justify-end">
        <v-btn color="error" @click.stop="cancel">{{ $t('cancel') }}</v-btn>
        <v-btn color="primary" @click.stop="agree">{{ $t('confirm') }}</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<style scoped></style>
