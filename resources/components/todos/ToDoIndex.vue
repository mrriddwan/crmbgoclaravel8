<template>
    <div class="container">
        <h1
            class="items-center text-center text-5 xl text-white font-extrabold bg-slate-600 rounded-md"
        >
            To Do List
        </h1>

        <div class="text-sm mb-2">
            <div class="py-1">
                <div class="border border-gray-500 inline-block">
                    <div class="m-1 inline-block items-center px-1 py-1">
                        <p>View by</p>
                        <select
                            v-model="viewType"
                            class="form-control text-center"
                        >
                            <option value="day">Day</option>
                            <option value="month">Month</option>
                            <option value="range">Date Range</option>
                        </select>
                    </div>
                    <div class="m-1 inline-block items-center px-1 py-1">
                        <span v-show="viewType === `day`">
                            <p>Select date</p>
                            <div class="px-2">
                                <VueDatePicker
                                    v-model="selectedDate"
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                />
                            </div>
                        </span>
                        <span v-show="viewType === `month`">
                            <p>Select month/year</p>
                            <input
                                v-model.lazy="currentMonth"
                                class="border-gray-300"
                                type="month"
                            />
                        </span>

                        <span
                            v-show="viewType === `range`"
                            class="inline-block items-center py-1"
                        >
                            <div class="border-gray-800 flex px-1 py-1">
                                <p class="px-1 mt-1">Start date</p>

                                <div class="px-2">
                                    <VueDatePicker
                                        v-model="selectedDateStart"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                    />
                                </div>
                            </div>
                            <div class="border-gray-800 flex px-1 py-1">
                                <p class="px-1">End date</p>
                                <div class="px-2">
                                    <VueDatePicker
                                        v-model="selectedDateEnd"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                    />
                                </div>
                            </div>
                        </span>
                    </div>
                </div>

                <div class="m-1 inline-block items-center px-1 py-1">
                    <p>Filter term</p>
                    <input
                        v-model.lazy="search"
                        type="search"
                        class="form-control"
                        placeholder="Search by any..."
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

                <div class="border-gray-400 inline-block px-1 py-1">
                    <p for="paginate">Per page</p>
                    <input v-model.lazy="paginate" class="form-control" />
                    <!-- <select v-model="paginate" class="form-control">
                        <option value="10">10</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select> -->
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
                        <span v-if="viewType === 'day'">
                            <Pagination
                                :data="todos"
                                @pagination-change-page="getToDosSelectDate"
                                :size="'small'"
                                :align="'right'"
                                class="pagination"
                            />
                        </span>
                        <span v-else-if="viewType === 'month'">
                            <Pagination
                                :data="todos"
                                @pagination-change-page="getToDosSelectMonth"
                                :size="'small'"
                                :align="'right'"
                                class="pagination"
                            />
                        </span>

                        <span v-else-if="viewType === 'range'">
                            <Pagination
                                :data="todos"
                                @pagination-change-page="
                                    getToDosSelectDateRange
                                "
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
                    <a
                        v-if="
                            can('export todo all') || is('admin | super-admin')
                        "
                        @click.prevent="selectAllRecords"
                        href="#"
                        class="ml-1 rounded-md bg-yellow-400 border-2 border-black uppercase text-black text-xs"
                        >Select All</a
                    >
                </div>
            </div>

            <div class="inline-block" v-if="selectPage">
                <div
                    class="inline-block mx-1"
                    v-if="selectAll || todos.meta.total == checked.length"
                >
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s).
                    <a
                        v-if="
                            can('export todo all') || is('admin | super-admin')
                        "
                        @click.prevent="selectAllRecords"
                        href="#"
                        class="ml-1 rounded-md bg-yellow-400 border-2 border-black uppercase text-black text-xs px-1"
                        >Select All</a
                    >
                </div>
                <div v-else class="inline-block mx-1">
                    Selected:
                    <strong>{{ checked.length }}</strong> record(s)
                    <a
                        v-if="
                            can('export todo all') || is('admin | super-admin')
                        "
                        @click.prevent="selectAllRecords"
                        href="#"
                        class="ml-1 rounded-md bg-yellow-400 border-2 border-black uppercase text-black text-xs px-1"
                        >Select All</a
                    >
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
            <span v-show="viewType === `day`">
                <div class="mt-1">
                    <h3 class="uppercase text-white font-extrabold">
                        {{ showToday(selectedDate) }}
                    </h3>
                </div>
            </span>
            <span v-show="viewType === `month`">
                <div class="mt-1">
                    <h3 class="uppercase text-white font-extrabold">
                        {{ showMonth(selectedMonthYear) }}
                    </h3>
                </div>
            </span>
            <span v-show="viewType === `range`">
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
                    <tr
                        v-for="(todo, index) in todos.data"
                        :key="todo.id"
                        :class="isChecked(todo.id) ? 'table-primary' : ''"
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
                        <td class="text-xs">{{ index + 1 }}</td>
                        <td class="text-xs">{{ todo.source.name }}</td>
                        <td class="text-xs">{{ showToday(todo.todo_date) }}</td>
                        <td class="text-xs">
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
                        <td class="text-xs">{{ todo.status.name }}</td>
                        <td class="text-xs">{{ todo.type.name }}</td>
                        <td class="text-xs">
                            <router-link
                                :to="`/contact/${todo.contact.id}/info`"
                                custom
                                v-slot="{ navigate, href }"
                            >
                                <a :href="href" @click.stop="navigate">{{
                                    todo.contact.name
                                }}</a>
                            </router-link>
                        </td>
                        <td class="text-xs">{{ todo.user.name }}</td>
                        <td class="text-xs">{{ todo.task.name }}</td>
                        <td class="text-xs">
                            {{ todo.todo_remark }}
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
                                <div v-if="todo.action" class="inline-block">
                                    <div
                                        class="text-xs break-words align-middle font-extrabold uppercase text-white bg-green-500 rounded-md py-1 px-1 text-center"
                                    >
                                        {{ todo.action.name }}
                                    </div>
                                    <div class="inline-block">
                                        <button
                                            class="bg-blue-300 py-1 px-1 ml-2 text-xs rounded-md inline-block"
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
                                                        todo.contact.id
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
                                                todo.contact.id
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
                                            id: todo.contact.id,
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
    },

    created() {},

    mounted() {
        console.log(
            "this is the route params: " + this.$route.params.selectedDate
        );
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
            this.currentDate = this.getCurrentDate();
            this.selectedDate = this.currentDate;
            this.getToDosSelectDate();
        } else {
            this.selectedDate = this.$route.params.selectedDate;
            this.getToDosSelectDate();
        }
        //initial date selection
        console.log(
            "Result of mounted getCurrentDate: " + this.getCurrentDate()
        );

        // this.getSelectedDate(this.selectedDate);
        console.log("Result of mounted currrentDate: " + this.currentDate);

        //initial month selection
        this.selectedMonth = this.getSelectedMonth(this.selectedDate);
        this.selectedYear = this.getSelectedYear(this.selectedDate);
        this.selectedMonthYear =
            this.selectedYear + "-" + this.selectedMonth + "-" + "01";
        this.currentMonth = this.selectedYear + "-" + this.selectedMonth;
        //initialise date range
        this.selectedDateStart = this.selectedDate;
        this.selectedDateEnd = this.selectedDate;
        console.log(
            "Result of mounted selectedDateStart: " + this.selectedDateStart
        );
        console.log(
            "Result of mounted selectedDateEnd: " + this.selectedDateEnd
        );

        this.incrementDate();
        this.decrementDate();
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
            viewType: "day",
            moment: moment,

            search: "",
            todo: "",

            selectPage: false,
            selectAll: false,
            checked: [],
            url: "",
            changeAction: false,

            todo_remark_visibility: false,
            todo_remark: null,

            selectedUser: "",
            selectedSource: "",
            selectedStatus: "",
            selectedType: "",
            selectedContact: "",
            selectedTask: "",

            currentDate: "",
            currentMonth: "",
            currentYear: "",

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
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },
        search: function (value) {
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },
        selectedStatus: function (value) {
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },

        selectedUser: function (value) {
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },
        selectedType: function (value) {
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },
        selectedContact: function (value) {
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },
        selectedTask: function (value) {
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },
        selectedSource: function (value) {
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },

        viewType: function (value) {
            if (value === "day") {
                if (this.viewType === "day") {
                    this.getToDosSelectDate();
                }
            }
            if (value === "month") {
                const monthYear = this.selectedMonthYear;
                this.getSelectedMonth(monthYear);
                this.getSelectedYear(monthYear);
                console.log(
                    "Result of this.getSelectedMonth(monthYear): " +
                        this.getSelectedMonth(monthYear)
                );
                console.log(
                    "Result of this.getSelectedYear(monthYear): " +
                        this.getSelectedYear(monthYear)
                );
                this.getToDosSelectMonth();
            }
            if (value === "range") {
                this.getSelectedDateStart(this.currentDate);
                this.getSelectedDateEnd(this.currentDate);
                this.getToDosSelectDateRange();
            }
        },
        selectedDate: function (value) {
            if (this.viewType === "day") {
                this.getSelectedDate(this.selectedDate);
                this.getToDosSelectDate();
            }
        },

        currentMonth: function (value) {
            const monthYear = this.currentMonth + "-" + "01";
            this.selectedMonthYear = monthYear;
            this.getSelectedMonth(monthYear);
            this.getSelectedYear(monthYear);
            this.getToDosSelectMonth();
            console.log("current date after month change: " + this.currentDate);
        },

        selectedDateRange(newVal) {
            const [selectedDateStart, selectedDateEnd] = newVal.split("|");
            this.getSelectedDateStart(selectedDateStart);
            this.getSelectedDateEnd(selectedDateEnd);
            console.log(
                "result of date after this.getSelectedDateEnd(selectedDateStart): " +
                    this.getSelectedDateEnd(selectedDateStart)
            );
            console.log(
                "result of date after this.getSelectedDateEnd(selectedDateEnd): " +
                    this.getSelectedDateEnd(selectedDateEnd)
            );
            this.getToDosSelectDateRange();
        },
    },
    computed: {
        selectedDateRange() {
            return `${this.selectedDateStart}|${this.selectedDateEnd}`;
        },
    },

    methods: {
        toggleRemark(todo_id) {
            this.todo_remark = todo_id;
            this.todo_remark_visibility = !this.todo_remark_visibility;
        },

        getToDosSelectDate(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/todos/index?" +
                        "q=" +
                        this.search +
                        "&selectedDate=" +
                        this.selectedDate +
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
                    this.todos = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getToDosSelectMonth(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/todos/index/monthrange?" +
                        "q=" +
                        this.search +
                        "&selectedMonth=" +
                        this.selectedMonth +
                        "&selectedYear=" +
                        this.selectedYear +
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
                    this.todos = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getToDosSelectDateRange(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/todos/index/daterange?" +
                        "q=" +
                        this.search +
                        "&selectedDateStart=" +
                        this.selectedDateStart +
                        "&selectedDateEnd=" +
                        this.selectedDateEnd +
                        "&selectedStatus=" +
                        this.selectedStatus +
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
            if (this.viewType === "day") {
                if (this.sort_field == field) {
                    this.sort_direction =
                        this.sort_direction == "asc" ? "desc" : "asc";
                } else {
                    this.sort_field = field;
                }
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                if (this.sort_field == field) {
                    this.sort_direction =
                        this.sort_direction == "asc" ? "desc" : "asc";
                } else {
                    this.sort_field = field;
                }
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                if (this.sort_field == field) {
                    this.sort_direction =
                        this.sort_direction == "asc" ? "desc" : "asc";
                } else {
                    this.sort_field = field;
                }
                this.getToDosSelectDateRange();
            }
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

        deleteToDo(id) {
            if (!window.confirm("Are you sure?")) {
                return;
            }
            axios.delete("/api/todos/delete/" + id);
            if (this.viewType === "day") {
                this.getToDosSelectDate();
            } else if (this.viewType === "month") {
                this.getToDosSelectMonth();
            } else if (this.viewType === "range") {
                this.getToDosSelectDateRange();
            }
        },

        actionSelected(action, toDoId, contactId) {
            if (!window.confirm("Update task?")) {
                this.todo_action.action_id = "";
                return;
            }
            console.log("this is is the action ID: " + action);
            console.log("this is is the todo ID: " + toDoId);
            console.log("this is is the contact ID: " + contactId);
            axios.put("/api/todos/action/" + toDoId, {
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
            if (this.viewType === "day") {
                document.getElementById("incrementDate").disabled = false;
                return (this.selectedDate = moment(this.selectedDate).add(
                    1,
                    "d"
                ));
            } else if (this.viewType === "month") {
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
                return (this.currentMonth = year + "-" + month);
            } else {
                document.getElementById("incrementDate").disabled = true;
            }
        },

        decrementDate() {
            if (this.viewType === "day") {
                document.getElementById("decrementDate").disabled = false;
                return (this.selectedDate = moment(this.selectedDate).subtract(
                    1,
                    "d"
                ));
            } else if (this.viewType === "month") {
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
                return (this.currentMonth = year + "-" + month);
            } else {
                document.getElementById("decrementDate").disabled = true;
            }
        },

        // exportSelected() {
        //     if (this.checked.length === 0) {
        //         return alert("Need select record.");
        //     } else {
        //         axios.get("/api/todos/export");
        //     }
        // },

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
</style>
