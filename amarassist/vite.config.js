import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/app.js"],
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
    ],
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "resources"),
        },
    },
    server: {
        port: 3000,
        host: "0.0.0.0",
        hmr: {
            host: "localhost",
        },
        cors: {
            origin: "http://localhost",
            credentials: true,
        },
        strictPort: true,
        watch: {
            usePolling: true,
        },
    },
});
