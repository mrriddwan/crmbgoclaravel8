<template>
    <div class="w-max container" id="index-container">
        <h1
            class="items-center text-center text-5xl text-white font-extrabold bg-slate-400 px-2 rounded-md"
        >
            Export
        </h1>

        <div>
            <div class="py-2 flex">
                Import/Export:
                <select v-model="import_export" class="form-control mx-2">
                    <option value="">Select type</option>
                    <option value="export">Export</option>
                    <option value="import">Import</option>
                </select>
            </div>
        </div>

        <div class="py-2 flex" v-if="import_export === 'import'">
            Import Type:
            <select v-model="import_type" class="form-control mx-2">
                <option value="">Select module</option>
                <option value="contact">Contact</option>
                <option value="todo">To Do</option>
                <option value="forecast">Forecast</option>
                <option value="project">Project</option>
            </select>
        </div>

        <div v-if="import_type === 'contact'" class="w-max">
            <form
                id="excel_contact"
                class="grid grid-cols-1 gap-2"
                @submit.prevent="importContacts"
                @change="getExcelData"
                enctype="multipart/form-data"
            >
                <label
                    class="text-center font-bold uppercase bg-slate-700 text-yellow-600"
                    >Contact</label
                >
                <input class="file-input" type="file" ref="contact_file" name="file" />
                <button
                    type="submit"
                    class="inline-block items-center font-semibold text-xs text-white uppercase px-2 py-1 bg-green-800 border border-transparent rounded-md tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    <ArrowDownOnSquareIcon class="h-6 w-6 inline" />Import
                </button>
                <div v-show="buffering" class="text-center text-sm font-bold">
                    Loading . . . please
                </div>
            </form>
        </div>

        <div class="flex" v-if="import_export === 'export'">
            <div class="py-2 flex">
                Select module:
                <select v-model="export_type" class="form-control">
                    <option value="">Pick one</option>
                    <option value="contact">Contact</option>
                    <option value="todo">To Do</option>
                    <option value="forecast">Forecast</option>
                    <option value="project">Project</option>
                </select>
            </div>

            <div class="py-2 mx-2" v-if="export_type">
                <button
                    @click="getModule"
                    class="inline-block items-center px-2 py-1 bg-slate-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    Search records
                </button>
                <label class="text-xs uppercase text-red-600 mx-2"
                v-if="new_search"
                ><ExclamationTriangleIcon class="h-6 w-6 inline" /></label>
            </div>

            <div class="py-2 mx-2" v-if="module_infos.length !== 0">
                <input
                    v-model.lazy="search"
                    type="search"
                    class="form-control"
                    placeholder="Search + Press ENTER"
                />
            </div>

            <div class="py-2 mx-2">
                <div v-if="module_infos.length !== 0">
                    <div v-if="export_type === 'contact'">
                        <download-excel
                            :data="module_infos.data"
                            :fields="contact_fields"
                            worksheet="Contacts"
                            name="Contacts.xls"
                            class="btn btn-success btn-sm text-xs"
                        >
                            <ArrowTopRightOnSquareIcon
                                class="h-5 w-5 mr-1 inline-block"
                            />
                            Export
                        </download-excel>
                    </div>
                    <div v-if="export_type === 'todo'">
                        <download-excel
                            :data="module_infos.data"
                            :fields="todo_fields"
                            worksheet="To Do"
                            name="To Dos.xls"
                            class="btn btn-success btn-sm text-xs"
                        >
                            <ArrowTopRightOnSquareIcon
                                class="h-5 w-5 mr-1 inline-block"
                            />
                            Export
                        </download-excel>
                    </div>
                    <div v-if="export_type === 'forecast'">
                        <download-excel
                            :data="module_infos.data"
                            :fields="forecast_fields"
                            worksheet="Forecast"
                            name="Forecast.xls"
                            class="btn btn-success btn-sm text-xs"
                        >
                            <ArrowTopRightOnSquareIcon
                                class="h-5 w-5 mr-1 inline-block"
                            />
                            Export
                        </download-excel>
                    </div>
                    <div v-if="export_type === 'project'">
                        <download-excel
                            :data="module_infos.data"
                            :fields="project_fields"
                            worksheet="Project"
                            name="Project.xls"
                            class="btn btn-success btn-sm text-xs"
                        >
                            <ArrowTopRightOnSquareIcon
                                class="h-5 w-5 mr-1 inline-block"
                            />
                            Export Project
                        </download-excel>
                    </div>
                </div>
            </div>
        </div>

        <div class="">
            <div
                class="table-wrp block max-h-screen overflow-y-auto overflow-x-auto"
            >
                <!-- table for contacts-->
                <table
                    v-if="export_type === 'contact'"
                    class="table table-hover table-bordered w-full"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr>
                            <th class="py-3">
                                <div class="text-sm text-center h-6 w-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('created_at')
                                        "
                                        class="text-white"
                                    >
                                        Date<br />Created
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
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'created_at'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
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
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    v-if="
                                        is('admin | supervisor | super-admin')
                                    "
                                    class="items-center text-xs text-center h-6 w-24"
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
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('status_name')
                                        "
                                        class="text-white"
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
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'status_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
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
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('type_name')
                                        "
                                        class="text-white"
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
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'type_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <div class="text-sm text-center h-6">
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
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('industry_name')
                                        "
                                        class="text-white"
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
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'industry_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6 w-24"
                                >
                                    <select
                                        v-model="selectedIndustry"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="industry in industries.data"
                                            :key="industry.id"
                                            :value="industry.id"
                                        >
                                            {{ industry.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('name')"
                                        class="text-white"
                                    >
                                        Name
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
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
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
                                        class="text-white"
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
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'category_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
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
                                        @click.prevent="change_sort('address')"
                                        class="text-white"
                                    >
                                        Address
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'address')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'address'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'address'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('remark')"
                                        class="text-white"
                                    >
                                        Remark
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'remark')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'remark'
                                                
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'remark'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr v-show="buffering" >
                            <td class="text-center text-sm font-bold" colspan="9">
                                Loading . .
                            </td>
                        </tr>
                        <tr
                            v-for="contact in module_infos.data"
                            :key="contact.id"
                        >
                            <td class="text-xs">
                                {{ showToday(contact.created_at) }}
                            </td>
                            <td class="text-xs">{{ contact.user_name }}</td>
                            <td class="text-xs">{{ contact.status_name }}</td>
                            <td class="text-xs">{{ contact.type_name }}</td>
                            <td class="text-xs">{{ contact.industry_name }}</td>
                            <td class="text-xs">
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
                            <td class="text-xs">{{ contact.category_name }}</td>
                            <td class="text-xs">{{ contact.address }}</td>
                            <td class="text-xs">{{ contact.remark }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- table for todos-->
                <table
                    v-if="export_type === 'todo'"
                    class="table table-hover table-bordered text-center"
                    id="example"
                >
                    <thead class="bg-slate-500">
                        <tr>
                            <th class="text-sm text-center w-max">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('source_name')"
                                    class="text-white inline-flex"
                                    ><div class="inline-flex">Source</div>

                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
                                            !(sort_field == 'source_name')
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'source_name'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'source_name'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                </a>
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedSource"
                                        class="form-control form-control-sm"
                                    >
                                        <option value="">All</option>
                                        <option
                                            v-for="source in sources.data"
                                            :key="source.id"
                                            :value="source.id"
                                        >
                                            {{ source.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>
                            <th class="text-sm text-center w-20">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('todo_date')"
                                    class="text-white inline-flex"
                                >
                                    <div>
                                        To Do <br />
                                        Date
                                    </div>

                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
                                            !(sort_field == 'todo_date')
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'todo_date'
                                        "
                                        class="inline-block text-amber-400 font-extrabold"
                                        ><ArrowUpIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'todo_date'
                                        "
                                        class="inline-block text-amber-400 font-extrabold"
                                        ><ArrowDownIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                </a>
                                <div class="text-sm text-center h-1"></div>
                            </th>
                            <th class="text-sm text-center">
                                <a
                                    href="#"
                                    @click.prevent="
                                        change_sort('todo_deadline')
                                    "
                                    class="text-white inline-flex"
                                >
                                    Date<br />Deadline
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
                                            !(sort_field == 'todo_deadline')
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'todo_deadline'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'todo_deadline'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                </a>
                                <div class="text-sm text-center h-1"></div>
                            </th>
                            <th class="text-sm text-center">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('status_name')"
                                    class="text-white inline-flex"
                                >
                                    Status
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
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
                                <div class="text-sm text-center h-6">
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
                            <th class="text-sm text-center">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('type_name')"
                                    class="text-white inline-flex"
                                >
                                    Type
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
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
                                <div class="text-sm text-center h-6">
                                    <select
                                        v-model="selectedType"
                                        class="form-control form-control-sm w-max"
                                    >
                                        <option value="">All</option>
                                        <option
                                            v-for="contact_types in types.data"
                                            :key="contact_types.id"
                                            :value="contact_types.id"
                                        >
                                            {{ contact_types.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>
                            <th class="text-sm text-center">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('contact_name')"
                                    class="text-white inline-flex"
                                >
                                    Contact
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
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
                                        ><ArrowUpIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'contact_name'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                </a>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="text-sm text-center">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('user_name')"
                                    class="text-white inline-flex"
                                >
                                    CS
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
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
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="text-sm text-center">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('task_name')"
                                    class="text-white inline-flex"
                                >
                                    Task
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
                                            !(sort_field == 'task_name')
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'task_name'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'task_name'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                </a>
                                <div class="text-sm text-center h-6">
                                    <div class="text-sm text-center h-6">
                                        <select
                                            v-model="selectedTask"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="task in tasks.data"
                                                :key="task.id"
                                                :value="task.id"
                                            >
                                                {{ task.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                            <th class="text-sm text-center">
                                <a
                                    href="#"
                                    @click.prevent="change_sort('todo_remark')"
                                    class="text-white inline-flex"
                                >
                                    Remark
                                    <span
                                        v-if="
                                            (!(sort_direction == 'asc') ||
                                                !(sort_direction == 'desc')) &&
                                            !(sort_field == 'todo_remark')
                                        "
                                        class="inline-block"
                                        ><ArrowsUpDownIcon class="h-4 w-4"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'todo_remark'
                                        "
                                        class="inline-block"
                                        ><ArrowUpIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'todo_remark'
                                        "
                                        class="inline-block"
                                        ><ArrowDownIcon
                                            class="h-4 w-4 text-amber-400 font-extrabold"
                                    /></span>
                                </a>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(todo, index) in module_infos.data"
                            :key="todo.id"
                        >
                            <!-- <td class="text-xs">{{ index + 1 }}</td> -->
                            <td class="text-xs">{{ todo.source_name }}</td>
                            <td class="text-xs">
                                {{ showToday(todo.todo_date) }}
                            </td>
                            <td class="text-xs">
                                <span
                                    v-if="todo.todo_deadline === '2000-01-01'"
                                >
                                    None
                                </span>
                                <span
                                    v-else-if="
                                        todo.todo_deadline !== '2000-01-01'
                                    "
                                >
                                    {{ showToday(todo.todo_deadline) }}
                                </span>
                                <span v-else="todo.todo_deadline.length === 0">
                                    Unset yet
                                </span>
                            </td>
                            <td class="text-xs">{{ todo.status_name }}</td>
                            <td class="text-xs">{{ todo.type_name }}</td>
                            <td class="text-xs">
                                <router-link
                                    :to="`/contact/${todo.contact_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        todo.contact_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="text-xs">{{ todo.user_name }}</td>
                            <td class="text-xs">{{ todo.task_name }}</td>
                            <td class="text-xs">
                                {{ todo.todo_remark }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- table for forecasts-->
                <table
                    v-if="export_type === 'forecast'"
                    class="table table-hover table-bordered w-full mt-0"
                >
                    <thead class="bg-slate-500 border-b sticky top-0 text-xs">
                        <tr>
                            <th class="py-3 align-middle text-center">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('forecast_updatedate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Last<br />Update
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'forecast_updatedate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'forecast_updatedate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'forecast_updatedate'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3 w-max">
                                <div class="text-sm text-center h-6 w-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('contact_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Contact
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
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'contact_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
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
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'user_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div
                                    class="items-center text-xs text-center h-6 w-24"
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
                            <th class="py-3 w-max">
                                <div class="text-sm text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('product_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Forecast<br />Product
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'product_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'product_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'product_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-center h-6 w-20">
                                    <select
                                        v-model="selectedProduct"
                                        class="form-control form-control-sm text-xs"
                                    >
                                        <option class="text-xs" value="">
                                            All
                                        </option>
                                        <option
                                            class="text-xs"
                                            v-for="product in products.data"
                                            :key="product.id"
                                            :value="product.id"
                                        >
                                            {{ product.name }}
                                        </option>
                                    </select>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('amount')"
                                        class="text-white inline-flex"
                                    >
                                        Amount
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'amount')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'amount'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'amount'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('forecast_date')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Date<br />Forecast
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'forecast_date')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'forecast_date'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'forecast_date'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('forecast_type_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Forecast<br />Type
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'forecast_type_name'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'forecast_type_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'forecast_type_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <div class="text-sm text-center h-6">
                                        <select
                                            v-model="selectedForecastType"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="forecast_type in forecast_types.data"
                                                :key="forecast_type.id"
                                                :value="forecast_type.id"
                                            >
                                                {{ forecast_type.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('forecast_result')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Result
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'forecast_result'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'forecast_result'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'forecast_result'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6">
                                    <div class="text-sm text-center h-6">
                                        <select
                                            v-model="filterResult"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option value="null">
                                                No result
                                            </option>
                                            <option
                                                v-for="result in results.data"
                                                :key="result.id"
                                                :value="result.id"
                                            >
                                                {{ result.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-center">
                        <tr v-show="buffering" >
                            <td class="text-center text-sm font-bold" colspan="8">
                                Loading . .
                            </td>
                        </tr>
                        <tr
                            v-for="(forecast, index) in module_infos.data"
                            :key="forecast.id"
                        >
                            <td class="text-xs">
                                {{ showToday(forecast.forecast_updatedate) }}
                            </td>
                            <td class="text-xs grid-cols-2 w-max">
                                <router-link
                                    :to="`/contact/${forecast.contact_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        forecast.contact_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="text-xs">{{ forecast.user_name }}</td>
                            <td class="text-xs w-max">
                                {{ forecast.product_name }}
                            </td>
                            <td class="text-xs">
                                <p class="inline mr-1">RM</p>
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td class="text-xs">
                                {{ showToday(forecast.forecast_date) }}
                            </td>
                            <td class="text-xs">
                                {{ forecast.forecast_type_name }}
                            </td>
                            <td class="text-center align-middle">
                            <span v-if="forecast.result_name">
                                <span
                                    v-if="forecast.result_id === 1"
                                    class="w-max inline-block align-middle text-sm font-extrabold uppercase text-white bg-green-600 rounded-md py-1 px-2 text-center"
                                >
                                    {{ forecast.result_name }}
                                </span>
                                <span
                                    v-if="forecast.result_id === 2"
                                    class="w-max inline-block align-middle text-sm font-extrabold uppercase text-white bg-red-600 rounded-md py-1 px-2 text-center"
                                >
                                    {{ forecast.result_name }}
                                </span>
                                <span
                                    v-if="forecast.result_id === 3"
                                    class="w-max inline-block align-middle text-sm font-extrabold uppercase text-white bg-yellow-600 rounded-md py-1 px-2 text-center"
                                >
                                    {{ forecast.result_name }}
                                </span>
                            </span>
                            <span v-show="!forecast.result_name" class="text-xs">
                                No result
                            </span>
                        </td>
                        </tr>
                    </tbody>
                </table>

                <!-- table for projects-->
                <table
                    v-if="export_type === 'project'"
                    class="table table-hover w-full mt-0"
                >
                    <thead class="bg-slate-500 border-b sticky top-0">
                        <tr class="h-max">
                            <th class="py-3 w-max">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('project_startdate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Project <br />
                                        Start Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'project_startdate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field ==
                                                    'project_startdate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'project_startdate'
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
                                            change_sort('project_enddate')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Project <br />
                                        End Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'project_enddate'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_enddate'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_enddate'
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
                                            change_sort('project_duration')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Duration
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'project_duration'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'project_duration'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'project_duration'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6 w-full">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('contact_name')
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
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'contact_name'
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
                                            change_sort('project_name')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Project
                                        <span
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
                                        /></span>
                                    </a>
                                </div>
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
                            </th>
                            <th class="py-3">
                                <div class="text-sm text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('updated_at')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Entry <br />
                                        Date
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'updated_at')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'updated_at'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'updated_at'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr v-show="buffering" >
                            <td class="text-center text-sm font-bold" colspan="7">
                                Loading . .
                            </td>
                        </tr>
                        <tr
                            v-for="(project, index) in module_infos.data"
                            :key="project.id"
                        >
                            <td class="text-xs">
                                {{ showToday(project.project_startdate) }}
                            </td>
                            <td class="text-xs">
                                {{ showToday(project.project_enddate) }}
                            </td>
                            <td class="text-xs">
                                <!-- {{ project.project_enddate }} -->
                                {{
                                    calculateDuration(
                                        project.project_startdate,
                                        project.project_enddate
                                    )
                                }}
                                day(s)
                            </td>
                            <td class="text-xs grid-cols-2 w-max">
                                <router-link
                                    :to="`/contact/${project.contact_id}/info`"
                                    custom
                                    v-slot="{ navigate, href }"
                                >
                                    <a :href="href" @click.stop="navigate">{{
                                        project.contact_name
                                    }}</a>
                                </router-link>
                            </td>
                            <td class="text-xs">{{ project.project_name }}</td>
                            <td class="text-xs">
                                {{ project.project_remark }}
                            </td>
                            <td class="text-xs">
                                {{ showToday(project.updated_at) }}
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
    TrashIcon,
    UserPlusIcon,
    PlusIcon,
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
    ArrowUpIcon,
    ArrowDownIcon,
    QuestionMarkCircleIcon,
    ArrowDownOnSquareIcon,
    ExclamationTriangleIcon,
} from "@heroicons/vue/24/solid";

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
        QuestionMarkCircleIcon,
        ArrowDownOnSquareIcon,
        ExclamationTriangleIcon,
    },

    mounted() {
        // this.selectedUser = document
        //     .querySelector('meta[name="user-id"]')
        //     .getAttribute("content");
        this.getUsers();
        //contact
        this.getIndustries();
        this.getStatus();
        this.getTypes();
        this.getCategories();
        //forecast
        this.getProducts();
        this.getForecastTypes();
        this.getResults();
        //todos
        this.getSources();
        this.getTasks();
        //project

        //tempboard

        // this.getModule();
    },
    data() {
        return {
            module_infos: [],
            buffering: false,

            types: [],
            users: [],
            statuses: [],
            industries: [],
            categories: [],

            tasks: [],
            sources: [],

            products: [],
            forecast_types: [],
            results: [],

            export_type: "",
            import_export: "",
            import_type: "",
            excel: "",
            new_search: false,

            search: "",
            selectedUser: "",
            selectedStatus: "",
            selectedType: "",
            selectedIndustry: "",
            selectedCategory: "",

            selectedSource: "",
            selectedContact: "",
            selectedTask: "",

            selectedProduct: "",
            selectedContactType: "",
            selectedForecastType: "",
            filterResult: "",

            sort_direction: "desc",
            sort_field: "created_at",
            moment: moment,

            contact_fields: {
                "Date Created": "created_at",
                User: "user_name",
                Status: "status_name",
                Type: "type_name",
                Industry: "industry_name",
                Company: "name",
                Product: "category_name",
                "PIC Name": {
                    callback: (value) => {
                        if (value.incharge.length === 0) {
                            return " ";
                        } else {
                            let arr = value.incharge;
                            let new_arr = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                new_arr.push(`(${index})` + " " + arr[x].name);
                            }

                            return `${new_arr}`;
                        }
                    },
                },
                "PIC Email": {
                    callback: (value) => {
                        if (value.incharge.length === 0) {
                            return " ";
                        } else {
                            let arr = value.incharge;
                            let new_arr = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                new_arr.push(`(${index})` + " " + arr[x].email);
                            }

                            return `${new_arr}`;
                        }
                    },
                },
                "PIC Phone 1": {
                    callback: (value) => {
                        if (value.incharge.length === 0) {
                            return " ";
                        } else {
                            let arr = value.incharge;
                            let new_arr = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                new_arr.push(
                                    `(${index})` + " " + arr[x].phone_mobile
                                );
                            }

                            return `${new_arr}`;
                        }
                    },
                },
                "PIC Phone 2": {
                    callback: (value) => {
                        if (value.incharge.length === 0) {
                            return " ";
                        } else {
                            let arr = value.incharge;
                            let new_arr = [];

                            for (
                                let x = 0, index = 1;
                                x < arr.length;
                                x++, index++
                            ) {
                                new_arr.push(
                                    `(${index})` + " " + arr[x].phone_office
                                );
                            }

                            return `${new_arr}`;
                        }
                    },
                },

                Address: "address",
                Remark: "remark",
            },

            todo_fields: {
                Source: "source_name",
                Date: "todo_date",
                Deadline: "todo_deadline",
                Status: "status_name",
                Type: "type_name",
                Company: "contact_name",
                User: "user_name",
                Task: "task_name",
                Remark: "todo_remark",
            },

            forecast_fields: {
                "Last Update": "updated_at",
                User: "user_name",
                "Contact Type": "contact_type_name",
                Company: "contact_name",
                "Forecast Product": "product_name",
                Amount: "amount",                
                "Forecast Date": "forecast_date",
                "Forecast Type": "forecast_type_name",
                Result: "result_name",
            },

            project_fields: {
                "Start Date": "project_startdate",
                "End Date": "project_enddate",
                Duration: `${this.calculateDuration(
                    "project_startdate",
                    "project_enddate"
                )}`,
                Company: "contact_name",
                "Project Name": "project_name",
                Remark: "project_remark",
                "Entry Date": "created_at",
            },
        };
    },
    watch: {
        search: function (value) {
            this.getModule();
        },
        selectedUser: function (value) {
            this.new_search = true;
        },
        selectedStatus: function (value) {
            this.new_search = true;
        },
        selectedType: function (value) {
            this.new_search = true;
        },
        selectedCategory: function (value) {
            this.new_search = true;
        },
        selectedIndustry: function (value) {
            this.new_search = true;
        },
        selectedCategory: function (value) {
            this.new_search = true;
        },
        selectedProduct: function (value) {
            this.new_search = true;
        },
        selectedContactType: function (value) {
            this.new_search = true;
        },
        selectedForecastType: function (value) {
            this.new_search = true;
        },
        filterResult: function (value) {
            this.new_search = true;
        },
        selectedSource: function (value) {
            this.new_search = true;
        },

        export_type: function (value) {
            this.new_search = true;
            this.module_infos = [];
        },

        import_export: function (value) {
            this.export_type = "";
        },
    },

    methods: {
        getModule() {
            this.module_infos = [];
            this.buffering = true;
            axios
                .get(
                    "/api/admin/module_export?" +
                        "q=" +
                        this.search +
                        "&export_type=" +
                        this.export_type +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedContact=" +
                        this.selectedContact +
                        "&selectedStatus=" +
                        this.selectedStatus +
                        "&selectedType=" +
                        this.selectedType +
                        "&selectedIndustry=" +
                        this.selectedIndustry +
                        "&selectedCategory=" +
                        this.selectedCategory +
                        "&selectedSource=" +
                        this.selectedSource +
                        "&selectedTask=" +
                        this.selectedTask +
                        "&selectedForecastType=" +
                        this.selectedForecastType +
                        "&selectedContactType=" +
                        this.selectedContactType +
                        "&selectedProduct=" +
                        this.selectedProduct +
                        "&filterResult=" +
                        this.filterResult +
                        "&sort_direction=" +
                        this.sort_direction +
                        "&sort_field=" +
                        this.sort_field
                )
                .then((res) => {
                    this.buffering = false;
                    this.new_search = false;
                    this.module_infos = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        calculateDuration(start_date, end_date) {
            const start = new Date(start_date);
            const end = new Date(end_date);

            return moment(end - start).format("D");
        },

        getStatus() {
            axios
                .get("/api/contacts/status/index")
                .then((res) => {
                    this.statuses = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getUsers() {
            axios
                .get("/api/users/users_list")
                .then((res) => {
                    this.users = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getTypes() {
            axios
                .get("/api/contacts/type/index")
                .then((res) => {
                    this.types = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getIndustries() {
            axios
                .get("/api/contacts/industry/index")
                .then((res) => {
                    this.industries = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getCategories() {
            axios
                .get("/api/contacts/category/index")
                .then((res) => {
                    this.categories = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getSources() {
            axios
                .get("/api/sources/index")
                .then((res) => {
                    this.sources = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getTasks() {
            axios
                .get("/api/tasks/index")
                .then((res) => {
                    this.tasks = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },
        getForecastTypes() {
            axios
                .get("/api/forecasts/type/index")
                .then((res) => {
                    this.forecast_types = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getProducts() {
            axios
                .get("/api/forecasts/product/index")
                .then((res) => {
                    this.products = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getResults() {
            axios
                .get("/api/forecasts/result/index")
                .then((res) => {
                    this.results = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        showToday(date) {
            let new_date = new Date(date);
            let day = moment(new_date).format("DD-MM-YY");
            return day;
        },

        change_sort(field) {
            if (this.sort_field == field) {
                this.sort_direction =
                    this.sort_direction == "asc" ? "desc" : "asc";
            } else {
                this.sort_field = field;
            }
            this.getModule();
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
