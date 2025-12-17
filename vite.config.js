import { defineConfig, loadEnv } from "vite";
import laravel from "laravel-vite-plugin";
import vue from "@vitejs/plugin-vue";
import vueDevTools from "vite-plugin-vue-devtools";

export default defineConfig(({ mode }) => {
    // Use ASSET_URL (e.g. https://storytime.is-great.net/public) so built chunk
    // URLs include the subdirectory and don't resolve to /build on hosts like InfinityFree.
    const env = loadEnv(mode, process.cwd(), "");
    const assetUrl = env.ASSET_URL?.replace(/\/+$/, "");
    // Ensure built assets resolve to /build/... under the ASSET_URL base.
    const base = assetUrl ? `${assetUrl}/build/` : "/build/";

    return {
        base,
        plugins: [
            laravel({
                input: "resources/js/app.js",
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
            vueDevTools({ appendTo: "resources/js/app.js" }),
        ],
    };
});
