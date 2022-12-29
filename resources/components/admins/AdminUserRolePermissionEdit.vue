<template>
    <div>
        <!-- Main modal -->
        <div
            id="authentication-modal"
            aria-hidden="true"
            class="h-screen bg-gray-200/50 overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center md:h-full md:inset-0"
        >
            <div
                class="absolute px-10 py-10 w-full max-w-md h-full md:h-auto max-h-96 my-auto mx-auto"
            >
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-gray-700 w-max py-5 px-5 inset-0"
                >
                    <div class="flex justify-end p-2">
                        <button
                            @click.prevent="closeModal"
                            type="button"
                            class="text-gray-500 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
                            data-modal-toggle="authentication-modal"
                        >
                            <svg
                                class="w-5 h-5"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                        </button>
                    </div>
                    <form
                        class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8"
                        @submit.prevent="updateUserRole(current_role)"
                    >
                        <h3
                            class="text-xl font-medium text-slate-900 uppercase"
                        >
                            Change Role
                        </h3>
                        <div v-if="user_permission_errors">
                            <div
                                v-for="(v, k) in user_permission_errors"
                                :key="k"
                            >
                                <p
                                    v-for="error in v"
                                    :key="error"
                                    class="text-xs text-red-500 rounded font-bold mb-1 shadow-lg py-2 px-4 pr-0 w-max"
                                >
                                    {{ error }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <label
                                for="name"
                                class="block mb-2 text-sm text-center first-line:font-medium text-slate-900 dark:text-slate-400"
                                >User Role</label
                            >
                            <div
                                class="form-group"
                                v-for="user in current_user_role_permissions"
                                :key="user.id"
                            >
                                <div
                                    v-for="role in user.roles"
                                    :key="role.id"
                                    v-if="user.roles.length !== 0"
                                >
                                    <select
                                        class="w-full text-center w-fullrounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        @change="getRoles"
                                        v-model="current_role"
                                    >
                                        <option disabled value="">
                                            Please select a role
                                        </option>

                                        <option
                                            v-for="role in roles"
                                            :key="role.id"
                                            :value="role.name"
                                        >
                                            {{ role.name }}
                                        </option>
                                    </select>
                                </div>
                                <div v-else>
                                    <select
                                        class="w-full text-center w-fullrounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        @change="getRoles"
                                        v-model="current_role"
                                    >
                                        <option disabled value="">
                                            Please select a role
                                        </option>

                                        <option
                                            v-for="role in roles"
                                            :key="role.id"
                                            :value="role.name"
                                        >
                                            {{ role.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Update
                        </button>
                    </form>
                    <form
                        class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8"
                        @submit.prevent="
                            addPermissionDirecttoUser(selectedPermission)
                        "
                    >
                        <h3
                            class="text-xl font-medium text-slate-900 uppercase"
                        >
                            Add Permission
                        </h3>
                        <div v-if="user_permission_errors">
                            <div
                                v-for="(v, k) in user_permission_errors"
                                :key="k"
                            >
                                <p
                                    v-for="error in v"
                                    :key="error"
                                    class="text-xs text-red-500 rounded font-bold mb-1 shadow-lg py-2 px-4 pr-0 w-max"
                                >
                                    {{ error }}
                                </p>
                            </div>
                        </div>
                        <div>
                            <label
                                for="name"
                                class="text-center block mb-2 text-sm font-medium text-slate-900 dark:text-slate-400"
                                >Permission</label
                            >

                            <div
                                class="text-xs text-center h-max w-full align-top"
                            >
                                <v-select
                                    label="name"
                                    :options="permissions"
                                    :reduce="(name) => name.id"
                                    v-model="selectedPermission"
                                    multiple
                                    class="vue_select"
                                    placeholder="Select permission"
                                ></v-select>
                            </div>

                            <!-- <div
                                class="form-group"
                                v-for="user in current_user_role_permissions"
                                :key="user.id"
                            >   
                                <select
                                    class="w-full text-center w-fullrounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    @change="getPermissions"
                                    v-model="selectedPermission"
                                >
                                    <option disabled value="">
                                        Please select a permission
                                    </option>

                                    <option
                                        v-for="permission in permissions"
                                        :key="permission.id"
                                        :value="permission.name"
                                    >
                                        {{ permission.name }}
                                    </option>
                                </select>
                            </div> -->
                        </div>
                        <button
                            type="submit"
                            class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        >
                            Add
                        </button>
                    </form>

                    <div class="container items-center text-center my-10">
                        <table class="w-full table-bordered">
                            <thead class="bg-slate-400">
                                <th>Role</th>
                                <th>Permissions Via Roles</th>
                                <th>Direct Permissions</th>
                            </thead>
                            <tbody>
                                <tr
                                    v-for="user in current_user_role_permissions"
                                    :key="user.id"
                                    class="py-3"
                                >
                                    <td class="text-xs">
                                        <div
                                            v-for="role in user.roles"
                                            :key="role.id"
                                            class="px-1 py-1 bg-green-300 rounded-md w-max flex"
                                        >
                                            {{ role.name }}
                                        </div>
                                    </td>

                                    <!-- Via Role - Permission -->
                                    <td class="text-xs w-max">
                                        <div
                                            v-for="role in user.roles"
                                            :key="role.id"
                                            class="grid grid-cols-3 gap-2 py-2 px-1"
                                        >
                                            <div
                                                v-for="permission in role.permissions"
                                                :key="permission.id"
                                                class="px-1 py-1 bg-purple-400 rounded-md w-max flex"
                                            >
                                                {{ permission.name }}
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Direct Permission -->
                                    <td>
                                        <div
                                            v-for="permission in user.permissions"
                                            :key="permission.id"
                                            class="px-1 py-1 bg-cyan-400 rounded-md w-max flex text-xs m-2"
                                        >
                                            {{ permission.name }}
                                            <div class="w-max text-center mx-2">
                                                <button
                                                    @click="
                                                        removeDirectPermissionFromUser(
                                                            user.id,
                                                            permission.id
                                                        )
                                                    "
                                                    class="align-middle border-1 border-black w-max rounded-md bg-red-300 px-2"
                                                >
                                                    <TrashIcon
                                                        class="inline h-4 w-4"
                                                    />
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { PencilSquareIcon, TrashIcon } from "@heroicons/vue/24/solid";
import axios from "axios";

export default {
    props: ["user_id"],

    components: {
        TrashIcon,
    },

    created() {
        console.log("This is the user id: " + this.$props.user_id);
    },

    data() {
        return {
            permissions: [],
            selectedPermission: "",

            user_permission_errors: "",
            current_role: "",
            current_user_role_permissions: [],
            roles: [],
        };
    },

    mounted() {
        this.getCurrentUserRolePermissions(this.$props.user_id);
        this.getPermissions();
        this.getRoles();
    },

    methods: {
        closeModal() {
            console.log(this.$props.user_id);
            this.getCurrentUserRolePermissions(this.$props.user_id);
            this.$emit("toggle-modal");
        },

        async addPermissionDirecttoUser() {
            try {
                await axios.post(
                    "/api/admin/roles/user/update/permission/" +
                        this.$props.user_id,
                    {
                        user_id: this.$props.role_id,
                        permission_name: this.selectedPermission,
                    }
                );
                (this.selectedPermission = ""),
                    this.getCurrentUserRolePermissions(this.$props.user_id);
                alert("Added permission in selected user.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async updateUserRole(current_role) {
            try {
                await axios.put(
                    "/api/admin/roles/user/update/" + this.$props.user_id,
                    {
                        user_id: this.$props.user_id,
                        role_name: current_role,
                    }
                );
                this.getCurrentUserRolePermissions();
                alert("Updated role in selected user.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
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

        async getCurrentUserRolePermissions(user_id) {
            await axios
                .get("/api/admin/users/role_permissions/" + user_id)
                .then((res) => {
                    this.current_user_role_permissions = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async removeDirectPermissionFromUser(user_id, permission_id) {
            try {
                if (!window.confirm("Are you sure?")) {
                    return;
                } else {
                    // console.log("this is the user_id: " + user_id);
                    // console.log("this is the permission_id: " + permission_id);
                    await axios
                        .post("/api/admin/users/remove/permission/" + user_id, {
                            user_id: user_id,
                            permission_id: permission_id,
                        })
                        .then((res) => {});
                }
                alert("Removed permission from user.");
                this.getCurrentUserRolePermissions(this.$props.user_id);
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
<style>
.vue_select {
    background-color: rgb(255, 255, 255);
    border-radius: 0.375rem;
    font-size: smaller;
    font-style: normal;
}
</style>
