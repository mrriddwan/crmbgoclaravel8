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
        <div class="flex w-full row">
            <div class="col-lg-20">
                <form
                    @submit.prevent="createContact"
                    class="rounded px-8 pt-1 pb-8 mb-4"
                >
                    <div class="">
                        <GoBack />
                    </div>

                    <div
                        class="text-center text-white bg-blue-900 px-2 py-1 rounded-md"
                    >
                        <h1
                            class="px-8 bg-black-50 uppercase w-max font-mono font-extrabold"
                        >
                            Create Contact
                        </h1>
                    </div>

                    <div class="form-group">
                        <label class="font-bold"
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
                        <label class="font-bold"
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
                        <label class="font-bold"
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
                        <label class="font-bold"
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
                        <div class="flex mt-2 mb-2">
                            <label class="font-bold"
                                >Company Name
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                            <div class="ml-3 mt-1">
                                <div
                                    role="status"
                                    class=""
                                    v-if="contact_check"
                                >
                                    <svg
                                        aria-hidden="true"
                                        class="w-4 h-4 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                        viewBox="0 0 100 101"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                            fill="currentColor"
                                        />
                                        <path
                                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                            fill="currentFill"
                                        />
                                    </svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div v-else-if="contact_exists">
                                    <CheckCircleIcon
                                        class="h-5 w-5 text-green-500"
                                    />
                                </div>
                                <div
                                    v-else-if="contact_non_exists"
                                    class="flex"
                                >
                                    <XCircleIcon class="h-5 w-5 text-red-600" />
                                    <p
                                        class="text-red-600 font-bold uppercase font-mono text-xs"
                                    >
                                        Company exists
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="h-max-10">
                            <v-select
                                label="name"
                                :options="contacts"
                                class="form_name"
                                placeholder="Search for duplicate"
                                @search="findContacts"
                                :filterable="false"
                            ></v-select>
                        </div>
                        <!-- :reduce="(name) => name.id"
                        v-model="form.contact_id" -->
                        <div class="flex">
                            <input
                                maxlength="100"
                                type="text"
                                class="block mt-1 w-full min-w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.name"
                                @change="checkContact(form.name)"
                            />
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label class="font-bold">Address </label>
                        <div v-if="form.address.length >= 800" class="flex">
                            <XCircleIcon class="h-5 w-5 text-red-600" />
                            <p
                                class="text-red-600 font-bold uppercase font-mono text-xs"
                            >
                            Exceeded limit
                            </p>
                        </div>
                        <input
                            maxlength="800"
                            type="text"
                            class="block mt-1 w-96 h-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.address"
                        />
                    </div>

                    <div class="form-group">
                        <label class="font-bold">Remark</label>
                        
                        <div v-if="form.remark.length >= 800" class="flex">
                            <XCircleIcon class="h-5 w-5 text-red-600" />
                            <p
                                class="text-red-600 font-bold uppercase font-mono text-xs"
                            >
                            Exceeded limit
                            </p>
                        </div>

                        <!-- <div>{{ form.remark.length }}</div> -->
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
import _ from "lodash";
import { CheckCircleIcon, XCircleIcon } from "@heroicons/vue/24/solid";

export default {
    components: { GoBack, CheckCircleIcon, XCircleIcon },

    data() {
        return {
            form: {
                status_id: "",
                type_id: "",
                industry_id: "",
                name: "",
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
            contact_check: false,
            contact_exists: false,
            contact_non_exists: false,
            contact_check_result: "",
            contact_search: "",
        };
    },
    watch: {
        "form.name": _.debounce(function (newVal, oldVal) {
            this.checkContact(newVal);
        }, 500),
    },

    created() {
        this.getStatus();
        this.getCategory();
        this.getType();
        this.getIndustry();
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

        async checkContact(contact_name) {
            // console.log("contact_name", contact_name);
            this.contact_non_exists = false;
            this.contact_exists = false;
            this.contact_check = true;
            if (contact_name.length === 0) {
                this.contact_non_exists = false;
                this.contact_exists = false;
                this.contact_check = false;
            } else {
                await axios
                    .get(
                        "/api/contacts/contact_check_result?" +
                            "q=" +
                            contact_name
                    )
                    .then((res) => {
                        this.contact_check_result = res.data.data;
                        // console.log(
                        //     "contact_check_result",
                        //     this.contact_check_result
                        // );
                        if (this.contact_check_result === true) {
                            this.contact_check = false;
                            return (this.contact_exists = true);
                        } else {
                            this.contact_check = false;
                            return (this.contact_non_exists = true);
                        }
                    });
            }
        },

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
                        user_id: document
                            .querySelector('meta[name="user-id"]')
                            .getAttribute("content"),
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
};
</script>

<style>
.form_name {
    background-color: lightgrey;
}
</style>
