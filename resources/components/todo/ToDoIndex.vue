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
    <h1
        class="items-center text-center text-6xl text-white font-extrabold bg-slate-600 rounded-md"
    >
        To Do Index
    </h1>

    <div class="text-sm">
        <div>
            <router-link
                to="/todo/create"
                class="inline-block items-center px-2 py-1 align-top bg-blue-800 border border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
            >
                <PlusIcon class="inline h-6 w-6 mr-1" />
                to do</router-link
            >
        </div>

        <div class="inline-block px-1 border-gray-500 border-2">
            <select v-model="paginate" class="form-control">
                <option value="10">10</option>
                <option value="20">50</option>
                <option value="30">100</option>
            </select>
            <label for="paginate" class="px-2">of 100 entries</label>
        </div>
        <div
            class="m-1 inline-block items-center px-1 py-1 border-gray-500 border-2"
        >
            <p>view by</p>
            <select v-model="viewType" class="form-control text-center">
                <option value="day">Day</option>
                <option value="month">Month</option>
                <option value="range">Date Range</option>
            </select>
        </div>
        <div
            class="m-1 inline-block items-center px-1 py-1 border-gray-500 border-2"
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
                class="m-1 inline-block items-center px-1 py-1 border-gray-500 border-2"
            >
                <div class="border-gray-800 border-2 flex px-2 py-2">
                    <p class="px-1 mt-1">select start date</p>
                    <input
                        v-model.lazy="selectedDateStart"
                        class="border-gray-300 w-36"
                        type="date"
                    />
                </div>
                <div class="border-gray-800 border-2 flex px-1 py-2">
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
            class="m-1 inline-block items-center px-1 py-1 border-gray-500 border-2"
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
            class="m-1 inline-block items-center px-1 py-1 border-gray-500 border-2"
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
            :data="todos"
            @pagination-change-page="getToDosSelectDate"
            :size="'small'"
            :align="'center'"
            class="pagination"
        />
    </div>

    <div class="grid grid-cols-3 w-full text-center bg-slate-500">
        <div class="text-left">
            <button
                class="text-xl text-left px-2 py-2"
                id="decrementDate"
                @click="decrementDate"
            >
                <ChevronDoubleLeftIcon class="h-6 w-6 bg-blue-300 rounded-lg" />
            </button>
        </div>
        <span v-show="viewType === `day`">
            <div class="mt-1">
                <h3 class="uppercase text-white font-extrabold">
                    {{ showToday(selectedDate) }}
                </h3>
            </div>
        </span>
        <span v-show="viewType === `month`">
            <div class="mt-1">
                <h3 class="uppercase text-white font-extrabold">
                    {{ showMonth(selectedMonthYear) }}
                </h3>
            </div>
        </span>
        <span v-show="viewType === `range`">
            <div class="mt-1">
                <h3 class="uppercase text-white font-extrabold">
                    {{ showToday(selectedDateStart) }} ---
                    {{ showToday(selectedDateEnd) }}
                </h3>
            </div>
        </span>

        <div class="text-right">
            <button
                class="text-5xl text-right px-2 py-2"
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
                        <a href="#" @click.prevent="change_sort('source_name')">
                            Source
                        </a>
                        <span
                            v-if="
                                sort_direction == 'desc' &&
                                sort_field == 'source_name'
                            "
                            >&uarr;</span
                        >
                        <span
                            v-if="
                                sort_direction == 'asc' &&
                                sort_field == 'source_name'
                            "
                            >&darr;</span
                        >
                    </th>
                    <th>
                        <a
                            href="#"
                            @click.prevent="change_sort('todo_created')"
                        >
                            Date of Todo
                        </a>
                        <span
                            v-if="
                                sort_direction == 'desc' &&
                                sort_field == 'todo_created'
                            "
                            >&uarr;</span
                        >
                        <span
                            v-if="
                                sort_direction == 'asc' &&
                                sort_field == 'todo_created'
                            "
                            >&darr;</span
                        >
                    </th>
                    <th>
                        <a
                            href="#"
                            @click.prevent="change_sort('todo_deadline')"
                        >
                            Date Deadline
                        </a>
                        <span
                            v-if="
                                sort_direction == 'desc' &&
                                sort_field == 'todo_deadline'
                            "
                            >&uarr;</span
                        >
                        <span
                            v-if="
                                sort_direction == 'asc' &&
                                sort_field == 'todo_deadline'
                            "
                            >&darr;</span
                        >
                    </th>
                    <th>
                        <a href="#" @click.prevent="change_sort('status_name')">
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
                    </th>
                    <th>
                        <a href="#" @click.prevent="change_sort('type_name')">
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
                        <a href="#" @click.prevent="change_sort('todo_remark')">
                            Remark
                        </a>
                        <span
                            v-if="
                                sort_direction == 'desc' &&
                                sort_field == 'todo_remark'
                            "
                            >&uarr;</span
                        >
                        <span
                            v-if="
                                sort_direction == 'asc' &&
                                sort_field == 'todo_remark'
                            "
                            >&darr;</span
                        >
                    </th>
                    <th>Action</th>
                    <th>-</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(todo, index) in todos.data" :key="todo.id">
                    <td class="text-sm">{{ index + 1 }}</td>
                    <td class="text-sm">{{ todo.source.name }}</td>
                    <td class="text-sm">{{ todo.todo_created }}</td>
                    <td class="text-sm">
                        <span v-if="todo.todo_deadline === '2000-01-01'">
                            None
                        </span>
                        <span v-else-if="todo.todo_deadline !== '2000-01-01'">
                            {{ todo.todo_deadline }}
                        </span>
                        <span v-else="todo.todo_deadline.length === 0">
                            Unset yet
                        </span>
                    </td>
                    <td class="text-sm">{{ todo.status.name }}</td>
                    <td class="text-sm">{{ todo.type.name }}</td>
                    <td class="text-sm">
                        <router-link
                            :to="`/contacts/${todo.contact.id}/info`"
                            custom
                            v-slot="{ navigate, href }"
                        >
                            <a :href="href" @click.stop="navigate">{{
                                todo.contact.name
                            }}</a>
                        </router-link>
                    </td>
                    <td class="text-sm">{{ todo.user.name }}</td>
                    <td class="text-sm">{{ todo.task.name }}</td>
                    <td class="text-sm">{{ todo.todo_remark }}</td>
                    <td class="text-center text-sm align-middle">
                        <span
                            v-if="todo.action"
                            class="block align-middle font-extrabold uppercase text-white bg-green-500 rounded-md py-1 px-2 text-center text-sm"
                        >
                            {{ todo.action.name }}
                            <!-- <select
                                disabled
                                id="selectAction"
                                class="form-control form-control-sm"
                                v-model="todo.action_id"
                            >
                                <option
                                    v-for="action in actions.data"
                                    :key="action.id"
                                    :value="action.id"
                                >
                                    {{ action.id }}
                                </option>
                            </select> -->
                        </span>
                        <span v-else>
                            <select
                                id="selectAction"
                                class="form-control form-control-sm"
                                @change="
                                    actionSelected(
                                        this.todo_action.action_id,
                                        todo.id,
                                        todo.contact.id
                                    )
                                "
                                v-model="todo_action.action_id"
                            >
                                <option disabled value="">Select Action</option>
                                <option
                                    v-for="action in actions.data"
                                    :key="action.id"
                                    :value="action.id"
                                >
                                    {{ action.name }}
                                </option>
                            </select>
                        </span>
                    </td>
                    <td>
                        <router-link
                            :to="{
                                name: 'todo_edit',
                                params: { id: todo.id },
                            }"
                            class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <PencilSquareIcon class="h-3 w-3"
                        /></router-link>
                        <button
                            class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            @click="deleteToDo(todo.id)"
                        >
                            <TrashIcon class="h-3 w-3" />
                        </button>
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
    },

    created() {},

    mounted() {
        console.log(
            "this is the route params: " + this.$route.params.selectedDate
        );
        this.getStatus();
        this.getActions();
        this.getUsers();
        if (!this.$route.params.selectedDate) {
            this.currentDate = this.getCurrentDate();
            this.selectedDate = this.currentDate;
            this.getToDos();
        } else {
            this.selectedDate = this.$route.params.selectedDate;
            this.getToDos();
        }
        //initial date selection
        console.log(
            "Result of mounted getCurrentDate: " + this.getCurrentDate()
        );

        // this.getSelectedDate(this.selectedDate);
        console.log("Result of mounted currrentDate: " + this.currentDate);

        //initial month selection
        this.selectedMonth = this.getSelectedMonth(this.selectedDate);
        this.selectedYear = this.getSelectedYear(this.selectedDate);
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

    props: {},

    data() {
        return {
            moment: moment,
            todos: [],
            paginate: 10,
            viewType: "day",
            search: "",
            todo: "",
            statuses: "",
            selectedStatus: "",
            users: "",
            selectedUser: 1,

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
            sort_field: "todo_created",
            actions: "",
            todo_action: {
                action_id: "",
            },
        };
    },
    watch: {
        paginate: function (value) {
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },
        search: function (value) {
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },
        selectedStatus: function (value) {
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },

        viewType: function (value) {
            if (value === "day") {
                if (this.viewType === "day") {
                    this.getToDosSelectDate();
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
                this.getToDosSelectMonth();
            }
            if (value === "range") {
                this.getSelectedDateStart(this.currentDate);
                this.getSelectedDateEnd(this.currentDate);
                this.getToDosSelectDateRange();
            }
        },
        selectedDate: function (value) {
            if (this.viewType === "day") {
                this.getSelectedDate(this.selectedDate);
                this.getToDosSelectDate();
            }
        },

        currentMonth: function (value) {
            const monthYear = this.currentMonth + "-" + "01";
            this.selectedMonthYear = monthYear;
            this.getSelectedMonth(monthYear);
            this.getSelectedYear(monthYear);
            this.getToDosSelectMonth();
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
            this.getToDosSelectDateRange();
        },
    },
    computed: {
        selectedDateRange() {
            return `${this.selectedDateStart}|${this.selectedDateEnd}`;
        },
    },

    methods: {
        getToDos(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/todos/index?" +
                        "q=" +
                        this.search +
                        "&selectedDate=" +
                        this.selectedDate +
                        "&selectedDateStart=" +
                        this.selectedDateStart +
                        "&selectedDateEnd=" +
                        this.selectedDateEnd +
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
                    this.todos = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getToDosSelectDate(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/todos/index?" +
                        "q=" +
                        this.search +
                        "&selectedDate=" +
                        this.selectedDate +
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
                    this.todos = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getToDosSelectMonth(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/todos/index?" +
                        "q=" +
                        this.search +
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
                    this.todos = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getToDosSelectDateRange(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/todos/index?" +
                        "q=" +
                        this.search +
                        "&selectedDateStart=" +
                        this.selectedDateStart +
                        "&selectedDateEnd=" +
                        this.selectedDateEnd +
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
                    this.todos = res.data;
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
            this.getToDos();
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
            this.getToDos();
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
