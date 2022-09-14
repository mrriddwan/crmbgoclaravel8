<template>
    <div class="container w-max border-4 align-center mx-auto h-max">
        <h1
            class="items-center text-center text-white font-extrabold bg-slate-600 px-2 py-2 rounded-md"
        >
            Edit Contact
        </h1>
        <GoBack />
        <div class="row">
            <div class="col-md-6 px-20">
                <form @submit.prevent="updateContact()">
                    <div class="form-group mb-4">
                        <label class="font-bold">User</label>
                        <select
                            class="block m-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="contact.user_id"
                            @change="getUser"
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
                    <div class="form-group mb-4">
                        <label class="font-bold">Status</label>
                        <select
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="contact.status_id"
                            @change="getStatus"
                        >
                            <option value="">Please select one</option>

                            <option
                                v-for="status in statuses"
                                :key="status.id"
                                :value="status.id"
                            >
                                {{ status.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label class="font-bold">Type</label>
                        <select
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="contact.type_id"
                            @change="getType"
                        >
                            <option value="">Please select one</option>

                            <option
                                v-for="type in types"
                                :key="type.id"
                                :value="type.id"
                            >
                                {{ type.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group mb-4">
                        <label class="font-bold">Industry</label>
                        <select
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="contact.industry_id"
                            @change="getIndustry"
                        >
                            <option value="">Please select one</option>

                            <option
                                v-for="industry in industries"
                                :key="industry.id"
                                :value="industry.id"
                            >
                                {{ industry.name }}
                            </option>
                        </select>
                    </div>

                    <div class="mt-1 mb-4">
                        <label class="font-bold">Name</label>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="contact.name"
                        />
                    </div>
                    <div class="form-group mb-4">
                        <label class="font-bold">Category</label>
                        <select
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="contact.category_id"
                            @change="getCategory"
                        >
                            <option value="">Please select one</option>

                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label class="font-bold">Address</label>
                        <textarea
                            type="text"
                            name="address"
                            id="address"
                            class="form-control block w-max h-max px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            rows="3"
                            placeholder="Your message"
                            v-model="contact.address"
                        ></textarea>
                    </div>
                    <div class="form-group mb-4">
                        <label class="font-bold">Remark</label>
                        <textarea
                            type="text"
                            name="remark"
                            id="remark"
                            class="form-control block w-max px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            rows="3"
                            placeholder="Your message"
                            v-model="contact.remark"
                        ></textarea>

                    </div>

                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import GoBack from "../utils/GoBack.vue";

export default {
    data() {
        return {
            contact: {
                user_id: "",
                status_id: "",
                type_id: "",
                category_id: "",
                industry_id: "",
                name: "",
                address: "",
                remark: "",
            },
            users: [],
            statuses: [],
            types: [],
            categories: [],
            industries: [],
        };
    },

    created() {
        this.showContact();
        this.getStatus();
        this.getCategory();
        this.getUser();
        this.getType();
        this.getIndustry();
        // this.getFormSelections();
    },
    methods: {
        showContact() {
            axios
                .get("/api/contacts/show/" + this.$route.params.id)
                .then((res) => {
                    this.contact = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

         // <p class="inline text-red-600 text-lg">*</p></label>
         
        // async createPIC() {
    //         const contact = this.contact_infos;
    //         // const form = document.getElementById('inchargeForm');
    //         try {
    //             await axios.post("/api/incharges/store", {
    //                 contact_id: contact[0].id,
    //                 name: this.form.name,
    //                 email: this.form.email,
    //                 phone_mobile: this.form.phone_mobile,
    //                 phone_office: this.form.phone_office,
    //             });

    //             await this.$router.push({
    //                 name: "incharge_create",
    //                 params: { id: this.$route.params.id },
    //             });
    //         } catch (e) {
    //             {
    //                 if (e.response.status === 422){
    //                     this.errors = e.response.data.errors;
    //                 }
                    
    //             }
    //         }
    //     },

        updateContact() {
            axios
                .put("/api/contacts/update/" + this.$route.params.id, {
                    user_id: this.contact.user_id,
                    address: this.contact.address,
                    type_id: this.contact.type_id,
                    status_id: this.contact.status_id,
                    industry: this.contact.industry_id,
                    name: this.contact.name,
                    category_id: this.contact.category_id,
                    address: this.contact.address,
                    remark: this.contact.remark,
                })
                .then((res) => {
                    this.$router.push({ name: "contact_index" });
                });
        },

        getStatus() {
            axios
                .get("/api/contactstatus/index")
                .then((res) => {
                    this.statuses = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getIndustry(){
            axios
                .get("/api/contactindustry/index")
                .then((res) => {
                    this.industries = res.data.data;
                }).catch((error) => {
                    console.log(error);
                })
        },

        getUser() {
            axios
                .get("/api/users/index")
                .then((res) => {
                    this.users = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getCategory() {
            axios
                .get("/api/contactcategory/index")
                .then((res) => {
                    this.categories = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getType() {
            axios
                .get("/api/contacttypes/index")
                .then((res) => {
                    this.types = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },

    components: {
        GoBack,
    },
};
</script>

// getFormSelections() { // const requestOne = axios.get(categoryAPI); // const
requestTwo = axios.get(typeAPI); // const requestThree = axios.get(statusAPI);
// const requestFour = axios.get(userAPI); // axios // .all([requestOne,
requestTwo, requestThree, requestFour]) // .then(axios // .spread((...responses)
=> { // const responseOne = responses[0] // const responseTwo = responses[1] //
const responseThree = responses[2] // const responseFour = responses[3] // //
use/access the results // console.log(responseOne, responseTwo, responseThree,
responseFour); // })) // .catch(errors => { // console.error(errors); // }) // }
