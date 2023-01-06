<template>
    <div class="">
        <h1
            class="items-center text-center text-6xl text-white font-extrabold bg-orange-500 px-96 rounded-md"
        >
            Tutorial: Forecast
        </h1>

        <div class="flex">
            <!-- <div
                class="py-2 px-2"
                v-if="can('export project') || is('admin | super-admin')"
            >
                <download-excel
                    :data="projects.data"
                    :fields="project_fields"
                    worksheet="ProjectSummary"
                    name="Project Summary.xls"
                    class="btn btn-success btn-sm"
                >
                    <ArrowTopRightOnSquareIcon
                        class="h-5 w-5 mr-1 inline-block"
                    />
                    Export
                </download-excel>
            </div> -->
        </div>

        <div>
            <!-- <h1>File</h1> -->
            <vue-pdf-embed :source="source1" class="mx-auto" />
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
        // this.getProjects();
    },
    data() {
        return {
            source1: "/storage/tutorials/13_forecast.pdf",
        };
    },
    watch: {},

    methods: {},
};
</script>
