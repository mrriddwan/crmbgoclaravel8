<template>
    <div class="container">
        <div
            class="bg-slate-600 px-2 py-1 rounded-md flex w-full justify-center items-center row"
        >
            <h1
                class="text-center text-white px-8 uppercase w-max font-mono font-extrabold"
            >
                User Access
            </h1>
        </div>
        <div>
            <!-- Roles section-->
            <div class="my-4">
                <div
                    class="bg-purple-200 px-2 py-1 rounded-md flex w-full justify-center items-center row"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        Roles
                    </h2>
                </div>

                <div v-if="role_errors">
                    <div v-for="(v, k) in role_errors" :key="k">
                        <p
                            v-for="error in v"
                            :key="error"
                            class="text-xs bg-red-500 text-white rounded font-bold mb-1 shadow-lg py-2 px-4 pr-0 w-max"
                        >
                            {{ error }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-4 gap-10">
                    <div class="grid grid-cols-1 mt-2">
                        <div
                            class="container h-max align-middle my-2 text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <UserPlusIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    Roles
                                </p>
                            </span>
                        </div>

                        <!-- Create Roles-->
                        <div class="grid grid-cols-2 py-1">
                            <div>
                                <label>Name</label>
                            </div>
                            <div>
                                <div class="form-group">
                                    <div class="form-group">
                                        <input
                                            v-model="new_role.name"
                                            type="text"
                                            class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label>Description</label>
                            </div>

                            <div class="form-group">
                                <div class="form-group">
                                    <input
                                        v-model="new_role.description"
                                        type="text"
                                        class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    />
                                </div>
                            </div>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-2"
                        >
                            <button
                                @click="createItem(this.new_role)"
                                class="border-1 border-black w-max rounded-md bg-green-300 px-2"
                            >
                                <PlusIcon class="inline h-4 w-4" />
                                <p
                                    class="inline uppercase font-bold text-sm h-1"
                                >
                                    Roles
                                </p>
                            </button>
                        </div>
                    </div>

                    <!-- Edit Roles-->
                    <div class="grid grid-cols-1 mt-3">
                        <div
                            class="container h-max align-middle text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <ListBulletIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    Roles
                                </p>
                            </span>
                        </div>
                        <div class="text-center mt-1">
                            <select
                                class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                @change="getRoles"
                                v-model="selectedRole"
                            >
                                <option value="">Please select a role</option>

                                <option
                                    v-for="role in roles"
                                    :key="role.id"
                                    :value="role.id"
                                >
                                    {{ role.name }}
                                </option>
                            </select>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-3"
                        ></div>
                    </div>

                    <div class="grid grid-cols-1 mt-1">
                        <div class="grid grid-cols-1 mt-1">
                            <div
                                class="container h-max align-middle my-2 text-lg uppercase font-mono text-center"
                            >
                                <span
                                    class="bg-slate-300 w-max py-2 px-2 rounded-md"
                                >
                                    <PencilSquareIcon class="inline h-6 w-6" />
                                    <p class="inline uppercase font-bold h-1">
                                        Permissions
                                    </p>
                                </span>
                            </div>
                            <div class="grid grid-cols-2 py-1">
                                <div>
                                    <label>Name</label>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="edit_role.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label>Description</label>
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        <input
                                            v-model="edit_role.description"
                                            type="text"
                                            class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-2"
                        >
                            <button
                                @click="updateItem(edit_role.name)"
                                class="border-1 border-black w-max rounded-md bg-blue-300 px-2"
                            >
                                <LockClosedIcon class="inline h-4 w-4" />
                                <p
                                    class="inline uppercase font-bold text-sm h-1"
                                >
                                    Roles
                                </p>
                            </button>
                        </div>
                    </div>

                    <!-- Remove Roles-->
                    <div class="grid grid-cols-1 mt-1">
                        <div
                            class="container h-max align-middle my-2 text-lg uppercase font-mono text-center"
                        >
                            <span
                                class="bg-slate-300 w-max py-2 px-2 rounded-md"
                            >
                                <TrashIcon class="inline h-6 w-6" />
                                <p class="inline uppercase font-bold h-1">
                                    Role
                                </p>
                            </span>
                        </div>
                        <div class="text-center">
                            <select
                                class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                @change="getRoles"
                                v-model="deleteRole"
                            >
                                <option disabled value="">
                                    Please select a role
                                </option>

                                <option
                                    v-for="role in roles"
                                    :key="role.id"
                                    :value="role.id"
                                >
                                    {{ role.name }}
                                </option>
                            </select>
                        </div>
                        <div
                            class="container w-max h-max text-center align-middle my-2"
                        >
                            <button
                                @click="deleteItem(deleteRole)"
                                class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                            >
                                <TrashIcon class="inline h-4 w-4" />
                                <p
                                    class="inline uppercase font-bold text-sm h-1"
                                >
                                    Roles
                                </p>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <AdminSupervisorUserAssign
                v-if="rolePermissionAddVisbility"
                @toggle-modal="toggleRolePermissionAdd(role_id)"
                :role_id="rolePermissionAdd"
            />

            <!-- Role Permission List-->
            <div class="my-4">
                <div class="grid grid-cols-1">
                    <div
                        class="container h-max align-middle my-3 text-lg uppercase font-mono text-center"
                    >
                        <span class="bg-slate-300 w-max py-2 px-2 rounded-md">
                            <p class="inline uppercase font-bold h-1">
                                Role and its Permissions
                            </p>
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-5">
                        <table
                            v-for="role in role_permissions"
                            :key="role.id"
                            class="table-auto table-bordered text-center"
                        >
                            <thead class="bg-slate-500 border-b px-2 py-2">
                                <th class="text-amber-200 uppercase text-xs">
                                    {{ role.name }}
                                </th>
                                <th class="text-center align-middle">
                                    <button
                                        @click="
                                            toggleUserAddCategoryModal(role.id)
                                        "
                                        class="border-1 border-black w-max rounded-md bg-green-300 px-2 py-2"
                                    >
                                        <UserPlusIcon class="inline h-4 w-4" />
                                    </button>
                                </th>
                            </thead>

                            <tbody
                                v-if="role.permission.length !== 0"
                                v-for="permission_info in role.permission"
                                :key="permission_info.id"
                            >
                                <tr class="">
                                    <td
                                        class="w-max text-center align-middle px-2 py-2"
                                    >
                                        {{ permission_info.name }}
                                    </td>
                                    <td class="w-max text-center">
                                        <button
                                            @click="
                                                removeUserFromCategory(
                                                    permission_info.id
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
                                    <td colspan="2">No Role(s)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Permissions section-->
                <div
                    class="bg-blue-200 px-2 py-1 rounded-md flex w-full justify-center items-center row"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        Permissions
                    </h2>
                </div>
                <div v-if="permission_errors">
                    <div v-for="(v, k) in permission_errors" :key="k">
                        <p
                            v-for="error in v"
                            :key="error"
                            class="text-xs bg-red-500 text-white rounded font-bold mb-1 shadow-lg py-2 px-4 pr-0 w-max"
                        >
                            {{ error }}
                        </p>
                    </div>
                </div>
                <div class="grid grid-cols-1">
                    <div class="grid grid-cols-4 gap-10">
                        <!-- Create Permission -->
                        <div class="grid grid-cols-1 mt-2">
                            <div
                                class="container h-max align-middle my-1 text-lg uppercase font-mono text-center"
                            >
                                <span
                                    class="bg-slate-300 w-max py-2 px-2 rounded-md"
                                >
                                    <UserPlusIcon class="inline h-6 w-6" />
                                    <p class="inline uppercase font-bold h-1">
                                        Permission
                                    </p>
                                </span>
                            </div>
                            <div class="grid grid-cols-2 py-1">
                                <div>
                                    <label>Name</label>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="new_permission.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label>Description</label>
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        <input
                                            v-model="new_permission.description"
                                            type="text"
                                            class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div
                                class="container w-max h-max text-center align-middle my-2"
                            >
                                <button
                                    @click="createItem(new_permission)"
                                    class="border-1 border-black w-max rounded-md bg-green-300 px-2"
                                >
                                    <PlusIcon class="inline h-4 w-4" />
                                    <p
                                        class="inline uppercase font-bold text-sm h-1"
                                    >
                                        Permission
                                    </p>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 mt-1">
                            <div
                                class="container h-max align-middle my-2 text-lg uppercase font-mono text-center"
                            >
                                <span
                                    class="bg-slate-300 w-max py-2 px-2 rounded-md"
                                >
                                    <ListBulletIcon class="inline h-6 w-6" />
                                    <p class="inline uppercase font-bold h-1">
                                        Permission
                                    </p>
                                </span>
                            </div>

                            <!-- Select Permission-->
                            <div class="text-center">
                                <select
                                    class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    @change="getPermissions"
                                    v-model="selectedPermission"
                                >
                                    <option disabled value="">
                                        Please select permission
                                    </option>

                                    <option
                                        v-for="permission in permissions"
                                        :key="permission.id"
                                        :value="permission.id"
                                    >
                                        {{ permission.name }}
                                    </option>
                                </select>
                            </div>
                            <div
                                class="container w-max h-max text-center align-middle my-2"
                            ></div>
                        </div>

                        <!-- Edit Permission -->

                        <div class="grid grid-cols-1 mt-1">
                            <div
                                class="container h-max align-middle my-2 text-lg uppercase font-mono text-center"
                            >
                                <span
                                    class="bg-slate-300 w-max py-2 px-2 rounded-md"
                                >
                                    <PencilSquareIcon class="inline h-6 w-6" />
                                    <p class="inline uppercase font-bold h-1">
                                        Permissions
                                    </p>
                                </span>
                            </div>
                            <div class="grid grid-cols-2 py-1">
                                <div>
                                    <label>Name</label>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <input
                                                v-model="edit_permission.name"
                                                type="text"
                                                class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            />
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label>Description</label>
                                </div>

                                <div class="form-group">
                                    <div class="form-group">
                                        <input
                                            v-model="
                                                edit_permission.description
                                            "
                                            type="text"
                                            class="block mt-1 w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        />
                                    </div>
                                </div>
                            </div>

                            <div
                                class="container w-max h-max text-center align-middle my-2"
                            >
                                <button
                                    @click="updateItem(edit_permission.name)"
                                    class="border-1 border-black w-max rounded-md bg-blue-300 px-2"
                                >
                                    <LockClosedIcon class="inline h-4 w-4" />
                                    <p
                                        class="inline uppercase font-bold text-sm h-1"
                                    >
                                        Permission
                                    </p>
                                </button>
                            </div>
                        </div>

                        <!-- Remove  Permission -->
                        <div class="grid grid-cols-1 mt-1">
                            <div
                                class="container h-max align-middle my-2 text-lg uppercase font-mono text-center"
                            >
                                <span
                                    class="bg-slate-300 w-max py-2 px-2 rounded-md"
                                >
                                    <TrashIcon class="inline h-6 w-6" />
                                    <p class="inline uppercase font-bold h-1">
                                        Permissions
                                    </p>
                                </span>
                            </div>
                            <div class="text-center">
                                <select
                                    class="text-center w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    @change="getPermissions"
                                    v-model="deletePermission"
                                >
                                    <option disabled value="">
                                        Please select a permission
                                    </option>

                                    <option
                                        v-for="permission in permissions"
                                        :key="permission.id"
                                        :value="permission.id"
                                    >
                                        {{ permission.name }}
                                    </option>
                                </select>
                            </div>
                            <div
                                class="container w-max h-max text-center align-middle my-2"
                            >
                                <button
                                    @click="deleteItem(deletePermission)"
                                    class="border-1 border-black w-max rounded-md bg-red-300 px-2"
                                >
                                    <TrashIcon class="inline h-4 w-4" />
                                    <p
                                        class="inline uppercase font-bold text-sm h-1"
                                    >
                                        Permission
                                    </p>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="container items-center text-center">
                        <table class="w-full table-bordered">
                            <thead class="bg-slate-400">
                                <th>Permission</th>
                                <th>Description</th>
                            </thead>
                            <tbody>
                                <tr v-for="permission in permissions">
                                    <td>{{ permission.name }}</td>
                                    <td>Permission description</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- <AdminUserCategoryAssign
                v-if="userAddCategoryVisibility"
                @toggle-modal="toggleUserAddCategoryModal(user_cat_id)"
                :user_cat_id="userAddCategory"
            />
            -->

            <!-- User List-->
            <div class="my-4">
                <div
                    class="bg-cyan-200 px-2 py-1 rounded-md flex w-full justify-center items-center row"
                >
                    <h2
                        class="text-center text-gray-800 px-8 uppercase w-max font-mono font-extrabold"
                    >
                        User Roles and Permissions
                    </h2>
                </div>
                <div class="text-md text-center mt-3">Select User</div>
                <div class="text-md text-center">
                    <div class="form-group">
                        <select
                            class="text-center w-fullrounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            @change="getUsers"
                            v-model="selectedUser"
                        >
                            <option value="">All</option>

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

                <div class="container items-center text-center my-10">
                    <table class="w-full table-bordered">
                        <thead class="bg-slate-400">
                            <th>User</th>
                            <th>Role</th>
                            <th>Permission</th>
                        </thead>
                        <tbody>
                            <tr
                                v-for="user in user_role_permissions"
                                :key="user.id"
                            >
                                <td>{{ user.name }}</td>
                                <td>{{ user.role }}</td>
                                <td
                                    v-for="permission in user.permissions"
                                    :key="permission.id"
                                >
                                    <span>{{ permission.name }}</span>
                                    <span>User permission</span>
                                    <span>User permission</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <AdminUserCategoryBenchmark
                    v-if="userPermissionAddVisbility"
                    @toggle-modal="toggleUserPermissionAdd(user_id)"
                    :user_id="userPermissionAdd"
                />
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
            selectedRole: "",
            selectedPermission: "",

            new_role: {
                name: "",
                description: "",
            },
            new_permission: {
                name: "",
                description: "",
            },

            edit_role: {
                name: "",
                description: "",
            },
            edit_permission: {
                name: "",
                description: "",
            },

            deleteRole: "",
            deletePermission: "",

            rolePermissionAdd: null,
            rolePermissionAddVisbility: false,
            userPermissionAdd: null,
            userPermissionAddVisbility: false,

            users: [],
            roles: [],
            permissions: [],
            role_permissions: [],
            user_role_permissions: [],

            user: [],
            actions: [],
            users: [],
            role_errors: "",
            permission_errors: "",
            user_permission_errors: "",
        };
    },

    mounted() {
        this.getUsers();
        this.getRoles();
        this.getPermissions();
        this.getUserRolePermissions();
    },

    watch: {
        selectedUser(value) {
            this.getUserRolePermissions(value);
        },

        selectedRole(value) {
            this.getRole(value);
        },

        selectedPermission(value) {
            this.getPermission(value);
        },
    },

    methods: {
        toggleRolePermissionAdd(role_id) {
            this.rolePermissionAdd = role_id;
            this.rolePermissionAddVisbility = !this.rolePermissionAddVisbility;
            this.getRoles();
        },
        toggleUserPermissionAdd(user_id) {
            this.userPermissionAdd = user_id;
            this.userPermissionAddVisbility = !this.userPermissionAddVisbility;
            this.getUserRolePermissions();
        },

        async createItem(value) {
            try {
                if (value === this.new_role.name) {
                    await axios.post("/api/admin/roles/create", {
                        name: this.new_role.name,
                        description: this.new_role.description,
                    });
                    this.role_errors = "";
                    this.new_role = "";
                    alert("Created new role.");
                } else {
                    await axios.post("/api/admin/permissions/create", {
                        name: this.new_permission.name,
                        description: this.new_permission.description,
                    });
                    this.permission_errors = "";
                    this.new_permission = "";
                    alert("Created new permission.");
                }
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async updateItem(value) {
            try {
                if (value === this.edit_role.name) {
                    await axios.put(
                        "/api/admin/roles/update/" + this.selectedRole,
                        {
                            name: this.edit_role.name,
                            description: this.edit_role.description,
                        }
                    );
                    this.role_errors = "";
                    this.edit_role.name = "";
                    this.edit_role.description = "";
                    alert("Updated selected role.");
                } else {
                    await axios.put(
                        "/api/admin/permissions/update/" +
                            this.selectedPermission,
                        {
                            name: this.edit_permission.name,
                            description: this.edit_permission.description,
                        }
                    );
                    this.permission_errors = "";
                    this.edit_permission.name = "";
                    this.edit_permission.description = "";
                    alert("Updated selected permission.");
                }
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async deleteItem(value) {
            if (!window.confirm("Are you sure?")) {
                return;
            } else {
                if (value === this.deleteRole) {
                    await axios.delete(
                        "/api/admin/roles/delete/" + this.deleteRole
                    );
                    this.deleteRole = "";
                    this.getRoles();
                    alert("Role deleted.");
                } else {
                    await axios.delete(
                        "/api/admin/permissions/delete/" + this.deletePermission
                    );
                    this.deletePermission = "";
                    alert("Permission deleted.");
                    this.getPermissions();
                }
            }
        },

        async getRoles() {
            await axios
                .get("/api/admin/roles/index")
                .then((res) => {
                    this.roles = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getPermissions() {
            await axios
                .get("/api/admin/permissions/index")
                .then((res) => {
                    this.permissions = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getRole(id) {
            await axios
                .get("/api/admin/roles/info/" + id)
                .then((res) => {
                    this.edit_role = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getPermission(id) {
            await axios
                .get("/api/admin/permissions/info/" + id)
                .then((res) => {
                    this.edit_permission = res.data.data;
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

        async getRolePermissions(){
            await axios
                .get("/api/admin/roles/permissions")
                .then((res) => {
                    this.role_permissions = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUserRolePermissions() {
            await axios
                .get("/api/admin/users/role_permissions")
                .then((res) => {
                    this.user_role_permissions = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async removeRole(user_id) {
            try {
                if (!window.confirm("Are you sure?")) {
                    return;
                }
                await axios.delete("/api/admin/roles/delete/" + user_id);

                this.getUserRolePermissions();
                alert("Removed role from user.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async removePermission(user_id) {
            try {
                if (!window.confirm("Are you sure?")) {
                    return;
                }
                await axios.delete("/api/admin/permissions/delete/" + user_id);

                this.getUserRolePermissions();
                alert("Removed permission from user.");
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
