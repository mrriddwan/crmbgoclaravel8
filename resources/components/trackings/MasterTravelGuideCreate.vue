<template>
    <div class="container w-max mx-auto h-max px-3 py-3">
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
        <div class="">
            <GoBack />
        </div>
        <div class="flex w-full row">
            <div class="col-lg-20">
                <!-- @submit.prevent="createTrackingGeneral" -->
                <form class="rounded px-8 pt-1 pb-8 mb-4">
                    <div
                        class="text-center text-white bg-slate-600 px-2 py-1 rounded-md"
                    >
                        <h1
                            class="px-8 bg-black-50 uppercase w-max font-mono font-extrabold"
                        >
                            Create Tracking (Travel Guide) - Master Record
                        </h1>
                    </div>

                    <div class="form-group grid grid-cols-2">
                        <label class="font-bold"
                            >User
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.user_id"
                            @change="getUsers"
                        >
                            <option value="">Select user</option>
                            <option
                                v-for="user in users"
                                :key="user.id"
                                :value="user.id"
                            >
                                {{ user.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group grid grid-cols-2">
                        <label class="font-bold"
                            >Company
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="text-center overflow-y block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.company_id"
                            @change="getContacts"
                        >
                            <option value="">Select company</option>
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

                    <div class="mt-2 grid grid-cols-2">
                        <div>
                            <div>
                                <label class="font-bold">Edition</label>
                                <p class="inline text-red-600 text-lg">*</p>
                                <!-- <div
                            v-if="form.remark.length >= 800"
                            class="text-red-600 inline text-xs uppercase"
                        >
                            Exceeded limit
                        </div> -->
                            </div>
                        </div>
                        <div>
                            <div class="form-group flex">
                                <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="form.general_type"
                                    placeholder="eg: 30' x 40'"
                                />
                                <p class="mx-5">-</p>
                                <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="form.general_type"
                                    placeholder="eg: 30' x 40'"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="mt-2 grid grid-cols-2">
                        <div>
                            <div>
                                <label class="font-bold">Size</label>
                                <p class="inline text-red-600 text-lg">*</p>
                                <!-- <div
                            v-if="form.remark.length >= 800"
                            class="text-red-600 inline text-xs uppercase"
                        >
                            Exceeded limit
                        </div> -->
                            </div>
                        </div>
                        <div>
                            <div class="form-group">
                                <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="form.general_type"
                                    placeholder="eg: 30' x 40'"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label class="font-bold"
                            >Remark
                            <p class="inline text-red-600 text-lg">*</p></label
                        >

                        <!-- <div
                            v-if="form.remark.length >= 800"
                            class="text-red-600 inline text-xs uppercase"
                        >
                            Exceeded limit
                        </div> -->
                        <input
                            maxlength="800"
                            type="text"
                            class="form-control block w-96 h-20 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            v-model="form.general_remark"
                            placeholder="eg: Artwork by Bluedale"
                        />
                    </div>

                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                        id="form-wrapper"
                    >
                        <div class="form-assignment">
                            <label class="font-bold">Assignment</label>
                            <div class="grid grid-cols-7">
                                <div class="grid grid-cols-1 my-2 col-span-3">
                                    <label class="font-bold">Package</label>
                                    <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                    <input
                                        maxlength="800"
                                        type="text"
                                        class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                        v-model="form.general_remark"
                                        placeholder="eg: Artwork by Bluedale"
                                    />
                                </div>
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold">Date</label>
                                    <div class="w-full">
                                        <VueDatePicker
                                            showNowButton
                                            nowButtonLabel="Today"
                                            :enableTimePicker="false"
                                            placeholder="Select date"
                                        />
                                    </div>
                                </div>
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold">User</label>
                                    <select
                                        class="block w-full text-center h-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        @change="getUsers"
                                    >
                                        <option value="">Select user</option>
                                        <option
                                            v-for="user in users"
                                            :key="user.id"
                                            :value="user.id"
                                        >
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-1 my-2 col-span-2">
                                    <label class="font-bold">Note</label>
                                    <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                    <textarea
                                        id="message"
                                        maxlength="800"
                                        rows="1"
                                        placeholder="eg: Artwork by Bluedale"
                                        class="block p-2.5 w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                            </div>
                            <button
                                @click="duplicateForm"
                                class="text-center text-sm border-2 border-slate-500"
                            >
                                + task
                            </button>
                        </div>
                    </div>

                    <!-- <button
                        type="submit"
                        class="inline-flex mt-2 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Create
                    </button> -->
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import GoBack from "../utils/GoBack.vue";
import axios from "axios";
import moment from "moment";

const div = document.getElementById("form-wrapper");

export default {
    data() {
        return {
            form: {
                user_id: "",
                company_id: "",
                contact_category_id: "",
                category_description: "",
                general_type: "",
                general_amount: "",
                art_format: "",
                art_frequency: "",
                general_reach: "",
                general_tenure: "",
                general_startdate: "",
                general_enddate: "",
                general_remark: "",
            },

            moment: moment,
            users: [],
            categories: [],
            contacts: [],
            tenure_length: "month",
            errors: "",
        };
    },

    mounted() {
        this.form.user_id = document
            .querySelector('meta[name="user-id"]')
            .getAttribute("content");
    },

    created() {
        this.getUsers();
        this.getCategory();
        this.getContacts();
    },

    methods: {
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

        async getCategory() {
            await axios
                .get("/api/contacts/category/index")
                .then((res) => {
                    this.categories = res.data.data;
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

        async createTrackingGeneral() {
            let tenure = Number;

            if (this.tenure_length === "month") {
                tenure = this.form.general_tenure * 30;
            } else if (this.tenure_length === "year") {
                tenure = this.form.general_tenure * 365;
            } else {
                tenure = this.form.general_tenure;
            }
            if (window.confirm("Confirm create tracking ?")) {
                try {
                    await axios
                        .post("/api/trackings/general/store", {
                            user_id: this.form.user_id,
                            company_id: this.form.company_id,
                            contact_category_id: this.form.contact_category_id,
                            category_description:
                                this.form.category_description,
                            general_type: this.form.general_type,
                            general_amount: this.form.general_amount,
                            art_format: this.form.art_format,
                            art_frequency: this.form.art_frequency,
                            general_reach: this.form.general_reach,
                            general_tenure: tenure,
                            general_startdate: this.moment(
                                this.form.general_startdate
                            ).format("YYYY-MM-DD"),
                            general_enddate: this.moment(
                                this.form.general_enddate
                            ).format("YYYY-MM-DD"),
                            general_remark: this.form.general_remark
                                ? this.form.general_remark
                                : "No remark",
                        })
                        .then((res) => {
                            this.$router.push({ name: "tracking_general" });
                        });
                } catch (e) {
                    {
                        if (e.response.status === 422) {
                            this.errors = e.response.data.errors;
                        } else {
                            return "no error response";
                        }
                    }
                }
            }
        },

        duplicateForm() {

            let forms = div.getElementsByClassName("form-assignment");
            let firstForm = forms[0];
            let formClone = firstForm.cloneNode(true);
            div.appendChild(formClone);
        },
    },

    components: { GoBack },
};
</script>
