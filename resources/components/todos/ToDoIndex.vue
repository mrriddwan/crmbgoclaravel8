<template>
    <div class="container">
        <h1
            class="items-center text-center text-5 xl text-white font-extrabold bg-blue-900 rounded-md"
        >
            To Do List
        </h1>

        <div class="text-sm mb-2">
            <div class="py-1 grid grid-cols-7">
                <div class="border border-gray-500 grid grid-cols-3 col-span-2">
                    <div
                        class="grid grid-cols-1 items-center align-middle px-1 py-1"
                    >
                        <label class="mx-auto my-auto">View by</label>
                        <select
                            v-model="view_type"
                            class="form-control text-center mx-auto my-auto"
                        >
                            <option value="day" class="text-xs">Day</option>
                            <option value="month" class="text-xs">Month</option>
                            <option value="range" class="text-xs">
                                Date Range
                            </option>
                        </select>
                        <div
                            class="w-max text-center justify-center py-1 mx-auto"
                            v-if="view_type === 'range'"
                        >
                            <button
                                @click="getToDos"
                                class="px-2 py-2 bg-green-400 rounded-md"
                            >
                                Search
                            </button>
                            <label
                                v-if="new_search"
                                class="text-xs uppercase text-red-600 mx-2"
                                ><ExclamationTriangleIcon
                                    class="h-8 w-8 inline"
                            /></label>
                        </div>
                    </div>
                    <div class="px-1 py-1 col-span-2">
                        <div
                            v-show="view_type === `day`"
                            class="grid grid-cols-1 text-center align-bottom items-center"
                        >
                            <div class="my-auto mx-auto py-2">
                                <label class="">Select date</label>
                            </div>
                            <div class="my-auto mx-auto">
                                <div class="px-2 w-40">
                                    <VueDatePicker
                                        v-model="search_date"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                    />
                                </div>
                            </div>
                        </div>
                        <div
                            v-show="view_type === `month`"
                            class="grid grid-cols-1 text-center align-bottom items-center"
                        >
                            <div class="my-auto mx-auto py-2">
                                <label class="">Select month/year</label>
                            </div>
                            <div class="my-auto mx-auto">
                                <input
                                    v-model.lazy="search_month_year"
                                    class="border-gray-300"
                                    type="month"
                                />
                            </div>
                        </div>

                        <div
                            v-show="view_type === `range`"
                            class="grid grid-cols-1 text-center align-bottom items-center"
                        >
                            <!-- <div class="border-gray-800 grid grid-cols-2 py-1 align-middle"> -->
                            <label class="mx-auto my-auto">Start date</label>

                            <div class="w-40 mx-auto">
                                <VueDatePicker
                                    v-model="search_start_date"
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                    class="date_picker"
                                />
                            </div>
                            <!-- </div> -->
                            <!-- <div class="border-gray-800 grid grid-cols-2 py-1 align-middle"> -->
                            <label class="mx-auto my-auto">End date</label>
                            <div class="w-40 mx-auto">
                                <VueDatePicker
                                    v-model="search_end_date"
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                    class="date_picker"
                                />
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                </div>

                <div class="m-1 inline-block items-center px-1 py-1 col-span-2">
                    <p>Filter term</p>
                    <input
                        v-model.lazy="search"
                        type="search"
                        class="form-control"
                        placeholder="Search + Press ENTER"
                    />
                </div>
                <div
                    class="m-1 inline-block items-center px-1 py-1"
                    v-if="is('supervisor | admin | super-admin')"
                >
                    <p>Select user</p>
                    <select v-model="selectedUser" class="form-control">
                        <option value="">All User</option>
                        <option
                            v-for="user in users"
                            :key="user.id"
                            :value="user.id"
                        >
                            {{ user.name }}
                        </option>
                    </select>
                </div>

                <div class="border-gray-400 inline-block px-1 py-1 m-1">
                    <p for="paginate">Per page</p>
                    <input v-model.lazy="paginate" class="form-control" />
                </div>

                <div class="inline-block ml-2">
                    <div v-if="can('create todo') || is('super-admin | admin')">
                        <router-link
                            to="/todo/create"
                            class="inline-block items-center px-2 py-1 align-top bg-blue-800 border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                        >
                            <PlusIcon class="inline h-6 w-6 mr-1" />
                            to do</router-link
                        >
                    </div>

                    <div class="inline-block py-1">
                        <span v-if="view_type === 'day'">
                            <Pagination
                                :data="todos"
                                @pagination-change-page="getToDos"
                                :size="'small'"
                                :align="'right'"
                                class="pagination"
                                :limit="2"
                            />
                        </span>
                        <span v-else-if="view_type === 'month'">
                            <Pagination
                                :data="todos"
                                :limit="2"
                                @pagination-change-page="getToDos"
                                :size="'small'"
                                :align="'right'"
                                class="pagination"
                            />
                        </span>

                        <span v-else-if="view_type === 'range'">
                            <Pagination
                                :data="todos"
                                :limit="2"
                                @pagination-change-page="getToDos"
                                :size="'small'"
                                :align="'right'"
                                class="pagination"
                            />
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="mx-2 inline-block">
            <a
                v-if="checked.length > 0"
                class="px-2 py-2 align-middle text-center bg-blue-400 border-black border-2 rounded-md text-xs"
                type="button"
                :href="url"
                download="file.xlsx"
            >
                <div class="h-5">
                    <ArrowTopRightOnSquareIcon
                        class="h-5 w-5 mr-1 inline-block"
                    />
                    <p class="inline-block text-black uppercase font-extrabold">
                        Export(?)
                    </p>
                </div>
            </a>

            <div v-if="checked.length > 0 && !selectPage" class="inline-block">
                <div
                    class="inline-block mx-1"
                    v-if="selectAll || todos.meta.total == checked.length"
                >
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s).
                </div>
                <div v-else class="inline-block mx-1">
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s)
                    <!-- <a
                        v-if="
                            can('export todo all') || is('admin | super-admin')
                        "
                        @click.prevent="selectAllRecords"
                        href="#"
                        class="ml-1 rounded-md bg-yellow-400 border-2 border-black uppercase text-black text-xs"
                        >Select All</a
                    > -->
                </div>
            </div>

            <div class="inline-block" v-if="selectPage">
                <div
                    class="inline-block mx-1"
                    v-if="selectAll || todos.meta.total == checked.length"
                >
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s).
                    <!-- <a
                        v-if="
                            can('export todo all') || is('admin | super-admin')
                        "
                        @click.prevent="selectAllRecords"
                        href="#"
                        class="ml-1 rounded-md bg-yellow-400 border-2 border-black uppercase text-black text-xs px-1"
                        >Select All</a
                    > -->
                </div>
                <div v-else class="inline-block mx-1">
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s)
                    <!-- <a
                        v-if="
                            can('export todo all') || is('admin | super-admin')
                        "
                        @click.prevent="selectAllRecords"
                        href="#"
                        class="ml-1 rounded-md bg-yellow-400 border-2 border-black uppercase text-black text-xs px-1"
                        >Select All</a
                    > -->
                </div>
            </div>
        </div>

        <div class="grid grid-cols-3 w-full text-center bg-slate-400">
            <div class="text-left">
                <button
                    class="text-xl text-left px-2 py-2"
                    id="decrementDate"
                    @click="decrementDate"
                >
                    <ChevronDoubleLeftIcon
                        class="h-6 w-6 bg-blue-300 rounded-lg"
                    />
                </button>
            </div>
            <span v-show="view_type === `day`">
                <div class="mt-1">
                    <h3 class="uppercase text-white font-extrabold">
                        {{ showToday(selectedDate) }}
                    </h3>
                </div>
            </span>
            <span v-show="view_type === `month`">
                <div class="mt-1">
                    <h3 class="uppercase text-white font-extrabold">
                        {{ showMonth(selectedMonthYear) }}
                    </h3>
                </div>
            </span>
            <span v-show="view_type === `range`">
                <div class="mt-1 inline-flex">
                    <h3
                        class="uppercase text-white font-extrabold inline-flex w-max"
                    >
                        {{ showToday(selectedDateStart) }}
                    </h3>
                    <h3
                        class="text-white font-extrabold inline-flex mx-3 w-max"
                    >
                        -
                    </h3>
                    <h3
                        class="uppercase text-white font-extrabold inline-flex w-max"
                    >
                        {{ showToday(selectedDateEnd) }}
                    </h3>
                </div>
            </span>

            <div class="text-right">
                <button
                    class="text-5xl text-right px-2 py-2"
                    id="incrementDate"
                    @click="incrementDate"
                >
                    <ChevronDoubleRightIcon
                        class="h-6 w-6 bg-blue-300 rounded-lg"
                    />
                </button>
            </div>
        </div>

        <div>
            <table
                class="table table-hover table-bordered text-center"
                id="example"
            >
                <thead class="bg-slate-500">
                    <tr>
                        <th
                            v-if="
                                can('export todo') || is('admin | super-admin')
                            "
                        >
                            <input type="checkbox" v-model="selectPage" />
                            <div class="text-sm text-center h-6"></div>
                        </th>
                        <th class="text-sm text-center">
                            #
                            <div class="text-sm text-center h-6"></div>
                        </th>
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
                                @click.prevent="change_sort('todo_deadline')"
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
                        <th class="text-sm text-center w-max text-white">
                            Action
                            <div class="text-sm text-center h-6"></div>
                        </th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-show="buffering">
                        <td class="text-center text-sm font-bold" colspan="20">
                            Loading . .
                        </td>
                    </tr>
                    <tr
                        v-for="(todo, index) in todos.data"
                        :key="todo.id"
                        :class="
                            isChecked(todo.id)
                                ? 'table-primary font-semibold'
                                : 'font-semibold'
                        "
                        :style="{ color: todo.color_name }"
                    >
                        <td
                            v-if="
                                can('export todo') || is('admin | super-admin')
                            "
                        >
                            <input
                                type="checkbox"
                                :value="todo.id"
                                v-model="checked"
                            />
                        </td>
                        <td class="text-xs text-left">{{ index + 1 }}</td>
                        <td class="text-xs text-left">
                            {{ todo.source_name }}
                        </td>
                        <td class="text-xs text-left">
                            {{ showToday(todo.todo_date) }}
                        </td>
                        <td class="text-xs text-left">
                            <span v-if="todo.todo_deadline === '2000-01-01'">
                                None
                            </span>
                            <span
                                v-else-if="todo.todo_deadline !== '2000-01-01'"
                            >
                                {{ showToday(todo.todo_deadline) }}
                            </span>
                            <span v-else="todo.todo_deadline.length === 0">
                                Unset yet
                            </span>
                        </td>
                        <td class="text-xs text-left">
                            {{ todo.status_name }}
                        </td>
                        <td class="text-xs text-left">{{ todo.type_name }}</td>
                        <td class="text-xs text-left">
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
                        <td class="text-xs text-left">{{ todo.user_name }}</td>
                        <td class="text-xs text-left">{{ todo.task_name }}</td>
                        <td class="text-xs text-left">
                            {{ todo.todo_remark.substring(0, 10) + ". . ." }}
                            <button
                                @click="toggleRemark(todo.id)"
                                class="align-middle border-1 border-black w-max rounded-md px-1"
                            >
                                <QuestionMarkCircleIcon
                                    class="inline h-4 w-4"
                                />
                            </button>
                        </td>
                        <td class="text-center align-middle w-max">
                            <div class="container">
                                <div v-if="todo.action_id" class="inline-block">
                                    <div
                                        class="text-xs break-words align-middle font-extrabold uppercase text-white bg-green-500 rounded-md py-1 px-1 text-center"
                                    >
                                        {{ todo.action_name }}
                                    </div>
                                    <div class="inline-block">
                                        <button
                                            class="bg-blue-300 py-1 px-1 ml-2 text-xs text-black rounded-md inline-block"
                                            @click="toggleResult()"
                                        >
                                            <PencilIcon class="h-3 w-3" />
                                        </button>
                                        <span v-show="changeAction" class="">
                                            <select
                                                id="selectAction"
                                                class="form-control form-control-sm"
                                                @change="
                                                    actionSelected(
                                                        this.todo_action
                                                            .action_id,
                                                        todo.id,
                                                        todo.contact_id
                                                    )
                                                "
                                                v-model="todo_action.action_id"
                                            >
                                                <option disabled value="">
                                                    Select Action
                                                </option>
                                                <option value="">
                                                    No action
                                                </option>
                                                <option
                                                    v-for="action in actions.data"
                                                    :key="action.id"
                                                    :value="action.id"
                                                >
                                                    {{ action.name }}
                                                </option>
                                            </select>
                                        </span>
                                    </div>
                                </div>
                                <div v-else>
                                    <select
                                        id="selectAction"
                                        class="form-control form-control-sm"
                                        @change="
                                            actionSelected(
                                                this.todo_action.action_id,
                                                todo.id,
                                                todo.contact_id
                                            )
                                        "
                                        v-model="todo_action.action_id"
                                    >
                                        <option disabled value="">
                                            Select Action
                                        </option>
                                        <option
                                            v-for="action in actions.data"
                                            :key="action.id"
                                            :value="action.id"
                                        >
                                            {{ action.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div
                                v-if="
                                    can('create followup') ||
                                    is('super-admin | admin')
                                "
                            >
                                <router-link
                                    v-show="todo.action"
                                    class="px-1 py-1 m-2 uppercase font-semibold bg-purple-200 text-xs rounded-md"
                                    :to="{
                                        name: 'followup_create',
                                        params: {
                                            id: todo.contact_id,
                                            todo_id: todo.id,
                                        },
                                    }"
                                    >+Follow Up</router-link
                                >
                            </div>

                            <div
                                v-if="
                                    can('edit todo') ||
                                    is('super-admin | admin')
                                "
                            >
                                <router-link
                                    :to="{
                                        name: 'todo_edit',
                                        params: { id: todo.id },
                                    }"
                                    class="m-2 inline-flex items-center px-2 py-1 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                >
                                    <PencilSquareIcon class="h-3 w-3"
                                /></router-link>
                            </div>

                            <div
                                v-if="
                                    can('delete todo') ||
                                    is('super-admin | admin')
                                "
                            >
                                <button
                                    class="m-2 inline-flex items-center px-2 py-1 bg-red-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                                    @click="deleteToDo(todo.id)"
                                >
                                    <TrashIcon class="h-3 w-3" />
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <TodoRemarkModalVue
            v-if="todo_remark_visibility"
            @toggle-modal="toggleRemark(todo_id)"
            :todo_id="todo_remark"
        />
    </div>
