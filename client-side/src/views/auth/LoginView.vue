<script setup lang="ts">
import { reactive, ref } from 'vue';
import useStore from '@/stores';
import LabelField from '@cores/components/labels/LabelField.vue';
import { useValidationsRules } from '@/composables/useValidationComposable';
import { useI18n } from 'vue-i18n';
import router from '@/router';
import { RouteName } from '@/constants/RouteName';

const { t } = useI18n();
const form = ref(null);
const { auth, app } = useStore();
const { rules, validate } = useValidationsRules();
const payload = reactive({
  email: '',
  password: '',
  remember_me: false
});

// Methods
const onLogin = async () => {
  const isValid = await validate(form);
  if (app.isAppLoading || !isValid) {
    return;
  }
  app.setAppLoadingStatus(true);

  await auth
    .login(payload)
    .then((response) => {
      app.success(t('loginSuccess'));
      setTimeout(function () {
        router.push({ name: RouteName.DASHBOARD });
      }, 3000);
    })
    .catch((error) => {
      app.error(error);
      app.setAppLoadingStatus(false);
    });
};
</script>

<template>
  <v-container>
    <v-row>
      <v-col cols="12">
        <v-window>
          <v-window-item>
            <v-card class="login-container" elevation="0">
              <v-card-title></v-card-title>
              <v-card-text>
                <v-form ref="form">
                  <v-row>
                    <v-col cols="12" class="py-0">
                      <label-field :title="$t('email')" />
                      <v-text-field
                        prepend-inner-icon="mdi-email"
                        :placeholder="$t('enterEmail')"
                        :loading="app.isAppLoading"
                        v-model="payload.email"
                        :rules="rules.email"
                      />
                    </v-col>
                    <v-col cols="12" class="py-0">
                      <label-field :title="$t('password')" />
                      <v-text-field
                        v-model="payload.password"
                        prepend-inner-icon="mdi-lock"
                        :loading="app.isAppLoading"
                        type="password"
                        :placeholder="$t('enterPassword')"
                        :rules="rules.required"
                      />
                    </v-col>
                    <!--                    <v-col cols="12" class="py-0">-->
                    <!--                      <v-checkbox v-model="payload.remember_me" :label="$t('rememberMe')" />-->
                    <!--                    </v-col>-->
                    <v-col cols="12">
                      <v-btn color="primary" :block="true" @click="onLogin">{{ $t('login') }}</v-btn>
                    </v-col>
                  </v-row>
                </v-form>
              </v-card-text>
            </v-card>
          </v-window-item>
        </v-window>
      </v-col>
    </v-row>
  </v-container>
</template>

<style scoped lang="scss">
.login-container {
  max-width: 380px;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 15px;
  margin-right: auto;
  margin-left: auto;
  align-self: center;
  box-shadow: 0 25px 10px rgba(0, 0, 0);
  background-color: #fff;
}
</style>
