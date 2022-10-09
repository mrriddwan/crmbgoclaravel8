<template>
    <div class="container">
        <h1
            class="items-center text-center text-4xl text-white font-extrabold font-mono uppercase bg-slate-400 px-2 rounded-md"
        >
            Forecast Summary
        </h1>

        <div class="">
            <div class="grid grid-cols-5 items-center">
                <!-- <div class="grid grid-cols-1 items-left m-2">
                    <label for="paginate" class="">Per Page</label>
                    <select v-model="paginate" class="form-control">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div> -->
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

                <div>
                    <div>
                        <download-excel
                            :data="forecasts.data"
                            :fields="forecast_fields"
                            worksheet="ForecastSummary"
                            name="Forecast Summary.xls"
                            class="btn btn-success btn-sm"
                        >
                            <ArrowTopRightOnSquareIcon
                                class="h-5 w-5 mr-1 inline-block"
                            />
                            Export
                        </download-excel>
                    </div>
                </div>
                <div class="py-1 inline-block">
                    <Pagination
                        :data="forecasts"
                        @pagination-change-page="getForecasts"
                        :size="'small'"
                        :align="'right'"
                        class="pagination"
                    />
                </div>
            </div>

            <div
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto"
            >
                <table class="table table-hover table-bordered w-max">
                    <thead class="bg-slate-400 border-b sticky top-0">
                        <tr>
                            <th class="text-xs">No.</th>
                            <th class="py-3">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('user_name')
                                        "
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
                                    class="items-center text-xs text-center h-6 w-24"
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
                            <th class="py-3">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('status_name')
                                        "
                                    >
                                        Status
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'status_name'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'status_name'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div class="text-xs text-center h-6">
                                    <select
                                        v-model="selectedStatus"
                                        class="form-control form-control-sm"
                                    >
                                        <option value="">All</option>
                                        <option
                                            v-for="status in statuses.data"
                                            :key="status.id"
                                            :value="status.id"
                                        >
                                            {{ status.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('type_name')
                                        "
                                    >
                                        Type
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'type_name'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'type_name'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div class="text-xs text-center h-6">
                                    <div class="text-xs text-center h-6">
                                        <select
                                            v-model="selectedContactType"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="contact_type in contact_types.data"
                                                :key="contact_type.id"
                                                :value="contact_type.id"
                                            >
                                                {{ contact_type.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </th>

                            <th class="py-3">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('name')"
                                        class="text-white"
                                    >
                                        Company
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('forecast_type')
                                        "
                                        class="text-white"
                                    >
                                        Forecast Type
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'forecast_type')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'forecast_type'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'forecast_type'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('forecast_product')
                                        "
                                        class="text-white"
                                    >
                                        Product
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'forecast_product'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'forecast_product'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'forecast_product'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-xs text-center">Jan</div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center">Feb</div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center">Mar</div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center">Apr</div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center">May</div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center">June</div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center">July</div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center">Aug</div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center">Sept</div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center">Oct</div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center">Nov</div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center">Dec</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr
                            v-for="(contact, index) in forecasts.data"
                            :key="contact.id"
                        >
                            <td class="text-xs text-center">{{ index + 1 }}</td>
                            <!-- <td class="text-xs">{{ contact.created_at }}</td> -->
                            <td class="text-xs">{{ contact.user_name }}</td>
                            <td class="text-xs">{{ contact.status_name }}</td>
                            <td class="text-xs">{{ contact.type_name }}</td>
                            <td class="text-xs">
                                <router-link
                                    :to="`/contact/${contact.id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        contact.name
                                    }}</a>
                                </router-link>
                            </td>

                            <td class="text-xs">
                                <span
                                    v-for="forecast in contact.forecast_summary"
                                >
                                    {{ forecast[0]["forecast_type"]["name"] }}
                                    <br />
                                </span>
                            </td>
                            <td class="text-xs">
                                <span
                                    v-for="forecast in contact.forecast_summary"
                                >
                                    {{ forecast[0]["product"]["name"] }}
                                    <br />
                                </span>
                            </td>

                            <td
                                v-if="contact.forecast_summary['Jan-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `Jan-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}<br />
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.forecast_summary['Feb-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `Feb-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}
                                    <br />
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.forecast_summary['Mar-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `Mar-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}
                                    <br />
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.forecast_summary['Apr-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `Apr-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}
                                    <br />
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.forecast_summary['May-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `May-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}<br />
                                    <br />
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.forecast_summary['Jun-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `Jun-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}
                                    <br />
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.forecast_summary['Jul-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `Jul-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}
                                    <br />
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.forecast_summary['Aug-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `Aug-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}<br />
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.forecast_summary['Sep-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `Sep-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}<br />
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.forecast_summary['Oct-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `Oct-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}
                                    <br />
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.forecast_summary['Nov-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `Nov-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}
                                    <br />
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.forecast_summary['Dec-2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .forecast_summary[
                                        `Dec-` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    {{
                                        summary_info["amount"].toLocaleString(
                                            "en-US"
                                        )
                                    }}
                                </span>
                            </td>
                            <td v-else></td>
                        </tr>
                        <tr class="text-xs text-center">
                            <td colspan="7" class="text-right">Total</td>
                            <td>Jan</td>
                            <td>Jan</td>
                            <td>Jan</td>
                            <td>Jan</td>
                            <td>Jan</td>
                            <td>Jan</td>
                            <td>Jan</td>
                            <td>Jan</td>
                            <td>Jan</td>
                            <td>Jan</td>
                            <td>Jan</td>
                            <td>Jan</td>
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
    ArrowUpIcon,
    ArrowDownIcon,
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
        ArrowUpIcon,
        ArrowDownIcon,
    },

    mounted() {
        this.getSelectedYear(this.getCurrentDate());
        this.getForecasts();
        this.getStatus();
        this.getContactTypes();
        this.getForecastTypes();
        this.getUsers();
    },
    data() {
        return {
            forecasts: [],
            statuses: [],
            users: [],
            contact_types: [],
            forecast_types: [],
            paginate: 50,
            moment: moment,
            selectPage: false,
            selectAll: false,
            checked: [],

            search: "",
            selectedYear: "",
            selectedStatus: "",
            selectedUser: "",
            selectedContactType: "",
            selectedForecastType: "",
            selectedProduct: "",

            sort_direction: "asc",
            sort_field: "id",
            currentDate: "",

            forecast_fields: {
                ID: "id",
                Company: "name",
                Status: "status_name",
                Type: "type_name",
                User: "user_name",
                User: "user_name",
                User: "user_name",
                Jan: {
                    callback: (value) => {
                        if (!value.forecast_summary[`Jan-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`Jan-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
                Feb: {
                    callback: (value) => {
                        if (!value.forecast_summary[`Feb-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`Feb-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
                Mar: {
                    callback: (value) => {
                        if (!value.forecast_summary[`Mar-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`Mar-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
                Apr: {
                    callback: (value) => {
                        if (!value.forecast_summary[`Apr-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`Apr-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
                May: {
                    callback: (value) => {
                        if (!value.forecast_summary[`May-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`May-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
                Jun: {
                    callback: (value) => {
                        if (!value.forecast_summary[`Jun-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`Jun-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
                Jul: {
                    callback: (value) => {
                        if (!value.forecast_summary[`Jul-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`Jul-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
                Aug: {
                    callback: (value) => {
                        if (!value.forecast_summary[`Aug-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`Aug-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
                Sep: {
                    callback: (value) => {
                        if (!value.forecast_summary[`Sep-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`Sep-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
                Oct: {
                    callback: (value) => {
                        if (!value.forecast_summary[`Oct-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`Oct-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
                Nov: {
                    callback: (value) => {
                        if (!value.forecast_summary[`Nov-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`Nov-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
                Dec: {
                    callback: (value) => {
                        if (!value.forecast_summary[`Dec-` + this.selectedYear]) {
                            return " ";
                        } else {
                            return `${value.forecast_summary[`Dec-` + this.selectedYear][0]["amount"]}`;
                        }
                    },
                },
            },
        
        };
    },
    watch: {
        paginate: function (value) {
            this.getForecasts();
        },
        search: function (value) {
            this.getForecasts();
        },
        selectedStatus: function (value) {
            this.getForecasts();
        },
        selectedUser: function (value) {
            this.getForecasts();
        },
        selectedContactType: function (value) {
            this.getForecasts();
        },
        selectedForecastType: function (value) {
            this.getForecasts();
        },
        // selectedCategory: function (value) {
        //     this.getForecasts();
        // },

        selectPage: function (value) {
            this.checked = [];
            if (value) {
                this.forecast.data.forEach((forecast) => {
                    this.checked.push(forecast.id);
                });
            } else {
                this.checked = [];
                this.selectAll = false;
            }
        },

        // checked: function (value) {
        //     this.url = "/api/contacts/exportSummary/" + this.checked;
        // },
    },

    computed: {},

    methods: {
        getForecasts(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/forecasts/summary?" +
                        "q=" +
                        this.search +
                        "&selectedContactType=" +
                        this.selectedContactType +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedProduct=" +
                        this.selectedProduct +
                        "&selectedForecastType=" +
                        this.selectedForecastType +
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
                    this.forecasts = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

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

        async getContactTypes() {
            await axios
                .get("/api/contacts/type/index")
                .then((res) => {
                    this.contact_types = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getStatus() {
            await axios
                .get("/api/contacts/status/index")
                .then((res) => {
                    this.statuses = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getForecastTypes() {
            await axios
                .get("/api/forecasts/type/index")
                .then((res) => {
                    this.forecast_types = res.data;
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
            await this.getForecasts();
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
            let day = moment(date).format("DD-MM-YY");
            return day;
        },

        exportSelected() {
            axios.get("/api/forecasts/exportSummary");
        },

        isChecked(contact_id) {
            return this.checked.includes(contact_id);
        },

        async selectAllRecords() {
            await axios.get("/api/forecasts/all").then((response) => {
                this.checked = response.data;
                this.selectAll = true;
            });
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
