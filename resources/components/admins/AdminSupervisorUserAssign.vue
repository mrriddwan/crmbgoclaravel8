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
                        @submit.prevent="addUserForSupervisor(selectedUser)"
                    >
                        <h3
                            class="text-xl font-medium text-slate-900 uppercase"
                        >
                            Add New User
                        </h3>
                        <div>
                            <label
                                for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                >User</label
                            >
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
    props: [
        'sv_id'
    ],

    created(){
        console.log("this is the supervisor id:" + this.$props.sv_id)
    },

    data() {
        return {
            users: [],
            selectedUser: "",
        };
    },

    mounted() {
        this.getUsers();
    },

    methods: {
        closeModal() {
            this.getSupervisorUser(this.$props.sv_id);
            this.$emit("toggle-modal");
        },

        async addUserForSupervisor(sv_id) {
            try {
                await axios.post(
                    "/api/admin/supervisors/users/add",
                    {
                        supervisor_id: this.$props.sv_id,
                        subordinate_id: this.selectedUser,
                    }
                )      
                ;
                this.getSupervisorUser(sv_id);
                alert("Added new user for chosen supervisor.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        async getSupervisorUser(sv_id) {
            await axios
                .get("/api/admin/supervisors/users/" + sv_id)
                .then((res) => {
                    this.supervisor_users = res.data.data[0];
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
    },
};
</script>
