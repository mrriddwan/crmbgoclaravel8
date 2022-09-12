<template>
    <div class="container w-max border-4 align-center mx-auto h-max">
        <div class="max-h-10 mb-4 ml-4">
            <GoBack class="" />
        </div>

        <div
            class="items-center text-center text-white font-extrabold bg-slate-600 px-2 py-2 rounded-md"
        >
            <h1 class="px-2 py-3 bg-black-50 col-span-2">
                Company Information
            </h1>
        </div>

        <table class="border-black m-4 grid">
            <tbody v-for="info in contact_infos" :key="contact_infos.id">
                <tr class="">
                    <td>Name</td>
                    <td
                        class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                    >
                        {{ info.name }}
                    </td>
                    <td>
                        <router-link
                            :to="{
                                name: 'todo_insert',
                                params: { id: info.id },
                            }"
                            class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <PlusCircleIcon class="h-5 w-5" /> To
                            Do</router-link
                        >
                        <router-link
                            :to="{
                                name: 'contacts_edit',
                                params: { id: info.id },
                            }"
                            class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <PencilSquareIcon class="h-5 w-5" />
                            Edit</router-link
                        >
                    </td>
                </tr>
                <tr>
                    <td>Industry</td>
                    <td
                        class="px-2 py-3 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                    >
                        {{ info.industry.name }}
                    </td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td
                        class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                    >
                        {{ info.category.name }}
                    </td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td
                        class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                    >
                        {{ info.address }}
                    </td>
                </tr>
                <tr>
                    <td>CS</td>
                    <td
                        class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                    >
                        {{ info.user.name }}
                    </td>
                </tr>
                <tr>
                    <td class="py-4">Contact History</td>
                    <td class="px-2 py-4">
                        <router-link
                            :to="{
                                name: 'contacts_history',
                                params: { id: info.id },
                            }"
                            class="mr-2 mb-2 inline-flex items-center px-1 py-1 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            Contact History</router-link
                        >
                    </td>
                </tr>
                <tr class="col-span-2 px-2 py-4">
                    <td>PIC</td>
                    <td>
                        <router-link
                            :to="{
                                name: 'incharge_create',
                                params: { id: info.id },
                            }"
                            class="inline-flex text-center px-1 py-1 bg-blue-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <PencilSquareIcon class="h-5 w-5" /> /
                            <PlusIcon class="h-5 w-5" /> PIC</router-link
                        >
                    </td>
                </tr>

                <span v-if="info.incharge.length !== 0" class="px-2 py-4">
                    <span
                        v-for="pic in info.incharge"
                        :key="info.incharge.id"
                        class="m-3 grid grid-cols-2 items-center border-2"
                    >
                        <tr>
                            <div>
                                <td
                                    class="px-2 py-4 text-m leading-5 text-gray-900 whitespace-no-wrap"
                                >
                                    Name
                                </td>
                                <td
                                    class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                >
                                    {{ pic.name }}
                                </td>
                            </div>
                            <div>
                                <td
                                    class="px-2 py-4 text-m leading-5 text-gray-900 whitespace-no-wrap"
                                >
                                    Email
                                </td>
                                <td
                                    class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                >
                                    {{ pic.email }}
                                </td>
                            </div>
                        </tr>

                        <tr>
                            <div>
                                <td
                                    class="px-2 py-4 text-m leading-5 text-gray-900 whitespace-no-wrap"
                                >
                                    Phone No. (Mobile)
                                </td>
                                <td
                                    class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                >
                                    {{ pic.phone_mobile }}
                                </td>
                            </div>

                            <div>
                                <td
                                    class="px-2 py-4 text-m leading-5 text-gray-900 whitespace-no-wrap"
                                >
                                    Phone No. (Office)
                                </td>
                                <td
                                    class="px-2 py-4 text-m leading-5 font-bold text-gray-900 whitespace-no-wrap"
                                >
                                    {{ pic.phone_office }}
                                </td>
                            </div>
                        </tr>

                        <tr class="ml-4">
                            <router-link
                                :to="{
                                    name: 'incharge_edit',
                                    params: { id: pic.id },
                                }"
                                class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                            >
                                <PencilIcon class="h-3 w-3"
                            /></router-link>
                            <button
                                class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                @click="deletePIC(pic.id)"
                            >
                                <TrashIcon class="h-3 w-3" />
                            </button>
                        </tr>
                    </span>
                </span>

                <span v-else class="">
                    <td
                        class="mx-auto font-serif border-5 border-grey-900 mb-2 text-xl font-extrabold tracking-tight leading-none text-gray-700 md:text-2xl lg:text-2xl text-center bg-slate-500 py-2 px-2 rounded-md uppercase w-max"
                    >
                        No PIC
                    </td>
                </span>
            </tbody>
        </table>

        <div class="ml-4 mb-4">
            <p>FORECAST</p>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import GoBack from "../utils/GoBack.vue";
import {
    PencilSquareIcon,
    TrashIcon,
    PlusCircleIcon,
    PlusIcon,
    PencilIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        GoBack,
        PencilSquareIcon,
        TrashIcon,
        PlusCircleIcon,
        PlusIcon,
        PencilIcon,
    },

    data() {
        return {
            info: "",
            contact_infos: [],
        };
    },

    mounted() {
        this.showContact();
    },

    methods: {
        showContact() {
            axios
                .get("/api/contacts/info/" + this.$route.params.id)
                .then((res) => {
                    this.contact_infos = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        deletePIC(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/incharges/delete/" + id);
            this.$router.push({
                name: "contacts_info",
                params: { id: this.$route.params.id },
            });
            this.showContact();
        },
    },
};
</script>
