<template>
    <div class="container w-max mx-auto h-max px-3 py-3">
        <div class="">
            <GoBack />
        </div>
        <div class="flex w-full row">
            <div class="col-lg-20">
                <!-- @submit.prevent="updateTrackingTravelGuide" -->
                <div class="rounded px-8 pt-1 pb-8 mb-4">
                    <div
                        class="text-center text-white bg-blue-900 px-2 py-1 rounded-md"
                    >
                        <h1
                            class="px-8 bg-black-50 uppercase w-max font-mono font-extrabold"
                        >
                            Edit Tracking (Travel Guide) - Master Record
                        </h1>
                    </div>

                    <div
                        class="bg-cyan-100 px-2 py-2 border-gray-300 my-3 rounded-md"
                    >
                        <div class="form-group grid grid-cols-2">
                            <label class="font-bold"
                                >User
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                            <select
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="tguide.user_id"
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
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                            <v-select
                                id="company_id"
                                label="name"
                                :options="contacts"
                                class="select_company"
                                :reduce="(name) => name.id"
                                v-model="tguide.company_id"
                                placeholder="Select company"
                            ></v-select>
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
                                        v-model="tguide.edition"
                                        placeholder="eg: 30' x 40'"
                                    />
                                    <!-- <p class="mx-5">-</p>
                                <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="tguide.general_type"
                                    placeholder="eg: 30' x 40'"
                                /> -->
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
                                        v-model="tguide.tguide_size"
                                        placeholder="eg: 30' x 40'"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-2">
                            <label class="font-bold"
                                >Remark
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
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
                                v-model="tguide.tguide_remark"
                                placeholder="eg: Artwork by Bluedale"
                            />
                        </div>
                    </div>
                    <div v-if="tracking_errors">
                        <div v-for="(v, k) in tracking_errors" :key="k">
                            <p
                                v-for="error in v"
                                :key="error"
                                class="text-xs bg-red-500 text-white rounded font-bold mb-1 shadow-lg py-2 px-4 pr-0 w-max"
                            >
                                {{ error }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="text-center bg-emerald-100 px-2 py-2 border-gray-300 my-3 rounded-md"
                        id="form-wrapper"
                    >
                        <div class="form-assignment">
                            <label class="font-bold">Art Reminder</label>
                            <div class="grid grid-cols-5">
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold">Progress</label>
                                    <select
                                        class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="tguide.art_reminder_done"
                                    >
                                        <option value="2">Pending</option>
                                        <option value="1">Completed</option>
                                    </select>
                                </div>
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold">Date</label>
                                    <div class="w-full">
                                        <VueDatePicker
                                            v-model="tguide.art_reminder_date"
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
                                        v-model="tguide.art_reminder_user_id"
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
                                        v-model="tguide.art_reminder_remark"
                                        id="message"
                                        maxlength="800"
                                        rows="1"
                                        placeholder="eg: Artwork by Bluedale"
                                        class="block p-2.5 w-full text-md rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-assignment">
                            <label class="font-bold">Art Record</label>
                            <div class="grid grid-cols-5">
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold">Progress</label>
                                    <select
                                        class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="tguide.art_record_done"
                                    >
                                        <option value="2">Pending</option>
                                        <option value="1">Completed</option>
                                    </select>
                                </div>
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold">Date</label>
                                    <div class="w-full">
                                        <VueDatePicker
                                            v-model="tguide.art_record_date"
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
                                        v-model="tguide.art_record_user_id"
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
                                        v-model="tguide.art_record_remark"
                                        id="message"
                                        maxlength="800"
                                        rows="1"
                                        placeholder="eg: Artwork by Bluedale"
                                        class="block p-2.5 w-full text-md rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="package_errors">
                        <div v-for="(v, k) in package_errors" :key="k">
                            <p
                                v-for="error in v"
                                :key="error"
                                class="text-xs bg-red-500 text-white rounded font-bold mb-1 shadow-lg py-2 px-4 pr-0 w-max"
                            >
                                {{ error }}
                            </p>
                        </div>
                    </div>

                    <div
                        class="text-center opacity-100 bg-purple-200 px-2 py-2 border-gray-300 my-3 rounded-md"
                        id="form-wrapper"
                        v-if="wip_travel_guide"
                        v-for="(tguide_package, index) in wip_travel_guide"
                    >
                        <div class="form-assignment">
                            <label class="font-bold"
                                >Package {{ index + 1 }}</label
                            >
                            <div class="grid grid-cols-3">
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold">Progress</label>
                                    <select
                                        class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="
                                            tguide_package.wip_package_done
                                        "
                                    >
                                        <option value="2">Pending</option>
                                        <option value="1">Completed</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-1 my-2 col-span-2">
                                    <label class="font-bold"
                                        >Name
                                        <p class="inline text-red-600 text-lg">
                                            *
                                        </p></label
                                    >
                                    <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                    <textarea
                                        v-model="
                                            tguide_package.wip_package_name
                                        "
                                        id="message"
                                        maxlength="800"
                                        rows="1"
                                        placeholder="eg: Sponsored Ads / Video / Pub E-book"
                                        class="block p-2.5 w-full text-md rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold"
                                        >Date
                                        <p class="inline text-red-600 text-lg">
                                            *
                                        </p></label
                                    >
                                    <div class="w-full">
                                        <VueDatePicker
                                            v-model="
                                                tguide_package.wip_package_date
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
                                            tguide_package.wip_package_user_id
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
                                        v-model="
                                            tguide_package.wip_package_remark
                                        "
                                        id="message"
                                        maxlength="800"
                                        rows="1"
                                        placeholder="eg: Artwork by Bluedale"
                                        class="block p-2.5 w-full text-md rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                            </div>
                            <button
                                v-if="tguide_package.tracking_tguide_id"
                                class="mr-2 mb-2 items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                @click="deletePackage(tguide_package.id)"
                            >
                                <TrashIcon class="h-3 w-3" />
                            </button>
                        </div>
                    </div>
                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                        id="form-wrapper"
                        v-else
                    >
                        <div class="form-assignment">
                            <label class="font-bold">Package</label>
                            <div class="grid grid-cols-3">
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold">Progress</label>
                                    <select
                                        class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="
                                            tguide_package.wip_package_done
                                        "
                                    >
                                        <option value="2">Pending</option>
                                        <option value="1">Completed</option>
                                    </select>
                                </div>
                                <div class="grid grid-cols-1 my-2 col-span-2">
                                    <label class="font-bold"
                                        >Name
                                        <p class="inline text-red-600 text-lg">
                                            *
                                        </p></label
                                    >
                                    <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                    <textarea
                                        v-model="
                                            tguide_package.wip_package_name
                                        "
                                        id="message"
                                        maxlength="800"
                                        rows="1"
                                        placeholder="eg: Artwork by Bluedale"
                                        class="block p-2.5 w-full text-md rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                                <div class="mx-1 grid grid-cols-1">
                                    <label class="font-bold"
                                        >Date
                                        <p class="inline text-red-600 text-lg">
                                            *
                                        </p></label
                                    >
                                    <div class="w-full">
                                        <VueDatePicker
                                            v-model="
                                                tguide_package.wip_package_date
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
                                            tguide_package.wip_package_user_id
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
                                        v-model="
                                            tguide_package.wip_package_remark
                                        "
                                        id="message"
                                        maxlength="800"
                                        rows="1"
                                        placeholder="eg: Artwork by Bluedale"
                                        class="block p-2.5 w-full text-md rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    ></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center">
                        <div class="text-center items-center text-sm">
                            <PlusCircleIcon
                                @click="addForm"
                                class="text-center items-center h-10 w-10 text-green-400 hover:text-green-600 hover:cursor-pointer"
                            />
                        </div>
                        <div class="text-center items-center text-sm">
                            <MinusCircleIcon
                                v-if="check_total > total_object"
                                @click="removeForm"
                                class="text-center items-center h-10 w-10 text-red-400 hover:text-red-600 hover:cursor-pointer"
                            />
                        </div>
                    </div>
                    <div>
                        <button
                            @click="updateTrackingTravelGuide()"
                            class="inline-flex mt-2 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            Update
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
import {
    TrashIcon,
    PlusCircleIcon,
    MinusCircleIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: { GoBack, TrashIcon, PlusCircleIcon, MinusCircleIcon },

    data() {
        return {
            tguide: {
                user_id: "",
                company_id: "",
                edition: "",
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
            },
            wip_travel_guide: [
                {
                    id: "",
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
            tracking_errors: "",
            package_errors: "",
            total_object: 0,
            check_total: Number,
        };
    },

    mounted() {
        this.getUsers();
        this.getContacts();
        this.getTrackingTravelGuide();
    },

    created() {},

    methods: {
        async getTrackingTravelGuide() {
            await axios
                .get(
                    "/api/trackings/travel_guide/show/" + this.$route.params.id
                )
                .then((res) => {
                    this.tguide = res.data.data[0];
                    this.wip_travel_guide = this.tguide.wip_travel_guide;
                    this.countTotalObject(this.tguide.wip_travel_guide);
                    this.check_total = this.total_object;
                    // console.log('total object: ',this.total_object)
                    // console.log('check_total: ',this.check_total)
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

        async updateTrackingTravelGuide() {
            if (window.confirm("Confirm update tracking ?")) {
                try {
                    await Promise.all([
                        axios.put("/api/trackings/wip/travel_guide/update", {
                            wip_travel_guide: this.wip_travel_guide,
                            tracking_tguide_id: this.$route.params.id,
                        }),
                        axios.put(
                            "/api/trackings/travel_guide/update/" +
                                this.$route.params.id,
                            {
                                user_id: this.tguide.user_id,
                                company_id: this.tguide.company_id,
                                edition: this.tguide.edition,
                                tguide_size: this.tguide.tguide_size,
                                tguide_remark: this.tguide.tguide_remark
                                    ? this.tguide.tguide_remark
                                    : "No remark",

                                art_reminder_date: this.tguide.art_reminder_date
                                    ? this.moment(
                                          this.tguide.art_reminder_date
                                      ).format("YYYY-MM-DD")
                                    : null,
                                art_reminder_remark: this.tguide
                                    .art_reminder_remark
                                    ? this.tguide.art_reminder_remark
                                    : "No remark",
                                art_reminder_user_id: this.tguide
                                    .art_reminder_user_id
                                    ? this.tguide.art_reminder_user_id
                                    : null,
                                art_reminder_done:
                                    this.tguide.art_reminder_done,

                                art_record_date: this.tguide.art_record_date
                                    ? this.moment(
                                          this.tguide.art_record_date
                                      ).format("YYYY-MM-DD")
                                    : null,
                                art_record_remark: this.tguide.art_record_remark
                                    ? this.tguide.art_record_remark
                                    : "No remark",
                                art_record_user_id: this.tguide
                                    .art_record_user_id
                                    ? this.tguide.art_record_user_id
                                    : null,
                                art_record_done: this.tguide.art_record_done,
                            }
                        ),
                    ]).then((res) => {
                        alert("Tracking and package (wip) updated");
                        this.$router.push({
                            name: "tracking_travel_guide",
                        });
                    });
                } catch (e) {
                    {
                        if (e.response.status === 422) {
                            this.tracking_errors = e.response.data.errors;
                        } else {
                            console.log("no error response");
                        }
                    }
                }
            }
        },

        async updateWIPTravelGuide() {
            try {
                await axios
                    .put("/api/trackings/wip/travel_guide/update", {
                        wip_travel_guide: this.wip_travel_guide,
                        tracking_tguide_id: this.$route.params.id,
                    })
                    .then((res) => {
                        console.log(res);
                    });
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.package_errors = e.response.data.errors;
                    } else {
                        console.log("no error response");
                    }
                }
            }
        },

        countTotalObject(array_obj) {
            for (let i = 0; i < array_obj.length; i++) {
                // checking the type of the object.
                if (array_obj[i] instanceof Object) {
                    this.total_object++;
                }
            }
        },

        deletePackage(package_id) {
            if (!window.confirm("Confirm delete package from tracking?")) {
                return;
            }
            axios.delete(
                "/api/trackings/wip/travel_guide/delete/" + package_id
            );
            this.getTrackingTravelGuide();
        },

        addForm() {
            this.wip_travel_guide.push({
                tracking_tguide_id: "",
                wip_package_name: "",
                wip_package_date: "",
                wip_package_done: 2,
                wip_package_user_id: "",
                wip_package_remark: "",
            });
            this.check_total++;
            // console.log('check_total after add: ',this.check_total)
        },

        removeForm(index) {
            this.wip_travel_guide.splice(-1);
            this.check_total--;
            // console.log('check_total after minus: ',this.check_total)
        },
    },
};
</script>
<style>
.select_company {
    background: #f8fafc;
    height: max-content;
}
</style>
