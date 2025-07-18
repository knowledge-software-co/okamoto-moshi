import { FlatCompat } from '@eslint/eslintrc';
import eslint from '@eslint/js';
import eslintConfigPrettier from 'eslint-config-prettier/flat';
import globals from 'globals';
import { fileURLToPath } from 'node:url';
import { dirname } from 'pathe';
import tsEslint from 'typescript-eslint';

const eslintrc = new FlatCompat({
    baseDirectory: dirname(fileURLToPath(import.meta.url)),
});

export default [
    eslint.configs.recommended, // eslint:recommended を継承
    ...tsEslint.configs.recommended,
    ...eslintrc.extends('plugin:vue/recommended', 'prettier'),
    eslintConfigPrettier, // Prettierの設定を直接インポートして使用
    {
        files: ['resources/**/*.{js,ts,vue}'],
    },
    {
        ignores: [
            '.schemaspy/*',
            'docker/*',
            'certs/*',
            'resources/js/tests/coverage/*',

            'resources/js/components/InertiaTable/*',

            'resources/js/types/globals.d.ts',
            'resources/js/types/ziggy.d.ts',
            'resources/js/types/index.d.ts',
            'resources/js/composables/useInitials.ts',
            'resources/js/composables/useAppearance.ts',
            'resources/js/app.ts',
            'resources/js/tests/pages/welcome.test.js',
            'resources/js/components/ui/*',
            'resources/js/components/AppSidebarHeader.vue',
            'resources/js/components/AppearanceTabs.vue',
            'resources/js/components/AppLogo.vue',
            'resources/js/components/PlaceholderPattern.vue',
            'resources/js/components/NavUser.vue',
            'resources/js/components/AppContent.vue',
            'resources/js/components/DeleteUser.vue',
            'resources/js/components/Icon.vue',
            'resources/js/components/AppShell.vue',
            'resources/js/components/Breadcrumbs.vue',
            'resources/js/components/NavMain.vue',
            'resources/js/components/Heading.vue',
            'resources/js/components/AppLogoIcon.vue',
            'resources/js/components/NavFooter.vue',
            'resources/js/components/AppHeader.vue',
            'resources/js/components/HeadingSmall.vue',
            'resources/js/components/AppSidebar.vue',
            'resources/js/components/UserInfo.vue',
            'resources/js/components/UserMenuContent.vue',
            'resources/js/components/TextLink.vue',
            'resources/js/components/InputError.vue',
            'resources/js/layouts/settings/Layout.vue',
            'resources/js/layouts/AuthLayout.vue',
            'resources/js/layouts/app/AppSidebarLayout.vue',
            'resources/js/layouts/app/AppHeaderLayout.vue',
            'resources/js/layouts/auth/AuthSimpleLayout.vue',
            'resources/js/layouts/auth/AuthSplitLayout.vue',
            'resources/js/layouts/auth/AuthCardLayout.vue',
            // 'resources/js/layouts/AppLayout.vue',
            'resources/js/lib/utils.ts',
            'resources/js/pages/settings/Profile.vue',
            'resources/js/pages/settings/Password.vue',
            'resources/js/pages/settings/Appearance.vue',
            // 'resources/js/pages/Dashboard.vue',
            'resources/js/pages/auth/Login.vue',
            'resources/js/pages/auth/Register.vue',
            'resources/js/pages/auth/ResetPassword.vue',
            'resources/js/pages/auth/ConfirmPassword.vue',
            'resources/js/pages/auth/ForgotPassword.vue',
            'resources/js/pages/auth/VerifyEmail.vue',
            // 'resources/js/pages/Welcome.vue',
            'resources/js/ssr.ts',
        ],
    },
    {
        // files なしで設定を書くことで、全てのファイルに適用される

        languageOptions: {
            globals: {
                ...globals.browser,
                ...globals.node,
                route: true,
                axios: true,
            },
            parserOptions: {
                parser: '@typescript-eslint/parser',
            },
        },
        rules: {
            // override/add rules settings here, such as:

            // ignorePatternに合致する未使用変数があってもエラーにしない
            'vue/no-unused-vars': [
                'error',
                {
                    ignorePattern: '^_',
                },
            ],
            'vue/require-default-prop': 'off',
            'vue/multi-word-component-names': 'off',
            'vue/no-multiple-template-root': 'off',
            camelcase: ['error', { properties: 'never' }],
        },
    },
];
