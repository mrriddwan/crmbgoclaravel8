<template>
    <div class="mx-auto">
        <GoBack />

        <span v-for="info in contact" :key="info.id">
            <h3
                class="mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-900 md:text-2xl lg:text-2xl text-center"
            >
                Company History - {{ info.name }}
            </h3>
            <div
                v-if="info.todo.length !== 0"
                class="overflow-x-auto relative shadow-md sm:rounded-lg"
            >
                <table
                    class="border-2 mb-4 w-full text-sm text-left text-gray-500 dark:text-gray-400"
                >
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                    >
                        <tr class="text-center">
                            <th scope="col" class="py-3 px-6">Date</th>
                            <th scope="col" class="py-3 px-6">CS</th>
                            <th scope="col" class="py-3 px-6">Task</th>
                            <th scope="col" class="py-3 px-6">Action</th>
                            <th scope="col" class="py-3 px-6">Remark</th>
                            <th scope="col" class="py-3 px-6"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="history in info.todo"
                            :key="history.id"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 text-gray-900 font-bold"
                        >
                            <td class="py-4 px-6">{{ history.todo_created }}</td>
                            <td class="py-4 px-6">{{ history.user.name }}</td>
                            <td class="py-4 px-6">{{ history.task.name }}</td>
                            <td class="py-4 px-6">Action</td>
                            <td class="py-4 px-6">{{ history.remark }}</td>
                            <td class="py-4 px-6">View in To Do</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div v-else class="">
                <h3
                    class="mx-auto font-serif border-5 border-grey-900 mb-4 text-xl font-extrabold tracking-tight leading-none text-gray-700 md:text-2xl lg:text-2xl text-center bg-slate-500 py-5 px-2 rounded-md uppercase w-max"
                >
                    No History data
                </h3>
            </div>
        </span>
    </div>
</template>

<script>
import GoBack from "../utils/GoBack.vue";

export default {
    components: { GoBack },

    data() {
        return {
            info: "",
            contact: [],
        };
    },

    mounted() {
        this.getContact();
    },

    methods: {
        getContact() {
            axios
                .get("/api/contacts/info/" + this.$route.params.id)
                .then((res) => {
                    this.contact = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
