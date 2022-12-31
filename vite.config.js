import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/css/editor-styles.css',
                'resources/js/app.js',
                'resources/js/ckeditor.conf.js',
            ],
            refresh: false,
        }),
    ],

});
