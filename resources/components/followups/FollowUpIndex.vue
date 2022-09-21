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
    <router-link
        to="/forecasts/index"
        class="inline-block items-center px-2 py-1 bg-purple-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
    >
        Forecast</router-link
    >
    <router-link
        to="/forecasts/index"
        class="inline-block items-center px-2 py-1 bg-cyan-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
    >
        Project</router-link
    >
    <h1
        class="items-center text-center text-6xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
    >
        Follow up Index
    </h1>

    <div class="text-sm">
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
        <div
            class="m-2 inline-block items-center px-2 py-1 border-gray-500 border-2"
        >
            <p>view by</p>
            <select v-model="viewType" class="form-control text-center">
                <option value="day">Day</option>
                <option value="month">Month</option>
                <option value="range">Date Range</option>
            </select>
        </div>
        <div
            class="m-2 inline-block items-center px-2 py-1 border-gray-500 border-2"
            @change=""
        >
            <span v-show="viewType === `day`">
                <p>select date</p>
                <input
                    v-model.lazy="selectedDate"
                    class="border-gray-300"
                    type="date"
                />
            </span>
            <span v-show="viewType === `month`">
                <p>select month/year</p>
                <input
                    v-model.lazy="currentMonth"
                    class="border-gray-300"
                    type="month"
                />
            </span>

            <span
                v-show="viewType === `range`"
                class="m-1 inline-block items-center px-2 py-1 border-gray-500 border-2"
            >
                <div class="border-gray-800 border-2 flex px-2 py-2">
                    <p class="px-1 mt-1">select start date</p>
                    <input
                        v-model.lazy="selectedDateStart"
                        class="border-gray-300 w-36"
                        type="date"
                    />
                </div>
                <div class="border-gray-800 border-2 flex px-2 py-2">
                    <p class="px-1 mt-1">select end date</p>
                    <input
                        v-model.lazy="selectedDateEnd"
                        class="border-gray-300 w-36"
                        type="date"
                    />
                </div>
            </span>
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

    <div class="py-2">
        <Pagination
            :data="followups"
            @pagination-change-page="getFollowUps"
            :size="'small'"
            :align="'center'"
            class="pagination"
        />
    </div>

    <div class="grid grid-cols-3 w-full text-center bg-slate-500">
        <div class="text-left">
            <button
                class="text-xl text-left px-3 py-3"
                id="decrementDate"
                @click="decrementDate"
            >
                <ChevronDoubleLeftIcon class="h-6 w-6 bg-blue-300 rounded-lg" />
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
            <div class="mt-2">
                <h3 class="uppercase text-white font-extrabold">
                    {{ showToday(selectedDateStart) }} ---
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
            <thead>
                <tr>
                    <th>#</th>
                    <th>
                        <a
                            href="#"
                            @click.prevent="change_sort('followup_created')"
                        >
                            Date Created
                        </a>
                        <span
                            v-if="
                                sort_direction == 'desc' &&
                                sort_field == 'followup_created'
                            "
                            >&uarr;</span
                        >
                        <span
                            v-if="
                                sort_direction == 'asc' &&
                                sort_field == 'followup_created'
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
                    <td>{{ followup.followup_created }}</td>
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
                                    selectedDate: followup.followup_created,
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
import {
    PencilSquareIcon,
    TrashIcon,
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
    PlusIcon,
    LightBulbIcon,
    EyeIcon,
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
    },

    mounted() {
        this.getStatus();
        this.getActions();
        this.getUsers();
        this.$route.params.length !== 0
            ? (this.currentDate = this.$route.params.selectedDate)
            : (this.currentDate = this.getCurrentDate());
        //initial date selection
        console.log(
            "Result of mounted getCurrentDate: " + this.getCurrentDate()
        );
        this.selectedDate = this.currentDate;
        // this.getSelectedDate(this.selectedDate);
        console.log("Result of mounted currrentDate: " + this.currentDate);
        //initial month selection
        this.selectedMonth = this.getSelectedMonth(this.selectedDate);
        this.selectedYear = this.getSelectedYear(this.selectedDate);
        this.getFollowUps();
        this.selectedMonthYear =
            this.selectedYear + "-" + this.selectedMonth + "-" + "01";
        this.currentMonth = this.selectedYear + "-" + this.selectedMonth;

        //initialise date range
        this.selectedDateStart = this.selectedDate;
        this.selectedDateEnd = this.selectedDate;
        console.log(
            "Result of mounted selectedDateStart: " + this.selectedDateStart
        );
        console.log(
            "Result of mounted selectedDateEnd: " + this.selectedDateEnd
        );

        this.incrementDate();
        this.decrementDate();
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
            sort_field: "followup_created",
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

        viewType: function (value) {
            if (value === "day") {
                if (this.viewType === "day") {
                    this.selectedMonth = "";
                    this.selectedYear = "";
                    this.selectedDateStart = "";
                    this.selectedDateEnd = "";
                    this.getFollowUps();
                    this.currentDate = this.getCurrentDate();
                    this.selectedMonth = this.currentMonth;
                    this.selectedDateStart = this.selectedDate;
                    this.selectedDateEnd = this.selectedDate;
                }
            }
            if (value === "month") {
                this.selectedDate = "";
                this.selectedDateStart = "";
                this.selectedDateEnd = "";
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
                this.getFollowUps();
                this.selectedDate = this.currentDate;
                this.selectedDateStart = this.selectedDate;
                this.selectedDateEnd = this.selectedDate;
            }
            if (value === "range") {
                this.selectedDate = "";
                this.selectedMonth = "";
                this.selectedYear = "";
                this.getSelectedDateStart(this.currentDate);
                this.getSelectedDateEnd(this.currentDate);
                this.getFollowUps();
                this.selectedDate = this.currentDate;
                this.selectedMonth = this.currentMonth;
            }
        },
        selectedDate: function (value) {
            if (this.viewType === "day") {
                this.selectedMonth = "";
                this.selectedYear = "";
                this.selectedDateStart = "";
                this.selectedDateEnd = "";
                this.getSelectedDate(this.selectedDate);
                this.getFollowUps();
            }
        },

        currentMonth: function (value) {
            this.selectedDate = "";
            this.selectedDateStart = "";
            this.selectedDateEnd = "";
            const monthYear = this.currentMonth + "-" + "01";
            this.selectedMonthYear = monthYear;
            this.getSelectedMonth(monthYear);
            this.getSelectedYear(monthYear);
            this.getFollowUps();
            console.log("current date after month change: " + this.currentDate);
            this.selectedDate = this.currentDate;
            this.selectedDateStart = this.selectedDate;
            this.selectedDateEnd = this.selectedDate;
        },

        // selectedDateRange(newVal) {
        //     this.selectedDate = "";
        //     this.selectedMonth = "";
        //     this.selectedYear = "";
        //     const [selectedDateStart, selectedDateEnd] = newVal.split("|");
        //     this.getSelectedDateStart(selectedDateStart);
        //     this.getSelectedDateEnd(selectedDateEnd);
        //     console.log("result of date after this.getSelectedDateEnd(selectedDateStart): " + this.getSelectedDateEnd(selectedDateStart))
        //     console.log("result of date after this.getSelectedDateEnd(selectedDateEnd): " + this.getSelectedDateEnd(selectedDateEnd))
        //     this.getFollowUps();
        //     this.selectedDate = this.currentDate;
        //     this.selectedMonth = this.currentMonth;
        // },
    },
    computed: {
        selectedDateRange() {
            return `${this.selectedDateStart}|${this.selectedDateEnd}`;
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
                .get("/api/contactstatus/index")
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
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("YYYY-MM-DD");
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

        searchType() {},

        deleteToDo(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/todos/delete/" + id);
            this.getFollowUps();
        },

        actionSelected(action, toDoId, contactId) {
            if (!window.confirm("Update task?")) {
                return;
            }
            console.log(action);
            console.log(toDoId);
            console.log(contactId);
            axios.put("/api/todos/action/" + toDoId, {
                action_id: action,
            });
            alert("Task updated");
            this.$router.push({
                name: "followup_create",
                params: { id: contactId, todoId: toDoId },
            });
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
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
