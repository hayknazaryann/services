import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import path from 'path'

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources/js'),
            '@images': path.resolve(__dirname, 'resources/img'),
            '@client': path.resolve(__dirname, 'resources/js/views/client'),
        }
    },
});
