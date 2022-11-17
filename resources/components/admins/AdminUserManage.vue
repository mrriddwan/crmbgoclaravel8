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
                        class="grid grid-cols-1 mt-2 gap-y-5"
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
                                >User Name</label
                            >

                            <div class="col-md-6">
                                <input
                                    v-model="new_user.name"
                                    id="name"
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    required
                                    placeholder="eg: Telesales 2"
                                />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label
                                for="email"
                                class="col-md-4 col-form-label text-md-right"
                                >User ID - Email</label
                            >

                            <div class="col-md-6">
                                <input
                                    v-model="new_user.email"
                                    id="email"
                                    type="email"
                                    class="form-control"
                                    name="email"
                                    required
                                    placeholder="eg: telesales2@bluedale.com.my"
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
                                        Select user to edit
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
                        <div v-if="selectedUser">
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
                                    <div class="text-center">
                                        Confirm Password
                                    </div>
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
                                    <div class="text-center">
                                        Email Password
                                    </div>
                                    <div class="form-group">
                                        <input
                                            v-model="edit_user.email_password"
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

                <div v-if="supervisor_errors">
                    <div v-for="(v, k) in supervisor_errors" :key="k">
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
                    <!--Create Supervisor -->
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
                                v-model="add_supervisor"
                            >
                                <option disabled value="">
                                    Select user to add
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
                                @click="createSupervisor()"
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
                                @change="getSupervisors"
                                v-model="deleteSupervisor"
                            >
                                <option disabled value="">
                                    Select supervisor to remove
                                </option>

                                <option
                                    v-for="supervisor in supervisors"
                                    :key="supervisor.id"
                                    :value="supervisor.id"
                                >
                                    {{ supervisor.sv_name }}
                                </option>
                            </select>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-2"
                        >
                            <button
                                @click="deleteItem(deleteSupervisor)"
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
                                @change="getSupervisors"
                                v-model="selectedSupervisor"
                            >
                                <option disabled value="">
                                    Select supervisor to edit
                                </option>

                                <option
                                    v-for="supervisor in supervisors"
                                    :key="supervisor.id"
                                    :value="supervisor.id"
                                >
                                    {{ supervisor.sv_name }}
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
                        <div
                            class="grid grid-cols-4"
                            v-if="selectedSupervisor"
                            v-for="supervisor in supervisor_users"
                        >
                            <button
                                @click="
                                    toggleUserSupervisorAdd(supervisor.user_id)
                                "
                                class="border-1 border-black w-max rounded-md bg-green-300 px-2 py-2"
                            >
                                <UserPlusIcon class="inline h-4 w-4" />
                            </button>
                            <div
                                class="text-sm text-center flex"
                                v-if="supervisor.users.length !== 0"
                                v-for="supervisor_user in supervisor.users"
                            >
                                <span
                                    class="bg-blue-300 px-2 py-2 font-bold rounded-md h-max"
                                    >{{
                                        supervisor_user.subordinate.name
                                    }}</span
                                >
                                <span>
                                    <div
                                        class="container w-max h-max text-center align-middle my-2"
                                    >
                                        <button
                                            @click="
                                                removeUserFromSupervisor(
                                                    supervisor_user.id
                                                )
                                            "
                                            class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                                        >
                                            <TrashIcon class="inline h-4 w-4" />
                                        </button>
                                    </div>
                                </span>
                            </div>
                            <div v-else class="text-sm text-center">
                                <h3
                                    class="bg-blue-300 px-2 py-2 font-bold font-mono text-sm uppercase rounded-md"
                                >
                                    No users
                                </h3>
                            </div>
                        </div>
                        <div v-else class="text-sm text-center">
                            <h3
                                class="bg-blue-300 px-2 py-2 font-bold font-mono text-sm uppercase rounded-md"
                            >
                                Select supervisor
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <AdminSupervisorUserAssign
                v-if="supervisorUserAddVisbility"
                @toggle-modal="toggleUserSupervisorAdd(sv_id)"
                :sv_id="supervisorUserAdd"
            />

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
                    <!-- Add Category -->
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
                                    placeholder="Enter new user category"
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

                    <!-- Remove Category-->
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
                                <option value="">Select user to remove</option>

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
                                <option value="">
                                    Select user category to edit
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
                        <div v-if="selectedCategory">
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
                                        updateUserCategory(
                                            this.selectedCategory
                                        )
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
                </div>

                <!-- Assign Category-->
                <div class="grid grid-cols-1">
                    <div
                        class="container h-max align-middle my-3 text-lg uppercase font-mono text-center"
                    >
                        <span class="bg-slate-300 w-max py-2 px-2 rounded-md">
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
                                        @click="
                                            toggleUserAddCategoryModal(
                                                user_category.id
                                            )
                                        "
                                        class="border-1 border-black w-max rounded-md bg-green-300 px-2 py-2"
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
                                <tr class="">
                                    <td
                                        class="w-max text-center align-middle px-2 py-2"
                                    >
                                        {{ user_info.name }}
                                    </td>
                                    <td class="w-max text-center">
                                        <button
                                            @click="
                                                removeUserFromCategory(
                                                    user_info.id
                                                )
                                            "
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
                    v-if="userAddCategoryVisibility"
                    @toggle-modal="toggleUserAddCategoryModal(user_cat_id)"
                    :user_cat_id="userAddCategory"
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
                                    class="w-max h-max text-center align-middle"
                                >
                                    <button
                                        @click="
                                            toggleBenchmarkAdd(user_category.id)
                                        "
                                        class="w-max px-2 py-2"
                                    >
                                        <span
                                            class="w-max bg-yellow-300 px-2 py-1"
                                        >
                                            <PencilIcon
                                                class="inline h-4 w-4"
                                            />
                                        </span>
                                        <span
                                            class="w-max bg-green-300 px-2 py-1"
                                        >
                                            <PlusIcon class="inline h-4 w-4" />
                                        </span>
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
                                        {{ benchmark.action.name }}
                                    </td>
                                    <td class="w-max text-center align-middle">
                                        {{ benchmark.action_target }}
                                    </td>
                                    <td class="w-max text-center">
                                        <button
                                            @click="
                                                removeUserFromCategory(
                                                    benchmark.id
                                                )
                                            "
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

            <AdminUserCategoryBenchmark
                v-if="benchmarkAddVisbility"
                @toggle-modal="toggleBenchmarkAdd(user_cat_id)"
                :user_cat_id="benchmarkAdd"
            />

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
                                <td>{{ user.password }}</td>
                                <td>{{ user.roles[0].name }}</td>
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
import AdminUserCategoryBenchmark from "./AdminUserCategoryBenchmark.vue";
import AdminSupervisorUserAssign from "./AdminSupervisorUserAssign.vue";

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
        AdminUserCategoryBenchmark,
        AdminSupervisorUserAssign,
    },

    data() {
        return {
            moment: moment,
            selectedUser: "",
            selectedCategory: "",
            selectedSupervisor: "",
            deleteCategory: "",
            deleteSupervisor: "",
            add_supervisor: "",

            userAddCategory: null,
            userAddCategoryVisibility: false,
            benchmarkAdd: null,
            benchmarkAddVisbility: false,
            supervisorUserAdd: null,
            supervisorUserAddVisbility: false,

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
            supervisor_users: [],

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
            supervisor_errors: "",
        };
    },

    mounted() {
        this.getTasks();
        this.getActions();
        this.getUsers();
        this.getUserCategories();
        this.getUserCategoryList();
        this.getBenchmarks();
        this.getSupervisors();
    },

    watch: {
        selectedUser(value) {
            this.getUserInfo(value);
        },

        selectedCategory(value) {
            this.getUserCategory(value);
        },

        selectedSupervisor(value) {
            this.getSupervisorUser(value);
        },
    },

    methods: {
        toggleUserAddCategoryModal(user_cat_id) {
            this.userAddCategory = user_cat_id;
            this.userAddCategoryVisibility = !this.userAddCategoryVisibility;
            this.getUserCategoryList();
        },
        toggleBenchmarkAdd(user_cat_id) {
            this.benchmarkAdd = user_cat_id;
            this.benchmarkAddVisbility = !this.benchmarkAddVisbility;
            this.getBenchmarks();
        },
        toggleUserSupervisorAdd(sv_id) {
            this.supervisorUserAdd = sv_id;
            this.supervisorUserAddVisbility = !this.supervisorUserAddVisbility;
            this.getSupervisorUser(this.selectedSupervisor);
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

                    // this.errors = "";

                    // this.edit_user.password = "";
                    // this.edit_user.confirm_password = "";
                    // this.edit_user.email = "";
                    // this.edit_user.email_password = "";
                    this.getUsers();
                    // this.selectedUser = ""; //this will cause the undefined.name error
                    this.edit_user.name = "";
                    alert("Updated user name.");
                } else if (value === this.edit_user.password) {
                    await axios.put(
                        "/api/admin/users/update/" + this.selectedUser,
                        {
                            password: this.edit_user.password,
                            confirm_password: this.edit_user.confirm_password,
                        }
                    );
                    this.errors = "";
                    this.edit_user.name = "";
                    this.edit_user.password = "";
                    this.edit_user.confirm_password = "";
                    this.edit_user.email = "";
                    this.edit_user.email_password = "";
                    // this.selectedUser = "";
                    alert("Updated password.");
                } else {
                    await axios.put(
                        "/api/admin/users/update/" + this.selectedUser,
                        {
                            email: this.edit_user.email,
                            email_password: this.edit_user.email_password,
                        }
                    );
                    this.errors = "";
                    this.edit_user.name = "";
                    this.edit_user.password = "";
                    this.edit_user.confirm_password = "";
                    this.edit_user.email = "";
                    this.edit_user.email_password = "";
                    // this.selectedUser = "";
                    alert("Updated user email.");
                }
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

        async createSupervisor() {
            try {
                await axios.post("/api/admin/supervisors/create", {
                    user_id: this.add_supervisor,
                });
                this.add_supervisor = "";
                this.supervisor_errors = "";
                this.getSupervisors();

                alert("Created new supervisor.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.supervisor_errors = e.response.data.errors;
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
                } else {
                    axios.delete(
                        "/api/admin/supervisors/delete/" + this.deleteSupervisor
                    );
                    this.deleteSupervisor = "";
                    alert("User removed from supervisor list.");
                    this.getSupervisors();
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

        async getActions() {
            await axios
                .get("/api/actions/index")
                .then((res) => {
                    this.actions = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUsers() {
            await axios
                .get("/api/users/manage_list")
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

        async getSupervisors() {
            await axios
                .get("/api/admin/supervisors/index")
                .then((res) => {
                    this.supervisors = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getSupervisorUser(sv_id) {
            await axios
                .get("/api/admin/supervisors/users/" + sv_id)
                .then((res) => {
                    this.supervisor_users = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async removeUserFromCategory(benchmark_id) {
            try {
                if (!window.confirm("Are you sure?")) {
                    return;
                }
                await axios.delete(
                    "/api/admin/benchmarks/delete/" + benchmark_id
                );

                this.getBenchmarks();
                alert("Removed action target from user category.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async removeTarget(benchmark_id) {
            try {
                await axios.put("/api/admin/users/remove/category/" + user_id, {
                    user_cat_id: null,
                });

                this.getUserCategoryList();
                alert("Removed user from category.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async removeUserFromSupervisor(pivot_id) {
            try {
                if (!window.confirm("Are you sure?")) {
                    return;
                }
                await axios.delete(
                    "/api/admin/supervisors/users/remove/" + pivot_id
                );

                this.getSupervisorUser(this.selectedSupervisor);
                alert("Removed user from selected supervisor.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },
    },
};
</script>
