<template>
    <div class="container">
        <h1
            class="items-center text-center text-6xl text-white font-extrabold bg-blue-900 px-2 rounded-md"
        >
            Project List
        </h1>

        <div class="flex">
            <div class="py-2 px-2">
                <router-link
                    to="/project/create"
                    class="inline-block items-center px-2 py-1 align-top bg-blue-800 border border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    <PlusIcon class="inline h-6 w-6 mr-1" />
                    Project</router-link
                >
            </div>
            <div
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
            </div>
        </div>

        <div class="grid grid-cols-2">
            <div class="grid grid-cols-2 items-center align-middle w-max">
                <label for="paginate" class="px-2 inline-block">Per page</label>
                <input v-model.lazy="paginate" class="form-control" />
                <!-- <select v-model="paginate" class="form-control">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> -->
                <!-- <label for="paginate" class="px-2 inline-block">of 100</label> -->
            </div>
            <div class="py-2">
                <input
                    v-model.lazy="search"
                    type="search"
                    class="form-control"
                    placeholder="Search + Press ENTER"
                />
            </div>
        </div>
        <div class="mt-1">
            <Pagination
                :data="projects"
                :limit="2"
                @pagination-change-page="getProjects"
                :size="'small'"
                :align="'center'"
                class="pagination"
            />
        </div>
        <div>
            <div
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto"
            >
                <table class="table table-hover w-full mt-0">
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white"
                                    >
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == ''
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == ''
                                        "
                                        >&darr;</span
                                    >
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('project_startdate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Project <br />
                                        Start Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'project_startdate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'project_startdate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'project_startdate'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('project_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Project <br />
                                        End Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'project_enddate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_enddate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_enddate'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('project_duration')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Duration
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'project_duration'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_duration'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_duration'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6 w-full">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('contact_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Company
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'contact_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'contact_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'contact_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('project_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Project
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'project_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('updated_at')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Entry <br />
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'updated_at')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'updated_at'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'updated_at'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6 text-white">
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr v-show="buffering">
                            <td
                                class="text-center text-sm font-bold"
                                colspan="13"
                            >
                                Loading . .
                            </td>
                        </tr>
                        <tr
                            v-for="(project, index) in projects.data"
                            :key="project.id"
                        >
                            <td class="text-xs">{{ index + 1 }}</td>
                            <td class="text-xs">
                                {{ showToday(project.project_startdate) }}
                            </td>
                            <td class="text-xs">
                                {{ showToday(project.project_enddate) }}
                            </td>
                            <td class="text-xs">
                                <!-- {{ project.project_enddate }} -->
                                {{
                                    calculateDuration(
                                        project.project_startdate,
                                        project.project_enddate
                                    )
                                }}
                                day(s)
                            </td>
                            <td class="text-xs grid-cols-2 w-max">
                                <router-link
                                    :to="`/contact/${project.contact.id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        project.contact.name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="text-xs w-72">
                                {{ project.project_name }}
                            </td>
                            <td class="text-xs">
                                {{ project.project_remark }}
                                <button
                                    @click="toggleRemark(project.id)"
                                    class="align-middle border-1 border-black w-max rounded-md px-1"
                                >
                                    <QuestionMarkCircleIcon
                                        class="inline h-4 w-4"
                                    />
                                </button>
                            </td>
                            <td class="text-xs">
                                {{ showToday(project.created_at) }}
                            </td>

                            <td class="text-xs">
                                <router-link
                                    :to="{
                                        name: 'todo_insert',
                                        params: { id: project.contact.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PlusIcon class="h-5 w-5 mr-1" /> To
                                    Do</router-link
                                >
                                <router-link
                                    :to="{
                                        name: 'project_edit',
                                        params: {
                                            id: project.id,
                                        },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="deleteProject(project.id)"
                                >
                                    <TrashIcon class="h-3 w-3" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <ProjectRemarkModalVue
                v-if="project_remark_visibility"
                @toggle-modal="toggleRemark(project_id)"
                :project_id="project_remark"
            />
        </div>
    </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import moment from "moment";
import ProjectRemarkModalVue from "./ProjectRemarkModal.vue";
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
        ProjectRemarkModalVue,
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
    },

    mounted() {
        this.getProjects();
    },
    data() {
        return {
            projects: [],
            paginate: 100,

            search: "",
            searchStartDate: "",
            searchEndDate: "",
            searchDuration: "",
            searchEntryDate: "",

            sort_direction: "desc",
            sort_field: "project_startdate",
            project_remark_visibility: false,
            project_remark: null,
            buffering: false,

            project_fields: {
                CS: {
                    callback: (value) => {
                        return `${value.user.name}`;
                    },
                },
                "Start Date": "project_startdate",
                "End Date": "project_enddate",
                // Duration: "user_name",
                Company: {
                    callback: (value) => {
                        return `${value.contact.name}`;
                    },
                },
                Project: "project_name",
                Remark: "project_remark",
                "Entry Date": "updated_at",
            },
        };
    },
    watch: {
        paginate: function (value) {
            this.getProjects();
        },
        search: function (value) {
            this.getProjects();
        },
        searchStartDate: function (value) {
            this.getProjects();
        },
        searchEndDate: function (value) {
            this.getProjects();
        },
        searchDuration: function (value) {
            this.getProjects();
        },
        searchEntryDate: function (value) {
            this.getProjects();
        },
    },

    methods: {
        toggleRemark(project_id) {
            this.project_remark = project_id;
            this.project_remark_visibility = !this.project_remark_visibility;
        },

        getProjects(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            this.buffering = true;
            axios
                .get(
                    "/api/projects/index?" +
                        "q=" +
                        this.search +
                        "&paginate=" +
                        this.paginate +
                        "&page=" +
                        page +
                        "&sort_direction=" +
                        this.sort_direction +
                        "&sort_field=" +
                        this.sort_field
                )
                .then((res) => {
                    this.buffering = false;
                    this.projects = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        change_sort(field) {
            if (this.sort_field == field) {
                this.sort_direction =
                    this.sort_direction == "asc" ? "desc" : "asc";
            } else {
                this.sort_field = field;
            }
            this.getProjects();
        },

        deleteProject(id) {
            if (!window.confirm("Confirm delete?")) {
                return;
            }
            axios.delete("/api/projects/delete/" + id);
            this.getProjects();
        },

        calculateDuration(start_date, end_date) {
            let start = new Date(start_date).getTime();
            let end = new Date(end_date).getTime();

            const day_diff = (end - start) / (1000 * 3600 * 24);
            // console.log('start date', start)
            // console.log('end date', end)

            // return moment((end - start)).format("D");
            return day_diff;
        },

        showToday(date) {
            // let new_date = new Date(date)
            let day = moment(date).format("DD-MM-YY");
            return day;
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
