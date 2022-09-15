<template>
    <div v-for="info in contact_infos" :key="contact_infos.id">
        <div class="container w-max border-4 align-center mx-auto h-max">
            <div class="max-h-10 mb-2 ml-4 h-9">
                <GoBack class="" />
            </div>

            <div
                class="items-center text-center text-white font-extrabold bg-slate-600 px-2 py-1 rounded-md"
            >
                <h1 class="px-2 bg-black-50 col-span-2">Company Information</h1>
            </div>

            <div class="inline-block text-right border w-full">
                <router-link
                    :to="{
                        name: 'todo_insert',
                        params: { id: info.id },
                    }"
                    class="mr-2 inline-flex text-right px-2 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    <PlusCircleIcon class="h-5 w-5" />
                    <p>To Do</p></router-link
                >
                <router-link
                    :to="{
                        name: 'contacts_edit',
                        params: { id: info.id },
                    }"
                    class="mr-2 inline-flex text-right px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    <PencilSquareIcon class="h-5 w-5" />
                    <p>Edit</p></router-link
                >
            </div>

            <table class="border-black mt-1 mr-1 ml-1 mb-2 grid">
                <tbody>
                    <tr class="border">
                        <td>Name</td>
                        <td
                            class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                        >
                            {{ info.name }}
                        </td>
                    </tr>
                    <tr class="border">
                        <td>Industry</td>
                        <td
                            class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                        >
                            {{ info.industry.name }}
                        </td>
                    </tr>
                    <tr class="border">
                        <td>Category</td>
                        <td
                            class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                        >
                            {{ info.category.name }}
                        </td>
                    </tr>
                    <tr class="border">
                        <td>Address</td>
                        <td
                            class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                        >
                            {{ info.address }}
                        </td>
                    </tr>
                    <tr class="border">
                        <td>CS</td>
                        <td
                            class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                        >
                            {{ info.user.name }}
                        </td>
                    </tr>
                    <!-- Link to -->
                    <tr class="border">
                        <td class="py-4">History</td>
                        <td class="px-2 py-4">
                            <router-link
                                :to="{
                                    name: 'contacts_history',
                                    params: { id: info.id },
                                }"
                                class="mr-2 mb-2 inline-flex items-center px-1 py-1 bg-blue-400 border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                                <BookOpenIcon class="h-8 w-8"
                            /></router-link>
                        </td>
                    </tr>

                    <!-- PIC Infos-->
                    <tr class="col-span-2 px-2 py-4 border">
                        <td>PIC</td>
                        <td>
                            <router-link
                                :to="{
                                    name: 'incharge_create',
                                    params: { id: info.id },
                                }"
                                class="inline-flex text-center px-1 py-1 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                                <PencilSquareIcon class="h-5 w-5" /> /
                                <PlusIcon class="h-5 w-5" /> PIC</router-link
                            >
                        </td>
                    </tr>

                    <span v-if="info.incharge.length !== 0" class="px-2 py-4">
                        <span
                            v-for="pic in info.incharge"
                            :key="info.incharge.id"
                            class="m-3 grid grid-cols-2 items-center border-2"
                        >
                            <tr class="border">
                                <div>
                                    <td
                                        class="px-2 py-4 text-m leading-5 text-gray-900 whitespace-no-wrap"
                                    >
                                        Name
                                    </td>
                                    <td
                                        class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                    >
                                        {{ pic.name }}
                                    </td>
                                </div>
                                <div>
                                    <td
                                        class="px-2 py-4 text-m leading-5 text-gray-900 whitespace-no-wrap"
                                    >
                                        Email
                                    </td>
                                    <td
                                        class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                    >
                                        {{ pic.email }}
                                    </td>
                                </div>
                            </tr>

                            <tr class="border">
                                <div>
                                    <td
                                        class="px-2 py-4 text-m leading-5 text-gray-900 whitespace-no-wrap"
                                    >
                                        Phone No. (Mobile)
                                    </td>
                                    <td
                                        class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                    >
                                        {{ pic.phone_mobile }}
                                    </td>
                                </div>

                                <div>
                                    <td
                                        class="px-2 py-4 text-m leading-5 text-gray-900 whitespace-no-wrap"
                                    >
                                        Phone No. (Office)
                                    </td>
                                    <td
                                        class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                    >
                                        {{ pic.phone_office }}
                                    </td>
                                </div>
                            </tr>

                            <tr class="ml-4 border">
                                <router-link
                                    :to="{
                                        name: 'incharge_edit',
                                        params: { id: pic.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilIcon class="h-3 w-3"
                                /></router-link>
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="deletePIC(pic.id)"
                                >
                                    <TrashIcon class="h-3 w-3" />
                                </button>
                            </tr>
                        </span>
                    </span>

                    <span v-else class="">
                        <td
                            class="mx-auto font-serif border-5 border-grey-900 mb-2 text-xl font-extrabold tracking-tight leading-none text-gray-700 md:text-2xl lg:text-2xl text-center bg-slate-500 py-2 px-2 rounded-md uppercase w-max"
                        >
                            No PIC
                        </td>
                    </span>

                    <!-- Forecast Infos-->
                    <tr class="col-span-2 px-2 py-2 border">
                        <td class="uppercase">Forecast</td>
                        <td>
                            <router-link
                                :to="{
                                    name: 'incharge_create',
                                    params: { id: info.id },
                                }"
                                class="inline-flex text-center px-1 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                                <PencilSquareIcon class="h-5 w-5" /><p class="uppercase px-2">/</p>
                                <PlusIcon class="h-5 w-5" />
                                <p class="uppercase px-2">Forecast</p></router-link
                            >
                        </td>
                    </tr>

                    <span v-if="info.forecast">
                        <span
                            v-for="forecast_info in info.forecast"
                            :key="forecast_info.id"
                            class="grid grid-cols-2 border-2 p-1"
                        >
                            <tr class="grid grid-cols-2 border">
                                <td
                                    class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap"
                                >
                                    Product
                                </td>
                                <td
                                    class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                >
                                    {{ forecast_info.product.name }}
                                </td>
                            </tr>

                            <tr class="grid grid-cols-2 border">
                                <td
                                    class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap"
                                >
                                    Amount (RM)
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
                            </tr>
                            <tr class="grid grid-cols-2 border">
                                <td
                                    class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap"
                                >
                                    Type
                                </td>
                                <td
                                    class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                >
                                    {{ forecast_info.type.name }}
                                </td>
                            </tr>
                            <tr class="grid grid-cols-2 border">
                                <td
                                    class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap"
                                >
                                    Date
                                </td>
                                <td
                                    class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                >
                                    {{ forecast_info.forecast_date }}
                                </td>
                            </tr>

                            <tr class="text-center col-span-2 border">
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
                            </tr>
                        </span>
                    </span>

                    <span v-if="!info.forecast" class="">
                        <td
                            class="mx-auto font-serif border-5 border-grey-900 mb-2 text-xl font-extrabold tracking-tight leading-none text-gray-700 md:text-2xl lg:text-2xl text-center bg-slate-500 py-2 px-2 rounded-md uppercase w-max"
                        >
                            No Forecast Data
                        </td>
                    </span>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import GoBack from "../utils/GoBack.vue";
import {
    PencilSquareIcon,
    TrashIcon,
    PlusCircleIcon,
    PlusIcon,
    PencilIcon,
    BookOpenIcon,
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
    },

    data() {
        return {
            info: "",
            contact_infos: [],
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
    },
};
</script>