</template>

<script>
import LaravelVuePagination from "laravel-vue-pagination";
import axios from "axios";
import moment from "moment";
import { VueDatePicker } from "@vuepic/vue-datepicker";
import TodoRemarkModalVue from "./TodoRemarkModal.vue";
import {
    PencilSquareIcon,
    TrashIcon,
    ChevronDoubleLeftIcon,
    ChevronDoubleRightIcon,
    PlusIcon,
    LightBulbIcon,
    ArrowTopRightOnSquareIcon,
    ArrowsUpDownIcon,
    PencilIcon,
    ArrowDownIcon,
    ArrowUpIcon,
    QuestionMarkCircleIcon,
    ExclamationTriangleIcon,
} from "@heroicons/vue/24/solid";

export default {
    components: {
        Pagination: LaravelVuePagination,
        TodoRemarkModalVue,
        PencilSquareIcon,
        TrashIcon,
        ChevronDoubleLeftIcon,
        ChevronDoubleRightIcon,
        PlusIcon,
        LightBulbIcon,
        ArrowTopRightOnSquareIcon,
        ArrowsUpDownIcon,
        PencilIcon,
        VueDatePicker,
        ArrowDownIcon,
        ArrowUpIcon,
        QuestionMarkCircleIcon,
        ExclamationTriangleIcon,
    },

    created() {},

    mounted() {
        this.getStatus();
        this.getActions();

        this.getUsers();
        this.selectedUser = document
            .querySelector('meta[name="user-id"]')
            .getAttribute("content");
        this.getSources();
        this.getTasks();
        this.getTypes();
        if (!this.$route.params.selectedDate) {
            this.search_date = this.moment().format("YYYY-MM-DD");
            // this.getToDos();
        } else {
            this.search_date = this.$route.params.selectedDate;
            // this.getToDos();
        }
        console.log(
            "this is the route params: " + this.$route.params.selectedDate
        );
    },

    props: {},

    data() {
        return {
            todos: [],
            statuses: [],
            tasks: [],
            sources: [],
            users: [],
            types: [],

            paginate: 100,
            view_type: "day",
            moment: moment,
            new_search: false,

            search: "",
            todo: "",

            selectPage: false,
            selectAll: false,
            checked: [],
            url: "",
            changeAction: false,
            buffering: false,

            todo_remark_visibility: false,
            todo_remark: null,

            selectedUser: "",
            selectedSource: "",
            selectedStatus: "",
            selectedType: "",
            selectedContact: "",
            selectedTask: "",

            currentDate: "",
            currentYear: "",

            search_date: "",
            search_month_year: "",
            search_start_date: "",
            search_end_date: "",

            selectedDate: "",
            selectedMonth: "",
            selectedYear: "",
            selectedMonthYear: "",

            selectedDateStart: "",
            selectedDateEnd: "",

            sort_direction: "desc",
            sort_field: "created_at",
            actions: "",
            todo_action: {
                action_id: "",
            },
        };
    },
    watch: {
        checked: function (value) {
            this.url = "/api/todos/export/" + this.checked;
        },

        selectPage: function (value) {
            this.checked = [];
            if (value) {
                this.todos.data.forEach((todo) => {
                    this.checked.push(todo.id);
                });
            } else {
                this.checked = [];
                this.selectAll = false;
            }
        },

        paginate: function (value) {
            this.getToDos();
        },
        search: function (value) {
            this.getToDos();
        },
        selectedStatus: function (value) {
            this.getToDos();
        },
        selectedUser: function (value) {
            this.getToDos();
        },
        selectedType: function (value) {
            this.getToDos();
        },
        selectedContact: function (value) {
            this.getToDos();
        },
        selectedTask: function (value) {
            this.getToDos();
        },
        selectedSource: function (value) {
            this.getToDos();
        },

        view_type: function (value) {
            if (value === "day") {
                this.getToDos();
            } else if (value === "month") {
                if (!this.search_month_year) {
                    this.selectedMonthYear = this.moment().format("MMMM-YYYY");
                    this.search_month_year = this.moment().format("YYYY-MM");
                    this.selectedMonth = this.moment().format("MM");
                    this.selectedYear = this.moment().format("YYYY");
                    this.getToDos();
                } else {
                    this.selectedMonthYear = this.moment(
                        this.search_month_year
                    ).format("MMMM-YYYY");
                    this.selectedMonth = this.moment(
                        this.search_month_year
                    ).format("MM");
                    this.selectedYear = this.moment(
                        this.search_month_year
                    ).format("YYYY");
                    this.getToDos();
                }
            } else {
                if (!this.search_start_date && !this.search_end_date) {
                    this.search_start_date = this.moment().format("YYYY-MM-DD");
                    this.search_end_date = this.moment().format("YYYY-MM-DD");
                    // this.getToDos();
                }
                // else {
                //     this.selectedMonth = this.moment(this.search_month_year).format("MM");
                //     this.selectedYear = this.moment(this.search_month_year).format("YYYY");
                //     this.getToDos();
                // }
            }
        },
        search_date: function (value) {
            this.selectedDate = this.moment(value).format("YYYY-MM-DD");
            this.getToDos();
        },

        search_month_year: function (value) {
            this.selectedMonthYear = this.moment(value).format("MMMM-YYYY");
            this.selectedMonth = this.moment(value).format("MM");
            this.selectedYear = this.moment(value).format("YYYY");
            this.getToDos();
        },

        search_start_date: function (value) {
            this.selectedDateStart = this.moment(value).format("YYYY-MM-DD");
            this.new_search = true;
        },

        search_end_date: function (value) {
            this.selectedDateEnd = this.moment(value).format("YYYY-MM-DD");
            this.new_search = true;
        },
    },

    methods: {
        toggleRemark(todo_id) {
            this.todo_remark = todo_id;
            this.todo_remark_visibility = !this.todo_remark_visibility;
        },

        getToDos(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            this.buffering = true;
            axios
                .get(
                    "/api/todos/index?" +
                        "q=" +
                        this.search +
                        "&selectedDate=" +
                        this.selectedDate +
                        "&selectedMonth=" +
                        this.selectedMonth +
                        "&selectedYear=" +
                        this.selectedYear +
                        "&selectedDateStart=" +
                        this.selectedDateStart +
                        "&selectedDateEnd=" +
                        this.selectedDateEnd +
                        "&selectedUser=" +
                        this.selectedUser +
                        "&selectedSource=" +
                        this.selectedSource +
                        "&selectedType=" +
                        this.selectedType +
                        "&selectedContact=" +
                        this.selectedContact +
                        "&selectedTask=" +
                        this.selectedTask +
                        "&selectedStatus=" +
                        this.selectedStatus +
                        "&view_type=" +
                        this.view_type +
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
                    this.new_search = false;
                    this.todos = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getUsers() {
            axios
                .get("/api/users/users_list")
                .then((res) => {
                    this.users = res.data.data;
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

        getActions() {
            axios
                .get("/api/actions/index")
                .then((res) => {
                    this.actions = res.data;
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
            this.getToDos();
        },

        showToday(date) {
            // let day = moment(date).format("DD-MM-YYYY");
            let day = moment(date).format("DD-MM-YY");
            return day;
        },

        showMonth(date) {
            let month = moment(date).format("MMMM-YYYY");
            return month;
        },

        getCurrentDate() {
            this.currentDate = moment().format("YYYY-MM-DD");
            return this.currentDate;
        },

        getSelectedDate(date) {
            this.selectedDate = moment(date).format("YYYY-MM-DD");
            return this.selectedDate;
        },

        getSelectedDateStart(date) {
            this.selectedDateStart = moment(date).format("YYYY-MM-DD");
            return this.selectedDateStart;
        },

        getSelectedDateEnd(date) {
            this.selectedDateEnd = moment(date).format("YYYY-MM-DD");
            return this.selectedDateEnd;
        },

        getSelectedDay() {
            let day = moment().format("DD");
            return day;
        },

        getSelectedMonth(date) {
            this.selectedMonth = moment(date).format("MM");
            return this.selectedMonth;
        },

        getSelectedYear(date) {
            this.selectedYear = moment(date).format("YYYY");
            return this.selectedYear;
        },

        async deleteToDo(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            await axios.delete("/api/todos/delete/" + id);
            this.getToDos();
        },

        async actionSelected(action, toDoId, contactId) {
            if (!window.confirm("Update task?")) {
                this.todo_action.action_id = "";
                return;
            }
            await axios.put("/api/todos/action/" + toDoId, {
                action_id: action ? action : null,
            });
            alert("Task updated");
            this.$router.push({
                name: "followup_create",
                params: { id: contactId, todo_id: toDoId },
            });
        },

        toggleResult() {
            return (this.changeAction = !this.changeAction);
        },

        incrementDate() {
            if (this.view_type === "day") {
                document.getElementById("incrementDate").disabled = false;
                return (this.search_date = moment(this.search_date).add(
                    1,
                    "d"
                ));
            } else if (this.view_type === "month") {
                document.getElementById("incrementDate").disabled = false;
                var monthYear =
                    this.selectedYear + "-" + this.selectedMonth + "-" + "01";
                console.log("monthYear : " + monthYear);

                var monthYearAdd = moment(monthYear)
                    .add(1, "M")
                    .format("YYYY-MM-DD");

                console.log("monthYearAdd : " + monthYearAdd);

                this.selectedMonthYear = monthYearAdd;
                var month = this.getSelectedMonth(monthYearAdd);
                var year = this.getSelectedYear(monthYearAdd);
                return (this.search_month_year = year + "-" + month);
            } else {
                document.getElementById("incrementDate").disabled = true;
            }
        },

        decrementDate() {
            if (this.view_type === "day") {
                document.getElementById("decrementDate").disabled = false;
                return (this.search_date = moment(this.search_date).subtract(
                    1,
                    "d"
                ));
            } else if (this.view_type === "month") {
                document.getElementById("decrementDate").disabled = false;
                var monthYear =
                    this.selectedYear + "-" + this.selectedMonth + "-" + "01";
                console.log("monthYear : " + monthYear);

                var monthYearMinus = moment(monthYear)
                    .subtract(1, "M")
                    .format("YYYY-MM-DD");

                console.log("monthYearMinus : " + monthYearMinus);

                this.selectedMonthYear = monthYearMinus;
                var month = this.getSelectedMonth(monthYearMinus);
                var year = this.getSelectedYear(monthYearMinus);
                return (this.search_month_year = year + "-" + month);
            } else {
                document.getElementById("decrementDate").disabled = true;
            }
        },

        isChecked(todo_id) {
            return this.checked.includes(todo_id);
        },

        selectAllRecords() {
            axios.get("/api/todos/all").then((response) => {
                this.checked = response.data;
                this.selectAll = true;
            });
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";

.date_picker {
    font-size: 5px;
}
</style>
