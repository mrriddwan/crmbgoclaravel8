import Alpine from "alpinejs";
import router from "./routes";
import { createApp } from "vue";
/*third party package */
import LaravelVuePagination from "laravel-vue-pagination";
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import JsonExcel from "vue-json-excel3";
import laravelPermissionToVuejs from "laravel-permission-to-vuejs";
import vSelect from "vue-select";
// import VuePdfEmbed from 'vue-pdf-embed'
// window.$ = window.jQuery = require('jquery')

import Contact_Index from "../components/contacts/ContactIndex.vue";
import ProjectIndex from "../components/projects/ProjectIndex.vue";
import moment from "moment";

//bootstrap
import "./bootstrap";
import "../css///bootstrapGlobal.css";
import "vue-select/dist/vue-select.css";

window.Alpine = Alpine;
Alpine.start();

const app = createApp({});


app.component("Pagination", LaravelVuePagination);
app.component('VueDatePicker', Datepicker);
// app.component("contact-index", Contact_Index);
// app.component("project_index", ProjectIndex);

app.component("downloadExcel", JsonExcel);
app.component("v-select", vSelect);
// app.component("vue-pdf-embed", VuePdfEmbed);

app.use(laravelPermissionToVuejs)
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

