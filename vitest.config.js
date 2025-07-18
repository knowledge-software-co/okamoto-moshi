import { mergeConfig } from 'vite';
import { defineConfig } from "vitest/config";
// import Vue from "@vitejs/plugin-vue";
import path from 'path';
import viteConfig from './vite.config';

export default mergeConfig(
    viteConfig,
    defineConfig({
        // plugins: [Vue()],
        test: {
            globals: true,
            environment: "jsdom",
            coverage: {
                reporter: ['text', 'json', 'html'],
            },
        },

        root: path.resolve('resources/js/tests'),

        resolve: {
            alias: {
                '@': path.resolve('resources/js'),
                'ziggy-js': path.resolve('vendor/tightenco/ziggy'),
            },
        }
    })
);
