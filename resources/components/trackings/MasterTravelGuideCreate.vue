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
                <!-- @submit.prevent="createTrackingTravelGuide" -->
                <div class="rounded px-8 pt-1 pb-8 mb-4">
                    <div
                        class="text-center text-white bg-slate-600 px-2 py-1 rounded-md"
                    >
                        <h2
                            class="px-3 bg-black-50 uppercase w-full font-mono font-extrabold"
                        >
                            Create Tracking (Travel Guide) - Master Record
                        </h2>
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
                                    v-model="form.edition1"
                                    placeholder="eg: KLTG"
                                />
                                <p class="mx-5">-</p>
                                <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="form.edition2"
                                    placeholder="eg: 40"
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
                                    v-model="form.tguide_size"
                                    placeholder="eg: FP"
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
                        <textarea
                            v-model="form.tguide_remark"
                            id="message"
                            maxlength="800"
                            rows="3"
                            placeholder="eg: Artwork by Bluedale"
                            class="block p-2.5 w-full text-xs rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                        ></textarea>
                    </div>
                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                        id="form-wrapper"
                    >
                        <div class="form-assignment">
                            <label class="font-bold">Art Reminder</label>
                            <div class="grid grid-cols-5">
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold">Date</label>
                                    <div class="w-full">
                                        <VueDatePicker
                                            v-model="form.art_reminder_date"
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
                                        v-model="form.art_reminder_user_id"
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
                                <div class="grid grid-cols-1 my-2 col-span-3">
                                    <label class="font-bold">Note</label>
                                    <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                    <textarea
                                        v-model="form.art_reminder_remark"
                                        id="message"
                                        maxlength="800"
                                        rows="1"
                                        placeholder="eg: Artwork by Bluedale"
                                        class="block p-2.5 w-full text-xs rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-assignment">
                            <label class="font-bold">Art Record</label>
                            <div class="grid grid-cols-5">
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold">Date</label>
                                    <div class="w-full">
                                        <VueDatePicker
                                            v-model="form.art_record_date"
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
                                        v-model="form.art_record_user_id"
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
                                <div class="grid grid-cols-1 my-2 col-span-3">
                                    <label class="font-bold">Note</label>
                                    <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                    <textarea
                                        v-model="form.art_record_remark"
                                        id="message"
                                        maxlength="800"
                                        rows="1"
                                        placeholder="eg: Artwork by Client"
                                        class="block p-2.5 w-full text-xs rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                        id="form-wrapper"
                        v-for="(new_package, index) in wip_travel_guide"
                    >
                        <div class="form-assignment">
                            <label class="font-bold"
                                >Package {{ index + 1 }}</label
                            >
                            <div class="grid grid-cols-3">
                                <div class="grid grid-cols-1 my-2 col-span-3">
                                    <label class="font-bold">Name</label>
                                    <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                    <textarea
                                        v-model="new_package.wip_package_name"
                                        id="message"
                                        maxlength="800"
                                        rows="1"
                                        placeholder="eg: Pub  & E book / 20K FB Sponsored Ad"
                                        class="block p-2.5 w-full text-xs rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold">Date</label>
                                    <div class="w-full">
                                        <VueDatePicker
                                            v-model="
                                                new_package.wip_package_date
                                            "
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
                                        v-model="
                                            new_package.wip_package_user_id
                                        "
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
                                <div class="grid grid-cols-1 my-2 col-span-1">
                                    <label class="font-bold">Note</label>
                                    <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                    <textarea
                                        v-model="new_package.wip_package_remark"
                                        id="message"
                                        maxlength="800"
                                        rows="1"
                                        placeholder="eg: Priority client"
                                        class="block p-2.5 w-full text-xs rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button
                            @click="addForm"
                            class="mx-2 text-center text-sm border-2 border-slate-300 p-2 rounded-lg bg-green-400"
                        >
                            +
                        </button>
                        <button
                            v-if="wip_travel_guide.length > 1"
                            @click="removeForm"
                            class="mx-2 text-center text-sm border-2 border-slate-300 p-2 rounded-lg bg-red-400"
                        >
                            -
                        </button>
                    </div>
                    <div>
                        <button
                            @click="createTrackingTravelGuide"
                            class="inline-flex mt-2 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            Create
                        </button>
                    </div>
                </div>
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
                edition1: "",
                edition2: "",
                tguide_size: "",
                tguide_remark: "",
                art_reminder_date: "",
                art_reminder_remark: "",
                art_reminder_user_id: "",
                art_reminder_done: "",
                art_record_date: "",
                art_record_remark: "",
                art_record_user_id: "",
                art_record_done: "",
                //wip travel guide data
            },
            wip_travel_guide: [
                {
                    tracking_tguide_id: "",
                    wip_package_name: "",
                    wip_package_date: "",
                    wip_package_done: "",
                    wip_package_user_id: "",
                    wip_package_remark: "",
                },
            ],
            moment: moment,
            users: [],
            contacts: [],
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

        async createTrackingTravelGuide() {
            if (window.confirm("Confirm create tracking ?")) {
                try {
                    await axios
                        .post("/api/trackings/travel_guide/store", {
                            user_id: this.form.user_id,
                            company_id: this.form.company_id,
                            edition:
                                this.form.edition1 + "-" + this.form.edition2,
                            tguide_size: this.form.tguide_size,
                            tguide_remark: this.form.tguide_remark
                                ? this.form.tguide_remark
                                : "No remark",

                            art_reminder_date: this.form.art_reminder_date
                                ? this.moment(
                                      this.form.art_reminder_date
                                  ).format("YYYY-MM-DD")
                                : null,
                            art_reminder_remark: this.form.art_reminder_remark
                                ? this.form.art_reminder_remark
                                : "No remark",
                            art_reminder_user_id: this.form.art_reminder_user_id
                                ? this.form.art_reminder_user_id
                                : null,
                            art_reminder_done: 2,

                            art_record_date: this.form.art_record_date
                                ? this.moment(this.form.art_record_date).format(
                                      "YYYY-MM-DD"
                                  )
                                : null,
                            art_record_remark: this.form.art_record_remark
                                ? this.form.art_record_remark
                                : "No remark",
                            art_record_user_id: this.form.art_record_user_id
                                ? this.form.art_record_user_id
                                : null,
                            art_record_done: 2,
                        })
                        .then((res) => {
                            const tracking_tguide = res.data.data;
                            console.log(tracking_tguide.id);
                            for (
                                let i = 0;
                                i < this.wip_travel_guide.length;
                                i++
                            ) {
                                axios.post(
                                    "/api/trackings/wip/travel_guide/store",
                                    {
                                        tracking_tguide_id: tracking_tguide.id,
                                        wip_package_name:
                                            this.wip_travel_guide[i]
                                                .wip_package_name,
                                        wip_package_date: this.wip_travel_guide[
                                            i
                                        ].wip_package_date
                                            ? this.moment(
                                                  this.wip_travel_guide[i]
                                                      .wip_package_date
                                              ).format("YYYY-MM-DD")
                                            : null,
                                        wip_package_done: 2,
                                        wip_package_user_id: this
                                            .wip_travel_guide[i]
                                            .wip_package_user_id
                                            ? this.wip_travel_guide[i]
                                                  .wip_package_user_id
                                            : null,
                                        wip_package_remark: this
                                            .wip_travel_guide[i]
                                            .wip_package_remark
                                            ? this.wip_travel_guide[i]
                                                  .wip_package_remark
                                            : null,
                                    }
                                );
                            }
                        })
                        .then((res) => {
                            alert("Tracking and package (wip) created");
                            this.$router.push({
                                name: "tracking_travel_guide",
                            });
                        });
                } catch (e) {
                    {
                        if (e.response.status === 422) {
                            this.errors = e.response.data.errors;
                        } else {
                            console.log("no error response");
                        }
                    }
                }
            }
        },

        addForm() {
            this.wip_travel_guide.push({
                tracking_tguide_id: "",
                wip_package_name: "",
                wip_package_date: "",
                wip_package_done: "",
                wip_package_user_id: "",
                wip_package_remark: "",
            });
        },

        removeForm(index) {
            this.wip_travel_guide.splice(-1);
        },
    },

    components: { GoBack },
};
</script>
