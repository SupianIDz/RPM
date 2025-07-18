import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/theme/main.css',
            ],
            refresh: true,
        }),
    ],
});
