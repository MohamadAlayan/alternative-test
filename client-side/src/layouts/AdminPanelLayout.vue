<script setup lang="ts">
import { RouterView } from 'vue-router';
import { ref } from 'vue';
import { RouteName } from '@/constants/RouteName';
import useStore from '@/stores';
import router from '@/router';
import { useI18n } from 'vue-i18n';

const { app, auth } = useStore();
const { t } = useI18n();
const menuItems = ref([
  {
    title: 'Dashboard',
    icon: 'mdi-view-dashboard',
    to: RouteName.DASHBOARD
  },
  {
    title: 'Users',
    icon: 'mdi-account-group',
    to: RouteName.USERS
  },
  {
    title: 'Pages',
    icon: 'mdi-file-document-edit-outline',
    to: RouteName.PAGES
  }
]);

const onLogout = async () => {
  await auth
    .logout()
    .then((response) => {
      app.success(t('logoutSuccess'));
      setTimeout(function () {
        router.push({ name: RouteName.LOGIN });
      }, 1500);
    })
    .catch((error) => {
      app.error(error);
    });
};
</script>

<template>
  <v-layout>
    <v-navigation-drawer permanent>
      <v-list>
        <v-list-item v-for="item in menuItems" :key="item.title" :to="item.to" :prepend-icon="item.icon" :title="item.title" />
      </v-list>
    </v-navigation-drawer>
    <v-app-bar>
      <v-spacer />
      <ul class="no-bullets">
        <li>
          <v-menu>
            <template #activator="{ props }">
              <v-btn class="text-capitalize text-text-color py-2 rounded-0" max-height="100%" height="100%" v-bind="props">
                <!--                <account-avatar-->
                <!--                  :avatar="auth.user.avatar?.base_url ? auth.user.avatar.base_url + '/' + auth.user.avatar.webp_thumbnail : null"-->
                <!--                  :account="auth.user"-->
                <!--                  :background="$vuetify.theme.current.colors.primary"-->
                <!--                  :color="$vuetify.theme.current.colors['on-primary']"-->
                <!--                  :size="45"-->
                <!--                  :text-size="1"-->
                <!--                />-->
                <div class="ml-3">
                  <!--                  <v-col cols="12" class="ma-0 pa-0 text-start">-->
                  <!--                    <span class="user-role" :style="{ color: auth.user_role.color ?? 'grey' }">{{ auth.user_role.name }}</span>-->
                  <!--                  </v-col>-->
                  <v-col cols="12" class="ma-0 pa-0 mt-1"
                    ><span class="lead-text">{{ auth.user.first_name + ' ' + auth.user.last_name }}</span>
                    <v-icon icon="mdi:mdi-menu-down" />
                  </v-col>
                </div>
              </v-btn>
            </template>
            <v-card>
              <v-list active-color="primary" class="pa-0">
                <v-list-item :title="$t('logout')" color="error" prepend-icon="mdi-logout" @click="onLogout" />
              </v-list>
            </v-card>
          </v-menu>
        </li>
      </ul>
    </v-app-bar>
    <v-main>
      <RouterView />
    </v-main>
  </v-layout>
</template>

<style scoped></style>
