<template>
    <div class="container w-max">
        <h1
            class="items-center text-center text-5xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
        >
            Follow Up List
        </h1>

        <div class="text-sm mb-2">
            <div class="py-1 w-max">
                <div class="border border-gray-500 inline-block">
                    <div class="m-1 inline-block items-center px-1 py-1">
                        <p>View by</p>
                        <select
                            v-model="viewType"
                            class="form-control text-center"
                        >
                            <option value="day">Day</option>
                            <option value="month">Month</option>
                            <option value="range">Date Range</option>
                        </select>
                    </div>
                    <div class="m-1 inline-block items-center px-1 py-1">
                        <span v-show="viewType === `day`">
                            <p>Select date</p>
                            <div class="px-2">
                                <VueDatePicker
                                    v-model="selectedDate"
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                />
                            </div>
                        </span>
                        <span v-show="viewType === `month`">
                            <p>Select month/year</p>
                            <input
                                v-model.lazy="currentMonth"
                                class="border-gray-300"
                                type="month"
                            />
                        </span>

                        <span
                            v-show="viewType === `range`"
                            class="inline-block items-center py-1"
                        >
                            <div class="border-gray-800 flex px-1 py-1">
                                <p class="px-1 mt-1">Start date</p>

                                <div class="px-2">
                                    <VueDatePicker
                                        v-model="selectedDateStart"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                    />
                                </div>
                            </div>
                            <div class="border-gray-800 flex px-1 py-1">
                                <p class="px-1">End date</p>
                                <div class="px-2">
                                    <VueDatePicker
                                        v-model="selectedDateEnd"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                    />
                                </div>
                            </div>
                        </span>
                    </div>
                </div>

                <div class="m-1 inline-block items-center px-1 py-1">
                    <p>Filter term</p>
                    <input
                        v-model.lazy="search"
                        type="search"
                        class="form-control"
                        placeholder="Search by any..."
                    />
                </div>
                <div
                    class="m-1 inline-block items-center px-1 py-1"
                    v-if="is('supervisor | admin | super-admin')"
                >
                    <p>Select user</p>
                    <select v-model="selectedUser" class="form-control">
                        <option value="">All User</option>
                        <option
                            v-for="user in users"
                            :key="user.id"
                            :value="user.id"
                        >
                            {{ user.name }}
                        </option>
                    </select>
                </div>

                <div class="border-gray-400 inline-block px-1 py-1">
                    <p for="paginate">Total entries</p>
                    <select v-model="paginate" class="form-control">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <div class="inline-block ml-1">
                    <div class="inline-block py-1">
                        <span v-if="viewType === 'day'">
                            <Pagination
                                :data="followups"
                                @pagination-change-page="getFollowUpsSelectDate"
                                :size="'small'"
                                :align="'right'"
                                class="pagination"
                            />
                        </span>
                        <span v-else-if="viewType === 'month'">
                            <Pagination
                                :data="followups"
                                @pagination-change-page="
                                    getFollowUpsSelectMonth
                                "
                                :size="'small'"
                                :align="'right'"
                                class="pagination"
                            />
                        </span>

                        <span v-else-if="viewType === 'range'">
                            <Pagination
                                :data="followups"
                                @pagination-change-page="
                                    getFollowUpsSelectDateRange
                                "
                                :size="'small'"
                                :align="'right'"
                                class="pagination"
                            />
                        </span>
                    </div>
                </div>
            </div>
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
                    v-if="selectAll || followups.meta.total == checked.length"
                >
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s).
                </div>
                <div v-else class="inline-block mx-1">
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s)
                    <a
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
                    v-if="selectAll || followups.meta.total == checked.length"
                >
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s).
                    <a
                        @click.prevent="selectAllRecords"
                        href="#"
                        class="ml-1 rounded-md bg-yellow-400 border-2 border-black uppercase text-black text-xs px-1"
                        >Select All</a
                    >
                </div>
                <div v-else class="inline-block mx-1">
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s)
                    <a
                        @click.prevent="selectAllRecords"
                        href="#"
                        class="ml-1 rounded-md bg-yellow-400 border-2 border-black uppercase text-black text-xs px-1"
                        >Select All</a
                    >
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 w-full text-center bg-slate-400">
            <div class="text-left">
                <button
                    class="text-xl text-left px-3 py-3"
                    id="decrementDate"
                    @click="decrementDate"
                >
                    <ChevronDoubleLeftIcon
                        class="h-6 w-6 bg-blue-300 rounded-lg"
                    />
                </button>
            </div>
            <span v-show="viewType === `day`">
                <div class="mt-2">
                    <h3 class="uppercase text-white font-extrabold">
                        {{ showToday(selectedDate) }}
                    </h3>
                </div>
            </span>
            <span v-show="viewType === `month`">
                <div class="mt-2">
                    <h3 class="uppercase text-white font-extrabold">
                        {{ showMonth(selectedMonthYear) }}
                    </h3>
                </div>
            </span>
            <span v-show="viewType === `range`">
                <div class="mt-1 inline-flex">
                    <h3
                        class="uppercase text-white font-extrabold inline-flex w-max"
                    >
                        {{ showToday(selectedDateStart) }}
                    </h3>
                    <h3
                        class="text-white font-extrabold inline-flex mx-3 w-max"
                    >
                        -
                    </h3>
                    <h3
                        class="uppercase text-white font-extrabold inline-flex w-max"
                    >
                        {{ showToday(selectedDateEnd) }}
                    </h3>
                </div>
            </span>

            <div class="text-right">
                <button
                    class="text-5xl text-right px-3 py-3"
                    id="incrementDate"
                    @click="incrementDate"
                >
                    <ChevronDoubleRightIcon
                        class="h-6 w-6 bg-blue-300 rounded-lg"
                    />
                </button>
            </div>
        </div>

        <div>
            <table class="table table-hover table-bordered" id="example">
                <thead class="bg-slate-500">
                    <tr>
                        <th>
                            <input type="checkbox" v-model="selectPage" />
                        </th>
                        <th>#</th>
                        <th>
                            <a
                                href="#"
                                @click.prevent="change_sort('followup_date')"
                                class="text-white"
                            >
                                Date<br />Follow Up
                                <span
                                    v-if="
                                        (!(sort_direction == 'asc') ||
                                            !(sort_direction == 'desc')) &&
                                        !(sort_field == 'followup_date')
                                    "
                                    class="inline-block"
                                    ><ArrowsUpDownIcon class="h-4 w-4"
                                /></span>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'followup_date'
                                    "
                                    class="inline-block"
                                    ><ArrowUpIcon class="h-4 w-4"
                                /></span>
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'followup_date'
                                    "
                                    class="inline-block"
                                    ><ArrowDownIcon class="h-4 w-4"
                                /></span>
                            </a>
                            <div></div>
                        </th>
                        <th>
                            <a
                                href="#"
                                @click.prevent="change_sort('followup_time')"
                                class="text-white"
                            >
                                Time<br />Follow Up
                                <span
                                    v-if="
                                        (!(sort_direction == 'asc') ||
                                            !(sort_direction == 'desc')) &&
                                        !(sort_field == 'followup_time')
                                    "
                                    class="inline-block"
                                    ><ArrowsUpDownIcon class="h-4 w-4"
                                /></span>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'followup_time'
                                    "
                                    class="inline-block"
                                    ><ArrowUpIcon class="h-4 w-4"
                                /></span>
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'followup_time'
                                    "
                                    class="inline-block"
                                    ><ArrowDownIcon class="h-4 w-4"
                                /></span>
                            </a>
                        </th>
                        <th>
                            <a
                                href="#"
                                @click.prevent="change_sort('contact_name')"
                                class="text-white"
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
                        </th>
                        <th>
                            <a
                                href="#"
                                @click.prevent="change_sort('user_name')"
                                class="text-white"
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
                        </th>
                        <th>
                            <a
                                href="#"
                                @click.prevent="change_sort('task_name')"
                                class="text-white"
                            >
                                Task
                                <span
                                    v-if="
                                        (!(sort_direction == 'asc') ||
                                            !(sort_direction == 'desc')) &&
                                        !(sort_field == 'task_name')
                                    "
                                    class="inline-block"
                                    ><ArrowsUpDownIcon class="h-4 w-4"
                                /></span>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'task_name'
                                    "
                                    class="inline-block"
                                    ><ArrowUpIcon class="h-4 w-4"
                                /></span>
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'task_name'
                                    "
                                    class="inline-block"
                                    ><ArrowDownIcon class="h-4 w-4"
                                /></span>
                            </a>
                            <div class="text-sm text-center h-6">
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedTask"
                                        class="form-control form-control-sm w-max"
                                    >
                                        <option value="">All</option>
                                        <option
                                            v-for="task in tasks.data"
                                            :key="task.id"
                                            :value="task.id"
                                        >
                                            {{ task.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </th>
                        <th>
                            <a
                                href="#"
                                @click.prevent="change_sort('followup_remark')"
                                class="text-white"
                            >
                                Remark
                                <span
                                    v-if="
                                        (!(sort_direction == 'asc') ||
                                            !(sort_direction == 'desc')) &&
                                        !(sort_field == 'followup_remark')
                                    "
                                    class="inline-block"
                                    ><ArrowsUpDownIcon class="h-4 w-4"
                                /></span>
                                <span
                                    v-if="
                                        sort_direction == 'desc' &&
                                        sort_field == 'followup_remark'
                                    "
                                    class="inline-block"
                                    ><ArrowUpIcon class="h-4 w-4"
                                /></span>
                                <span
                                    v-if="
                                        sort_direction == 'asc' &&
                                        sort_field == 'followup_remark'
                                    "
                                    class="inline-block"
                                    ><ArrowDownIcon class="h-4 w-4"
                                /></span>
                            </a>
                        </th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(followup, index) in followups.data"
                        :key="followup.id"
                    >
                        <td>
                            <input
                                type="checkbox"
                                :value="followup.id"
                                v-model="checked"
                            />
                        </td>
                        <td>{{ index + 1 }}</td>
                        <td>{{ showToday(followup.followup_date) }}</td>
                        <td>
                            <span v-if="followup.followup_time">
                                {{ followup.followup_time }}
                            </span>
                            <span v-else> No time set</span>
                        </td>
                        <td>
                            <router-link
                                :to="`/contact/${followup.contact.id}/info`"
                                custom
                                v-slot="{ navigate, href }"
                            >
                                <a :href="href" @click.stop="navigate">{{
                                    followup.contact.name
                                }}</a>
                            </router-link>
                        </td>
                        <td>{{ followup.user.name }}</td>
                        <td>{{ followup.task.name }}</td>
                        <td>{{ followup.followup_remark }}</td>
                        <td>
                            <div
                                v-if="
                                    can('delete followup') ||
                                    is('supervisor | admin | super-admin')
                                "
                            >
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="deleteFollowUp(followup.id)"
                                >
                                    <TrashIcon class="h-3 w-3" />
                                </button>
                            </div>

                            <router-link
                                :to="{
                                    name: 'todo_index',
                                    params: {
                                        selectedDate: followup.followup_date,
                                    },
                                }"
                                class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                                <i class="fa-solid fa-pen-to-square"></i
                                ><EyeIcon
                                    class="h-4 w-4 mr-1"
                                />Todo</router-link
                            >
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
import { VueDatePicker } from "@vuepic/vue-datepicker";
import {
    PencilSquareIcon,
    TrashIcon,
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
    PlusIcon,
    LightBulbIcon,
    EyeIcon,
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
        ChevronDoubleLeftIcon,
        ChevronDoubleRightIcon,
        PlusIcon,
        LightBulbIcon,
        EyeIcon,
        ArrowTopRightOnSquareIcon,
        ArrowsUpDownIcon,
        VueDatePicker,
        ArrowUpIcon,
        ArrowDownIcon,
    },

    mounted() {
        this.getActions();
        this.getUsers();
        this.selectedUser = document.querySelector('meta[name="user-id"]').getAttribute('content');
        this.getTasks();
        console.log(
            "this is the route params from follow up, month?:" +
                this.$route.params.selectedMonth
        );
        console.log(
            "this is the route params from follow up, year?:" +
                this.$route.params.selectedYear
        );

        if (!this.$route.params) {
            this.currentDate = this.getCurrentDate();
            this.select = this.currentDate;
            this.getFollowUpsSelectMonth();
        } else {
            this.selectedMonth = this.$route.params.selectedMonth;
            this.selectedYear = this.$route.params.selectedYear;
            this.getFollowUpsSelectMonth();
        }
        //initial date selection
        console.log(
            "Result of mounted getCurrentDate: " + this.getCurrentDate()
        );
        this.currentDate = this.getCurrentDate();
        this.selectedDate = this.currentDate;
        // this.getSelectedDate(this.selectedDate);
        console.log("Result of mounted currrentDate: " + this.currentDate);
        //initialise date range
        this.selectedDateStart = this.selectedDate;
        this.selectedDateEnd = this.selectedDate;
        console.log(
            "Result of mounted selectedDateStart: " + this.selectedDateStart
        );
        console.log(
            "Result of mounted selectedDateEnd: " + this.selectedDateEnd
        );

        //initial month selection
        this.selectedMonth = this.getSelectedMonth(this.selectedDate);
        this.selectedYear = this.getSelectedYear(this.selectedDate);
        this.getFollowUpsSelectMonth();
        this.selectedMonthYear =
            this.selectedYear + "-" + this.selectedMonth + "-" + "01";
        this.currentMonth = this.selectedYear + "-" + this.selectedMonth;

        this.incrementDate();
        this.decrementDate();
    },
    data() {
        return {
            followups: [],
            tasks: [],
            users: [],

            paginate: 100,
            viewType: "month",
            moment: moment,

            search: "",
            selectPage: false,
            selectAll: false,
            checked: [],
            url: "",

            selectedUser: "",
            selectedTask: "",

            currentDate: "",
            currentMonth: "",
            currentYear: "",

            selectedDate: "",
            selectedMonth: "",
            selectedYear: "",
            selectedMonthYear: "",

            selectedDateStart: "",
            selectedDateEnd: "",

            sort_direction: "desc",
            sort_field: "created_at",
            actions: "",
        };
    },
    watch: {
        paginate: function (value) {
            if (this.viewType === "day") {
                this.getFollowUpsSelectDate();
            } else if (this.viewType === "month") {
                this.getFollowUpsSelectMonth();
            } else if (this.viewType === "range") {
                this.getFollowUpsSelectDateRange();
            }
        },
        search: function (value) {
            if (this.viewType === "day") {
                this.getFollowUpsSelectDate();
            } else if (this.viewType === "month") {
                this.getFollowUpsSelectMonth();
            } else if (this.viewType === "range") {
                this.getFollowUpsSelectDateRange();
            }
        },

        selectedUser: function (value) {
            if (this.viewType === "day") {
                this.getFollowUpsSelectDate();
            } else if (this.viewType === "month") {
                this.getFollowUpsSelectMonth();
            } else if (this.viewType === "range") {
                this.getFollowUpsSelectDateRange();
            }
        },

        selectedTask: function (value) {
            if (this.viewType === "day") {
                this.getFollowUpsSelectDate();
            } else if (this.viewType === "month") {
                this.getFollowUpsSelectMonth();
            } else if (this.viewType === "range") {
                this.getFollowUpsSelectDateRange();
            }
        },

        viewType: function (value) {
            if (value === "day") {
                if (this.viewType === "day") {
                    this.getFollowUpsSelectDate();
                }
            }
            if (value === "month") {
                const monthYear = this.selectedMonthYear;
                this.getSelectedMonth(monthYear);
                this.getSelectedYear(monthYear);
                console.log(
                    "Result of this.getSelectedMonth(monthYear): " +
                        this.getSelectedMonth(monthYear)
                );
                console.log(
                    "Result of this.getSelectedYear(monthYear): " +
                        this.getSelectedYear(monthYear)
                );
                this.getFollowUpsSelectMonth();
            }
            if (value === "range") {
                this.getSelectedDateStart(this.currentDate);
                this.getSelectedDateEnd(this.currentDate);
                this.getFollowUpsSelectDateRange();
            }
        },
        selectedDate: function (value) {
            if (this.viewType === "day") {
                this.getSelectedDate(this.selectedDate);
                this.getFollowUpsSelectDate();
            }
        },

        currentMonth: function (value) {
            const monthYear = this.currentMonth + "-" + "01";
            this.selectedMonthYear = monthYear;
            this.getSelectedMonth(monthYear);
            this.getSelectedYear(monthYear);
            this.getFollowUpsSelectMonth();
            console.log("current date after month change: " + this.currentDate);
        },

        selectedDateRange(newVal) {
            const [selectedDateStart, selectedDateEnd] = newVal.split("|");
            this.getSelectedDateStart(selectedDateStart);
            this.getSelectedDateEnd(selectedDateEnd);
            console.log(
                "result of date after this.getSelectedDateEnd(selectedDateStart): " +
                    this.getSelectedDateEnd(selectedDateStart)
            );
            console.log(
                "result of date after this.getSelectedDateEnd(selectedDateEnd): " +
                    this.getSelectedDateEnd(selectedDateEnd)
            );
            this.getFollowUpsSelectDateRange();
        },

        checked: function (value) {
            this.url = "/api/followups/export/" + this.checked;
        },

        selectPage: function (value) {
            this.checked = [];
            if (value) {
                this.followups.data.forEach((followup) => {
                    this.checked.push(followup.id);
                });
            } else {
                this.checked = [];
                this.selectAll = false;
            }
        },
    },
    computed: {
        selectedDateRange() {
            return `${this.selectedDateStart}|${this.selectedDateEnd}`;
        },
    },

    methods: {
        getFollowUpsSelectDate(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/followups/index?" +
                        "q=" +
                        this.search +
                        "&selectedDate=" +
                        this.selectedDate +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedTask=" +
                        this.selectedTask +
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
                    this.followups = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getFollowUpsSelectMonth(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/followups/index/monthrange?" +
                        "q=" +
                        this.search +
                        "&selectedMonth=" +
                        this.selectedMonth +
                        "&selectedYear=" +
                        this.selectedYear +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedTask=" +
                        this.selectedTask +
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
                    this.followups = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getFollowUpsSelectDateRange(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/followups/index/daterange?" +
                        "q=" +
                        this.search +
                        "&selectedDateStart=" +
                        this.selectedDateStart +
                        "&selectedDateEnd=" +
                        this.selectedDateEnd +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedTask=" +
                        this.selectedTask +
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
                    this.followups = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getUsers() {
            axios
                .get("/api/users/users_list")
                .then((res) => {
                    this.users = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getTasks() {
            axios
                .get("/api/tasks/index")
                .then((res) => {
                    this.tasks = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getActions() {
            axios
                .get("/api/actions/index")
                .then((res) => {
                    this.actions = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        change_sort(field) {
            if (this.viewType === "day") {
                if (this.sort_field == field) {
                    this.sort_direction =
                        this.sort_direction == "asc" ? "desc" : "asc";
                } else {
                    this.sort_field = field;
                }
                this.getFollowUpsSelectDate();
            } else if (this.viewType === "month") {
                if (this.sort_field == field) {
                    this.sort_direction =
                        this.sort_direction == "asc" ? "desc" : "asc";
                } else {
                    this.sort_field = field;
                }
                this.getFollowUpsSelectMonth();
            } else if (this.viewType === "range") {
                if (this.sort_field == field) {
                    this.sort_direction =
                        this.sort_direction == "asc" ? "desc" : "asc";
                } else {
                    this.sort_field = field;
                }
                this.getFollowUpsSelectDateRange();
            }
        },

        showToday(date) {
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("DD-MM-YY");
            return day;
        },

        showMonth(date) {
            let month = moment(date).format("MMMM-YYYY");
            return month;
        },

        getCurrentDate() {
            this.currentDate = moment().format("YYYY-MM-DD");
            return this.currentDate;
        },

        getSelectedDate(date) {
            this.selectedDate = moment(date).format("YYYY-MM-DD");
            return this.selectedDate;
        },

        getSelectedDateStart(date) {
            this.selectedDateStart = moment(date).format("YYYY-MM-DD");
            return this.selectedDateStart;
        },

        getSelectedDateEnd(date) {
            this.selectedDateEnd = moment(date).format("YYYY-MM-DD");
            return this.selectedDateEnd;
        },

        getSelectedDay() {
            let day = moment().format("DD");
            return day;
        },

        getSelectedMonth(date) {
            this.selectedMonth = moment(date).format("MM");
            return this.selectedMonth;
        },

        getSelectedYear(date) {
            this.selectedYear = moment(date).format("YYYY");
            return this.selectedYear;
        },

        deleteFollowUp(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/followups/delete/" + id);
            if (this.viewType === "day") {
                this.getFollowUpsSelectDate();
            } else if (this.viewType === "month") {
                this.getFollowUpsSelectMonth();
            } else if (this.viewType === "range") {
                this.getFollowUpsSelectDateRange();
            }
        },

        incrementDate() {
            if (this.viewType === "day") {
                document.getElementById("incrementDate").disabled = false;
                return (this.selectedDate = moment(this.selectedDate).add(
                    1,
                    "d"
                ));
            } else if (this.viewType === "month") {
                document.getElementById("incrementDate").disabled = false;
                var monthYear =
                    this.selectedYear + "-" + this.selectedMonth + "-" + "01";
                console.log("monthYear : " + monthYear);

                var monthYearAdd = moment(monthYear)
                    .add(1, "M")
                    .format("YYYY-MM-DD");

                console.log("monthYearAdd : " + monthYearAdd);

                this.selectedMonthYear = monthYearAdd;
                var month = this.getSelectedMonth(monthYearAdd);
                var year = this.getSelectedYear(monthYearAdd);
                return (this.currentMonth = year + "-" + month);
            } else {
                document.getElementById("incrementDate").disabled = true;
            }
        },

        decrementDate() {
            if (this.viewType === "day") {
                document.getElementById("decrementDate").disabled = false;
                return (this.selectedDate = moment(this.selectedDate).subtract(
                    1,
                    "d"
                ));
            } else if (this.viewType === "month") {
                document.getElementById("decrementDate").disabled = false;
                var monthYear =
                    this.selectedYear + "-" + this.selectedMonth + "-" + "01";
                console.log("monthYear : " + monthYear);

                var monthYearMinus = moment(monthYear)
                    .subtract(1, "M")
                    .format("YYYY-MM-DD");

                console.log("monthYearMinus : " + monthYearMinus);

                this.selectedMonthYear = monthYearMinus;
                var month = this.getSelectedMonth(monthYearMinus);
                var year = this.getSelectedYear(monthYearMinus);
                return (this.currentMonth = year + "-" + month);
            } else {
                document.getElementById("decrementDate").disabled = true;
            }
        },

        exportSelected() {
            if (this.checked.length === 0) {
                return alert("Need select record.");
            } else {
                axios.get("/api/followups/export");
            }
        },

        isChecked(followup_id) {
            return this.checked.includes(followup_id);
        },

        selectAllRecords() {
            axios.get("/api/followups/all").then((response) => {
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
