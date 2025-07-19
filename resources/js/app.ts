import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';
import { i18nVue } from 'laravel-vue-i18n';
import * as Sentry from "@sentry/vue";

// Extend ImportMeta interface for Vite...
declare module 'vite/client' {
    interface ImportMetaEnv {
        readonly VITE_APP_NAME: string;
        [key: string]: string | boolean | undefined;
    }

    interface ImportMeta {
        readonly env: ImportMetaEnv;
        readonly glob: <T>(pattern: string) => Record<string, () => Promise<T>>;
    }
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
        ;

        Sentry.init({
            app,
            dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
            environment: import.meta.env.VITE_APP_ENV,
            tracesSampleRate: 1.0,
            profilesSampleRate: 1.0,
            trackComponents: false,
            logErrors: true,
            integrations: [Sentry.browserTracingIntegration()],
        });

        if (props.initialPage.props?.auth.user) {
            // もしログインしてたらユーザーIDをセットする
            Sentry.setUser({ id: props.initialPage.props?.auth.user.id });
        }

        app.use(i18nVue, {
            resolve: async (lang: string) => {
                const langs = import.meta.glob('../../lang/*.json');
                return await langs[`../../lang/${lang}.json`]();
            },
            onLoad: () => { /* mount app after language is loaded */
                if (el && el.__vue_app__) /* check needed to avoid remounting (which would fail) when we call loadLanguageAsync to change language */
                    return;
                app.mount(el);
            }
        });
        // app.mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
