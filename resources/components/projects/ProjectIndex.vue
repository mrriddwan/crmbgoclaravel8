<template>
    <h1
        class="items-center text-center text-6xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
    >
        Project List
    </h1>

    <div class="py-2">
            <router-link
                to="/project/create"
                class="inline-block items-center px-2 py-1 align-top bg-blue-800 border border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            >
                <PlusIcon class="inline h-6 w-6 mr-1" />
                Project</router-link
            >
    </div>
    <div class="grid grid-cols-2">
        <div class="grid grid-cols-2 items-center align-middle w-max">
            <label for="paginate" class="px-2 inline-block">Entries</label>
            <select v-model="paginate" class="form-control inline-block">
                <option value="10">10</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <label for="paginate" class="px-2 inline-block">of 100</label>
        </div>
        <div class="py-2">
            <input
                v-model.lazy="search"
                type="search"
                class="form-control"
                placeholder="Search by any..."
            />
        </div>
    </div>
    <div class="mt-1">
        <Pagination
            :data="projects"
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
                <thead class="bg-slate-400 border-b sticky top-0">
                    <tr>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a href="#" @click.prevent=""> # </a>
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
                                >
                                    Project<br />Start Date
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'project_startdate'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'project_startdate'
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
                                        change_sort('project_enddate')
                                    "
                                >
                                    Project<br />End Date
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'project_enddate'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'project_enddate'
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
                                        change_sort('project_duration')
                                    "
                                >
                                    Duration
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'project_duration'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'project_duration'
                                    "
                                    >&darr;</span
                                >
                            </div>
                        </th>

                        <th class="py-3">
                            <div class="text-sm text-center h-6 w-full">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('contact_name')"
                                >
                                    Company
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'contact_name'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'contact_name'
                                    "
                                    >&darr;</span
                                >
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a href="#" @click.prevent=""> Project </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'project_name'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'project_name'
                                    "
                                    >&darr;</span
                                >
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a href="#" @click.prevent=""> Remark </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'project_remark'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'project_remark'
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
                                        change_sort('updated_at')
                                    "
                                >
                                    Entry<br />Date
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'updated_at'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'updated_at'
                                    "
                                    >&darr;</span
                                >
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">Action</div>
                        </th>
                    </tr>
                </thead>
                <tbody class="mt-2">
                    <tr
                        v-for="(project, index) in projects.data"
                        :key="project.id"
                    >
                        <td class="text-xs">{{ index + 1 }}</td>
                        <td class="text-xs">
                            {{ project.project_startdate }}
                        </td>
                        <td class="text-xs">
                            {{ project.project_enddate }}
                        </td>
                        <td class="text-xs">
                            <!-- {{ project.project_enddate }} -->
                            Duration: 0 days
                        </td>
                        <td class="text-xs grid-cols-2 w-max">
                            <router-link
                                class="mr-2"
                                :to="`/contact/${project.contact.id}/info`"
                                custom
                                v-slot="{ navigate, href }"
                            >
                                <a :href="href" @click.stop="navigate">{{
                                    project.contact.name
                                }}</a>
                            </router-link>
                        </td>
                        <td class="text-xs">{{ project.project_name }}</td>
                        <td class="text-xs">{{ project.project_remark }}</td>
                        <td class="text-xs">{{ project.updated_at }}</td>
                        
                        <td class="text-xs">
                            <router-link
                                :to="{
                                    name: 'todo_insert',
                                    params: { id: project.contact.id },
                                }"
                                class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                            <PlusIcon class="h-5 w-5 mr-1"/> To Do</router-link
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
    </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import moment from "moment";
import {
    PencilSquareIcon,
    PencilIcon,
    TrashIcon,
    PlusIcon,
    UserPlusIcon,
    DocumentChartBarIcon,
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
    },

    mounted() {
        this.getProjects();
    },
    data() {
        return {
            projects: [],
            paginate: 50,

            search: "",
            searchStartDate: "",
            searchEndDate: "",
            searchDuration: "",
            searchEntryDate: "",

            sort_direction: "desc",
            sort_field: "project_startdate",

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
        getProjects(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/projects/index?" +
                        "q=" +
                        this.search +
                        "&filterResult=" +
                        this.filterResult +
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

    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
