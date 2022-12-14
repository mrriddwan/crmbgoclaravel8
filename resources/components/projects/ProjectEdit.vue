<template>
    <div
        class="w-full min-h-screen px-5 pt-3 pb-60"
    >
        <div>
            <GoBack />
        </div>

        <div
            class="items-center text-center text-white font-mono font-extrabold bg-orange-400 px-48 py-2 rounded-md uppercase"
        >
            <h1 class="px-2 py-1 bg-black-50">Edit Project</h1>
        </div>
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

        <div class="row mt-3">
            <div class="col-md-6">
                <form @submit.prevent="updateProject">
                    <div class="form-group">
                        <label
                            >Start Date
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <!-- <input
                            type="date"
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="project.project_startdate"
                        /> -->
                        <div>
                            <VueDatePicker
                                v-model="project.project_startdate"
                                showNowButton
                                nowButtonLabel="Today"
                                :enableTimePicker="false"
                                class="text-center w-full inline-block items-left mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label
                            >End Date
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <div>
                            <VueDatePicker
                                v-model="project.project_enddate"
                                showNowButton
                                nowButtonLabel="Today"
                                :enableTimePicker="false"
                                class="text-center w-full inline-block items-left mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            />
                        </div>
                        <!-- <input
                            type="date"
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="project.project_enddate"
                        /> -->
                    </div>

                    <div class="form-group">
                        <label
                            >Project Name
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <input
                            maxlength="800"
                            type="text"
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="project.project_name"
                        />
                    </div>

                    <div class="form-group">
                        <label
                            >Company Name
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <div class="h-max-10">
                            <v-select
                                label="name"
                                :options="contacts"
                                class="form_company"
                                :reduce="(name) => name.id"
                                v-model="project.contact_id"
                                placeholder="Search & select company"
                                @search="findContacts"
                                :filterable="false"
                            ></v-select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Remark</label>
                        <div
                            v-if="project.project_remark.length >= 800"
                            class="text-red-600 inline text-xs uppercase"
                        >
                            Exceeded limit
                        </div>
                        <textarea
                            maxlength="800"
                            type="text"
                            class="block mt-1 w-96 w-max-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="project.project_remark"
                        />
                    </div>

                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 mt-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
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
import { VueDatePicker } from "@vuepic/vue-datepicker";
import moment from "moment";

export default {
    components: { GoBack, VueDatePicker },

    data() {
        return {
            moment: moment,
            project: {
                project_startdate: "",
                project_enddate: "",
                project_name: "",
                project_remark: "",
                user_id: "",
                contact_id: "",
            },

            contacts: [],
            errors: "",
        };
    },

    mounted() {
        this.getContacts();
        this.showContact();
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

        async updateProject() {
            try {
                await axios.put(
                    "/api/projects/update/" + this.$route.params.id,
                    {
                        project_startdate: this.moment(
                            this.project.project_startdate
                        ).format("YYYY-MM-DD"),
                        project_enddate: this.moment(
                            this.project.project_enddate
                        ).format("YYYY-MM-DD"),
                        project_name: this.project.project_name,
                        project_remark: this.project.project_remark
                            ? this.project.project_remark
                            : "No remark",
                        user_id: 2, //change to current user later
                        contact_id: this.project.contact_id,
                    }
                );

                await this.$router.push({
                    name: "project_index",
                });
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
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

        async showContact() {
            await axios
                .get("/api/projects/show/" + this.$route.params.id)
                .then((res) => {
                    this.project = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    
};
</script>
<style>
.form_company {
    background-color: rgb(255, 255, 255);
    border-radius: 0.375rem;
}
</style>