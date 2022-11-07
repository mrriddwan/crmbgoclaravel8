<template>
    <div class="container w-max align-center mx-auto h-max px-3 py-3">
        <div>
            <GoBack />
        </div>

        <div
            class="items-center text-center text-white bg-slate-600 px-2 py-2 rounded-md"
        >
            <h1
                class="font-extrabold uppercase px-2 py-1 bg-black-50 font-mono"
            >
                Create To Do (Internal)
            </h1>
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
                <form @submit.prevent="createToDo">
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
                            v-model="form.user_id"
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
                    <div class="form-group w-max">
                        <label
                            >Date of Task
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <div class="">
                            <VueDatePicker
                                v-model="form.todo_date"
                                showNowButton
                                nowButtonLabel="Today"
                                :enableTimePicker="false"
                                :format="format"
                            />
                        </div>
                    </div>
                    <div class="form-group w-max">
                        <label
                            >Date of Deadline
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <div class="">
                            <VueDatePicker
                                v-model="form.todo_deadline"
                                showNowButton
                                nowButtonLabel="Today"
                                :enableTimePicker="false"
                                :format="format"
                            />
                        </div>
                    </div>

                    <div class="form-group">
                        <label
                            >Status
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.status_id"
                            @change="getStatuses"
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
                            >Contact
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <div class="h-max-10">
                            <select
                                class="overflow-y block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.contact_id"
                                @change="getContacts"
                            >
                                <option disabled value="">
                                    Please select one
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
                    </div>

                    <div class="form-group">
                        <label
                            >Type
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.type_id"
                            @change="getTypes"
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
                        <div v-if="form.todo_remark.length >= 800" class="text-red-600 inline text-xs uppercase">
                            Exceeded limit
                        </div>
                        <textarea
                            maxlength="800"
                            type="text"
                            class="block mt-1 w-96 h-40 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="form.todo_remark"
                        />
                    </div>

                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 mt-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Create
                    </button>

                    <!-- <h1
                        v-for="contact in contacts"
                        :key="info.id"
                        :value="info.id"
                    >
                        <h1>here is {{ info.name }}</h1>
                    </h1> -->
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive } from "vue";
import contactComposables from "../composables/contacts";
import toDoComposables from "../composables/todos";
import { onMounted } from "vue";
import GoBack from "../utils/GoBack.vue";
import { ref } from "vue";
import { VueDatePicker } from "@vuepic/vue-datepicker";
import moment from "moment";

export default {
    setup() {
        let priority_id = ref(2);
        // let color_id = ref(3);
        const date = ref(new Date());
        const format = (date) => {
            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();

            return `${day}-${month}-${year}`;
        };

        const form = reactive({
            priority_id: "",
            user_id: "",
            contact_id: "",
            type_id: "",
            status_id: "",
            todo_date: "",
            todo_deadline: "",
            task_id: "",
            todo_remark: "",
            color_id: 1,
            source_id: 3,
        });

        const {
            getUsers,
            users,
            getContacts,
            contacts,
            getStatuses,
            statuses,
            getCategories,
            categories,
            getTypes,
            types,
        } = contactComposables();

        const { getTasks, tasks, storeToDo, errors } = toDoComposables();

        onMounted(getUsers);
        onMounted(getStatuses);
        onMounted(getTypes);
        onMounted(getContacts);
        onMounted(getTasks);
        onMounted(getCategories);

        const createToDo = async () => {
            await storeToDo({ ...form });
        };

        return {
            form,
            errors,
            createToDo,
            contacts,
            tasks,
            users,
            statuses,
            categories,
            types,
            priority_id,
            format,
            date,
        };
    },

    components: {
        GoBack,
        VueDatePicker,
    },
};
</script>

<!-- <style scoped>
.select-wrapper {
    height: 50px;
    overflow-y: visible;
}

.select {
    width: 100%;
    /* make it min-height*/
    min-height: 50px;
    border-radius: 25px;
    border-color: #555;
    padding: 10px;
}
</style> -->

<!-- 
<script>
import GoBack from "../utils/GoBack.vue";
import axios from "axios";

export default {
    data() {
        return {
            form: {
                priority_id: '',
                user_id: '',
                date_created: '',
                task_id: '',
                remark: '',
            },
            tasks: [],
        };
    },

    mounted() {
        // this.getStatus();
    },

    methods: {
        insertToDo() {
            axios
                .post("/api/contacts/store", {
                    type_id: this.form.type_id,
                    industry: this.form.industry,
                    status_id: this.form.status_id,
                    name: this.form.name,
                    category_id: this.form.category_id,
                    address: this.form.address,
                    remark: this.form.remark,
                })
                .then((res) => {
                    this.$router.push({ name: "contact_index" });
                });
        },

        getTasks() {
            axios
                .get("/api/todotasks/index")
                .then((res) => {
                    this.tasks = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
    components: { GoBack },
};
</script> -->
