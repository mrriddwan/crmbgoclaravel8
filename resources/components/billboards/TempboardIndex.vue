<template>
    <div class="w-max">
        <h1
            class="items-center text-center text-4xl text-white font-extrabold font-mono uppercase bg-slate-400 px-2 rounded-md"
        >
            Tempboard Summary
        </h1>

        <div class="">
            <div class="grid grid-cols-4 items-center">
                <!-- <div class="grid grid-cols-1 items-left m-2">
                    <label for="paginate" class="">Per Page</label>
                    <select v-model="paginate" class="form-control">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div> -->
                <div class="items-center">
                    <router-link
                        to="/tempboard/create"
                        class="inline-block items-center px-2 py-1 align-top bg-blue-800 border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="inline h-6 w-6 mr-1" />
                        Tempboard</router-link
                    >
                </div>
                <div class="grid grid-cols-1 items-left m-2">
                    <label>Year</label>
                    <input
                        v-model.lazy="selectedYear"
                        type="search"
                        class="form-control"
                        placeholder="Search by any..."
                    />
                </div>
                <div class="grid grid-cols-1 items-left m-2">
                    <label>Search in table</label>
                    <input
                        v-model.lazy="search"
                        type="search"
                        class="form-control"
                        placeholder="Search by any..."
                    />
                </div>

                <div class="grid grid-cols-2 break-normal text-xs">
                    <div class="bg-blue-700 rounded-md w-max px-2 py-2">
                        <button @click="getTempboards" class="text-white">
                            Find Records
                        </button>
                    </div>
                    <div>
                        <!-- <download-excel
                            :data="tempboards.data"
                            :fields="forecast_fields"
                            worksheet="ForecastSummary"
                            name="Forecast Summary.xls"
                            class="btn btn-success btn-sm"
                        >
                            <ArrowTopRightOnSquareIcon
                                class="h-5 w-5 mr-1 inline-block"
                            />
                            Export
                        </download-excel> -->
                    </div>
                </div>
                <div class="py-1 inline-block">
                    <Pagination
                        :data="tempboards"
                        @pagination-change-page="getTempboards"
                        :size="'small'"
                        :align="'right'"
                        class="pagination"
                    />
                </div>
            </div>

            <div class="block max-h-screen overflow-y-auto overflow-x-auto">
                <table
                    class="table table-hover table-bordered w-max"
                    id="summary_table"
                >
                    <thead class="bg-slate-400 border-b sticky top-0">
                        <tr class="w-full">
                            <th class="w-10">
                                <div class="text-xs text-center h-6 text-white">
                                    No.
                                </div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_entrydate')
                                        "
                                        class="text-white"
                                    >
                                        Date<br />Entry
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'tpboard_entrydate'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'tpboard_entrydate'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-20">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('user_name')
                                        "
                                        class="text-white"
                                    >
                                        CS
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'user_name'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'user_name'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                >
                                    <select
                                        v-model="selectedUser"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="user in users.data"
                                            :key="user.id"
                                            :value="user.id"
                                        >
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_location')
                                        "
                                        class="text-white"
                                    >
                                        Location
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'tpboard_location'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'tpboard_location'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('contact_name')
                                        "
                                        class="text-white"
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
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_unit')
                                        "
                                        class="text-white"
                                    >
                                        Unit
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'tpboard_unit'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'tpboard_unit'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_size')
                                        "
                                        class="text-white"
                                    >
                                        Size
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'tpboard_size'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'tpboard_size'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_startdate')
                                        "
                                        class="text-white"
                                    >
                                        Date<br />Start
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'tpboard_startdate'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'tpboard_startdate'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_enddate')
                                        "
                                        class="text-white"
                                    >
                                        Date<br />End
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'tpboard_enddate'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'tpboard_enddate'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_collection')
                                        "
                                        class="text-white"
                                    >
                                        Collection
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'tpboard_collection'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'tpboard_collection'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_material')
                                        "
                                        class="text-white"
                                    >
                                        Material
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'tpboard_material'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'tpboard_material'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_printing')
                                        "
                                        class="text-white"
                                    >
                                        Printing
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'tpboard_printing'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'tpboard_printing'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_installation')
                                        "
                                        class="text-white"
                                    >
                                        Installation
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'tpboard_installation'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'tpboard_installation'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_remark')
                                        "
                                        class="text-white"
                                    >
                                        Remark
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'tpboard_remark'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'tpboard_remark'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6"></div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr
                            v-for="(tempboard, index) in tempboards.data"
                            :key="tempboard.id"
                        >
                            <td class="text-xs">{{ index + 1 }}</td>
                            <td class="text-xs w-max">
                                {{ tempboard.tpboard_entrydate }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.user_name }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_location }}
                            </td>
                            <td class="text-xs break-normal">
                                <router-link
                                    :to="`/contact/${tempboard.contact_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        tempboard.contact_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="text-xs w-max">
                                {{ tempboard.tpboard_unit }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_size }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_startdate }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_enddate }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_collection }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_material }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_printing }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_installation }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_remark }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import {
    PencilSquareIcon,
    TrashIcon,
    UserPlusIcon,
    PlusIcon,
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
} from "@heroicons/vue/24/solid";
import moment from "moment";

