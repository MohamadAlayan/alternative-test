<script setup lang="ts">
import { RouterView } from 'vue-router';
</script>

<template>
  <v-layout class="auth-page-wrapper">
    <div class="auth-page-background">
      <div class="auth-bg-overlay"></div>
      <div class="auth-bg-shape" style="">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
          <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
        </svg>
      </div>
    </div>
    <div class="auth-page-content">
      <RouterView />
    </div>
  </v-layout>
</template>

<style scoped lang="scss">
.auth-page-wrapper {
  .auth-page-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    height: 350px;
    background: url('@/assets/images/auth-bg.png') no-repeat fixed center center !important;
    background-size: cover !important;

    .auth-bg-overlay {
      position: absolute;
      height: 100%;
      width: 100%;
      right: 0;
      bottom: 0;
      left: 0;
      top: 0;
      background: linear-gradient(to right, rgb(var(--v-theme-primary)), rgba(var(--v-theme-primary), 0.7));
      opacity: 0.9;
    }

    .auth-bg-shape {
      position: absolute;
      bottom: -6px;
      right: 0;
      left: 0;
      z-index: 1;
      pointer-events: none;

      svg {
        width: 100%;
        height: auto;
        fill: rgb(var(--v-theme-background));
      }
    }
  }

  .auth-page-content {
    top: 250px;
    position: relative;
    z-index: 1;
    margin-left: auto;
    margin-right: auto;
  }
}
</style>
