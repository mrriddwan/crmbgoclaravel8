<template>
    <div
        class="container w-max-10 border-4 align-center mx-auto h-max px-5 py-5"
    >
        <div>
            <GoBack />
        </div>

        <div
            class="items-center text-center text-white font-extrabold bg-slate-600 px-2 py-2 rounded-md"
        >
            <h1 class="px-2 py-3 bg-black-50">Create To Do (Contact)</h1>
        </div>

        <div
            class="items-center text-center text-black font-extrabold px-1 py-3 rounded-md w-max mx-auto"
        >
            <h2
                class="px-2 py-1 text-4xl bg-amber-300"
            >
                {{ contact.name }}
            </h2>
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
                <form @submit.prevent="insertToDo">
                    <div>
                        <label
                            for="large-toggle"
                            class="inline-flex relative items-center cursor-pointer"
                        >
                            <input
                                type="checkbox"
                                true-value="1"
                                value="2"
                                id="large-toggle"
                                class="sr-only peer"
                                v-model="form.priority_id"
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
                        <label
                            >User
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="contact.user_id"
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
                        <label
                            >Date of Task
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <input
                            type="date"
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.todo_date"
                        />
                    </div>

                    <div class="form-group">
                        <label
                            >Task
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.task_id"
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
                            v-model="form.todo_remark"
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

export default {
    data() {
        return {
            form: {
                priority_id: "",
                user_id: "",
                todo_date: "",
                todo_deadline: "",
                status_id: "",
                type_id: "",
                contact_id: "",
                task_id: "",
                todo_remark: "",
            },
            tasks: [],
            users: [],
            contact: [],
            errors: "",
        };
    },

    mounted() {
        this.getTasks();
        this.getUsers();
        this.showContact();
    },

    methods: {
        async insertToDo() {
            let contact = this.contact;
            try {
                await axios.post("/api/todos/insert/" + this.$route.params.id, {
                    priority_id: this.form.priority_id === "" ? 2 : 1,
                    user_id: contact.user_id,
                    todo_date: this.form.todo_date,
                    status_id: contact.status_id,
                    type_id: contact.type_id,
                    contact_id: contact.id,
                    task_id: this.form.task_id,
                    todo_remark: this.form.todo_remark,
                    source_id: 1,
                });
                console.log(this.form.todo_date)
                await this.$router.push({
                    name: "todo_index",
                    params: {
                        selectedDate: this.form.todo_date,
                    },
                });
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

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

        getTasks() {
            axios
                .get("/api/tasks/index")
                .then((res) => {
                    this.tasks = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getUsers() {
            axios
                .get("/api/users/index")
                .then((res) => {
                    this.users = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    components: { GoBack },
};
</script>
<!-- <script>
import { reactive } from "vue";
import toDoComposables from "../composables/todos";
import { onMounted } from "vue";
import GoBack from "../utils/GoBack.vue";

export default {
    props: {
        id: {
            required: true,
            type: String,
        },
    },

    setup(props) {
        const form = reactive({
            priority_id: "",
            user_id: "",
            contact_id: "",
            type_id: "",
            status_id: "",
            todo_date: "",
            task_id: "",
            remark: "",
        });

        // const errors = ref('')

        const {
            errors,
            storeToDo,

            getUsers,
            users,

            getTasks,
            tasks,

            getContact,
            contact,
        } = toDoComposables();

        onMounted(getTasks);
        onMounted(getUsers);
        onMounted(getContact(props.id));

        const insertToDo = async (id) => {
            await storeToDo({ ...form });
        };

        return {
            form,
            // errors,
            insertToDo,
            contact,
            tasks,
            users,
        };
    },

    components: {
        GoBack,
    },
};
</script> -->
