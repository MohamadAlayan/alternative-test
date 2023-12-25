<script setup lang="ts">
const props = defineProps({
  title: {
    type: String,
    required: false
  },
  subtitle: {
    type: String,
    required: false
  },
  fontSize: {
    type: String,
    required: false,
    default: '16px'
  },
  marginBottom: {
    type: String,
    required: false,
    default: '5px'
  }
});
</script>

<template>
  <div class="label-field" :style="{ marginBottom: props.marginBottom }">
    <p class="label-title">
      {{ props.title }}
      <slot />
    </p>
    <span v-if="props.subtitle" class="label-subtitle">{{ props.subtitle }}</span>
  </div>
</template>

<style lang="scss" scoped>
.label-field {
  margin-bottom: 0.5rem;
}

.label-title {
  font-size: 0.925rem;
  font-weight: 500;
  color: rgb(var(--v-theme-on-surface));
}

.label-subtitle {
  font-style: normal;
  font-weight: 400;
  font-size: 14px;
  line-height: 16px;
  color: rgb(var(--v-theme-text-secondary));
  margin-top: 6px;
  display: block;
}
</style>
