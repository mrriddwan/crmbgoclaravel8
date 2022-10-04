<template>
    <div v-for="info in contact_infos" :key="contact_infos.id">
        <div class="container w-max -4 align-center mx-auto h-max">
            <div class="max-h-10 mb-2 ml-4 h-9">
                <GoBack class="" />
            </div>

            <div
                class="items-center text-center text-white font-extrabold bg-slate-600 px-2 py-1 rounded-md"
            >
                <h1 class="px-2 bg-black-50 col-span-2 uppercase">
                    Company Information
                </h1>
            </div>
            <div class="mx-auto col-md-10">
                <table class="mt-1 mr-1 ml-1 mb-2 grid w-full">
                    <tbody>
                        <tr class="">
                            <td class="uppercase">Name</td>
                            <td
                                class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                            >
                                {{ info.name }}
                            </td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'todo_insert',
                                        params: { id: info.id },
                                    }"
                                    class="inline-block w-max bg-green-400 text-center px-1 py-1 transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PlusCircleIcon
                                        class="inline-flex h-6 w-6 mr-1"
                                    />
                                    To Do
                                </router-link>
                            </td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'contacts_edit',
                                        params: { id: info.id },
                                    }"
                                    class="inline-flex text-right px-2 py-1 bg-yellow-400 -transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-6 w-6" />
                                </router-link>
                            </td>
                        </tr>
                        <tr class="">
                            <td class="uppercase">Industry</td>
                            <td
                                class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                            >
                                {{ info.industry.name }}
                            </td>
                        </tr>
                        <tr class="">
                            <td class="uppercase">Category</td>
                            <td
                                class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                            >
                                {{ info.category.name }}
                            </td>
                        </tr>
                        <tr class="">
                            <td class="uppercase">Address</td>
                            <td
                                class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                            >
                                {{ info.address }}
                            </td>
                        </tr>
                        <tr class="">
                            <td class="uppercase">CS</td>
                            <td
                                class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                            >
                                {{ info.user.name }}
                            </td>
                        </tr>
                        <!-- Link to -->
                        <tr class="">
                            <td class="py-4 uppercase">History</td>
                            <td class="px-2 py-4">
                                <router-link
                                    :to="{
                                        name: 'contacts_history',
                                        params: { id: info.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-1 py-1 bg-blue-400 -transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <BookOpenIcon class="h-8 w-8"
                                /></router-link>
                            </td>
                        </tr>

                        <!-- PIC Infos-->
                        <h5
                            class="text-center text-white font-extrabold font-mono text-sm uppercase bg-slate-600 px-5 py-2 rounded-md"
                        >
                            PIC
                        </h5>

                        <tr class="col-span-2 px-2 py-4">
                            <td>PIC</td>
                            <td>
                                <router-link
                                    :to="{
                                        name: 'incharge_create',
                                        params: { id: info.id },
                                    }"
                                    class="inline-flex text-center px-1 py-1 transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <div
                                        class="bg-green-400 inline-flex rounded-md align-middle px-1"
                                    >
                                        <PlusIcon
                                            class="h-8 w-8 bg-green-400 py-1 px-1 rounded-md"
                                        />
                                        <p class="text-center">PIC</p>
                                    </div>
                                    <PencilSquareIcon
                                        class="h-8 w-8 bg-yellow-400 py-1 px-1 rounded-md"
                                    />
                                </router-link>
                            </td>
                        </tr>
                        <span>
                            <span
                                v-if="info.incharge.length !== 0"
                                class="px-2 py-2 my-4"
                            >
                                <span
                                    v-for="(pic, index) in info.incharge"
                                    :key="info.incharge.id"
                                    class="my-2 py-1 border-gray-200"
                                >
                                    <!-- <tr ></tr> -->

                                    <tr
                                        class="text-left text-neutral-300 py-2 border-gray-200 grid grid-cols-4"
                                    >
                                        <div>
                                            <td>
                                                <span
                                                    class="bg-cyan-700 px-2 py-1 font-semibold font-mono rounded-md"
                                                >
                                                    {{ index + 1 }}
                                                </span>
                                            </td>
                                            <td
                                                class="px-1 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap"
                                            >
                                                Name:
                                            </td>
                                            <td
                                                class="px-1 py-1 text-md leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                            >
                                                {{ pic.name }}
                                            </td>
                                        </div>
                                        <div>
                                            <td
                                                class="px-1 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap"
                                            >
                                                Email:
                                            </td>
                                            <td
                                                class="px-1 py-1 text-md leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                            >
                                                {{ pic.email }}
                                            </td>
                                        </div>
                                        <div>
                                            <td
                                                class="px-1 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap"
                                            >
                                                Phone No. (Mobile):
                                            </td>
                                            <td
                                                class="px-1 py-1 text-md leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                            >
                                                {{ pic.phone_mobile }}
                                            </td>
                                        </div>
                                        <div>
                                            <td
                                                class="px-1 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap"
                                            >
                                                Phone No. (Office):
                                            </td>
                                            <td
                                                class="px-1 py-1 text-md leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                            >
                                                {{ pic.phone_office }}
                                            </td>
                                            <td class="py-1">
                                                <router-link
                                                    :to="{
                                                        name: 'incharge_edit',
                                                        params: { id: pic.id },
                                                    }"
                                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                                >
                                                    <PencilSquareIcon
                                                        class="h-3 w-3"
                                                /></router-link>
                                                <button
                                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                                    @click="deletePIC(pic.id)"
                                                >
                                                    <TrashIcon
                                                        class="h-3 w-3"
                                                    />
                                                </button>
                                            </td>
                                        </div>
                                    </tr>
                                </span>
                            </span>
                            <span v-else>
                                <div
                                    class="uppercase text-center font-extrabold text-5xl bg-slate-400 rounded-md py-3 px-3"
                                >
                                    <h1><strong>No PIC </strong></h1>
                                </div>
                            </span>
                        </span>
                        <h5
                            class="items-center m-2 text-center text-white font-extrabold font-mono text-sm uppercase bg-slate-600 px-5 py-2 rounded-md"
                        >
                            Forecast
                        </h5>
                        <!-- Forecast Infos-->
                        <tr class="col-span-2 px-2">
                            <td class="uppercase py-2">Forecast</td>
                            <td class="ml-4">
                                <router-link
                                    :to="`/forecast/${info.id}/create`"
                                    class="ml-1 px-2 py-2 items-center border text-xs text-right rounded-lg w-max text-lime-600"
                                >
                                    <PlusIcon class="h-3 w-3 inline" />
                                    <DocumentChartBarIcon
                                        class="h-6 w-6 inline"
                                /></router-link>
                            </td>
                        </tr>

                        <span>
                            <span
                                v-if="info.forecast.length !== 0"
                                v-for="(forecast_info, index) in info.forecast"
                                :key="forecast_info.id"
                                class=""
                            >
                                <tr
                                    class="grid grid-cols-4 border-gray-200 py-2 border-2"
                                >
                                    <div>
                                        <td>
                                            <span
                                                class="bg-cyan-700 px-2 py-1 font-semibold font-mono rounded-md text-neutral-300"
                                            >
                                                {{ index + 1 }}
                                            </span>
                                        </td>
                                        <td
                                            class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap"
                                        >
                                            Product:
                                        </td>
                                        <td
                                            class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                        >
                                            {{ forecast_info.product.name }}
                                        </td>
                                    </div>

                                    <div>
                                        <td
                                            class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap"
                                        >
                                            Amount(RM):
                                        </td>
                                        <td
                                            class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                        >
                                            {{
                                                forecast_info.amount.toLocaleString(
                                                    "en-US"
                                                )
                                            }}
                                        </td>
                                    </div>

                                    <div>
                                        <td
                                            class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap"
                                        >
                                            Forecast Type:
                                        </td>
                                        <td
                                            class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                        >
                                            {{
                                                forecast_info.forecast_type.name
                                            }}
                                        </td>
                                    </div>

                                    <div>
                                        <td
                                            class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap"
                                        >
                                            Date:
                                        </td>
                                        <td
                                            class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                        >
                                            {{
                                                showToday(
                                                    forecast_info.forecast_date
                                                )
                                            }}
                                        </td>

                                        <router-link
                                            :to="{
                                                name: 'forecast_edit',
                                                params: {
                                                    id: forecast_info.id,
                                                },
                                            }"
                                            class="mr-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                        >
                                            <PencilSquareIcon class="h-3 w-3"
                                        /></router-link>
                                        <button
                                            class="mr-2 inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                            @click="
                                                deleteForecast(forecast_info.id)
                                            "
                                        >
                                            <TrashIcon class="h-3 w-3" />
                                        </button>
                                    </div>
                                </tr>
                            </span>
                            <span v-else>
                                <div
                                    class="uppercase text-center font-extrabold text-5xl bg-slate-400 rounded-md py-3 px-3"
                                >
                                    <h1><strong>No Forecast </strong></h1>
                                </div>
                            </span>
                        </span>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import GoBack from "../utils/GoBack.vue";
import moment from "moment";
import {
    PencilSquareIcon,
    TrashIcon,
    PlusCircleIcon,
    PlusIcon,
    PencilIcon,
    BookOpenIcon,
    DocumentChartBarIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        GoBack,
        PencilSquareIcon,
        TrashIcon,
        PlusCircleIcon,
        PlusIcon,
        PencilIcon,
        BookOpenIcon,
        DocumentChartBarIcon,
    },

    data() {
        return {
            info: "",
            contact_infos: [],
            moment: moment,
        };
    },

    mounted() {
        this.showContact();
    },

    methods: {
        showContact() {
            axios
                .get("/api/contacts/info/" + this.$route.params.id)
                .then((res) => {
                    this.contact_infos = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        deletePIC(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/incharges/delete/" + id);
            this.$router.push({
                name: "contacts_info",
                params: { id: this.$route.params.id },
            });
            this.showContact();
        },

        deleteForecast(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/forecasts/delete/" + id);
            this.$router.push({
                name: "contacts_info",
                params: { id: this.$route.params.id },
            });
            this.showContact();
        },

        showToday(date) {
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("DD-MM-YYYY");
            return day;
        },
    },
};
</script>
