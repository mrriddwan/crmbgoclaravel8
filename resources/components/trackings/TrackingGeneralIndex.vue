<template>
    <div class="container">
        <h1
            class="items-center text-center text-5xl text-white font-extrabold bg-orange-500 px-2 rounded-md"
        >
            Tracking - General
        </h1>

        <div class="flex">
            <div class="py-2 px-2">
                <router-link
                    to="/tracking/general/create"
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
                        (can('export general master') ||
                            is('admin | super-admin')) &&
                        (view_type === 'master' ||
                            view_type === 'master_report')
                    "
                >
                    <download-excel
                        :data="tracking_generals.data"
                        :fields="general_master_fields"
                        worksheet="General Master Summary"
                        name="General Master Summary.xls"
                        class="btn btn-success btn-sm text-xs"
                    >
                        <ArrowTopRightOnSquareIcon
                            class="h-5 w-5 mr-1 inline-block"
                        />
                        Export master
                    </download-excel>
                </div>
                <div
                    class="px-2"
                    v-if="
                        (can('export general wip') ||
                            is('admin | super-admin')) &&
                        (view_type === 'wip' || view_type === 'wip_report')
                    "
                >
                    <download-excel
                        :data="tracking_generals.data"
                        :fields="general_wip_fields"
                        worksheet="General WIP Summary"
                        name="General WIP Summary.xls"
                        class="btn btn-success btn-sm text-xs"
                    >
                        <ArrowTopRightOnSquareIcon
                            class="h-5 w-5 mr-1 inline-block"
                        />
                        Export WIP
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
                    <option value="master_report">Report(Master)</option>
                    <option value="wip_report">Report(WIP)</option>
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
                            <th class="py-3">
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
                            <th class="py-3 w-max">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('division_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        BGOC
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'division_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'division_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'division_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedDivision"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="division in divisions.data"
                                            :key="division.id"
                                            :value="division.id"
                                        >
                                            {{ division.name }}
                                        </option>
                                    </select>
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

                            <th
                                class="py-3"
                                v-if="
                                    can('view tracking general amount') ||
                                    is('admin | super-admin')
                                "
                            >
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_amount')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Amount
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
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6 w-32">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('category_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Product
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
                                >
                                    <select
                                        v-model="selectedCategory"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="category in categories.data"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-12 w-32">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('category_description')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Product <br />
                                        Description
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
                                        Type
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
                                        Artwork <br />
                                        Format
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'art_format')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'art_format'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'art_format'
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
                                            change_sort('art_frequency')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Artwork <br />
                                        Frequency
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'art_frequency')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'art_frequency'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'art_frequency'
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
                                            change_sort('general_reach')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        REACH
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'general_reach')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'general_reach'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'general_reach'
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
                                            change_sort('general_tenure')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Tenure
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_tenure'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'general_tenure'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'general_tenure'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12 w-16">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_startdate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Start <br />
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_startdate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'general_startdate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'general_startdate'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12 w-16">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        End <br />
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_enddate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'general_enddate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'general_enddate'
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
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('progress')"
                                        class="text-white inline-flex"
                                    >
                                        Status
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'progress')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'progress'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'progress'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedResult"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option class="text-xs" value="Pending">
                                            Pending
                                        </option>
                                        <option
                                            class="text-xs"
                                            value="Completed"
                                        >
                                            Completed
                                        </option>
                                    </select>
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
                    <tbody class="mt-2 text-left">
                        <tr v-show="buffering">
                            <td
                                class="text-center text-sm font-bold"
                                colspan="30"
                            >
                                Loading . .
                            </td>
                        </tr>
                        <tr
                            v-for="(tracking, index) in tracking_generals.data"
                            :key="tracking.id"
                        >
                            <td class="text-xs">{{ index + 1 }}</td>
                            <td class="text-xs">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.division_name }}
                            </td>
                            <td class="text-xs">
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
                            <td
                                class="text-xs"
                                v-if="
                                    can('view tracking general amount') ||
                                    is('admin | super-admin')
                                "
                            >
                                RM
                                {{
                                    tracking.general_amount.toLocaleString(
                                        "en-US"
                                    )
                                }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.category_name }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.category_description }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.general_type }}
                            </td>

                            <td class="text-xs">
                                {{ tracking.art_format }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.art_frequency }}
                            </td>
                            <td class="text-xs">
                                {{
                                    tracking.general_reach.toLocaleString(
                                        "en-US"
                                    )
                                }}
                            </td>
                            <td class="text-xs">
                                {{
                                    Math.round(
                                        (tracking.general_tenure / 30) * 10
                                    ) / 10
                                }}
                                <br />
                                month(s)
                            </td>
                            <td class="text-xs">
                                {{ showToday(tracking.general_startdate) }}
                            </td>
                            <td class="text-xs">
                                {{ showToday(tracking.general_enddate) }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.general_remark }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.progress }}
                            </td>
                            <td class="text-xs">
                                <router-link
                                    :to="{
                                        name: 'tracking_general_edit',
                                        params: { id: tracking.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="deleteMasterGeneral(tracking.id)"
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
                            <th class="py-3 w-max">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('division_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        BGOC
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'division_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'division_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'division_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedDivision"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="division in divisions.data"
                                            :key="division.id"
                                            :value="division.id"
                                        >
                                            {{ division.name }}
                                        </option>
                                    </select>
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
                                        Product
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
                                >
                                    <select
                                        v-model="selectedCategory"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="category in categories.data"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.name }}
                                        </option>
                                    </select>
                                </div>
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
                                        Product <br />
                                        Description
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
                                        Type
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
                            <th
                                class="py-3"
                                v-if="
                                    can('view tracking general amount') ||
                                    is('admin | super-admin')
                                "
                            >
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_amount')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Amount
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
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('frequency_no')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Frequency
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'frequency_no')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'frequency_no'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'frequency_no'
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
                                <div class="text-sm text-center h-6 w-14">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_startdate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Start <br />
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_startdate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'general_startdate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'general_startdate'
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
                                <div class="text-sm text-center h-6 w-14">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        End <br />
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_enddate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'general_enddate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'general_enddate'
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
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Art <br />
                                        Chase
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Art <br />
                                        Received
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Art <br />
                                        ToDo
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        C&S <br />
                                        Sent
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        C&S <br />
                                        Record
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Schedule <br />
                                        Date
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Report
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Client <br />
                                        Posting
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Actual Live <br />
                                        Date
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('wip_progress')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Status
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'wip_progress')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'wip_progress'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'wip_progress'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedResult"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option class="text-xs" value="Pending">
                                            Pending
                                        </option>
                                        <option
                                            class="text-xs"
                                            value="Completed"
                                        >
                                            Completed
                                        </option>
                                    </select>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6 text-white">
                                    Action
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-left">
                        <tr v-show="buffering">
                            <td
                                class="text-center text-sm font-bold"
                                colspan="30"
                            >
                                Loading . .
                            </td>
                        </tr>
                        <tr
                            v-for="(tracking, index) in tracking_generals.data"
                            :key="tracking.id"
                        >
                            <td class="text-xs border">{{ index + 1 }}</td>
                            <td class="text-xs border">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="text-xs border">
                                {{ tracking.division_name }}
                            </td>
                            <td class="text-xs border">
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
                            <td class="text-xs border">
                                {{ tracking.category_name }}
                            </td>
                            <td class="text-xs border">
                                {{ tracking.general_category_description }}
                            </td>
                            <td class="text-xs border">
                                {{ tracking.general_type }}
                            </td>
                            <td
                                class="text-xs border"
                                v-if="
                                    can('view tracking general amount') ||
                                    is('admin | super-admin')
                                "
                            >
                                RM
                                {{
                                    tracking.general_amount.toLocaleString(
                                        "en-US"
                                    )
                                }}
                            </td>
                            <td class="text-xs border">
                                {{
                                    tracking.frequency_no +
                                    " / " +
                                    tracking.general_art_freq
                                }}
                            </td>
                            <td class="text-xs border">
                                {{ showToday(tracking.general_startdate) }}
                            </td>
                            <td class="text-xs border">
                                {{ showToday(tracking.general_enddate) }}
                            </td>
                            <!-- style="background-color: yellow" -->

                            <td class="text-xs text-center border">
                                <div
                                    v-if="!tracking.art_chase_date"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.art_chase_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.art_chase_date) }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.art_chase_date) }}
                                </div>
                                <div
                                    v-if="!tracking.art_chase_user"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.art_chase_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-if="!tracking.art_chase_remark"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.art_chase_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_remark }}
                                </div>
                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.art_chase_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center bg-amber-600 border">
                                <div
                                    v-if="!tracking.art_received_date"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.art_received_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.art_received_date) }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.art_received_date) }}
                                </div>
                                <!-- Art received user-->
                                <div
                                    v-if="!tracking.art_received_user"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.art_received_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_received_user.name }}
                                </div>

                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_received_user.name }}
                                </div>
                                <!-- Art received remark-->
                                <div
                                    v-if="!tracking.art_received_remark"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.art_received_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_received_remark }}
                                </div>

                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.art_received_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Art todo date-->
                                <div
                                    v-if="!tracking.art_todo_date"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.art_todo_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.art_todo_date) }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.art_todo_date) }}
                                </div>
                                <!-- Art todo user-->
                                <div
                                    v-if="!tracking.art_todo_user"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.art_todo_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_todo_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_todo_user.name }}
                                </div>
                                <!-- Art todo remark-->
                                <div
                                    v-if="!tracking.art_todo_remark"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.art_todo_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_todo_remark }}
                                </div>

                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.art_todo_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Art cns sent date-->
                                <div
                                    v-if="!tracking.cns_sent_date"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.cns_sent_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.cns_sent_date) }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.cns_sent_date) }}
                                </div>
                                <!-- Art cns sent user-->
                                <div
                                    v-if="!tracking.cns_sent_user"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.cns_sent_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.cns_sent_user.name }}
                                </div>

                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.cns_sent_user.name }}
                                </div>
                                <!-- Art cns sent remark-->
                                <div
                                    v-if="!tracking.cns_sent_remark"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.cns_sent_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.cns_sent_remark }}
                                </div>

                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.cns_sent_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Art cns record date-->
                                <div
                                    v-if="!tracking.cns_record_date"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.cns_record_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.cns_record_date) }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.cns_record_date) }}
                                </div>
                                <!-- Art cns record user-->
                                <div
                                    v-if="!tracking.cns_record_user"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.cns_record_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.cns_record_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.cns_record_user.name }}
                                </div>
                                <!-- Art cns record remark-->
                                <div
                                    v-if="!tracking.cns_record_remark"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.cns_record_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.cns_record_remark }}
                                </div>
                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.cns_record_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Art cns schedule date -->
                                <div
                                    v-if="!tracking.schedule_date"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.schedule_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.schedule_date) }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.schedule_date) }}
                                </div>
                                <!-- Art cns schedule user -->
                                <div
                                    v-if="!tracking.schedule_user"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.schedule_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.schedule_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.schedule_user.name }}
                                </div>
                                <!-- Art cns schedule remark -->
                                <div
                                    v-if="!tracking.schedule_remark"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.schedule_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.schedule_remark }}
                                </div>
                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.schedule_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Art report date -->
                                <div
                                    v-if="!tracking.report_date"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.report_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.report_date) }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.report_date) }}
                                </div>
                                <!-- Art report user -->
                                <div
                                    v-if="!tracking.report_user"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.report_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.report_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.report_user.name }}
                                </div>
                                <!-- Art report remark -->
                                <div
                                    v-if="!tracking.report_remark"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.report_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.report_remark }}
                                </div>
                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.report_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Client posting date -->
                                <div
                                    v-if="!tracking.client_posting_date"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="
                                        tracking.client_posting_done === 2
                                    "
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{
                                        showToday(tracking.client_posting_date)
                                    }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{
                                        showToday(tracking.client_posting_date)
                                    }}
                                </div>
                                <!-- Client posting user -->
                                <div
                                    v-if="!tracking.client_posting_user"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="
                                        tracking.client_posting_done === 2
                                    "
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.client_posting_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.client_posting_user.name }}
                                </div>
                                <!-- Client posting remark -->
                                <div
                                    v-if="!tracking.client_posting_remark"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="
                                        tracking.client_posting_done === 2
                                    "
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.client_posting_remark }}
                                </div>
                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.client_posting_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Actual live date -->
                                <div
                                    v-if="!tracking.actual_live_date"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.actual_live_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.actual_live_date) }}
                                </div>

                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.actual_live_date) }}
                                </div>
                                <!-- Actual live user -->
                                <div
                                    v-if="!tracking.actual_live_user"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.actual_live_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.actual_live_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.actual_live_user.name }}
                                </div>
                                <!-- Actual live remark -->
                                <div
                                    v-if="!tracking.actual_live_remark"
                                    class="rounded-md p-1 mb-1 text-yellow-300"
                                ></div>
                                <div
                                    v-else-if="tracking.actual_live_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.actual_live_remark }}
                                </div>
                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.actual_live_remark }}
                                </div>
                            </td>
                            <!-- WIP remark -->
                            <td class="text-xs text-center border">
                                {{ tracking.wip_remark }}
                            </td>

                            <td class="text-xs text-center border">
                                {{ tracking.wip_progress }}
                            </td>
                            <td class="text-xs text-center border">
                                <router-link
                                    :to="{
                                        name: 'tracking_wip_edit',
                                        params: { id: tracking.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="deleteWIPGeneral(tracking.id)"
                                >
                                    <TrashIcon class="h-3 w-3" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="view_type === 'master_report'"
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
                            <th class="py-3">
                                <div class="text-sm text-center h-12 w-16">
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
                            <th class="py-3 w-max">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('division_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        BGOC
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'division_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'division_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'division_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedDivision"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="division in divisions.data"
                                            :key="division.id"
                                            :value="division.id"
                                        >
                                            {{ division.name }}
                                        </option>
                                    </select>
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
                                <div class="text-sm text-center h-6 w-max">
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

                            <th
                                class="py-3"
                                v-if="
                                    can('view tracking general amount') ||
                                    is('admin | super-admin')
                                "
                            >
                                <div class="text-sm text-center h-12">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_amount')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Amount
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
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6 w-28">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('category_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Product
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
                                >
                                    <select
                                        v-model="selectedCategory"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="category in categories.data"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.name }}
                                        </option>
                                    </select>
                                </div>
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
                                        Product <br />
                                        Description
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
                                        Type
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
                                        Artwork <br />
                                        Format
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'art_format')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'art_format'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'art_format'
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
                                            change_sort('art_frequency')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Artwork <br />
                                        Frequency
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'art_frequency')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'art_frequency'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'art_frequency'
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
                                            change_sort('general_reach')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        REACH
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'general_reach')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'general_reach'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'general_reach'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12 w-14">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_tenure')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Tenure
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_tenure'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'general_tenure'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'general_tenure'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12 w-16">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_startdate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Start <br />
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_startdate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'general_startdate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'general_startdate'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-12 w-16">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        End <br />
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_enddate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'general_enddate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'general_enddate'
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
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('progress')"
                                        class="text-white inline-flex"
                                    >
                                        Status
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'progress')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'progress'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'progress'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedResult"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option class="text-xs" value="Pending">
                                            Pending
                                        </option>
                                        <option
                                            class="text-xs"
                                            value="Completed"
                                        >
                                            Completed
                                        </option>
                                    </select>
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
                    <tbody class="mt-2 text-left">
                        <tr v-show="buffering">
                            <td
                                class="text-center text-sm font-bold"
                                colspan="30"
                            >
                                Loading . .
                            </td>
                        </tr>
                        <tr
                            v-for="(tracking, index) in tracking_generals.data"
                            :key="tracking.id"
                        >
                            <td class="text-xs text-left">{{ index + 1 }}</td>
                            <td class="text-xs text-left">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="text-xs text-left">
                                {{ tracking.division_name }}
                            </td>
                            <td class="text-xs text-left">
                                {{ tracking.user_name }}
                            </td>
                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs text-left h-6 w-24"
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
                            <td
                                class="text-xs text-left"
                                v-if="
                                    can('view tracking general amount') ||
                                    is('admin | super-admin')
                                "
                            >
                                RM
                                {{
                                    tracking.general_amount.toLocaleString(
                                        "en-US"
                                    )
                                }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.category_name }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.category_description }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.general_type }}
                            </td>

                            <td class="text-xs">
                                {{ tracking.art_format }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.art_frequency }}
                            </td>
                            <td class="text-xs">
                                {{
                                    tracking.general_reach.toLocaleString(
                                        "en-US"
                                    )
                                }}
                            </td>
                            <td class="text-xs">
                                {{
                                    Math.round(
                                        (tracking.general_tenure / 30) * 10
                                    ) / 10
                                }}
                                <br />
                                month(s)
                            </td>
                            <td class="text-xs">
                                {{ showToday(tracking.general_startdate) }}
                            </td>
                            <td class="text-xs">
                                {{ showToday(tracking.general_enddate) }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.general_remark }}
                            </td>
                            <td class="text-xs">
                                {{ tracking.progress }}
                            </td>
                            <td class="text-xs text-center">
                                <router-link
                                    :to="{
                                        name: 'tracking_general_edit',
                                        params: { id: tracking.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="deleteMasterGeneral(tracking.id)"
                                >
                                    <TrashIcon class="h-3 w-3" />
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-if="view_type === 'wip_report'"
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto container w-full"
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
                                <div class="text-sm text-center h-6 w-16">
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
                            <th class="py-3 w-max">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('division_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        BGOC
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'division_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'division_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'division_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedDivision"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="division in divisions.data"
                                            :key="division.id"
                                            :value="division.id"
                                        >
                                            {{ division.name }}
                                        </option>
                                    </select>
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

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('category_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Product
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
                                >
                                    <select
                                        v-model="selectedCategory"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="category in categories.data"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.name }}
                                        </option>
                                    </select>
                                </div>
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
                                        Product <br />
                                        Description
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
                                        Type
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
                            <th
                                class="py-3"
                                v-if="
                                    can('view tracking general amount') ||
                                    is('admin | super-admin')
                                "
                            >
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_amount')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Amount
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
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('frequency_no')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Frequency
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'frequency_no')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'frequency_no'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'frequency_no'
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
                                <div class="text-sm text-center h-6 w-16">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_startdate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Start <br />
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_startdate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'general_startdate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'general_startdate'
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
                                <div class="text-sm text-center h-6 w-16">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('general_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        End <br />
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'general_enddate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'general_enddate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'general_enddate'
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
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Art <br />
                                        Chase
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Art <br />
                                        Received
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Art <br />
                                        ToDo
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        C&S <br />
                                        Sent
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        C&S <br />
                                        Record
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Schedule <br />
                                        Date
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Report
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Client <br />
                                        Posting
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Actual Live <br />
                                        Date
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
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

                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent=""
                                        class="text-white inline-flex"
                                    >
                                        Remark
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('wip_progress')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Status
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'wip_progress')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'wip_progress'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'wip_progress'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedResult"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option class="text-xs" value="Pending">
                                            Pending
                                        </option>
                                        <option
                                            class="text-xs"
                                            value="Completed"
                                        >
                                            Completed
                                        </option>
                                    </select>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6 text-white">
                                    Action
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-left">
                        <tr v-show="buffering">
                            <td
                                class="text-center text-sm font-bold"
                                colspan="30"
                            >
                                Loading . .
                            </td>
                        </tr>
                        <tr
                            v-for="(tracking, index) in tracking_generals.data"
                            :key="tracking.id"
                        >
                            <td class="text-xs border">{{ index + 1 }}</td>
                            <td class="text-xs border">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="text-xs border">
                                {{ tracking.division_name }}
                            </td>
                            <td class="text-xs border">
                                {{ tracking.user_name }}
                            </td>
                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs h-6 w-24 border"
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
                            <td class="text-xs border">
                                {{ tracking.category_name }}
                            </td>
                            <td class="text-xs border">
                                {{ tracking.general_category_description }}
                            </td>
                            <td class="text-xs border">
                                {{ tracking.general_type }}
                            </td>
                            <td
                                class="text-xs border"
                                v-if="
                                    can('view tracking general amount') ||
                                    is('admin | super-admin')
                                "
                            >
                                RM
                                {{
                                    tracking.general_amount.toLocaleString(
                                        "en-US"
                                    )
                                }}
                            </td>
                            <td class="text-xs border">
                                {{
                                    tracking.frequency_no +
                                    " / " +
                                    tracking.general_art_freq
                                }}
                            </td>
                            <td class="text-xs border">
                                {{ this.showToday(tracking.general_startdate) }}
                            </td>
                            <td class="text-xs border">
                                {{ this.showToday(tracking.general_enddate) }}
                            </td>
                            <!-- style="background-color: yellow" -->

                            <td class="text-xs text-center border">
                                <div class="flex">
                                    <div
                                        v-if="!tracking.art_chase_date"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.art_chase_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ showToday(tracking.art_chase_date) }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-green-300 rounded-md p-1 mb-1"
                                    >
                                        {{ showToday(tracking.art_chase_date) }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_chase_user"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.art_chase_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.art_chase_user.name }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-blue-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.art_chase_user.name }}
                                    </div>
                                    <div
                                        v-if="!tracking.art_chase_remark"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.art_chase_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.art_chase_remark }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-indigo-300 rounded-md p-1 w-max mr-1"
                                    >
                                        {{ tracking.art_chase_remark }}
                                    </div>
                                </div>
                            </td>

                            <td class="text-xs text-center bg-amber-600 border">
                                <div class="flex">
                                    <div
                                        v-if="!tracking.art_received_date"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.art_received_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{
                                            showToday(
                                                tracking.art_received_date
                                            )
                                        }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-green-300 rounded-md p-1 mb-1"
                                    >
                                        {{
                                            showToday(
                                                tracking.art_received_date
                                            )
                                        }}
                                    </div>
                                    <!-- Art received user-->
                                    <div
                                        v-if="!tracking.art_received_user"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.art_received_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.art_received_user.name }}
                                    </div>

                                    <div
                                        v-else
                                        class="bg-blue-300 rounded-md p-1 mb-1"
                                    >
                                        {{ tracking.art_received_user.name }}
                                    </div>
                                    <!-- Art received remark-->
                                    <div
                                        v-if="!tracking.art_received_remark"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.art_received_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.art_received_remark }}
                                    </div>

                                    <div
                                        v-else
                                        class="bg-indigo-300 rounded-md p-1"
                                    >
                                        {{ tracking.art_received_remark }}
                                    </div>
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Art todo date-->
                                <div class="flex">
                                    <div
                                        v-if="!tracking.art_todo_date"
                                        class="rounded-md p-1 mb-1 text-yellow-300"
                                    ></div>
                                    <div
                                        v-else-if="tracking.art_todo_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ showToday(tracking.art_todo_date) }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-green-300 rounded-md p-1 mb-1"
                                    >
                                        {{ showToday(tracking.art_todo_date) }}
                                    </div>
                                    <!-- Art todo user-->
                                    <div
                                        v-if="!tracking.art_todo_user"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="tracking.art_todo_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.art_todo_user.name }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-blue-300 rounded-md p-1 mb-1"
                                    >
                                        {{ tracking.art_todo_user.name }}
                                    </div>
                                    <!-- Art todo remark-->
                                    <div
                                        v-if="!tracking.art_todo_remark"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="tracking.art_todo_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.art_todo_remark }}
                                    </div>

                                    <div
                                        v-else
                                        class="bg-indigo-300 rounded-md p-1"
                                    >
                                        {{ tracking.art_todo_remark }}
                                    </div>
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Art cns sent date-->
                                <div class="flex">
                                    <div
                                        v-if="!tracking.cns_sent_date"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="tracking.cns_sent_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ showToday(tracking.cns_sent_date) }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-green-300 rounded-md p-1 mb-1"
                                    >
                                        {{ showToday(tracking.cns_sent_date) }}
                                    </div>
                                    <!-- Art cns sent user-->
                                    <div
                                        v-if="!tracking.cns_sent_user"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="tracking.cns_sent_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.cns_sent_user.name }}
                                    </div>

                                    <div
                                        v-else
                                        class="bg-blue-300 rounded-md p-1 mb-1"
                                    >
                                        {{ tracking.cns_sent_user.name }}
                                    </div>
                                    <!-- Art cns sent remark-->
                                    <div
                                        v-if="!tracking.cns_sent_remark"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="tracking.cns_sent_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.cns_sent_remark }}
                                    </div>

                                    <div
                                        v-else
                                        class="bg-indigo-300 rounded-md p-1"
                                    >
                                        {{ tracking.cns_sent_remark }}
                                    </div>
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Art cns record date-->
                                <div class="flex">
                                    <div
                                        v-if="!tracking.cns_record_date"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.cns_record_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{
                                            showToday(tracking.cns_record_date)
                                        }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-green-300 rounded-md p-1 mb-1"
                                    >
                                        {{
                                            showToday(tracking.cns_record_date)
                                        }}
                                    </div>
                                    <!-- Art cns record user-->
                                    <div
                                        v-if="!tracking.cns_record_user"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.cns_record_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.cns_record_user.name }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-blue-300 rounded-md p-1 mb-1"
                                    >
                                        {{ tracking.cns_record_user.name }}
                                    </div>
                                    <!-- Art cns record remark-->
                                    <div
                                        v-if="!tracking.cns_record_remark"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.cns_record_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.cns_record_remark }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-indigo-300 rounded-md p-1"
                                    >
                                        {{ tracking.cns_record_remark }}
                                    </div>
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Art cns schedule date -->
                                <div class="flex">
                                    <div
                                        v-if="!tracking.schedule_date"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="tracking.schedule_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ showToday(tracking.schedule_date) }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-green-300 rounded-md p-1 mb-1"
                                    >
                                        {{ showToday(tracking.schedule_date) }}
                                    </div>
                                    <!-- Art cns schedule user -->
                                    <div
                                        v-if="!tracking.schedule_user"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="tracking.schedule_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.schedule_user.name }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-blue-300 rounded-md p-1 mb-1"
                                    >
                                        {{ tracking.schedule_user.name }}
                                    </div>
                                    <!-- Art cns schedule remark -->
                                    <div
                                        v-if="!tracking.schedule_remark"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="tracking.schedule_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.schedule_remark }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-indigo-300 rounded-md p-1"
                                    >
                                        {{ tracking.schedule_remark }}
                                    </div>
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Art report date -->

                                <div class="flex">
                                    <div
                                        v-if="!tracking.report_date"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="tracking.report_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ showToday(tracking.report_date) }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-green-300 rounded-md p-1 mb-1"
                                    >
                                        {{ showToday(tracking.report_date) }}
                                    </div>
                                    <!-- Art report user -->
                                    <div
                                        v-if="!tracking.report_user"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="tracking.report_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.report_user.name }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-blue-300 rounded-md p-1 mb-1"
                                    >
                                        {{ tracking.report_user.name }}
                                    </div>
                                    <!-- Art report remark -->
                                    <div
                                        v-if="!tracking.report_remark"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="tracking.report_done === 2"
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.report_remark }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-indigo-300 rounded-md p-1"
                                    >
                                        {{ tracking.report_remark }}
                                    </div>
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Client posting date -->
                                <div class="flex">
                                    <div
                                        v-if="!tracking.client_posting_date"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.client_posting_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{
                                            showToday(
                                                tracking.client_posting_date
                                            )
                                        }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-green-300 rounded-md p-1 mb-1"
                                    >
                                        {{
                                            showToday(
                                                tracking.client_posting_date
                                            )
                                        }}
                                    </div>
                                    <!-- Client posting user -->
                                    <div
                                        v-if="!tracking.client_posting_user"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.client_posting_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.client_posting_user.name }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-blue-300 rounded-md p-1 mb-1"
                                    >
                                        {{ tracking.client_posting_user.name }}
                                    </div>
                                    <!-- Client posting remark -->
                                    <div
                                        v-if="!tracking.client_posting_remark"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.client_posting_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.client_posting_remark }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-indigo-300 rounded-md p-1"
                                    >
                                        {{ tracking.client_posting_remark }}
                                    </div>
                                </div>
                            </td>

                            <td class="text-xs text-center border">
                                <!-- Actual live date -->
                                <div class="flex">
                                    <div
                                        v-if="!tracking.actual_live_date"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.actual_live_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{
                                            showToday(tracking.actual_live_date)
                                        }}
                                    </div>

                                    <div
                                        v-else
                                        class="bg-green-300 rounded-md p-1 mb-1"
                                    >
                                        {{
                                            showToday(tracking.actual_live_date)
                                        }}
                                    </div>
                                    <!-- Actual live user -->
                                    <div
                                        v-if="!tracking.actual_live_user"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.actual_live_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.actual_live_user.name }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-blue-300 rounded-md p-1 mb-1"
                                    >
                                        {{ tracking.actual_live_user.name }}
                                    </div>
                                    <!-- Actual live remark -->
                                    <div
                                        v-if="!tracking.actual_live_remark"
                                        class="rounded-md p-1 mb-1 text-yellow-300 w-max mr-1"
                                    ></div>
                                    <div
                                        v-else-if="
                                            tracking.actual_live_done === 2
                                        "
                                        class="bg-yellow-300 rounded-md p-1 mb-1 w-max mr-1"
                                    >
                                        {{ tracking.actual_live_remark }}
                                    </div>
                                    <div
                                        v-else
                                        class="bg-indigo-300 rounded-md p-1"
                                    >
                                        {{ tracking.actual_live_remark }}
                                    </div>
                                </div>
                            </td>
                            <td
                                v-if="
                                    check_id(tracking.user_id) ||
                                    is('supervisor | admin | super-admin')
                                "
                                class="items-center text-xs text-left h-6 w-24 border"
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
                            <!-- WIP remark -->
                            <td class="text-xs border text-left">
                                {{ tracking.wip_remark }}
                            </td>

                            <td class="text-xs border text-left">
                                {{ tracking.wip_progress }}
                            </td>
                            <td class="text-xs text-center border">
                                <router-link
                                    :to="{
                                        name: 'tracking_wip_edit',
                                        params: { id: tracking.id },
                                    }"
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-yellow-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                                <button
                                    class="mr-2 mb-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="deleteWIPGeneral(tracking.id)"
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
        // this.selectedUser = document
        //     .querySelector('meta[name="user-id"]')
        //     .getAttribute("content");
        this.getTrackingGenerals();
        this.getUsers();
        this.getCategories();
        this.getDivisions();
    },
    data() {
        return {
            tracking_generals: [],
            paginate: 100,

            search: "",

            sort_direction: "desc",
            sort_field: "created_at",
            buffering: false,
            // general_remark_visibility: false,
            // general_remark: null,
            view_type: "",
            selectedUser: "",
            selectedCategory: "",
            selectedResult: "",
            selectedDivision: "",
            users: [],
            categories: [],
            divisions: [],

            general_master_fields: {
                Date: "created_at",
                User: "user_name",
                Company: "company_name",
                BGOC: "division_name",
                Amount: "general_amount",
                Product: "category_name",
                "Product Description": "category_description",
                Type: "general_type",
                "Artwork Format": "art_format",
                "Artwork Frequency": "art_format",
                REACH: "general_reach",
                "Tenure (month)": {
                    callback: (value) => {
                        return `${
                            Math.round((value.general_tenure / 30) * 10) / 10
                        }`;
                    },
                },
                "Start Date": "general_startdate",
                "End Date": "general_enddate",
                Remark: "general_remark",
                Status: "progress",
                Jan: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-01`
                            ? value.general_amount
                            : "";
                    },
                },
                Feb: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-02`
                            ? value.general_amount
                            : "";
                    },
                },
                Mac: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-03`
                            ? value.general_amount
                            : "";
                    },
                },
                Apr: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-04`
                            ? value.general_amount
                            : "";
                    },
                },
                May: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-05`
                            ? value.general_amount
                            : "";
                    },
                },
                Jun: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-06`
                            ? value.general_amount
                            : "";
                    },
                },
                Jul: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-07`
                            ? value.general_amount
                            : "";
                    },
                },
                Aug: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-08`
                            ? value.general_amount
                            : "";
                    },
                },
                Sep: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-09`
                            ? value.general_amount
                            : "";
                    },
                },
                Oct: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-10`
                            ? value.general_amount
                            : "";
                    },
                },
                Nov: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-11`
                            ? value.general_amount
                            : "";
                    },
                },
                Dec: {
                    callback: (value) => {
                        return this.getMonth(value.created_at) ===
                            `${this.getYear(value.created_at)}-12`
                            ? value.general_amount
                            : "";
                    },
                },
            },

            general_wip_fields: {
                Date: {
                    callback: (value) => {
                        return `${this.showToday(value.created_at)}`;
                    },
                },
                User: "user_name",
                Company: "company_name",
                Product: "category_name",
                "Product Description": "general_category_description",
                Type: "general_type",
                Frequency: {
                    callback: (value) => {
                        return `${value.frequency_no} of ${value.general_art_freq}`;
                    },
                },
                "Start Date": "general_startdate",
                "End Date": "general_enddate",
                "Artwork Chase": {
                    callback: (value) => {
                        return value.art_chase_done === 1
                            ? `(${this.getDayMonth(value.art_chase_date)})`
                            : `${this.getDayMonth(value.art_chase_date)}`;
                    },
                },
                "Artwork Received": {
                    callback: (value) => {
                        return value.art_received_done === 1
                            ? `(${this.getDayMonth(value.art_received_date)})`
                            : `${this.getDayMonth(value.art_received_date)}`;
                    },
                },
                "Artwork To Do": {
                    callback: (value) => {
                        return value.art_todo_done === 1
                            ? `(${this.getDayMonth(value.art_todo_date)})`
                            : `${this.getDayMonth(value.art_todo_date)}`;
                    },
                },
                "C&S Sent": {
                    callback: (value) => {
                        return value.cns_sent_done === 1
                            ? `(${this.getDayMonth(value.cns_sent_date)})`
                            : `${this.getDayMonth(value.cns_sent_date)}`;
                    },
                },
                "C&S Record": {
                    callback: (value) => {
                        return value.cns_record_done === 1
                            ? `(${this.getDayMonth(value.cns_record_date)})`
                            : `${this.getDayMonth(value.cns_record_date)}`;
                    },
                },
                "Schedule Date": {
                    callback: (value) => {
                        return value.schedule_done === 1
                            ? `(${this.getDayMonth(value.schedule_date)})`
                            : `${this.getDayMonth(value.schedule_date)}`;
                    },
                },
                Report: {
                    callback: (value) => {
                        return value.report_done === 1
                            ? `(${this.getDayMonth(value.report_date)})`
                            : `${this.getDayMonth(value.report_date)}`;
                    },
                },
                "Client Posting": {
                    callback: (value) => {
                        return value.client_posting_done === 1
                            ? `(${this.getDayMonth(value.client_posting_date)})`
                            : `${this.getDayMonth(value.client_posting_date)}`;
                    },
                },
                "Live Date": {
                    callback: (value) => {
                        return value.actual_live_done === 1
                            ? `(${this.getDayMonth(value.actual_live_date)})`
                            : `${this.getDayMonth(value.actual_live_date)}`;
                    },
                },
                Remark: "wip_remark",
                Status: "wip_progress",
            },
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

        selectedDivision: function (value) {
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
                        this.selectedResult +
                        "&selectedDivision=" +
                        this.selectedDivision
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

        async getDivisions() {
            await axios
                .get("/api/trackings/division/index")
                .then((res) => {
                    this.divisions = res.data;
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

        getDayMonth(date) {
            let day_month = moment(date).format("DD-MM");
            return day_month;
        },

        getMonth(date) {
            let month = moment(date).format("YYYY-MM");
            return month;
        },

        getYear(date) {
            let year = moment(date).format("YYYY");
            return year;
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
