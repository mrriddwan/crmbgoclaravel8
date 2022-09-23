import { createRouter, createWebHistory } from "vue-router";
// import TestQueryString from "../components/utils/TestQueryString.vue";

/**Contact Imports */
import ContactIndex from "../components/contacts/ContactIndex.vue";
import ContactCreate from "../components/contacts/ContactCreate.vue";
import ContactEdit from "../components/contacts/ContactEdit.vue";
import ContactHistory from "../components/contacts/ContactHistory.vue";
import ContactInfo from "../components/contacts/ContactInfo.vue";
import ContactSummary from "../components/contacts/ContactSummary.vue";

import InchargeCreate from "../components/contacts/InchargeCreate.vue";
import InchargeEdit from "../components/contacts/InchargeEdit.vue";

/**ToDo Imports */
import ToDoIndex from "../components/todo/ToDoIndex.vue";
import ToDoCreate from "../components/todo/ToDoCreate.vue";
import ToDoEdit from "../components/todo/ToDoEdit.vue";
import ToDoInsert from "../components/todo/ToDoInsert.vue";

/**Follow Up Imports */
import FollowUpIndex from "../components/followups/FollowUpIndex.vue";
import FollowUpCreate from "../components/followups/FollowUpCreate.vue";

/**Forecast Imports */
import ForecastIndex from "../components/forecasts/ForecastIndex.vue";
import ForecastCreate from "../components/forecasts/ForecastCreate.vue";
import ForecastEdit from "../components/forecasts/ForecastEdit.vue";

/**Project Imports */
import ProjectIndex from "../components/projects/ProjectIndex.vue";
import ProjectCreate from "../components/projects/ProjectCreate.vue";
import ProjectEdit from "../components/projects/ProjectEdit.vue";

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
        path: "/contact/index",
        name: "contact_index",
        component: ContactIndex,
    },

    {
        path: "/contact/summary",
        name: "contact_summary",
        component: ContactSummary,
    },

    {
        path: "/contact/create",
        name: "contacts_create",
        component: ContactCreate,
    },

    {
        path: "/contact/:id/edit",
        name: "contacts_edit",
        component: ContactEdit,
    },

    {
        path: "/contact/:id/info",
        name: "contacts_info",
        component: ContactInfo,
    },

    {
        path: "/contact/:id/history",
        name: "contacts_history",
        component: ContactHistory,
    },

    {
        path: "/incharge/:id/create",
        name: "incharge_create",
        component: InchargeCreate,
    },

    {
        path: "/incharge/:id/edit",
        name: "incharge_edit",
        component: InchargeEdit,
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
            Follow Up Routes 
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
    /*                                                  
            Forecast Routes 
    */

    {
        path: "/forecast/index",
        name: "forecast_index",
        component: ForecastIndex,
    },

    {
        path: "/forecast/:id/create",
        name: "forecast_create",
        component: ForecastCreate,
    },

    {
        path: "/forecast/:id/edit",
        name: "forecast_edit",
        component: ForecastEdit,
    },

    /*                                                  
            Project Routes 
    */

    {
        path: "/project/index",
        name: "project_index",
        component: ProjectIndex,
    },

    {
        path: "/project/create",
        name: "project_create",
        component: ProjectCreate,
    },

    {
        path: "/project/:id/edit",
        name: "project_edit",
        component: ProjectEdit,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
