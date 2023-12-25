import type { ThemeDefinition } from 'vuetify';

const ThemeOne = {
  light: {
    dark: false,
    colors: {
      primary: '#020f1f',
      background: '#f2f2f7',

      surface: '#FFFFFF',
      'primary-darken-1': '#3700B3',
      secondary: '#03DAC6',
      'secondary-darken-1': '#018786',
      error: '#B00020',
      info: '#2196F3',
      success: '#4CAF50',
      warning: '#FB8C00'
    }
  },
  dark: {
    dark: true,
    colors: {
      background: '#121212',
      surface: '#121212',
      primary: '#BB86FC',
      'primary-darken-1': '#3700B3',
      secondary: '#03DAC6',
      'secondary-darken-1': '#03DAC6',
      error: '#CF6679',
      info: '#2196F3',
      success: '#4CAF50',
      warning: '#FB8C00'
    }
  }
};

export default ThemeOne;
