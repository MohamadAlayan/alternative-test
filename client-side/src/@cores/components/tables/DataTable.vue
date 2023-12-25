<script setup lang="ts">
import { reactive, onMounted, ref, watch } from 'vue';
import type { ServerOptions } from 'vue3-easy-data-table';
import api from '@/config/axios';
import i18n from '@/config/i18n';
import useStore from '@/stores';

const { app } = useStore();
const { t } = i18n.global;

// Props
const props = defineProps({
  baseRoute: { type: String, required: true },
  title: { type: String, default: null, required: false },
  subtitle: { type: String, default: null, required: false },
  headers: { type: Array },
  paginated: { type: Boolean, default: true },
  enableFilters: { type: Boolean, default: false },
  enablePageRoute: { type: Boolean, default: false },
  filtersData: { type: Object, default: () => ({}) },
  hideFooter: { type: Boolean, default: false },
  extraParams: { type: Object, default: () => ({}) },
  exact: { type: Boolean, default: false },
  disableHeader: { type: Boolean, default: false }
});

// Data
const data = reactive({
  pagination: {
    total: 0,
    count: 0,
    totalPages: 1
  },
  search: '',
  loading: false,
  items: [],
  openFilters: false
});
const pageField = ref();
const tablePagination = ref<ServerOptions>({
  page: 1, // Current Page
  sortBy: 'id',
  sortType: 'desc',
  rowsPerPage: 25
});

onMounted(() => {
  getData();
});

// Methods
const getData = async () => {
  data.loading = true;
  let params = {
    page: tablePagination.value.page,
    per_page: tablePagination.value.rowsPerPage,
    descending: tablePagination.value.sortType === 'desc',
    sort: tablePagination.value.sortBy
  };

  if (props.extraParams) {
    params = { ...params, ...props.extraParams };
  }

  // Search
  if (data.search && data.search.length > 0) {
    // @ts-ignore
    params.search = data.search;
  }

  // Filters
  if (props.filtersData) {
    params = { ...params, ...props.filtersData };
  }

  let bRoute = props.baseRoute;
  if (!props.exact) {
    bRoute = props.baseRoute + 'list';
  }

  api
    .get(bRoute, {
      params
    })
    .then((response) => {
      const result = response.data;
      data.items = result.data;

      if (props.paginated) {
        data.pagination.total = result.total;
        data.pagination.count = result.total;
        data.pagination.totalPages = result.last_page;
        tablePagination.value.rowsPerPage = result.per_page;
        tablePagination.value.page = result.current_page;
      }
    })
    .catch((e) => {
      app.error(e.error.message);
    })
    .finally(() => {
      data.loading = false;
    });
};

const paginationRange = (inputPage: number, lastPage: number) => {
  if (inputPage && inputPage >= 1 && inputPage <= lastPage) return true;
  return t('pageLimit', lastPage);
};

const onSearch = () => {
  tablePagination.value.page = 1;
  getData();
};

const openFilters = () => {
  data.openFilters = !data.openFilters;
};

// watchers
watch(
  tablePagination,
  async (value) => {
    if (paginationRange(value.page, data.pagination.totalPages) === true) {
      await getData();
    }
  },
  { deep: true }
);

watch(
  () => props.filtersData,
  async (value) => {
    if (props.enableFilters && value) {
      await getData();
    }
  },
  { deep: true }
);

defineExpose({
  getData
});
</script>

<template>
  <v-row v-if="!props.disableHeader" class="justify-end my-3">
    <v-col v-if="props.title" cols="auto">
      <!--          <page-title :title="props.title" :subtitle="props.subtitle" />-->
      <h1>{{ props.title }}</h1>
    </v-col>
    <slot name="title" />
    <v-spacer />
    <v-col cols="auto">
      <slot name="buttons" />
    </v-col>
  </v-row>
  <v-expand-transition>
    <v-card v-if="props.enableFilters && data.openFilters" :title="$t('filters')" class="mb-5">
      <v-row class="mx-1 mb-1">
        <slot name="filters" />
      </v-row>
    </v-card>
  </v-expand-transition>
  <v-row>
    <v-col cols="12">
      <v-card elevation="0" border>
        <v-card-text>
          <v-row>
            <v-spacer />
            <v-col cols="auto">
              <v-tooltip v-if="enableFilters" location="top">
                <template #activator="{ props }">
                  <v-btn icon="mdi-filter-outline" color="primary" variant="text" v-bind="props" @click="openFilters" />
                </template>
                <span>{{ t('filters') }}</span>
              </v-tooltip>
              <v-tooltip location="top">
                <template #activator="{ props }">
                  <v-btn icon="mdi-refresh" color="primary" variant="text" v-bind="props" @click="getData" />
                </template>
                <span>{{ t('refresh') }}</span>
              </v-tooltip>
            </v-col>
          </v-row>
        </v-card-text>
      </v-card>
    </v-col>
  </v-row>
  <v-row class="mb-2">
    <v-col cols="12">
      <easy-data-table
        v-model:server-options="tablePagination"
        :rows-items="[5, 10, 25, 50, 100]"
        :server-items-length="data.pagination.total"
        :theme-color="$vuetify.theme.current.colors.primary"
        :headers="props.headers"
        :items="data.items"
        :loading="data.loading"
        table-class-name="vue3-table-style"
        :hide-footer="props.hideFooter"
        :class="props.hideFooter ? '' : 'with-footer'"
        alternating
      >
        <template v-for="(x, slotName) in $slots" #[slotName]="item">
          <slot v-if="slotName.toString().includes('item-')" :name="slotName" v-bind="item" />
        </template>
      </easy-data-table>
    </v-col>
    <v-col cols="12">
      <div v-if="props.paginated && data.items.length > 0" class="text-center pt-2 pb-2">
        <v-row justify="center">
          <v-col cols="12">
            <v-pagination
              v-model="tablePagination.page"
              size="small"
              active-color="primary"
              :length="data.pagination.totalPages"
              :disabled="data.loading"
              :total-visible="5"
              elevation="1"
            />
          </v-col>
          <v-col cols="auto" class="pa-0">
            <v-text-field
              ref="pageField"
              v-model.number="tablePagination.page"
              class="page-text-field"
              variant="solo"
              density="comfortable"
              :prefix="$t('page') + ': '"
              :label="$t('enterPage')"
              :rules="[paginationRange(tablePagination.page, data.pagination.totalPages)]"
            />
          </v-col>
        </v-row>
      </div>
    </v-col>
  </v-row>
</template>

<style scoped></style>
