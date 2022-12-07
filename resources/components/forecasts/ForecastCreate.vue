<template>
    <div
        class="container w-max align-center"
        v-for="info in contact_infos"
        :key="contact_infos.id"
    >
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
            class="items-center text-center text-white font-extrabold font-mono text-4xl uppercase bg-yellow-400 px-2 py-2 rounded-md"
        >
            Create Forecast
        </h1>

        <div
            class="items-center text-center text-black font-extrabold px-1 py-3 rounded-md w-max mx-auto"
        >
            <h2
                class="px-2 py-1 text-4xl bg-amber-300 rounded-lg uppercase font-semibold"
            >
                {{ info.name }}
            </h2>
        </div>
        <div class="text-center">
            <form
                @submit.prevent="createForecast"
                ref="inchargeForm"
                class="inline-block align-middle"
            >
                <div class="grid grid-cols-1 items-center text-center">
                    <div class="grid grid-cols-2 w-auto items-center py-2 px-2">
                        <div class="">
                            <label class="ml-7"
                                >User
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                        </div>
                        <div class="">
                            <select
                                v-model="form.user_id"
                                class="form-control"
                            >
                                <option value="">
                                    Please select user
                                </option>
                                <option
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.id"
                                >
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 w-auto items-center py-2 px-2">
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
                                v-model="form.product_id"
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
                    <div class="grid grid-cols-2 w-auto items-center py-2 px-2">
                        <label class="ml-7"
                            >Amount
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <div>
                            <span
                                class="bg-slate-600 px-2 py-1 inline-block rounded-md text-white"
                                >RM</span
                            >
                            <input
                                type="number"
                                class="inline-block items-left mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.amount"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 w-auto items-center py-2 px-2">
                        <label class="ml-7"
                            >Type
                            <p class="inline text-red-600 text-lg">*</p>
                        </label>
                        <div>
                            <select
                                v-model="form.forecast_type_id"
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

                    <div class="grid grid-cols-2 items-center px-2">
                        <label class="ml-7"
                            >Forecast Date
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <div class="w-max">
                            <VueDatePicker
                                v-model="form.forecast_date"
                                showNowButton
                                nowButtonLabel="Today"
                                :enableTimePicker="false"
                            />
                        </div>
                    </div>
                </div>
                <div class="text-center col-span-2 px-2">
                    <button
                        type="submit"
                        class="mt-4 px-8 py-2 bg-gray-800 border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 item"
                    >
                        Create
                    </button>
                </div>
            </form>
        </div>

        <div class="max-h-10 my-2">
            <GoBack class="" />
        </div>

        <div class="m-4">
            <span v-if="info.forecast.length !== 0">
                <h5
                    class="items-center text-center text-white font-extrabold font-mono text-sm uppercase bg-blue-900 px-5 py-2 rounded-md"
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
                    class="items-center text-center text-white font-extrabold font-mono text-sm uppercase bg-blue-900 px-5 py-2 rounded-md"
                >
                    Forecast
                </h5>
                <div
                    class="uppercase text-center font-extrabold text-5xl bg-slate-400 rounded-md py-3 px-3"
                >
                    <h1><strong>No Forecast Data</strong></h1>
                </div>
            </span>
        </div>
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
            info: "",
            contact_infos: [],
            form: {
                user_id: "",
                contact_id: "",
                product_id: "",
                amount: "",
                forecast_type_id: "",
                forecast_date: "",
            },
            errors: "",
            products: [],
            forecast_types: [],
        };
    },
    mounted() {
        this.showForecast();
        this.getUsers()
        this.getProducts();
        this.getForecastTypes();
        this.form.user_id = document
            .querySelector('meta[name="user-id"]')
            .getAttribute("content");
    },
    methods: {
        showForecast() {
            axios
                .get("/api/contacts/info/" + this.$route.params.id)
                .then((res) => {
                    this.contact_infos = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async createForecast() {
            const contact = this.contact_infos;
            // const form = document.getElementById('inchargeForm');
            try {
                await axios.post("/api/forecasts/store", {
                    forecast_date: this.moment(this.form.forecast_date).format("YYYY-MM-DD"),
                    amount: this.form.amount,
                    user_id: this.form.user_id,
                    contact_id: contact[0].id,
                    contact_type_id: contact[0].type_id,
                    contact_status_id: contact[0].status_id,
                    product_id: this.form.product_id,
                    forecast_type_id: this.form.forecast_type_id,
                });
                if (window.confirm("Finish creating and back to main page?")) {
                    await this.$router.push({
                        name: "forecast_index",
                    });
                } else {
                    this.$router.push({
                        name: "forecast_create",
                        params: { id: this.$route.params.id },
                    });
                }

                this.form.product_id = "";
                this.form.forecast_type_id = "";
                this.form.amount = "";
                this.form.forecast_date = "";
                this.errors = "";
                this.showForecast();
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async getUsers() {
            await axios
                .get("/api/users/users_list")
                .then((res) => {
                    this.users = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
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

        deleteForecast(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/forecasts/delete/" + id);
            this.$router.push({
                name: "forecast_create",
                params: { id: this.$route.params.id },
            });
            this.showIncharge();
        },

        showToday(date) {
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("DD-MM-YY");
            return day;
        },
    },
};
</script>

<script></script>
