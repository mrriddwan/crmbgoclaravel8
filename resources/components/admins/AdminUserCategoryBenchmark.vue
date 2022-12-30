<template>
    <div>
        <!-- Main modal -->
        <div
            id="authentication-modal"
            aria-hidden="true"
            class="flex h-screen bg-gray-200/50 overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center md:h-full md:inset-0"
        >
            <div class="relative px-10 py-10 w-full max-w-md h-full md:h-auto mx-auto">
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
                        class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8 mx-auto"
                        @submit.prevent="addBenchmark(selectedAction)"
                    >
                        <h3
                            class="text-xl font-medium text-slate-900 uppercase"
                        >
                            Add New Benchmark
                        </h3>
                        <div class="grid grid-cols-2 gap-40">
                            <div class="px-3 text-center">
                                <label
                                    for="name"
                                    class="block mb-2 text-sm font-medium text-slate-900 dark:text-slate-300"
                                    >Action</label
                                >
                                <select
                                    class="form-group text-center w-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    @change="getActions"
                                    v-model="selectedAction"
                                >
                                    <option disabled value="">
                                        Please select action
                                    </option>

                                    <option
                                        v-for="action in actions"
                                        :key="action.id"
                                        :value="action.id"
                                    >
                                        {{ action.name }}
                                    </option>
                                </select>
                            </div>

                            <div class="px-3 text-center">
                                <label
                                    for="name"
                                    class="block mb-2 text-sm font-medium text-slate-900 dark:text-slate-300"
                                    >Target</label
                                >
                                <input
                                    v-model="action_target"
                                    type="number"
                                    class="w-20 form-group block mt-1 text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                />
                            </div>
                        </div>
                        <div class="text-center">
                            <button
                                type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >
                                Add
                            </button>
                        </div>
                    </form>

                    <table class="text-xs mx-auto gap-2">
                        <thead class="bg-slate-800 text-amber-300 py-3">
                            <th class="px-4">Action</th>
                            <th class="px-4">Target</th>
                            <th class="px-4"> </th>
                        </thead>
                        <tbody class="text-xs">
                            <tr v-for="benchmark_action in benchmark_actions" :key="benchmark_action.id">
                                <td class="px-4 py-3">{{ benchmark_action.action }}</td>
                                <td class="px-4 py-3">
                                    <input
                                        v-model="benchmark_action.action_target"
                                        type="number"
                                        class="w-20 form-group block mt-1 text-center text-xs rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    />
                                </td>
                                <td class="px-4 py-3">
                                    <span class="w-max">
                                        <button
                                            @click="
                                                updateTarget(
                                                    benchmark_action.id, benchmark_action.action_target
                                                )
                                            "
                                            class="text-white text-xs px-2 py-2 bg-yellow-400 hover:bg-amber-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg dark:bg-yellow-400 dark:hover:bg-amber-700 dark:focus:ring-amber-800"
                                        >
                                            Update
                                        </button>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: ["user_cat_id"],

    created() {
        console.log(this.$props.user_cat_id);
    },

    data() {
        return {
            actions: [],
            benchmark_actions: [],
            action_target: "",
            selectedAction: "",
        };
    },

    mounted() {
        this.getActions();
        this.getCategoryBenchmark();
    },

    methods: {
        closeModal() {
            this.$emit("toggle-modal");
            this.getBenchmarks();
        },

        async addBenchmark(action_id) {
            try {
                await axios.post("/api/admin/benchmarks/create", {
                    user_cat_id: this.$props.user_cat_id,
                    action_id: action_id,
                    action_target: this.action_target,
                });
                this.getCategoryBenchmark();
                alert("Target created for the user category.");
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
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

        async getCategoryBenchmark() {
            await axios
                .get(
                    "/api/admin/benchmarks/category/" + this.$props.user_cat_id
                )
                .then((res) => {
                    this.benchmark_actions = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async updateTarget(benchmark_id, action_target){
            try {
                await axios.put("/api/admin/benchmarks/target/update/" + benchmark_id, {
                    action_target: action_target,
                });
                this.getBenchmarks();
                alert("Target updated for the user category.");
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
