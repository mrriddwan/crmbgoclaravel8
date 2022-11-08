<template>
    <h1
        class="items-center text-center text-5xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
    >
        Forecast List
    </h1>

    <div class="py-2">
        <div
            class="inline-block"
            v-if="
                can('view forecast summary') ||
                is('supervisor | admin | super-admin')
            "
        >
            <router-link
                to="/forecast/summary"
                class="inline-block items-center px-2 py-1 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >Forecast Summary</router-link
            >
        </div>

        <div class="mx-2 inline-block">
            <a
                v-if="checked.length > 0"
                class="px-2 py-2 align-middle text-center bg-blue-400 border-black border-2 rounded-md text-xs"
                type="button"
                :href="url"
                download="file.xlsx"
            >
                <button @click="exportSelected()" class="h-1">
                    <ArrowTopRightOnSquareIcon
                        class="h-5 w-5 mr-1 inline-block"
                    />
                    <p class="inline-block text-black uppercase font-extrabold">
                        Export
                    </p>
                </button>
            </a>

            <div v-if="checked.length > 0 && !selectPage" class="inline-block">
                <div
                    class="inline-block mx-1"
                    v-if="selectAll || forecasts.meta.total == checked.length"
                >
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s).
                </div>
                <div v-else class="inline-block mx-1">
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s)
                    <a
                        v-if="
                            can('export forecast all') ||
                            is('supervisor | admin | super-admin')
                        "
                        @click.prevent="selectAllRecords"
                        href="#"
                        class="ml-1 rounded-md bg-yellow-400 border-2 border-black uppercase text-black text-xs"
                        >Select All</a
                    >
                </div>
            </div>

            <div class="inline-block" v-if="selectPage">
                <div
                    class="inline-block mx-1"
                    v-if="selectAll || forecasts.meta.total == checked.length"
                >
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s).
                </div>
                <div v-else class="inline-block mx-1">
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s)
                    <a
                        v-if="
                            can('export forecast all') ||
                            is('supervisor | admin | super-admin')
                        "
                        @click.prevent="selectAllRecords"
                        href="#"
                        class="ml-1 rounded-md bg-yellow-400 border-2 border-black uppercase text-black text-xs px-1"
                        >Select All</a
                    >
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-3">
        <div class="grid grid-cols-2 items-center align-middle w-max">
            <label for="paginate" class="px-2 inline-block"
                >Per page</label
            >
            <input v-model.lazy="paginate" class="form-control"/>
                    <!-- <select v-model="paginate" class="form-control">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> -->
        </div>
        <div class="py-2">
            <input
                v-model.lazy="search"
                type="search"
                class="form-control"
                placeholder="Search by any..."
            />
        </div>
        <div class="mt-1">
            <Pagination
                :data="forecasts"
                @pagination-change-page="getForecasts"
                :size="'small'"
                :align="'right'"
                class="pagination"
            />
        </div>
    </div>

    <div>
        <div
            class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto"
        >
            <table class="table table-hover table-bordered w-full mt-0">
                <thead class="bg-slate-500 border-b sticky top-0 text-xs">
                    <tr>
                        <th
                            v-if="
                                can('export forecast') ||
                                is('admin | super-admin')
                            "
                        >
                            <input type="checkbox" v-model="selectPage" />
                            <div class="text-sm text-center h-6"></div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center text-white h-6">
                                #
                            </div>
                            <div class="text-sm text-center h-6"></div>
                        </th>
                        <th class="py-3 align-middle text-center">
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('forecast_updatedate')
                                    "
                                    class="text-white inline-flex"
                                >
                                    Last<br />Update
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
                                            !(
                                                sort_field ==
                                                'forecast_updatedate'
                                            )
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'forecast_updatedate'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'forecast_updatedate'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon class="h-4 w-4"
                                    /></span>
                                </a>
                            </div>
                            <div class="text-sm text-center h-6"></div>
                        </th>
                        <th class="py-3 w-max">
                            <div class="text-sm text-center h-6 w-max">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('contact_name')"
                                    class="text-white inline-flex"
                                >
                                    Contact
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
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
                                        ><ArrowUpIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'contact_name'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon class="h-4 w-4"
                                    /></span>
                                </a>
                            </div>
                            <div class="text-sm text-center h-6"></div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('user_name')"
                                    class="text-white inline-flex"
                                >
                                    CS
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
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
                                        ><ArrowUpIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'user_name'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon class="h-4 w-4"
                                    /></span>
                                </a>
                            </div>
                            <div
                                class="items-center text-xs text-center h-6 w-24"
                                v-if="is('supervisor | admin | super-admin')"
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
                            <div class="text-sm text-center h-max">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('product_name')"
                                    class="text-white inline-flex"
                                >
                                    Forecast<br />Product
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
                                            !(sort_field == 'product_name')
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'product_name'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'product_name'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon class="h-4 w-4"
                                    /></span>
                                </a>
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
                                    class="text-white inline-flex"
                                >
                                    Amount
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
                                            !(sort_field == 'amount')
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'amount'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'amount'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon class="h-4 w-4"
                                    /></span>
                                </a>
                            </div>
                            <div class="text-sm text-center h-6"></div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-max">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('forecast_date')
                                    "
                                    class="text-white inline-flex"
                                >
                                    Date<br />Forecast
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
                                            !(sort_field == 'forecast_date')
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'forecast_date'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'forecast_date'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon class="h-4 w-4"
                                    /></span>
                                </a>
                            </div>
                            <div class="text-sm text-center h-6"></div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-max">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('forecast_type_name')
                                    "
                                    class="text-white inline-flex"
                                >
                                    Forecast<br />Type
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
                                            !(
                                                sort_field ==
                                                'forecast_type_name'
                                            )
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'forecast_type_name'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'forecast_type_name'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon class="h-4 w-4"
                                    /></span>
                                </a>
                            </div>
                            <div class="text-sm text-center h-6">
                                <div class="text-sm text-center h-6">
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
                            <div class="text-sm text-center h-max">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('forecast_result')
                                    "
                                    class="text-white inline-flex"
                                >
                                    Result
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
                                            !(sort_field == 'forecast_result')
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
                                        ><ArrowUpIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'forecast_result'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon class="h-4 w-4"
                                    /></span>
                                </a>
                            </div>
                            <div class="text-sm text-center h-6">
                                <div class="text-sm text-center h-6">
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
                        <th class="py-3">
                            <div class="text-sm text-center h-6"></div>
                        </th>
                    </tr>
                </thead>
                <tbody class="mt-2 text-center">
                    <tr
                        v-for="(forecast, index) in forecasts.data"
                        :key="forecast.id"
                        :class="isChecked(forecast.id) ? 'table-primary' : ''"
                    >
                        <td
                            class="text-center"
                            v-if="
                                can('export forecast') ||
                                is('admin | super-admin')
                            "
                        >
                            <input
                                type="checkbox"
                                :value="forecast.id"
                                v-model="checked"
                            />
                        </td>
                        <td class="text-xs">{{ index + 1 }}</td>
                        <td class="text-xs">
                            {{ showToday(forecast.forecast_updatedate) }}
                        </td>
                        <td class="text-xs grid-cols-2 w-max">
                            <router-link
                                :to="`/contact/${forecast.contact.id}/info`"
                                custom
                                v-slot="{ navigate, href }"
                            >
                                <a :href="href" @click.stop="navigate">{{
                                    forecast.contact.name
                                }}</a>
                            </router-link>
                            <router-link
                                :to="`/forecast/${forecast.contact.id}/create`"
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
                        <td class="text-xs">
                            {{ showToday(forecast.forecast_date) }}
                        </td>
                        <td class="text-xs">
                            {{ forecast.forecast_type.name }}
                        </td>
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
                                <span
                                    v-if="forecast.result_id === 3"
                                    class="w-max inline-block align-middle text-sm font-extrabold uppercase text-white bg-yellow-600 rounded-md py-1 px-2 text-center"
                                >
                                    {{ forecast.result_name }}
                                </span>
                                <div
                                    v-if="
                                        can('edit forecast') ||
                                        is('supervisor | admin | super-admin')
                                    "
                                >
                                    <button
                                        class="bg-blue-300 py-1 px-1 ml-2 text-xs rounded-md inline-block"
                                        @click="toggleResult()"
                                    >
                                        <PencilIcon class="h-3 w-3" />
                                    </button>
                                </div>

                                <!-- <button
                                    class="bg-blue-300 py-1 px-1 ml-2 text-xs rounded-md inline-block"
                                    @click="hideEditResult(forecast.id)"
                                >
                                    Hide
                                </button> -->
                                <span v-show="changeResult">
                                    <select
                                        id="change-result-{{forecast.id}}"
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
                                        <option value="">Unconfirmed</option>
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
                                    <option value="">Select Result</option>
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
                            <div
                                v-if="
                                    can('delete forecast') ||
                                    is('supervisor | admin | super-admin')
                                "
                            >
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="deleteForecast(forecast.id)"
                                >
                                    <TrashIcon class="h-3 w-3" />
                                </button>
                            </div>
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
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
    ArrowUpIcon,
    ArrowDownIcon,
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
    },

    mounted() {
        this.getUsers();
        this.selectedUser = document
            .querySelector('meta[name="user-id"]')
            .getAttribute("content");
        this.getProducts();
        this.getForecastTypes();
        this.getResults();
        this.getForecasts();
    },
    data() {
        return {
            forecasts: [],
            products: [],
            forecast_types: [],
            results: [],

            paginate: 50,
            selectPage: false,
            selectAll: false,
            checked: [],
            url: "",

            search: "",
            selectedProduct: "",
            selectedContactType: "",
            selectedForecastType: "",
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
        selectedForecastType: function (value) {
            this.getForecasts();
        },
        selectedContactType: function (value) {
            this.getForecasts();
        },
        selectedProduct: function (value) {
            this.getForecasts();
        },
        selectedUser: function (value) {
            this.getForecasts();
        },
        filterResult: function (value) {
            if (this.filterResult === "null") {
                this.filterResult = null;
                this.getForecasts();
            } else {
                this.getForecasts();
            }
        },
        selectPage: function (value) {
            this.checked = [];
            if (value) {
                this.forecasts.data.forEach((forecast) => {
                    this.checked.push(forecast.id);
                });
            } else {
                this.checked = [];
                this.selectAll = false;
            }
        },

        checked: function (value) {
            this.url = "/api/forecasts/export/" + this.checked;
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
                        "&selectedForecastType=" +
                        this.selectedForecastType +
                        "&selectedContactType=" +
                        this.selectedContactType +
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
                .get("/api/users/users_list")
                .then((res) => {
                    this.users = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getForecastTypes() {
            axios
                .get("/api/forecasts/type/index")
                .then((res) => {
                    this.forecast_types = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getProducts() {
            axios
                .get("/api/forecasts/product/index")
                .then((res) => {
                    this.products = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getResults() {
            axios
                .get("/api/forecasts/result/index")
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

        deleteForecast(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/forecasts/delete/" + id);
            this.getForecasts();
        },

        showToday(date) {
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("DD-MM-YY");
            return day;
        },

        resultSelected(result, forecastId) {
            const date = moment().format("YYYY-MM-DD");
            if (!window.confirm("Update result of forecast?")) {
                this.forecast_result.result_id = "";
                return result;
            }
            console.log(result);
            console.log(forecastId);
            axios.put("/api/forecasts/resultSelected/" + forecastId, {
                result_id: result ? result : null,
                forecast_updatedate: date,
            });
            console.log("this is update date:" + date);
            alert("Result updated");
            this.forecast_result.result_id = "";
            this.changeResult = false;
            this.getForecasts();
        },

        toggleResult() {
            return (this.changeResult = !this.changeResult);
        },

        hideEditResult(forecastId) {
            // return (this.changeResult = !this.changeResult);
            let x = document.getElementById(
                `change-result-${forecastId}`
            ).hidden;
            x = true;
            console.log(x);
            return x;
        },

        exportSelected() {
            if (this.checked.length === 0) {
                return alert("Need select record.");
            } else {
                axios.get("/api/forecasts/export/");
            }
        },

        isChecked(forecast_id) {
            return this.checked.includes(forecast_id);
        },

        selectAllRecords() {
            axios.get("/api/forecasts/all").then((response) => {
                this.checked = response.data;
                this.selectAll = true;
            });
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

/* #change-result-${forecastId} {
  width: 500px;
  height: 500px;
  background-color: lightblue;
} */
</style>
