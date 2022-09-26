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
        class="items-center text-center text-6xl text-white font-extrabold bg-slate-400 px-2 py-2 rounded-md"
    >
        Follow up Index
    </h1>

    <div class="text-sm">
        <div
            class="m-2 inline-block items-center px-2 py-1 border-gray-500 border-2"
        >
            <p>view by</p>
            <select v-model="viewType" class="form-control text-center">
                <option value="day">Day</option>
                <option value="month">Month</option>
            </select>
        </div>
        <div
            class="m-2 inline-block items-center px-2 py-1 border-gray-500 border-2"
        >
            <span v-if="viewType === `day`">
                <p>select date</p>
                <input
                    v-model.lazy="selectedDate"
                    class="border-gray-300"
                    type="date"
                />
            </span>
            <span v-else>
                <p>select month/year</p>
                <input
                    v-model.lazy="currentMonth"
                    class="border-gray-300"
                    type="month"
                />
            </span>
        </div>
        <div
            class="m-2 inline-block items-center px-2 py-1 border-gray-500 border-2"
        >
            <p class="text-xs">Range date</p>
            <input type="checkbox" v-model="rangeDate" />
        </div>
        <div
            v-show="rangeDate"
            class="m-1 inline-block items-center px-2 py-1 border-gray-500 border-2"
        >
            <div class="border-gray-800 border-2 flex px-2 py-2">
                <p class="px-1 mt-1">select start date</p>
                <input
                    v-model.lazy="minDateRange"
                    class="border-gray-300 w-36"
                    type="date"
                />
            </div>
            <div class="border-gray-800 border-2 flex px-2 py-2">
                <p class="px-1 mt-1">select end date</p>
                <input
                    v-model.lazy="maxDateRange"
                    class="border-gray-300 w-36"
                    type="month"
                />
            </div>
        </div>
        <div
            class="m-2 inline-block items-center px-2 py-1 border-gray-500 border-2"
        >
            <p>Filter term</p>
            <input
                v-model.lazy="search"
                type="search"
                class="form-control"
                placeholder="Search by any..."
            />
        </div>
        <div
            class="m-2 inline-block items-center px-2 py-1 border-gray-500 border-2"
        >
            <p>Select user</p>
            <select v-model="selectedUser" class="">
                <option value="">All User</option>
                <option v-for="user in users" :key="user.id" :value="user.id">
                    {{ user.name }}
                </option>
            </select>
        </div>
    </div>

    <div
        class="m-2 inline-block items-center px-2 py-1 border-gray-500 border-2"
    >
        <select v-model="paginate" class="form-control">
            <option value="10">10</option>
            <option value="20">50</option>
            <option value="30">100</option>
        </select>
        <label for="paginate" class="px-2">of 100 entries</label>
    </div>
    <div class="py-2">
        <Pagination
            :data="followups"
            @pagination-change-page="getFollowUps"
            :size="'small'"
            :align="'center'"
            class="pagination"
        />
    </div>

    <div class="grid grid-cols-3 w-full text-center">
        <div class="text-left">
            <button class="text-5xl text-left">&larr;</button>
        </div>
        <span v-if="viewType === `day`">
            <div class="">
                <h3 class="uppercase font-extrabold">
                    {{ showToday(selectedDate) }}
                </h3>
            </div>
        </span>
        <span v-else>
            <div>
                <h3 class="uppercase font-extrabold">
                    {{ showMonth(selectedMonthYear) }}
                </h3>
            </div>
        </span>
        <div class="text-right">
            <button class="text-5xl text-right">&rarr;</button>
        </div>
    </div>

    <div>
        <table class="table table-hover table-bordered" id="example">
            <thead>
                <tr>
                    <th>#List no.</th>
                    <th>
                        <a
                            href="#"
                            @click.prevent="change_sort('followup_date')"
                        >
                            Date Created
                        </a>
                        <span
                            v-if="
                                sort_direction == 'desc' &&
                                sort_field == 'followup_date'
                            "
                            >&uarr;</span
                        >
                        <span
                            v-if="
                                sort_direction == 'asc' &&
                                sort_field == 'followup_date'
                            "
                            >&darr;</span
                        >
                    </th>
                    <th>
                        <a
                            href="#"
                            @click.prevent="change_sort('followup_time')"
                        >
                            Time
                        </a>
                        <span
                            v-if="
                                sort_direction == 'desc' &&
                                sort_field == 'followup_time'
                            "
                            >&uarr;</span
                        >
                        <span
                            v-if="
                                sort_direction == 'asc' &&
                                sort_field == 'followup_time'
                            "
                            >&darr;</span
                        >
                    </th>
                    <th>
                        <a
                            href="#"
                            @click.prevent="change_sort('contact_name')"
                        >
                            Contact
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
                    </th>
                    <th>
                        <a href="#" @click.prevent="change_sort('user_name')">
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
                    </th>
                    <th>
                        <a href="#" @click.prevent="change_sort('task_name')">
                            Task
                        </a>
                        <span
                            v-if="
                                sort_direction == 'desc' &&
                                sort_field == 'task_name'
                            "
                            >&uarr;</span
                        >
                        <span
                            v-if="
                                sort_direction == 'asc' &&
                                sort_field == 'task_name'
                            "
                            >&darr;</span
                        >
                    </th>
                    <th>
                        <a
                            href="#"
                            @click.prevent="change_sort('followup_remark')"
                        >
                            Remark
                        </a>
                        <span
                            v-if="
                                sort_direction == 'desc' &&
                                sort_field == 'followup_remark'
                            "
                            >&uarr;</span
                        >
                        <span
                            v-if="
                                sort_direction == 'asc' &&
                                sort_field == 'followup_remark'
                            "
                            >&darr;</span
                        >
                    </th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(followup, index) in followups.data"
                    :key="followup.id"
                >
                    <td>{{ index + 1 }}</td>
                    <td>{{ followup.followup_date }}</td>
                    <td>
                        <span v-if="followup.followup_time">
                            {{ followup.followup_time }}
                        </span>
                        <span v-else> No time set</span>
                    </td>
                    <td>
                        <router-link
                            :to="`/contacts/${followup.contact.id}/info`"
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
                        <button
                            class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            @click="deleteFollowUp(followup.id)"
                        >
                            <TrashIcon class="h-3 w-3" />
                        </button>

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
                            ><EyeIcon class="h-4 w-4 mr-1" />Todo</router-link
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import moment from "moment";
import { TrashIcon, EyeIcon } from "@heroicons/vue/24/solid";

