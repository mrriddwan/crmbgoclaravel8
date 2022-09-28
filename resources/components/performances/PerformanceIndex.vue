<template>
    <h1
        class="items-center text-center text-6xl text-white font-extrabold bg-slate-600 rounded-md"
    >
        Performance Index
    </h1>

    <div class="text-sm">
        <div
            class="m-1 inline-block items-center px-1 py-1 border-gray-500 border-2"
        >
            <p>view by</p>
            <select v-model="viewType" class="form-control text-center">
                <option value="week">Week</option>
                <option value="month">Month</option>
                <option value="year">Year</option>
            </select>
        </div>
        <div
            class="m-1 inline-block items-center px-1 py-1 border-gray-500 border-2"
            @change=""
        >
            <span v-show="viewType === `month`">
                <p>select month/year</p>
                <input
                    v-model.lazy="currentMonth"
                    class="border-gray-300"
                    type="month"
                />
            </span>
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

    <div class="text-center bg-slate-500 h-max">
        <div class="text-left w-max">
            <button
                class="text-xl text-left px-2 py-2"
                id="decrementDate"
                @click="decrementDate"
            >
                <ChevronDoubleLeftIcon class="h-6 w-6 bg-blue-300 rounded-lg" />
            </button>
        </div>

        <span v-show="viewType === `week`">
            <div class="mt-1">
                <h3 class="uppercase text-white font-extrabold inline-block">
                    {{ dates[0] }}
                </h3>
                <h3
                    class="uppercase text-white font-extrabold inline-block ml-1 mr-1"
                >
                    -
                </h3>
                <h3 class="uppercase text-white font-extrabold inline-block">
                    {{ dates[6] }}
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
                    <th class="text-sm text-center">Week</th>
                    <th
                        class="text-sm text-center"
                        v-for="action in actions"
                        :key="action.id"
                    >
                        <a>
                            {{ action.name }}
                        </a>
                    </th>
                </tr>
            </thead>
            <!-- <tbody v-for="user_action in users_actions" :key="user.id"> -->
            <tbody>
                <!-- <span v-if="viewType === 'month'"> -->
                <tr v-for="(date, day) in dates" :key="date.id">
                    <td>{{ date + " - " + getWeekday(day) }}</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
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
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        Pagination: LaravelVuePagination,
        ChevronDoubleLeftIcon,
        ChevronDoubleRightIcon,
    },

    created() {},

    mounted() {
        this.getActions();
        this.getUsers();
        this.getCurrentDate();

        console.log(
            "result of getDatesOfWeek: " + this.getDates(this.currentDate)
        );

        //initial date selection
        // console.log(
        //     "Result of mounted getCurrentDate: " + this.getCurrentDate()
        // );

        console.log("Result of mounted currrentDate: " + this.currentDate);

        //initial month selection
        this.selectedMonth = this.getSelectedMonth(this.currentDate);
        this.selectedYear = this.getSelectedYear(this.currentDate);
        this.selectedMonthYear =
            this.selectedYear + "-" + this.selectedMonth + "-" + "01";
        this.currentMonth = this.selectedYear + "-" + this.selectedMonth;
        //initialise date range

        this.incrementDate();
        this.decrementDate();
    },

    props: {},

    data() {
        return {
            actions: [],
            users: [],
            users_actions: [],

            // paginate: 10,
            viewType: "week",
            moment: moment,

            selectedUser: 2,
            dates: [],
            weekday: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],

            currentDate: "",
            currentMonth: "",
            currentYear: "",

            selectedDate: "",
            selectedMonth: "",
            selectedYear: "",
            selectedMonthYear: "",

            sort_direction: "desc",
            sort_field: "todo_date",
        };
    },
    watch: {
        selectedUser: function (value) {
            // if (this.viewType === "day") {
            //     this.getToDosSelectDate();
            // } else if (this.viewType === "month") {
            //     this.getToDosSelectMonth();
            // } else if (this.viewType === "range") {
            //     this.getToDosSelectDateRange();
            // }
            this.getUserAction();
        },

        viewType: function (value) {
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
                // this.getToDosSelectMonth();
            }
        },

        currentMonth: function (value) {
            const monthYear = this.currentMonth + "-" + "01";
            this.selectedMonthYear = monthYear;
            this.getSelectedMonth(monthYear);
            this.getSelectedYear(monthYear);
            // this.getToDosSelectMonth();
            console.log("current date after month change: " + this.currentDate);
        },
    },
    computed: {},

    methods: {
        // getActionsByWeek() {
        //     axios
        //         .get(
        //             "/api/todos/index?" +
        //                 "q=" +
        //                 this.search +
        //                 "&selectedDate=" +
        //                 this.selectedDate +
        //                 "&selectedUser=" +
        //                 this.selectedUser
        //         )
        //         .then((res) => {
        //             this.todos = res.data;
        //         })
        //         .catch((error) => {
        //             console.log(error);
        //         });
        // },

        getWeekday(day) {
            // const d = new Date();
            let currentDay = this.weekday[day];
            return currentDay;
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

        getActions() {
            axios
                .get("/api/actions/index")
                .then((res) => {
                    this.actions = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getUserAction() {
            axios
                .get("/api/users/action/" + this.selectedUser)
                .then((res) => {
                    this.users_actions = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        // change_sort(field) {
        //     } else if (this.viewType === "month") {
        //         if (this.sort_field == field) {
        //             this.sort_direction =
        //                 this.sort_direction == "asc" ? "desc" : "asc";
        //         } else {
        //             this.sort_field = field;
        //         }
        //         this.getToDosSelectMonth();

        // },

        // getStartWeek() {
        //     var startOfWeek = moment().startOf("isoweek").format("DD-MM-YY");

        //     return startOfWeek;
        // },

        // Dates in Week Loop
        getDates(date) {

            for (var x = 0; x < this.weekday.length; x++) {
                var datesOfWeek = moment(date)
                    .startOf("isoweek")
                    .add(x, "days")
                    .format("DD-MM-YY");

                console.log("in loop " + datesOfWeek);
                console.log("");
                this.dates.push(datesOfWeek);
            }
            return this.dates;
        },

        // getDatesOfWeek(day) {
        //     var datesOfWeek = moment()
        //         .startOf("isoweek")
        //         .add(day, "days")
        //         .format("DD-MM-YY");

        //     return datesOfWeek;
        // },

        // getEndWeek() {
        //     var endOfWeek = moment().endOf("isoweek").format("DD-MM-YY");

        //     return endOfWeek;
        // },

        showMonth(date) {
            let month = moment(date).format("MMMM-YYYY");
            return month;
        },

        showYear(date) {
            let year = moment(date).format("YYYY");
            return year;
        },

        getCurrentDate() {
            this.currentDate = moment().format("YYYY-MM-DD");
            return this.currentDate;
        },

        getSelectedDate(date) {
            this.selectedDate = moment(date).format("YYYY-MM-DD");
            return this.selectedDate;
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
