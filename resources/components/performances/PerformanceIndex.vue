<template>
    <h1
        class="items-center text-center text-6xl text-white font-extrabold bg-slate-600 rounded-md"
    >
        Performance Index
    </h1>

    <div class="text-sm">
        <div class="m-1 inline-block items-center px-1 py-1">
            <p>view by</p>
            <select v-model="viewType" class="form-control text-center">
                <option value="week">Week</option>
                <option value="month">Month</option>
                <option value="year">Year</option>
            </select>
        </div>
        <div class="m-1 inline-block items-center px-1 py-1">
            <span v-show="viewType === `month`">
                <p>select month/year</p>
                <input
                    v-model.lazy="currentMonth"
                    class="border-gray-300"
                    type="month"
                />
            </span>
        </div>

        <div class="m-1 inline-block items-center px-1 py-1" v-if="is('supervisor | admin | super-admin')">
            <p>Select user</p>
            <select v-model="selectedUser" class="form-control">
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

        <span v-show="viewType === `year`">
            <div class="mt-1">
                <h3 class="uppercase text-white font-extrabold">
                    {{ selectedYear }}
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
                <tr
                    v-if="viewType === 'week'"
                    v-for="(date, day) in dates"
                    :key="date.id"
                >
                    <td>{{ date + " - " + getWeekday(day) }}</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            </tbody>

            <tbody>
                <!-- <span v-if="viewType === 'month'"> -->
                <!-- <tr v-if="viewType === 'month'">
                    <td>
                        Week 1 : 01/
                        {{
                            this.selectedMonth +
                            " / " +
                            moment(this.selectedYear).format("YY") +
                            " - " +
                            "04 / 09 /22"
                        }}
                    </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr> -->
                <tr v-for="date in this.weekInMonth">
                    <td >
                        <!-- {{  this.displayWeek() }} -->
                        <!-- {{ moment().date(2).format("DD-MM-YY") }} ------- {{ getStartWeek(getWeek()) }} -->
                        <span >
                            {{ moment(date.startDate).format("DD-MM-YY") }}
                        </span>
                        <span class="mx-2">
                            to
                        </span>
                        <span >
                            {{ moment(date.endDate).format("DD-MM-YY") }}
                        </span>
                    </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            </tbody>

            <tbody>
                <!-- <span v-if="viewType === 'month'"> -->
                <tr
                    v-if="viewType === 'year'"
                    v-for="(date, day) in dates"
                    :key="date.id"
                >
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
        this.selectedUser = document.querySelector('meta[name="user-id"]').getAttribute('content');
        this.getCurrentDate();
        this.getDates(this.currentDate);

        this.selectedDate = this.currentDate;
        // this.getWeek();
        // console.log(
        //     "Currently this is week no. for this current month: " +
        //         this.getWeek()
        // );
        console.log(this.currentDate);

        // console.log(
        //     "result of getDatesOfWeek: " + this.getDates(this.currentDate)
        // );

        // console.log("Result of mounted currrentDate: " + this.currentDate);

        this.m = parseInt(this.getSelectedMonth(this.selectedDate));
        this.y = parseInt(this.getSelectedYear(this.selectedDate));
        // console.log(this.m);

        // this.consoleList();
        

        //initial month selection
        this.selectedMonth = this.getSelectedMonth(this.currentDate);
        this.selectedYear = this.getSelectedYear(this.currentDate);
        this.selectedMonthYear =
            this.selectedYear + "-" + this.selectedMonth + "-" + "01";
        this.currentMonth = this.selectedYear + "-" + this.selectedMonth;
        //initialise date range
        this.displayWeek();
        // this.incrementDate();
        // this.decrementDate();

        //need to change according to the current/selected month
    },

    props: {},

    data() {
        return {
            actions: [],
            users: [],
            users_actions: [],
            m: Number,
            y: Number,
            weekInMonth: [],
            // paginate: 10,
            viewType: "month",
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
            // this.returnM(monthYear);
            // this.returnY(monthYear);
            // this.displayWeek();
            // this.getSelectedMonth(monthYear);
            // this.getSelectedYear(monthYear);

            // this.getToDosSelectMonth();
            // console.log("current date after month change: " + this.currentDate);
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

        getWeek() {
            // return moment(date).isoWeek();
            // let tarikh =
            //     this.getSelectedYear + "-" + this.getSelectedMonth + "-01";
            const d = new Date(
                this.getSelectedYear + "-" + this.getSelectedMonth + "-01"
            );
            const date = d.getDate();
            const day = d.getDay();
            const weekOfMonth = Math.ceil((date - 1 - day) / 7);
            return weekOfMonth;
        },

        getWeekday(day) {
            let currentDay = this.weekday[day];
            return currentDay;
        },
        //first and last Dates in Week
        getStartWeek() {
            var startOfWeek = moment().startOf("isoweek").format("DD-MM-YY");

            return startOfWeek;
        },

        getEndWeek() {
            var endOfWeek = moment().endOf("isoweek").format("DD-MM-YY");

            return endOfWeek;
        },

        // Dates in Week Loop
        getDates(date) {
            for (var x = 0; x < this.weekday.length; x++) {
                var datesOfWeek = moment(date)
                    .startOf("isoweek")
                    .add(x, "days")
                    .format("DD-MM-YY");

                // console.log("in loop " + datesOfWeek);
                // console.log("");
                this.dates.push(datesOfWeek);
            }
            return this.dates;
        },

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
                // console.log("monthYear : " + monthYear);

                var monthYearAdd = moment(monthYear)
                    .add(1, "M")
                    .format("YYYY-MM-DD");

                // console.log("monthYearAdd : " + monthYearAfterAdd);

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
                // console.log("monthYear : " + monthYear);

                var monthYearMinus = moment(monthYear)
                    .subtract(1, "M")
                    .format("YYYY-MM-DD");

                // console.log("monthYearMinus : " + monthYearAfterMinus);

                this.selectedMonthYear = monthYearMinus;
                var month = this.getSelectedMonth(monthYearMinus);
                var year = this.getSelectedYear(monthYearMinus);
                return (this.currentMonth = year + "-" + month);
            } else {
                document.getElementById("decrementDate").disabled = true;
            }
        },

        getWeekNumbers(year, month) {
            let firstWeek = moment(new Date(year, month, 1)).isoWeek();
            let lastWeek = moment(new Date(year, month + 1, 0)).isoWeek();

            let out = [`Week ${firstWeek}`];
            if (firstWeek === 52 || firstWeek === 53) {
                firstWeek = 0;
            }

            for (let i = firstWeek + 1; i <= lastWeek; i++) {
                out.push(`Week ${i}`);
            }
            return out;
        },

        getMomentDate(start, end) {
            return {
                startDate: moment([this.y, this.m - 1, start]),
                endDate: moment([this.y, this.m - 1, end]),
            };
        },

        weeks(month) {
            const weekStartEndDay = [];
            const first = month.day() == 0 ? 6 : month.day() - 1;
            let day = 7 - first;
            const last = month.daysInMonth();
            const count = (last - day) / 7;

            weekStartEndDay.push(this.getMomentDate(1, day));
            for (let i = 0; i < count; i++) {
                weekStartEndDay.push(
                    this.getMomentDate(day + 1, Math.min((day += 7), last))
                );
            }
            return weekStartEndDay;
        },

        // consoleList() {
        //     const month = moment([this.y, this.m - 1]);
        //     const weekNumbers = this.getWeekNumbers(this.y, this.m - 1);
        //     const weekList = this.weeks(month);
        //     // console.log("weekNumbers", weekNumbers);
        //     // console.log("weekList", weekList);
        //     weekList.forEach((date) => {
        //         console.log(
        //             "start - " + date.startDate.format("DD-MM--YY"),
        //             "end - " + date.endDate.format("DD-MM--YY")
        //         );
        //     });
        // },

        displayWeek() {
            let monthYear = this.selectedYear + "-" + this.selectedMonth + "-01";
            let y = parseInt(this.getSelectedYear(monthYear));
            let m = parseInt(this.getSelectedMonth(monthYear));

            const month = moment([y, m - 1]);
            const weekList = this.weeks(month);
            // console.log("weekNumbers", weekNumbers);
            // console.log("weekList", weekList);
            // weekList.forEach((date) => {
            //     console.log(
            //         "start - " + date.startDate.format("DD-MM--YY"),
            //         "end - " + date.endDate.format("DD-MM--YY")
            //     );
            // });
            return this.weekInMonth.push(...weekList);
        },

        returnM(date){
            return this.m = parseInt(this.getSelectedMonth(date));

        },

        returnY(date){
            return this.y = parseInt(this.getSelectedYear(date));
        }
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
