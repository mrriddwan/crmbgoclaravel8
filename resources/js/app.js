import Alpine from "alpinejs";
import router from "./routes";
import { createApp } from "vue";
/*third party package */
import LaravelVuePagination from "laravel-vue-pagination";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import JsonExcel from "vue-json-excel3";

// window.$ = window.jQuery = require('jquery')



import ContactIndex from "../components/contacts/ContactIndex.vue";
import moment from "moment";

//bootstrap
import "./bootstrap";
import "../css///bootstrapGlobal.css";

window.Alpine = Alpine;
Alpine.start();

const app = createApp({});


app.component("Pagination", LaravelVuePagination);
app.component('VueDatePicker', Datepicker);
app.component("contact-index", ContactIndex);
app.component("downloadExcel", JsonExcel);


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

