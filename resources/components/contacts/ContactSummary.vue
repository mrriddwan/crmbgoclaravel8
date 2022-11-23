<template>
    <div class="w-max">
        <h1
            class="items-center text-center text-4xl text-white font-extrabold font-mono uppercase bg-slate-400 px-2 rounded-md"
        >
            Contact Summary
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
                <div class="grid grid-cols-1 items-left m-2">
                    <label>Year</label>
                    <input
                        v-model.lazy="selectedYear"
                        type="search"
                        class="form-control"
                        placeholder="Search + Press ENTER"
                    />
                </div>
                <div class="grid grid-cols-1 items-left m-2">
                    <label>Search in table</label>
                    <input
                        v-model.lazy="search"
                        type="search"
                        class="form-control"
                        placeholder="Search + Press ENTER"
                    />
                </div>
                <!-- <div
                    v-if="is('supervisor | admin | super-admin')"
                    class="grid grid-cols-1 items-left m-2 w-60"
                >
                    <label>View by</label>
                    <select
                        v-model="viewType"
                        class="form-control form-control-md text-md h-max w-60"
                    >
                        <option class="text-md w-48" value="todo">
                            Latest To Do
                        </option>
                        <option class="text-md w-48" value="action">
                            Latest Action
                        </option>
                    </select>
                </div> -->

                <div>
                    <div
                        v-if="
                            can('export contact summary') ||
                            is('admin | super-admin')
                        "
                    >
                        <download-excel
                            :data="contacts.data"
                            :fields="contact_fields"
                            worksheet="ContactSummary"
                            name="ContactSummary.xls"
                            class="btn btn-success btn-sm"
                        >
                            <ArrowTopRightOnSquareIcon
                                class="h-5 w-5 mr-1 inline-block"
                            />
                            Export
                        </download-excel>
                    </div>
                </div>
                <div class="py-1 inline-block">
                    <Pagination
                        :data="contacts"
                        @pagination-change-page="getContactsByTodo"
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
                                <div class="text-xs text-center h-6">
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
                                <div
                                    v-if="
                                        is('supervisor | admin | super-admin')
                                    "
                                    class="items-center text-xs text-center h-6 4"
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
                                            change_sort('status_name')
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
                                                !(sort_field == 'status_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'status_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'status_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6">
                                    <select
                                        v-model="selectedStatus"
                                        class="form-control form-control-sm"
                                    >
                                        <option value="">All</option>
                                        <option
                                            v-for="status in statuses.data"
                                            :key="status.id"
                                            :value="status.id"
                                        >
                                            {{ status.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('type_name')
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
                                                !(sort_field == 'type_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'type_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'type_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6">
                                    <div class="text-xs text-center h-6">
                                        <select
                                            v-model="selectedType"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="contact_type in types.data"
                                                :key="contact_type.id"
                                                :value="contact_type.id"
                                            >
                                                {{ contact_type.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </th>

                            <th class="w-10">
                                <div class="text-xs text-center h-6">
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
                                <div class="text-xs text-center h-6">
                                    <div class="text-xs text-center h-6">
                                        <select
                                            v-model="selectedCategory"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="category in categories.data"
                                                :key="category.id"
                                                :value="category.id"
                                            >
                                                {{ category.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('industry_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Industry
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'industry_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'industry_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'industry_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-xs text-center h-6">
                                    <div class="text-xs text-center h-6">
                                        <select
                                            v-model="selectedIndustry"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="industry in industries.data"
                                                :key="industry.id"
                                                :value="industry.id"
                                            >
                                                {{ industry.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </th>

                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('name')"
                                        class="text-white inline-flex"
                                    >
                                        Company
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">Jan</div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">Feb</div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">Mar</div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">Apr</div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">May</div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">June</div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">July</div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">Aug</div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">Sept</div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">Oct</div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">Nov</div>
                            </th>
                            <th class="text-white">
                                <div class="text-xs text-center">Dec</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr v-show="buffering" >
                            <td class="text-center text-sm font-bold" colspan="18">
                                Loading . .
                            </td>
                        </tr>
                        <tr
                            v-for="(contact, index) in contacts.data"
                            :key="contact.id"
                        >
                            <td class="text-xs break-normal">
                                {{ contact.user_name }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ contact.status_name }}
                            </td>
                            <td class="text-xs">{{ contact.type_name }}</td>
                            <td class="text-xs break-normal">
                                {{ contact.category_name }}
                            </td>
                            <td class="text-xs break-normal">
                                {{ contact.industry_name }}
                            </td>
                            <td class="text-xs break-normal">
                                <router-link
                                    :to="`/contact/${contact.id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        contact.name
                                    }}</a>
                                </router-link>
                            </td>
                            <td
                                v-if="contact.summary_todo['Jan2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `Jan` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }} </span
                                    ><span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary_todo['Feb2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `Feb` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                        <br /> </span
                                    ><span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary_todo['Mar2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `Mar` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                        <br /> </span
                                    ><span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary_todo['Apr2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `Apr` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                        <br /> </span
                                    ><span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary_todo['May2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `May` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                        <br /> </span
                                    ><span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary_todo['Jun2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `Jun` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                        <br /> </span
                                    ><span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary_todo['Jul2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `Jul` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                        <br /> </span
                                    ><span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary_todo['Aug2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `Aug` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }} </span
                                    ><span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary_todo['Sep2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `Sep` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }} </span
                                    ><span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary_todo['Oct2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `Oct` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }} </span
                                    ><span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary_todo['Nov2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `Nov` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }} </span
                                    ><span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>

                            <td
                                v-if="contact.summary_todo['Dec2022']"
                                class="text-xs"
                            >
                                <span
                                    v-for="(summary_info, index) in contact
                                        .summary_todo[
                                        `Dec` + this.selectedYear
                                    ]"
                                    :key="summary_info.id"
                                >
                                    <span
                                        v-if="
                                            index === 0 &&
                                            !summary_info['action']
                                        "
                                        class="w-max bg-red-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                    <span
                                        v-if="
                                            index === 0 &&
                                            summary_info['action']
                                        "
                                        class="w-max bg-green-300 px-1 py-1 rounded-md text-xs"
                                    >
                                        {{
                                            showToday(summary_info["todo_date"])
                                        }}
                                    </span>
                                </span>
                            </td>
                            <td v-else></td>
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
        this.getStatus();
        this.getTypes();
        this.selectedUser = document
            .querySelector('meta[name="user-id"]')
            .getAttribute("content");
        this.getUsers();
        this.getCategories();
        this.getIndustries();
        this.getContactsByTodo();
    },
    data() {
        return {
            contacts: [],
            statuses: [],
            users: [],
            types: [],
            industries: [],
            categories: [],

            paginate: 50,
            moment: moment,
            selectPage: false,
            selectAll: false,
            checked: [],
            url: "",
            viewType: "todo",
            buffering: false,

            search: "",
            selectedYear: "",
            selectedStatus: "",
            selectedUser: "",
            selectedType: "",
            selectedCategory: "",
            selectedIndustry: "",

            sort_direction: "asc",
            sort_field: "name",
            currentDate: "",

            contact_fields: {
                Company: "name",
                Status: "status_name",
                Type: "type_name",
                User: "user_name",
                "Contact Product": "category_name",
                Industry: "industry_name",
                Jan: {
                    callback: (value) => {
                        if (!value.summary_todo[`Jan` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`Jan` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                `${
                                    value.summary_todo[
                                        `Jan` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                                
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `Jan` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`;
                        }
                    },
                },
                Feb: {
                    callback: (value) => {
                        if (!value.summary_todo[`Feb` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`Feb` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                ` ${
                                    value.summary_todo[
                                        `Feb` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                                
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `Feb` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`;
                        }
                    },
                },
                Mar: {
                    callback: (value) => {
                        if (!value.summary_todo[`Mar` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`Mar` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                ` ${
                                    value.summary_todo[
                                        `Mar` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                                
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `Mar` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`;
                        }
                    },
                },
                Apr: {
                    callback: (value) => {
                        if (!value.summary_todo[`Apr` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`Apr` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                ` ${
                                    value.summary_todo[
                                        `Apr` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                                
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `Apr` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`;
                        }
                    },
                },
                May: {
                    callback: (value) => {
                        if (!value.summary_todo[`May` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`May` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                ` ${
                                    value.summary_todo[
                                        `May` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                                
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `May` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`;
                        }
                    },
                },
                Jun: {
                    callback: (value) => {
                        if (!value.summary_todo[`Jun` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`Jun` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                ` ${
                                    value.summary_todo[
                                        `Jun` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                                
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `Jun` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`;
                        }
                    },
                },
                Jul: {
                    callback: (value) => {
                        if (!value.summary_todo[`Jul` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`Jul` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                ` ${
                                    value.summary_todo[
                                        `Jul` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                                
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `Jul` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`;
                        }
                    },
                },
                Aug: {
                    callback: (value) => {
                        if (!value.summary_todo[`Aug` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`Aug` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                ` ${
                                    value.summary_todo[
                                        `Aug` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                                
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `Aug` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`;
                        }
                    },
                },
                Sep: {
                    callback: (value) => {
                        if (!value.summary_todo[`Sep` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`Sep` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                ` ${
                                    value.summary_todo[
                                        `Sep` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                                
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `Sep` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`
                        }
                    },
                },
                Oct: {
                    callback: (value) => {
                        if (!value.summary_todo[`Oct` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`Oct` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                ` ${
                                    value.summary_todo[
                                        `Oct` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `Oct` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`
                        }
                    },
                },
                Nov: {
                    callback: (value) => {
                        if (!value.summary_todo[`Nov` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`Nov` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                ` ${
                                    value.summary_todo[
                                        `Nov` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                                
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `Nov` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`
                        }
                    },
                },
                Dec: {
                    callback: (value) => {
                        if (!value.summary_todo[`Dec` + this.selectedYear]) {
                            return " ";
                        } else if (
                            !value.summary_todo[`Dec` + this.selectedYear][0][
                                "action"
                            ]
                        ) {
                            return (
                                
                                ` ${
                                    value.summary_todo[
                                        `Dec` + this.selectedYear
                                    ][0]["todo_date"]
                                }`
                            );
                        } else {
                            return `(( ` +  `${
                                value.summary_todo[
                                    `Dec` + this.selectedYear
                                ][0]["todo_date"]
                            }` + ` ))`
                        }
                    },
                },
            },
        };
    },
    watch: {
        paginate: function (value) {
            this.contacts = [];
            this.getContactsByTodo();
        },
        search: function (value) {
            this.contacts = [];
            this.getContactsByTodo();
        },
        selectedStatus: function (value) {
            this.contacts = [];
            this.getContactsByTodo();
        },
        selectedUser: function (value) {
            this.contacts = [];
            this.getContactsByTodo();
        },
        selectedType: function (value) {
            this.contacts = [];
            this.getContactsByTodo();
        },
        selectedCategory: function (value) {
            this.contacts = [];
            this.getContactsByTodo();
        },
        selectedIndustry: function (value) {
            this.contacts = [];
            this.getContactsByTodo();
        },

        selectPage: function (value) {
            this.checked = [];
            if (value) {
                this.contacts.data.forEach((contact) => {
                    this.checked.push(contact.id);
                });
            } else {
                this.checked = [];
                this.selectAll = false;
            }
        },

        checked: function (value) {
            this.url = "/api/contacts/exportSummary/" + this.checked;
        },
    },

    computed: {},

    methods: {
        getContactsByTodo(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            this.buffering = true;
            axios
                .get(
                    "/api/contacts/summary_todo?" +
                        "q=" +
                        this.search +
                        "&selectedYear=" +
                        this.selectedYear +
                        "&selectedStatus=" +
                        this.selectedStatus +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedType=" +
                        this.selectedType +
                        "&selectedCategory=" +
                        this.selectedCategory +
                        "&selectedIndustry=" +
                        this.selectedIndustry +
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
                    this.buffering = false;
                    this.contacts = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getContactsByAction(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/contacts/summary_action?" +
                        "q=" +
                        this.search +
                        "&selectedYear=" +
                        this.selectedYear +
                        "&selectedStatus=" +
                        this.selectedStatus +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedType=" +
                        this.selectedType +
                        "&selectedCategory=" +
                        this.selectedCategory +
                        "&selectedIndustry=" +
                        this.selectedIndustry +
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
                    this.contacts = res.data;
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

        async getTypes() {
            await axios
                .get("/api/contacts/type/index")
                .then((res) => {
                    this.types = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getStatus() {
            await axios
                .get("/api/contacts/status/index")
                .then((res) => {
                    this.statuses = res.data;
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

        async getIndustries() {
            await axios
                .get("/api/contacts/industry/index")
                .then((res) => {
                    this.industries = res.data;
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
            await this.getContactsByTodo();
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
