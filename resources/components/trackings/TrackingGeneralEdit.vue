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
                    @submit.prevent="createTrackingGeneral"
                    class="rounded px-8 pt-1 pb-8 mb-4"
                >
                    <div
                        class="text-center text-white bg-slate-600 px-2 py-1 rounded-md"
                    >
                        <h1
                            class="px-8 bg-black-50 uppercase w-max font-mono font-extrabold"
                        >
                            Create Tracking - General
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
                            <option disabled value="">Select user</option>
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
                            v-model="form.user_id"
                            @change="getContacts"
                        >
                            <option disabled value="">Select company</option>
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
                            v-model="form.category_id"
                            @change="getCategory"
                        >
                            <option disabled value="">Select product</option>
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
                            v-model="form.product_description"
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
                                    v-model="form.type"
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
                                    type="text"
                                    class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="form.amount"
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
                                v-model="form.artwork_format"
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
                                type="text"
                                class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                v-model="form.artwork_freq"
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
                                type="text"
                                class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                v-model="form.reach"
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
                        <div>
                            <input
                                maxlength="800"
                                type="text"
                                class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                v-model="form.tenure"
                            />
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
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
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
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label class="font-bold">Remark</label>
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
                            v-model="form.remark"
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

export default {
    data() {
        return {
            form: {
                user_id: "",
                company_id: "",
                category_id: "",
                product_description: "",
                type: "",
                amount: "",
                artwork_format: "",
                artwork_freq: "",
                reach: "",
                tenure: "",
                start_date: "",
                end_date: "",
                remark: "",
            },

            users: [],
            categories: [],
            contacts: [],

            errors: "",
        };
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
            try {
                await axios
                    .post("/api/tracking/general/store", {
                        user_id: this.form.user_id,
                        company_id: this.form.company_id,
                        category_id: this.form.category_id,
                        product_description: this.form.product_description,
                        type: this.form.type,
                        amount: this.form.amount,
                        artwork_format: this.form.artwork_format,
                        artwork_freq: this.form.artwork_freq,
                        reach: this.form.reach,
                        tenure: this.form.tenure,
                        start_date: this.form.start_date,
                        end_date: this.form.end_date,
                        remark: this.form.remark
                            ? this.form.remark
                            : "No remark",
                    })
                    .then((res) => {
                        this.$router.push({ name: "contact_index" });
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
