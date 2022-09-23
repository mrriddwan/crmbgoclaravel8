<template>
    <h1
        class="items-center text-center text-6xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
    >
        Forecast List
    </h1>

    <div class="py-2">
        <router-link
            to="/forecasts/index"
            class="inline-block items-center px-2 py-1 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            >Forecast Summary</router-link
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
        <!-- <div class="bg-slate-400 w-max mx-auto">
            <p class="mt-2 text-center">Filter Forecast Result</p>
            <div class="grid grid-cols-2">
                <div>
                    <div class="grid grid-cols-2 px-3 text-center">
                        <div class="bg-cyan-500">
                            <input
                                id="default-checkbox"
                                type="checkbox"
                                value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                        </div>
                        <div>
                            <label
                                for="default-checkbox"
                                class="ml-2 text-sm font-medium text-black dark:text-gray-300"
                                >None</label
                            >
                        </div>
                    </div>
                    <div class="grid grid-cols-2 py-2 px-3 text-center">
                        <div class="bg-cyan-500">
                            <input
                                id="default-checkbox"
                                type="checkbox"
                                value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                        </div>
                        <div>
                            <label
                                for="default-checkbox"
                                class="ml-2 text-sm font-medium text-black dark:text-gray-300"
                                >Only Confirmed</label
                            >
                        </div>
                    </div>
                    <div class="grid grid-cols-2 px-3 text-center">
                        <div class="bg-cyan-500">
                            <input
                                id="default-checkbox"
                                type="checkbox"
                                value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                        </div>
                        <div>
                            <label
                                for="default-checkbox"
                                class="ml-2 text-sm font-medium text-black dark:text-gray-300"
                                >Exclude Confirmed</label
                            >
                        </div>
                    </div>
                </div>
                <div>
                    <div class="grid grid-cols-2 px-3 text-center">
                        <div class="bg-cyan-500">
                            <input
                                id="default-checkbox"
                                type="checkbox"
                                value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                        </div>
                        <div>
                            <label
                                for="default-checkbox"
                                class="ml-2 text-sm font-medium text-black dark:text-gray-300"
                                >None</label
                            >
                        </div>
                    </div>
                    <div class="grid grid-cols-2 py-2 px-3 text-center">
                        <div class="bg-cyan-500">
                            <input
                                id="default-checkbox"
                                type="checkbox"
                                value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                        </div>
                        <div>
                            <label
                                for="default-checkbox"
                                class="ml-2 text-sm font-medium text-black dark:text-gray-300"
                                >Only Rejected</label
                            >
                        </div>
                    </div>
                    <div class="grid grid-cols-2 px-3 text-center">
                        <div class="bg-cyan-500">
                            <input
                                id="default-checkbox"
                                type="checkbox"
                                value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                            />
                        </div>
                        <div>
                            <label
                                for="default-checkbox"
                                class="ml-2 text-sm font-medium text-black dark:text-gray-300"
                                >Exclude Rejected</label
                            >
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
    <div class="mt-1">
        <Pagination
            :data="forecasts"
            @pagination-change-page="getForecasts"
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
                        <th class="py-3 align-middle text-center">
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('forecast_updatedate')
                                    "
                                >
                                    Last<br />Update
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'forecast_updatedate'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'forecast_updatedate'
                                    "
                                    >&darr;</span
                                >
                            </div>
                        </th>
                        <th class="py-3 w-max">
                            <div class="text-sm text-center h-6 w-max">
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
                                <a href="#" @click.prevent=""> CS </a>
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
                        <th class="py-3 w-max">
                            <div class="text-sm text-center h-6">
                                <a href="#" @click.prevent=""> Product </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'product_name'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'product_name'
                                    "
                                    >&darr;</span
                                >
                            </div>
                            <div class="text-center h-6 w-20">
                                <select
                                    v-model="selectedProduct"
                                    class="form-control form-control-sm text-xs"
                                >
                                    <option class="text-xs" value="">
                                        All
                                    </option>
                                    <option
                                        class="text-xs"
                                        v-for="product in products.data"
                                        :key="product.id"
                                        :value="product.id"
                                    >
                                        {{ product.name }}
                                    </option>
                                </select>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('amount')"
                                >
                                    Amount
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'amount'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'amount'
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
                                        change_sort('forecast_date')
                                    "
                                >
                                    Expected<br />
                                    Forecast
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'forecast_date'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'forecast_date'
                                    "
                                    >&darr;</span
                                >
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('type_name')"
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
                            <div class="text-sm text-center h-6">
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedType"
                                        class="form-control form-control-sm w-max"
                                    >
                                        <option value="">All</option>
                                        <option
                                            v-for="forecast_type in types.data"
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
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('forecast_result')
                                    "
                                >
                                    Result
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'forecast_result'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'forecast_result'
                                    "
                                    >&darr;</span
                                >
                            </div>
                            <div class="text-sm text-center h-6">
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="filterResult"
                                        class="form-control form-control-sm w-max"
                                    >
                                        <option value="">All</option>
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
                        <th class="py-3">
                            <div class="text-sm text-center h-6"></div>
                        </th>
                    </tr>
                </thead>
                <tbody class="mt-2">
                    <tr
                        v-for="(forecast, index) in forecasts.data"
                        :key="forecast.id"
                    >
                        <td class="text-xs">{{ index + 1 }}</td>
                        <td class="text-xs">
                            {{ forecast.forecast_updatedate }}
                        </td>
                        <td class="text-xs grid-cols-2 w-max">
                            <router-link
                                class="mr-2"
                                :to="`/contact/${forecast.contact.id}/info`"
                                custom
                                v-slot="{ navigate, href }"
                            >
                                <a :href="href" @click.stop="navigate">{{
                                    forecast.contact.name
                                }}</a>
                            </router-link>
                            <router-link
                                :to="`/forecasts/${forecast.contact.id}/create`"
                                class="ml-1 px-2 py-1 items-center border text-xs text-right rounded-lg w-max text-lime-600"
                            >
                                <PlusIcon class="h-3 w-3 inline" />
                                <DocumentChartBarIcon class="h-4 w-4 inline"
                            /></router-link>
                        </td>
                        <td class="text-xs">{{ forecast.user.name }}</td>
                        <td class="text-xs w-max">
                            {{ forecast.product.name }}
                        </td>
                        <td class="text-xs">
                            <p class="inline mr-1">RM</p>
                            {{ forecast.amount.toLocaleString("en-US") }}
                        </td>
                        <td class="text-xs">{{ forecast.forecast_date }}</td>
                        <td class="text-xs">{{ forecast.type.name }}</td>
                        <td class="text-center align-middle">
                            <span v-if="forecast.result">
                                <span
                                    v-if="forecast.result.id === 1"
                                    class="w-max inline-block align-middle text-sm font-extrabold uppercase text-white bg-green-600 rounded-md py-1 px-2 text-center"
                                >
                                    {{ forecast.result.name }}
                                </span>
                                <span
                                    v-if="forecast.result.id === 2"
                                    class="w-max inline-block align-middle text-sm font-extrabold uppercase text-white bg-red-600 rounded-md py-1 px-2 text-center"
                                >
                                    {{ forecast.result.name }}
                                </span>
                                <button
                                    class="bg-blue-300 py-1 px-1 ml-2 text-xs rounded-md inline-block"
                                    @click="toggleResult"
                                    :id="forecast.id"
                                >
                                    <PencilIcon class="h-3 w-3" />
                                </button>
                                <span v-show="changeResult === true">
                                    <select
                                        hidden
                                        id="result-change-{{forecast.id}}"
                                        class="form-control form-control-sm mt-2"
                                        @change="
                                            resultSelected(
                                                this.forecast_result.result_id,
                                                forecast.id,
                                                forecast.contact.id
                                            )
                                        "
                                        v-model="forecast_result.result_id"
                                    >
                                        <option disabled value="">
                                            Select Result
                                        </option>
                                        <option
                                            v-for="result in results.data"
                                            :key="result.id"
                                            :value="result.id"
                                        >
                                            {{ result.name }}
                                        </option>
                                    </select>
                                </span>
                            </span>
                            <span v-show="!forecast.result">
                                <select
                                    id="result-select"
                                    class="form-control form-control-sm mt-2"
                                    @change="
                                        resultSelected(
                                            this.forecast_result.result_id,
                                            forecast.id,
                                            forecast.contact.id
                                        )
                                    "
                                    v-model="forecast_result.result_id"
                                >
                                    <option disabled value="">
                                        Select Result
                                    </option>
                                    <option
                                        v-for="result in results.data"
                                        :key="result.id"
                                        :value="result.id"
                                    >
                                        {{ result.name }}
                                    </option>
                                </select>
                            </span>
                        </td>
                        <td class="text-xs">
                            <router-link
                                :to="{
                                    name: 'forecast_edit',
                                    params: {
                                        id: forecast.id,
                                    },
                                }"
                                class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                                <PencilSquareIcon class="h-3 w-3"
                            /></router-link>
                            <button
                                class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                @click="deleteForecast(forecast.id)"
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
        this.getForecasts();
        this.getUsers();
        this.getProducts();
        this.getTypes();
        this.getResults();
    },
    data() {
        return {
            forecasts: [],
            products: [],
            types: [],
            results: [],
            paginate: 50,

            search: "",
            selectedProduct: "",
            selectedType: "",
            selectedUser: "",
            filterResult: "",

            sort_direction: "desc",
            sort_field: "forecast_date",
            users: "",
            forecast_result: {
                result_id: "",
                forecast_updatedate: "",
            },
            changeResult: false,
        };
    },
    watch: {
        paginate: function (value) {
            this.getForecasts();
        },
        search: function (value) {
            this.getForecasts();
        },
        selectedType: function (value) {
            this.getForecasts();
        },
        selectedProduct: function (value) {
            this.getForecasts();
        },
        selectedUser: function (value) {
            this.getForecasts();
        },
        filterResult: function (value) {
            this.getForecasts();
        },
    },

    methods: {
        getForecasts(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/forecasts/index?" +
                        "q=" +
                        this.search +
                        "&selectedType=" +
                        this.selectedType +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedProduct=" +
                        this.selectedProduct +
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
        getUsers() {
            axios
                .get("/api/users/index")
                .then((res) => {
                    this.users = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getTypes() {
            axios
                .get("/api/contacttypes/index")
                .then((res) => {
                    this.types = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getProducts() {
            axios
                .get("/api/forecastproducts/index")
                .then((res) => {
                    this.products = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getResults() {
            axios
                .get("/api/forecastresults/index")
                .then((res) => {
                    this.results = res.data;
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
            this.getForecasts();
        },

        searchType() {},

        deleteForecast(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/forecasts/delete/" + id);
            this.getForecasts();
        },

        resultSelected(result, forecastId) {
            const date = moment().format("YYYY-MM-DD");
            if (!window.confirm("Update result of forecast?")) {
                return;
            }
            console.log(result);
            console.log(forecastId);
            axios.put("/api/forecasts/resultSelected/" + forecastId, {
                result_id: result,
                forecast_updatedate: date,
            });
            console.log("this is update date:" + date);
            alert("Result updated");
            this.changeResult = false;
            this.getForecasts();
        },

        toggleResult() {
            return (this.changeResult = !this.changeResult);
        },

        // forecastResult() {
        //     if ((forecast.result.id = 1)) {
        //         document.getElementById("confirmed-checkbox").checked = true;
        //     } else if ((forecast.result.id = 2)) {
        //         document.getElementById("rejected-checkbox").checked = true;
        //     } else {
        //         document.getElementById("confirmed-checkbox").checked = false;
        //         document.getElementById("rejected-checkbox").checked = false;
        //     }
        // },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
