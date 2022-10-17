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

                <div class="grid grid-cols-2 gap-10">
                    <!-- Create User-->
                    <form
                        class="grid grid-cols-1 mt-2"
                        @submit.prevent="createUser"
                    >
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
                        <div class="form-group row">
                            <label
                                for="name"
                                class="col-md-4 col-form-label text-md-right"
                                >Name</label
                            >

                            <div class="col-md-6">
                                <input
                                    v-model="new_user.name"
                                    id="name"
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    required
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label
                                for="email"
                                class="col-md-4 col-form-label text-md-right"
                                >Email</label
                            >

                            <div class="col-md-6">
                                <input
                                    v-model="new_user.email"
                                    id="email"
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    required
                                />

                                <!-- @error('password') -->
                                <!-- <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> -->
                                <!-- @enderror -->
                            </div>
                        </div>
                        <!-- <div class="text-md text-center">Password</div> -->
                        <div class="form-group row">
                            <label
                                for="password"
                                class="col-md-4 col-form-label text-md-right"
                                >Password</label
                            >

                            <div class="col-md-6">
                                <input
                                    v-model="new_user.password"
                                    id="password"
                                    type="password"
                                    class="form-control"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                />

                                <!-- @error('password') -->
                                <!-- <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span> -->
                                <!-- @enderror -->
                            </div>
                        </div>

                        <div class="form-group row">
                            <label
                                for="password"
                                class="col-md-4 col-form-label text-md-right"
                                >Confirm Password</label
                            >

                            <div class="col-md-6">
                                <input
                                    v-model="new_user.confirm_password"
                                    id="password_confirmation"
                                    type="password"
                                    class="form-control"
                                    name="password_confirmation"
                                    required
                                    autocomplete="current-password"
                                />
                            </div>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-1"
                        >
                            <button
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
                    </form>

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

                <div v-if="category_errors">
                    <div v-for="(v, k) in category_errors" :key="k">
                        <p
                            v-for="error in v"
                            :key="error"
                            class="text-xs bg-red-500 text-white rounded font-bold mb-1 shadow-lg py-2 px-4 pr-0 w-max"
                        >
                            {{ error }}
                        </p>
                    </div>
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
                                    v-model="new_category"
                                    type="text"
                                    class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-2"
                        >
                            <button
                                @click="createUserCategory()"
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
                                @click="deleteItem(deleteCategory)"
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
                                <option value="">Please select user</option>

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
                                @click="
                                    updateUserCategory(this.selectedCategory)
                                "
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
                                Assign User Category
                            </p>
                        </span>
                    </div>

                    <div class="grid grid-cols-4 gap-5">
                        <table
                            v-for="user_category in category_list"
                            :key="user_category.id"
                            class="table-auto table-bordered text-center"
                        >
                            <thead class="bg-slate-500 border-b px-2 py-2">
                                <th class="text-amber-200 uppercase text-xs">
                                    {{ user_category.name }}
                                </th>
                                <th class="text-center align-middle">
                                    <button
                                        @click="toggleAddModal(user_category.id)"
                                        class="border-1 border-black w-max rounded-md bg-green-300 px-2 py-2"
                                    >
                                        <UserPlusIcon class="inline h-4 w-4" />
                                    </button>
                                    <!-- <button
                                        @click="toggleAddModal(user_category.id)"
                                        class="border-1 border-black w-max rounded-md bg-green-300 px-2 py-2"
                                    >
                                        <UserPlusIcon class="inline h-4 w-4" />
                                    </button> -->
                                </th>
                            </thead>

                            <tbody
                                v-if="user_category.user.length !== 0"
                                v-for="user_info in user_category.user"
                                :key="user_info.id"
                            >
                                <tr class="">
                                    <td
                                        class="w-max text-center align-middle px-2 py-2"
                                    >
                                        {{ user_info.name }}
                                    </td>
                                    <td class="w-max text-center">
                                        <button
                                            @click="createUser()"
                                            class="align-middle border-1 border-black w-max rounded-md bg-red-300 px-2"
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
                

                <AdminUserCategoryAssign
                    v-if="isAddVisibility"
                    @toggle-modal="toggleAddModal()"
                />

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

                    <div class="grid grid-cols-4 gap-5 mx-2 text-xs">
                        <table
                            v-for="user_category in benchmarks"
                            :key="user_category.id"
                            class="table-auto table-bordered"
                        >
                            <thead class="bg-slate-500 border-b">
                                <th
                                    class="py-2 px-2 text-amber-200 uppercase text-xs"
                                >
                                    {{ user_category.cat_name }}
                                </th>
                                <th class="py-2 px-2 text-white">Target</th>
                                <th
                                    class="container w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="createUser()"
                                        class="border-1 border-black w-max rounded-md bg-blue-300 px-2"
                                    >
                                        <PlusIcon class="inline h-4 w-4" />
                                        <p
                                            class="inline uppercase font-bold text-xs h-1"
                                        >
                                            Target
                                        </p>
                                    </button>
                                </th>

                                <th></th>
                            </thead>

                            <tbody
                                v-if="user_category.benchmark.length !== 0"
                                v-for="benchmark in user_category.benchmark"
                                :key="benchmark.id"
                            >
                                <tr>
                                    <td class="w-max text-center align-middle">
                                        {{ benchmark.task.name }}
                                    </td>
                                    <td class="w-max text-center align-middle">
                                        {{ benchmark.task_target }}
                                    </td>
                                    <td class="w-max text-center">
                                        <button
                                            @click="createUser()"
                                            class="border-1 border-black w-max rounded-md bg-yellow-300 px-2"
                                        >
                                            <PencilIcon
                                                class="inline h-4 w-4"
                                            />
                                        </button>
                                        <button
                                            @click="createUser()"
                                            class="align-middle border-1 border-black w-max rounded-md bg-red-300 px-2"
                                        >
                                            <TrashIcon class="inline h-4 w-4" />
                                        </button>
                                    </td>
                                </tr>
                            </tbody>

                            <tbody v-else>
                                <tr>
                                    <td colspan="3" class="text-center">
                                        No Benchmark
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- User List-->
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

                <div class="container items-center text-center">
                    <table class="w-full">
                        <thead>
                            <th>User Name</th>
                            <th>User Password</th>
                            <th>User Level</th>
                            <th>User Email</th>
                        </thead>
                        <tbody>
                            <tr v-for="user in users">
                                <td>{{ user.name }}</td>
                                <td>*****</td>
                                <td>Admin / User</td>
                                <td>{{ user.email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment";
import AdminUserCategoryAssign from "../admins/AdminUserCategoryAssign.vue";

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
        AdminUserCategoryAssign,
    },

    data() {
        return {
            moment: moment,
            selectedUser: "",
            selectedCategory: "",
            deleteCategory: "",

            isAddVisibility: false,

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

            benchmarks: [],

            user: [],
            actions: [],
            users: [],
            errors: "",
            category_errors: "",
        };
    },

    mounted() {
        this.getTasks();
        this.getUsers();
        this.getUserCategories();
        this.getUserCategoryList();
        this.getBenchmarks();
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
        toggleAddModal() {
            this.isAddVisibility = !this.isAddVisibility;
            this.getUsers();
        },

        async createUser() {
            try {
                await axios.post("/api/admin/users/create", {
                    name: this.new_user.name,
                    email: this.new_user.email,
                    password: this.new_user.password,
                    confirm_password: this.new_user.confirm_password,
                });
                this.new_user.name = "";
                this.new_user.email = "";
                this.new_user.password = "";
                this.new_user.confirm_password = "";
                (this.errors = ""), this.getUsers();
                alert("Created new user.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async updateUser(value) {
            try {
                if (value === this.edit_user.name) {
                    await axios.put(
                        "/api/admin/users/update/" + this.selectedUser,
                        {
                            name: this.edit_user.name,
                        }
                    );
                    (this.errors = ""),
                        (this.edit_user.name = this.edit_user.name);
                    alert("Updated user name.");
                } else if (value === this.edit_user.password) {
                    await axios.put(
                        "/api/admin/users/update/" + this.selectedUser,
                        {
                            password: this.edit_user.password,
                            confirm_password: this.edit_user.confirm_password,
                        }
                    );
                    (this.errors = ""), (this.edit_user.password = "");
                    this.edit_user.confirm_password = "";
                    alert("Updated password.");
                } else {
                    await axios.put(
                        "/api/admin/users/update/" + this.selectedUser,
                        {
                            email: this.edit_user.email,
                            email_password: this.edit_user.email_password,
                        }
                    );
                    (this.errors = ""), (this.edit_user.email_password = "");
                    alert("Updated user email.");
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

        async updateUserCategory(id) {
            try {
                await axios.put("/api/admin/users/category/update/" + id, {
                    name: this.user_category.name,
                });
                this.selectedCategory = "";
                this.user_category.name = "";
                this.getUserCategories();
                alert("Updated user category name.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async createUserCategory() {
            try {
                await axios.post("/api/admin/users/category/create", {
                    name: this.new_category,
                });
                this.new_category = "";
                this.category_errors = "";
                this.getUserCategories();
                this.getUserCategoryList();
                this.getBenchmarks();
                alert("Created new user category.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.category_errors = e.response.data.errors;
                    }
                }
            }
        },

        deleteItem(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            } else {
                if (id === this.deleteCategory) {
                    axios.delete(
                        "/api/admin/users/category/delete/" +
                            this.deleteCategory
                    );
                    this.deleteCategory = "";
                    this.getUserCategories();
                    alert("User Category deleted.");
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

        async getBenchmarks() {
            await axios
                .get("/api/admin/users/category/benchmark")
                .then((res) => {
                    this.benchmarks = res.data.data;
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
