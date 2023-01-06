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
            <div class="mx-3">
                <button class="my-auto px-2 py-2 bg-green-500 rounded-md">
                    Download PDF
                </button>
            </div>

            <!-- download="file.xlsx" -->
            <!-- <div>
                <a
                    class="px-2 py-2 align-bottom text-center bg-blue-400 border-black border-2 rounded-md text-xs"
                    type="button"
                    href="/api/admin/tutorial/download"
                >
                    <button class="h-1">
                        <p
                            class="inline-block text-black uppercase font-extrabold"
                        >
                            Download
                        </p>
                    </button>
                </a>
            </div> -->
        </div>

        <div>
            <!-- <h1>File</h1> -->
            <vue-pdf-embed :source="source" class="mx-auto" />
            <!-- <vue-pdf-embed v-if="view_tutorial === 'data'" :source="source_data" class="mx-auto" />
            <vue-pdf-embed v-if="view_tutorial === 'manage'" :source="source_manage" class="mx-auto" />
            <vue-pdf-embed v-if="view_tutorial === 'access'" :source="source_access" class="mx-auto" />
            <vue-pdf-embed v-if="view_tutorial === 'export_import'" :source="source_export_import" class="mx-auto" /> -->
        </div>
    </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import moment from "moment";
import VuePdfEmbed from "vue-pdf-embed";

import {
    PencilSquareIcon,
    PencilIcon,
    TrashIcon,
    PlusIcon,
    UserPlusIcon,
    DocumentChartBarIcon,
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
    ArrowUpIcon,
    ArrowDownIcon,
    QuestionMarkCircleIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        Pagination: LaravelVuePagination,
        PencilSquareIcon,
        TrashIcon,
        PlusIcon,
        UserPlusIcon,
        DocumentChartBarIcon,
        PencilIcon,
        ArrowTopRightOnSquareIcon,
        ArrowsUpDownIcon,
        ArrowUpIcon,
        ArrowDownIcon,
        QuestionMarkCircleIcon,
        VuePdfEmbed,
    },

    mounted() {
        this.source = this.source_data;
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

            view_tutorial: "data",
        };
    },
    watch: {
        view_tutorial: function (value) {
            value === "data"
                ? (this.source = this.source_data)
                : value === "announcement"
                ? (this.source = this.source_announcement)
                : value === "manage"
                ? (this.source = this.source_manage)
                : value === "access"
                ? (this.source = this.source_access)
                : (this.source = this.source_export_import);
        },
    },

    methods: {},
};
</script>
