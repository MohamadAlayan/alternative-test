<script setup lang="ts">
import { computed, onMounted, reactive, ref } from 'vue';
import useStore from '@/stores';
import { useRoute, useRouter } from 'vue-router';
import { useValidationsRules } from '@/composables/useValidationComposable';
import LabelField from '@cores/components/labels/LabelField.vue';
import { useI18n } from 'vue-i18n';
import { RouteName } from '@/constants/RouteName';

const route = useRoute();
const router = useRouter();
const { rules, validate } = useValidationsRules();
const { app, page } = useStore();
const { t } = useI18n();
const form = ref(null);

const data = reactive({
  id: route.params.id,
  action: route.params.action
});

const payload = reactive({
  title: '',
  slug: '',
  content: '',
  status: 1,
  parent_id: null
});

const title = computed(() => {
  return data.action === 'create' ? t('createPage') : t('editPage') + ' #' + data.id;
});

const allPages = ref([]);

const onSave = async () => {
  const isValid = await validate(form);
  if (app.isAppLoading || !isValid) {
    return;
  }
  app.setAppLoadingStatus(true);

  if (data.action === 'create') {
    await page
      .create(payload)
      .then((response) => {
        app.success(t('pageCreatedSuccessfully'));
        setTimeout(function () {
          router.push({ name: RouteName.PAGES });
        }, 3000);
      })
      .catch((error) => {
        app.error(error);
        app.setAppLoadingStatus(false);
      });
  } else {
    await page
      .update(payload)
      .then((response) => {
        app.success(t('pageUpdatedSuccessfully'));
        setTimeout(function () {
          router.push({ name: RouteName.PAGES });
        }, 3000);
      })
      .catch((error) => {
        app.error(error);
        app.setAppLoadingStatus(false);
      });
  }
};

onMounted(async () => {
  allPages.value = await page.getAll();

  if (data.action === 'edit') {
    // Get page data
    await page
      .getPage({
        id: data.id
      })
      .then((content) => {
        payload.id = content.id;
        payload.uuid = content.uuid;
        payload.title = content.title;
        payload.slug = content.slug;
        payload.content = content.content;
        payload.status = content.status;
        payload.parent_id = content.parent_id;
      })
      .catch((error) => {
        app.error(error);
      });
  }
});
</script>

<template>
  <v-container :fluid="true">
    <v-card>
      <v-card-title class="pt-5 pb-10">
        <h2>{{ title }}</h2>
      </v-card-title>
      <v-card-text>
        <v-form ref="form">
          <v-row>
            <v-col cols="12">
              <label-field :title="$t('title')" />
              <v-text-field v-model="payload.title" :rules="rules.required" :loading="app.isAppLoading" :placeholder="$t('enterTitle')" />
            </v-col>
            <v-col cols="12">
              <label-field :title="$t('slug')" />
              <v-text-field v-model="payload.slug" :rules="rules.required" :loading="app.isAppLoading" :placeholder="$t('enterSlug')" />
            </v-col>
            <v-col cols="12">
              <label-field :title="$t('content')" />
              <v-textarea v-model="payload.content" :rules="rules.required" :loading="app.isAppLoading" :placeholder="$t('enterContent')" />
            </v-col>

            <v-col cols="12">
              <label-field :title="$t('status')" />
              <v-select
                v-model="payload.status"
                :items="[
                  { text: $t('active'), value: 1 },
                  { text: $t('inactive'), value: 2 }
                ]"
                item-title="text"
                item-value="value"
                :rules="rules.required"
                :loading="app.isAppLoading"
                :placeholder="$t('selectStatus')"
              />
            </v-col>
            <v-col cols="12">
              <label-field :title="$t('parentPage')" />
              <v-select
                v-model="payload.parent_id"
                :items="allPages"
                item-title="title"
                item-value="id"
                :loading="app.isAppLoading"
                :placeholder="$t('selectParentPage')"
                clearable
              />
            </v-col>
            <v-col cols="12">
              <v-btn color="primary" :block="true" @click="onSave">{{ $t('save') }}</v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<style scoped></style>
