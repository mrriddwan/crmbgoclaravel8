<template>
    <router-link
        to="/dashboard"
        class="inline-block items-center px-2 py-1 bg-gray-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
    >
        Contact</router-link
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
    <h1
        class="items-center text-center text-6xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
    >
        Contact Index
    </h1>

    <router-link
        to="/contacts/create"
        class="ml-1 inline-block items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
    >
        <UserPlusIcon class="h-6 w-6 inline"/> contact</router-link
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
                :data="contacts"
                @pagination-change-page="getContacts"
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
                                <a
                                    href="#"
                                    @click.prevent="change_sort('created_at')"
                                >
                                    Date Created
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

                            <div class="text-sm text-center h-6">
                                <input
                                    v-model.lazy="search"
                                    type="search"
                                    class="w-16 placeholder:text-xs placeholder:text-center h-8"
                                    placeholder="Search date"
                                />
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
                            <div class="text-sm text-center h-6">
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
                                        placeholder="Search type"
                                    />
                                </div>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('industry')"
                                >
                                    Industry
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'industry'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'industry'
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
                            <div class="text-sm text-center h-6">
                                <div class="text-sm text-center h-6">
                                    <input
                                        v-model.lazy="search"
                                        type="search"
                                        class="w-16 placeholder:text-xs placeholder:text-center h-8"
                                        placeholder="Search contact"
                                    />
                                </div>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
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
                                        sort_field == 'category_name'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'category_name'
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
                                    @click.prevent="change_sort('address')"
                                >
                                    Address
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'address'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'address'
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
                                        placeholder="Search address"
                                    />
                                </div>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('remark')"
                                >
                                    Remark
                                </a>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'remark'
                                    "
                                    >&uarr;</span
                                >
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'remark'
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
                                        placeholder="Search remark"
                                    />
                                </div>
                            </div>
                        </th>
                        <th class="py-3">
                            <div class="text-sm text-center h-6">Action</div>
                            <div class="text-sm text-center h-6"></div>
                        </th>
                    </tr>
                </thead>
                <tbody class="mt-2">
                    <tr v-for="contact in contacts.data" :key="contact.id">
                        <td class="text-xs">{{ contact.created_at }}</td>
                        <td class="text-xs">{{ contact.user.name }}</td>
                        <td class="text-xs">{{ contact.status.name }}</td>
                        <td class="text-xs">{{ contact.type.name }}</td>
                        <td class="text-xs">{{ contact.industry.name }}</td>
                        <td class="text-xs">
                            <router-link
                                :to="`/contacts/${contact.id}/info`"
                                custom
                                v-slot="{ navigate, href }"
                            >
                                <a :href="href" @click.stop="navigate">{{
                                    contact.name
                                }}</a>
                            </router-link>
                        </td>
                        <td class="text-xs">{{ contact.category.name }}</td>
                        <td class="text-xs">{{ contact.address }}</td>
                        <td class="text-xs">{{ contact.remark }}</td>
                        <td class="text-xs">
                            <router-link
                                :to="{
                                    name: 'todo_insert',
                                    params: { id: contact.id },
                                }"
                                class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                            <PlusIcon class="h-5 w-5 mr-1"/> To Do</router-link
                            >
                            <router-link
                                :to="{
                                    name: 'contacts_edit',
                                    params: { id: contact.id },
                                }"
                                class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                            <PencilSquareIcon class="h-3 w-3"/></router-link
                            >
                            <button
                                class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                @click="deletecontact(contact.id)"
                            >
                                <TrashIcon class="h-3 w-3"/>
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
import { PencilSquareIcon, TrashIcon, UserPlusIcon, PlusIcon } from "@heroicons/vue/24/solid";

export default {
    components: {
        Pagination: LaravelVuePagination,
        PencilSquareIcon,
        TrashIcon,
        UserPlusIcon,
        PlusIcon
    },

    mounted() {
        this.getContacts();
        this.getStatus();
    },
    data() {
        return {
            contacts: [],
            paginate: 50,

            search: "",
            selectedStatus: "",

            sort_direction: "desc",
            sort_field: "created_at",
            statuses: "",
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
    },

    methods: {
        getContacts(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/contacts/index?" +
                        "q=" +
                        this.search +
                        "&selectedStatus=" +
                        this.selectedStatus +
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
        getStatus() {
            axios
                .get("/api/contactstatus/index")
                .then((res) => {
                    this.statuses = res.data;
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
            this.getContacts();
        },

        searchType() {},

        deletecontact(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/contacts/delete/" + id);
            this.getContacts();
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
