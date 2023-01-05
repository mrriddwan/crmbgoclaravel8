<template>
    <div class="container">
        <div class="px-20 pb-20 rounded-md w-max items-center">
            <h1
                class="text-center text-white uppercase font-mono font-extrabold bg-blue-900 rounded-md"
            >
                Welcome
            </h1>

            <div
                v-for="user_info in user"
                :key="user_info.id"
                class="text-center"
            >
                <div class="flex text-center justify-left my-2">
                    <UserIcon class="h-8 w-8 mr-2" />
                    <h5
                        class="my-auto bg-emerald-300 text-slate-700 px-5 py-2 rounded-lg"
                    >
                        {{ user_info.name }}
                    </h5>
                </div>

                <div
                    class="flex text-center justify-left my-2"
                    v-for="role in user_info.roles"
                    :key="role.id"
                >
                    <IdentificationIcon class="h-8 w-8 mr-2" />
                    <h5
                        class="my-auto bg-purple-300 text-slate-700 px-5 py-2 rounded-lg"
                    >
                        {{ role.name }}
                    </h5>
                </div>
            </div>

            <div class="text-center mx-auto mt-3 align-middle">
                <table>
                    <thead class="bg-slate-400 text-white h-10 uppercase">
                        <tr>
                            <th class="px-3">Date</th>
                            <th class="px-32">
                                <div class="flex text-center">
                                    <SpeakerWaveIcon
                                        class="h-6 w-6 mr-2 text-blue-600"
                                    />Announcement
                                </div>
                            </th>
                            <th class="px-3">From</th>
                        </tr>
                    </thead>
                    <tbody class="text-left">
                        <tr
                            v-if="announcement.length"
                            v-for="announcement_info in announcement"
                            :key="announcement_info.id"
                            class=""
                        >
                            <td class="px-3 py-3">
                                {{ showToday(announcement_info.created_at) }}
                            </td>
                            <td class="px-3 py-3">
                                {{ announcement_info.message }}
                            </td>
                            <td class="px-3 py-3">
                                {{ announcement_info.from_user.name }}
                            </td>
                        </tr>
                        <tr v-else class="text-center mt-2 bg-slate-200 ">
                            <td colspan="3" class="py-3 font-bold font-sans">
                                No announcement
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="text-center mx-auto mt-3 w-max"
                v-for="user_info in user"
                :key="user_info.id"
            >
                <table>
                    <thead class="bg-slate-600 text-white h-10 uppercase">
                        <tr>
                            <th class="px-3">Date</th>
                            <th class="px-32">
                                <div class="flex text-center">
                                    <BellAlertIcon
                                        class="h-5 w-5 mr-2 text-yellow-300"
                                    />Personal Reminder
                                </div>
                            </th>
                            <th class="px-3">From</th>
                            <th class="px-3">To</th>
                        </tr>
                    </thead>
                    <tbody
                        class="text-left bg-slate-400 text-white"
                        v-if="
                            user_info['reminder_from'].length ||
                            user_info['reminder_to'].length
                        "
                    >
                        <tr
                            v-for="reminder in user_info['reminder_from']"
                            :key="reminder.id"
                            class="py-1 mt-2 "
                        >
                            <td class="px-2 py-2">
                                {{ showToday(reminder.created_at) }}
                            </td>
                            <td class="px-2 py-2">
                                {{ reminder.message }}
                            </td>
                            <td class=" text-center">
                                <div
                                    class="w-max"
                                    v-for="user in users"
                                    :key="user.id"
                                >
                                    <span
                                        class="mx-2"
                                        v-if="user.id === reminder.from_user_id"
                                    >
                                        {{ user.name }}</span
                                    >
                                    <span v-else></span>
                                </div>
                            </td>
                            <td class="">
                                <div
                                    class="w-max justify-center"
                                    v-for="user in users"
                                    :key="user.id"
                                >
                                    <span
                                        class="mx-2"
                                        v-if="user.id === reminder.to_user_id"
                                    >
                                        {{ user.name }}</span
                                    >
                                    <span v-else></span>
                                </div>
                            </td>
                        </tr>
                        <tr
                            v-for="reminder in user_info['reminder_to']"
                            :key="reminder.id"
                            class="py-1 mt-2"
                        >
                            <td class="px-2 py-2">
                                {{ showToday(reminder.created_at) }}
                            </td>
                            <td class="px-2 py-2">
                                {{ reminder.message }}
                            </td>
                            <td class="text-center">
                                <div
                                    class="w-max"
                                    v-for="user in users"
                                    :key="user.id"
                                >
                                    <span
                                        v-if="user.id === reminder.from_user_id"
                                    >
                                        {{ user.name }}</span
                                    >
                                    <span v-else></span>
                                </div>
                            </td>
                            <td class="">
                                <div
                                    class="w-max justify-center"
                                    v-for="user in users"
                                    :key="user.id"
                                >
                                    <span
                                        v-if="user.id === reminder.to_user_id"
                                    >
                                        {{ user.name }}</span
                                    >
                                    <span v-else></span>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else class="text-center mt-2 bg-slate-200 ">
                        <td colspan="4" class="py-3 font-bold font-sans">
                            No reminder
                        </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import AdminPermissionAddViaRole from "./AdminPermissionAddViaRole.vue";
import AdminUserRolePermissionEdit from "./AdminUserRolePermissionEdit.vue";

import {
    UserIcon,
    IdentificationIcon,
    SpeakerWaveIcon,
    BellAlertIcon,
    SpeakerXMarkIcon,
    BellIcon,
} from "@heroicons/vue/24/solid";
import axios from "axios";

export default {
    components: {
        UserIcon,
        IdentificationIcon,
        AdminPermissionAddViaRole,
        AdminUserRolePermissionEdit,
        SpeakerWaveIcon,
        BellAlertIcon,
    },

    data() {
        return {
            moment: moment,
            user: [],
            announcement: [],
            users: [],
        };
    },

    mounted() {
        // this.selectedUser = document
        //     .querySelector('meta[name="user-id"]')
        //     .getAttribute("content");
        this.getUsers();
        this.getUser();
    },

    watch: {
        // selectedPermission(value) {
        //     this.getPermission(value);
        // },
    },

    methods: {
        async getUser() {
            await axios
                .get("/api/users/home")
                .then((res) => {
                    this.user = res.data.data;
                    this.announcement = res.data.data2;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUsers() {
            await axios
                .get("/api/users/index")
                .then((res) => {
                    this.users = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        showToday(date) {
            let new_date = new Date(date);
            let day = moment(new_date).format("DD-MM-YY");
            return day;
        },
    },
};
</script>
