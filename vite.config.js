import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
            css: {
                preprocessorOptions: {
                    scss: {
                        additionalData: `@import "./src/styles/global.scss";`,
                    },
                },
            },
        }),
        vue(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources'),
            '@css': path.resolve(__dirname, 'resources/css'),
            'tinymce': path.resolve(__dirname, 'node_modules/tinymce'),  // ✅ Add TinyMCE alias
        },
    },
    build: {
        rollupOptions: {
            external: ['tinymce'],  // ✅ Prevent TinyMCE from being bundled incorrectly
        },
    },
    optimizeDeps: {
      exclude: ['tinymce'],
    },
});
