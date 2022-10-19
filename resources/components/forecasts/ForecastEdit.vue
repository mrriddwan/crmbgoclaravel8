<template>
    <div class="container w-max align-center">
        <div v-if="errors">
            <div v-for="(v, k) in errors" :key="k">
                <p
                    v-for="error in v"
                    :key="error"
                    class="text-xs bg-red-500 text-white rounded font-bold mb-1 shadow-lg py-2 px-4 pr-0 w-max"
                >
                    {{ error }}
                </p>
            </div>
        </div>
        <h1
            class="items-center text-center text-white font-extrabold font-mono text-5xl uppercase bg-slate-600 px-5 py-2 rounded-md"
        >
            Edit Forecast
        </h1>
        <div>
            <!-- <div v-for="contact in forecast.contact" -->
            <div
                class="items-center text-center text-black font-extrabold px-1 py-3 rounded-md w-max mx-auto"
            >
                <h2
                    class="px-2 py-1 text-4xl bg-amber-300 rounded-lg uppercase font-semibold"
                >
                    {{ forecast.contact.name }}
                </h2>
            </div>
            <div class="text-center">
                <form
                    @submit.prevent="editForecast()"
                    class="inline-block align-middle"
                >
                    <div class="grid grid-cols-1 items-center text-center">
                        <div class="grid grid-cols-2 w-auto items-center py-2">
                            <div class="">
                                <label class="ml-7"
                                    >Product
                                    <p class="inline text-red-600 text-lg">
                                        *
                                    </p></label
                                >
                            </div>
                            <div class="">
                                <select
                                    v-model="forecast.product_id"
                                    class="form-control"
                                >
                                    <option disabled value="">
                                        Please select product
                                    </option>
                                    <option
                                        v-for="product in products"
                                        :key="product.id"
                                        :value="product.id"
                                    >
                                        {{ product.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 w-auto items-center py-2">
                            <label class="ml-7"
                                >Amount
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                            <div>
                                <span
                                    class="bg-slate-600 px-2 py-1 inline-block rounded-md text-white"
                                    >RM</span
                                >
                                <input
                                    type="number"
                                    class="inline-block items-left mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="forecast.amount"
                                />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 w-auto items-center py-2">
                            <label class="ml-7"
                                >Type
                                <p class="inline text-red-600 text-lg">*</p>
                            </label>
                            <div>
                                <select
                                    v-model="forecast.forecast_type_id"
                                    class="form-control"
                                >
                                    <option disabled value="">
                                        Please select type
                                    </option>
                                    <option
                                        v-for="forecast_type in forecast_types"
                                        :key="forecast_type.id"
                                        :value="forecast_type.id"
                                    >
                                        {{ forecast_type.name }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 items-center">
                            <label class="ml-7"
                                >Forecast Date
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                            <div class="w-max">
                            <VueDatePicker
                                v-model="forecast.forecast_date"
                                showNowButton
                                nowButtonLabel="Today"
                                :enableTimePicker="false"
                            />
                        </div>
                        </div>
                    </div>
                    <div class="text-center col-span-2">
                        <button
                            type="submit"
                            class="mt-4 px-8 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 item"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="max-h-10 m-6">
            <GoBack class="m-5" />
        </div>
    </div>
</template>

<script>
import GoBack from "../utils/GoBack.vue";
import axios from "axios";
import { VueDatePicker } from "@vuepic/vue-datepicker";
import {
    PencilSquareIcon,
    TrashIcon,
    PlusCircleIcon,
    PlusIcon,
    PencilIcon,
} from "@heroicons/vue/24/solid";
import moment from "moment";

export default {
    components: { GoBack, PencilSquareIcon, TrashIcon, VueDatePicker },

    data() {
        return {
            moment: moment,
            forecast: {
                contact_id: "",
                product_id: "",
                amount: "",
                forecast_type_id: "",
                forecast_date: "",
                contact: {
                    id:"",
                    name: "",
                }
            },
            errors: "",
            products: [],
            forecast_types: [],
            forecast_infos: [],
        };
    },

    mounted() {
        this.showForecast();
        this.getProducts();
        this.getForecastTypes();
    },
    methods: {
        showForecast() {
            axios
                .get("/api/forecasts/info/" + this.$route.params.id)
                .then((res) => {
                    this.forecast = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        editForecast() {
            console.log(this.forecast.contact.name);
            console.log(this.forecast.amount);
            axios
                .put("/api/forecasts/update/" + this.$route.params.id, {
                    forecast_date: this.moment(this.forecast.forecast_date).format("YYYY-MM-DD"),
                    amount: this.forecast.amount,
                    contact_id: this.forecast.contact.id,
                    // user_id: 2, //replace with current user id later
                    product_id: this.forecast.product_id,
                    forecast_type_id: this.forecast.forecast_type_id,
                })
                .then((res) => {
                    this.$router.push({
                        name: "forecast_index",
                    });
                });
        },

        async getForecastTypes() {
            await axios
                .get("/api/forecasts/type/index")
                .then((res) => {
                    this.forecast_types = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getProducts() {
            await axios
                .get("/api/forecasts/product/index")
                .then((res) => {
                    this.products = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
