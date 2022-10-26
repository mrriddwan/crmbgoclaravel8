<template>
    <div class="container w-max align-center">
        <div class="max-h-10 my-2">
            <GoBack class="" />
        </div>
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
            Create Tempboard
        </h1>

        <div class="text-center">
            <form
                @submit.prevent="updateTempboard"
                class="inline-block align-middle"
            >
                <div class="grid grid-cols-1 items-center text-center">
                    <div class="grid grid-cols-1">
                        <div>
                            <label class="mx-2"
                                >Entry Date
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                        </div>
                        <div>
                            <VueDatePicker
                                v-model="tempboard.tpboard_entrydate"
                                showNowButton
                                nowButtonLabel="Today"
                                :enableTimePicker="false"
                                class="text-center w-full inline-block items-left mt-1 mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            />
                        </div>
                    </div>
                    <div class="inline-block w-full mt-2">
                        <label class=""
                            >CS
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                    </div>
                    <div class="inline-block w-full">
                        <div class="">
                            <select
                                class="text-center w-full rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="tempboard.user_id"
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

                    <div class="inline-block w-full mt-2">
                        <label class=""
                            >Contact
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                    </div>
                    <div class="inline-block w-full">
                        <div class="">
                            <select
                                class="text-center overflow-y block mt-1 w-full rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="tempboard.contact_id"
                                @change="getContacts"
                            >
                                <option disabled value="">
                                    Please select one
                                </option>
                                <option
                                    class=""
                                    v-for="contact in contacts"
                                    :key="contact.id"
                                    :value="contact.id"
                                >
                                    {{ contact.name }}
                                </option>
                            </select>
                        </div>
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
                                <div class="grid grid-cols-3">
                                    <div class="mx-2">
                                        <input
                                            type="text"
                                            class="text-center w-20 inline-block mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            v-model="tempboard.tpboard_size1"
                                        />
                                        <p
                                            class="inline-block align-top text-xl ml-1 font-bold"
                                        >
                                            "
                                        </p>
                                    </div>
                                    <div class="pt-2">
                                        <p class="uppercase text-xl">X</p>
                                    </div>
                                    <div class="mx-2">
                                        <input
                                            type="text"
                                            class="text-center w-20 inline-block mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            v-model="tempboard.tpboard_size2"
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
                                <label class="mx-2">Current Size</label>
                            </div>
                            <div class="w-full">
                                <input
                                    disabled
                                    type="text"
                                    class="bg-slate-300 text-slate-600 text-center w-36 inline-block items-left mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="tempboard.tpboard_size"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="w-full mt-2">
                        <label class="mx-2"
                            >Location
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                    </div>
                    <div class="w-full">
                        <input
                            type="text"
                            class="text-center w-full inline-block items-left mt-1 mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="tempboard.tpboard_location"
                        />
                    </div>
                    <div class="w-full mt-2">
                        <label class="mx-2"
                            >Unit
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                    </div>
                    <div class="w-full">
                        <input
                            type="text"
                            class="text-center w-full inline-block items-left mt-1 mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="tempboard.tpboard_unit"
                        />
                    </div>

                    <div class="grid grid-cols-2 mt-2 gap-4">
                        <div class="grid grid-cols-1">
                            <div>
                                <label class="mx-2"
                                    >Start Date
                                    <p class="inline text-red-600 text-lg">
                                        *
                                    </p></label
                                >
                            </div>
                            <div>
                                <VueDatePicker
                                    v-model="tempboard.tpboard_startdate"
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                    class="text-center w-full inline-block items-left mt-1 mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-1">
                            <div>
                                <label class="mx-2"
                                    >End Date
                                    <p class="inline text-red-600 text-lg">
                                        *
                                    </p></label
                                >
                            </div>
                            <div>
                                <VueDatePicker
                                    v-model="tempboard.tpboard_enddate"
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                    class="text-center w-full inline-block items-left mt-1 mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="w-full mt-2">
                        <label class="mx-2"
                            >Collection
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                    </div>
                    <div class="w-full">
                        <input
                            type="text"
                            class="text-center w-full inline-block items-left mt-1 mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="tempboard.tpboard_collection"
                        />
                    </div>
                    <div class="w-full mt-2">
                        <label class="mx-2"
                            >Material
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                    </div>
                    <div class="w-full">
                        <input
                            type="text"
                            class="text-center w-full inline-block items-left mt-1 mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="tempboard.tpboard_material"
                        />
                    </div>
                    <div class="w-full mt-2">
                        <label class="mx-2"
                            >Printing
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                    </div>
                    <div class="w-full">
                        <input
                            type="text"
                            class="text-center w-full inline-block items-left mt-1 mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="tempboard.tpboard_printing"
                        />
                    </div>
                    <div class="w-full mt-2">
                        <label class="mx-2"
                            >Installation
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                    </div>
                    <div class="w-full">
                        <input
                            type="text"
                            class="text-center w-full inline-block items-left mt-1 mx-2 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="tempboard.tpboard_installation"
                        />
                    </div>
                    <div class="w-full mt-2">
                        <label class="mx-2">Remark</label>
                    </div>
                    <div class="w-full">
                        <textarea
                            type="text"
                            class="text-center inline-block items-left mt-1 mx-2 w-96 h-40 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="tempboard.tpboard_remark"
                        />
                    </div>
                </div>
                <button
                    type="submit"
                    class="inline-flex mt-2 px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    Update
                </button>
            </form>
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
            contact_infos: [],
            tempboard: {
                tpboard_entrydate: "",
                contact_id: "",
                user_id: "",
                tpboard_startdate: "",
                tpboard_enddate: "",
                tpboard_size: "",
                tpboard_size1: "",
                tpboard_size2: "",
                tpboard_location: "",
                tpboard_unit: "",
                tpboard_collection: "",
                tpboard_material: "",
                tpboard_printing: "",
                tpboard_installation: "",
                tpboard_remark: "",
            },
            form: {
                tpboard_size1: "",
                tpboard_size2: "",
            },
            errors: "",
            contacts: [],
            users: [],
        };
    },
    mounted() {
        this.getUsers();
        this.getContacts();
        this.showTempBoard();
    },
    methods: {
        async showTempBoard() {
            await axios
                .get("/api/tempboards/info/" + this.$route.params.id)
                .then((res) => {
                    this.tempboard = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async updateTempboard() {
            try {
                await axios.put("/api/tempboards/update/"+ this.$route.params.id, {
                    tpboard_entrydate: this.moment(
                        this.tempboard.tpboard_entrydate
                    ).format("YYYY-MM-DD"),
                    contact_id: this.tempboard.contact_id,
                    user_id: this.tempboard.user_id,
                    tpboard_startdate: this.moment(
                        this.tempboard.tpboard_startdate
                    ).format("YYYY-MM-DD"),
                    tpboard_enddate: this.moment(
                        this.tempboard.tpboard_enddate
                    ).format("YYYY-MM-DD"),
                    tpboard_size: this.tempboard.tpboard_size,
                    tpboard_size1: this.tempboard.tpboard_size1,
                    tpboard_size2: this.tempboard.tpboard_size2,
                    tpboard_location: this.tempboard.tpboard_location,
                    tpboard_unit: this.tempboard.tpboard_unit,
                    tpboard_collection: this.tempboard.tpboard_collection,
                    tpboard_material: this.tempboard.tpboard_material,
                    tpboard_printing: this.tempboard.tpboard_printing,
                    tpboard_installation: this.tempboard.tpboard_installation,
                    tpboard_remark: this.tempboard.tpboard_remark
                        ? this.tempboard.tpboard_remark
                        : "No remark",
                });

                this.$router.push({
                    name: "tempboard_index",
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
    },
};
</script>
