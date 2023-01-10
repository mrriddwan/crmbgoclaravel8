<template>
    <div class="pb-96">
        <h1
            class="items-center text-center text-6xl text-white font-extrabold bg-orange-500 px-96 rounded-md"
        >
            Tutorial: Admin
        </h1>

        <div class="flex my-2">
            <div>
                <select class="form-control" v-model="view_tutorial">
                    <option value="">Select tutorial</option>
                    <option value="announcement">Announcement</option>
                    <option value="data">Data</option>
                    <option value="manage">User Management</option>
                    <option value="access">User Access</option>
                    <option value="export_import">Export/Import</option>
                </select>
            </div>
            <div class="flex mx-2">
                <a
                    class="align-bottom py-2 px-2 text-center bg-green-400 text-slate-700 border-black border-2 rounded-md text-xs flex"
                    type="button"
                    :href="'/api/admin/tutorial/download/' + url"
                >
                    <ArrowDownTrayIcon class="w-5 h-5 my-auto" />
                    <p
                        class="ml-2 uppercase font-mono font-semibold my-auto text-lg"
                    >
                        PDF
                    </p>
                </a>
            </div>
        </div>

        <div>
            <vue-pdf-embed :source="source" class="mx-auto" />
        </div>
    </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import moment from "moment";
import VuePdfEmbed from "vue-pdf-embed";

import {
    ArrowDownTrayIcon
} from "@heroicons/vue/24/solid";

export default {
    components: {
        ArrowDownTrayIcon,
        VuePdfEmbed,
    },

    mounted() {
        this.source = this.source_data;
        this.url = 8;
    },
    data() {
        return {
            source_announcement: "/storage/tutorials/10_admin_announcement.pdf",
            source_data: "/storage/tutorials/8_admin_data.pdf",
            source_manage: "/storage/tutorials/9_admin_user_manage.pdf",
            source_access: "/storage/tutorials/12_admin_access.pdf",
            source_export_import:
                "/storage/tutorials/11_admin_export_import.pdf",

            source: "",
            url: "",

            view_tutorial: "data",
        };
    },
    watch: {
        view_tutorial: function (value) {
            if (value === "data") {
                this.source = this.source_data;
                this.url = 8;
            } else if (value === "announcement") {
                this.source = this.source_announcement;
                this.url = 10;
            } else if (value === "manage") {
                this.source = this.source_manage;
                this.url = 9;
            } else if (value === "access") {
                this.source = this.source_access;
                this.url = 12;
            } else {
                this.source = this.source_export_import;
                this.url = 11;
            }
        },
    },

    methods: {

    },
};
</script>
