<template>
    <div class="w-full min-h-screen">
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
                <form
                    @submit.prevent="createTrackingGeneral"
                    class="rounded px-8 pt-1 pb-8 mb-4"
                >
                    <div
                        class="text-center text-white bg-blue-900 px-2 py-1 rounded-md"
                    >
                        <h1
                            class="px-8 bg-black-50 uppercase w-max font-mono font-extrabold"
                        >
                            Create Tracking (General) - Master Record
                        </h1>
                    </div>

                    <div class="form-group grid grid-cols-2">
                        <label class="font-bold"
                            >User
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
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
                    <div class="form-group grid grid-cols-2 my-2">
                        <label class="font-bold"
                            >Company
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <div class="">
                            <v-select
                                label="name"
                                :options="contacts"
                                class="form_company"
                                :reduce="(name) => name.id"
                                v-model="form.company_id"
                                placeholder="Search & select company"
                                @search="findContacts"
                                :filterable="false"
                            ></v-select>
                        </div>
                    </div>

                    <div class="form-group grid grid-cols-2">
                        <label class="font-bold"
                            >Product
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.contact_category_id"
                            @change="getCategory"
                        >
                            <option value="">Select product</option>
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group grid grid-cols-2">
                        <label class="font-bold"
                            >BGOC
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.division_id"
                            @change="getDivisions"
                        >
                            <option value="">Select division</option>
                            <option
                                v-for="division in divisions"
                                :key="division.id"
                                :value="division.id"
                            >
                                {{ division.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group my-2">
                        <label class="font-bold">Product Description</label>
                        <p class="inline text-red-600 text-lg">*</p>
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
                            v-model="form.category_description"
                            placeholder="eg: Persiaran Sultan"
                        />
                    </div>

                    <div class="mt-2 grid grid-cols-2">
                        <div>
                            <div>
                                <label class="font-bold">Type</label>
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

                    <div class="form-group mt-2 grid grid-cols-2">
                        <div>
                            <div>
                                <label class="font-bold">Amount</label>
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
                            <div class="flex">
                                <span
                                    class="bg-slate-600 px-2 py-1 inline-block rounded-md text-white"
                                    >RM</span
                                >
                                <input
                                    maxlength="800"
                                    type="number"
                                    class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="form.general_amount"
                                    placeholder="eg: 10 000"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2 grid grid-cols-2">
                        <div>
                            <label class="font-bold">Artwork Format</label>
                            <p class="inline text-red-600 text-lg">*</p>
                            <!-- <div
                            v-if="form.remark.length >= 800"
                            class="text-red-600 inline text-xs uppercase"
                        >
                            Exceeded limit
                        </div> -->
                        </div>
                        <div>
                            <input
                                maxlength="800"
                                type="text"
                                class="form-control block w-96 h-20 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                v-model="form.art_format"
                                placeholder="eg: Carousel, Video"
                            />
                        </div>
                    </div>

                    <div class="form-group mt-2 grid grid-cols-2">
                        <div>
                            <label class="font-bold">Artwork Frequency</label>
                            <p class="inline text-red-600 text-lg">*</p>
                            <!-- <div
                            v-if="form.remark.length >= 800"
                            class="text-red-600 inline text-xs uppercase"
                        >
                            Exceeded limit
                        </div> -->
                        </div>
                        <div>
                            <input
                                maxlength="800"
                                type="number"
                                class="text-center form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                v-model="form.art_frequency"
                                placeholder="eg: 6"
                            />
                        </div>
                    </div>

                    <div class="form-group mt-2 grid grid-cols-2">
                        <div>
                            <label class="font-bold">REACH</label>
                            <p class="inline text-red-600 text-lg">*</p>
                            <!-- <div
                            v-if="form.remark.length >= 800"
                            class="text-red-600 inline text-xs uppercase"
                        >
                            Exceeded limit
                        </div> -->
                        </div>
                        <div>
                            <input
                                maxlength="800"
                                type="number"
                                class="text-center form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                v-model="form.general_reach"
                                placeholder="eg: 300 000"
                            />
                        </div>
                    </div>

                    <div class="form-group mt-2 grid grid-cols-2">
                        <div>
                            <label class="font-bold">Tenure</label>
                            <p class="inline text-red-600 text-lg">*</p>
                            <!-- <div
                            v-if="form.remark.length >= 800"
                            class="text-red-600 inline text-xs uppercase"
                        >
                            Exceeded limit
                        </div> -->
                        </div>
                        <div class="flex">
                            <input
                                maxlength="800"
                                type="number"
                                class="text-center form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                v-model="form.general_tenure"
                                placeholder="eg: 5"
                            />
                            <select
                                v-model="tenure_length"
                                class="w-max text-center overflow-y block mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                                <option value="day">Day(s)</option>
                                <option value="month">Month(s)</option>
                                <option value="year">Year(s)</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 items-center mt-2">
                        <div>
                            <label class="font-bold"
                                >Start Date
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                        </div>
                        <div>
                            <div class="w-max">
                                <VueDatePicker
                                    v-model="form.general_startdate"
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                    placeholder="Select date"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 items-center mt-2">
                        <div>
                            <label class="font-bold"
                                >End Date
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                        </div>
                        <div>
                            <div class="w-max">
                                <VueDatePicker
                                    v-model="form.general_enddate"
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                    placeholder="Select date"
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
                            class="form-control block w-96 h-40 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            v-model="form.general_remark"
                            placeholder="eg: Artwork by Bluedale"
                        />
                    </div>

                    <button
                        type="submit"
                        class="inline-flex mt-2 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Create
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import GoBack from "../utils/GoBack.vue";
import axios from "axios";
import moment from "moment";

export default {
    data() {
        return {
            form: {
                user_id: "",
                company_id: "",
                contact_category_id: "",
                category_description: "",
                division_id: "",
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
            divisions: [],
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
        // this.getContacts();
        this.getDivisions();
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

        async getDivisions() {
            await axios
                .get("/api/trackings/division/index")
                .then((res) => {
                    this.divisions = res.data.data;
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
                            division_id: this.form.division_id,
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
    },

    components: { GoBack },
};
</script>

<style>
.form_company {
    background-color: rgb(255, 255, 255);
    border-radius: 0.375rem;
    font-size: medium;
}
</style>
