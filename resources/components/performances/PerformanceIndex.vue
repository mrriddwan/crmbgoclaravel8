<template>
    <h1
        class="items-center text-center text-6xl text-white font-extrabold bg-slate-600 rounded-md"
    >
        Performance
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

        <div
            class="m-1 inline-block items-center px-1 py-1"
            v-if="is('supervisor | admin | super-admin')"
        >
            <p>Select user</p>
            <select v-model="selectedUser" class="form-control">
                <option value="">Select User</option>
                <option v-for="user in users" :key="user.id" :value="user.id">
                    {{ user.name }}
                </option>
            </select>
        </div>

        <!-- <download-excel
            :data="actions"
            :fields="action_fields"
            worksheet="Performance Summary"
            name="Performance Summary(week).xls"
            class="btn btn-success btn-sm"
        >
            <ArrowTopRightOnSquareIcon class="h-5 w-5 mr-1 inline-block" />
            Export Actions
        </download-excel> -->

        <div
            class="m-1 inline-block items-center px-1 py-1"
            v-if="
                (can('export performance') || is('admin | super-admin')) &&
                viewType === 'week'
            "
        >
            <download-excel
                :data="user_performance"
                :fields="performance_week"
                worksheet="Performance Summary"
                name="Performance Summary(week).xls"
                class="btn btn-success btn-sm"
            >
                <ArrowTopRightOnSquareIcon class="h-5 w-5 mr-1 inline-block" />
                Export Weekly
            </download-excel>
        </div>

        <div
            class="m-1 inline-block items-center px-1 py-1"
            v-if="
                (can('export performance') || is('admin | super-admin')) &&
                viewType === 'month'
            "
        >
            <download-excel
                :data="user_performance.data"
                :fields="performance_month"
                worksheet="Performance Summary"
                name="Performance Summary(month).xls"
                class="btn btn-success btn-sm"
            >
                <ArrowTopRightOnSquareIcon class="h-5 w-5 mr-1 inline-block" />
                Export Monthly
            </download-excel>
        </div>

        <div
            class="m-1 inline-block items-center px-1 py-1"
            v-if="
                (can('export performance') || is('admin | super-admin')) &&
                viewType === 'year'
            "
        >
            <download-excel
                :data="user_performance.data"
                :fields="performance_year"
                worksheet="Performance Summary"
                name="Performance Summary(year).xls"
                class="btn btn-success btn-sm"
            >
                <ArrowTopRightOnSquareIcon class="h-5 w-5 mr-1 inline-block" />
                Export Annual
            </download-excel>
        </div>
    </div>

    <div class="py-2 text-center bg-slate-500 flex justify-between">
        <div class="text-left">
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
                    {{ showToday(datesInWeek[0]) }}
                </h3>
                <h3 class="text-white font-extrabold inline-block mx-5">to</h3>
                <h3 class="uppercase text-white font-extrabold inline-block">
                    {{ showToday(datesInWeek[6]) }}
                </h3>
            </div>
        </span>

        <span v-show="viewType === `month`">
            <div class="">
                <h3 class="uppercase text-white font-extrabold">
                    {{ showMonth(selectedMonthYear) }}
                </h3>
            </div>
        </span>

        <span v-show="viewType === `year`">
            <div class="">
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

    <!-- <div> -->

    <table class="table table-hover table-bordered" id="example">
        <thead v-if="viewType !== 'year'" class="bg-slate-600">
            <tr>
                <th class="text-sm text-center text-amber-400">Week</th>
                <th
                    class="text-sm text-center"
                    v-for="action in actions"
                    :key="action.id"
                >
                    <span class="text-amber-400 break-normal">
                        {{ action.name }}
                    </span>
                </th>
            </tr>
        </thead>
        <thead v-else class="bg-slate-600">
            <tr>
                <th class="text-sm text-center text-amber-400">Month</th>
                <th class="text-sm text-center text-amber-400">Week</th>
                <th
                    class="text-sm text-center text-amber-400"
                    v-for="action in actions"
                    :key="action.id"
                >
                    <span class="break-normal">
                        {{ action.name }}
                    </span>
                </th>
            </tr>
        </thead>

        <tbody
            v-if="viewType === 'week'"
            v-for="(date, day) in datesInWeek"
            :key="date.id"
        >
            <!-- <tr>{{ getWeek(date)}}</tr> -->
            <tr class="text-center">
                <td>{{ showToday(date) + " - " + getWeekday(day) }}</td>
                <td v-for="(action, index) in actions" :key="action.id">
                    <span v-if="user_performance[0][`${date}`]">
                        <span
                            v-if="
                                !user_performance[0][`${date}`][`${action.name}`]
                            "
                        >
                            0
                        </span>
                        <span v-else class="font-bold">
                            {{ user_performance[0][`${date}`][`${action.name}`] }}
                        </span>
                    </span>
                    <span v-else> 0 </span>
                </td>
            </tr>
        </tbody>

        <tbody
            v-if="viewType === 'month'"
            v-for="date in this.weeksInMonth"
            class="text-center"
        >
            <tr class="text-center">
                <td>
                    <span>
                        {{ moment(date.startDate).format("DD-MM-YY") }}
                    </span>
                    <span class="mx-2"> to </span>
                    <span>
                        {{ moment(date.endDate).format("DD-MM-YY") }}
                        <br />
                    </span>
                </td>
                <td v-for="(action, index) in actions" :key="action.id">
                    <span
                        v-if="
                            user_performance[`${this.getWeek(date.startDate)}`]
                        "
                    >
                        <span
                            v-if="
                                !user_performance[
                                    `${this.getWeek(date.startDate)}`
                                ][`${action.name}`]
                            "
                        >
                            0
                        </span>
                        <span v-else class="font-bold">
                            {{
                                user_performance[
                                    `${this.getWeek(date.startDate)}`
                                ][`${action.name}`]
                            }}
                        </span>
                    </span>
                    <span v-else> 0 </span>
                </td>
            </tr>
        </tbody>

        <tbody v-if="viewType === 'year'">
            <tr v-for="weeks in dates_in_one_year" class="text-center">
                <td>
                    {{ months[moment(weeks.start_date).add(2, "d").month()] }}
                </td>
                <td class="flex">
                    <!-- <p>{{ weeks.week_number }} </p><br /> -->
                    {{ showToday(weeks.start_date) }}
                    <p class="mx-2">to</p>
                    {{ showToday(weeks.end_date) }}
                </td>
                <td v-for="(action, index) in actions" :key="action.id">
                    <span
                        v-if="
                            user_performance[
                                `${this.getWeek(weeks.start_date)}`
                            ]
                        "
                    >
                        <span
                            v-if="
                                !user_performance[
                                    `${this.getWeek(weeks.start_date)}`
                                ][`${action.name}`]
                            "
                        >
                            0
                        </span>
                        <span v-else class="font-bold">
                            {{
                                user_performance[
                                    `${this.getWeek(weeks.start_date)}`
                                ][`${action.name}`]
                            }}
                        </span>
                    </span>
                    <span v-else> 0 </span>
                </td>
            </tr>
        </tbody>

        <!-- <div>{{ datesInWeek }}</div> -->
    </table>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import moment from "moment";
