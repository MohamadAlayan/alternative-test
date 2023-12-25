<script setup lang="ts">
import DataTable from '@cores/components/tables/DataTable.vue';
import { ref } from 'vue';
import { RouteName } from '@/constants/RouteName';
import router from '@/router';
import { useI18n } from 'vue-i18n';
import useStore from '@/stores';
import ConfirmDialog from '@cores/dialogs/ConfirmDialog.vue';

const { t } = useI18n();
const { app, page } = useStore();
const confirmDeleteDialog = ref<InstanceType<typeof ConfirmDialog>>();
const table = ref<InstanceType<typeof DataTable>>();
const tableHeaders = ref([
  {
    text: 'ID',
    value: 'id'
  },
  {
    text: 'title',
    value: 'title'
  },
  {
    text: 'slug',
    value: 'slug'
  },
  {
    text: 'parent',
    value: 'parent.title'
  },
  {
    text: 'created_at',
    value: 'created_at'
  },
  { text: 'actions', value: 'action-buttons' }
]);

const deleteItem = async (id: number, uuid: string) => {
  confirmDeleteDialog.value?.openDialog(t('delete'), t('confirmDelete')).then((response: boolean) => {
    if (response) {
      page
        .delete(id, uuid)
        .then(() => {
          table.value.getData();
          app.success(t('deleteSuccess'));
        })
        .catch((e) => {
          app.error(e);
        });
    }
  });
};
</script>

<template>
  <v-container fluid>
    <v-row>
      <v-col cols="12">
        <data-table ref="table" base-route="page/" :headers="tableHeaders" :title="$t('pages')">
          <template #buttons>
            <v-btn color="primary" @click="$router.push({ name: RouteName.PAGE, params: { action: 'create' } })">
              <v-icon>mdi-plus</v-icon>
              {{ $t('create') }}
            </v-btn>
          </template>
          <template #item-action-buttons="item">
            <v-menu location="bottom left">
              <template #activator="{ props }">
                <v-btn variant="text" icon="mdi-dots-vertical" v-bind="props" color="data-table-action-button-color"></v-btn>
              </template>
              <v-list density="comfortable" class="data-table-action-button-list">
                <v-list-item
                  :title="t('view')"
                  prepend-icon="mdi-eye"
                  density="comfortable"
                  color="data-table-action-button-color"
                  @click="productView(item)"
                />
                <v-list-item
                  :title="t('edit')"
                  prepend-icon="mdi-pencil"
                  density="comfortable"
                  @click="$router.push({ name: RouteName.PAGE, params: { action: 'edit', id: item.id } })"
                />
                <v-list-item :title="t('delete')" prepend-icon="mdi-delete" density="comfortable" @click="deleteItem(item.id, item.uuid)" />
              </v-list>
            </v-menu>
          </template>
        </data-table>
      </v-col>
    </v-row>
  </v-container>
  <ConfirmDialog ref="confirmDeleteDialog" />
</template>

<style scoped></style>
