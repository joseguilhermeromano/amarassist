import "./bootstrap";
import $ from "jquery";
window.$ = window.jQuery = $;
import "materialize-css/dist/js/materialize.min.js";
import "materialize-css/dist/css/materialize.min.css";
import "@fortawesome/fontawesome-free/css/all.min.css";
import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

createInertiaApp({
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) }).use(plugin);

        const user = props.initialPage.props.auth?.user;

        if (!user && window.location.pathname !== "/") {
            Inertia.visit("/");
            return;
        }

        app.mount(el);
    },
});
