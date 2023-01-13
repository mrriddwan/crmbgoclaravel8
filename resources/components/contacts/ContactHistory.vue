<template>
    <div class="mx-auto max-w-screen-lg min-h-screen">
        <GoBack />

        <div>
            <div
                class="mb-4 tracking-tight leading-none text-gray-900 md:text-4xl lg:text-5xl text-center"
            >
                <span
                    class="bg-yellow-400 px-10 py-3 rounded-md uppercase text-4xl font-extrabold"
                    >{{ contact.name }}</span
                >
            </div>
            <div class="my-2">
                <Pagination
                    :data="todo"
                    :limit="2"
                    @pagination-change-page="getContactHistory"
                    :size="'small'"
                    :align="'right'"
                    class="pagination"
                />
            </div>
            <div
                v-if="todo.data"
                class="overflow-x-auto relative sm:rounded-lg mx-auto"
            >
                <table
                    class="border-2 mb-4 text-xs text-left text-gray-500 dark:text-gray-400 mx-auto"
                >
                    <thead
                        class="text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr class="text-center">
                            <th scope="col" class="py-3 px-3 min-w-16">Date</th>
                            <th scope="col" class="py-3 px-3 min-w-16">CS</th>
                            <th scope="col" class="py-3 px-3 min-w-16">Task</th>
                            <th scope="col" class="py-3 px-3 min-w-16">Action</th>
                            <th scope="col" class="py-3 px-3 min-w-16">Remark</th>
                            <th scope="col" class="py-3 px-3 min-w-16"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="history in todo.data"
                            :key="history.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 font-bold"
                        >
                            <td class="py-2 px-3 w-24">
                                {{ showToday(history.todo_date) }}
                            </td>
                            <td class="py-2 px-3 w-32">{{ history.user.name }}</td>
                            <td class="py-2 px-3">
                                <span v-if="history.task">
                                    {{ history.task.name }}
                                </span>
                                <span v-else> Task not available </span>
                            </td>
                            <td class="py-2 px-3">
                                <span v-if="history.action">
                                    {{ history.action.name }}
                                </span>
                                <span v-else> No action yet </span>
                            </td>
                            <td class="py-2 px-3">{{ history.todo_remark }}</td>
                            <td class="py-2 px-3">
                                <router-link
                                    :to="{
                                        name: 'todo_index',
                                        params: {
                                            selectedDate: history.todo_date,
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
            <div v-else class="items-center my-5 min-w-96 px-96">
                <h5
                    class="mx-auto font-mono px-2 py-2 bg-grey-900 mb-2 text-xl font-extrabold tracking-tight leading-none text-gray-700 md:text-2xl lg:text-2xl text-center bg-slate-300 rounded-md uppercase w-max"
                >
                    No History Data
                </h5>
            </div>
        </div>
    </div>
</template>

<script>
import { EyeIcon } from "@heroicons/vue/24/solid";
import GoBack from "../utils/GoBack.vue";
import moment from "moment";
import LaravelVuePagination from "laravel-vue-pagination";

export default {
    components: {
        GoBack,
        EyeIcon,
        Pagination: LaravelVuePagination,
    },

    data() {
        return {
            info: "",
            contact: [],
            todo: [],
            moment: moment,
        };
    },

    mounted() {
        this.getContactHistory();
        this.showContact();
    },

    methods: {
        getContactHistory(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/contacts/history/" +
                        this.$route.params.id +
                        "?page=" +
                        page
                )
                .then((res) => {
                    // this.contact = res.data.data;
                    this.todo = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        showContact() {
            axios
                .get("/api/contacts/show/" + this.$route.params.id)
                .then((res) => {
                    this.contact = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        showToday(date) {
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("DD-MM-YY");
            return day;
        },
    },
};
</script>
