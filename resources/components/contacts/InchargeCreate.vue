<template>
    <div
        class="container w-max align-center mx-auto"
        v-for="info in contact_infos"
        :key="contact_infos.id"
    >
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
        <h5
            class="items-center text-center text-white font-extrabold font-mono uppercase text-4xl bg-slate-600 px-1 py-1 rounded-md"
        >
            <strong> Create PIC </strong>
        </h5>
        <div class="text-left mx-auto">
            <p class="m-1 font-extrabold text-xl text-center uppercase">
                {{ info.name }}
            </p>

            <div class="mx-auto">
                <form
                    @submit.prevent="createPIC"
                    ref="inchargeForm"
                    class="inline-block align-middle"
                >
                    <div class="grid grid-cols-2 items-center">
                        <div class="grid grid-cols-2 w-auto items-center">
                            <div>
                                <label class="ml-7"
                                    >Name
                                    <p class="inline text-red-600 text-lg">
                                        *
                                    </p></label
                                >
                            </div>
                            <div>
                                <input
                                    type="text"
                                    class="items-left rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="form.name"
                                />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 w-auto items-center">
                            <label class="ml-7"
                                >Email
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                            <input
                                type="email"
                                class="items-left mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.email"
                            />
                        </div>

                        <div class="grid grid-cols-2 w-auto items-center">
                            <label class="ml-7"
                                >Phone No.(Mobile)
                                <p class="inline text-red-600 text-lg">*</p>
                            </label>
                            <input
                                type="text"
                                class="items-left mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.phone_mobile"
                            />
                        </div>

                        <div class="grid grid-cols-2 items-center">
                            <label class="ml-7">Phone No.(Office)</label>
                            <input
                                type="text"
                                class="items-left mt-1 rounded-md border-gray-500 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                v-model="form.phone_office"
                            />
                        </div>
                    </div>
                    <div class="text-center col-span-2">
                        <button
                            type="submit"
                            class="mt-4 px-8 py-2 bg-gray-800 border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 item"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="max-h-10 my-2">
            <GoBack class="" />
        </div>

        <div class="my-2">
            <span v-if="info.incharge.length !== 0">
                <h5
                    class="items-center text-center text-white font-extrabold font-mono text-sm uppercase bg-slate-600 px-5 py-2 rounded-md"
                >
                    PIC
                </h5>
                <span
                    v-for="(pic, index) in info.incharge"
                    :key="info.incharge.id"
                    class="my-2 py-1 border-gray-200"
                >
                    <!-- <tr ></tr> -->

                    <tr
                        class="text-left text-neutral-300 py-2 border-gray-200 grid grid-cols-4 gap-x-10"
                    >
                        <div>
                            <td>
                                <span
                                    class="bg-cyan-700 px-2 py-1 font-semibold font-mono rounded-md"
                                >
                                    {{ index + 1 }}
                                </span>
                            </td>
                            <td
                                class="px-1 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap"
                            >
                                Name:
                            </td>
                            <td
                                class="px-1 py-1 text-md leading-5 font-bold text-gray-900 whitespace-no-wrap"
                            >
                                {{ pic.name }}
                            </td>
                        </div>
                        <div class="w-max">
                            <td
                                class="px-1 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap"
                            >
                                Email:
                            </td>
                            <td
                                class="px-1 py-1 text-md leading-5 font-bold text-gray-900 whitespace-no-wrap w-max"
                            >
                                {{ pic.email }}
                            </td>
                        </div>
                        <div>
                            <td
                                class="px-1 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap"
                            >
                                Phone No. (Mobile):
                            </td>
                            <td
                                class="px-1 py-1 text-md leading-5 font-bold text-gray-900 whitespace-no-wrap"
                            >
                                {{ pic.phone_mobile }}
                            </td>
                        </div>
                        <div>
                            <td
                                class="px-1 py-1 text-md leading-5 text-gray-900 whitespace-no-wrap"
                            >
                                Phone No. (Office):
                            </td>
                            <td
                                class="px-1 py-1 text-md leading-5 font-bold text-gray-900 whitespace-no-wrap"
                            >
                                {{ pic.phone_office }}
                            </td>
                            <td class="py-1">
                                <router-link
                                    :to="{
                                        name: 'incharge_edit',
                                        params: { id: pic.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="deletePIC(pic.id)"
                                >
                                    <TrashIcon class="h-3 w-3" />
                                </button>
                            </td>
                        </div>
                    </tr>
                </span>
            </span>

            <span v-else>
                <h5
                    class="items-center text-center text-white font-extrabold font-mono text-sm uppercase bg-slate-600 px-5 py-2 rounded-md"
                >
                    PIC
                </h5>
                <div
                    class="uppercase text-center font-extrabold text-xl bg-slate-200 rounded-md py-1 px-1"
                >
                    <h5><b>No PIC data</b></h5>
                </div>
            </span>
        </div>
    </div>
</template>

<script>
import GoBack from "../utils/GoBack.vue";
import {
    PencilSquareIcon,
    TrashIcon,
    PlusCircleIcon,
    PlusIcon,
    PencilIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: { GoBack, PencilSquareIcon, TrashIcon },

    data() {
        return {
            info: [],
            contact_infos: [],
            form: {
                contact_id: "",
                name: "",
                email: "",
                phone_mobile: "",
                phone_office: "",
            },
            errors: "",
        };
    },
    mounted() {
        this.showIncharge();
    },
    methods: {
        showIncharge() {
            axios
                .get("/api/contacts/info/" + this.$route.params.id)
                .then((res) => {
                    this.contact_infos = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async createPIC() {
            const contact = this.contact_infos;
            // const form = document.getElementById('inchargeForm');
            try {
                await axios.post("/api/incharges/store", {
                    contact_id: contact[0].id,
                    name: this.form.name,
                    email: this.form.email,
                    phone_mobile: this.form.phone_mobile,
                    phone_office: this.form.phone_office,
                });
                // if (window.confirm("Continue to add incharge?")) {
                //     await this.$router.push({
                //         name: "incharge_create",
                //         params: { id: this.$route.params.id },
                //     });
                // } else {
                //     this.$router.push({ name: "contact_index" });
                // }

                this.form.contact_id = "";
                this.form.name = "";
                this.form.email = "";
                this.form.phone_mobile = "";
                this.form.phone_office = "";
                this.errors = "";
                this.showIncharge();
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    }
                }
            }
        },

        deletePIC(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/incharges/delete/" + id);
            this.$router.push({
                name: "incharge_create",
                params: { id: this.$route.params.id },
            });
            this.showIncharge();
        },
    },
};
</script>

<script></script>
