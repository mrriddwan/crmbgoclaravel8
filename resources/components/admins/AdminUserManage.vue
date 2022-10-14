<template>
    <div class="container">
        <div
            class="bg-slate-600 px-2 py-1 rounded-md flex w-full justify-center items-center row"
        >
            <h1
                class="text-center text-white px-8 uppercase w-max font-mono font-extrabold"
            >
                User Management
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
                        User
                    </h2>
                </div>

                <div class="grid grid-cols-2 gap-10">
                    <div class="grid grid-cols-1 mt-2">
                        <div
                            class="container h-max align-middle my-1 text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <UserPlusIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    User
                                </p>
                            </span>
                        </div>
                        <div class="text-md text-center">Name</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <input
                                    v-model="new_user.name"
                                    type="text"
                                    class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div class="text-md text-center">Email</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <input
                                    v-model="new_user.email"
                                    type="text"
                                    class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div class="text-md text-center">Password</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <input
                                    v-model="new_user.password"
                                    type="text"
                                    class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div class="text-md text-center">Confirm password</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <input
                                    v-model="new_user.confirm_password"
                                    type="text"
                                    class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-1"
                        >
                            <button
                                @click="createUser()"
                                class="border-1 border-black w-max rounded-md bg-green-300 px-2"
                            >
                                <PlusIcon class="inline h-4 w-4" />
                                <p
                                    class="inline uppercase font-bold text-sm h-1"
                                >
                                    User
                                </p>
                            </button>
                        </div>
                    </div>

                    <!-- Edit User-->
                    <div class="my-2">
                        <div
                            class="container h-max align-middle my-1 text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <PencilSquareIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    User
                                </p>
                            </span>
                        </div>

                        <div class="text-md text-center mt-3">Select User</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <select
                                    class="text-center w-fullrounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    @change="getUsers"
                                    v-model="selectedUser"
                                >
                                    <option disabled value="">
                                        Please select user
                                    </option>

                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="text-md text-center mt-2">Name</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <input
                                    v-model="edit_user.name"
                                    type="text"
                                    class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-1"
                        >
                            <button
                                @click="updateUser(edit_user.name)"
                                class="border-1 border-black w-max rounded-md bg-blue-300 px-1"
                            >
                                <LockClosedIcon class="inline h-4 w-4" />
                                <p
                                    class="inline uppercase font-semibold text-xs h-1"
                                >
                                    Name
                                </p>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-10">
                            <div class="grid grid-cols-1">
                                <div class="text-center">Password</div>
                                <div class="form-group">
                                    <input
                                        v-model="edit_user.password"
                                        type="password"
                                        class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    />
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="text-center">Confirm Password</div>
                                <div class="form-group">
                                    <input
                                        v-model="edit_user.confirm_password"
                                        type="password"
                                        class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    />
                                </div>
                            </div>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-1"
                        >
                            <button
                                @click="updateUser(edit_user.password)"
                                class="border-1 border-black w-max rounded-md bg-blue-300 px-1"
                            >
                                <LockClosedIcon class="inline h-4 w-4" />
                                <p
                                    class="text-center inline uppercase font-semibold text-xs h-1"
                                >
                                    Password
                                </p>
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-10">
                            <div class="grid grid-cols-1">
                                <div class="text-center">Email</div>
                                <div class="form-group">
                                    <input
                                        v-model="edit_user.email"
                                        type="text"
                                        class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    />
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="text-center">Email Password</div>
                                <div class="form-group">
                                    <input
                                        v-model="edit_user.email_password"
                                        type="text"
                                        class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    />
                                </div>
                            </div>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-1"
                        >
                            <button
                                @click="updateUser(edit_user.email)"
                                class="border-1 border-black w-max rounded-md bg-blue-300 px-1"
                            >
                                <LockClosedIcon class="inline h-4 w-4" />
                                <p
                                    class="inline uppercase font-semibold text-xs h-1"
                                >
                                    Email
                                </p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Supervisor section-->
            <div class="my-4">
                <div
                    class="bg-purple-200 px-2 py-1 rounded-md flex w-full justify-center items-center row"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        Supervisor
                    </h2>
                </div>

                <div class="grid grid-cols-2 gap-10">
                    <div class="grid grid-cols-1 mt-2">
                        <div
                            class="container h-max align-middle my-2 text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <UserPlusIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    Supervisor
                                </p>
                            </span>
                        </div>
                        <div class="text-center">
                            <select
                                class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                @change="getUsers"
                                v-model="selectedUser"
                            >
                                <option disabled value="">
                                    Please select user
                                </option>

                                <option
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.id"
                                >
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-2"
                        >
                            <button
                                @click="createUser()"
                                class="border-1 border-black w-max rounded-md bg-green-300 px-2"
                            >
                                <PlusIcon class="inline h-4 w-4" />
                                <p
                                    class="inline uppercase font-bold text-sm h-1"
                                >
                                    SV
                                </p>
                            </button>
                        </div>
                    </div>

                    <!-- Remove Supervisor-->
                    <div class="grid grid-cols-1 mt-1">
                        <div
                            class="container h-max align-middle my-2 text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <TrashIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    Supervisor
                                </p>
                            </span>
                        </div>
                        <div class="text-center">
                            <select
                                class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                @change="getUsers"
                                v-model="selectedUser"
                            >
                                <option disabled value="">
                                    Please select user
                                </option>

                                <option
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.id"
                                >
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-2"
                        >
                            <button
                                @click="createUser()"
                                class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                            >
                                <TrashIcon class="inline h-4 w-4" />
                                <p
                                    class="inline uppercase font-bold text-sm h-1"
                                >
                                    SV
                                </p>
                            </button>
                        </div>
                    </div>
                </div>

                <!--Edit Supervisor-User -->

                <div class="grid grid-cols-2 gap-10">
                    <div class="grid grid-cols-1 mt-2">
                        <div
                            class="container h-max my-2 align-middle text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <ListBulletIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    Supervisor
                                </p>
                            </span>
                        </div>
                        <div class="text-center">
                            <select
                                class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                @change="getUsers"
                                v-model="selectedUser"
                            >
                                <option disabled value="">
                                    Please select user
                                </option>

                                <option
                                    v-for="user in users"
                                    :key="user.id"
                                    :value="user.id"
                                >
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-2"
                        ></div>
                    </div>

                    <!-- User List under Supervisor -->
                    <div class="grid grid-cols-1 my-1">
                        <div
                            class="container h-max align-middle my-2 text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <PencilSquareIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    Supervision
                                </p>
                            </span>
                        </div>
                        <div class="grid grid-cols-4">
                            <div class="text-sm text-center">
                                <span>User</span>
                            </div>
                            <div class="text-sm text-center">
                                <span>User</span>
                            </div>
                            <div class="text-sm text-center">
                                <span>User</span>
                            </div>
                            <div class="text-sm text-center">
                                <span>User</span>
                            </div>
                            <div class="text-sm text-center">
                                <span>User</span>
                            </div>
                            <div class="text-sm text-center">
                                <span>User</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Category-->
            <div class="my-4">
                <div
                    class="bg-orange-200 px-2 py-1 rounded-md flex w-full justify-center items-center row"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        User Category
                    </h2>
                </div>

                <div class="grid grid-cols-2 gap-10">
                    <div class="grid grid-cols-1 mt-2">
                        <div
                            class="container h-max align-middle my-1 text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <UserPlusIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    Category
                                </p>
                            </span>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-2"
                        >
                            <button
                                @click="createUser()"
                                class="border-1 border-black w-max rounded-md bg-green-300 px-2"
                            >
                                <PlusIcon class="inline h-4 w-4" />
                                <p
                                    class="inline uppercase font-bold text-sm h-1"
                                >
                                    Category
                                </p>
                            </button>
                        </div>
                    </div>

                    <!-- Remove Supervisor-->
                    <div class="grid grid-cols-1 mt-1">
                        <div
                            class="container h-max align-middle my-2 text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <TrashIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    Category
                                </p>
                            </span>
                        </div>
                        <div class="text-center mt-1">
                            <select
                                class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                @change="getUserCategories"
                                v-model="deleteCategory"
                            >
                                <option disabled value="">
                                    Please select user
                                </option>

                                <option
                                    v-for="user_category in user_categories"
                                    :key="user_category.id"
                                    :value="user_category.id"
                                >
                                    {{ user_category.name }}
                                </option>
                            </select>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-2"
                        >
                            <button
                                @click="createUser()"
                                class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                            >
                                <TrashIcon class="inline h-4 w-4" />
                                <p
                                    class="inline uppercase font-bold text-sm h-1"
                                >
                                    Category
                                </p>
                            </button>
                        </div>
                    </div>
                </div>

                <!--Select User-Category -->

                <div class="grid grid-cols-2 gap-10">
                    <div class="grid grid-cols-1 mt-2">
                        <div
                            class="container h-max align-middle text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <ListBulletIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    Category
                                </p>
                            </span>
                        </div>
                        <div class="text-center mt-1">
                            <select
                                class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                @change="getUserCategories"
                                v-model="selectedCategory"
                            >
                                <option disabled value="">
                                    Please select user
                                </option>

                                <option
                                    v-for="user_category in user_categories"
                                    :key="user_category.id"
                                    :value="user_category.id"
                                >
                                    {{ user_category.name }}
                                </option>
                            </select>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-3"
                        ></div>
                    </div>

                    <!--Edit User-Category name-->

                    <div class="grid grid-cols-1 my-2">
                        <div
                            class="container h-max align-middle my-1 text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <PencilSquareIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    Category
                                </p>
                            </span>
                        </div>
                        <div class="form-group">
                            <input
                                v-model="user_category.name"
                                type="text"
                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            />
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-2"
                        >
                            <button
                                @click="createUser()"
                                class="border-1 border-black w-max rounded-md bg-blue-300 px-2"
                            >
                                <LockClosedIcon class="inline h-4 w-4" />
                                <p
                                    class="inline uppercase font-bold text-sm h-1"
                                >
                                    Category
                                </p>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Assign Category-->
                <div class="grid grid-cols-1">
                    <div
                        class="container h-max align-middle my-3 text-lg uppercase font-mono text-center"
                    >
                        <span class="bg-slate-300 w-max py-2 px-2 rounded-md">
                            <!-- <PencilSquareIcon class="inline h-6 w-6" /> -->
                            <p class="inline uppercase font-bold h-1">
                                Set User Category
                            </p>
                        </span>
                    </div>

                    <div class="grid grid-cols-4">
                        <table
                            v-for="user_category in category_list"
                            :key="user_category.id"
                        >
                            <thead>
                                <th>{{ user_category.name }}</th>
                                <th
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-green-300 px-2"
                                    >
                                        <UserPlusIcon class="inline h-4 w-4" />
                                    </button>
                                </th>
                            </thead>

                            <tbody
                                v-if="user_category.user.length !== 0"
                                v-for="user_info in user_category.user"
                                :key="user_info.id"
                            >
                                <tr>
                                    <td>
                                        {{ user_info.name }}
                                    </td>
                                    <td
                                        class="inline-block w-max h-max text-center align-middle"
                                    >
                                        <button
                                            @click="createUser()"
                                            class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                                        >
                                            <TrashIcon class="inline h-4 w-4" />
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                            <tbody v-else>
                                <tr>
                                    <td colspan="2">No User</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Category benchmark-->
                <div class="grid grid-cols-1">
                    <div
                        class="container h-max align-middle my-3 text-lg uppercase font-mono text-center"
                    >
                        <span class="bg-slate-300 w-max py-2 px-2 rounded-md">
                            <!-- <PencilSquareIcon class="inline h-6 w-6" /> -->
                            <p class="inline uppercase font-bold h-1">
                                Set Benchmark Category
                            </p>
                        </span>
                    </div>

                    <div class="grid grid-cols-4 gap-10">
                        <div class="grid grid-cols-2">
                            <div>Sales</div>
                            <div
                                class="container w-max h-max text-center align-middle my-2"
                            >
                                <button
                                    @click="createUser()"
                                    class="border-1 border-black w-max rounded-md bg-blue-300 px-2"
                                >
                                    <PencilIcon class="inline h-4 w-4" />
                                    <p
                                        class="inline uppercase font-bold text-sm h-1"
                                    >
                                        Target
                                    </p>
                                </button>
                            </div>
                            <div>Task 1</div>
                            <div class="grid grid-cols-3">
                                <div>10</div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-amber-300 px-2"
                                    >
                                        <PencilIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                                    >
                                        <TrashIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                            <div>Task 2</div>
                            <div class="grid grid-cols-3">
                                <div>50</div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-amber-300 px-2"
                                    >
                                        <PencilIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                                    >
                                        <TrashIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                            <div>Task 3</div>
                            <div class="grid grid-cols-3">
                                <div>100</div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-amber-300 px-2"
                                    >
                                        <PencilIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                                    >
                                        <TrashIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div>Project</div>
                            <div
                                class="container w-max h-max text-center align-middle my-2"
                            >
                                <button
                                    @click="createUser()"
                                    class="border-1 border-black w-max rounded-md bg-blue-300 px-2"
                                >
                                    <PencilIcon class="inline h-4 w-4" />
                                    <p
                                        class="inline uppercase font-bold text-sm h-1"
                                    >
                                        Target
                                    </p>
                                </button>
                            </div>
                            <div>Task 1</div>
                            <div class="grid grid-cols-3">
                                <div>10</div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-amber-300 px-2"
                                    >
                                        <PencilIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                                    >
                                        <TrashIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                            <div>Task 2</div>
                            <div class="grid grid-cols-3">
                                <div>50</div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-amber-300 px-2"
                                    >
                                        <PencilIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                                    >
                                        <TrashIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                            <div>Task 3</div>
                            <div class="grid grid-cols-3">
                                <div>100</div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-amber-300 px-2"
                                    >
                                        <PencilIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                                <div
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                                    >
                                        <TrashIcon class="inline h-4 w-4" />
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div>Internal</div>
                            <div
                                class="container w-max h-max text-center align-middle my-2"
                            >
                                <button
                                    @click="createUser()"
                                    class="border-1 border-black w-max rounded-md bg-blue-300 px-2"
                                >
                                    <PencilIcon class="inline h-4 w-4" />
                                    <p
                                        class="inline uppercase font-bold text-sm h-1"
                                    >
                                        Target
                                    </p>
                                </button>
                            </div>
                            <div class="col-span-2">No Benchmark</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="my-4">
                <div
                    class="bg-cyan-200 px-2 py-1 rounded-md flex w-full justify-center items-center row"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        User List
                    </h2>
                </div>

                <div class="container items-center">
                    <table class="w-full">
                        <thead>
                            <th>User Name</th>
                            <th>User Password</th>
                            <th>User Level</th>
                            <th>User Email</th>
                        </thead>
                        <tbody>
                            <td>User 1</td>
                            <td>*****</td>
                            <td>Admin</td>
                            <td>admin@gmail.com</td>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";

