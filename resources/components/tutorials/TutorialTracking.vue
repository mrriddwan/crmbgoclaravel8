<template>
    <div class="">
        <h1
            class="items-center text-center text-6xl text-white font-extrabold bg-orange-500 px-96 rounded-md"
        >
            Tutorial: Tracking
        </h1>

        <div class="flex">
            <div>
                <a
                    class="px-2 py-2 align-bottom text-center bg-blue-400 border-black border-2 rounded-md text-xs"
                    type="button"
                    href="/api/admin/tutorial/download"
                >
                    <button class="mx-2">Download PDF</button>
                </a>
                <!-- <button
                    class="mx-2 px-2 py-2 text-center bg-blue-400 border-black border-2 rounded-md text-xs"
                    @click="downloadFile"
                >
                    Download PDF
                </button> -->
            </div>
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
            source1: "/storage/tutorials/7_tracking_general_travelguide.pdf",
        };
    },
    watch: {},

    methods: {},
};
</script>
