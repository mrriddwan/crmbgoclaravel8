<template>
    <div class="container">
        <!-- <div class="max-w-full"> -->
        <h1
            class="items-center text-center text-5xl text-white font-extrabold bg-orange-500 px-2 rounded-md"
        >
            Tracking - Travel Guide
        </h1>

        <div class="flex">
            <div
                class="py-2 px-2"
                v-if="
                    can('create tracking travelguide') ||
                    is('admin | super-admin')
                "
            >
                <router-link
                    :to="{ name: 'tracking_travel_guide_create' }"
                    class="inline-block items-center px-2 py-1 align-top bg-blue-800 border border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    <PlusIcon class="inline h-6 w-6 mr-1" />
                    Tracking</router-link
                >
            </div>

            <div class="py-2 px-2">
                <div
                    class="px-2"
                    v-if="
                        (can('export travel guide master') ||
                            is('admin | super-admin')) &&
                        (view_type === 'master' ||
                            view_type === 'master_report')
                    "
                >
                    <download-excel
                        :data="tracking_travel_guides.data"
                        :fields="tguide_master_fields"
                        worksheet="Travel Guide Summary"
                        name="Travel Guide Master.xls"
                        class="btn btn-success btn-sm"
                    >
                        <ArrowTopRightOnSquareIcon
                            class="h-5 w-5 mr-1 inline-block"
                        />
                        Export Master Table
                    </download-excel>
                </div>
                <div
                    class="px-2"
                    v-if="
                        (can('export travel guide wip') ||
                            is('admin | super-admin')) &&
                        (view_type === 'wip' || view_type === 'wip_report')
                    "
                >
                    <download-excel
                        :data="tracking_travel_guides.data"
                        :fields="tguide_wip_fields"
                        worksheet="Travel Guide Summary"
                        name="Travel Guide WIP.xls"
                        class="btn btn-success btn-sm"
                    >
                        <ArrowTopRightOnSquareIcon
                            class="h-5 w-5 mr-1 inline-block"
                        />
                        Export WIP Table
                    </download-excel>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-8 gap-3">
            <div class="grid grid-cols-2 items-center text-right">
                <label for="paginate" class="mr-2 text-sm">Per page</label>
                <input v-model.lazy="paginate" class="form-control w-max" />
            </div>
            <div class="grid grid-cols-2 col-span-2 items-center text-right">
                <label for="view_type" class="mr-2">View</label>
                <select v-model="view_type" class="form-control mx-2">
                    <option value="">Select one</option>
                    <option value="master">Master</option>
                    <option value="wip">WIP</option>
                    <option value="master_report">Report (Master)</option>
                    <option value="wip_report">Report (WIP)</option>
                </select>
            </div>
            <div class="py-2 mx-8 col-span-3">
                <input
                    v-model.lazy="search"
                    type="search"
                    class="form-control"
                    placeholder="Search + Press ENTER"
                />
            </div>
            <div class="mt-1 col-span-2">
                <Pagination
                    :data="tracking_travel_guides"
                    :limit="2"
                    @pagination-change-page="getTrackingTravelGuides"
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
            <div v-if="view_type === 'master_report'">
                <h3
                    class="items-center text-center text-2xl uppercase font-mono text-white font-extrabold bg-blue-800 px-2 rounded-md"
                >
                    Master Report
                </h3>
            </div>
            <div v-if="view_type === 'wip_report'">
                <h3
                    class="items-center text-center text-2xl uppercase font-mono text-white font-extrabold bg-amber-800 px-2 rounded-md"
                >
                    Work In Progress Report
                </h3>
            </div>
            <div
                v-if="view_type === 'master'"
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto border-separate"
            >
                <table
                    class="table table-hover w-full mt-0 table-separate"
                    ref="tguide_master_table"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="border py-3">
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
                            <th class="border py-3 w-max">
                                <div class="text-sm text-center h-12 w-14">
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
                            <th class="border py-3">
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
                                <div class="text-xs text-center h-6">
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

                            <th class="border py-3">
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

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('edition')"
                                        class="text-white inline-flex"
                                    >
                                        Edition
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'edition')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'edition'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'edition'
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

                            <th class="border py-3">
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tguide_size')
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
                                                !(sort_field == 'tguide_size')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>

                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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

                            <th class="border py-3">
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

                            <th class="border py-3">
                                <div
                                    class="text-sm text-center h-12 text-white"
                                >
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-left">
                        <tr
                            v-for="(
                                tracking, index
                            ) in tracking_travel_guides.data"
                            :key="tracking.id"
                        >
                            <td class="border text-xs">
                                {{ index + 1 }}
                            </td>
                            <td class="border text-xs">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.user_name }}
                            </td>
                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs h-6 w-24"
                            >
                                <router-link
                                    :to="`/contact/${tracking.company_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        tracking.company_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="border text-xs">
                                {{ tracking.edition }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.tguide_size }}
                            </td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-01`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-01` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-01` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-02`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-02` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-02` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-03`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-03` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-03` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-04`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-04` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-04` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-05`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-05` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-05` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-06`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-06` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-06` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-07`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-07` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-07` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-08`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-08` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-08` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-09`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-09` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-09` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-10`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-10` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-10` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-11`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-11` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-11` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-12`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-12` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-12` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-yellow-300"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td class="border text-xs">
                                {{ tracking.tguide_remark }}
                            </td>
                            <!-- :to="{ name: 'tracking_general_edit', params: { id: tracking.id },}" -->
                            <td class="border text-xs text-center">
                                <router-link
                                    v-if="
                                        can('edit master travelguide') ||
                                        is('admin | super-admin')
                                    "
                                    :to="{
                                        name: 'tracking_travel_guide_edit',
                                        params: { id: tracking.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                                <button
                                    v-if="
                                        can('delete master travelguide') ||
                                        is('admin | super-admin')
                                    "
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="
                                        deleteTrackingTravelGuide(tracking.id)
                                    "
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
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto table-border"
            >
                <table
                    class="table table-hover w-full mt-0 table-separate"
                    ref="tguide_wip_table"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="border py-3">
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
                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-14">
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
                            <th class="border py-3">
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
                                <div class="text-xs text-center h-6">
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

                            <th class="border py-3">
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

                            <th class="border py-3">
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

                            <th class="border py-3">
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

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_type')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        A/W Reminder
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
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_amount')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        A/W Received
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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

                            <th class="border py-3">
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

                            <th class="border py-3">
                                <div
                                    class="text-sm text-center h-12 text-white"
                                >
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-left">
                        <tr
                            v-for="(
                                tracking, index
                            ) in tracking_travel_guides.data"
                            :key="tracking.id"
                        >
                            <td class="border text-xs">
                                {{ index + 1 }}
                            </td>
                            <td class="border text-xs">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.user_name }}
                            </td>
                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs h-6 w-24"
                            >
                                <router-link
                                    :to="`/contact/${tracking.company_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        tracking.company_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="border text-xs">
                                {{ tracking.edition }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.tguide_size }}
                            </td>
                            <td
                                class="border text-xs"
                                v-if="
                                    !tracking.art_reminder_date &&
                                    !tracking.art_reminder_user_id &&
                                    !tracking.art_reminder_remark
                                "
                            >
                                <div
                                    class="bg-red-300 p-1 rounded-md w-20 text-red-300"
                                ></div>
                            </td>
                            <td
                                v-else-if="tracking.art_reminder_done === 2"
                                class="border text-xs"
                            >
                                <div class="bg-yellow-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_reminder_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_date">
                                        {{
                                            showToday(
                                                tracking.art_reminder_date
                                            )
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_user">
                                        {{ tracking.art_reminder_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_remark">
                                        {{ tracking.art_reminder_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                v-else-if="tracking.art_reminder_done === 1"
                                class="border text-xs"
                            >
                                <div class="bg-green-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_reminder_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_date">
                                        {{
                                            showToday(
                                                tracking.art_reminder_date
                                            )
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_user">
                                        {{ tracking.art_reminder_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_reminder_remark">
                                        {{ tracking.art_reminder_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                class="border text-xs"
                                v-if="
                                    !tracking.art_record_date &&
                                    !tracking.art_record_user &&
                                    !tracking.art_record_remark
                                "
                            >
                                <div
                                    class="bg-red-300 p-1 rounded-md w-20 text-red-300"
                                ></div>
                            </td>
                            <td
                                v-else-if="tracking.art_record_done === 2"
                                class="border text-xs"
                            >
                                <div class="bg-yellow-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_record_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_date">
                                        {{
                                            showToday(tracking.art_record_date)
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_user">
                                        {{ tracking.art_record_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_remark">
                                        {{ tracking.art_record_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                v-else-if="tracking.art_record_done === 1"
                                class="border text-xs"
                            >
                                <div class="bg-green-300 p-1 rounded-md w-20">
                                    <div
                                        v-if="!tracking.art_record_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_date">
                                        {{
                                            showToday(tracking.art_record_date)
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_user">
                                        {{ tracking.art_record_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div v-else="tracking.art_record_remark">
                                        {{ tracking.art_record_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-01`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-01` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-01` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-02`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-02` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-02` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-03`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-03` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-03` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-04`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-04` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-04` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-05`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-05` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-05` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-06`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-06` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-06` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-07`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-07` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-07` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-08`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-08` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-08` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-09`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-09` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-09` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-10`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-10` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-10` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-11`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-11` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-11` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-12`
                                    )
                                "
                            >
                                <div
                                    v-for="tguide_package in tracking.wip_travel_guide"
                                    :key="tguide_package.id"
                                    class="mb-1"
                                >
                                    <div
                                        class="bg-yellow-300 p-1 rounded-md w-20"
                                        v-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-12` &&
                                            tguide_package.wip_package_done ===
                                                2
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                    <div
                                        class="bg-green-300 p-1 rounded-md w-20"
                                        v-else-if="
                                            getMonth(
                                                tguide_package.wip_package_date
                                            ) === `${selectedYear}-12` &&
                                            tguide_package.wip_package_done ===
                                                1
                                        "
                                    >
                                        <div
                                            v-if="
                                                tguide_package.wip_package_name
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.wip_package_date
                                            "
                                        >
                                            {{
                                                showToday(
                                                    tguide_package.wip_package_date
                                                )
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                        <div
                                            v-if="
                                                tguide_package.package_user_name
                                            "
                                        >
                                            {{
                                                tguide_package.package_user_name
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>

                                        <div
                                            v-if="
                                                tguide_package.wip_package_remark
                                            "
                                        >
                                            {{
                                                tguide_package.wip_package_remark
                                            }}
                                        </div>
                                        <div
                                            v-else
                                            class="text-amber-600"
                                        ></div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td class="border text-xs">
                                {{ tracking.tguide_remark }}
                            </td>

                            <td class="border text-xs text-center">
                                <router-link
                                    v-if="
                                        can('edit wip travelguide') ||
                                        is('admin | super-admin')
                                    "
                                    :to="{
                                        name: 'tracking_travel_guide_edit',
                                        params: { id: tracking.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="view_type === 'master_report'"
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto border-separate"
            >
                <table
                    class="table table-hover w-full mt-0 table-separate"
                    ref="tguide_master_table"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="border py-3">
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
                            <th class="border py-3 w-max">
                                <div class="text-sm text-center h-12 w-14">
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
                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-20">
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
                                <div class="text-xs text-center h-6">
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

                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-60">
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

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('edition')"
                                        class="text-white inline-flex"
                                    >
                                        Edition
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'edition')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'edition'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'edition'
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

                            <th class="border py-3 text-center">
                                <div class="text-sm text-center h-12 w-20">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('tguide_size')
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
                                                !(sort_field == 'tguide_size')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'tguide_size'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>

                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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

                            <th class="border py-3">
                                <div class="text-sm text-center h-12 w-28">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                            </th>

                            <th class="border py-3">
                                <div
                                    class="text-sm text-center h-12 text-white"
                                >
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-left">
                        <tr
                            v-for="(
                                tracking, index
                            ) in tracking_travel_guides.data"
                            :key="tracking.id"
                        >
                            <td class="border text-xs">
                                {{ index + 1 }}
                            </td>
                            <td class="border text-xs">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.user_name }}
                            </td>
                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs h-6 w-24"
                            >
                                <router-link
                                    :to="`/contact/${tracking.company_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        tracking.company_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="border text-xs">
                                {{ tracking.edition }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.tguide_size }}
                            </td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-01`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-01` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-01` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-02`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-02` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-02` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-03`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-03` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-03` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-04`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-04` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-04` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-05`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-05` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-05` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-06`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-06` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-06` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-07`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-07` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-07` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-08`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-08` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-08` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-09`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-09` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-09` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-10`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-10` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-10` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-11`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-11` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-11` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-12`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-20"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-12` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md w-20"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-12` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-yellow-300"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td class="border text-xs">
                                {{ tracking.tguide_remark }}
                            </td>
                            <!-- :to="{ name: 'tracking_general_edit', params: { id: tracking.id },}" -->
                            <td class="border text-xs text-center">
                                <div class="flex">
                                    <router-link
                                        v-if="
                                            can('edit master travelguide') ||
                                            is('admin | super-admin')
                                        "
                                        :to="{
                                            name: 'tracking_travel_guide_edit',
                                            params: { id: tracking.id },
                                        }"
                                        class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    >
                                        <PencilSquareIcon class="h-3 w-3"
                                    /></router-link>
                                    <button
                                        v-if="
                                            can('delete master travelguide') ||
                                            is('admin | super-admin')
                                        "
                                        class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                        @click="
                                            deleteTrackingTravelGuide(
                                                tracking.id
                                            )
                                        "
                                    >
                                        <TrashIcon class="h-3 w-3" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="view_type === 'wip_report'"
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto table-border"
            >
                <table
                    class="table table-hover w-full mt-0 table-separate"
                    ref="tguide_wip_table"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="border py-3">
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
                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-14">
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
                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-20">
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
                                <div class="text-xs text-center h-6">
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

                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-60">
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

                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-20">
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

                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-20">
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

                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_type')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        A/W Reminder
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
                            <th class="border py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_amount')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        A/W Received
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
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
                            <th class="border py-3">
                                <div class="text-sm text-center h-6 w-60">
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

                            <th class="border py-3">
                                <div class="text-sm text-center h-12 w-32">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                            </th>

                            <th class="border py-3">
                                <div
                                    class="text-sm text-center h-12 text-white"
                                >
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-left">
                        <tr
                            v-for="(
                                tracking, index
                            ) in tracking_travel_guides.data"
                            :key="tracking.id"
                        >
                            <td class="border text-xs">
                                {{ index + 1 }}
                            </td>
                            <td class="border text-xs">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.user_name }}
                            </td>
                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs h-6 w-24"
                            >
                                <router-link
                                    :to="`/contact/${tracking.company_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        tracking.company_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="border text-xs">
                                {{ tracking.edition }}
                            </td>
                            <td class="border text-xs">
                                {{ tracking.tguide_size }}
                            </td>
                            <td
                                class="border text-xs"
                                v-if="
                                    !tracking.art_reminder_date &&
                                    !tracking.art_reminder_user_id &&
                                    !tracking.art_reminder_remark
                                "
                            >
                                <div
                                    class="p-1 rounded-md w-20 text-red-300"
                                ></div>
                            </td>
                            <td
                                v-else-if="tracking.art_reminder_done === 2"
                                class="border text-xs"
                            >
                                <span
                                    class="bg-yellow-300 p-1 rounded-md flex w-max"
                                >
                                    <span
                                        v-if="!tracking.art_reminder_date"
                                        class="text-amber-600"
                                    ></span>
                                    <span
                                        v-else="tracking.art_reminder_date"
                                        class="w-max mr-1"
                                    >
                                        {{
                                            showToday(
                                                tracking.art_reminder_date
                                            )
                                        }}
                                    </span>
                                    <span
                                        v-if="!tracking.art_reminder_user"
                                        class="text-amber-600"
                                    ></span>
                                    <span
                                        v-else="tracking.art_reminder_user"
                                        class="w-max mr-1"
                                    >
                                        {{ tracking.art_reminder_user.name }}
                                    </span>
                                    <span
                                        v-if="!tracking.art_reminder_remark"
                                        class="text-amber-600"
                                    ></span>
                                    <span
                                        v-else="tracking.art_reminder_remark"
                                        class="w-max mr-1"
                                    >
                                        {{ tracking.art_reminder_remark }}
                                    </span>
                                </span>
                            </td>
                            <td
                                v-else-if="tracking.art_reminder_done === 1"
                                class="border text-xs"
                            >
                                <div
                                    class="bg-green-300 p-1 rounded-md flex w-max"
                                >
                                    <div
                                        v-if="!tracking.art_reminder_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div
                                        v-else="tracking.art_reminder_date"
                                        class="w-max mr-1"
                                    >
                                        {{
                                            showToday(
                                                tracking.art_reminder_date
                                            )
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div
                                        v-else="tracking.art_reminder_user"
                                        class="w-max mr-1"
                                    >
                                        {{ tracking.art_reminder_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_reminder_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div
                                        v-else="tracking.art_reminder_remark"
                                        class="w-max mr-1"
                                    >
                                        {{ tracking.art_reminder_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                class="border text-xs"
                                v-if="
                                    !tracking.art_record_date &&
                                    !tracking.art_record_user &&
                                    !tracking.art_record_remark
                                "
                            >
                                <div
                                    class="p-1 rounded-md w-20 text-red-300"
                                ></div>
                            </td>
                            <td
                                v-else-if="tracking.art_record_done === 2"
                                class="border text-xs"
                            >
                                <div
                                    class="bg-yellow-300 p-1 rounded-md flex w-max"
                                >
                                    <div
                                        v-if="!tracking.art_record_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div
                                        v-else="tracking.art_record_date"
                                        class="w-max mr-1"
                                    >
                                        {{
                                            showToday(tracking.art_record_date)
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div
                                        v-else="tracking.art_record_user"
                                        class="w-max mr-1"
                                    >
                                        {{ tracking.art_record_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div
                                        v-else="tracking.art_record_remark"
                                        class="w-max mr-1"
                                    >
                                        {{ tracking.art_record_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                v-else-if="tracking.art_record_done === 1"
                                class="border text-xs"
                            >
                                <div
                                    class="bg-green-300 p-1 rounded-md flex w-max"
                                >
                                    <div
                                        v-if="!tracking.art_record_date"
                                        class="text-amber-600"
                                    ></div>
                                    <div
                                        v-else="tracking.art_record_date"
                                        class="w-max mr-1"
                                    >
                                        {{
                                            showToday(tracking.art_record_date)
                                        }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_user"
                                        class="text-amber-600"
                                    ></div>
                                    <div
                                        v-else="tracking.art_record_user"
                                        class="w-max mr-1"
                                    >
                                        {{ tracking.art_record_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_record_remark"
                                        class="text-amber-600"
                                    ></div>
                                    <div
                                        v-else="tracking.art_record_remark"
                                        class="w-max mr-1"
                                    >
                                        {{ tracking.art_record_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-01`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-01` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-01` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-02`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-02` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-02` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-03`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-03` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-03` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-04`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-04` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-04` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-05`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-05` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-05` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-06`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-06` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-06` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-07`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-07` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-07` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-08`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-08` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-08` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-09`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-09` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-09` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-10`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-10` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-10` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-11`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-11` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-11` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                class="border text-xs"
                                v-if="
                                    tracking.wip_travel_guide.length !== 0 &&
                                    checkMonth(
                                        tracking.wip_travel_guide,
                                        `${selectedYear}-12`
                                    )
                                "
                            >
                                <div class="flex">
                                    <div
                                        v-for="tguide_package in tracking.wip_travel_guide"
                                        :key="tguide_package.id"
                                        class="mr-1"
                                    >
                                        <div
                                            class="bg-yellow-300 p-1 rounded-md w-max flex"
                                            v-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-12` &&
                                                tguide_package.wip_package_done ===
                                                    2
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                        <div
                                            class="bg-green-300 p-1 rounded-md flex w-max"
                                            v-else-if="
                                                getMonth(
                                                    tguide_package.wip_package_date
                                                ) === `${selectedYear}-12` &&
                                                tguide_package.wip_package_done ===
                                                    1
                                            "
                                        >
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.wip_package_date
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    showToday(
                                                        tguide_package.wip_package_date
                                                    )
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                            <div
                                                v-if="
                                                    tguide_package.package_user_name
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.package_user_name
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>

                                            <div
                                                v-if="
                                                    tguide_package.wip_package_remark
                                                "
                                                class="w-max mr-2"
                                            >
                                                {{
                                                    tguide_package.wip_package_remark
                                                }}
                                            </div>
                                            <div
                                                v-else
                                                class="text-amber-600"
                                            ></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="border text-xs" v-else></td>

                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs h-6 w-24"
                            >
                                <router-link
                                    :to="`/contact/${tracking.company_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        tracking.company_name
                                    }}</a>
                                </router-link>
                            </td>

                            <td class="border text-xs w-36">
                                {{ tracking.tguide_remark }}
                            </td>

                            <td class="border text-xs text-center">
                                <router-link
                                    v-if="
                                        can('edit wip travelguide') ||
                                        is('admin | super-admin')
                                    "
                                    :to="{
                                        name: 'tracking_travel_guide_edit',
                                        params: { id: tracking.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- </div> -->
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

const test_json = [
    {
        id: 4,
        tracking_tguide_id: 2,
        wip_package_name: "Article",
        wip_package_date: "2022-01-15",
        wip_package_done: 2,
    },

    {
        id: 5,
        tracking_tguide_id: 2,
        wip_package_name: "FB Ads and Video",
        wip_package_date: "2022-01-29",
        wip_package_done: 2,
    },
];

const month_year_test = "2022-01";

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
        this.selectedUser = document
            .querySelector('meta[name="user-id"]')
            .getAttribute("content");
        this.currentDate = this.getCurrentDate();
        this.selectedDate = this.currentDate;

        this.selectedYear = this.getSelectedYear(this.selectedDate);
        this.getTrackingTravelGuides();
        this.getUsers();
        this.getCategories();

        this.checkMonth(test_json, month_year_test);
    },
    data() {
        return {
            tracking_travel_guides: [],
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
            currentDate: "",

            selectedDate: "",
            selectedYear: "",
            tguide_master_fields: {
                Date: {
                    callback: (value) => {
                        return `${this.showToday(value.created_at)}`;
                    },
                },
                User: "user_name",
                Company: "company_name",
                Edition: "edition",
                Size: "tguide_size",
                Jan: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        // console.log('wip_tguide',wip_tguide);
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-01`
                            )
                        ) {
                            //loop through the package
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-01` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    //return without bracket
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-01` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    //return with bracket
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                                // else {
                                //     new_arr.push(`-`)
                                // }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            //return empty
                            return ``;
                        }
                    },
                },
                Feb: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-02`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-02` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-02` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Mar: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-03`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-03` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-03` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Apr: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-04`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-04` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-04` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                May: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-05`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-05` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-05` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Jun: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-06`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-06` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-06` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Jul: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-07`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-07` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-07` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Aug: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-08`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-08` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-08` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            // return `${new_arr.join('-')}`
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Sep: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-09`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-09` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-09` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Oct: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-10`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-10` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-10` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Nov: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-11`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-11` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-11` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Dec: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-12`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-12` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${tguide_package.wip_package_name}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-12` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${tguide_package.wip_package_name})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
            },

            tguide_wip_fields: {
                Date: {
                    callback: (value) => {
                        return `${this.showToday(value.created_at)}`;
                    },
                },
                User: "user_name",
                Company: "company_name",
                Edition: "edition",
                Size: "tguide_size",
                "A/W Reminder": {
                    callback: (value) => {
                        return !value.art_reminder_date
                            ? ``
                            : value.art_reminder_done === 2
                            ? `${this.showToday(value.art_reminder_date)}.`
                            : `(${this.showToday(value.art_reminder_date)})`;
                    },
                },
                "A/W Received": {
                    callback: (value) => {
                        return !value.art_record_date
                            ? ``
                            : value.art_record_done === 2 &&
                              value.art_record_date
                            ? `${this.showToday(value.art_record_date)}.`
                            : `(${this.showToday(value.art_record_date)})`;
                    },
                },

                Jan: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-01`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-01` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-01` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Feb: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-02`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-02` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-02` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Mar: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-03`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-03` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-03` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Apr: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-04`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-04` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-04` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                May: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-05`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-05` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-05` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Jun: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-06`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-06` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-06` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Jul: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-07`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-07` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-07` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Aug: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-08`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-08` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-08` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Sep: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-09`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-09` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-09` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Oct: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-10`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-10` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-10` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Nov: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-11`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-11` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-11` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
                Dec: {
                    callback: (value) => {
                        var wip_tguide = value.wip_travel_guide;
                        if (
                            wip_tguide.length !== 0 &&
                            this.checkMonth(
                                wip_tguide,
                                `${this.selectedYear}-12`
                            )
                        ) {
                            let new_arr = [];
                            for (let tguide_package of wip_tguide) {
                                if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-12` &&
                                    tguide_package.wip_package_done === 2
                                ) {
                                    new_arr.push(
                                        `${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )}`
                                    );
                                } else if (
                                    this.getMonth(
                                        tguide_package.wip_package_date
                                    ) === `${this.selectedYear}-12` &&
                                    tguide_package.wip_package_done === 1
                                ) {
                                    new_arr.push(
                                        `(${
                                            tguide_package.wip_package_name
                                        }:${this.getDayMonth(
                                            tguide_package.wip_package_date
                                        )})`
                                    );
                                }
                            }
                            return `${new_arr.join("\n")}`;
                        } else {
                            return ``;
                        }
                    },
                },
            },
        };
    },
    watch: {
        paginate: function (value) {
            this.getTrackingTravelGuides();
        },
        search: function (value) {
            this.getTrackingTravelGuides();
        },

        view_type: function (value) {
            this.getTrackingTravelGuides();
        },

        selectedUser: function (value) {
            this.tracking_travel_guides = [];
            this.getTrackingTravelGuides();
        },

        selectedCategory: function (value) {
            this.tracking_travel_guides = [];
            this.getTrackingTravelGuides();
        },

        selectedResult: function (value) {
            this.tracking_travel_guides = [];
            this.getTrackingTravelGuides();
        },
    },

    methods: {
        // toggleRemark(general_id) {
        //     this.general_remark = general_id;
        //     this.general_remark_visibility = !this.general_remark_visibility;
        // },

        getTrackingTravelGuides(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            this.buffering = true;
            axios
                .get(
                    "/api/trackings/travel_guide/index?" +
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
                        this.selectedUser
                    // +
                    // "&selectedCategory=" +
                    // this.selectedCategory +
                    // "&selectedResult=" +
                    // this.selectedResult
                )
                .then((res) => {
                    this.buffering = false;
                    this.tracking_travel_guides = res.data;
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
            this.getTrackingTravelGuides();
        },

        deleteMasterGeneral(id) {
            if (!window.confirm("Confirm delete?")) {
                return;
            }
            axios.delete("/api/trackings/general/delete/" + id);
            this.getTrackingTravelGuides();
        },

        deleteWIPGeneral(id) {
            if (!window.confirm("Confirm delete?")) {
                return;
            }
            axios.delete("/api/trackings/wip/general/delete/" + id);
            this.getTrackingTravelGuides();
        },

        showToday(date) {
            let new_date = new Date(date);
            let day = moment(new_date).format("DD-MM-YY");
            return day;
        },

        getMonth(date) {
            let day = moment(date).format("YYYY-MM");
            return day;
        },

        getSelectedYear(date) {
            this.selectedYear = moment(date).format("YYYY");
            return this.selectedYear;
        },

        getCurrentDate() {
            this.currentDate = moment().format("YYYY-MM-DD");
            return this.currentDate;
        },

        checkMonth(wip_travel_guide, month_year) {
            var count = 0;
            // console.log(wip_travel_guide);
            for (let i = 0; i < wip_travel_guide.length; i++) {
                if (
                    this.getMonth(wip_travel_guide[i].wip_package_date) ===
                    month_year
                ) {
                    count++;
                }
            }
            return count > 0 ? true : false;
            // console.log(count > 0 ? true : false)
        },

        getDayMonth(date) {
            let day_month = moment(date).format("DD-MM");
            return day_month;
        },

        deleteTrackingTravelGuide(tracking_id) {
            if (
                !window.confirm(
                    "This will remove the tracking and its WIP(s). Continue?"
                )
            ) {
                return;
            }
            axios.delete("/api/trackings/travel_guide/delete/" + tracking_id);
            alert("Tracking and its WIP(s) deleted.");
            this.getTrackingTravelGuides();
        },

        exportMasterTravelGuidelExcel(type, fn, dl) {
            var elt = this.$refs.tguide_master_table;
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "Master Travel Guide",
            });

            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64",
                  })
                : XLSX.writeFile(
                      wb,
                      fn || "Master Travel Guide." + (type || "xlsx")
                  );
        },

        exportWIPTravelGuideExcel(type, fn, dl) {
            var elt = this.$refs.tguide_wip_table;
            var wb = XLSX.utils.table_to_book(elt, {
                sheet: "WIP Travel Guide",
            });

            return dl
                ? XLSX.write(wb, {
                      bookType: type,
                      bookSST: true,
                      type: "base64",
                  })
                : XLSX.writeFile(
                      wb,
                      fn || "WIP Travel Guide." + (type || "xlsx")
                  );
        },

        check_id(contact_user_id) {
            let id = contact_user_id;
            // console.log(id)
            let user_id = parseInt(
                document
                    .querySelector('meta[name="user-id"]')
                    .getAttribute("content")
            );
            // console.log(user_id)
            if (id === user_id) {
                return true;
            } else {
                return false;
            }
        },

        async check_if_subordinate(contact_user_id) {
            let result = await axios
                .post("/api/users/check_subordinate", {
                    contact_user_id: contact_user_id,
                })
                .then((response) => {
                    return response.data.data;
                });
            console.log("result: ", result);

            if (result.id === 1) {
                // console.log("this is under the user")
                return "true";
            } else {
                // console.log("this is not under the user")
                return "false";
            }
        },
    },
};
</script>