import {
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
    ArrowTopRightOnSquareIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        Pagination: LaravelVuePagination,
        ChevronDoubleLeftIcon,
        ChevronDoubleRightIcon,
        ArrowTopRightOnSquareIcon,
    },

    created() {},

    mounted() {
        this.getActions();
        this.getUsers();
        // this.selectedUser = document
        //     .querySelector('meta[name="user-id"]')
        //     .getAttribute("content");
        this.selectedUser = 4;

        this.getCurrentDate();
        this.getDates(this.currentDate);

        this.selectedDate = this.currentDate;
        console.log("selectedDate", this.selectedDate);

        this.m = parseInt(this.getSelectedMonth(this.selectedDate));
        this.y = parseInt(this.getSelectedYear(this.selectedDate));

        //initial month selection
        this.selectedMonth = this.getSelectedMonth(this.currentDate);
        this.selectedYear = this.getSelectedYear(this.currentDate);
        this.selectedMonthYear =
            this.selectedYear + "-" + this.selectedMonth + "-" + "01";
        this.currentMonth = this.selectedYear + "-" + this.selectedMonth;
        //initialise month view
        this.displayMonth(this.selectedYear, this.selectedMonth); //for month view

        this.displayYear(this.selectedYear, this.selectedDate); //for year view

        this.selectedStartDate = this.datesInWeek[0];
        // this.selectedStartDate = "2022-10-31"
        // console.log("selectedStartDate", this.selectedStartDate);
        this.selectedEndDate = this.datesInWeek[6];
        // this.selectedEndDate = "2022-11-06"
        // console.log("selectedEndDate", this.selectedEndDate);
        this.getUserPerformance();
    },

    props: {},

    data() {
        return {
            actions: [],
            users: [],
            users_actions: [],
            user_performance: [],
            m: Number,
            y: Number,
            daysInWeek: [],
            weeksInMonth: [],
            monthsInYear: [],
            // paginate: 10,
            viewType: "week",
            moment: moment,

            selectedUser: "",
            datesInWeek: [],
            dates_in_one_year: [],
            months: [
                "January",
                "February",
                "March",
                "April",
                "May",
                "June",
                "July",
                "August",
                "September",
                "October",
                "November",
                "December",
            ],
            weekday: ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun"],

            currentDate: "",
            currentMonth: "",
            currentYear: "",

            selectedStartDate: "",
            selectedEndDate: "",
            selectedWeek: "",
            selectedDate: "",
            selectedMonth: "",
            selectedYear: "",
            selectedMonthYear: "",

            sort_direction: "desc",
            sort_field: "todo_date",

            // action_fields: {
            //     ID: "id",
            //     Name: "name",
            // },

            performance_week: {
                // Week: {
                //     callback: (value) => {
                //         let week_date = this.datesInWeek;
   
                //         for (let date of week_date) {
                //             return `${date}`;
                //         }
                //         // return `${week_date}`;
                //     },
                // },


                // <td v-for="(action, index) in actions" :key="action.id">
                //     <span v-if="user_performance[0][`${date}`]">
                //         <span
                //             v-if="
                //                 !user_performance[0][`${date}`][`${action.name}`]
                //             "
                //         >
                //             0
                //         </span>
                //         <span v-else class="font-bold">
                //             {{ user_performance[0][`${date}`][`${action.name}`] }}
                //         </span>
                //     </span>
                //     <span v-else> 0 </span>
                // </td>

                Attended: 
                // "2022-10-31",
                {
                    callback: (value) => {
                        // let week_date = this.datesInWeek;

                        // for (let date in this.datesInWeek) {
                        //     return `${value[date]}`;
                        // }
                        return `${value["2022-10-31"]['Attended']}`;
                    },
                },

                // Called: {
                //     callback: (value) => {
                //         let week_date = this.datesInWeek;

                //         for (let date in week_date) {
                //             return `${value[date]['Attended']}`;
                //         }
                //     },
                // },

                // "Telephone 2": {
                //     field: "phone.landline",
                //     callback: (value) => {
                //       return `Landline Phone - ${value}`;
                //   },
                // },

                // "Appointment Visitation": {
                //     callback: (value) => {
                //         let week_date = this.datesInWeek;
                //         for (date in week_date){
                //             return `${value[date][`${action.name}`]}`;
                //         }
                //     }
                // },
                // "Approval obtained": {
                //     callback: (value) => {
                //         return ``;
                //     }
                // },
                // "Attended": {
                //     callback: (value) => {
                //         return ``;
                //     }
                // },
                // "Called": {
                //     callback: (value) => {
                //         return ``;
                //     }
                // },
                // "Carried Forward": {
                //     callback: (value) => {
                //         return ``;
                //     }
                // },
                // "Payment": {
                //     callback: (value) => {
                //         return ``;
                //     }
                // },
                // "To Call": {
                //     callback: (value) => {
                //         return ``;
                //     }
                // },
            },
            
            performance_month: {
                // Week: `${this.weeksInMonth}`,
            },

            performance_year: {
                // "Site No.": "site_id",
                // Location: "bboard_location",
                // Size: "bboard_size",
            },
        };
    },
    watch: {
        selectedUser: function (value) {
            this.getUserPerformance();
        },

        viewType: function (value) {
            if (value === "week") {
                this.monthsInYear = [];
                this.getUserPerformance();
            }
            if (value === "month") {
                this.monthsInYear = [];
                const monthYear = this.selectedMonthYear;
                this.getSelectedMonth(monthYear);
                this.getSelectedYear(monthYear);
                this.getUserPerformance();
            }
            if (value === "year") {
                this.monthsInYear = [];
                this.displayYear(this.selectedYear, this.selectedDate); //for year view
                this.getUserPerformance();
            }
        },

        currentMonth: function (value) {
            const monthYear = this.currentMonth + "-" + "01";
            this.selectedMonthYear = monthYear;
            this.weeksInMonth = [];
            this.getSelectedMonth(monthYear);
            this.getSelectedYear(monthYear);
            this.displayMonth(this.selectedYear, this.selectedMonth);
            this.getUserPerformance();
        },
    },
    computed: {
        console: () => console,
    },

    methods: {
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

        getUserPerformance() {
            axios
                .get(
                    "/api/users/performance?" +
                        "&viewType=" +
                        this.viewType +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedStartDate=" +
                        this.selectedStartDate +
                        "&selectedEndDate=" +
                        this.selectedEndDate +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedMonth=" +
                        this.selectedMonth +
                        "&selectedYear=" +
                        this.selectedYear
                )
                .then((res) => {
                    this.user_performance = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getWeek(date) {
            return moment(date).isoWeek();
        },

        getWeekday(day) {
            let currentDay = this.weekday[day];
            return currentDay;
        },

        // Dates in Week Loop
        getDates(date) {
            for (var x = 0; x < this.weekday.length; x++) {
                var datesOfWeek = moment(date)
                    .startOf("isoweek")
                    .add(x, "days")
                    .format("YYYY-MM-DD");
                this.datesInWeek.push(datesOfWeek);
            }
            return this.datesInWeek;
        },

        showToday(date) {
            let day = moment(date).format("DD-MM-YY");
            return day;
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

        displayMonth(selected_year, selected_month) {
            let monthYear = selected_year + "-" + selected_month + "-01";

            let y = parseInt(this.getSelectedYear(monthYear));
            let m = parseInt(this.getSelectedMonth(monthYear));

            const month = moment([y, m - 1]);
            console.log("month", month);

            const weekList = this.weeks(month);

            return this.weeksInMonth.push(...weekList);
        },

        getKeyByValue(object, value) {
            return Object.keys(object).filter((key) => object[key] === value);
        },

        getObjectKey(object) {
            return Object.keys(object);
        },

        returnFirstObjKey(obj, value) {
            return Object.keys(obj).find((key) => obj[key] === value);
        },

        displayYear(selected_year, selected_date) {
            var year_end_date = new Date(selected_year + "-12-31");

            for (let week = 1; week < 56; week++) {
                let initialDayOfWeek = moment(
                    moment(selected_date).isoWeek(week)
                )
                    .startOf("isoweek")
                    .format("YYYY-MM-DD");
                let finalDayOfWeek = moment(moment(selected_date).isoWeek(week))
                    .endOf("isoweek")
                    .format("YYYY-MM-DD");
                let week_number = moment(initialDayOfWeek).isoWeek();

                var check_date = new Date(initialDayOfWeek);

                if (check_date > year_end_date) {
                    return this.dates_in_one_year;
                } else {
                    this.dates_in_one_year.push({
                        week_number: week_number,
                        start_date: initialDayOfWeek,
                        end_date: finalDayOfWeek,
                    });
                }
            }
            return this.dates_in_one_year;
        },

        incrementDate() {
            if (this.viewType === "week") {
                document.getElementById("incrementDate").disabled = false;

                this.selectedDate = moment(this.selectedDate)
                    .add(1, "W")
                    .format("YYYY-MM-DD");

                this.datesInWeek = [];
                this.getDates(this.selectedDate);
                this.selectedStartDate = this.datesInWeek[0];
                this.selectedEndDate = this.datesInWeek[6];
                this.getUserPerformance();
            } else if (this.viewType === "month") {
                document.getElementById("incrementDate").disabled = false;
                var monthYear =
                    this.selectedYear + "-" + this.selectedMonth + "-" + "01";
                // console.log("monthYear : " + monthYear);

                var monthYearAdd = moment(monthYear)
                    .add(1, "M")
                    .format("YYYY-MM-DD");

                console.log("monthYearAdd : " + monthYearAdd);
                this.selectedMonthYear = monthYearAdd;

                var selected_month = this.getSelectedMonth(monthYearAdd);
                var selected_year = this.getSelectedYear(monthYearAdd);
                console.log("selected_month", selected_month);
                console.log("selected_month", selected_year);

                this.weeksInMonth = [];
                this.getSelectedMonth(monthYearAdd);
                this.getSelectedYear(monthYearAdd);

                this.displayMonth(selected_year, selected_month);
                this.getUserPerformance();

                var month = this.getSelectedMonth(monthYearAdd);
                var year = this.getSelectedYear(monthYearAdd);
                return (this.currentMonth = year + "-" + month);
            } else {
                document.getElementById("incrementDate").disabled = false;

                var monthYearBefore =
                    this.selectedYear + "-" + this.selectedMonth + "-" + "01";
                console.log("monthYearBefore : " + monthYearBefore);

                var monthYearAdd = moment(monthYearBefore)
                    .add(1, "y")
                    .format("YYYY-MM-DD");

                console.log("monthYearAdd : " + monthYearAdd);

                this.getSelectedYear(monthYearAdd);
                this.dates_in_one_year = [];

                this.displayYear(this.selectedYear, monthYearAdd);
                this.getUserPerformance();
            }
        },

        decrementDate() {
            if (this.viewType === "week") {
                document.getElementById("decrementDate").disabled = false;

                this.selectedDate = moment(this.selectedDate)
                    .subtract(1, "W")
                    .format("YYYY-MM-DD");

                this.datesInWeek = [];
                this.getDates(this.selectedDate);

                this.selectedStartDate = this.datesInWeek[0];
                this.selectedEndDate = this.datesInWeek[6];
                this.getUserPerformance();
            } else if (this.viewType === "month") {
                document.getElementById("decrementDate").disabled = false;
                var monthYear =
                    this.selectedYear + "-" + this.selectedMonth + "-" + "01";
                // console.log("monthYear : " + monthYear);

                var monthYearMinus = moment(monthYear)
                    .subtract(1, "M")
                    .format("YYYY-MM-DD");

                console.log("monthYearMinus : " + monthYearMinus);
                this.selectedMonthYear = monthYearMinus;

                var new_month_year = new Date(monthYearMinus);

                var selected_month = this.getSelectedMonth(new_month_year);
                var selected_year = this.getSelectedYear(new_month_year);

                console.log("selected_month", selected_month);
                console.log("selected_month", selected_year);

                this.weeksInMonth = [];
                this.getSelectedMonth(monthYearMinus);
                this.getSelectedYear(monthYearMinus);

                this.displayMonth(selected_year, selected_month);
                this.getUserPerformance();

                var month = this.getSelectedMonth(monthYearMinus);
                var year = this.getSelectedYear(monthYearMinus);
                return (this.currentMonth = year + "-" + month);
            } else {
                document.getElementById("decrementDate").disabled = false;

                var monthYearBefore =
                    this.selectedYear + "-" + this.selectedMonth + "-" + "01";
                console.log("monthYearBefore : " + monthYearBefore);

                var monthYearAdd = moment(monthYearBefore)
                    .subtract(1, "y")
                    .format("YYYY-MM-DD");

                console.log("monthYearAdd : " + monthYearAdd);

                this.getSelectedYear(monthYearAdd);
                this.dates_in_one_year = [];

                this.displayYear(this.selectedYear, monthYearAdd);
                this.getUserPerformance();
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
            let monthYear =
                this.selectedYear + "-" + this.selectedMonth + "-01";
            const y = parseInt(this.getSelectedYear(monthYear));
            const m = parseInt(this.getSelectedMonth(monthYear));
            return {
                startDate: moment([y, m - 1, start]),
                endDate: moment([y, m - 1, end]),
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
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