export default {
    components: {
        Pagination: LaravelVuePagination,
        TrashIcon,
        EyeIcon,
    },

    mounted() {
        this.getStatus();
        this.getActions();
        this.getUsers();
        //initial date selection
        this.currentDate = this.showToday();
        this.selectedDate = this.currentDate;
        this.getFollowUps();

        //initial month selection
        this.selectedMonth = this.getSelectedMonth(this.currentDate);
        this.selectedYear = this.getSelectedYear(this.currentDate);
        this.selectedMonthYear =
            this.selectedYear + "-" + this.selectedMonth + "-" + "01";
        this.currentMonth = this.selectedYear + "-" + this.selectedMonth;
    },
    data() {
        return {
            moment: moment,
            rangeDate: false,
            followups: [],
            paginate: 10,
            viewType: "month",
            search: "",

            statuses: "",
            selectedStatus: "",
            users: "",
            selectedUser: 1,

            currentDate: "",
            currentMonth: "",
            currentYear: "",

            minDateRange: "",
            maxDateRange: "",

            selectedDate: "",
            selectedMonth: "",
            selectedYear: "",
            selectedMonthYear: "",

            selectedDateStart: "",
            selectedDateEnd: "",

            sort_direction: "desc",
            sort_field: "followup_date",
            actions: "",
        };
    },
    watch: {
        paginate: function (value) {
            this.getFollowUps();
        },
        search: function (value) {
            this.getFollowUps();
        },
        selectedStatus: function (value) {
            this.getFollowUps();
        },

        selectedDate: function (value) {
            if (this.viewType === "day") {
                this.selectedMonth = "";
                this.selectedYear = "";
                this.getSelectedDate();
                this.getFollowUps();
            }
        },
        viewType: function (value) {
            if (value === "day") {
                if (this.viewType === "day") {
                    this.selectedMonth = "";
                    this.selectedYear = "";
                    this.getSelectedDate();
                    this.getFollowUps();
                }
            } else {
                this.selectedDate = "";
                const monthYear = this.selectedMonthYear;
                this.getSelectedMonth(monthYear);
                this.getSelectedYear(monthYear);
                this.getFollowUps();
                this.selectedDate = this.currentDate;
            }
        },

        currentMonth: function (value) {
            this.selectedDate = "";
            const monthYear = this.currentMonth + "-" + "01";
            this.selectedMonthYear = monthYear;
            this.getSelectedMonth(monthYear);
            this.getSelectedYear(monthYear);
            this.getFollowUps();
            this.selectedDate = this.currentDate;
        },
    },

    methods: {
        getFollowUps(page = 1) {
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
                        "&selectedMonth=" +
                        this.selectedMonth +
                        "&selectedYear=" +
                        this.selectedYear +
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
                    this.followups = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getUsers() {
            axios
                .get("/api/users/index")
                .then((res) => {
                    this.users = res.data.data;
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
            if (this.sort_field == field) {
                this.sort_direction =
                    this.sort_direction == "asc" ? "desc" : "asc";
            } else {
                this.sort_field = field;
            }
            this.getFollowUps();
        },

        showToday(date) {
            let month = moment(date).format("YYYY-MM-DD");
            return month;
        },

        showMonth(date) {
            let month = moment(date.toString()).format("MMMM-YYYY");
            return month;
        },

        getSelectedDate() {
            this.currentDate = this.selectedDate;
            this.showToday(this.currentDate);
            return this.currentDate;
        },

        getSelectedDay() {
            let day = moment(this.currentDate).format("DD");
            return day;
        },

        getSelectedMonth() {
            let month = moment(this.currentDate).format("MM");
            this.showMonth(this.currentDate);
            return month;
        },

        getSelectedYear() {
            let year = moment(this.currentDate).format("YYYY");
            return year;
        },

        searchType() {},

        deleteFollowUp(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/followups/delete/" + id);
            this.getFollowUps();
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
