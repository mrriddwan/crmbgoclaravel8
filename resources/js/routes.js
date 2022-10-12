import { createRouter, createWebHistory } from "vue-router";
// import TestQueryString from "../components/utils/TestQueryString.vue";

/**Admin Imports */
import AdminData from "../components/admins/AdminData.vue";
import AdminUserAccess from "../components/admins/AdminUserAccess.vue";
import AdminUserManage from "../components/admins/AdminUserManage.vue";

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
import ToDoIndex from "../components/todos/ToDoIndex.vue";
import ToDoCreate from "../components/todos/ToDoCreate.vue";
import ToDoEdit from "../components/todos/ToDoEdit.vue";
import ToDoInsert from "../components/todos/ToDoInsert.vue";

/**Follow Up Imports */
import FollowUpIndex from "../components/followups/FollowUpIndex.vue";
import FollowUpCreate from "../components/followups/FollowUpCreate.vue";

/**Forecast Imports */
import ForecastIndex from "../components/forecasts/ForecastIndex.vue";
import ForecastCreate from "../components/forecasts/ForecastCreate.vue";
import ForecastEdit from "../components/forecasts/ForecastEdit.vue";
import ForecastSummary from "../components/forecasts/ForecastSummary.vue";

/**Project Imports */
import ProjectIndex from "../components/projects/ProjectIndex.vue";
import ProjectCreate from "../components/projects/ProjectCreate.vue";
import ProjectEdit from "../components/projects/ProjectEdit.vue";

/**Performance Imports */
import PerformanceIndex from "../components/performances/PerformanceIndex.vue";

/**Billboard Imports */
import BillboardIndex from "../components/billboards/BillboardIndex.vue";
import BillboardCreate from "../components/billboards/BillboardCreate.vue";
import BillboardTenure from "../components/billboards/BillboardTenure.vue";
import TempboardIndex from "../components/billboards/TempboardIndex.vue";
import TempboardCreate from "../components/billboards/TempboardCreate.vue";
import TempboardEdit from "../components/billboards/TempboardEdit.vue";



const routes = [
    /*                      
        test Routes                      
    */

    {
        //test route
        //     path: "/testpage",
        //     name: "TestQueryString",
        //     component: TestQueryString,
    },

    /*                      
        Contact Routes                      
    */

    {
        //No route
        path: "/",
        name: "home",
        component: ContactIndex,
    },

    {
        //ContactIndex
        path: "/contact/index",
        name: "contact_index",
        component: ContactIndex,
    },

    {
        //Contact Summary
        path: "/contact/summary",
        name: "contact_summary",
        component: ContactSummary,
    },

    {
        //ContactCreate
        path: "/contact/create",
        name: "contacts_create",
        component: ContactCreate,
    },

    {
        //ContactEdit
        path: "/contact/:id/edit",
        name: "contacts_edit",
        component: ContactEdit,
    },

    {
        //Contact Info
        path: "/contact/:id/info",
        name: "contacts_info",
        component: ContactInfo,
    },

    {
        //Contact History
        path: "/contact/:id/history",
        name: "contacts_history",
        component: ContactHistory,
    },

    {
        //Incharge Create
        path: "/incharge/:id/create",
        name: "incharge_create",
        component: InchargeCreate,
    },

    {
        //Incharge Edit
        path: "/incharge/:id/edit",
        name: "incharge_edit",
        component: InchargeEdit,
    },

    /*                                                  
            To Do Routes 
    */

    {
        //ToDo Index
        path: "/todo/index",
        name: "todo_index",
        component: ToDoIndex,
        // props: route => ({ selectedDate: route.query.q })
    },

    {
        //ToDo Insert
        path: "/todo/:id/insert",
        name: "todo_insert",
        component: ToDoInsert,
        props: true,
    },

    {
        //ToDo Create
        path: "/todo/create",
        name: "todo_create",
        component: ToDoCreate,
    },

    {
        //ToDo Edit
        path: "/todo/:id/edit",
        name: "todo_edit",
        component: ToDoEdit,
        props: true,
    },

    /*                                                  
            Follow Up Routes 
    */

    {
        //Follow Up Index
        path: "/followup/index",
        name: "followup_index",
        component: FollowUpIndex,
    },

    {
        //Follow Up Create
        path: "/followup/:id/:todo_id/create",
        name: "followup_create",
        component: FollowUpCreate,
        props: true,
    },
    /*                                                  
            Forecast Routes 
    */

    {
        //Forecast Index
        path: "/forecast/index",
        name: "forecast_index",
        component: ForecastIndex,
    },

    {
        //Forecast Create
        path: "/forecast/:id/create/",
        name: "forecast_create",
        component: ForecastCreate,
        props: true,
    },

    {
        //Forecast Edit
        path: "/forecast/:id/edit",
        name: "forecast_edit",
        component: ForecastEdit,
    },

    {
        //Forecast Summary
        path: "/forecast/summary",
        name: "forecast_summary",
        component: ForecastSummary,
    },

    /*                                                  
            Project Routes 
    */

    {
        //Project Index
        path: "/project/index",
        name: "project_index",
        component: ProjectIndex,
    },

    {
        //Project Create
        path: "/project/create",
        name: "project_create",
        component: ProjectCreate,
    },

    {
        //Project Edit
        path: "/project/:id/edit",
        name: "project_edit",
        component: ProjectEdit,
    },

    /*                                                  
            Perfomance Routes 
    */

    {
        //Performance Index
        path: "/performance/index",
        name: "performance_index",
        component: PerformanceIndex,
    },

    /*                                                  
            Billboard Routes 
    */

    { //Billboard Index
        path: "/billboard/index",
        name: "billboard_index",
        component: BillboardIndex,
    },

    {//Billboard Create
        path: "/billboard/create",
        name: "billboard_create",
        component: BillboardCreate,
    },

    {//Billboard Tenure
        path: "/billboard/:id/tenure",
        name: "billboard_tenure",
        component: BillboardTenure,
    },

    { //Tempboard Index
        path: "/tempboard/index",
        name: "tempboard_index",
        component: TempboardIndex,
    },

    { //Tempboard Create
        path: "/tempboard/create",
        name: "tempboard_create",
        component: TempboardCreate,
    },

    { //Tempboard Edit
        path: "/tempboard/:id/edit",
        name: "tempboard_edit",
        component: TempboardEdit,
    },

    /*                                                  
            Admin Routes 
    */

    {   //Admin Index
        path: "/admin/data",
        name: "admin_data",
        component: AdminData,
    },
    {   //Admin Management
        path: "/admin/user/management",
        name: "admin_userManagement",
        component: AdminUserManage,
    },
    {   //Admin Access
        path: "/admin/user/access",
        name: "admin_userAccess",
        component: AdminUserAccess,
    },
];

export default createRouter({
    history: createWebHistory(),
    routes,
});
