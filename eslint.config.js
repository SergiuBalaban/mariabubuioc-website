import js from '@eslint/js';
import tsParser from '@typescript-eslint/parser';
import pluginVue from 'eslint-plugin-vue';
import { defineConfig } from 'eslint/config';
import globals from 'globals';
import vueParser from 'vue-eslint-parser';

export default defineConfig([
    {
        files: ['**/*.{js,mjs,cjs,vue}'],
        plugins: { js },
        extends: ['js/recommended'],
        languageOptions: {
            globals: globals.browser,
            parser: vueParser,
            parserOptions: {
                parser: tsParser,
                ecmaVersion: 'latest',
                sourceType: 'module',
            },
        },
    },
    pluginVue.configs['flat/essential'],
]);
