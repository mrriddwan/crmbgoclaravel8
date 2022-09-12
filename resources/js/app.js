import Alpine from "alpinejs";
import router from "./routes";
import { createApp } from "vue";

import LaravelVuePagination from "laravel-vue-pagination";
import ContactIndex from "../components/contacts/ContactIndex.vue";
import moment from "moment";

//bootstrap
import "./bootstrap";
import "../css///bootstrapGlobal.css";

window.Alpine = Alpine;
Alpine.start();

const app = createApp({});

app.component("Pagination", LaravelVuePagination);
app.component("contact-index", ContactIndex);
app.use(router);
app.config.globalProperties.$moment = {
    formNow(date) {
        return moment(date).fromNow();
    },
    calendar(date) {
        return moment(date).calendar();
    },
};
app.mount("#app");

