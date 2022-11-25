<template>
    <div class="container">
        <h1
            class="items-center text-center text-5xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
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

            <div
                class="py-2 px-2"
                v-if="can('export project') || is('admin | super-admin')"
            >
                <!-- <download-excel
                    :data="tracking_generals.data"
                    :fields="project_fields"
                    worksheet="tracking_generalsummary"
                    name="Project Summary.xls"
                    class="btn btn-success btn-sm"
                >
                    <ArrowTopRightOnSquareIcon
                        class="h-5 w-5 mr-1 inline-block"
                    />
                    Export
                </download-excel> -->
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
                <table class="table table-hover w-full mt-0">
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
                                <div class="text-sm text-center h-12">
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
                                <div class="text-sm text-center h-12">
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
                    <tbody class="mt-2">
                        <tr
                            v-for="(tracking, index) in tracking_generals.data"
                            :key="tracking.id"
                        >
                            <td class="text-xs text-center">{{ index + 1 }}</td>
                            <td class="text-xs text-center">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.user_name }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.company_name }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.category_name }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.category_description }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.general_type }}
                            </td>
                            <td
                                class="text-xs text-center"
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
                            <td class="text-xs text-center">
                                {{ tracking.art_format }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.art_frequency }}
                            </td>
                            <td class="text-xs text-center">
                                {{
                                    tracking.general_reach.toLocaleString(
                                        "en-US"
                                    )
                                }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.general_tenure }}
                            </td>
                            <td class="text-xs text-center">
                                {{ showToday(tracking.general_startdate) }}
                            </td>
                            <td class="text-xs text-center">
                                {{ showToday(tracking.general_enddate) }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.general_remark }}
                            </td>
                            <td class="text-xs text-center">
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
                <table class="table table-hover w-full mt-0">
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
                            <th class="py-3">
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
                                <div class="text-sm text-center h-6">
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
                                <div class="text-sm text-center h-6">
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
                                        <!-- <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'project_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span> -->
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
                                        <!-- <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'project_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span> -->
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
                                        <!-- <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'project_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span> -->
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
                                        <!-- <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'project_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span> -->
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
                                        <!-- <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'project_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span> -->
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
                                        <!-- <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'project_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span> -->
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
                                        <!-- <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'project_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span> -->
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
                                        <!-- <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'project_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span> -->
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
                                        <!-- <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'project_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span> -->
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
                                                !(
                                                    sort_field ==
                                                    'wip_progress'
                                                )
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
                    <tbody class="mt-2">
                        <tr
                            v-for="(tracking, index) in tracking_generals.data"
                            :key="tracking.id"
                        >
                            <td class="text-xs text-center">{{ index + 1 }}</td>
                            <td class="text-xs text-center">
                                {{ showToday(tracking.created_at) }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.user_name }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.company_name }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.category_name }}
                            </td>
                            <td class="text-xs text-center">
                                {{
                                    tracking.general_category_description
                                }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.general_type }}
                            </td>
                            <td
                                class="text-xs text-center"
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
                            <td class="text-xs text-center">
                                {{
                                    tracking.frequency_no +
                                    " / " +
                                    tracking.general_art_freq
                                }}
                            </td>
                            <td class="text-xs text-center">
                                {{
                                    tracking.general_startdate
                                }}
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.general_enddate }}
                            </td>
                            <!-- style="background-color: yellow" -->

                            <td class="text-xs text-center">
                                <div
                                    v-if="!tracking.art_chase_date"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
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
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
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
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
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

                            <td class="text-xs text-center bg-amber-600">
                                <div
                                    v-if="!tracking.art_received_date"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.art_received_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.art_received_date) }}
                                </div>
                                <div
                                    v-if="!tracking.art_received_user"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.art_received_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>

                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_received_user.name }}
                                </div>

                                <div
                                    v-if="!tracking.art_received_remark"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.art_received_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>

                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.art_received_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center">
                                <div
                                    v-if="!tracking.art_todo_date"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.art_todo_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.art_todo_date) }}
                                </div>

                                <div
                                    v-if="!tracking.art_todo_user"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.art_todo_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_todo_user.name }}
                                </div>

                                <div
                                    v-if="!tracking.art_todo_remark"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.art_todo_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>

                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.art_todo_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center">
                                <div
                                    v-if="!tracking.cns_sent_date"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.cns_sent_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.cns_sent_date) }}
                                </div>

                                <div
                                    v-if="!tracking.cns_sent_user"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.cns_sent_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>

                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.cns_sent_user.name }}
                                </div>

                                <div
                                    v-if="!tracking.cns_sent_remark"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.cns_sent_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>

                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.cns_sent_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center">
                                <div
                                    v-if="!tracking.cns_record_date"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.cns_record_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.cns_record_date) }}
                                </div>
                                <div
                                    v-if="!tracking.cns_record_user"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.cns_record_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.cns_record_user.name }}
                                </div>
                                <div
                                    v-if="!tracking.cns_record_remark"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.cns_record_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.cns_record_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center">
                                <div
                                    v-if="!tracking.schedule_date"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.schedule_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.schedule_date) }}
                                </div>
                                <div
                                    v-if="!tracking.schedule_user"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.schedule_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.schedule_user.name }}
                                </div>
                                <div
                                    v-if="!tracking.schedule_remark"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.schedule_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.schedule_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center">
                                <div
                                    v-if="!tracking.report_date"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.report_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.report_date) }}
                                </div>
                                <div
                                    v-if="!tracking.report_user"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.report_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.report_user.name }}
                                </div>
                                <div
                                    v-if="!tracking.report_remark"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.report_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.report_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center">
                                <div
                                    v-if="!tracking.client_posting_date"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.client_posting_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{
                                        showToday(tracking.client_posting_date)
                                    }}
                                </div>
                                <div
                                    v-if="!tracking.client_posting_user"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.client_posting_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.client_posting_user.name }}
                                </div>
                                <div
                                    v-if="!tracking.client_posting_remark"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.client_posting_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.client_posting_remark }}
                                </div>
                            </td>

                            <td class="text-xs text-center">
                                <div
                                    v-if="!tracking.actual_live_date"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.actual_live_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-green-300 rounded-md p-1 mb-1"
                                >
                                    {{ showToday(tracking.actual_live_date) }}
                                </div>
                                <div
                                    v-if="!tracking.actual_live_user"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.actual_live_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-blue-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.actual_live_user.name }}
                                </div>
                                <div
                                    v-if="!tracking.actual_live_remark"
                                    class="bg-yellow-300 rounded-md p-1 mb-1 text-yellow-300"
                                >
                                    Unset yet
                                </div>
                                <div
                                    v-else-if="tracking.actual_live_done === 2"
                                    class="bg-yellow-300 rounded-md p-1 mb-1"
                                >
                                    {{ tracking.art_chase_user.name }}
                                </div>
                                <div
                                    v-else
                                    class="bg-indigo-300 rounded-md p-1"
                                >
                                    {{ tracking.actual_live_remark }}
                                </div>
                            </td>
                            <td class="text-xs text-center">
                                {{ tracking.wip_remark }}
                            </td>
                            
                            <td class="text-xs text-center">
                                {{ tracking.wip_progress }}
                            </td>
                            <td class="text-xs text-center">
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

            sort_direction: "desc",
            sort_field: "created_at",
            // general_remark_visibility: false,
            // general_remark: null,
            view_type: "wip",
            selectedUser: "",
            selectedCategory: "",
            selectedResult: "",
            users: [],
            categories: [],

            general_fields: {
                // CS: {
                //     callback: (value) => {
                //         return `${value.user.name}`;
                //     },
                // },
                // "Start Date": "project_startdate",
                // "End Date": "project_enddate",
                // // Duration: "user_name",
                // Company: {
                //     callback: (value) => {
                //         return `${value.contact.name}`;
                //     },
                // },
                // Project: "project_name",
                // Remark: "general_remark",
                // "Entry Date": "updated_at",
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

        deleteProject(id) {
            if (!window.confirm("Confirm delete?")) {
                return;
            }
            axios.delete("/api/tracking_generals/delete/" + id);
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
    },
};
</script>
