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
                <form
                    @submit.prevent="updateTrackingGeneral"
                    class="rounded px-8 pt-1 pb-8 mb-4"
                >
                    <div
                        class="text-center text-white bg-blue-900 px-2 py-1 rounded-md"
                    >
                        <h1
                            class="px-8 bg-black-50 uppercase w-max font-mono font-extrabold"
                        >
                            Edit Tracking (General) - Master Record
                        </h1>
                    </div>

                    <div class="form-group grid grid-cols-2">
                        <label class="font-bold"
                            >User
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="tracking.user_id"
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
                            v-model="tracking.company_id"
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

                    <div class="form-group grid grid-cols-2">
                        <label class="font-bold"
                            >Product
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="tracking.contact_category_id"
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

                    <div class="form-group my-2">
                        <div></div>
                        <div></div>
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
                            v-model="tracking.category_description"
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
                                    v-model="tracking.general_type"
                                    placeholder="eg: 30' x 40'"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2 grid grid-cols-2">
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

                        <div
                            class="flex"
                            v-if="
                                can('view tracking general amount') ||
                                is('admin | super-admin')
                            "
                        >
                            <span
                                class="bg-slate-600 px-2 py-1 inline-block rounded-md text-white"
                                >RM</span
                            >
                            <input
                                maxlength="800"
                                type="number"
                                class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                v-model="tracking.general_amount"
                                placeholder="eg: 10 000"
                            />
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
                                v-model="tracking.art_format"
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
                                disabled
                                maxlength="800"
                                type="number"
                                class="bg-slate-500 text-center form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                v-model="tracking.art_frequency"
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
                                v-model="tracking.general_reach"
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
                                v-model="tracking.general_tenure"
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
                                    v-model="tracking.general_startdate"
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
                                    v-model="tracking.general_enddate"
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
                            v-model="tracking.general_remark"
                            placeholder="eg: Artwork by Bluedale"
                        />
                    </div>

                    <button
                        type="submit"
                        class="inline-flex mt-2 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Update
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
            tracking: {
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
                progress: "",
            },

            moment: moment,
            users: [],
            categories: [],
            contacts: [],
            tenure_length: "day",
            errors: "",
        };
    },

    mounted() {
        this.getTracking();
        this.getUsers();
        this.getCategory();
        this.getContacts();
    },

    created() {},

    methods: {
        async getTracking() {
            await axios
                .get("/api/trackings/general/show/" + this.$route.params.id)
                .then((res) => {
                    this.tracking = res.data.data;
                    // this.tracking.general_tenure = (
                    //     this.tracking.general_tenure / 30
                    // ).toFixed(1);
                })
                .catch((error) => {
                    console.log(error);
                });
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

        async updateTrackingGeneral() {
            let tenure = Number;

            if (this.tenure_length === "month") {
                tenure = this.tracking.general_tenure * 30;
            } else if (this.tenure_length === "year") {
                tenure = this.tracking.general_tenure * 365;
            } else {
                tenure = this.tracking.general_tenure;
            }

            try {
                await axios
                    .put(
                        "/api/trackings/general/update/" +
                            this.$route.params.id,
                        {
                            progress: this.tracking.progress,
                            user_id: this.tracking.user_id,
                            company_id: this.tracking.company_id,
                            contact_category_id:
                                this.tracking.contact_category_id,
                            category_description:
                                this.tracking.category_description,
                            general_type: this.tracking.general_type,
                            general_amount: this.tracking.general_amount,
                            art_format: this.tracking.art_format,
                            art_frequency: this.tracking.art_frequency,
                            general_reach: this.tracking.general_reach,
                            general_tenure: tenure,
                            general_startdate: this.moment(
                                this.tracking.general_startdate
                            ).format("YYYY-MM-DD"),
                            general_enddate: this.moment(
                                this.tracking.general_enddate
                            ).format("YYYY-MM-DD"),
                            general_remark: this.tracking.general_remark
                                ? this.tracking.general_remark
                                : "No remark",
                        }
                    )
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
        },
    },

    components: { GoBack },
};
</script>
