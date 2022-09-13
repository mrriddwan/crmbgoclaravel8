<template>
    <router-link
        to="/dashboard"
        class="inline-block items-center px-2 py-1 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
    >
        Contacts</router-link
    >
    <router-link
        to="/todo/index"
        class="inline-block items-center px-2 py-1 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
    >
        To Do</router-link
    >
    <router-link
        to="/followup/index"
        class="inline-block items-center px-2 py-1 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
    >
        Follow Up</router-link
    >
    <router-link
        to="/forecasts/index"
        class="inline-block items-center px-2 py-1 bg-purple-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
    >
        Forecast</router-link
    >
    <h1
        class="items-center text-center text-6xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
    >
        Forecast List
    </h1>

    <router-link
        to="/forecasts/create"
        class="ml-1 inline-block items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
    >
        <UserPlusIcon class="h-6 w-6 inline" /> forecast</router-link
    >

    <div class="">
        <div class="grid grid-cols-2 items-center">
            <div class="grid grid-cols-2 items-left m-2">
                <label for="paginate" class="">Per Page</label>
                <select v-model="paginate" class="form-control">
                    <option value="10">10</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div>
                <input
                    v-model.lazy="search"
                    type="search"
                    class="form-control"
                    placeholder="Search by any..."
                />
            </div>
        </div>

        <div class="py-1">
            <Pagination
                :data="forecasts"
                @pagination-change-page="getforecasts"
                :size="'small'"
                :align="'center'"
                class="pagination"
            />
        </div>

        <!-- <div class="table-wrp block max-h-96">
  <table class="w-full">
    <thead class="bg-white border-b sticky top-0"> -->

        <div
            class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto"
        >
            <table class="table table-hover table-bordered w-full">
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
                                        change_sort('forecast_updatedate')
                                    "
                                >
                                    Last Update
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
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('forecast_name')
                                    "
                                >
                                    Company
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'forecast_name'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'forecast_name'
                                    "
                                    >&darr;</span
                                >
                            </div>
                            <div class="text-sm text-center h-6">
                                <div class="text-sm text-center h-6">
                                    <input
                                        v-model.lazy="search"
                                        type="search"
                                        class="w-16 placeholder:text-xs placeholder:text-center h-8"
                                        placeholder="Search forecast"
                                    />
                                </div>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('user_name')"
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
                            <div class="text-sm text-center h-6">
                                <input
                                    v-model.lazy="search"
                                    type="search"
                                    class="w-16 placeholder:text-xs placeholder:text-center h-8"
                                    placeholder="Search user"
                                />
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('Product')"
                                >
                                    Product
                                </a>
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
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedProduct"
                                        class="form-control form-control-sm"
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
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('amount')"
                                >
                                    Amount (RM)
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
                            <div class="text-sm text-center h-6">
                                <div class="text-sm text-center h-6">
                                    <input
                                        v-model.lazy="search"
                                        type="search"
                                        class="w-16 placeholder:text-xs placeholder:text-center h-8"
                                        placeholder="Search type"
                                    />
                                </div>
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
                                    Expected Forecast
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
                            <div class="text-sm text-center h-6">
                                <div class="text-sm text-center h-6">
                                    <input
                                        v-model.lazy="search"
                                        type="search"
                                        class="w-16 placeholder:text-xs placeholder:text-center h-8"
                                        placeholder="Search industry"
                                    />
                                </div>
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
                                    <input
                                        v-model.lazy="search"
                                        type="search"
                                        class="w-16 placeholder:text-xs placeholder:text-center h-8"
                                        placeholder="Search category"
                                    />
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
                                    Confirmed
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
                            <!-- <div class="text-sm text-center h-6">
                                <div class="text-sm text-center h-6">
                                    <input
                                        v-model.lazy="search"
                                        type="search"
                                        class="w-16 placeholder:text-xs placeholder:text-center h-8"
                                        placeholder="Search address"
                                    />
                                </div>
                            </div> -->
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('forecast_result')
                                    "
                                >
                                    Rejected
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
                            <!-- <div class="text-sm text-center h-6">
                                <div class="text-sm text-center h-6">
                                    <input
                                        v-model.lazy="search"
                                        type="search"
                                        class="w-16 placeholder:text-xs placeholder:text-center h-8"
                                        placeholder="Search address"
                                    />
                                </div>
                            </div> -->
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6"></div>
                        </th>
                    </tr>
                </thead>
                <!-- <tbody class="mt-2">
                    <tr v-for="forecast in forecasts.data" :key="forecast.id">
                        <td class="text-xs">{{ forecast.forecast_updatedate }}</td>
                        <td class="text-xs">
                            <router-link
                                :to="`/forecasts/${forecast.id}/info`"
                                custom
                                v-slot="{ navigate, href }"
                            >
                                <a :href="href" @click.stop="navigate">{{
                                    forecast.contact.name
                                }}</a>
                            </router-link>
                        </td>
                        <td class="text-xs">{{ forecast.user.name }}</td>
                        <td class="text-xs">{{ forecast.product.name }}</td>
                        <td class="text-xs">{{ forecast.amount }}</td>
                        <td class="text-xs">{{ forecast.forecast_date }}</td>                        
                        <td class="text-xs">{{ forecast.type.name }}</td>
                        <td class="text-xs">{{ forecast_result_id }}</td>
                        <td class="text-xs">{{ forecast.forecast_result_id }}</td>
                        <td class="text-xs">
                            <router-link
                                :to="{
                                    name: 'forecasts_edit',
                                    params: { id: forecast.id },
                                }"
                                class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                            <PencilSquareIcon class="h-3 w-3"/></router-link
                            >
                            <button
                                class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                @click="deleteForecast(forecast.id)"
                            >
                                <TrashIcon class="h-3 w-3"/>
                            </button>
                        </td>
                    </tr>
                </tbody> -->
                <tbody class="mt-2">
                    <tr>
                        <td class="text-xs">1</td>
                        <td class="text-xs">updatedate</td>
                        <td class="text-xs">
                            <a> ContactName </a>
                        </td>
                        <td class="text-xs">User Name</td>
                        <td class="text-xs">Product</td>
                        <td class="text-xs">Amount</td>
                        <td class="text-xs">Forecast Date</td>
                        <td class="text-xs">Type</td>
                        <td class="text-xs">Checkbox confirm</td>
                        <td class="text-xs">Checkbox reject</td>
                        <td class="text-xs">
                            Edit forecast button and Delete Forecast Button
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
import {
    PencilSquareIcon,
    TrashIcon,
    PlusIcon,
    UserPlusIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        Pagination: LaravelVuePagination,
        PencilSquareIcon,
        TrashIcon,
        PlusIcon,
        UserPlusIcon,
    },

    mounted() {
        this.getForecasts();
        this.getUsers();
    },
    data() {
        return {
            forecasts: [],
            paginate: 50,

            search: "",
            selectedStatus: "",

            sort_direction: "desc",
            sort_field: "created_at",
            users: "",
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
                        "&selectedUsers=" +
                        this.selectedUsers +
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
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
