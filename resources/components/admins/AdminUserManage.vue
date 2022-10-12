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
                    <div class="grid grid-cols-1">
                        <div class="text-lg text-center">
                            <h3>Add User</h3>
                        </div>
                        <div class="text-md text-center">Name</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div class="text-md text-center">Email</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div class="text-md text-center">Password</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div class="text-md text-center">Confirm password</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <button
                            class="border-2 w-max rounded-md bg-green-300 px-1 py-1"
                        >
                            Create
                        </button>
                    </div>

                    <!-- Edit User-->
                    <div class="grid grid-cols-1">
                        <div class="text-lg text-center">
                            <h3>Edit User</h3>
                        </div>
                        <div class="text-md text-center">Select User</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <!-- <select
                                        class="w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form2.user_id"
                                        @change="getUsers"
                                    > -->
                                <select
                                    class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                                    <option disabled value="">
                                        Please select user
                                    </option>
                                    <!-- 
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option> -->
                                </select>
                            </div>
                        </div>
                        <div class="text-md text-center">Name</div>
                        <div class="text-md text-center">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <button
                            class="border-2 w-max rounded-md bg-blue-300 px-1 py-1"
                        >
                            Update
                        </button>

                        <div class="grid grid-cols-2 gap-10">
                            <div class="grid grid-cols-1">
                                <div class="text-center">Password</div>
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    />
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="text-center">Confirm Password</div>
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    />
                                </div>
                            </div>
                        </div>
                        <button
                            class="border-2 w-max rounded-md bg-blue-300 px-1 py-1"
                        >
                            Update
                        </button>

                        <div class="grid grid-cols-2 gap-10">
                            <div class="grid grid-cols-1">
                                <div class="text-center">Email</div>
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    />
                                </div>
                            </div>
                            <div class="grid grid-cols-1">
                                <div class="text-center">Email Password</div>
                                <div class="form-group">
                                    <input
                                        type="text"
                                        class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    />
                                </div>
                            </div>
                        </div>
                        <button
                            class="border-2 w-max rounded-md bg-blue-300 px-1 py-1"
                        >
                            Update
                        </button>
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
                    <div class="grid grid-cols-1">
                        <div class="text-lg text-center">
                            <h3>Add Supervisor</h3>
                        </div>
                        <div class="form-group">
                            <!-- <select
                                        class="w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form2.user_id"
                                        @change="getUsers"
                                    > -->
                            <select
                                class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                                <option disabled value="">
                                    Please select user
                                </option>
                                <!-- 
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option> -->
                            </select>
                        </div>
                        <button
                            class="border-2 w-max rounded-md bg-green-300 px-1 py-1"
                        >
                            Create
                        </button>
                    </div>

                    <!-- Remove Supervisor-->
                    <div class="grid grid-cols-1">
                        <div class="text-lg text-center">
                            <h3>Remove Supervisor</h3>
                        </div>
                        <div class="form-group">
                            <!-- <select
                                        class="w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form2.user_id"
                                        @change="getUsers"
                                    > -->
                            <select
                                class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                                <option disabled value="">
                                    Please select user
                                </option>
                                <!-- 
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option> -->
                            </select>
                        </div>
                        <button
                            class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                        >
                            Remove
                        </button>
                    </div>
                </div>

                <!--Edit Supervisor-User -->

                <div class="grid grid-cols-2 gap-10">
                    <div class="grid grid-cols-1">
                        <div class="text-lg text-center">
                            <h3>Select Supervisor</h3>
                        </div>
                        <div class="form-group">
                            <!-- <select
                                        class="w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form2.user_id"
                                        @change="getUsers"
                                    > -->
                            <select
                                class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                                <option disabled value="">
                                    Please select user
                                </option>
                                <!-- 
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option> -->
                            </select>
                        </div>
                    </div>

                    <!-- User List under Supervisor -->
                    <div class="grid grid-cols-1">
                        <div class="text-lg text-center">
                            <h5>User Under Supervision</h5>
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
                    <div class="grid grid-cols-1">
                        <div class="text-lg text-center">
                            <h3>Create Category</h3>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <input
                                    type="text"
                                    class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <button
                            class="border-2 w-max rounded-md bg-green-300 px-1 py-1"
                        >
                            Create
                        </button>
                    </div>

                    <!-- Remove Supervisor-->
                    <div class="grid grid-cols-1">
                        <div class="text-lg text-center">
                            <h3>Remove Category</h3>
                        </div>
                        <div class="form-group">
                            <!-- <select
                                        class="w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form2.user_id"
                                        @change="getUsers"
                                    > -->
                            <select
                                class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                                <option disabled value="">
                                    Please select user
                                </option>
                                <!-- 
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option> -->
                            </select>
                        </div>
                        <button
                            class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                        >
                            Remove
                        </button>
                    </div>
                </div>

                <!--Edit User-Category -->

                <div class="grid grid-cols-2 gap-10">
                    <div class="grid grid-cols-1">
                        <div class="text-lg text-center">
                            <h3>Select Category</h3>
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <!-- <select
                                        class="w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="form2.user_id"
                                        @change="getUsers"
                                    > -->
                                <select
                                    class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                                    <option disabled value="">
                                        Please select user
                                    </option>
                                    <!-- 
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option> -->
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Remove Supervisor-->
                    <div class="grid grid-cols-1">
                        <div class="text-lg text-center">
                            <h3>Edit Category</h3>
                        </div>
                        <div class="form-group">
                            <input
                                type="text"
                                class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            />
                        </div>
                        <button
                            class="border-2 w-max rounded-md bg-blue-300 px-1 py-1"
                        >
                            Update
                        </button>
                    </div>
                </div>

                <!-- Assign Category-->
                <div class="grid grid-cols-1">
                    <div class="text-lg text-center">
                        <h3>Category Assign</h3>
                    </div>

                    <div class="grid grid-cols-4">
                        <div class="grid grid-cols-2">
                            <div>Sales</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-green-300 px-1 py-1"
                                >
                                    Add User
                                </button>
                            </div>
                            <div>User 1</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                >
                                    Remove
                                </button>
                            </div>
                            <div>User 2</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div>Project</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-green-300 px-1 py-1"
                                >
                                    Add User
                                </button>
                            </div>
                            <div>User 1</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                >
                                    Remove
                                </button>
                            </div>
                            <div>User 2</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div>Internal</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-green-300 px-1 py-1"
                                >
                                    Add User
                                </button>
                            </div>
                            <div>User 1</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                >
                                    Remove
                                </button>
                            </div>
                            <div>User 2</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div>Media</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-green-300 px-1 py-1"
                                >
                                    Add User
                                </button>
                            </div>
                            <div>User 1</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                >
                                    Remove
                                </button>
                            </div>
                            <div>User 2</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                >
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Category benchmark-->
                <div class="grid grid-cols-1">
                    <div class="text-lg text-center">
                        <h3>Category Benchmark</h3>
                    </div>

                    <div class="grid grid-cols-4 gap-10">
                        <div class="grid grid-cols-2">
                            <div>Sales</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-blue-300 px-1 py-1"
                                >
                                    Set Target
                                </button>
                            </div>
                            <div>Task 1</div>
                            <div class="grid grid-cols-3">
                                <div>10</div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-yellow-300 px-1 py-1"
                                    >
                                        Edit
                                    </button>
                                </div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                            <div>Task 2</div>
                            <div class="grid grid-cols-3">
                                <div>50</div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-yellow-300 px-1 py-1"
                                    >
                                        Edit
                                    </button>
                                </div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                            <div>Task 3</div>
                            <div class="grid grid-cols-3">
                                <div>100</div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-yellow-300 px-1 py-1"
                                    >
                                        Edit
                                    </button>
                                </div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div>Project</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-blue-300 px-1 py-1"
                                >
                                    Set Target
                                </button>
                            </div>
                            <div>Task 1</div>
                            <div class="grid grid-cols-3">
                                <div>10</div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-yellow-300 px-1 py-1"
                                    >
                                        Edit
                                    </button>
                                </div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                            <div>Task 2</div>
                            <div class="grid grid-cols-3">
                                <div>50</div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-yellow-300 px-1 py-1"
                                    >
                                        Edit
                                    </button>
                                </div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                            <div>Task 3</div>
                            <div class="grid grid-cols-3">
                                <div>100</div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-yellow-300 px-1 py-1"
                                    >
                                        Edit
                                    </button>
                                </div>
                                <div>
                                    <button
                                        class="border-2 w-max rounded-md bg-red-300 px-1 py-1"
                                    >
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2">
                            <div>Internal</div>
                            <div>
                                <button
                                    class="border-2 w-max rounded-md bg-blue-300 px-1 py-1"
                                >
                                    Set Target
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

                <div >
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
