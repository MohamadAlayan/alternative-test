import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import { fa } from 'vuetify/iconsets/fa';
import { aliases, mdi } from 'vuetify/iconsets/mdi';
import '@mdi/font/css/materialdesignicons.css';
import ThemeOne from '@/assets/themes/ThemeOne';
import 'vuetify/styles';

export default createVuetify({
  components,
  directives,
  theme: {
    themes: ThemeOne
  },
  icons: {
    defaultSet: 'mdi',
    aliases,
    sets: {
      fa,
      mdi
    }
  },
  defaults: {
    VTextField: {
      variant: 'outlined',
      density: 'compact',
      color: 'primary',
      bgColor: 'surface'
    },
    VBtn: {
      variant: 'flat'
    },
    VTabs: {
      VTab: {
        VBtn: {
          rounded: false
        }
      }
    },
    VAutocomplete: {
      rounded: true,
      variant: 'outlined',
      density: 'compact',
      bgColor: 'surface',
      color: 'primary'
    },
    VSelect: {
      rounded: true,
      variant: 'outlined',
      density: 'compact',
      bgColor: 'surface',
      color: 'primary'
    },
    VTextarea: {
      rounded: 'lg',
      variant: 'outlined',
      density: 'compact',
      bgColor: 'surface',
      color: 'primary'
    },
    VCheckbox: {
      color: 'primary',
      density: 'compact'
    },
    VSwitch: {
      color: 'primary'
    }
  }
});
