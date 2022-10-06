<template>
    <div class="container">
        <h1
            class="items-center text-center text-4xl text-white font-extrabold font-mono uppercase bg-slate-400 px-2 rounded-md"
        >
            Contact Summary
        </h1>

        <div class="">
            <div class="grid grid-cols-5 items-center">
                <div class="grid grid-cols-1 items-left m-2">
                    <label for="paginate" class="">Per Page</label>
                    <select v-model="paginate" class="form-control">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
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

                <div>
                    <div>
                        <a
                            v-if="checked.length > 0"
                            class="px-2 py-1 ml-2 align-bottom text-center bg-emerald-300 rounded-md text-xs"
                            type="button"
                            :href="url"
                            download="file.xlsx"
                        >
                            <button @click="exportSelected()" class="h-1">
                                <ArrowTopRightOnSquareIcon
                                    class="h-5 w-5 mr-1 inline-block"
                                />
                                <p class="inline-block">Export</p>
                            </button>
                        </a>
                    </div>

                    <!-- <div v-if="checked.length > 0" class="inline-block">
                    <div
                        v-if="
                            selectAll || contacts.meta.total == checked.length
                        "
                    >
                        Selected all:
                        <strong>{{ checked.length }}</strong> record(s).
                    </div>
                    <div v-else>
                        Selected:
                        <strong>{{ checked.length }}</strong> record(s), All:
                        <strong>{{ contacts.meta.total }}</strong>
                        <a
                            @click.prevent="selectAllRecords"
                            href="#"
                            class="ml-2"
                            >Select All</a
                        >
                    </div>
                </div>

                <div class="inline-block" v-if="selectPage">
                    <div
                        v-if="
                            selectAll || contacts.meta.total == checked.length
                        "
                    >
                        Selected all:
                        <strong>{{ checked.length }}</strong> record(s).
                    </div>
                    <div v-else>
                        Selected:
                        <strong>{{ checked.length }}</strong> record(s), All:
                        <strong>{{ contacts.meta.total }}</strong>
                        <a
                            @click.prevent="selectAllRecords"
                            href="#"
                            class="ml-2"
                            >Select All</a
                        >
                    </div>
                </div> -->
                </div>
                <div class="py-1 inline-block">
                    <Pagination
                        :data="contacts"
                        @pagination-change-page="getContacts"
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
                        <tr class="w-max">
                            <th>
                                <input type="checkbox" v-model="selectPage" />
                            </th>
                            <!-- <th class="text-xs">No.</th> -->
                            <!-- <th class="py-3">
                            <div class="text-xs text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('created_at')"
                                >
                                    Date<br />Created
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'created_at'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'created_at'
                                    "
                                    >&darr;</span
                                >
                            </div>
                        </th> -->
                            <th class="py-3 w-2">
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
                                            v-model="selectedType"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="contact_type in types.data"
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
                                        @click.prevent="
                                            change_sort('category_name')
                                        "
                                    >
                                        Category
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
                                            v-model="selectedCategory"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="category in categories.data"
                                                :key="category.id"
                                                :value="category.id"
                                            >
                                                {{ category.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('industry_name')
                                        "
                                    >
                                        Industry
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'industry_name'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'industry_name'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div class="text-xs text-center h-6">
                                    <div class="text-xs text-center h-6">
                                        <select
                                            v-model="selectedIndustry"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="industry in industries.data"
                                                :key="industry.id"
                                                :value="industry.id"
                                            >
                                                {{ industry.name }}
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
                                    >
                                        Contact
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'name'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'name'
                                        "
                                        >&darr;</span
                                    >
                                </div>
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
                            v-for="(contact, index) in contacts.data"
                            :key="contact.id"
                            :class="
                                isChecked(contact.id) ? 'table-primary' : ''
                            "
                        >
                            <td>
                                <input
                                    type="checkbox"
                                    :value="contact.id"
                                    v-model="checked"
                                />
                            </td>
                            <!-- <td class="text-xs">{{ index + 1 }}</td> -->
                            <!-- <td class="text-xs">{{ contact.created_at }}</td> -->
                            <td class="text-xs break-normal w-2">{{ contact.user_name }}</td>
                            <td class="text-xs break-normal">{{ contact.status_name }}</td>
                            <td class="text-xs">{{ contact.type_name }}</td>
                            <td class="text-xs break-normal">{{ contact.category_name }}</td>
                            <td class="text-xs break-normal">{{ contact.industry_name }}</td>
                            <td class="text-xs break-normal">
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
                            <td
                                v-if="contact.summary['Jan2022']"
                                class="text-xs "
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`Jan` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max"
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary['Feb2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`Feb` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                        <br />
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary['Mar2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`Mar` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                        <br />
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary['Apr2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`Apr` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                        <br />
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary['May2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`May` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                        <br />
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary['Jun2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`Jun` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                        <br />
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary['Jul2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`Jul` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                        <br />
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary['Aug2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`Aug` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary['Sep2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`Sep` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary['Oct2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`Oct` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary['Nov2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`Nov` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary['Dec2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary[`Dec` + this.selectedYear]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                    >
                                        {{ showToday(summary_info["todo_date"]) }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>
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
        this.getContacts();
        this.getStatus();
        this.getTypes();
        this.getUsers();
        this.getCategories();
        this.getIndustries();
    },
    data() {
        return {
            contacts: [],
            statuses: [],
            users: [],
            types: [],
            industries: [],
            categories: [],

            paginate: 50,
            moment: moment,
            selectPage: false,
            selectAll: false,
            checked: [],
            url: "",

            search: "",
            selectedYear: "",
            selectedStatus: "",
            selectedUser: "",
            selectedType: "",
            selectedCategory: "",
            selectedIndustry: "",

            sort_direction: "asc",
            sort_field: "id",
            currentDate: "",
        };
    },
    watch: {
        paginate: function (value) {
            this.getContacts();
        },
        search: function (value) {
            this.getContacts();
        },
        selectedStatus: function (value) {
            this.getContacts();
        },
        selectedUser: function (value) {
            this.getContacts();
        },
        selectedType: function (value) {
            this.getContacts();
        },
        selectedCategory: function (value) {
            this.getContacts();
        },
        selectedIndustry: function (value) {
            this.getContacts();
        },

        selectPage: function (value) {
            this.checked = [];
            if (value) {
                this.contacts.data.forEach((contact) => {
                    this.checked.push(contact.id);
                });
            } else {
                this.checked = [];
                this.selectAll = false;
            }
        },

        checked: function (value) {
            this.url = "/api/contacts/exportSummary/" + this.checked;
        },
    },

    computed: {},

    methods: {
        getContacts(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/contacts/summary?" +
                        "q=" +
                        this.search +
                        "&selectedYear=" +
                        this.selectedYear +
                        "&selectedStatus=" +
                        this.selectedStatus +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedType=" +
                        this.selectedType +
                        "&selectedCategory=" +
                        this.selectedCategory +
                        "&selectedIndustry=" +
                        this.selectedIndustry +
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
                    this.contacts = res.data;
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

        async getTypes() {
            await axios
                .get("/api/contacts/type/index")
                .then((res) => {
                    this.types = res.data;
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

        async getCategories() {
            await axios
                .get("/api/contacts/category/index")
                .then((res) => {
                    this.categories = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getIndustries() {
            await axios
                .get("/api/contacts/industry/index")
                .then((res) => {
                    this.industries = res.data;
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
            await this.getContacts();
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

        exportSelected() {
            if (this.checked.length === 0) {
                return alert("Need select record.");
            } else {
                axios.get("/api/contacts/exportSummary");
            }
        },

        isChecked(contact_id) {
            return this.checked.includes(contact_id);
        },

        async selectAllRecords() {
            await axios.get("/api/contacts/all").then((response) => {
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
