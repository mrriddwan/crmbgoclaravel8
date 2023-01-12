<template>
    <div class="w-full min-h-screen">
        <h1
            class="items-center text-center text-5xl text-white font-extrabold bg-yellow-400 px-2 rounded-md"
        >
            Forecast Summary
        </h1>

        <div class="">
            <div class="grid grid-cols-4 items-center">
                <div class="grid grid-cols-1 items-left m-2">
                    <label>Year</label>
                    <input
                        v-model.lazy="selectedYear"
                        type="search"
                        class="form-control"
                        placeholder="Search + Press ENTER"
                    />
                </div>
                <div class="grid grid-cols-1 items-left m-2">
                    <label>Search in table</label>
                    <input
                        v-model.lazy="search"
                        type="search"
                        class="form-control"
                        placeholder="Search + Press ENTER"
                    />
                </div>
                <div class="grid grid-cols-2 break-normal text-xs">
                    <div class="bg-blue-700 rounded-md w-max px-2 py-2">
                        <button @click="getForecasts" class="text-white">
                            Find Records
                        </button>
                    </div>
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
            </div>

            <div
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto"
            >
                <table class="table table-hover table-bordered w-max">
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="text-xs">
                                <div class="text-xs text-center h-6 text-white">
                                    No.
                                </div>
                                <div class="text-xs text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('user_name')
                                        "
                                        class="text-white"
                                    >
                                        CS
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'user_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    v-if="
                                        is('supervisor | admin | super-admin')
                                    "
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
                                <div class="text-xs text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('contact_status')
                                        "
                                        class="text-white"
                                    >
                                        Contact Status
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'contact_status'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'contact_status'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'contact_status'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6">
                                    <select
                                        v-model="selectedContactStatus"
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
                                <div class="text-xs text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('contact_type')
                                        "
                                        class="text-white"
                                    >
                                        Contact Type
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'contact_type')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'contact_type'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'contact_type'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
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
                                <div class="text-xs text-center h-6 flex w-24">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('contact')"
                                        class="text-white"
                                    >
                                        Company
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'contact')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'contact'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'contact'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-xs text-center h-max">
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
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'forecast_type'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6">
                                    <div class="text-xs text-center h-6">
                                        <select
                                            v-model="selectedForecastType"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="forecast_type in forecast_types.data"
                                                :key="forecast_type.id"
                                                :value="forecast_type.id"
                                            >
                                                {{ forecast_type.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </th>

                            <th class="py-3">
                                <div class="text-xs text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('forecast_product')
                                        "
                                        class="text-white"
                                    >
                                        Forecast Product
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
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'forecast_product'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6">
                                    <div class="text-xs text-center h-6">
                                        <select
                                            v-model="selectedForecastProduct"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="product in products.data"
                                                :key="product.id"
                                                :value="product.id"
                                            >
                                                {{ product.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('forecast_product')
                                        "
                                        class="text-white"
                                    >
                                        Result
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'forecast_result'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'forecast_result'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'forecast_result'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6">
                                    <div class="text-xs text-center h-6">
                                        <select
                                        v-model="filterResult"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option value="null">No result</option>
                                            <option
                                                v-for="result in results.data"
                                                :key="result.id"
                                                :value="result.id"
                                            >
                                                {{ result.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </th>

                            <th class="py-3 text-white">
                                <div class="text-xs text-center">Jan</div>
                            </th>
                            <th class="py-3 text-white">
                                <div class="text-xs text-center">Feb</div>
                            </th>
                            <th class="py-3 text-white">
                                <div class="text-xs text-center">Mar</div>
                            </th>
                            <th class="py-3 text-white">
                                <div class="text-xs text-center">Apr</div>
                            </th>
                            <th class="py-3 text-white">
                                <div class="text-xs text-center">May</div>
                            </th>
                            <th class="py-3 text-white">
                                <div class="text-xs text-center">June</div>
                            </th>
                            <th class="py-3 text-white">
                                <div class="text-xs text-center">July</div>
                            </th>
                            <th class="py-3 text-white">
                                <div class="text-xs text-center">Aug</div>
                            </th>
                            <th class="py-3 text-white">
                                <div class="text-xs text-center">Sept</div>
                            </th>
                            <th class="py-3 text-white">
                                <div class="text-xs text-center">Oct</div>
                            </th>
                            <th class="py-3 text-white">
                                <div class="text-xs text-center">Nov</div>
                            </th>
                            <th class="py-3 text-white">
                                <div class="text-xs text-center">Dec</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr
                            v-for="(forecast, index) in forecasts.data"
                            :key="forecast.id"
                        >
                            <td class="text-xs text-center">{{ index + 1 }}</td>
                            <!-- <td class="text-xs">{{ contact.created_at }}</td> -->
                            <td class="text-xs text-left">{{ forecast.user_name }}</td>
                            <td class="text-xs text-left">
                                {{ forecast.contact_status }}
                            </td>
                            <td class="text-xs text-left">
                                {{ forecast.contact_type }}
                            </td>
                            <td class="text-xs text-left">
                                <router-link
                                    :to="`/contact/${forecast.contact_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        forecast.contact
                                    }}</a>
                                </router-link>
                            </td>

                            <td class="text-xs text-left">
                                {{ forecast.forecast_type }}
                            </td>
                            <td class="text-xs text-left">
                                {{ forecast.forecast_product }}
                            </td>
                            <td class="text-xs text-left" v-if="!forecast.forecast_result">
                                No result
                            </td>
                            <td class="text-xs text-left" v-else>
                                {{ forecast.forecast_result }}
                            </td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-01'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-02'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-03'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-04'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-05'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-06'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-07'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-08'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-09'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-10'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-11'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>

                            <td
                                class="text-xs"
                                v-if="
                                    getMonth(forecast.forecast_date) ===
                                    this.selectedYear + '-12'
                                "
                            >
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td v-else></td>
                        </tr>
                        <!-- <tr class="text-xs text-center">
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
                        </tr> -->
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
        this.getUsers();
        this.selectedUser = document
            .querySelector('meta[name="user-id"]')
            .getAttribute("content");
        this.getSelectedYear(this.getCurrentDate());
        // this.getForecasts();
        this.getStatus();
        this.getContactTypes();
        this.getForecastTypes();
        this.getResults();
        this.getProducts();
    },
    data() {
        return {
            forecasts: [],
            statuses: [],
            users: [],
            contact_types: [],
            forecast_types: [],
            products: [],
            results: [],

            paginate: 5000,
            moment: moment,
            selectPage: false,
            selectAll: false,
            checked: [],

            search: "",
            selectedYear: "",
            selectedUser: "",
            selectedContact: "",
            selectedContactType: "",
            selectedContactStatus: "",
            selectedForecastType: "",
            selectedForecastProduct: "",
            filterResult: "",

            sort_direction: "asc",
            sort_field: "contact",
            currentDate: "",

            forecast_fields: {
                // ID: "id",
                Date: {
                    callback: (value) => {
                        return `${this.showToday(value.created_at)}`;
                    },
                },
                User: "user_name",
                "Contact Status": "contact_status",
                "Contact Type": "contact_type",
                Company: "contact",
                "Forecast Product": "forecast_product",
                "Forecast Type": "forecast_type",
                Result: {
                    callback: (value) => {
                        if (!value.forecast_result) {
                            return "No result ";
                        } else {
                            return `${value.forecast_result}`;
                        }
                    },
                },
                Amount: "amount",
                Jan: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-01"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
                        }
                    },
                },
                Feb: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-02"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
                        }
                    },
                },
                Mar: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-03"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
                        }
                    },
                },
                Apr: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-04"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
                        }
                    },
                },
                May: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-05"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
                        }
                    },
                },
                Jun: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-06"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
                        }
                    },
                },
                Jul: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-07"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
                        }
                    },
                },
                Aug: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-08"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
                        }
                    },
                },
                Sep: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-09"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
                        }
                    },
                },
                Oct: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-10"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
                        }
                    },
                },
                Nov: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-11"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
                        }
                    },
                },
                Dec: {
                    callback: (value) => {
                        if (
                            this.getMonth(value.forecast_date) !==
                            this.selectedYear + "-12"
                        ) {
                            return " ";
                        } else {
                            return value.amount;
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
        selectedContactStatus: function (value) {
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
        selectedForecastProduct: function (value) {
            this.getForecasts();
        },

        filterResult: function (value) {
            this.getForecasts();
        },

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
                        "&selectedContactStatus=" +
                        this.selectedContactStatus +
                        "&selectedForecastProduct=" +
                        this.selectedForecastProduct +
                        "&selectedForecastType=" +
                        this.selectedForecastType +
                        "&selectedContact=" +
                        this.selectedContact +
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
                    this.forecasts = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUsers() {
            await axios
                .get("/api/users/users_list")
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

        async getResults() {
            await axios
                .get("/api/forecasts/result/index")
                .then((res) => {
                    this.results = res.data;
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

        async getProducts() {
            await axios
                .get("/api/forecasts/product/index")
                .then((res) => {
                    this.products = res.data;
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

        getMonth(date) {
            let day = moment(date).format("YYYY-MM");
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
