<template>

    <h1
        class="items-center text-center text-4xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
    >
        Contact Summary
    </h1>

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
                :data="contacts"
                @pagination-change-page="getContacts"
                :size="'small'"
                :align="'center'"
                class="pagination"
            />
        </div>

        <div
            class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto"
        >
            <table class="table table-hover table-bordered w-full">
                <thead class="bg-slate-400 border-b sticky top-0">
                    <tr>
                        <th>No.</th>
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
                        <th class="py-3">
                            <div class="text-xs text-center h-6">
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
                                    @click.prevent="change_sort('status_name')"
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
                            <!-- <div class="text-xs text-center h-6">
                                <div class="text-xs text-center h-6">
                                    <input
                                        v-model.lazy="search"
                                        type="search"
                                        class="w-16 placeholder:text-xs placeholder:text-center h-8"
                                        placeholder="Search contact"
                                    />
                                </div>
                            </div> -->
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
                    >
                        <td class="text-xs">{{ index + 1 }}</td>
                        <!-- <td class="text-xs">{{ contact.created_at }}</td> -->
                        <td class="text-xs">{{ contact.user_name }}</td>
                        <td class="text-xs">{{ contact.status_name }}</td>
                        <td class="text-xs">{{ contact.type_name }}</td>
                        <td class="text-xs">{{ contact.category_name }}</td>
                        <td class="text-xs">
                            <router-link
                                class="mr-2"
                                :to="`/contact/${contact.id}/info`"
                                custom
                                v-slot="{ navigate, href }"
                            >
                                <a :href="href" @click.stop="navigate">{{
                                    contact.name
                                }}</a>
                            </router-link>
                        </td>
                        <!-- <td class="text-xs">{{ contact.summary.todo_date }}</td> -->
                        <!-- <tr> -->
                        <!-- <td class="text-xs">1</td> -->
                        <!-- <td class="text-xs">Date</td> -->
                        <!-- <td class="text-xs">User</td>
                        <td class="text-xs">Status</td>
                        <td class="text-xs">Type</td>
                        <td class="text-xs">Category</td>
                        <td class="text-xs">Company</td> -->
                        <td class="text-xs">
                            Jan
                            <span></span>
                        </td>
                        <td class="text-xs">
                            <span
                                v-for="summary_info in contact.summary"
                                :key="summary_info.id"
                                >{{ summary_info.todo_date }} <br/></span
                            >
                        </td>
                        <td class="text-xs">Mar</td>
                        <td class="text-xs">Apr</td>
                        <td class="text-xs">May</td>
                        <td class="text-xs">June</td>
                        <td class="text-xs">July</td>
                        <td class="text-xs">Aug</td>
                        <td class="text-xs">Sep</td>
                        <td class="text-xs">Oct</td>
                        <td class="text-xs">Nov</td>
                        <td class="text-xs">Dec</td>
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
    UserPlusIcon,
    PlusIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        Pagination: LaravelVuePagination,
        PencilSquareIcon,
        TrashIcon,
        UserPlusIcon,
        PlusIcon,
    },

    mounted() {
        this.getContacts();
        this.getStatus();
        this.getTypes();
        this.getUsers();
        this.getCategories();
    },
    data() {
        return {
            contacts: [],
            statuses: [],
            users: [],
            types: [],
            categories: [],
            paginate: 50,

            search: "",
            selectedStatus: "",
            selectedUser: "",
            selectedType: "",
            selectedCategory: "",

            sort_direction: "asc",
            sort_field: "id",
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
    },

    methods: {
        async getContacts(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            await axios
                .get(
                    "/api/contacts/summary?" +
                        "q=" +
                        this.search +
                        "&selectedStatus=" +
                        this.selectedStatus +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedType=" +
                        this.selectedType +
                        "&selectedCategory=" +
                        this.selectedCategory +
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
                .get("/api/contacttype/index")
                .then((res) => {
                    this.types = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getStatus() {
            await axios
                .get("/api/contactstatus/index")
                .then((res) => {
                    this.statuses = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getCategories() {
            await axios
                .get("/api/contactcategory/index")
                .then((res) => {
                    this.categories = res.data;
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
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
