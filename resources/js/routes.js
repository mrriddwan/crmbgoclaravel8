import { createRouter, createWebHistory } from "vue-router";
// import TestQueryString from "../components/utils/TestQueryString.vue";

/**Contact Imports */
import ContactIndex from "../components/contacts/ContactIndex.vue";
import ContactCreate from "../components/contacts/ContactCreate.vue";
import ContactEdit from "../components/contacts/ContactEdit.vue";
import ContactHistory from "../components/contacts/ContactHistory.vue";
import ContactInfo from "../components/contacts/ContactInfo.vue";

import InchargeCreate from "../components/contacts/InchargeCreate.vue";
import InchargeEdit from "../components/contacts/InchargeEdit.vue";

/**Forecast Imports */
import ForecastIndex from "../components/forecasts/ForecastIndex.vue";
import ForecastEdit from "../components/forecasts/ForecastEdit.vue";
import ForecastCreateInfo from "../components/forecasts/ForecastCreateInfo.vue";

/**ToDo Imports */
import ToDoIndex from "../components/todo/ToDoIndex.vue";
import ToDoCreate from "../components/todo/ToDoCreate.vue";
import ToDoEdit from "../components/todo/ToDoEdit.vue";
import ToDoInsert from "../components/todo/ToDoInsert.vue";

/**ToDo Imports */
import FollowUpIndex from "../components/followups/FollowUpIndex.vue";
import FollowUpCreate from "../components/followups/FollowUpCreate.vue";

const routes = [

    /*                      
        test Routes                      
    */

        // {
        //     path: "/testpage",
        //     name: "TestQueryString",
        //     component: TestQueryString,
        // },



    /*                      
        Contact Routes                      
    */

    {
        path: "/dashboard",
        name: "contact_index",
        component: ContactIndex,
    },

    {
        path: "/contacts/create",
        name: "contacts_create",
        component: ContactCreate,
    },

    {
        path: "/contacts/:id/edit",
        name: "contacts_edit",
        component: ContactEdit,
    },

    {
        path: "/contacts/:id/info",
        name: "contacts_info",
        component: ContactInfo,
    },

    {
        path: "/contacts/:id/history",
        name: "contacts_history",
        component: ContactHistory,
    },

    {
        path: "/incharges/:id/create",
        name: "incharge_create",
        component: InchargeCreate,
    },

    {
        path: "/incharges/:id/edit",
        name: "incharge_edit",
        component: InchargeEdit,
    },

    /*                                                  
            Forecast Routes 
    */

    {
        path: "/forecasts/index",
        name: "forecast_index",
        component: ForecastIndex,
    },

    {
        path: "/forecasts/createinfo",
        name: "forecast_createinfo",
        component: ForecastCreateInfo,
    },

    {
        path: "/forecast_edit/:id",
        name: "forecast_edit",
        component: ForecastEdit,
    },
    /*                                                  
            To Do Routes 
    */

    {
        path: "/todo/index",
        name: "todo_index",
        component: ToDoIndex,
        // props: route => ({ selectedDate: route.query.q })
    },

    {
        path: "/todo/:id/insert",
        name: "todo_insert",
        component: ToDoInsert,
        props: true,
    },

    {
        path: "/todo/create",
        name: "todo_create",
        component: ToDoCreate,
    },

    {
        path: "/todo/:id/edit",
        name: "todo_edit",
        component: ToDoEdit,
        props: true,
    },

    /*                                                  
            To Do Routes 
    */

    {
        path: "/followup/index",
        name: "followup_index",
        component: FollowUpIndex,
    },

    {
        path: "/followup/:id/create",
        name: "followup_create",
        component: FollowUpCreate,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
