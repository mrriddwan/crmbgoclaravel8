<template>
    <div class="w-max">
        <h1
            class="items-center text-center text-4xl text-white font-extrabold font-mono uppercase bg-slate-400 px-2 rounded-md"
        >
            Billboard Summary
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

                <div class="items-center" v-if="can('create billboard')">
                    <router-link
                        to="/billboard/create"
                        class="inline-block items-center px-2 py-1 align-top bg-blue-800 border-transparent rounded-md font-semibold text-m text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        <PlusIcon class="inline h-6 w-6 mr-1" />
                        Billboard</router-link
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
                    <!-- <div class="bg-blue-700 rounded-md w-max px-2 py-2">
                        <button @click="getBillboards" class="text-white">
                            Find Records
                        </button>
                    </div> -->
                    <div>
                        <!-- <download-excel
                            :data="billboards.data"
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
            </div>

            <div class="block max-h-screen overflow-y-auto overflow-x-auto">
                <table
                    class="table table-hover table-bordered w-max"
                    id="summary_table"
                >
                    <thead class="bg-slate-600 border-b sticky top-0">
                        <tr class="w-full">
                            <th class="w-10">
                                <div class="text-xs text-center h-6 text-white">
                                    No.
                                </div>
                            </th>
                            <th class="w-w-max">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="change_sort('site_id')"
                                        class="text-white"
                                    >
                                        Site No.
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'site_id'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'site_id'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <!-- <div
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
                                </div> -->
                            </th>

                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('bboard_location')
                                        "
                                        class="text-white"
                                    >
                                        Location
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'bboard_location'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'bboard_location'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                            </th>
                            <th class="w-10">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('bboard_size')
                                        "
                                        class="text-white"
                                    >
                                        Size
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'bboard_size'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'bboard_size'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                                <!--     <div class="text-xs text-center h-6">
                                     <div class="text-xs text-center h-6">
                                        <select
                                            v-model="selectedSize"
                                            class="form-control form-control-sm w-max"
                                        >
                                            <option value="">All</option>
                                            <option
                                                v-for="billboard_size in billboard_sizes.data"
                                                :key="billboard_size.id"
                                                :value="billboard_size.id"
                                            >
                                                {{ billboard_size.name }}
                                            </option>
                                        </select>
                                    </div> 
                                </div>-->
                            </th>
                            <th class="w-max">
                                <div class="text-xs text-center h-6">
                                    <a
                                        href="#"
                                        @click.prevent="
                                            change_sort('company_name')
                                        "
                                        class="text-white"
                                    >
                                        Company
                                    </a>
                                    <span
                                        v-if="
                                            sort_direction == 'desc' &&
                                            sort_field == 'company_name'
                                        "
                                        >&uarr;</span
                                    >
                                    <span
                                        v-if="
                                            sort_direction == 'asc' &&
                                            sort_field == 'company_name'
                                        "
                                        >&darr;</span
                                    >
                                </div>
                            </th>

                            <th class="">
                                <div class="text-xs text-center text-white">
                                    Jan
                                </div>
                            </th>
                            <th class="">
                                <div class="text-xs text-center text-white">
                                    Feb
                                </div>
                            </th>
                            <th class="">
                                <div class="text-xs text-center text-white">
                                    Mar
                                </div>
                            </th>
                            <th class="">
                                <div class="text-xs text-center text-white">
                                    Apr
                                </div>
                            </th>
                            <th class="">
                                <div class="text-xs text-center text-white">
                                    May
                                </div>
                            </th>
                            <th class="">
                                <div class="text-xs text-center text-white">
                                    June
                                </div>
                            </th>
                            <th class="">
                                <div class="text-xs text-center text-white">
                                    July
                                </div>
                            </th>
                            <th class="">
                                <div class="text-xs text-center text-white">
                                    Aug
                                </div>
                            </th>
                            <th class="">
                                <div class="text-xs text-center text-white">
                                    Sept
                                </div>
                            </th>
                            <th class="">
                                <div class="text-xs text-center text-white">
                                    Oct
                                </div>
                            </th>
                            <th class="">
                                <div class="text-xs text-center text-white">
                                    Nov
                                </div>
                            </th>
                            <th class="">
                                <div class="text-xs text-center text-white">
                                    Dec
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-xs font-bold bg-gray-500 text-black">
                        <tr
                            v-for="(billboard, index) in billboards.data"
                            :key="billboard.id"
                        >
                            <td class="text-white font-bold">
                                {{ index + 1 }}
                            </td>
                            <td>
                                <div
                                    v-if="
                                        can('edit billboard') ||
                                        is('supervisor | admin | super-admin')
                                    "
                                    class="text-black"
                                >
                                    <router-link
                                        :to="`/billboard/${billboard.id}/tenure`"
                                        custom
                                        v-slot="{ navigate, href }"
                                    >
                                        <a
                                            class="text-blue-300 font-bold"
                                            :href="href"
                                            @click.stop="navigate"
                                            >{{ billboard.site_id }}</a
                                        >
                                    </router-link>
                                </div>
                                <div v-else class="my-1">
                                    {{ billboard.site_id }}
                                </div>
                            </td>
                            <td class="text-white font-bold">
                                {{ billboard.bboard_location }}
                            </td>
                            <td class="text-white font-bold">
                                {{ billboard.bboard_size }}
                            </td>
                            <td class="w-max">
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class="border-2 border-slate-500"
                                >
                                    <div class="w-max grid-cols-1 gap-1 px-2">
                                        <div>
                                            <td>
                                                <router-link
                                                    :to="`/contact/${tenure.company_id}/info`"
                                                    custom
                                                    v-slot="{ navigate, href }"
                                                >
                                                    <a
                                                        class="text-blue-300 font-bold"
                                                        :href="href"
                                                        @click.stop="navigate"
                                                        >{{
                                                            tenure.company_name
                                                        }}</a
                                                    >
                                                </router-link>
                                            </td>
                                        </div>
                                    </div>
                                </tr>
                            </td>
                            <td class="text-xs py-2 w-max">
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class=""
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-01' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-01'
                                        "
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-01'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-01'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-01-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
                            </td>
                            <td class="py-2 w-max">
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class=""
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-02' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-02'
                                        "
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-02'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-02'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-02-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
                            </td>
                            <td class="my-2">
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class="my-2"
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-03' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-03'
                                        "
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-03'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-03'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-03-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
                            </td>
                            <td class="py-2 w-max">
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class=""
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-04' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-04'
                                        "
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-04'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-04'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-04-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
                            </td>
                            <td class="py-2 w-max">
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class=""
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-05' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-05'
                                        "
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-05'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-05'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-05-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
                            </td>
                            <td class="py-2 w-max">
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class=""
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-06' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-06'
                                        "
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-06'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-06'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-06-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
                            </td>
                            <td class="py-2 w-max">
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class=""
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-07' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-07'
                                        "
                                        class="w-full"
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-07'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-07'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-07-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
                            </td>
                            <td>
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class="py-2"
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-08' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-08'
                                        "
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-08'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-08'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-08-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
                            </td>
                            <td>
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class="py-2"
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-09' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-09'
                                        "
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-09'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-09'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-09-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
                            </td>
                            <td>
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class="py-2"
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-10' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-10'
                                        "
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-10'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-10'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-10-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
                            </td>
                            <td>
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class="py-2"
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-11' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-11'
                                        "
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-11'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-11'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-11-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
                            </td>
                            <td>
                                <tr
                                    v-for="tenure in billboard.summary"
                                    :key="tenure.id"
                                    class="py-2"
                                >
                                    <td
                                        v-if="
                                            getMonth(
                                                tenure.tenure_startdate
                                            ) ===
                                                this.selectedYear + '-12' ||
                                            getMonth(tenure.tenure_enddate) ===
                                                this.selectedYear + '-12'
                                        "
                                    >
                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_startdate
                                                ) ===
                                                this.selectedYear + '-12'
                                            "
                                            class="bg-green-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(
                                                    tenure.tenure_startdate
                                                )
                                            }}<br />
                                        </div>

                                        <div
                                            v-if="
                                                getMonth(
                                                    tenure.tenure_enddate
                                                ) ===
                                                this.selectedYear + '-12'
                                            "
                                            class="bg-red-300 text-center px-1 font-bold border-2 border-slate-500 w-max"
                                        >
                                            {{
                                                showToday(tenure.tenure_enddate)
                                            }}
                                        </div>
                                    </td>
                                    <td
                                        v-else-if="
                                            checkMonth(
                                                this.selectedYear + '-12-01',
                                                tenure.tenure_startdate,
                                                tenure.tenure_enddate
                                            )
                                        "
                                        class="bg-green-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                    <td
                                        v-else
                                        class="bg-yellow-300 text-center w-16 px-1 font-bold text-transparent border-2 border-slate-500"
                                    >
                                        X
                                    </td>
                                </tr>
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
        // this.getTenures();
        this.getBillboardSizes();
        this.getBillboards();
    },
    data() {
        return {
            tenures: [],
            billboard_sizes: [],
            contacts: [],
            billboards: [],

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

            sort_direction: "asc",
            sort_field: "site_id",
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
            this.getTenures();
        },
        search: function (value) {
            this.getTenures();
        },
        selectedYear: function (value) {
            this.getTenures();
        },
        selectedSite: function (value) {
            this.getTenures();
        },
        selectedSize: function (value) {
            this.getTenures();
        },
    },

    computed: {},

    methods: {
        getTenures(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/billboards/tenure?" +
                        "q=" +
                        this.search +
                        "&selectedYear=" +
                        this.selectedYear +
                        "&selectedSite=" +
                        this.selectedSite +
                        "&selectedSize=" +
                        this.selectedSize +
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
                    this.tenures = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        getBillboards(page = 1) {
            if (typeof page === "undefined") {
                page = 1;
            }
            axios
                .get(
                    "/api/billboards/index"
                    // +
                    // "q=" +
                    // this.search +
                    // "&selectedYear=" +
                    // this.selectedYear +
                    // "&selectedSite=" +
                    // this.selectedSite +
                    // "&selectedSize=" +
                    // this.selectedSize +
                    // "&paginate=" +
                    // this.paginate +
                    // "&page=" +
                    // page +
                    // "&sort_direction=" +
                    // this.sort_direction +
                    // "&sort_field=" +
                    // this.sort_field
                )
                .then((res) => {
                    this.billboards = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getBillboardSites() {
            await axios
                .get("/api/billboards/site")
                .then((res) => {
                    this.billboard_sites = res.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getBillboardSizes() {
            await axios
                .get("/api/billboards/size")
                .then((res) => {
                    this.billboard_sizes = res.data;
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
            await this.getBillboards();
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

        getMonth(date) {
            let day = moment(date).format("YYYY-MM");
            return day;
        },

        checkMonth(month, start_date, end_date) {
            const date = new Date(month);

            const start = new Date(start_date);
            const end = new Date(end_date);

            if (date > start && date < end) {
                // console.log("✅ date is between the 2 dates");
                return true;
            } else {
                // console.log("⛔️ date is not in the range");
                return false;
            }
        },
    },
};
</script>

<style scoped>
@import "bootstrap/dist/css/bootstrap.min.css";
</style>
