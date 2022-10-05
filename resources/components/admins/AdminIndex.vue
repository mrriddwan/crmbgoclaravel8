<template>
    <div class="container">
        <div
            class="bg-slate-600 px-2 py-1 rounded-md flex w-full justify-center items-center row"
        >
            <h1
                class="text-center text-white px-8 uppercase w-max font-mono font-extrabold"
            >
                Admin Panel
            </h1>
        </div>
        <div>
            <div class="my-4">
                <div
                    class="bg-blue-200 px-2 py-1 rounded-md flex w-full justify-center items-center row"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        Contact
                    </h2>
                </div>

                <div
                    class="grid grid-cols-2 gap-2 text-center align-items-center"
                >
                    <div
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-lg w-full justify-center items-center row"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Contact Product
                            </h3>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="grid grid-rows-2 grid-cols-1">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form.contact_category"
                                    />
                                </div>
                                <div>
                                    <button
                                        @click="
                                            createItem(form.contact_category)
                                        "
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.contact_category"
                                    >
                                        <option disabled value="">
                                            Please select one
                                        </option>
                                        <option
                                            v-for="contact_category in contact_categories"
                                            :key="contact_category.id"
                                            :value="contact_category.id"
                                        >
                                            {{ contact_category.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="items-center">
                                    <button
                                        @click="
                                            deleteItem(admin.contact_category)
                                        "
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-md w-full justify-center items-center row"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Contact Status
                            </h3>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="grid grid-rows-2 grid-cols-1">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form.contact_status"
                                    />
                                </div>
                                <div>
                                    <button
                                        @click="createItem(form.contact_status)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.contact_status"
                                    >
                                        <option disabled value="">
                                            Please select one
                                        </option>
                                        <option
                                            v-for="contact_status in contact_statuses"
                                            :key="contact_status.id"
                                            :value="contact_status.id"
                                        >
                                            {{ contact_status.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="items-center">
                                    <button
                                        @click="
                                            deleteItem(admin.contact_status)
                                        "
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-md w-full justify-center items-center row"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Contact Type
                            </h3>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="grid grid-rows-2 grid-cols-1">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form.contact_type"
                                    />
                                </div>
                                <div>
                                    <button
                                        @click="createItem(form.contact_type)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.contact_type"
                                    >
                                        <option disabled value="">
                                            Please select one
                                        </option>
                                        <option
                                            v-for="contact_type in contact_types"
                                            :key="contact_type.id"
                                            :value="contact_type.id"
                                        >
                                            {{ contact_type.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="items-center">
                                    <button
                                        @click="deleteItem(admin.contact_type)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-lg w-full justify-center items-center row"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Contact Industry
                            </h3>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="grid grid-rows-2 grid-cols-1">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form.contact_industry"
                                    />
                                </div>
                                <div>
                                    <button
                                        @click="
                                            createItem(form.contact_industry)
                                        "
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.contact_industry"
                                    >
                                        <option disabled value="">
                                            Please select one
                                        </option>
                                        <option
                                            v-for="contact_industry in contact_industries"
                                            :key="contact_industry.id"
                                            :value="contact_industry.id"
                                        >
                                            {{ contact_industry.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="items-center">
                                    <button
                                        @click="
                                            deleteItem(admin.contact_industry)
                                        "
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div>
                <h3>Text Color</h3>
            </div> -->
            </div>

            <div class="my-4">
                <div
                    class="bg-purple-200 px-2 py-1 rounded-md flex w-full justify-center items-center row"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        To Do
                    </h2>
                </div>

                <div
                    class="grid grid-cols-2 gap-2 text-center align-items-center"
                >
                    <div
                        class="grid grid-cols-1 mt-2 bg-slate-300 px-2 py-1 rounded-lg w-full justify-center items-center row"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">Task</h3>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="grid grid-rows-2 grid-cols-1">
                                <!-- <div>
                                        <label>New Contact Product</label>
                                    </div> -->
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form.todo_task"
                                    />
                                </div>
                                <div>
                                    <button
                                        @click="createItem(form.todo_task)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <!-- <div>
                                        
                                    </div> -->

                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.todo_task"
                                    >
                                        <option disabled value="">
                                            Please select one
                                        </option>
                                        <option
                                            v-for="todo_task in todo_tasks"
                                            :key="todo_task.id"
                                            :value="todo_task.id"
                                        >
                                            {{ todo_task.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="items-center">
                                    <button
                                        @click="deleteItem(admin.todo_task)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-md w-full justify-center items-center row"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Action
                            </h3>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="grid grid-rows-2 grid-cols-1">
                                <!-- <div>
                                        <label>New Contact Product</label>
                                    </div> -->
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form.todo_action"
                                    />
                                </div>
                                <div>
                                    <button
                                        @click="createItem(form.todo_action)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <!-- <div>
                                        
                                    </div> -->

                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.todo_action"
                                    >
                                        <option disabled value="">
                                            Please select one
                                        </option>
                                        <option
                                            v-for="todo_action in todo_actions"
                                            :key="todo_action.id"
                                            :value="todo_action.id"
                                        >
                                            {{ todo_action.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="items-center">
                                    <button
                                        @click="deleteItem(admin.todo_action)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div>
                <h3>Text Color</h3>
            </div> -->
            </div>

            <div class="my-4">
                <div
                    class="bg-cyan-200 px-2 py-1 rounded-md flex w-full justify-center items-center row"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        Forecast
                    </h2>
                </div>

                <div
                    class="grid grid-cols-2 gap-2 text-center align-items-center"
                >
                    <div
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-lg w-full justify-center items-center row"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Forecast Product
                            </h3>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="grid grid-rows-2 grid-cols-1">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form.forecast_product"
                                    />
                                </div>
                                <div>
                                    <button
                                        @click="
                                            createItem(form.forecast_product)
                                        "
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.forecast_product"
                                    >
                                        <option disabled value="">
                                            Please select one
                                        </option>
                                        <option
                                            v-for="forecast_product in forecast_products"
                                            :key="forecast_product.id"
                                            :value="forecast_product.id"
                                        >
                                            {{ forecast_product.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="items-center">
                                    <button
                                        @click="
                                            deleteItem(admin.forecast_product)
                                        "
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-md w-full justify-center items-center row"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Forecast Type
                            </h3>
                        </div>

                        <div class="grid grid-cols-2">
                            <div class="grid grid-rows-2 grid-cols-1">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form.forecast_type"
                                    />
                                </div>
                                <div>
                                    <button
                                        @click="createItem(form.forecast_type)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Add
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.forecast_type"
                                    >
                                        <option disabled value="">
                                            Please select one
                                        </option>
                                        <option
                                            v-for="forecast_type in forecast_types"
                                            :key="forecast_type.id"
                                            :value="forecast_type.id"
                                        >
                                            {{ forecast_type.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="items-center">
                                    <button
                                        @click="deleteItem(admin.forecast_type)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-red-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div>
                <h3>Text Color</h3>
            </div> -->
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
                contact_category: "",
                contact_status: "",
                contact_type: "",
                contact_industry: "",
                todo_task: "",
                todo_action: "",
                forecast_product: "",
                forecast_type: "",
            },

            admin: {
                contact_category: "",
                contact_status: "",
                contact_type: "",
                contact_industry: "",
                todo_task: "",
                todo_action: "",
                forecast_product: "",
                forecast_type: "",
            },

            contact_types: [],
            contact_categories: [],
            contact_statuses: [],
            contact_industries: [],

            todo_tasks: [],
            todo_actions: [],

            forecast_products: [],
            forecast_types: [],
        };
    },

    created() {
        this.getContactStatuses();
        this.getContactCategories();
        this.getContactTypes();
        this.getContactIndustries();

        this.getToDoTasks();
        this.getToDoActions();

        this.getForecastProducts();
        this.getForecastTypes();
    },

    methods: {
        async getContactIndustries() {
            await axios
                .get("/api/contacts/industry/index")
                .then((res) => {
                    this.contact_industries = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getContactStatuses() {
            await axios
                .get("/api/contacts/status/index")
                .then((res) => {
                    this.contact_statuses = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getContactCategories() {
            await axios
                .get("/api/contacts/category/index")
                .then((res) => {
                    this.contact_categories = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getContactTypes() {
            await axios
                .get("/api/contacts/type/index")
                .then((res) => {
                    this.contact_types = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getForecastTypes() {
            await axios
                .get("/api/forecasts/type/index")
                .then((res) => {
                    this.forecast_types = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getForecastProducts() {
            await axios
                .get("/api/forecasts/product/index")
                .then((res) => {
                    this.forecast_products = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getToDoTasks() {
            await axios
                .get("/api/tasks/index")
                .then((res) => {
                    this.todo_tasks = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getToDoActions() {
            await axios
                .get("/api/actions/index")
                .then((res) => {
                    this.todo_actions = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async createItem(text) {
            if (!window.confirm("Confirm add item?")) {
                return;
            } else {
                try {
                    if (text === this.form.contact_category) {
                        await axios
                            .post("/api/admin/create/contact/category", {
                                name: this.form.contact_category,
                            })
                            .then((res) => {
                                this.form.contact_category = "";
                                this.getContactCategories();
                                alert("Added new contact product.");
                            });
                    } else if (text === this.form.contact_status) {
                        await axios
                            .post("/api/admin/create/contact/status", {
                                name: this.form.contact_status,
                            })
                            .then((res) => {
                                this.form.contact_status = "";
                                this.getContactStatuses();
                                alert("Added new contact status.");
                            });
                    } else if (text === this.form.contact_type) {
                        await axios
                            .post("/api/admin/create/contact/type", {
                                name: this.form.contact_type,
                            })
                            .then((res) => {
                                this.form.contact_type = "";
                                this.getContactTypes();
                                alert("Added new contact type.");
                            });
                    } else if (text === this.form.contact_industry) {
                        await axios
                            .post("/api/admin/create/contact/industry", {
                                name: this.form.contact_industry,
                            })
                            .then((res) => {
                                this.form.contact_industry = "";
                                this.getContactIndustries();
                                alert("Added new contact industry.");
                            });
                    } else if (text === this.form.todo_task) {
                        await axios
                            .post("/api/admin/create/todo/task", {
                                name: this.form.todo_task,
                            })
                            .then((res) => {
                                this.form.todo_task = "";
                                this.getToDoTasks();
                                alert("Added new todo task.");
                            });
                    } else if (text === this.form.todo_action) {
                        await axios
                            .post("/api/admin/create/todo/action", {
                                name: this.form.todo_action,
                            })
                            .then((res) => {
                                this.form.todo_action = "";
                                this.getToDoActions();
                                alert("Added new todo action.");
                            });
                    } else if (text === this.form.forecast_product) {
                        await axios
                            .post("/api/admin/create/forecast/product", {
                                name: this.form.forecast_product,
                            })
                            .then((res) => {
                                this.form.forecast_product = "";
                                this.getForecastProducts();
                                alert("Added new forecast product.");
                            });
                    } else {
                        await axios
                            .post("/api/admin/create/forecast/type", {
                                name: this.form.forecast_type,
                            })
                            .then((res) => {
                                this.form.forecast_type = "";
                                this.getForecastTypes();
                                alert("Added new forecast type.");
                            });
                    }
                } catch (e) {
                    {
                        if (e.response.status === 422) {
                            this.errors = e.response.data.errors;
                        } else {
                            return "no error response";
                        }
                    }
                }
            }
        },

        deleteItem(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            } else {
                if (id === this.admin.contact_category) {
                    axios.delete(
                        "/api/admin/delete/contact/category/" +
                            this.admin.contact_category
                    );
                    this.admin.contact_category = "";
                    alert("Contact Product deleted.");
                    this.getContactCategories();
                } else if (id === this.admin.contact_status) {
                    axios.delete(
                        "/api/admin/delete/contact/status/" +
                            this.admin.contact_status
                    );
                    this.admin.contact_category = "";
                    alert("Contact Status deleted.");
                    this.getContactStatuses();
                } else if (id === this.admin.contact_type) {
                    axios.delete(
                        "/api/admin/delete/contact/type/" +
                            this.admin.contact_type
                    );
                    this.admin.contact_type = "";
                    alert("Contact Type deleted.");
                    this.getContactTypes();
                } else if (id === this.admin.contact_industry) {
                    axios.delete(
                        "/api/admin/delete/contact/industry/" +
                            this.admin.contact_industry
                    );
                    this.admin.contact_industry = "";
                    alert("Contact Industry deleted.");
                    this.getContactIndustries();
                } else if (id === this.admin.todo_task) {
                    axios.delete(
                        "/api/admin/delete/todo/task/" + this.admin.todo_task
                    );
                    this.admin.todo_task = "";
                    alert("To Do Task deleted.");
                    this.getToDoTasks();
                } else if (id === this.admin.todo_action) {
                    axios.delete(
                        "/api/admin/delete/todo/action/" +
                            this.admin.todo_action
                    );
                    this.admin.todo_action = "";
                    alert("To Do Action deleted.");
                    this.getToDoActions();
                } else if (id === this.admin.forecast_product) {
                    axios.delete(
                        "/api/admin/delete/forecast/product/" +
                            this.admin.forecast_product
                    );
                    this.admin.forecast_product = "";
                    alert("Forecast Product deleted.");
                    this.getForecastProducts();
                } else {
                    axios.delete(
                        "/api/admin/delete/forecast/type/" +
                            this.admin.forecast_type
                    );
                    this.admin.forecast_type = "";
                    alert("Forecast Type deleted.");
                    this.getForecastTypes();
                }
            }
        },
    },

    components: { GoBack },
};
</script>
