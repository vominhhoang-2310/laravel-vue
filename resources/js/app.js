import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createI18nInstance } from './i18n';

createInertiaApp({
    title: (title) => `${title} - Story Time`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const initialLocale = props.initialPage?.props?.locale?.current ?? 'en';
        const i18n = createI18nInstance(initialLocale);
        const syncLocale = (pageProps) => {
            const next = pageProps?.props?.locale?.current;
            if (next && i18n.global.locale.value !== next) {
                i18n.global.locale.value = next;
            }
        };

        return createApp({ render: () => h(App, props) })
            .mixin({
                created() {
                    syncLocale(this.$page);
                },
                watch: {
                    '$page.props.locale.current'(val) {
                        if (val) {
                            syncLocale({ props: { locale: { current: val } } });
                        }
                    },
                },
            })
            .use(plugin)
            .use(i18n)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
