<template>
    <div class="container pt-1 pb-96 ">
        <div
            class="px-20 py-1 rounded-md flex w-max justify-center items-center row"
        >
            <div class="text-center bg-blue-900 px-20">
                <h1
                    class="text-center text-white uppercase w-max font-mono font-extrabold flex mx-auto"
                >
                    Announcement <PencilIcon class="h-8 w-8 ml-2 my-auto" />
                </h1>
            </div>
            <div v-if="errors">
                <div v-for="(v, k) in errors" :key="k">
                    <p
                        v-for="error in v"
                        :key="error"
                        class="text-xs bg-red-500 text-white rounded font-bold shadow-lg py-2 px-4 pr-0 w-max"
                    >
                        {{ error }}
                    </p>
                </div>
            </div>

            <div class="w-full my-3">
                <div class="mt-3 text-center font-extrabold">
                    <label>Announcement / Reminder </label>
                </div>
                <textarea
                    cols="30"
                    rows="6"
                    class="form-control"
                    v-model="form.message"
                />
                <div class="mt-3">
                    <div>
                        <label class="mt-2">Message Type</label>
                        <select
                            class="form-control mt-2"
                            v-model="message_type"
                        >
                            <option value="announcement">
                                Announcement (All)
                            </option>
                            <option value="reminder">Reminder</option>
                        </select>
                    </div>
                    <div v-if="message_type === 'reminder'">
                        <label class="mt-2">Select user</label>
                        <div class="text-xs text-center h-max w-full align-top">
                            <v-select
                                label="name"
                                :options="users"
                                :reduce="(name) => name.id"
                                v-model="to_user_id"
                                multiple
                                class="vue_select"
                            ></v-select>
                        </div>
                    </div>
                </div>

                <div
                    class="mt-3 bg-green-300 hover:bg-green-500 w-max flex rounded-md px-1 py-1 text-center"
                >
                    <button
                        class="uppercase text-xs text-center flex"
                        @click="createMessage"
                    >
                        <PlusIcon
                            class="h-4 w-4 ml-2 my-auto text-center"
                        />Message
                    </button>
                </div>
            </div>
        </div>

        <div class="text-center mt-3 justify-center">
            <table class="mx-auto">
                <thead class="bg-slate-600 text-white h-10 uppercase">
                    <tr>
                        <th class="px-3">Date</th>
                        <th class="px-3">Type</th>
                        <th class="px-3">Message</th>
                        <th class="px-3">From</th>
                        <th class="px-3">To</th>
                        <th class="px-3">Action</th>
                    </tr>
                </thead>
                <tbody class="text-left text-xs">
                    <tr
                        v-for="annc_reminder in announcements_reminders"
                        :key="annc_reminder.id"
                    >
                        <td class="px-3 py-3">
                            {{ showToday(annc_reminder.created_at) }}
                        </td>
                        <td class="px-3 py-3">
                            <span v-if="annc_reminder.message_type_id !== 1">
                                Reminder</span
                            >
                            <span v-else>Announcement</span>
                        </td>
                        <td class="px-3 py-3">{{ annc_reminder.message }}</td>
                        <td
                            class="px-3 py-3"
                        >
                            <div
                                class="text-center"
                                v-for="user in users"
                                :key="user.id"
                            >
                                <div
                                    class="my-1"
                                    v-if="user.id === annc_reminder.from_user.id"
                                >
                                    {{ user.name }}
                                </div>
                                <div v-else></div>
                            </div>
                        </td>
                        <td
                            class="px-3 py-3"
                            v-if="annc_reminder.message_type_id !== 1"
                        >
                            <div
                                class="text-center"
                                v-for="user in users"
                                :key="user.id"
                            >
                                <div
                                    class="my-1"
                                    v-if="user.id === annc_reminder.to_user.id"
                                >
                                    {{ user.name }}
                                </div>
                                <div v-else></div>
                            </div>
                        </td>
                        <td v-else class="text-center">All</td>
                        <td>
                            <div class="flex text-center">
                                <button
                                    class="uppercase text-xs text-center bg-yellow-400 hover:bg-yellow-600 px-1 py-1 mr-1 rounded-md my-auto"
                                    @click="
                                        anncReminderModalVisible(
                                            annc_reminder.id
                                        )
                                    "
                                >
                                    <PencilSquareIcon
                                        class="h-4 w-4 my-auto text-center"
                                    />
                                </button>
                                <button
                                    class="uppercase text-xs text-center bg-red-400 hover:bg-red-600 px-1 py-1 w-max rounded-md my-auto"
                                    @click="deleteMessage(annc_reminder.id)"
                                >
                                    <TrashIcon
                                        class="h-4 w-4my-auto text-center"
                                    />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <Modal v-show="isModalVisible" @close="closeModal">
                <template #header>
                    <div
                        class="text-center justify-center bg-slate-400 text-white rounded-md px-20 py-2 uppercase font-mono mx-auto"
                    >
                        <h3>Edit</h3>
                    </div>
                </template>

                <template #body>
                    <div v-if="edit_errors">
                        <div v-for="(v, k) in edit_errors" :key="k">
                            <p
                                v-for="error in v"
                                :key="error"
                                class="text-xs bg-red-500 text-white rounded font-bold shadow-lg py-2 px-4 pr-0 w-max"
                            >
                                {{ error }}
                            </p>
                        </div>
                    </div>
                    <div>
                        <textarea
                            cols="30"
                            rows="6"
                            class="form-control"
                            v-model="selected_annc_reminder.message"
                        />
                    </div>
                    <div class="mt-3">
                        <div class="text-center my-2">
                            <label class="mt-2">Message Type</label>
                            <select
                                class="form-control mt-2"
                                v-model="selected_annc_reminder.message_type_id"
                            >
                                <option :value="1">Announcement (All)</option>
                                <option :value="2">Reminder</option>
                            </select>
                        </div>
                        <div
                            class="text-center my-2"
                            v-if="selected_annc_reminder.message_type_id === 2"
                        >
                            <label class="mt-2">Selected User</label>
                            <select
                                class="form-control form-control-sm text-xs"
                                v-model="selected_annc_reminder.to_user_id"
                            >
                                <option class="text-sm" :value="null">
                                    Select user
                                </option>
                                <option
                                    class="text-sm"
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.id"
                                >
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="text-center">
                        <button
                            class="bg-green-400 px-2 py-2 rounded-md"
                            @click="updateAnnouncementReminder"
                        >
                            Save
                        </button>
                    </div>
                </template>

                <!-- <template #footer>
                    <p></p>
                </template> -->
            </Modal>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import AdminPermissionAddViaRole from "./AdminPermissionAddViaRole.vue";
