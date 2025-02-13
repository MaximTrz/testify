import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import reactRefresh from "@vitejs/plugin-react-refresh";

import mdx from "@mdx-js/rollup";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/main.tsx"],
            refresh: true,
        }),
        { enforce: "pre", ...mdx() },
        reactRefresh(),
    ],
    optimizeDeps: {
        force: true,
        esbuildOptions: {
            loader: {
                ".ts": "tsx",
            },
        },
    },
});
