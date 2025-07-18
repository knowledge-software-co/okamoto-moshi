import vue from '@vitejs/plugin-vue';
import autoprefixer from 'autoprefixer';
import laravel from 'laravel-vite-plugin';
import i18n from 'laravel-vue-i18n/vite';
import fs from 'node:fs';
import { resolve } from 'node:path';
import path from 'path';
import tailwindcss from 'tailwindcss';
import { defineConfig, loadEnv } from 'vite';

const isProduction = process.env.NODE_ENV === 'production';

export default defineConfig({
    ...(isProduction
        ? []
        : {
              server: {
                  https: {
                      key: fs.existsSync('certs/domain.key') ? fs.readFileSync('certs/domain.key') : undefined,
                      cert: fs.existsSync('certs/signed.crt') ? fs.readFileSync('certs/signed.crt') : undefined,
                  },
                  // host: '0.0.0.0', // default
                  hmr: {
                      clientPort: 5173,
                      host:
                          process.env.VITE_USER_NODE_ENV === 'dusk'
                              ? loadEnv(process.env.VITE_USER_NODE_ENV, process.cwd(), '').APP_SERVICE
                              : 'localhost',
                  },
                  watch: {
                      usePolling: true,
                      ignored: ['**/vendor/**'],
                  },
              },
          }),
    plugins: [
        laravel({
            input: ['resources/js/app.ts'],
            ssr: 'resources/js/ssr.ts',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        i18n(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, './resources/js'),
            'ziggy-js': resolve(__dirname, 'vendor/tightenco/ziggy'),
        },
    },
    css: {
        postcss: {
            plugins: [tailwindcss, autoprefixer],
        },
    },
});
