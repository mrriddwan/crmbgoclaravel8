<template>
    <div>
        <!-- Main modal -->
        <div
            id="authentication-modal"
            aria-hidden="true"
            class="flex h-screen bg-gray-200/50 overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center md:h-full md:inset-0"
        >
            <div class="relative px-4 w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-gray-700"
                >
                    <div class="flex justify-end p-2">
                        <button
                            @click.prevent="closeModal"
                            type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white"
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
                        @submit.prevent="
                            addPermissionToRole(selectedPermission)
                        "
                    >
                        <h3
                            class="text-xl font-medium text-slate-900 uppercase"
                        >
                            Add Permission
                        </h3>
                        <div v-if="errors">
                            <div v-for="(v, k) in errors" :key="k">
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
                                class="block mb-2 text-sm font-medium text-slate-900 dark:text-slate-400"
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
                            <!-- <div class="form-group">
                                <select
                                    class="text-center w-fullrounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["role_id"],

    created() {
        console.log("This is the role_id: " + this.$props.role_id);
    },

    data() {
        return {
            permissions: [],
            selectedPermission: [],
            errors: "",
        };
    },

    mounted() {
        this.getPermissions();
    },

    methods: {
        closeModal() {
            this.getRolePermissions();
            this.$emit("toggle-modal");
        },

        async addPermissionToRole() {
            try {
                await axios.post(
                    "/api/admin/roles/add/permission/" + this.$props.role_id,
                    {
                        role_id: this.$props.role_id,
                        permission_name: this.selectedPermission,
                    }
                );
                this.getRolePermissions();
                alert("Added permission in selected Role.");
                this.closeModal();
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
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

        async getRolePermissions() {
            await axios
                .get("/api/admin/roles/permissions")
                .then((res) => {
                    this.role_permissions = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
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