import {
    PencilSquareIcon,
    TrashIcon,
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
    PlusIcon,
    LightBulbIcon,
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
    PencilIcon,
    ClipboardDocumentCheckIcon,
    LockClosedIcon,
    UserPlusIcon,
    ListBulletIcon,
} from "@heroicons/vue/24/solid";

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
    },

    data() {
        return {
            moment: moment,
            selectedUser: "",
            selectedCategory: "",
            deleteCategory: "",

            new_user: {
                name: "",
                email: "",
                email_password: "",
                password: "",
                confirm_password: "",
            },

            edit_user: {
                name: "",
                email: "",
                password: "",
                confirm_password: "",
            },

            supervisors: [],

            new_category: "",
            user_categories: [],
            category_list: [],
            user_category: {
                id: "",
                name: "",
            },
            user: [],
            actions: [],
            users: [],
            errors: "",
        };
    },

    mounted() {
        this.getTasks();
        this.getUsers();
        this.getUserCategories();
        this.getUserCategoryList();
    },

    watch: {
        selectedUser(value) {
            this.getUserInfo(value);
        },

        selectedCategory(value) {
            this.getUserCategory(value);
        },
    },

    methods: {
        async updateUser(value) {
            try {
                if (value === this.edit_user.name) {
                    await axios.put(
                        "/api/admin/users/update/name/" + this.selectedUser,
                        {
                            name: edit_user.name,
                        }
                    );
                    this.edit_user.name = "";
                } else if (value === this.edit_user.password) {
                    await axios.put(
                        "/api/admin/users/update/password/" + this.selectedUser,
                        {
                            password: edit_user.password,
                            confirm_password: edit_user.confirm_password,
                        }
                    );
                    this.edit_user.password = "";
                    this.edit_user.confirm_password = "";
                } else {
                    await axios.put(
                        "/api/admin/users/update/email/" + this.selectedUser,
                        {
                            email: edit_user.email,
                            email_password: edit_user.email_password,
                        }
                    );
                    this.edit_user.email = "";
                    this.edit_user.email_password = "";
                }

                // await this.$router.push({
                //     name: "todo_index",
                //     params: {
                //         selectedDate: this.form.todo_date,
                //     },
                // });
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async getUserCategories() {
            await axios
                .get("/api/admin/users/category/index")
                .then((res) => {
                    this.user_categories = res.data.data;
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

        async getUserInfo(id) {
            await axios
                .get("/api/admin/users/info/" + id)
                .then((res) => {
                    this.edit_user = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUserCategory(id) {
            await axios
                .get("/api/admin/users/category/info/" + id)
                .then((res) => {
                    this.user_category = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUserCategoryList() {
            await axios
                .get("/api/admin/users/category/user_list")
                .then((res) => {
                    this.category_list = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
