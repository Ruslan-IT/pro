import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        host: '14mvgifts.local', // Указываем ваш домен
        cors: true, // Включаем CORS
        hmr: {
            host: '14mvgifts.local' // Для Hot Module Replacement
        }
    },
    plugins: [
        laravel([
            'resources/js/app.js',
        ]),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
});
