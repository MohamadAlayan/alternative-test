/* eslint-env node */
require('@rushstack/eslint-patch/modern-module-resolution')

module.exports = {
  root: true,
  extends: [
    'plugin:vue/vue3-essential',
    'eslint:recommended',
    '@vue/eslint-config-typescript',
    '@vue/eslint-config-prettier/skip-formatting'
  ],
  overrides: [
    {
      files: [
        '**/__tests__/*.{cy,spec}.{js,ts,jsx,tsx}',
        'cypress/e2e/**/*.{cy,spec}.{js,ts,jsx,tsx}'
      ],
      'extends': [
        'plugin:cypress/recommended'
      ]
    }
  ],
  parserOptions: {
    ecmaVersion: 'latest'
  },
  plugins: ['vue', '@typescript-eslint'],
  rules: {
    'linebreak-style': ['warn', 'unix'],
  },
  settings: {
    "import/resolver": {
      alias: {
        map: [
          ["@", "./src"],
          ["@images", "./src/assets/img"],
          ["@svgs", "./src/assets/svg"],
          ["@layouts", "./src/layouts"],
          ["@cores", "./src/components/@cores"],
          ["@dialogs", "./src/components/@dialogs"],
          ["@composables", "./src/composables"],
        ],
      },
    },
  },
}
