<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import useStore from '@/stores';

const pageContent = ref('');
const { page } = useStore();
const route = useRoute();

const props = defineProps({
  type: {
    type: String,
    required: true
  },
  pathMatch: {
    type: String,
    required: true
  }
});

onMounted(async () => {
  const { type, pathMatch } = route.params;

  if (type === 'slug') {
    // convert array to string
    const path = pathMatch.join('/');
    await page
      .getPage({ slug: path })
      .then((response) => {
        pageContent.value = response.content;
      })
      .catch((error) => {
        console.log(error);
      });
  } else if (type === 'titles') {
    await page
      .getPage({ titles: pathMatch })
      .then((response) => {
        pageContent.value = response.content;
      })
      .catch((error) => {
        console.log(error);
      });
  }
});
</script>

<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <h1 class="text-amber">111111111111111111</h1>
        <div v-html="pageContent" />
      </v-col>
    </v-row>
  </v-container>
</template>

<style scoped></style>
