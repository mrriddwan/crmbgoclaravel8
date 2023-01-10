<template>
    <div class="">
        <h1
            class="items-center text-center text-6xl text-white font-extrabold bg-orange-500 px-48 rounded-md"
        >
            Tutorial: Billboard & Tempboard
        </h1>

        <div class="flex my-2">
            <a
                class="align-bottom py-2 px-2 text-center bg-green-400 text-slate-700 border-black border-2 rounded-md text-xs flex"
                type="button"
                :href="'/api/admin/tutorial/download/' + 6"
            >
                <ArrowDownTrayIcon class="w-5 h-5" />
                <p
                    class="ml-2 uppercase font-mono font-semibold my-auto text-lg"
                >
                    PDF
                </p>
            </a>
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
    ArrowDownTrayIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        ArrowDownTrayIcon,
        VuePdfEmbed,
    },

    mounted() {
        // this.getProjects();
    },
    data() {
        return {
            source1: "/storage/tutorials/6_billboard_tempboard.pdf",
        };
    },
    watch: {},

    methods: {},
};
</script>