import AdminUserRolePermissionEdit from "./AdminUserRolePermissionEdit.vue";
import Modal from "../utils/Modal.vue";

import {
    PencilSquareIcon,
    TrashIcon,
    PlusIcon,
    PencilIcon,
    ClipboardDocumentCheckIcon,
    LockClosedIcon,
    UserPlusIcon,
    ListBulletIcon,
} from "@heroicons/vue/24/solid";
import axios from "axios";

export default {
    components: {
        ClipboardDocumentCheckIcon,
        TrashIcon,
        PlusIcon,
        PencilSquareIcon,
        LockClosedIcon,
        UserPlusIcon,
        ListBulletIcon,
        PencilIcon,
        AdminPermissionAddViaRole,
        AdminUserRolePermissionEdit,
        Modal,
    },

    data() {
        return {
            moment: moment,
            announcements_reminders: [],
            message_type: "announcement",
            form: {
                message: "",
                message_type_id: "",
                from_user_id: "",
            },
            to_user_id: [],
            users: [],
            errors: [],
            edit_errors: [],
            isModalVisible: false,
            selected_annc_reminder: {
                id: "",
                message: "",
                message_type_id: "",
                from_user_id: "",
                to_user_id: "",
            },
        };
    },

    mounted() {
        this.getUsers();
        this.getAnnouncementsReminders();
    },

    watch: {},

    methods: {
        showModal() {
            this.isModalVisible = true;
        },
        closeModal() {
            this.isModalVisible = false;
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

        async getAnnouncementsReminders() {
            await axios
                .get("/api/admin/announcement_reminder")
                .then((res) => {
                    this.announcements_reminders = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        anncReminderModalVisible(annc_reminder_id) {
            this.getSelectedAnnouncementReminder(annc_reminder_id);
            this.isModalVisible = true;
        },

        async getSelectedAnnouncementReminder(annc_reminder_id) {
            await axios
                .get("/api/admin/announcement_reminder/" + annc_reminder_id)
                .then((res) => {
                    this.selected_annc_reminder = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async createMessage() {
            try {
                if (!window.confirm("Confirm create?")) {
                    return;
                }
                await axios.post("/api/admin/announcement_reminder/create", {
                    message: this.form.message,
                    from_user_id: Number(
                        document
                            .querySelector('meta[name="user-id"]')
                            .getAttribute("content")
                    ),
                    message_type_id: this.message_type === "reminder" ? 2 : 1,
                    to_user_id: this.to_user_id,
                });
                alert("Announcement/reminder created.");
                this.form.message = "";
                (this.form.from_user_id = ""),
                    (this.form.message_type_id = ""),
                    (this.to_user_id = []);
                this.errors = "";
                this.getAnnouncementsReminders();
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async deleteMessage(annc_reminder_id) {
            if (!window.confirm("Delete message?")) {
                return;
            }
            await axios.delete(
                "/api/admin/announcement_reminder/delete/" + annc_reminder_id
            );
            alert("Announcement/reminder deleted.");
            this.getAnnouncementsReminders();
        },

        showToday(date) {
            let new_date = new Date(date);
            let day = moment(new_date).format("DD-MM-YY");
            return day;
        },

        async updateAnnouncementReminder() {
            try {
                if (!window.confirm("Confirm update?")) {
                    return;
                }
                await axios
                    .put(
                        "/api/admin/announcement_reminder/update/" +
                            this.selected_annc_reminder.id,
                        {
                            message: this.selected_annc_reminder.message,
                            from_user_id: Number(
                                document
                                    .querySelector('meta[name="user-id"]')
                                    .getAttribute("content")
                            ),
                            message_type_id:
                                this.selected_annc_reminder.message_type_id,
                            to_user_id: this.selected_annc_reminder.to_user_id
                                ? this.selected_annc_reminder.to_user_id
                                : null,
                        }
                    )
                    .then((res) => {
                        alert("Announcement/reminder updated.");
                        this.isModalVisible = false;
                        this.getAnnouncementsReminders();
                    });
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.edit_errors = e.response.data.errors;
                    }
                }
            }
        },
    },
};
</script>

<style>
.vue_select {
    background-color: rgb(255, 255, 255);
    border-radius: 0.375rem;
    font-size: medium;
    font-style: normal;
}
</style>
