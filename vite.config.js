import { defineConfig } from "vite";
import { createRequire } from "node:module";
const require = createRequire(import.meta.url);
import path from "path";

import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import ckeditor5 from "@ckeditor/vite-plugin-ckeditor5";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
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
        ckeditor5({
            theme: require.resolve("@ckeditor/ckeditor5-theme-lark"),
        }),
    ],
    resolve: {
        alias: {
            vue: "vue/dist/vue.esm-bundler.js",
            "@": path.resolve(__dirname, "./resources"),
            "@components": path.resolve(__dirname, "./resources/js/components"),
            "@pages": path.resolve(__dirname, "./resources/js/pages"),
        },
    },
    test: {
        // enable jest-like global test APIs
        globals: true,
        // simulate DOM with happy-dom
        // (requires installing happy-dom as a peer dependency)
        environment: "happy-dom",
    },
});