export default {
    components: {
        Pagination: LaravelVuePagination,
        PencilSquareIcon,
        TrashIcon,
        UserPlusIcon,
        PlusIcon,
        ArrowTopRightOnSquareIcon,
        ArrowsUpDownIcon,
    },

    mounted() {
        this.getSelectedYear(this.getCurrentDate());
        this.getTempboards();
        // this.getBillboardSizes();
        this.getUsers();
    },
    data() {
        return {
            tempboards: [],
            // billboard_sizes: [],
            contacts: [],
            users: [],

            paginate: 50,
            moment: moment,
            // selectPage: false,
            // selectAll: false,
            // checked: [],
            // url: "",

            search: "",
            selectedYear: "",
            selectedSite: "",
            selectedSize: "",
            selectedUser: "",

            sort_direction: "asc",
            sort_field: "id",
            currentDate: "",

            // contact_fields: {
            //     ID: "id",
            //     Company: "name",
            //     Status: "status_name",
            //     Type: "type_name",
            //     User: "user_name",
            //     "Contact Product": "category_name",
            //     Industry: "industry_name",
            //     Jan: {
            //         callback: (value) => {
            //             if (!value.summary[`Jan` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Jan` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Feb: {
            //         callback: (value) => {
            //             if (!value.summary[`Feb` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Feb` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Mar: {
            //         callback: (value) => {
            //             if (!value.summary[`Mar` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Mar` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Apr: {
            //         callback: (value) => {
            //             if (!value.summary[`Apr` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Apr` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     May: {
            //         callback: (value) => {
            //             if (!value.summary[`May` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`May` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Jun: {
            //         callback: (value) => {
            //             if (!value.summary[`Jun` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Jun` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Jul: {
            //         callback: (value) => {
            //             if (!value.summary[`Jul` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Jul` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Aug: {
            //         callback: (value) => {
            //             if (!value.summary[`Aug` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Aug` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Sep: {
            //         callback: (value) => {
            //             if (!value.summary[`Sep` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Sep` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Oct: {
            //         callback: (value) => {
            //             if (!value.summary[`Oct` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Oct` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Nov: {
            //         callback: (value) => {
            //             if (!value.summary[`Nov` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Nov` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Dec: {
            //         callback: (value) => {
            //             if (!value.summary[`Dec` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Dec` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            // },
        };
    },
    watch: {
        paginate: function (value) {
            this.getTempboards();
        },
        search: function (value) {
            this.getTempboards();
        },
        selectedYear: function (value) {
            this.getTempboards();
        },
        // selectedSite: function (value) {
        //     this.getTempboards();
        // },
        // selectedSize: function (value) {
        //     this.getTempboards();
        // },
    },

    computed: {},

    methods: {
        getTempboards(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/tempboard/index?" +
                        "q=" +
                        this.search +
                        "&selectedYear=" +
                        this.selectedYear +
                        "&selectedStatus=" +
                        this.selectedSite +
                        "&selectedSite=" +
                        this.selectedSize +
                        "&selectedSize=" +
                        this.selectedType +
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
                    this.tempboards = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getBillboardSites() {
            await axios
                .get("/api/tempboard/site")
                .then((res) => {
                    this.billboard_sites = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        // async getBillboardSizes() {
        //     await axios
        //         .get("/api/tempboard/size")
        //         .then((res) => {
        //             this.billboard_sizes = res.data;
        //         })
        //         .catch((error) => {
        //             console.log(error);
        //         });
        // },

        async getUsers() {
            await axios
                .get("/api/users/index")
                .then((res) => {
                    this.users = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async change_sort(field) {
            if (this.sort_field == field) {
                this.sort_direction =
                    this.sort_direction == "asc" ? "desc" : "asc";
            } else {
                this.sort_field = field;
            }
            await this.getTempboards();
        },

        getCurrentDate() {
            this.currentDate = moment().format("YYYY-MM-DD");
            return this.currentDate;
        },

        getSelectedYear(date) {
            this.selectedYear = moment(date).format("YYYY");
            return this.selectedYear;
        },

        showToday(date) {
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("DD-MM-YY");
            return day;
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
