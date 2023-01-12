<template>
    <div class="w-full min-h-screen">
        <div
            class="py-2 rounded-md flex w-full text-center justify-center items-center row mx-auto bg-blue-900"
        >
            <h1
                class="text-center text-white px-8 w-full uppercase font-mono font-extrabold"
            >
                Admin Panel
            </h1>
        </div>
        <!-- <button class="collapsible" @click="openTab">Open Collapsible</button>
        <div class="content">
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                enim ad minim veniam, quis nostrud exercitation ullamco laboris
                nisi ut aliquip ex ea commodo consequat.
            </p>
        </div> -->
        <div>
            <div class="my-4">
                <button
                    @click="revealContent('contact')"
                    class="bg-blue-200 px-2 py-1 rounded-md flex w-full justify-center items-center row mx-auto hover:bg-blue-500"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        Contact
                    </h2>
                </button>
                <div
                    :class="
                        !display_contact
                            ? 'hidden truncate max-h-0'
                            : 'grid grid-cols-1 gap-2 text-center align-items-center h-max:transition h-max:ease-in-out h-max:delay-300'
                    "
                >
                    <div
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-lg w-full justify-center items-center row mx-auto"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Contact Product
                            </h3>
                        </div>

                        <div class="grid grid-cols-4">
                            <!-- Create Contact Product -->
                            <div class="grid grid-rows-2 grid-cols-1 mx-1">
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
                            <!-- Select Contact Product -->
                            <div class="form-group items-center mx-1">
                                <select
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="editContactCategory"
                                >
                                    <option disabled value="">
                                        Select to edit
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

                            <!-- Update Contact Product -->
                            <div class="items-center mx-1">
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="contact_category.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                    <button
                                        @click="
                                            updateItem(contact_category.name)
                                        "
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>

                            <!--Delete Contact Product-->
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.contact_category"
                                    >
                                        <option disabled value="">
                                            Select to edit
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
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-md w-full justify-center items-center row mx-auto"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Contact Status
                            </h3>
                        </div>

                        <div class="grid grid-cols-4">
                            <!-- Create Contact Status -->
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
                            <!-- Select Contact Status -->
                            <div class="form-group items-center mx-1">
                                <select
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="editContactStatus"
                                >
                                    <option disabled value="">
                                        Select to edit
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
                            <!-- Edit Contact Status -->
                            <div class="items-center mx-1">
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="contact_status.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                    <button
                                        @click="updateItem(contact_status.name)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>
                            <!-- Delete Contact Status -->
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.contact_status"
                                    >
                                        <option disabled value="">
                                            Select to delete
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
                        class="grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-md w-full justify-center items-center row mx-auto"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Contact Type
                            </h3>
                        </div>

                        <div class="grid grid-cols-4">
                            <!-- Create Contact Type -->
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

                            <!-- Select Contact Type -->
                            <div class="form-group items-center mx-1">
                                <select
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="editContactType"
                                >
                                    <option disabled value="">
                                        Select to edit
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

                            <!-- Edit Contact Type -->
                            <div class="items-center mx-1">
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="contact_type.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                    <button
                                        @click="updateItem(contact_type.name)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>
                            <!-- Delete Contact Type -->
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.contact_type"
                                    >
                                        <option disabled value="">
                                            Select to delete
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
                        class="grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-lg w-full justify-center items-center row mx-auto"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Contact Industry
                            </h3>
                        </div>

                        <div class="grid grid-cols-4">
                            <!-- Create Contact Industry -->
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
                            <!-- Select Contact Industry-->
                            <div class="form-group items-center mx-1">
                                <select
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="editContactIndustry"
                                >
                                    <option disabled value="">
                                        Select to edit
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
                            <!-- Edit Contact Category -->
                            <div class="items-center mx-1">
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="contact_industry.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                    <button
                                        @click="
                                            updateItem(contact_industry.name)
                                        "
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>
                            <!-- Delete Contact Category -->
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.contact_industry"
                                    >
                                        <option disabled value="">
                                            Select to delete
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
                <button
                    @click="revealContent('todo')"
                    class="bg-purple-200 px-2 py-1 rounded-md flex w-full justify-center items-center row mx-auto hover:bg-purple-400"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        To Do
                    </h2>
                </button>

                <div
                    :class="
                        !display_todo
                            ? 'hidden truncate max-h-0'
                            : 'grid grid-cols-1 gap-2 text-center align-items-center h-max:transition h-max:ease-in-out h-max:delay-300'
                    "
                >
                    <div
                        class="grid grid-cols-1 mt-2 bg-slate-300 px-2 py-1 rounded-lg w-full justify-center items-center row mx-auto"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">Task</h3>
                        </div>

                        <div class="grid grid-cols-4">
                            <!-- Create To Do Task -->
                            <div class="grid grid-rows-2 grid-cols-1">
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
                            <!-- Select To Do Task -->
                            <div class="form-group items-center mx-1">
                                <select
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="editTodoTask"
                                >
                                    <option disabled value="">
                                        Select to edit
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
                            <!-- Edit To Do Task -->
                            <div class="items-center mx-1">
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="todo_task.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                    <button
                                        @click="updateItem(todo_task.name)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>
                            <!-- Delete To Do Task -->
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.todo_task"
                                    >
                                        <option disabled value="">
                                            Select to delete
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
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-md w-full justify-center items-center row mx-auto"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Action
                            </h3>
                        </div>

                        <div class="grid grid-cols-4">
                            <!-- Create To Do Action -->
                            <div class="grid grid-rows-2 grid-cols-1">
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

                            <!-- Select To Do Action -->
                            <div class="form-group items-center mx-1">
                                <select
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="editTodoAction"
                                >
                                    <option disabled value="">
                                        Select to edit
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

                            <div class="items-center mx-1">
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="todo_action.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                    <button
                                        @click="updateItem(todo_action.name)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>
                            <!-- Delete To Do Action -->
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.todo_action"
                                    >
                                        <option disabled value="">
                                            Select to delete
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

                    <div
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-md w-full justify-center items-center row mx-auto"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Text Color
                            </h3>
                        </div>

                        <div class="grid grid-cols-4">
                            <!-- Create Text Color -->
                            <div class="grid grid-rows-2 grid-cols-1">
                                <div class="form-group rounded-md">
                                    <input
                                        type="color"
                                        class="hover:cursor-pointer block h-10 mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form.todo_color"
                                    />
                                    <div>
                                        <span
                                            :style="{ color: form.todo_color }"
                                            >Code: {{ form.todo_color }}</span
                                        >
                                    </div>
                                </div>

                                <div>
                                    <button
                                        @click="createItem(form.todo_color)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Add
                                    </button>
                                </div>
                            </div>

                            <!-- Select Text Color -->
                            <div class="form-group items-center mx-1">
                                <select
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="editColor"
                                >
                                    <option disabled value="">
                                        Select to edit
                                    </option>
                                    <option
                                        v-for="color in colors"
                                        :key="color.id"
                                        :value="color.id"
                                        :style="{ color: color.color_code }"
                                    >
                                        {{ color.color_code }}
                                    </option>
                                </select>
                            </div>
                            <div class="grid grid-rows-2 grid-cols-1">
                                <div class="form-group rounded-md">
                                    <input
                                        type="color"
                                        class="hover:cursor-pointer block h-10 mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="todo_textcolor.color_code"
                                        :style="{
                                            color: todo_textcolor.color_code,
                                        }"
                                    />
                                    <div>
                                        <span
                                            :style="{
                                                color: todo_textcolor.color_code,
                                            }"
                                            >Code:
                                            {{
                                                todo_textcolor.color_code
                                            }}</span
                                        >
                                    </div>
                                </div>

                                <div>
                                    <button
                                        @click="
                                            updateItem(
                                                todo_textcolor.color_code
                                            )
                                        "
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>

                            <!-- Delete Text Color -->
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.todo_textcolor"
                                        @change="getColors"
                                    >
                                        <option disabled value="">
                                            Select to delete
                                        </option>
                                        <option
                                            v-for="color in colors"
                                            :key="color.id"
                                            :value="color.id"
                                            :style="{
                                                color: color.color_code,
                                            }"
                                        >
                                            {{ color.color_code }}
                                        </option>
                                    </select>
                                </div>
                                <div class="items-center">
                                    <button
                                        @click="deleteItem(admin.todo_textcolor)"
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
                <button
                    @click="revealContent('forecast')"
                    class="bg-cyan-200 px-2 py-1 rounded-md flex w-full justify-center items-center row mx-auto hover:bg-cyan-400"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        Forecast
                    </h2>
                </button>

                <div
                    :class="
                        !display_forecast
                            ? 'hidden truncate max-h-0'
                            : 'grid grid-cols-1 gap-2 text-center align-items-center h-max:transition h-max:ease-in-out h-max:delay-300'
                    "
                >
                    <div
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-lg w-full justify-center items-center row mx-auto"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Forecast Product
                            </h3>
                        </div>

                        <div class="grid grid-cols-4">
                            <!-- Create Forecast Product -->
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

                            <!-- Select Forecast Product-->
                            <div class="form-group items-center mx-1">
                                <select
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="editForecastProduct"
                                >
                                    <option disabled value="">
                                        Select to edit
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
                            <!-- Edit Forecast Product -->
                            <div class="items-center mx-1">
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="forecast_product.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                    <button
                                        @click="
                                            updateItem(forecast_product.name)
                                        "
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>
                            <!-- Delete Forecast Product -->
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.forecast_product"
                                    >
                                        <option disabled value="">
                                            Select to delete
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
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-md w-full justify-center items-center row mx-auto"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Forecast Type
                            </h3>
                        </div>

                        <div class="grid grid-cols-4">
                            <!-- Create Forecast Type -->
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
                            <!-- Select Forecast Type -->
                            <div class="form-group items-center mx-1">
                                <select
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="editForecastType"
                                >
                                    <option disabled value="">
                                        Select to edit
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
                            <div class="items-center mx-1">
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="forecast_type.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                    <button
                                        @click="updateItem(forecast_type.name)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Update
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
                                            Select to delete
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

                    <div
                        class="mt-2 grid grid-cols-1 bg-slate-300 px-2 py-1 rounded-md w-full justify-center items-center row mx-auto"
                    >
                        <div colspan="2">
                            <h3 class="uppercase font-bold font-mono">
                                Forecast Result
                            </h3>
                        </div>

                        <div class="grid grid-cols-4">
                            <!-- Create Forecast Result -->
                            <div class="grid grid-rows-2 grid-cols-1">
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form.forecast_result"
                                    />
                                </div>
                                <div>
                                    <button
                                        @click="createItem(form.forecast_result)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-green-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Add
                                    </button>
                                </div>
                            </div>
                            <!-- Select Forecast Result -->
                            <div class="form-group items-center mx-1">
                                <select
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="editForecastResult"
                                >
                                    <option disabled value="">
                                        Select to edit
                                    </option>
                                    <option
                                        v-for="result in results"
                                        :key="result.id"
                                        :value="result.id"
                                    >
                                        {{ result.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="items-center mx-1">
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="forecast_result.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                    <button
                                        @click="updateItem(forecast_result.name)"
                                        type="submit"
                                        class="inline-flex mt-2 items-center px-4 py-2 bg-blue-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        Update
                                    </button>
                                </div>
                            </div>
                            <div class="grid grid-rows-2 grid-cols-1 mx-3">
                                <div class="form-group items-center">
                                    <select
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="admin.forecast_result"
                                    >
                                        <option disabled value="">
                                            Select to delete
                                        </option>
                                        <option
                                            v-for="result in results"
                                            :key="result.id"
                                            :value="result.id"
                                        >
                                            {{ result.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="items-center">
                                    <button
                                        @click="deleteItem(admin.forecast_result)"
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
            </div>
        </div>
    </div>
</template>

<script>
import GoBack from "../utils/GoBack.vue";
import axios from "axios";

var coll = document.getElementsByClassName("collapsible");
var i;

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
                todo_color: "",
                forecast_product: "",
                forecast_type: "",
                forecast_result: "",
            },

            display_contact: false,
            display_todo: false,
            display_forecast: false,

            editContactCategory: "",
            editContactStatus: "",
            editContactType: "",
            editContactIndustry: "",
            editTodoTask: "",
            editTodoAction: "",
            editColor: "",
            editForecastProduct: "",
            editForecastType: "",
            editForecastResult: "",

            contact_category: {
                id: "",
                name: "",
            },
            contact_status: {
                id: "",
                name: "",
            },
            contact_type: {
                id: "",
                name: "",
            },
            contact_industry: {
                id: "",
                name: "",
            },
            todo_task: {
                id: "",
                name: "",
            },
            todo_action: {
                id: "",
                name: "",
            },
            todo_textcolor: {
                id: "",
                color_code: "",
            },
            forecast_product: {
                id: "",
                name: "",
            },
            forecast_type: {
                id: "",
                name: "",
            },
            forecast_result: {
                id: "",
                name: "",
            },

            admin: {
                contact_category: "",
                contact_status: "",
                contact_type: "",
                contact_industry: "",
                todo_task: "",
                todo_action: "",
                todo_textcolor: "",
                forecast_product: "",
                forecast_type: "",
                forecast_result: "",
            },

            userID: "",

            contact_types: [],
            contact_categories: [],
            contact_statuses: [],
            contact_industries: [],

            todo_tasks: [],
            todo_actions: [],
            colors: [],

            forecast_products: [],
            forecast_types: [],
            results: [],
        };
    },

    watch: {
        editContactCategory() {
            this.getContactCategoryInfo();
        },
        editContactStatus() {
            this.getContactStatusInfo();
        },
        editContactType() {
            this.getContactTypeInfo();
        },
        editContactIndustry() {
            this.getContactIndustryInfo();
        },
        editTodoTask() {
            this.getTodoTaskInfo();
        },
        editTodoAction() {
            this.getTodoActionInfo();
        },
        editForecastProduct() {
            this.getForecastProductInfo();
        },
        editForecastType() {
            this.getForecastTypeInfo();
        },
        editColor(){
            this.getTextColorInfo();
        },
        editForecastResult(){
            this.getForecastResultInfo();
        }
    },

    created() {
        this.getUserID();
        this.getContactStatuses();
        this.getContactCategories();
        this.getContactTypes();
        this.getContactIndustries();

        this.getToDoTasks();
        this.getToDoActions();
        this.getColors();

        this.getForecastProducts();
        this.getForecastTypes();
        this.getResults();
    },

    methods: {
        openTab() {
            for (i = 0; i < coll.length; i++) {
                coll[i].addEventListener("click", function () {
                    this.classList.toggle("active");
                    var content = this.nextElementSibling;
                    if (content.style.maxHeight) {
                        content.style.maxHeight = null;
                    } else {
                        content.style.maxHeight = content.scrollHeight + "px";
                    }
                });
            }
        },

        revealContent(display) {
            if (display === "contact") {
                this.display_contact = !this.display_contact;
            } else if (display === "todo") {
                this.display_todo = !this.display_todo;
            } else {
                this.display_forecast = !this.display_forecast;
            }
        },

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

        async getColors() {
            await axios
                .get("/api/text_colors/index")
                .then((res) => {
                    this.colors = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getResults() {
            await axios
                .get("/api/forecasts/result/list")
                .then((res) => {
                    this.results = res.data.data;
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
                    } else if (text === this.form.todo_color) {
                        await axios
                            .post("/api/admin/create/text_color", {
                                color_code: this.form.todo_color,
                            })
                            .then((res) => {
                                this.form.todo_color = "";
                                this.getColors();
                                alert("Added new text color.");
                            });
                    } else if (text === this.form.forecast_result) {
                        await axios
                            .post("/api/admin/create/forecast/result", {
                                name: this.form.forecast_result,
                            })
                            .then((res) => {
                                this.form.forecast_result = "";
                                this.getResults();
                                alert("Added new forecast result.");
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

        async updateItem(text) {
            if (!window.confirm("Confirm update item?")) {
                return;
            } else {
                try {
                    if (text === this.contact_category.name) {
                        await axios
                            .put(
                                "/api/admin/update/contact/category/" +
                                    this.editContactCategory,
                                {
                                    name: this.contact_category.name,
                                }
                            )
                            .then((res) => {
                                this.contact_category.name = "";
                                this.getContactCategories();
                                this.editContactCategory = "";

                                alert("Contact product updated.");
                            });
                    } else if (text === this.contact_status.name) {
                        await axios
                            .put(
                                "/api/admin/update/contact/status/" +
                                    this.editContactStatus,
                                {
                                    name: this.contact_status.name,
                                }
                            )
                            .then((res) => {
                                this.contact_status.name = "";
                                this.getContactStatuses();
                                this.editContactStatus = "";

                                alert("Contact status updated.");
                            });
                    } else if (text === this.contact_type.name) {
                        await axios
                            .put(
                                "/api/admin/update/contact/type/" +
                                    this.editContactType,
                                {
                                    name: this.contact_type.name,
                                }
                            )
                            .then((res) => {
                                this.contact_type.name = "";
                                this.getContactTypes();
                                this.editContactType = "";

                                alert("Contact type updated.");
                            });
                    } else if (text === this.contact_industry.name) {
                        await axios
                            .put(
                                "/api/admin/update/contact/industry/" +
                                    this.editContactIndustry,
                                {
                                    name: this.contact_industry.name,
                                }
                            )
                            .then((res) => {
                                this.contact_industry.name = "";
                                this.getContactIndustries();
                                this.editContactIndustry = "";

                                alert("Contact industry updated.");
                            });
                    } else if (text === this.todo_task.name) {
                        await axios
                            .put(
                                "/api/admin/update/todo/task/" +
                                    this.editTodoTask,
                                {
                                    name: this.todo_task.name,
                                }
                            )
                            .then((res) => {
                                this.todo_task.name = "";
                                this.getToDoTasks();
                                this.editTodoTask = "";

                                alert("Todo task updated.");
                            });
                    } else if (text === this.todo_action.name) {
                        await axios
                            .put(
                                "/api/admin/update/todo/action/" +
                                    this.editTodoAction,
                                {
                                    name: this.todo_action.name,
                                }
                            )
                            .then((res) => {
                                this.todo_action.name = "";
                                this.getToDoActions();
                                this.editTodoAction = "";

                                alert("Todo action updated.");
                            });
                    } else if (text === this.forecast_product.name) {
                        await axios
                            .put(
                                "/api/admin/update/forecast/product/" +
                                    this.editForecastProduct,
                                {
                                    name: this.forecast_product.name,
                                }
                            )
                            .then((res) => {
                                this.forecast_product.name = "";
                                this.getForecastProducts();
                                this.editForecastProduct = "";

                                alert("Forecast product updated.");
                            });
                    } else if (text === this.todo_textcolor.color_code) {
                        await axios
                            .put(
                                "/api/admin/update/text_color/" +
                                    this.editColor,
                                {
                                    color_code: this.todo_textcolor.color_code,
                                }
                            )
                            .then((res) => {
                                this.todo_textcolor.color_code = "";
                                this.getColors();
                                this.editColor = "";

                                alert("Forecast product updated.");
                            });
                    } else if (text === this.forecast_result.name) {
                        await axios
                            .put(
                                "/api/admin/update/forecast/result/" +
                                    this.editForecastResult,
                                {
                                    name: this.forecast_result.name,
                                }
                            )
                            .then((res) => {
                                this.forecast_result.name = "";
                                this.getResults();
                                this.editForecastResult = "";

                                alert("Forecast result updated.");
                            });
                    } else {
                        await axios
                            .put(
                                "/api/admin/update/forecast/type/" +
                                    this.editForecastType,
                                {
                                    name: this.forecast_type.name,
                                }
                            )
                            .then((res) => {
                                this.forecast_type.name = "";
                                this.getForecastTypes();
                                this.editForecastType = "";

                                alert("Forecast type updated.");
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
                } else if (id === this.admin.todo_textcolor) {
                    axios.delete(
                        "/api/admin/delete/text_color/" +
                            this.admin.todo_textcolor
                    );
                    this.admin.todo_textcolor = "";
                    alert("Text color deleted.");
                    this.getColors();
                } else if (id === this.admin.forecast_result) {
                    axios.delete(
                        "/api/admin/delete/forecast/result/" +
                            this.admin.forecast_result
                    );
                    this.admin.forecast_result = "";
                    alert("Forecast result deleted.");
                    this.getResults();
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

        async getUserID() {
            await axios
                .get("/api/contacts/getuserid")
                .then((res) => {
                    this.userID = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getContactCategoryInfo() {
            await axios
                .get("/api/contacts/category/info/" + this.editContactCategory)
                .then((res) => {
                    this.contact_category = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getContactStatusInfo() {
            await axios
                .get("/api/contacts/status/info/" + this.editContactStatus)
                .then((res) => {
                    this.contact_status = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getContactTypeInfo() {
            await axios
                .get("/api/contacts/type/info/" + this.editContactType)
                .then((res) => {
                    this.contact_type = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getContactIndustryInfo() {
            await axios
                .get("/api/contacts/industry/info/" + this.editContactIndustry)
                .then((res) => {
                    this.contact_industry = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getTodoTaskInfo() {
            await axios
                .get("/api/tasks/info/" + this.editTodoTask)
                .then((res) => {
                    this.todo_task = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getTodoActionInfo() {
            await axios
                .get("/api/actions/info/" + this.editTodoAction)
                .then((res) => {
                    this.todo_action = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getTextColorInfo() {
            await axios
                .get("/api/text_colors/info/" + this.editColor)
                .then((res) => {
                    this.todo_textcolor = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getForecastProductInfo() {
            await axios
                .get("/api/forecasts/product/info/" + this.editForecastProduct)
                .then((res) => {
                    this.forecast_product = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getForecastTypeInfo() {
            await axios
                .get("/api/forecasts/type/info/" + this.editForecastType)
                .then((res) => {
                    this.forecast_type = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        async getForecastResultInfo() {
            await axios
                .get("/api/forecasts/result/info/" + this.editForecastResult)
                .then((res) => {
                    this.forecast_result = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },

    components: { GoBack },
};
</script>

<style>
.collapsible {
    background-color: #777;
    color: white;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
}

.active,
.collapsible:hover {
    background-color: #555;
}

.content {
    padding: 0 18px;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    background-color: #f1f1f1;
}
</style>
