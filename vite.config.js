import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        host: "0.0.0.0",
        cors: true,
        proxy: {
            "^/(?!@vite|resources|node_modules)": {
                target: "http://127.0.0.1:8000",
                changeOrigin: true,
            },
        },
        hmr: {
            host: "76lsqshz-5173.asse.devtunnels.ms",
            protocol: "wss",
            clientPort: 443,
        },
    },
});
