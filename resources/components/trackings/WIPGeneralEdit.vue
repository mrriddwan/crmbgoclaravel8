<template>
    <div class="w-full min-h-screen">
        <div v-if="errors">
            <div v-for="(v, k) in errors" :key="k">
                <p
                    v-for="error in v"
                    :key="error"
                    class="text-xs bg-red-500 text-white rounded font-bold mb-1 shadow-lg py-2 px-4 pr-0 w-max"
                >
                    {{ error }}
                </p>
            </div>
        </div>
        <div class="">
            <GoBack />
        </div>
        <div class="flex w-full row">
            <div class="col-lg-20">
                <form
                    @submit.prevent="updateWIPGeneral"
                    class="rounded px-8 pt-1 pb-8 mb-4"
                >
                    <div
                        class="text-center text-white bg-blue-900 px-2 py-1 rounded-md"
                    >
                        <h1
                            class="px-8 bg-black-50 uppercase w-full font-mono font-extrabold"
                        >
                            Edit Tracking (General) - WIP
                        </h1>
                    </div>

                    <div class="form-group grid grid-cols-2">
                        <label class="font-bold"
                            >User
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="wip.tracking_general.user_id"
                            @change="getUsers"
                        >
                            <option value="">Select user</option>
                            <option
                                v-for="user in users"
                                :key="user.id"
                                :value="user.id"
                            >
                                {{ user.name }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group grid grid-cols-2">
                        <label class="font-bold"
                            >Company
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="overflow-y block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="wip.tracking_general.company_id"
                            @change="getContacts"
                        >
                            <option value="">Select company</option>
                            <option
                                class=""
                                v-for="contact in contacts"
                                :key="contact.id"
                                :value="contact.id"
                            >
                                {{ contact.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group grid grid-cols-2">
                        <label class="font-bold"
                            >Product
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="wip.tracking_general.contact_category_id"
                            @change="getCategory"
                        >
                            <option value="">Select product</option>
                            <option
                                v-for="category in categories"
                                :key="category.id"
                                :value="category.id"
                            >
                                {{ category.name }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group mt-2 grid grid-cols-2">
                        <div>
                            <label class="font-bold">Artwork Frequency</label>
                            <p class="inline text-red-600 text-lg">*</p>
                            <!-- <div
                            v-if="form.remark.length >= 800"
                            class="text-red-600 inline text-xs uppercase"
                        >
                            Exceeded limit
                        </div> -->
                        </div>
                        <div class="flex">
                            <input
                                disabled
                                maxlength="800"
                                type="number"
                                class="mx-1 bg-slate-500 text-center form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                v-model="wip.frequency_no"
                                placeholder="eg: 6"
                            />
                            <p class="text-lg mx-3">/</p>
                            <input
                                disabled
                                maxlength="800"
                                type="number"
                                class="mx-1 bg-slate-500 text-center form-control block px-3 py-1.5 text-base font-normal text-gray-700 bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                v-model="wip.tracking_general.art_frequency"
                                placeholder="eg: 6"
                            />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 items-center mt-2">
                        <div>
                            <label class="font-bold"
                                >Start Date
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                        </div>
                        <div>
                            <div class="w-full">
                                <VueDatePicker
                                    v-model="
                                        wip.tracking_general.general_startdate
                                    "
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                    placeholder="Select date"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 items-center mt-2">
                        <div>
                            <label class="font-bold"
                                >End Date
                                <p class="inline text-red-600 text-lg">
                                    *
                                </p></label
                            >
                        </div>
                        <div>
                            <div class="w-full">
                                <VueDatePicker
                                    v-model="
                                        wip.tracking_general.general_enddate
                                    "
                                    showNowButton
                                    nowButtonLabel="Today"
                                    :enableTimePicker="false"
                                    placeholder="Select date"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="form-group grid grid-cols-2">
                        <label class="font-bold"
                            >Status
                            <p class="inline text-red-600 text-lg">*</p></label
                        >
                        <select
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            v-model="wip.wip_progress"
                        >
                            <option value="Pending">Pending</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>

                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                    >
                        <label class="font-bold">Artwork Chase </label>
                        <div class="grid grid-cols-6">
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Progress</label>
                                <select
                                    class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.art_chase_done"
                                >
                                    <option value="2">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Date</label>
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="wip.art_chase_date"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        placeholder="Select date"
                                    />
                                </div>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">User</label>
                                <select
                                    class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.art_chase_user_id"
                                    @change="getUsers"
                                >
                                    <option value="">Select user</option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 my-2 col-span-3">
                                <label class="font-bold">Note</label>
                                <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                <textarea
                                    id="message"
                                    maxlength="800"
                                    rows="1"
                                    v-model="wip.art_chase_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                    class="block w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                    >
                        <label class="font-bold">Artwork Received </label>
                        <div class="grid grid-cols-6">
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Progress</label>
                                <select
                                    class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.art_received_done"
                                >
                                    <option value="2">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Date</label>
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="wip.art_received_date"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        placeholder="Select date"
                                    />
                                </div>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">User</label>
                                <select
                                    class="block w-full text-center h-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.art_received_user_id"
                                    @change="getUsers"
                                >
                                    <option value="">Select user</option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 my-2 col-span-3">
                                <label class="font-bold">Note</label>
                                <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                <textarea
                                    id="message"
                                    maxlength="800"
                                    rows="1"
                                    v-model="wip.art_received_remark"
                                    placeholder="eg: Artwork by Client"
                                    class="block p-2.5 w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                    >
                        <label class="font-bold">Artwork To Do </label>
                        <div class="grid grid-cols-6">
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Progress</label>
                                <select
                                    class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.art_todo_done"
                                >
                                    <option value="2">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Date</label>
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="wip.art_todo_date"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        placeholder="Select date"
                                    />
                                </div>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">User</label>
                                <select
                                    class="block w-full text-center h-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.art_todo_user_id"
                                    @change="getUsers"
                                >
                                    <option value="">Select user</option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 my-2 col-span-3">
                                <label class="font-bold">Note</label>
                                <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                <textarea
                                    id="message"
                                    maxlength="800"
                                    rows="1"
                                    v-model="wip.art_todo_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                    class="block p-2.5 w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                    >
                        <label class="font-bold">Cop & Signed Sent </label>
                        <div class="grid grid-cols-6">
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Progress</label>
                                <select
                                    class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.cns_sent_done"
                                >
                                    <option value="2">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Date</label>
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="wip.cns_sent_date"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        placeholder="Select date"
                                    />
                                </div>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">User</label>
                                <select
                                    class="block w-full text-center h-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.cns_sent_user_id"
                                    @change="getUsers"
                                >
                                    <option value="">Select user</option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 my-2 col-span-3">
                                <label class="font-bold">Note</label>
                                <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                <textarea
                                    id="message"
                                    maxlength="800"
                                    v-model="wip.cns_sent_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                    class="block p-2.5 w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                    >
                        <label class="font-bold">Cop & Signed Record </label>
                        <div class="grid grid-cols-6">
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Progress</label>
                                <select
                                    class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.cns_record_done"
                                >
                                    <option value="2">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Date</label>
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="wip.cns_record_date"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        placeholder="Select date"
                                    />
                                </div>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">User</label>
                                <select
                                    class="block w-full text-center h-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.cns_record_user_id"
                                    @change="getUsers"
                                >
                                    <option value="">Select user</option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 my-2 col-span-3">
                                <label class="font-bold">Note</label>
                                <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                <textarea
                                    id="message"
                                    maxlength="800"
                                    rows="1"
                                    v-model="wip.cns_record_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                    class="block p-2.5 w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                    >
                        <label class="font-bold">Schedule</label>
                        <div class="grid grid-cols-6">
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Progress</label>
                                <select
                                    class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.schedule_done"
                                >
                                    <option value="2">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Date</label>
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="wip.schedule_date"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        placeholder="Select date"
                                    />
                                </div>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">User</label>
                                <select
                                    class="block w-full text-center h-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.schedule_user_id"
                                    @change="getUsers"
                                >
                                    <option value="">Select user</option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 my-2 col-span-3">
                                <label class="font-bold">Note</label>
                                <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                <textarea
                                    id="message"
                                    maxlength="800"
                                    rows="1"
                                    v-model="wip.schedule_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                    class="block p-2.5 w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                    >
                        <label class="font-bold">Live</label>
                        <div class="grid grid-cols-6">
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Progress</label>
                                <select
                                    class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.actual_live_done"
                                >
                                    <option value="2">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Date</label>
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="wip.actual_live_date"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        placeholder="Select date"
                                    />
                                </div>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">User</label>
                                <select
                                    class="block w-full text-center h-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.actual_live_user_id"
                                    @change="getUsers"
                                >
                                    <option value="">Select user</option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 my-2 col-span-3">
                                <label class="font-bold">Note</label>
                                <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                <textarea
                                    id="message"
                                    maxlength="800"
                                    rows="1"
                                    v-model="wip.actual_live_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                    class="block p-2.5 w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                    >
                        <label class="font-bold">Client Posting </label>
                        <div class="grid grid-cols-6">
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Progress</label>
                                <select
                                    class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.client_posting_done"
                                >
                                    <option value="2">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Date</label>
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="wip.client_posting_date"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        placeholder="Select date"
                                    />
                                </div>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">User</label>
                                <select
                                    class="block w-full text-center h-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.client_posting_user_id"
                                    @change="getUsers"
                                >
                                    <option value="">Select user</option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 my-2 col-span-3">
                                <label class="font-bold">Note</label>
                                <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                <textarea
                                    id="message"
                                    maxlength="800"
                                    rows="1"
                                    v-model="wip.client_posting_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                    class="block p-2.5 w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div
                        class="text-center border-2 px-1 py-1 border-slate-300 my-2"
                    >
                        <label class="font-bold">Report</label>
                        <div class="grid grid-cols-6">
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Progress</label>
                                <select
                                    class="block h-max w-full text-center rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.report_done"
                                >
                                    <option value="2">Pending</option>
                                    <option value="1">Completed</option>
                                </select>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">Date</label>
                                <div class="w-full">
                                    <VueDatePicker
                                        v-model="wip.report_date"
                                        showNowButton
                                        nowButtonLabel="Today"
                                        :enableTimePicker="false"
                                        placeholder="Select date"
                                    />
                                </div>
                            </div>
                            <div class="mx-1 grid grid-cols-1">
                                <label class="font-bold">User</label>
                                <select
                                    class="block w-full text-center h-max rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    v-model="wip.report_user_id"
                                    @change="getUsers"
                                >
                                    <option value="">Select user</option>
                                    <option
                                        v-for="user in users"
                                        :key="user.id"
                                        :value="user.id"
                                    >
                                        {{ user.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="grid grid-cols-1 my-2 col-span-3">
                                <label class="font-bold">Note</label>
                                <!-- <input
                                    maxlength="800"
                                    type="text"
                                    class="form-control block w-96 h-24 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                    v-model="wip.general_remark"
                                    placeholder="eg: Artwork by Bluedale"
                                /> -->
                                <textarea
                                    id="message"
                                    maxlength="800"
                                    rows="1"
                                    v-model="wip.report_user_id"
                                    placeholder="eg: Artwork by Bluedale"
                                    class="block p-2.5 w-full text-sm rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                ></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-2">
                        <label class="font-bold"
                            >Remark
                            <p class="inline text-red-600 text-lg">*</p></label
                        >

                        <!-- <div
                            v-if="form.remark.length >= 800"
                            class="text-red-600 inline text-xs uppercase"
                        >
                            Exceeded limit
                        </div> -->
                        <input
                            maxlength="800"
                            type="text"
                            class="form-control block w-96 h-40 px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            v-model="wip.wip_remark"
                            placeholder="eg: Artwork by Bluedale"
                        />
                    </div>

                    <button
                        type="submit"
                        class="inline-flex mt-2 items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150"
                    >
                        Update
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import GoBack from "../utils/GoBack.vue";
import axios from "axios";
import moment from "moment";

export default {
    data() {
        return {
            wip: {
                wip_remark: "",
                wip_progress: "",
                art_chase_date: "",
                art_chase_done: "",
                art_chase_remark: "",
                art_chase_user_id: "",
                art_received_date: "",
                art_received_done: "",
                art_received_remark: "",
                art_received_user_id: "",
                art_todo_date: "",
                art_todo_done: "",
                art_todo_remark: "",
                art_todo_user_id: "",
                cns_sent_date: "",
                cns_sent_done: "",
                cns_sent_remark: "",
                cns_sent_user_id: "",
                cns_record_date: "",
                cns_record_done: "",
                cns_record_remark: "",
                cns_record_user_id: "",
                schedule_date: "",
                schedule_done: "",
                schedule_user_id: "",
                schedule_remark: "",
                actual_live_date: "",
                actual_live_done: "",
                actual_live_remark: "",
                actual_live_user_id: "",
                client_posting_date: "",
                client_posting_done: "",
                client_posting_user_id: "",
                client_posting_remark: "",
                report_date: "",
                report_done: "",
                report_remark: "",
                report_user_id: "",
                frequency_no: "",
                tracking_general_id: "",
                tracking_general: {
                    id: "",
                    company_id: "",
                    user_id: "",
                    contact_category_id: "",
                    art_frequency: "",
                    general_startdate: "",
                    general_enddate: "",
                    progress: "",
                    general_remark: "",
                },
            },

            moment: moment,
            users: [],
            categories: [],
            contacts: [],
            tenure_length: "day",
            errors: "",
        };
    },

    mounted() {
        this.getWIPGeneral();
        this.getUsers();
        this.getCategory();
        this.getContacts();
    },

    created() {},

    methods: {
        async getWIPGeneral() {
            await axios
                .get("/api/trackings/wip/general/show/" + this.$route.params.id)
                .then((res) => {
                    this.wip = res.data.data[0];
                    // this.tracking.general_tenure = (
                    //     this.tracking.general_tenure / 30
                    // ).toFixed(1);
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getUsers() {
            await axios
                .get("/api/users/users_list")
                .then((res) => {
                    this.users = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getCategory() {
            await axios
                .get("/api/contacts/category/index")
                .then((res) => {
                    this.categories = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async getContacts() {
            await axios
                .get("/api/contacts/list")
                .then((res) => {
                    this.contacts = res.data.data;
                })
                .catch((error) => {
                    console.log(error);
                });
        },

        async updateWIPGeneral() {
            try {
                await axios
                    .put(
                        "/api/trackings/wip/general/update/" +
                            this.$route.params.id,
                        {
                            wip_remark: this.wip.wip_remark,
                            wip_progress: this.wip.wip_progress,
                            art_chase_date: this.wip.art_chase_date
                                ? this.moment(this.wip.art_chase_date).format(
                                      "YYYY-MM-DD"
                                  )
                                : null,
                            art_chase_done: parseInt(this.wip.art_chase_done),
                            art_chase_remark: this.wip.art_chase_remark,
                            art_chase_user_id: this.wip.art_chase_user_id,
                            art_received_date: this.wip.art_received_date
                                ? this.moment(
                                      this.wip.art_received_date
                                  ).format("YYYY-MM-DD")
                                : null,
                            art_received_done: parseInt(this.wip.art_received_done),
                            art_received_remark: this.wip.art_received_remark,
                            art_received_user_id: this.wip.art_received_user_id,
                            art_todo_date: this.wip.art_todo_date
                                ? this.moment(this.wip.art_todo_date).format(
                                      "YYYY-MM-DD"
                                  )
                                : null,
                            art_todo_done: parseInt(this.wip.art_todo_done),
                            art_todo_remark: this.wip.art_todo_remark,
                            art_todo_user_id: this.wip.art_todo_user_id,
                            cns_sent_date: this.wip.cns_sent_date
                                ? this.moment(this.wip.cns_sent_date).format(
                                      "YYYY-MM-DD"
                                  )
                                : null,
                            cns_sent_done: parseInt(this.wip.cns_sent_done),
                            cns_sent_remark: this.wip.cns_sent_remark,
                            cns_sent_user_id: this.wip.cns_sent_user_id,
                            cns_record_date: this.wip.cns_record_date
                                ? this.moment(this.wip.cns_record_date).format(
                                      "YYYY-MM-DD"
                                  )
                                : null,
                            cns_record_done: parseInt(this.wip.cns_record_done),
                            cns_record_remark: this.wip.cns_record_remark,
                            cns_record_user_id: this.wip.cns_record_user_id,
                            schedule_date: this.wip.schedule_date
                                ? this.moment(this.wip.schedule_date).format(
                                      "YYYY-MM-DD"
                                  )
                                : null,
                            schedule_done: parseInt(this.wip.schedule_done),
                            schedule_user_id: this.wip.schedule_user_id,
                            schedule_remark: this.wip.schedule_remark,
                            actual_live_date: this.wip.actual_live_date
                                ? this.moment(this.wip.actual_live_date).format(
                                      "YYYY-MM-DD"
                                  )
                                : null,
                            actual_live_done: parseInt(this.wip.actual_live_done),
                            actual_live_remark: this.wip.actual_live_remark,
                            actual_live_user_id: this.wip.actual_live_user_id,
                            client_posting_date: this.wip.client_posting_date
                                ? this.moment(
                                      this.wip.client_posting_date
                                  ).format("YYYY-MM-DD")
                                : null,
                            client_posting_done: parseInt(this.wip.client_posting_done),
                            client_posting_user_id:
                                this.wip.client_posting_user_id,
                            client_posting_remark:
                                this.wip.client_posting_remark,
                            report_date: this.wip.report_date
                                ? this.moment(this.wip.report_date).format(
                                      "YYYY-MM-DD"
                                  )
                                : null,
                            report_done: parseInt(this.wip.report_done),
                            report_remark: this.wip.report_remark,
                            report_user_id: this.wip.report_user_id,
                            tracking_general_id: this.wip.tracking_general_id,

                            //tracking general info
                            user_id: this.wip.tracking_general.user_id,
                            company_id: this.wip.tracking_general.company_id,
                            contact_category_id:
                                this.wip.tracking_general.contact_category_id,
                            category_description:
                                this.wip.tracking_general.category_description,
                            general_startdate: this.moment(
                                this.wip.tracking_general.general_startdate
                            ).format("YYYY-MM-DD"),
                            general_enddate: this.moment(
                                this.wip.tracking_general.general_enddate
                            ).format("YYYY-MM-DD"),
                            general_remark: this.wip.tracking_general
                                .general_remark
                                ? this.wip.general_remark
                                : "No remark",
                        }
                    )
                    .then((res) => {
                        this.$router.push({ name: "tracking_general" });
                    });
            } catch (e) {
                {
                    if (e.response.status === 422) {
                        this.errors = e.response.data.errors;
                    } else {
                        return "no error response";
                    }
                }
            }
        },
    },

    components: { GoBack },
};
</script>
