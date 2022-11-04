<template>
    <div class="w-max container" id="index-container">
        <h1
            class="items-center text-center text-5xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
        >
            Contact List
        </h1>

        <div class="flex">
            <div>
                <router-link
                    to="/contact/create"
                    class="inline-block items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    <UserPlusIcon class="h-6 w-6 inline" /> contact</router-link
                >
            </div>

            <div
                class="py-2 ml-3 inline-block"
                v-if="can('view contact summary') || is('super-admin')"
            >
                <router-link
                    to="/contact/summary"
                    class="inline-block items-center px-2 py-1 bg-slate-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >Contact Summary</router-link
                >
            </div>

            <div>
                <div class="mx-2">
                    <a
                        v-if="checked.length > 0"
                        class="px-2 py-2 align-bottom text-center bg-blue-400 border-black border-2 rounded-md text-xs"
                        type="button"
                        :href="url"
                        download="file.xlsx"
                    >
                        <button @click="exportSelected()" class="h-1">
                            <ArrowTopRightOnSquareIcon
                                class="h-5 w-5 mr-1 inline-block"
                            />
                            <p
                                class="inline-block text-black uppercase font-extrabold"
                            >
                                Export
                            </p>
                        </button>
                    </a>

                    <div
                        v-if="checked.length > 0 && !selectPage"
                        class="inline-block"
                    >
                        <div
                            class="inline-block mx-1"
                            v-if="
                                selectAll ||
                                contacts.meta.total == checked.length
                            "
                        >
                            Selected:
                            <strong>{{ checked.length }}</strong> record(s).
                        </div>
                        <div v-else class="inline-block mx-1">
                            Selected:
                            <strong>{{ checked.length }}</strong> record(s)
                            <a
                                v-if="
                                    can('export contact all') ||
                                    is('admin | super-admin')
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
                            v-if="
                                selectAll ||
                                contacts.meta.total == checked.length
                            "
                        >
                            Selected:
                            <strong>{{ checked.length }}</strong> record(s).
                        </div>
                        <div v-else class="inline-block mx-1">
                            Selected:
                            <strong>{{ checked.length }}</strong> record(s)
                            <a
                                v-if="
                                    can('export contact all') ||
                                    is('admin | super-admin')
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
        </div>

        <div class="">
            <div class="grid grid-cols-3 items-center">
                <div class="grid grid-cols-2 items-left m-2">
                    <label for="paginate" class="">Per Page</label>
                    <input v-model.lazy="paginate" class="form-control" />
                    <!-- <select v-model="paginate" class="form-control">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> -->
                </div>

                <div>
                    <input
                        v-model.lazy="search"
                        type="search"
                        class="form-control"
                        placeholder="Search by any..."
                    />
                </div>

                <div class="py-1">
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
                <table class="table table-hover table-bordered w-full">
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th
                                v-if="
                                    can('export contact') ||
                                    is('admin | super-admin')
                                "
                            >
                                <input type="checkbox" v-model="selectPage" />
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6 w-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('created_at')
                                        "
                                        class="text-white"
                                    >
                                        Date<br />Created
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'created_at')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'created_at'
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
                                    v-if="
                                        is('admin | supervisor | super-admin')
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
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('status_name')
                                        "
                                        class="text-white"
                                    >
                                        Status
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'status_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'status_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'status_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
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
                                        @click.prevent="
                                            change_sort('type_name')
                                        "
                                        class="text-white"
                                    >
                                        Type
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'type_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'type_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'type_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <div class="text-sm text-center h-6">
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
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('industry_name')
                                        "
                                        class="text-white"
                                    >
                                        Industry
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'industry_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'industry_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'industry_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6 w-24"
                                >
                                    <select
                                        v-model="selectedIndustry"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="industry in industries.data"
                                            :key="industry.id"
                                            :value="industry.id"
                                        >
                                            {{ industry.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('name')"
                                        class="text-white"
                                    >
                                        Name
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
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('category_name')
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
                                                !(sort_field == 'category_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'category_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'category_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6 w-24"
                                >
                                    <select
                                        v-model="selectedCategory"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="category in categories.data"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('address')"
                                        class="text-white"
                                    >
                                        Address
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'address')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'address'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'address'
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
                                        @click.prevent="change_sort('remark')"
                                        class="text-white"
                                    >
                                        Remark
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'remark')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'remark'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'remark'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6 text-white">
                                    Action
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr
                            v-for="contact in contacts.data"
                            :key="contact.id"
                            :class="
                                isChecked(contact.id) ? 'table-primary' : ''
                            "
                        >
                            <td
                                v-if="
                                    can('export contact') ||
                                    is('admin | super-admin')
                                "
                            >
                                <input
                                    type="checkbox"
                                    :value="contact.id"
                                    v-model="checked"
                                />
                            </td>
                            <td class="text-xs">
                                {{ showToday(contact.created_at) }}
                            </td>
                            <td class="text-xs">{{ contact.user.name }}</td>
                            <td class="text-xs">{{ contact.status.name }}</td>
                            <td class="text-xs">{{ contact.type.name }}</td>
                            <td class="text-xs">{{ contact.industry.name }}</td>
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
                            <td class="text-xs">{{ contact.category.name }}</td>
                            <td class="text-xs">{{ contact.address }}</td>
                            <td class="text-xs">
                                {{ contact.remark }}
                                <button
                                    @click="toggleRemark(contact.id)"
                                    class="align-middle border-1 border-black w-max rounded-md px-1"
                                >
                                    <QuestionMarkCircleIcon class="inline h-4 w-4" />
                                </button>
                            </td>
                            <td class="text-xs">
                                <div
                                    v-if="
                                        can('insert todo') || is('super-admin')
                                    "
                                >
                                    <router-link
                                        :to="{
                                            name: 'todo_insert',
                                            params: { id: contact.id },
                                        }"
                                        class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        <PlusIcon class="h-5 w-5 mr-1" /> To
                                        Do</router-link
                                    >
                                </div>

                                <br />
                                <div
                                    v-if="
                                        can('edit contact') || is('super-admin')
                                    "
                                >
                                    <router-link
                                        :to="{
                                            name: 'contacts_edit',
                                            params: { id: contact.id },
                                        }"
                                        class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        <PencilSquareIcon class="h-3 w-3"
                                    /></router-link>
                                </div>

                                <div
                                    v-if="
                                        can('delete contact') ||
                                        is('super-admin')
                                    "
                                >
                                    <button
                                        class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                        @click="deletecontact(contact.id)"
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

        <ContactRemarkModalVue
            v-if="contact_remark_visibility"
            @toggle-modal="toggleRemark(contact_id)"
            :contact_id="contact_remark"
        />
    </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import moment from "moment";
