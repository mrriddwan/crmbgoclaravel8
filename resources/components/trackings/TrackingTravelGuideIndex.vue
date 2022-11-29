<template>
    <div class="container">
        <h1
            class="items-center text-center text-5xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
        >
            Tracking - Travel Guide
        </h1>

        <div class="flex">
            <div class="py-2 px-2">
                <router-link
                    :to="{ name: 'tracking_travel_guide_create'}"
                    class="inline-block items-center px-2 py-1 align-top bg-blue-800 border border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    <PlusIcon class="inline h-6 w-6 mr-1" />
                    Tracking</router-link
                >
            </div>

            <div
                class="py-2 px-2"
                v-if="can('export project') || is('admin | super-admin')"
            >
                <div
                    class="inline-block"
                    v-if="
                        (can('export general master') ||
                            is('admin | super-admin')) &&
                        view_type === 'master'
                    "
                >
                    <button
                        class="bg-green-500 px-2 py-2 rounded-lg text-xs"
                        @click="exportMasterGeneralExcel('xls')"
                    >
                        <ArrowTopRightOnSquareIcon
                            class="h-5 w-5 mr-1 inline-block"
                        />Export Master
                    </button>
                </div>
                <div
                    class="inline-block"
                    v-if="
                        (can('export general wip') ||
                            is('admin | super-admin')) &&
                        view_type === 'wip'
                    "
                >
                    <button
                        class="bg-green-500 px-2 py-2 rounded-lg text-xs"
                        @click="exportWIPGeneralExcel('xls')"
                    >
                        <ArrowTopRightOnSquareIcon
                            class="h-5 w-5 mr-1 inline-block"
                        />Export WIP
                    </button>
                </div>
            </div>
            <div class="py-2 flex">
                View:
                <select v-model="view_type" class="form-control mx-2">
                    <option value="">Select one</option>
                    <option value="master">Master</option>
                    <option value="wip">WIP</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-20">
            <div class="grid grid-cols-2 items-center align-middle w-max">
                <label for="paginate" class="px-2 inline-block">Per page</label>
                <input v-model.lazy="paginate" class="form-control" />
            </div>
            <div class="py-2 mx-8">
                <input
                    v-model.lazy="search"
                    type="search"
                    class="form-control"
                    placeholder="Search + Press ENTER"
                />
            </div>
            <div class="mt-1">
                <Pagination
                    :data="tracking_generals"
                    :limit="2"
                    @pagination-change-page="getTrackingGenerals"
                    :size="'small'"
                    :align="'center'"
                    class="pagination"
                />
            </div>
        </div>

        <div>
            <div v-if="view_type === 'wip'">
                <h3
                    class="items-center text-center text-2xl uppercase font-mono text-white font-extrabold bg-amber-600 px-2 rounded-md"
                >
                    Work In Progress
                </h3>
            </div>
            <div v-if="view_type === 'master'">
                <h3
                    class="items-center text-center text-2xl uppercase font-mono text-white font-extrabold bg-blue-500 px-2 rounded-md"
                >
                    Master Record
                </h3>
            </div>
            <div
                v-if="view_type === 'master'"
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto"
            >
                <table
                    class="table table-hover w-full mt-0"
                    ref="general_master_table"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white"
                                    >
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == ''
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == ''
                                        "
                                        >&darr;</span
                                    >
                                </div>
                            </th>
                            <th class="py-3 w-max">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('created_at')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'created_at')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('user_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        CS
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'user_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedUser"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="user in users.data"
                                            :key="user.id"
                                            :value="user.id"
                                        >
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6 w-full">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('company_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Company
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'company_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('category_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Edition
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'category_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'category_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'category_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6 w-24"
                                ></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('category_description')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Size
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'category_description'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'category_description'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'category_description'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_type')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Jan
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_amount')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Feb
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('art_format')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Mac
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('art_frequency')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Apr
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_reach')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        May
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_tenure')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Jun
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_startdate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Jul
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Aug
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Sept
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Oct
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Nov
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Dec
                                    </a>
                                </div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                            </th>

                            <th class="py-3">
                                <div
                                    class="text-sm text-center h-12 text-white"
                                >
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr>
                            <td class="text-xs text-center">1</td>
                            <td class="text-xs text-center">29-11-22</td>
                            <td class="text-xs text-center">IT</td>
                            <td class="text-xs text-center">Admin Limited</td>
                            <td class="text-xs text-center">KLTG 42</td>
                            <td class="text-xs text-center">FP</td>
                            <td class="text-xs text-center">Jan</td>
                            <td class="text-xs text-center">Feb</td>
                            <td class="text-xs text-center">Mac</td>
                            <td class="text-xs text-center">Apr</td>
                            <td class="text-xs text-center">May</td>
                            <td class="text-xs text-center">Jun</td>
                            <td class="text-xs text-center">Jul</td>
                            <td class="text-xs text-center">Aug</td>
                            <td class="text-xs text-center">Sep</td>
                            <td class="text-xs text-center">Oct</td>
                            <td class="text-xs text-center">Nov</td>
                            <td class="text-xs text-center">Dec</td>
                            <td class="text-xs text-center">Remark</td>
                            <!-- :to="{ name: 'tracking_general_edit', params: { id: tracking.id },}" -->
                            <td class="text-xs text-center">
                                <router-link
                                    to=""
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click=""
                                >
                                    <TrashIcon class="h-3 w-3" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="view_type === 'wip'"
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto"
            >
                <table
                    class="table table-hover w-full mt-0"
                    ref="general_wip_table"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white"
                                    >
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == ''
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == ''
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('created_at')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'created_at')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('user_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        CS
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'user_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedUser"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="user in users.data"
                                            :key="user.id"
                                            :value="user.id"
                                        >
                                            {{ user.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6 w-full">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('company_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Company
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'company_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'company_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('category_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Edition
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'category_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'category_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'category_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6 w-24"
                                ></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort(
                                                'general_category_description'
                                            )
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Size
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_category_description'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'general_category_description'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'general_category_description'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_type')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Art Received
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'general_type')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'general_type'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'general_type'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_amount')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Art Record
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_amount'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'general_amount'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'general_amount'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_type')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Jan
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_amount')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Feb
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('art_format')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Mac
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('art_frequency')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Apr
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_reach')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        May
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_tenure')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Jun
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_startdate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Jul
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Aug
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Sept
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Oct
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Nov
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Dec
                                    </a>
                                </div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                            </th>

                            <th class="py-3">
                                <div
                                    class="text-sm text-center h-12 text-white"
                                >
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr>
                            <td class="text-xs text-center">1</td>
                            <td class="text-xs text-center">29-11-22</td>
                            <td class="text-xs text-center">IT</td>
                            <td class="text-xs text-center">Admin Limited</td>
                            <td class="text-xs text-center">KLTG 42</td>
                            <td class="text-xs text-center">FP</td>
                            <td class="text-xs text-center">
                                30-11-22<br />
                                Media 3<br />
                                Accepted<br />
                            </td>
                            <td class="text-xs text-center">
                                30-12-22<br />
                                Telesales<br />
                                Accepted<br />
                            </td>
                            <td class="text-xs text-center">Jan</td>
                            <td class="text-xs text-center">Feb</td>
                            <td class="text-xs text-center">Mac</td>
                            <td class="text-xs text-center">Apr</td>
                            <td class="text-xs text-center">May</td>
                            <td class="text-xs text-center">Jun</td>
                            <td class="text-xs text-center">Jul</td>
                            <td class="text-xs text-center">Aug</td>
                            <td class="text-xs text-center">Sep</td>
                            <td class="text-xs text-center">Oct</td>
                            <td class="text-xs text-center">Nov</td>
                            <td class="text-xs text-center">Dec</td>
                            <td class="text-xs text-center">Remark</td>
                            <!-- :to="{ name: 'tracking_general_edit', params: { id: tracking.id },}" -->
                            <td class="text-xs text-center">
                                <router-link
                                    to=""
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click=""
                                >
                                    <TrashIcon class="h-3 w-3" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import moment from "moment";

import {
    PencilSquareIcon,
    PencilIcon,
    TrashIcon,
    PlusIcon,
    UserPlusIcon,
    DocumentChartBarIcon,
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
    ArrowUpIcon,
    ArrowDownIcon,
    QuestionMarkCircleIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        Pagination: LaravelVuePagination,
        PencilSquareIcon,
        TrashIcon,
        PlusIcon,
        UserPlusIcon,
        DocumentChartBarIcon,
        PencilIcon,
        ArrowTopRightOnSquareIcon,
        ArrowsUpDownIcon,
        ArrowUpIcon,
        ArrowDownIcon,
        QuestionMarkCircleIcon,
    },

    mounted() {
        this.getTrackingGenerals();
        this.getUsers();
        this.getCategories();
    },
    data() {
        return {
            tracking_generals: [],
            paginate: 100,

            search: "",
            buffering: false,

            sort_direction: "desc",
            sort_field: "created_at",
            // general_remark_visibility: false,
            // general_remark: null,
            view_type: "master",
            selectedUser: "",
            selectedCategory: "",
            selectedResult: "",
            users: [],
            categories: [],
        };
    },
    watch: {
        paginate: function (value) {
            this.getTrackingGenerals();
        },
        search: function (value) {
            this.getTrackingGenerals();
        },

        view_type: function (value) {
            this.getTrackingGenerals();
        },

        selectedUser: function (value) {
            this.tracking_generals = [];
            this.getTrackingGenerals();
        },

        selectedCategory: function (value) {
            this.tracking_generals = [];
            this.getTrackingGenerals();
        },

        selectedResult: function (value) {
            this.tracking_generals = [];
            this.getTrackingGenerals();
        },
    },

    methods: {
        // toggleRemark(general_id) {
        //     this.general_remark = general_id;
        //     this.general_remark_visibility = !this.general_remark_visibility;
        // },

        getTrackingGenerals(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            this.buffering = true;
            axios
                .get(
                    "/api/trackings/general/index?" +
                        "q=" +
                        this.search +
                        "&paginate=" +
                        this.paginate +
                        "&page=" +
                        page +
                        "&sort_direction=" +
                        this.sort_direction +
                        "&sort_field=" +
                        this.sort_field +
                        "&view_type=" +
                        this.view_type +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedCategory=" +
                        this.selectedCategory +
                        "&selectedResult=" +
                        this.selectedResult
                )
                .then((res) => {
                    this.buffering = false;
                    this.tracking_generals = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUsers() {
            await axios
                .get("/api/users/users_list")
                .then((res) => {
                    this.users = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getCategories() {
            await axios
                .get("/api/contacts/category/index")
                .then((res) => {
                    this.categories = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        change_sort(field) {
            if (this.sort_field == field) {
                this.sort_direction =
                    this.sort_direction == "asc" ? "desc" : "asc";
            } else {
                this.sort_field = field;
            }
            this.getTrackingGenerals();
        },

        deleteMasterGeneral(id) {
            if (!window.confirm("Confirm delete?")) {
                return;
            }
            axios.delete("/api/trackings/general/delete/" + id);
            this.getTrackingGenerals();
        },

        deleteWIPGeneral(id) {
            if (!window.confirm("Confirm delete?")) {
                return;
            }
            axios.delete("/api/trackings/wip/general/delete/" + id);
            this.getTrackingGenerals();
        },

        calculateDuration(start_date, end_date) {
            const start = new Date(start_date);
            const end = new Date(end_date);

            return moment(end - start).format("D");
        },

        showToday(date) {
            let new_date = new Date(date);
            let day = moment(new_date).format("DD-MM-YY");
            return day;
        },

        exportMasterGeneralExcel(type, fn, dl) {
            var elt = this.$refs.general_master_table;
            var wb = XLSX.utils.table_to_book(elt, { sheet: "Master General" });

            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64",
                  })
                : XLSX.writeFile(
                      wb,
                      fn || "MasterGeneralExport." + (type || "xlsx")
                  );
        },

        exportWIPGeneralExcel(type, fn, dl) {
            var elt = this.$refs.general_wip_table;
            var wb = XLSX.utils.table_to_book(elt, { sheet: "WIP General" });

            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64",
                  })
                : XLSX.writeFile(
                      wb,
                      fn || "WIPGeneralExport." + (type || "xlsx")
                  );
        },
    },
};
</script>
