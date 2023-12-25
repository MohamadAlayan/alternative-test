import { createI18n } from 'vue-i18n';
import type { I18nOptions } from 'vue-i18n';

// // Auto import lang files from locales folder
// interface LocaleMessages {
//   [key: string]: string | LocaleMessages;
// }
//
// const messages: Record<string, LocaleMessages> = {};
// const locales = import.meta.glob('./locales/*.ts');
//
// Object.keys(locales).forEach((key) => {
//   const matched = key.match(/([A-Za-z0-9-_]+)\./i);
//   if (matched && matched.length > 1) {
//     const locale = matched[1];
//     messages[locale] = locales[key].default as LocaleMessages;
//   }
// });

// User defined lang
import enLocale from '@/locales/en';

const messages = {
  en: {
    ...enLocale
  }
};

const options: I18nOptions = {
  legacy: false, // you must set `false`, to use Composition API
  locale: localStorage.getItem('base-locale') ? localStorage.getItem('base-locale')! : 'en', // set locale
  globalInjection: true,
  allowComposition: true,
  messages
};

export default createI18n(options);