import ContactRemarkModalVue from "./ContactRemarkModal.vue";

import {
    PencilSquareIcon,
    TrashIcon,
    UserPlusIcon,
    PlusIcon,
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
    ArrowUpIcon,
    ArrowDownIcon,
    QuestionMarkCircleIcon
} from "@heroicons/vue/24/solid";

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
        QuestionMarkCircleIcon,
        ContactRemarkModalVue,
    },

    mounted() {
        this.getStatus();
        this.selectedUser = document
            .querySelector('meta[name="user-id"]')
            .getAttribute("content");
        this.getUsers();
        this.getIndustries();
        this.getTypes();
        this.getCategories();
        this.getContacts();
    },
    data() {
        return {
            contacts: [],
            types: [],
            users: [],
            statuses: [],
            industries: [],
            categories: [],
            contact_remark_visibility: false,
            contact_remark: null,

            paginate: 100,
            selectPage: false,
            selectAll: false,
            checked: [],
            url: "",

            search: "",
            selectedUser: "",
            selectedStatus: "",
            selectedType: "",
            selectedIndustry: "",
            selectedCategory: "",

            sort_direction: "desc",
            sort_field: "created_at",
            moment: moment,
        };
    },
    watch: {
        paginate: function (value) {
            this.getContacts();
        },
        search: function (value) {
            this.getContacts();
        },
        selectedUser: function (value) {
            this.getContacts();
        },
        selectedStatus: function (value) {
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
        selectedCategory: function (value) {
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
            this.url = "/api/contacts/export/" + this.checked;
        },
    },

    methods: {
        toggleRemark(contact_id) {
            this.contact_remark = contact_id;
            this.contact_remark_visibility = !this.contact_remark_visibility;
        },

        getContacts(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/contacts/index?" +
                        "q=" +
                        this.search +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedStatus=" +
                        this.selectedStatus +
                        "&selectedType=" +
                        this.selectedType +
                        "&selectedIndustry=" +
                        this.selectedIndustry +
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
        getStatus() {
            axios
                .get("/api/contacts/status/index")
                .then((res) => {
                    this.statuses = res.data;
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

        getTypes() {
            axios
                .get("/api/contacts/type/index")
                .then((res) => {
                    this.types = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getIndustries() {
            axios
                .get("/api/contacts/industry/index")
                .then((res) => {
                    this.industries = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getCategories() {
            axios
                .get("/api/contacts/category/index")
                .then((res) => {
                    this.categories = res.data;
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

        deletecontact(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/contacts/delete/" + id);
            this.getContacts();
        },

        exportSelected() {
            if (this.checked.length === 0) {
                return alert("Need select record.");
            } else {
                axios.get("/api/contacts/export");
            }
        },

        isChecked(contact_id) {
            return this.checked.includes(contact_id);
        },

        selectAllRecords() {
            axios.get("/api/contacts/all").then((response) => {
                this.checked = response.data;
                this.selectAll = true;
            });
        },

        showToday(date) {
            let new_date = new Date(date);
            let day = moment(new_date).format("DD-MM-YY");
            return day;
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
