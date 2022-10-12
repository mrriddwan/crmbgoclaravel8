<template>
    <div class="container w-max align-center">
        <div v-if="errors">
            <div v-for="(v, k) in errors" :key="k">
                <p
                    v-for="error in v"
                    :key="error"
                    class="text-xs bg-red-500 text-white rounded font-bold mb-1 shadow-lg py-2 px-8 w-max"
                >
                    {{ error }}
                </p>
            </div>
        </div>
        <h1
            class="items-center text-center text-white font-extrabold font-mono text-4xl uppercase bg-slate-600 px-2 py-2 rounded-md"
        >
            Create Billboard
        </h1>

        <div class="text-center">
            <form
                @submit.prevent="createBillboard"
                ref="inchargeForm"
                class="inline-block align-middle"
            >
                <div class="grid grid-cols-1 items-center text-center">
                    <div class="grid grid-cols-2 w-auto items-center py-2 px-2">
                        <div class="inline-block">
                            <label class=""
                                >Site No.
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                        </div>
                        <div class="flex">
                            <div class="mx-2">
                                <input
                                    type="text"
                                    class="w-20 inline-block mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="form.site_id1"
                                />
                            </div>
                            <div class="pt-2">
                                <p class="uppercase text-2xl">-</p>
                            </div>
                            <div class="mx-2">
                                <input
                                    type="text"
                                    class="w-20 inline-block mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="form.site_id2"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 w-auto items-center py-2 px-2">
                        <label class="mx-2"
                            >Location
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <input
                            type="text"
                            class="inline-block items-left mt-1 mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.bboard_location"
                        />
                    </div>
                    <div class="grid grid-cols-2 w-auto items-center py-2 px-2">
                        <div class="inline-block">
                            <label class=""
                                >Size
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                        </div>
                        <div class="flex">
                            <div class="mx-2">
                                <input
                                    type="text"
                                    class="w-20 inline-block mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="form.bboard_size1"
                                />
                            </div>
                            <div class="pt-3">
                                <p class="uppercase text-md">X</p>
                            </div>
                            <div class="mx-2">
                                <input
                                    type="text"
                                    class="w-20 inline-block mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="form.bboard_size2"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <button
                    type="submit"
                    class="inline-flex mt-2 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    Create
                </button>
            </form>
        </div>

        <div class="max-h-10 my-2">
            <GoBack class="" />
        </div>

        <!-- <div class="m-4">
            <span v-if="info.forecast.length !== 0">
                <h5
                    class="items-center text-center text-white font-extrabold font-mono text-sm uppercase bg-slate-600 px-5 py-2 rounded-md"
                >
                    Forecast
                </h5>
                <span
                    v-for="(forecast_info, index) in info.forecast"
                    :key="forecast_info.id"
                    class=""
                >
                    <tr class="grid grid-cols-4 border-gray-200 py-2 border-2">
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
                                    forecast_info.amount.toLocaleString("en-US")
                                }}
                            </td>
                        </div>

                        <div>
                            <td
                                class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap"
                            >
                                Type:
                            </td>
                            <td
                                class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                            >
                                {{ forecast_info.forecast_type.name }}
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
                                {{ showToday(forecast_info.forecast_date) }}
                            </td>

                            <router-link
                                :to="{
                                    name: 'forecast_edit',
                                    params: { id: forecast_info.id },
                                }"
                                class="mr-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                                <PencilSquareIcon class="h-3 w-3"
                            /></router-link>
                            <button
                                class="mr-2 inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                @click="deleteForecast(forecast_info.id)"
                            >
                                <TrashIcon class="h-3 w-3" />
                            </button>
                        </div>
                    </tr>
                </span>
            </span>

            <span v-else>
                <h5
                    class="items-center text-center text-white font-extrabold font-mono text-sm uppercase bg-slate-600 px-5 py-2 rounded-md"
                >
                    Forecast
                </h5>
                <div
                    class="uppercase text-center font-extrabold text-5xl bg-slate-400 rounded-md py-3 px-3"
                >
                    <h1><strong>No Forecast Data</strong></h1>
                </div>
            </span>
        </div> -->
    </div>
</template>

<script>
import GoBack from "../utils/GoBack.vue";
import {
    PencilSquareIcon,
    TrashIcon,
    PlusCircleIcon,
    PlusIcon,
    PencilIcon,
} from "@heroicons/vue/24/solid";
import moment from "moment";
import { VueDatePicker } from "@vuepic/vue-datepicker";

export default {
    components: { GoBack, PencilSquareIcon, TrashIcon, VueDatePicker },

    data() {
        return {
            moment: moment,
            contact_infos: [],
            form: {
                site_id1: "",
                site_id2: "",
                bboard_location: "",
                bboard_size1: "",
                bboard_size2: "",
            },
            errors: "",
        };
    },
    mounted() {},
    methods: {
        async createBillboard() {
            try {
                await axios.post("/api/billboards/store", {
                    site_id1: this.form.site_id1,
                    site_id2: this.form.site_id2,
                    bboard_location: this.form.bboard_location,
                    bboard_size1: this.form.bboard_size1,
                    bboard_size2: this.form.bboard_size2,
                });

                this.$router.push({
                    name: "billboard_index",
                    // params: { id: this.$route.params.id },
                });
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },
    },
};
</script>
