<template>
    <div class="container w-max align-center mx-auto h-max px-3 py-3">
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
        <div class="flex w-full justify-center items-center row">
            <div class="col-lg-20">
                <form
                    @submit.prevent="createContact"
                    class="rounded px-8 pt-1 pb-8 mb-4"
                >
                    <div class="">
                        <GoBack />
                    </div>

                    <div
                        class="text-center text-white bg-slate-600 px-2 py-1 rounded-md"
                    >
                        <h1
                            class="px-8 bg-black-50 uppercase w-max font-mono font-extrabold"
                        >
                            Create Contact
                        </h1>
                    </div>

                    <div class="form-group">
                        <label
                            >Status
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.status_id"
                            @change="getStatus"
                        >
                            <option disabled value="">Please select one</option>
                            <option
                                v-for="status in statuses"
                                :key="status.id"
                                :value="status.id"
                            >
                                {{ status.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label
                            >Type
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.type_id"
                            @change="getType"
                        >
                            <option disabled value="">Please select one</option>
                            <option
                                v-for="type in types"
                                :key="type.id"
                                :value="type.id"
                            >
                                {{ type.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label
                            >Industry
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.industry_id"
                            @change="getIndustry"
                        >
                            <option disabled value="">Please select one</option>
                            <option
                                v-for="industry in industries"
                                :key="industry.id"
                                :value="industry.id"
                            >
                                {{ industry.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label
                            >Category
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.category_id"
                            @change="getCategory"
                        >
                            <option disabled value="">Please select one</option>
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label
                            >Company Name
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <div class="h-max-10">
                            <select
                                class="bg-slate-200 border-1 overflow-y block mt-1 w-max rounded-md border-gray-400 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                @change="getContacts"
                            >
                                <option value="">
                                    Check company for duplicate
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
                        <input
                            maxlength="100"
                            type="text"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.name"
                        />
                    </div>

                    <div class="form-group mt-2">
                        <label>Address </label>
                        <input
                            maxlength="65000"
                            type="text"
                            class="block mt-1 w-96 h-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.address"
                        />
                    </div>
                    <div class="form-group">
                        <label>Remark</label>
                        <input
                            maxlength="65000"
                            type="text"
                            class="block mt-1 w-96 h-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
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
                status_id: "",
                type_id: "",
                industry_id: "",
                company_name: "",
                category_id: "",
                address: "",
                remark: "",
            },
            user_id: "",
            types: [],
            categories: [],
            statuses: [],
            industries: [],
            errors: "",
            contact: "",
            contacts: [],
        };
    },

    created() {
        this.getStatus();
        this.getCategory();
        this.getType();
        this.getIndustry();
        this.getContacts();
    },

    methods: {
        async getIndustry() {
            await axios
                .get("/api/contacts/industry/index")
                .then((res) => {
                    this.industries = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getStatus() {
            await axios
                .get("/api/contacts/status/index")
                .then((res) => {
                    this.statuses = res.data.data;
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

        async getType() {
            await axios
                .get("/api/contacts/type/index")
                .then((res) => {
                    this.types = res.data.data;
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

        async createContact() {
            try {
                await axios
                    .post("/api/contacts/store", {
                        type_id: this.form.type_id,
                        industry_id: this.form.industry_id,
                        status_id: this.form.status_id,
                        name: this.form.name,
                        category_id: this.form.category_id,
                        address: this.form.address
                            ? this.form.address
                            : "No address saved",
                        remark: this.form.remark
                            ? this.form.remark
                            : "No remark",
                        user_id: 2, //later add current user
                    })
                    .then((res) => {
                        const contact = res.data.data;
                        if (window.confirm("Proceed to add incharge?")) {
                            this.$router.push({
                                name: "incharge_create",
                                params: { id: contact.id },
                            });
                        } else {
                            this.$router.push({ name: "contact_index" });
                        }
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
