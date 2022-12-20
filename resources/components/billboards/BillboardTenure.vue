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
        <div class="grid grid-cols-2 gap-2">
            <div class="text-center">
                <h3
                    class="items-center text-center text-white font-extrabold font-mono text-4xl uppercase bg-blue-900 px-2 py-2 rounded-md"
                >
                    Billboard
                </h3>
                <form
                    @submit.prevent="updateBillBoard"
                    ref="inchargeForm"
                    class="inline-block align-middle"
                >
                    <div class="grid grid-cols-1 items-center text-center">
                        <div class="grid grid-cols-2">
                            <div class="grid grid-cols-1">
                                <div class="inline-block w-full mt-2">
                                    <label class=""
                                        >Site No.
                                        <p class="inline text-red-600 text-lg">
                                            *
                                        </p></label
                                    >
                                </div>
                                <div class="inline-block w-max mx-auto my-2">
                                    <div class="flex">
                                        <div class="mx-2">
                                            <input
                                                type="text"
                                                class="text-center w-20 inline-block mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                v-model="billboard.site_id1"
                                            />
                                        </div>
                                        <div class="pt-2 mx-2">
                                            <p class="uppercase text-xl">-</p>
                                        </div>
                                        <div class="mx-2">
                                            <input
                                                type="text"
                                                class="text-center w-20 inline-block mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                v-model="billboard.site_id2"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="w-full mt-2">
                                    <label class="mx-2">Current</label>
                                </div>
                                <div class="w-full">
                                    <input
                                        disabled
                                        type="text"
                                        class="bg-slate-300 text-slate-600 text-center w-36 inline-block items-left mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="billboard.site_id"
                                    />
                                </div>
                            </div>
                        </div>

                        <div
                            class="grid grid-cols-5 w-auto items-left py-2 px-2"
                        >
                            <label class="mx-2 py-3"
                                >Location
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                            <input
                                type="text"
                                class="inline-block col-span-4 text-center items-left mt-1 mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="billboard.bboard_location"
                            />
                        </div>
                        <div class="grid grid-cols-2">
                            <div class="grid grid-cols-1">
                                <div class="inline-block w-full mt-2">
                                    <label class=""
                                        >Size
                                        <p class="inline text-red-600 text-lg">
                                            *
                                        </p></label
                                    >
                                </div>
                                <div class="inline-block w-max mx-auto my-2">
                                    <div class="flex">
                                        <div class="mx-2">
                                            <input
                                                type="text"
                                                class="text-center w-20 inline-block mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                v-model="billboard.bboard_size1"
                                            />
                                            <p
                                                class="inline-block align-top text-xl ml-1 font-bold"
                                            >
                                                "
                                            </p>
                                        </div>
                                        <div class="pt-2 mx-2 py-2">
                                            <p
                                                class="inline-block uppercase text-sm align-bottom"
                                            >
                                                X
                                            </p>
                                        </div>
                                        <div class="mx-2">
                                            <input
                                                type="text"
                                                class="text-center w-20 inline-block mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                                v-model="billboard.bboard_size2"
                                            />
                                            <p
                                                class="inline-block align-top text-xl ml-1 font-bold"
                                            >
                                                "
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="w-full mt-2">
                                    <label class="mx-2">Current</label>
                                </div>
                                <div class="w-full">
                                    <input
                                        disabled
                                        type="text"
                                        class="bg-slate-300 text-slate-600 text-center w-36 inline-block items-left mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="billboard.bboard_size"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="inline-flex mt-2 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Update
                    </button>
                </form>
            </div>
            <div class="text-center">
                <h3
                    class="items-center text-center text-white font-extrabold font-mono text-4xl uppercase bg-blue-900 px-10 py-2 rounded-md"
                >
                    Create Tenure
                </h3>
                <form
                    @submit.prevent="createTenure"
                    class="inline-block align-middle"
                >
                    <div class="grid grid-cols-1 items-center text-left">
                        <div
                            class="grid grid-cols-5 w-auto items-center py-2 px-2"
                        >
                            <div class="inline-block">
                                <label class=""
                                    >CS
                                    <p class="inline text-red-600 text-lg">
                                        *
                                    </p></label
                                >
                            </div>
                            <div class="flex col-span-4">
                                <select
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="form2.user_id"
                                    @change="getUsers"
                                >
                                    <option disabled value="">
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

                        <div class="grid grid-cols-5 items-center py-2 px-2">
                            <div class="inline-block">
                                <label class=""
                                    >Contact
                                    <p class="inline text-red-600 text-lg">
                                        *
                                    </p></label
                                >
                            </div>

                            <div class="form-group col-span-4">
                                <v-select
                                    label="name"
                                    :options="contacts"
                                    class="form_company"
                                    :reduce="(name) => name.id"
                                    v-model="form2.contact_id"
                                    placeholder="Search & select company"
                                    @search="findContacts"
                                    :filterable="false"
                                ></v-select>
                            </div>
                        </div>
                        <div
                            class="grid grid-cols-5 w-auto items-center text-left py-2 px-2"
                        >
                            <label class="mr-2"
                                >Start Date
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                            <div class="w-full col-span-4">
                                <VueDatePicker
                                    v-model="form2.tenure_startdate"
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                />
                            </div>
                        </div>
                        <div
                            class="grid grid-cols-5 w-auto items-center text-left py-2 px-2"
                        >
                            <label class="mr-2"
                                >End Date
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                            <div class="w-full col-span-4">
                                <VueDatePicker
                                    v-model="form2.tenure_enddate"
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                />
                            </div>
                        </div>
                    </div>
                    <button
                        type="submit"
                        class="inline-flex mt-2 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Create
                    </button>
                </form>
            </div>
        </div>

        <div class="max-h-10 my-2">
            <GoBack class="" />
        </div>
        <h5
            class="items-center text-center text-white font-extrabold font-mono text-sm uppercase bg-blue-900 px-5 py-2 rounded-md"
        >
            <!-- Tenure (2022) change to selected year -->
            Tenure
        </h5>
        <span v-if="billboard.tenure[0]">
            <div class="m-4" v-for="(tenure_info, index) in billboard.tenure">
                <tr class="grid grid-cols-4 border-gray-200 py-2 border-2">
                    <div class="grid grid-cols-2">
                        <div class="text-center">
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
                                Company:
                            </td>
                        </div>
                        <div>
                            <td
                                class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                            >
                                {{ tenure_info.contact.name }}
                            </td>
                        </div>
                    </div>

                    <div class="grid grid-cols-2">
                        <td
                            class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap text-center"
                        >
                            CS:
                        </td>
                        <td
                            class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                        >
                            {{ tenure_info.user.name }}
                        </td>
                    </div>

                    <div class="grid grid-cols-2">
                        <td
                            class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap text-center"
                        >
                            Start Date:
                        </td>
                        <td
                            class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                        >
                            {{ showToday(tenure_info.tenure_startdate) }}
                        </td>
                    </div>

                    <div class="grid grid-cols-2">
                        <td
                            class="px-1 py-1 text-s leading-5 text-gray-900 whitespace-no-wrap text-center"
                        >
                            End Date:
                        </td>
                        <td
                            class="px-1 py-1 text-s leading-5 font-bold text-gray-900 whitespace-no-wrap"
                        >
                            {{ showToday(tenure_info.tenure_enddate) }}
                        </td>

                        <!-- <router-link
                            :to="{
                                name: 'forecast_edit',
                                params: { id: forecast_info.id },
                            }"
                            class="mr-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <PencilSquareIcon class="h-3 w-3"
                        /></router-link> -->
                    </div>
                </tr>
                <div class="text-right">
                    <button
                        class="inline-block px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        @click="deleteTenure(tenure_info.id)"
                    >
                        <TrashIcon class="h-3 w-3" />
                    </button>
                </div>
            </div>
        </span>

        <span v-else>
            <div
                class="uppercase text-center font-extrabold text-5xl bg-slate-400 rounded-md py-3 px-3"
            >
                <h1><strong>No Tenure</strong></h1>
            </div>
        </span>
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
            contacts: [],
            users: [],
            billboard: {
                site_id: "",
                site_id1: "",
                site_id2: "",
                bboard_location: "",
                bboard_size: "",
                tenure: [],
                bboard_size1: "",
                bboard_size2: "",
            },
            form2: {
                user_id: "",
                contact_id: "",
                tenure_startdate: "",
                tenure_enddate: "",
            },
            errors: "",
        };
    },
    mounted() {
        this.getBillboard();
        this.getUsers();
        // this.getContacts();
    },
    methods: {
        findContacts(search, loading) {
            if (search.length) {
                loading(true);
                this.searchContact(loading, search, this);
            }
        },

        searchContact: _.debounce((loading, search, vm) => {
            axios.get("/api/contacts/list?" + "q=" + search).then((res) => {
                vm.contacts = res.data.data;
                loading(false);
            });
        }, 350),

        async getBillboard() {
            await axios
                .get("/api/billboards/info/" + this.$route.params.id)
                .then((res) => {
                    this.billboard = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async updateBillBoard() {
            try {
                await axios.put(
                    "/api/billboards/update/" + this.$route.params.id,
                    {
                        site_id1: this.billboard.site_id1,
                        site_id2: this.billboard.site_id2,
                        site_id: this.billboard.site_id,
                        bboard_location: this.billboard.bboard_location,
                        bboard_size: this.billboard.bboard_size,
                        bboard_size1: this.billboard.bboard_size1,
                        bboard_size2: this.billboard.bboard_size2,
                    }
                );

                this.getBillboard();

                alert("Billboard updated");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async createTenure() {
            try {
                await axios.post("/api/billboards/tenure/store", {
                    bboard_id: this.$route.params.id,
                    user_id: this.form2.user_id,
                    contact_id: this.form2.contact_id,
                    // tenure_startdate: this.moment(
                    //     this.form2.tenure_startdate
                    // ).format("YYYY-MM-DD"),
                    tenure_startdate: this.form2.tenure_startdate,
                    // tenure_enddate: this.moment(
                    //     this.form2.tenure_enddate
                    // ).format("YYYY-MM-DD"),
                    tenure_enddate: this.form2.tenure_enddate,
                });
                this.form2.user_id = "";
                this.form2.contact_id = "";
                this.form2.tenure_startdate = "";
                this.form2.tenure_enddate = "";

                this.getBillboard();
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

        async getContacts() {
            await axios
                .get("/api/contacts/list")
                .then((res) => {
                    this.contacts = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        deleteTenure(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/billboards/tenure/delete/" + id);
            alert("Billboard tenure deleted.");
            this.getBillboard();
        },

        showToday(date) {
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("DD-MM-YY");
            return day;
        },
    },
};
</script>

<style>
.form_company {
    background-color: rgb(255, 255, 255);
    border-radius: 0.375rem;
    text-align: left;
}
</style>
