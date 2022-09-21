<template>
    <div class="container w- border-4 align-center mx-auto h-max px-5 py-5">
        <div>
            <GoBack />
        </div>

        <div
            class="items-center text-center text-white font-extrabold bg-slate-600 px-2 py-2 rounded-md"
        >
            <h1 class="px-2 py-3 bg-black-50">Edit To Do</h1>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <form @submit.prevent="editToDo">
                    <div>
                        <label
                            for="large-toggle"
                            class="inline-flex relative items-center cursor-pointer"
                        >
                            <input
                                type="checkbox"
                                true-value="1"
                                false-value="2"
                                id="large-toggle"
                                class="sr-only peer"
                                v-model="todo.priority_id"
                            />
                            <div
                                class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"
                            ></div>
                            <span
                                class="ml-3 text-md font-extrabold uppercase text-black"
                                >Urgent</span
                            >
                        </label>
                    </div>
                    <div class="form-group">
                        <label>User</label>
                        <select
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="todo.user_id"
                            @change="getUsers"
                        >
                            <option disabled value="">Please select one</option>
                            <option
                                v-for="user in users"
                                :key="user.id"
                                :value="user.id"
                            >
                                {{ user.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date of Task</label>
                        <input
                            type="date"
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="todo.todo_created"
                        />
                    </div>
                    <div class="form-group">
                        <label>Deadline of Task</label>
                        <input
                            type="date"
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="todo.todo_deadline"
                        />
                    </div>

                    <div class="form-group">
                        <label>Contact Status</label>
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="todo.status_id"
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
                        <label>Contact Type</label>
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="todo.type_id"
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
                        <label>Contact Name</label>
                        <div>
                            <select
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="todo.contact_id"
                                @change="getContacts"
                            >
                                <option disabled value="">
                                    Please select one
                                </option>
                                <option
                                    v-for="contact in contacts"
                                    :key="contact.id"
                                    :value="contact.id"
                                >
                                    {{ contact.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Task</label>
                        <select
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="todo.task_id"
                            @change="getTasks"
                        >
                            <option disabled value="">Please select one</option>
                            <option
                                v-for="task in tasks"
                                :key="task.id"
                                :value="task.id"
                            >
                                {{ task.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Remark</label>
                        <textarea
                            type="text"
                            class="block mt-1 w-60 w-max-100 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="todo.todo_remark"
                        />
                    </div>

                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 mt-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Save Edit
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
            todo: {
                priority_id: "",
                user_id: "",
                todo_created: "",
                todo_deadline: "",
                status_id: "",
                type_id: "",
                contact_id: "",
                task_id: "",
                todo_remark: "",
            },
            tasks: [],
            contacts: [],
            statuses: [],
            types: [],
            users: [],
        };
    },

    mounted() {
        this.showToDo();
        this.getTasks();
        this.getContacts();
        this.getStatus();
        this.getUser();
        this.getType();
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
    //             this.form.contact_id = "";
    //             this.form.name = "";
    //             this.form.email = "";
    //             this.form.phone_mobile = "";
    //             this.form.phone_office = "";
    //             this.errors = "";
    //             this.showIncharge();
    //         } catch (e) {
    //             {
    //                 if (e.response.status === 422){
    //                     this.errors = e.response.data.errors;
    //                 }

    //             }
    //         }
    //     },

    methods: {
        editToDo() {
            axios
                .put("/api/todos/update/" + this.$route.params.id, {
                    priority_id: this.todo.priority_id,
                    user_id: this.todo.user_id,
                    todo_created: this.todo.todo_created,
                    todo_deadline: this.todo.todo_deadline,
                    status_id: this.todo.status_id,
                    type_id: this.todo.type_id,
                    contact_id: this.todo.contact_id,
                    task_id: this.todo.task_id,
                    todo_remark: this.todo.todo_remark,
                    //need to add color id later
                })
                .then((res) => {
                    this.$router.push({
                        name: "todo_index",
                        params: {
                            selectedDate: this.todo.todo_created,
                        },
                    });
                });
        },

        async showToDo() {
            await axios
                .get("/api/todos/show/" + this.$route.params.id)
                .then((res) => {
                    this.todo = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getTasks() {
            await axios
                .get("/api/tasks/index")
                .then((res) => {
                    this.tasks = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getStatus() {
            await axios
                .get("/api/contactstatus/index")
                .then((res) => {
                    this.statuses = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUser() {
            await axios
                .get("/api/users/index")
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

        async getType() {
            await axios
                .get("/api/contacttype/index")
                .then((res) => {
                    this.types = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    components: { GoBack },
};
</script>
