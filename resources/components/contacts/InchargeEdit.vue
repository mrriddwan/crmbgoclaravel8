<template>
    <div class="align-center mx-auto">
        <GoBack />
    </div>

    <div class="max-w-lg">
        <div
            class="container w-max border-4 align-center mx-auto"
            v-if="incharge.length !== 0"
        >
            <div>
                <h1
                    class="items-center text-center text-white font-extrabold bg-slate-600 px-2 py-2 rounded-md"
                >
                    Edit PIC
                </h1>
                <div class="text-left w-full">
                    <!-- <p class="m-5 font-extrabold text-xl text-center uppercase">{{ pic.name }}</p> -->
                    <form @submit.prevent="updatePIC" class="inline-block">
                        <div class="grid grid-cols-2 items-center">
                            <div class="grid grid-cols-2 items-center">
                                <div>
                                    <label class="ml-7">Name</label>
                                </div>
                                <div>
                                    <input
                                        type="text"
                                        class="w-100 items-left rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        v-model="incharge.name"
                                    />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 w-auto items-center">
                                <label class="ml-7">Email</label>
                                <input
                                    type="email"
                                    class="items-left mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="incharge.email"
                                />
                            </div>

                            <div class="grid grid-cols-2 w-auto items-center">
                                <label class="ml-7">Phone No.(Mobile)</label>
                                <input
                                    type="text"
                                    class="items-left mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="incharge.phone_mobile"
                                />
                            </div>

                            <div class="grid grid-cols-2 items-center">
                                <label class="ml-7">Phone No.(Office)</label>
                                <input
                                    type="text"
                                    class="items-left mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="incharge.phone_office"
                                />
                            </div>
                        </div>
                        <div class="text-center">
                            <button
                                type="submit"
                                class="mt-4 px-2 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 item"
                            >
                                Save
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div v-else>
            <div>
                <h3>No PIC data</h3>
            </div>
        </div>
    </div>
</template>

<script>
import GoBack from "../utils/GoBack.vue";

export default {
    data() {
        return {
            incharge: {
                contact_id: "",
                name: "",
                email: "",
                phone_mobile: "",
                phone_office: "",
            },
        };
    },
    mounted() {
        this.showIncharge();
    },
    methods: {
        showIncharge() {
            axios
                .get("/api/incharges/show/" + this.$route.params.id)
                .then((res) => {
                    this.incharge = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        // <p class="inline text-red-600 text-lg">*</p></label>

        // async createPIC() {
        //         const contact = this.contact_infos;
        //         // const form = document.getElementById('inchargeForm');
        //         try {
        //             await axios.post("/api/incharges/store", {
        //                 contact_id: contact[0].id,
        //                 name: this.form.name,
        //                 email: this.form.email,
        //                 phone_mobile: this.form.phone_mobile,
        //                 phone_office: this.form.phone_office,
        //             });

        //             await this.$router.push({
        //                 name: "incharge_create",
        //                 params: { id: this.$route.params.id },
        //             });
        //             this.form.contact_id = "";
        //             this.form.name = "";
        //             this.form.email = "";
        //             this.form.phone_mobile = "";
        //             this.form.phone_office = "";
        //             this.errors = "";
        //             this.showIncharge();
        //         } catch (e) {
        //             {
        //                 if (e.response.status === 422){
        //                     this.errors = e.response.data.errors;
        //                 }

        //             }
        //         }
        //     },

        updatePIC() {
            axios
                .put("/api/incharges/update/" + this.$route.params.id, {
                    contact_id: this.incharge.contact_id,
                    name: this.incharge.name,
                    email: this.incharge.email,
                    phone_mobile: this.incharge.phone_mobile,
                    phone_office: this.incharge.phone_office,
                })
                .then((res) => {
                    this.$router.push({
                        name: "incharge_create",
                        params: { id: this.incharge.contact_id },
                    });
                });
        },
    },
    components: { GoBack },
};
</script>
