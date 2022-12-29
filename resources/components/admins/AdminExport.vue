<template>
    <div class="container min-w-96 min-h-96" id="index-container">
        <h1
            class="items-center text-center text-5xl text-white font-extrabold px-80 rounded-md font-mono uppercase bg-blue-900"
        >
            Export / Import
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
                <!-- <option value="todo">To Do</option>
                <option value="forecast">Forecast</option>
                <option value="project">Project</option> -->
            </select>
        </div>

        <div v-if="import_type === 'contact'" class="w-full">
            <form
                id="excel_contact"
                class="grid grid-cols-1 gap-2 w-max mx-auto"
                @submit.prevent="importContacts"
                @change="getExcelData"
                enctype="multipart/form-data"
            >
                <label
                    class="text-center font-bold uppercase bg-slate-700 text-yellow-600"
                    >Contact</label
                >
                <input
                    class="file-input"
                    type="file"
                    ref="contact_file"
                    name="file"
                />
                <div>

                </div>
                <div class="inline-block items-center font-semibold text-center mx-auto w-max text-xs text-white uppercase px-2 py-1 border border-transparent rounded-md tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 bg-green-600 ">
                    <button
                    type="submit"
                    class=""
                >
                    <ArrowDownOnSquareIcon class="h-6 w-6 inline" />Import
                </button>
                </div>
                
                <div v-show="buffering" class="text-center text-sm font-bold">
                    Loading . . . please
                </div>
            </form>

            <div class="my-4">
            <vue-pdf-embed :source="import_format_contact" class="mx-auto" />
            </div>
        </div>
        <!-- v-if="is('supervisor | admin | super-admin')" -->
        <div class="flex" v-if="import_export === 'export'">
            <div class="py-2 flex">
                Select module:
                <select v-model="export_type" class="form-control">
                    <option value="">Pick one</option>
                    <option
                        value="contact"
                        v-if="
                            can('export admin contact') ||
                            is('super-admin | admin')
                        "
                    >
                        Contact
                    </option>
                    <option
                        value="todo"
                        v-if="
                            can('export admin todo') ||
                            is('super-admin | admin')
                        "
                    >
                        To Do
                    </option>
                    <option
                        value="forecast"
                        v-if="
                            can('export admin forecast') ||
                            is('super-admin | admin')
                        "
                    >
                        Forecast
                    </option>
                    <option
                        value="project"
                        v-if="
                            can('export admin project') ||
                            is('super-admin | admin')
                        "
                    >
                        Project
                    </option>
                </select>
            </div>

            <div class="py-2 mx-2 my-auto" v-if="export_type">
                <button
                    @click="getModule"
                    class="inline-block items-center px-2 py-1 bg-slate-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                >
                    Search records
                </button>
                <label
                    class="text-xs uppercase text-red-600 mx-2"
                    v-if="new_search"
                    ><ExclamationTriangleIcon class="h-6 w-6 inline"
                /></label>
            </div>

            <div class="py-2 mx-2" v-if="module_infos.length !== 0">
                <input
                    v-model.lazy="search"
                    type="search"
                    class="form-control"
                    placeholder="Search + Press ENTER"
                />
            </div>

            <div class="py-2 mx-2 my-auto">
                <div v-if="module_infos.length !== 0">
                    <div v-if="export_type === 'contact'">
                        <download-excel
                            :data="module_infos.data"
                            :fields="contact_fields"
                            worksheet="Contacts"
                            name="Contacts.xls"
                            class="btn btn-success btn-sm text-xs uppercase"
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
                            class="btn btn-success btn-sm text-xs uppercase"
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
                            class="btn btn-success btn-sm text-xs uppercase"
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
                            class="btn btn-success btn-sm text-xs uppercase"
                        >
                            <ArrowTopRightOnSquareIcon
                                class="h-5 w-5 mr-1 inline-block"
                            />
                            Export Project
                        </download-excel>
                    </div>
                </div>
            </div>
            <div class="w-max my-auto" v-if="export_type === 'forecast'">
                <button
                    @click="revealFilter"
                    class="bg-blue-500 rounded-md uppercase text-xs px-2 py-2 font-bold font-mono text-white"
                >
                    Filter
                </button>
            </div>
        </div>

        <div class="min-w-screen">
            <div
                class="table-wrp block min-h-screen max-h-screen overflow-y-auto overflow-x-auto"
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
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'address'
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
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'remark'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                                <div class="text-sm text-center h-6"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2">
                        <tr v-show="buffering">
                            <td
                                class="text-center text-sm font-bold"
                                colspan="9"
                            >
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
                            <th class="align-middle text-center w-36">
                                <div class="text-sm text-center">
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
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field ==
                                                    'forecast_updatedate'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th
                                :rowspan="showFilter ? 2 : 1"
                                class="align-middle text-center"
                            >
                                <div class="text-sm text-center">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('contact_name')
                                        "
                                        class="text-white text-center"
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
                            <th class="">
                                <div class="text-sm text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('contact_type')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Contact Type
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(sort_field == 'contact_type')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'contact_type'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'contact_type'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="">
                                <div class="text-sm text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('contact_status')
                                        "
                                        class="text-white inline-flex"
                                    >
                                        Contact Status
                                        <span
                                            v-if="
                                                (!(sort_direction == 'asc') ||
                                                    !(
                                                        sort_direction == 'desc'
                                                    )) &&
                                                !(
                                                    sort_field ==
                                                    'contact_status'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'contact_status'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'contact_status'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="">
                                <div class="text-sm text-center">
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
                            </th>
                            <th class="w-max">
                                <div class="text-sm text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('forecast_product')
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
                                                !(
                                                    sort_field ==
                                                    'forecast_product'
                                                )
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'forecast_product'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'forecast_product'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th
                                :rowspan="showFilter ? 2 : 1"
                                class="align-middle text-center"
                            >
                                <span class="text-sm text-center">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('amount')"
                                        class="text-white"
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
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'amount'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </span>
                            </th>
                            <th class="">
                                <div class="text-sm text-center h-max w-36">
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
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'forecast_date'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="">
                                <div class="text-sm text-center h-max">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('forecast_type')
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
                                                !(sort_field == 'forecast_type')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'forecast_type'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'forecast_type'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                            <th class="">
                                <div class="text-sm text-center w-32 mx-auto">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('result_name')
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
                                                !(sort_field == 'result_name')
                                            "
                                            class="inline-block"
                                            ><ArrowsUpDownIcon class="h-4 w-4"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'desc' &&
                                                sort_field == 'result_name'
                                            "
                                            class="inline-block"
                                            ><ArrowUpIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                        <span
                                            v-if="
                                                sort_direction == 'asc' &&
                                                sort_field == 'result_name'
                                            "
                                            class="inline-block"
                                            ><ArrowDownIcon
                                                class="h-4 w-4 text-amber-400 font-extrabold"
                                        /></span>
                                    </a>
                                </div>
                            </th>
                        </tr>
                        <tr class="" v-if="showFilter">
                            <th class="grid grid-cols-1 gap-1 w-40">
                                <!-- <div class="border-gray-800 flex px-1 py-1"> -->
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="forecast_startupdate"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        class="date_picker"
                                    />
                                </div>

                                <div class="text-white text-center">to</div>

                                <!-- </div> -->
                                <!-- <div class="border-gray-800 flex px-1 py-1"> -->
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="forecast_endupdate"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        class="date_picker"
                                    />
                                </div>
                                <!-- </div> -->
                            </th>
                            <!-- <th>Company</th> -->
                            <th class="align-top w-20">
                                <div
                                    class="text-xs text-center w-full align-top"
                                >
                                    <v-select
                                        label="name"
                                        :options="types.data"
                                        :reduce="(name) => name.id"
                                        v-model="selectedContactType"
                                        multiple
                                        class="vue_select"
                                    ></v-select>
                                </div>
                            </th>
                            <th class="align-top w-20">
                                <div
                                    class="text-xs text-center h-max w-full align-top"
                                >
                                    <v-select
                                        label="name"
                                        :options="statuses.data"
                                        :reduce="(name) => name.id"
                                        v-model="selectedContactStatus"
                                        multiple
                                        class="vue_select"
                                    ></v-select>
                                </div>
                            </th>
                            <th class="align-top w-20">
                                <div
                                    class="text-xs text-center h-max w-full align-top"
                                >
                                    <v-select
                                        label="name"
                                        :options="users.data"
                                        :reduce="(name) => name.id"
                                        v-model="selectedForecastUsers"
                                        multiple
                                        class="vue_select"
                                    ></v-select>
                                </div>
                            </th>
                            <th class="align-top w-20">
                                <div
                                    class="text-xs text-center h-max w-full align-top"
                                >
                                    <v-select
                                        label="name"
                                        :options="products.data"
                                        :reduce="(name) => name.id"
                                        v-model="selectedForecastProduct"
                                        multiple
                                        class="vue_select"
                                    ></v-select>
                                </div>
                            </th>
                            <!-- <th>Amount</th> -->
                            <th class="grid grid-cols-1 gap-1 w-40">
                                <!-- <div class="border-gray-800 flex px-1 py-1"> -->
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="forecast_startdate"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        class="date_picker"
                                    />
                                </div>

                                <div class="text-white text-center">to</div>

                                <!-- </div> -->
                                <!-- <div class="border-gray-800 flex px-1 py-1"> -->
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="forecast_enddate"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        class="date_picker"
                                    />
                                </div>
                                <!-- </div> -->
                            </th>
                            <th class="align-top w-20">
                                <div
                                    class="text-xs text-center h-max w-full align-top"
                                >
                                    <v-select
                                        label="name"
                                        :options="forecast_types.data"
                                        :reduce="(name) => name.id"
                                        v-model="selectedForecastType"
                                        multiple
                                        class="vue_select"
                                    ></v-select>
                                </div>
                            </th>
                            <th class="align-top">
                                <div
                                    class="text-xs text-center h-max w-full align-top"
                                >
                                    <v-select
                                        label="name"
                                        :options="results.data"
                                        :reduce="(name) => name.id"
                                        v-model="filterResult"
                                        multiple
                                        class="vue_select"
                                    ></v-select>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="mt-2 text-center">
                        <tr v-show="buffering">
                            <td
                                class="text-center text-sm font-bold"
                                colspan="8"
                            >
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
                            <td class="text-xs">{{ forecast.contact_type }}</td>
                            <td class="text-xs">
                                {{ forecast.contact_status }}
                            </td>
                            <td class="text-xs">{{ forecast.user_name }}</td>
                            <td class="text-xs w-max">
                                {{ forecast.forecast_product }}
                            </td>
                            <td class="text-xs">
                                <p class="inline mr-1">RM</p>
                                {{ forecast.amount.toLocaleString("en-US") }}
                            </td>
                            <td class="text-xs">
                                {{ showToday(forecast.forecast_date) }}
                            </td>
                            <td class="text-xs">
                                {{ forecast.forecast_type }}
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
                                <span
                                    v-show="!forecast.result_name"
                                    class="text-xs"
                                >
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
                        <tr v-show="buffering">
                            <td
                                class="text-center text-sm font-bold"
                                colspan="7"
                            >
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
import { VueDatePicker } from "@vuepic/vue-datepicker";
import VuePdfEmbed from "vue-pdf-embed";

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
        VueDatePicker,
        VuePdfEmbed,
    },

    mounted() {
        // this.selectedForecastUsers = [
        //     document
        //         .querySelector('meta[name="user-id"]')
        //         .getAttribute("content"),
        // ];
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
            import_format_contact: "/storage/tutorials/3_import_format_contact.pdf",

            search: "",
            selectedUser: "",
            selectedStatus: "",
            selectedType: "",
            selectedIndustry: "",
            selectedCategory: "",

            selectedSource: "",
            selectedContact: "",
            selectedTask: "",
            parameter_type: "",

            filter_forecast_startdate: "",
            filter_forecast_enddate: "",
            filter_forecast_startupdate: "",
            filter_forecast_endupdate: "",

            filter_contact_types: [],
            filter_forecast_types: [],
            filter_contact_statuses: [],
            filter_forecast_products: [],
            filter_forecast_users: [],
            filter_forecast_results: [],
            // display_contact_status: [],
            // display_user: [],

            selectedForecastProduct: [],
            selectedContactType: [],
            selectedContactStatus: [],
            selectedForecastType: [],
            selectedForecastUsers: [],
            filterResult: [],
            showFilter: false,

            forecast_startdate: "",
            forecast_enddate: "",
            forecast_startupdate: "",
            forecast_endupdate: "",

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
        selectedForecastUsers: function (value) {
            this.filter_forecast_users = value;
            this.new_search = true;
        },
        selectedForecastProduct: function (value) {
            this.filter_forecast_products = value;
            this.new_search = true;
        },
        selectedContactType: function (value) {
            this.filter_contact_types = value;
            this.new_search = true;
        },
        selectedContactStatus: function (value) {
            this.filter_contact_statuses = value;
            this.new_search = true;
        },
        selectedForecastType: function (value) {
            this.filter_forecast_types = value;
            this.new_search = true;
        },
        filterResult: function (value) {
            this.filter_forecast_results = value;
            this.new_search = true;
        },
        selectedSource: function (value) {
            this.new_search = true;
        },
        forecast_startdate: function (value) {
            if (value === null) {
                this.filter_forecast_startdate = "";
            } else {
                this.filter_forecast_startdate =
                    this.moment(value).format("YYYY-MM-DD");
            }

            this.new_search = true;
        },
        forecast_enddate: function (value) {
            if (value === null) {
                this.filter_forecast_enddate = "";
            } else {
                this.filter_forecast_enddate =
                    this.moment(value).format("YYYY-MM-DD");
            }
            this.new_search = true;
        },
        forecast_startupdate: function (value) {
            if (value === null) {
                this.filter_forecast_startupdate = "";
            } else {
                this.filter_forecast_startupdate =
                    this.moment(value).format("YYYY-MM-DD");
            }
            this.new_search = true;
        },
        forecast_endupdate: function (value) {
            if (value === null) {
                this.filter_forecast_endupdate = "";
            } else {
                this.filter_forecast_endupdate =
                    this.moment(value).format("YYYY-MM-DD");
            }
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
                        "&filter_contact_types=" +
                        this.filter_contact_types +
                        "&filter_contact_statuses=" +
                        this.filter_contact_statuses +
                        "&filter_forecast_products=" +
                        this.filter_forecast_products +
                        "&filter_forecast_types=" +
                        this.filter_forecast_types +
                        "&filter_forecast_users=" +
                        this.filter_forecast_users +
                        "&filter_forecast_results=" +
                        this.filter_forecast_results +
                        this.filter_forecast_startdate +
                        "&filter_forecast_enddate=" +
                        this.filter_forecast_enddate +
                        "&filter_forecast_startupdate=" +
                        this.filter_forecast_startupdate +
                        "&filter_forecast_endupdate=" +
                        this.filter_forecast_endupdate +
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

        revealFilter() {
            this.showFilter = !this.showFilter;
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
        getExcelData(e) {
            this.excel = this.$refs.contact_file.files[0];
            console.log(this.excel);
        },

        importContacts() {
            const config = {
                headers: {
                    "content-type": "multipart/form-data",
                },
            };

            let data = new FormData();

            data.append("file", this.excel);

            this.buffering = true;

            axios
                .post("/api/contacts/import", data, config)
                .then((response) => {
                    this.buffering = false;
                    alert("Contact imported");
                })
                .catch((error) => {
                    console.log(error);
                });
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";

.vue_select {
    background-color: rgb(255, 255, 255);
    border-radius: 0.375rem;
    font-size: smaller;
    font-style: normal;
}

.date_picker {
    font-size: 5px;
}
</style>
