<template>
    <div>
        <!-- Main modal -->
        <div
            id="remark-modal"
            aria-hidden="true"
            class="flex h-screen bg-gray-200/50 overflow-y-auto overflow-x-hidden fixed right-0 left-0 top-4 z-50 justify-center items-center md:h-full md:inset-0"
        >
            <div class="relative px-4 w-full max-w-md h-full md:h-auto">
                <!-- Modal content -->
                <div
                    class="relative bg-white rounded-lg shadow dark:bg-gray-700"
                >
                    <!-- close modal-->
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
                    <!-- content-->
                    <div class="py-1 px-1 mx-auto text-center">
                        <textarea
                            disabled
                            class="text-sm h-max w-full"
                            v-model="project_remark.project_remark"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["project_id"],

    created() {
        console.log("This is the contact_id: " + this.$props.project_id);
    },

    data() {
        return {
            project_remark: [],
        };
    },

    mounted() {
        this.getProjectRemark();
    },

    methods: {
        closeModal() {
            this.$emit("toggle-modal");
        },

        async getProjectRemark() {
            await axios
                .get("/api/projects/remark/" + this.$props.project_id)
                .then((res) => {
                    this.project_remark = res.data.data[0];
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>
