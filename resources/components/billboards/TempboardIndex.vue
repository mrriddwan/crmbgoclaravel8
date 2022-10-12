<template>
    <div class="w-max">
        <h1
            class="items-center text-center text-4xl text-white font-extrabold font-mono uppercase bg-slate-400 px-2 rounded-md"
        >
            Tempboard Summary
        </h1>

        <div class="">
            <div class="grid grid-cols-4 items-center">
                <!-- <div class="grid grid-cols-1 items-left m-2">
                    <label for="paginate" class="">Per Page</label>
                    <select v-model="paginate" class="form-control">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div> -->
                <div class="items-center">
                    <router-link
                        to="/tempboard/create"
                        class="inline-block items-center px-2 py-1 align-top bg-blue-800 border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="inline h-6 w-6 mr-1" />
                        Tempboard</router-link
                    >
                </div>
                <div class="grid grid-cols-1 items-left m-2">
                    <label>Year</label>
                    <input
                        v-model.lazy="selectedYear"
                        type="search"
                        class="form-control"
                        placeholder="Search by any..."
                    />
                </div>
                <div class="grid grid-cols-1 items-left m-2">
                    <label>Search in table</label>
                    <input
                        v-model.lazy="search"
                        type="search"
                        class="form-control"
                        placeholder="Search by any..."
                    />
                </div>

                <div class="grid grid-cols-2 break-normal text-xs">
                    <div class="bg-blue-700 rounded-md w-max px-2 py-2">
                        <button @click="getTempboards" class="text-white">
                            Find Records
                        </button>
                    </div>
                    <div>
                        <!-- <download-excel
                            :data="tempboards.data"
                            :fields="forecast_fields"
                            worksheet="ForecastSummary"
                            name="Forecast Summary.xls"
                            class="btn btn-success btn-sm"
                        >
                            <ArrowTopRightOnSquareIcon
                                class="h-5 w-5 mr-1 inline-block"
                            />
                            Export
                        </download-excel> -->
                    </div>
                </div>
                <div class="py-1 inline-block">
                    <Pagination
                        :data="tempboards"
                        @pagination-change-page="getTempboards"
                        :size="'small'"
                        :align="'right'"
                        class="pagination"
                    />
                </div>
            </div>

            <div class="block max-h-screen overflow-y-auto overflow-x-auto">
                <table
                    class="table table-hover table-bordered w-max"
                    id="summary_table"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr class="w-full">
                            <th class="w-10">
                                <div class="text-xs text-center h-6 text-white">
                                    No.
                                </div>
                            </th>
                            <th class="w-max">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_entrydate')
                                        "
                                        class="text-white"
                                    >
                                        Date<br />Entry
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'tpboard_entrydate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'tpboard_entrydate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 "
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'tpboard_entrydate'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-20">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('user_name')
                                        "
                                        class="text-white"
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
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                >
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
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_location')
                                        "
                                        class="text-white"
                                    >
                                        Location
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'tpboard_location'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tpboard_location'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tpboard_location'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('contact_name')
                                        "
                                        class="text-white"
                                    >
                                        Company
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'contact_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'contact_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'contact_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_unit')
                                        "
                                        class="text-white"
                                    >
                                        Unit
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'tpboard_unit')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tpboard_unit'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tpboard_unit'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-max">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_size')
                                        "
                                        class="text-white"
                                    >
                                        Size
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'tpboard_size')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tpboard_size'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tpboard_size'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-max">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_startdate')
                                        "
                                        class="text-white"
                                    >
                                        Date<br />Start
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'tpboard_startdate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'tpboard_startdate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'tpboard_startdate'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-max">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_enddate')
                                        "
                                        class="text-white"
                                    >
                                        Date<br />End
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'tpboard_enddate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tpboard_enddate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tpboard_enddate'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_collection')
                                        "
                                        class="text-white"
                                    >
                                        Collection
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'tpboard_collection'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'tpboard_collection'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'tpboard_collection'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_material')
                                        "
                                        class="text-white"
                                    >
                                        Material
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'tpboard_material'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tpboard_material'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tpboard_material'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_printing')
                                        "
                                        class="text-white"
                                    >
                                        Printing
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'tpboard_printing'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tpboard_printing'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tpboard_printing'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_installation')
                                        "
                                        class="text-white"
                                    >
                                        Installation
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'tpboard_installation'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'tpboard_installation'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'tpboard_installation'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tpboard_remark')
                                        "
                                        class="text-white"
                                    >
                                        Remark
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'tpboard_remark'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tpboard_remark'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tpboard_remark'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6"></div>
                                <div
                                    class="items-center text-xs text-center h-6"
                                ></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr
                            v-for="(tempboard, index) in tempboards.data"
                            :key="tempboard.id"
                        >
                            <td class="text-xs">{{ index + 1 }}</td>
                            <td class="text-xs w-max">
                                {{ showToday(tempboard.tpboard_entrydate) }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.user_name }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_location }}
                            </td>
                            <td class="text-xs break-normal">
                                <router-link
                                    :to="`/contact/${tempboard.contact_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        tempboard.contact_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="text-xs w-max">
                                {{ tempboard.tpboard_unit }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_size }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ showToday(tempboard.tpboard_startdate) }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ showToday(tempboard.tpboard_enddate) }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_collection }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_material }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_printing }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_installation }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ tempboard.tpboard_remark }}
                            </td>
                            <td class="text-xs">
                                <br />
                                <router-link
                                    :to="{
                                        name: 'tempboard_edit',
                                        params: { id: tempboard.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="deleteTempboard(tempboard.id)"
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
import {
    PencilSquareIcon,
    TrashIcon,
    UserPlusIcon,
    PlusIcon,
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
    ArrowUpIcon,
    ArrowDownIcon,
} from "@heroicons/vue/24/solid";
import moment from "moment";

export default {
    components: {
        Pagination: LaravelVuePagination,
        PencilSquareIcon,
        TrashIcon,
        UserPlusIcon,
        PlusIcon,
        ArrowTopRightOnSquareIcon,
        ArrowsUpDownIcon,
        ArrowUpIcon,
        ArrowDownIcon,
    },

    mounted() {
        this.getSelectedYear(this.getCurrentDate());
        this.getTempboards();
        // this.getBillboardSizes();
        this.getUsers();
    },
    data() {
        return {
            tempboards: [],
            // billboard_sizes: [],
            contacts: [],
            users: [],

            paginate: 50,
            moment: moment,
            // selectPage: false,
            // selectAll: false,
            // checked: [],
            // url: "",

            search: "",
            selectedYear: "",
            selectedSite: "",
            selectedSize: "",
            selectedUser: "",

            sort_direction: "asc",
            sort_field: "tpboard_entrydate",
            currentDate: "",

            // contact_fields: {
            //     ID: "id",
            //     Company: "name",
            //     Status: "status_name",
            //     Type: "type_name",
            //     User: "user_name",
            //     "Contact Product": "category_name",
            //     Industry: "industry_name",
            //     Jan: {
            //         callback: (value) => {
            //             if (!value.summary[`Jan` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Jan` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Feb: {
            //         callback: (value) => {
            //             if (!value.summary[`Feb` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Feb` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Mar: {
            //         callback: (value) => {
            //             if (!value.summary[`Mar` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Mar` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Apr: {
            //         callback: (value) => {
            //             if (!value.summary[`Apr` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Apr` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     May: {
            //         callback: (value) => {
            //             if (!value.summary[`May` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`May` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Jun: {
            //         callback: (value) => {
            //             if (!value.summary[`Jun` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Jun` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Jul: {
            //         callback: (value) => {
            //             if (!value.summary[`Jul` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Jul` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Aug: {
            //         callback: (value) => {
            //             if (!value.summary[`Aug` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Aug` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Sep: {
            //         callback: (value) => {
            //             if (!value.summary[`Sep` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Sep` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Oct: {
            //         callback: (value) => {
            //             if (!value.summary[`Oct` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Oct` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Nov: {
            //         callback: (value) => {
            //             if (!value.summary[`Nov` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Nov` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            //     Dec: {
            //         callback: (value) => {
            //             if (!value.summary[`Dec` + this.selectedYear]) {
            //                 return " ";
            //             } else {
            //                 return `${value.summary[`Dec` + this.selectedYear][0]["todo_date"]}`;
            //             }
            //         },
            //     },
            // },
        };
    },
    watch: {
        paginate: function (value) {
            this.getTempboards();
        },
        search: function (value) {
            this.getTempboards();
        },
        selectedYear: function (value) {
            this.getTempboards();
        },
        selectedUser: function (value) {
            this.getTempboards();
        },
        // selectedSize: function (value) {
        //     this.getTempboards();
        // },
    },

    computed: {},

    methods: {
        getTempboards(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/tempboards/index?" +
                        "q=" +
                        this.search +
                        "&selectedYear=" +
                        this.selectedYear +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&paginate=" +
                        this.paginate +
                        "&page=" +
                        page +
                        "&sort_direction=" +
                        this.sort_direction +
                        "&sort_field=" +
                        this.sort_field
                )
                .then((res) => {
                    this.tempboards = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUsers() {
            await axios
                .get("/api/users/index")
                .then((res) => {
                    this.users = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async change_sort(field) {
            if (this.sort_field == field) {
                this.sort_direction =
                    this.sort_direction == "asc" ? "desc" : "asc";
            } else {
                this.sort_field = field;
            }
            this.getTempboards();
        },

        deleteTempboard(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/tempboards/delete/" + id);
            this.getTempboards();
        },

        getCurrentDate() {
            this.currentDate = moment().format("YYYY-MM-DD");
            return this.currentDate;
        },

        getSelectedYear(date) {
            this.selectedYear = moment(date).format("YYYY");
            return this.selectedYear;
        },

        showToday(date) {
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("DD-MM-YY");
            return day;
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
