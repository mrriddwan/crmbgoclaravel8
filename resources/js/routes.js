import { createRouter, createWebHistory } from "vue-router";
// import TestQueryString from "../components/utils/TestQueryString.vue";
import NoAuthorizationPage from "../components/utils/NoAuthorizationPage.vue";

/**Admin Imports */
import AdminData from "../components/admins/AdminData.vue";
import AdminUserAccess from "../components/admins/AdminUserAccess.vue";
import AdminUserManage from "../components/admins/AdminUserManage.vue";
import AdminExport from "../components/admins/AdminExport.vue";

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

/**Tracking General Imports */
import TrackingGeneralIndex from "../components/trackings/TrackingGeneralIndex.vue";
import MasterGeneralCreate from "../components/trackings/MasterGeneralCreate.vue";
import MasterGeneralEdit from "../components/trackings/MasterGeneralEdit.vue";
import WIPGeneralEdit from "../components/trackings/WIPGeneralEdit.vue";

/**Tracking Travel Guide Imports */
import TrackingTravelGuideIndex from "../components/trackings/TrackingTravelGuideIndex.vue";
import MasterTravelGuideCreate from "../components/trackings/MasterTravelGuideCreate.vue";
import MasterTravelGuideEdit from "../components/trackings/MasterTravelGuideEdit.vue";

/**Tracking Travel Guide Imports */
import TutorialContacts from "../components/tutorials/TutorialContacts.vue";
import TutorialToDoFollowUps from "../components/tutorials/TutorialToDoFollowUps.vue";
import TutorialForecast from "../components/tutorials/TutorialForecast.vue";
import TutorialProject from "../components/tutorials/TutorialProject.vue";
import TutorialPerformance from "../components/tutorials/TutorialPerformance.vue";
import TutorialBBoardTBoard from "../components/tutorials/TutorialBBoardTBoard.vue";
import TutorialTracking from "../components/tutorials/TutorialTracking.vue";
import TutorialAdmin from "../components/tutorials/TutorialAdmin.vue";

/**Tracking Travel Guide Imports */
import AnnouncementIndex from "../components/admins/AnnouncementIndex.vue";
import AnnouncementEdit from "../components/admins/AnnouncementEdit.vue";

const role_permissions = JSON.parse(
    document.querySelector('meta[name="user_roles"]').getAttribute("content")
);

const direct_permissions = JSON.parse(
    document
        .querySelector('meta[name="user_permissions"]')
        .getAttribute("content")
);

function check() {
    // direct_permissions.forEach((user_direct_permission) => {
    //     console.log(user_direct_permission.name);
    // });
    console.log(role_permissions[0].name);
}

function checkUserPermission(permission_required) {
    if(role_permissions[0].name === "super-admin" || role_permissions[0].name === "admin"){
        return true;
    }

    let count = 0;
    
    role_permissions[0]["permissions"].forEach((user_permission) => {
        if (user_permission.name === permission_required) {
            return count++;
        }
    });
    direct_permissions.forEach((user_direct_permission) => {
        if (user_direct_permission.name === permission_required) {
            return count++;
        }
    });
    return count > 0 ? true : false;
}

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
        path: "",
        name: "no_route",
        component: AnnouncementIndex,
    },

    {
        //No route
        path: "/",
        name: "home",
        component: AnnouncementIndex,
    },

    {
        //403 Page
        path: "/not_authorized",
        name: "not_authorized_page",
        component: NoAuthorizationPage,
    },

    {
        //ContactIndex
        path: "/contact/index",
        name: "contact_index",
        component: ContactIndex,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view contact")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Contact Summary
        path: "/contact/summary",
        name: "contact_summary",
        component: ContactSummary,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view contact summary")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //ContactCreate
        path: "/contact/create",
        name: "contacts_create",
        component: ContactCreate,
        beforeEnter: (to, from, next) => {
            checkUserPermission("create contact")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //ContactEdit
        path: "/contact/:id/edit",
        name: "contacts_edit",
        component: ContactEdit,
        beforeEnter: (to, from, next) => {
            checkUserPermission("edit contact")
                ? next()
                : next("/not_authorized");
        },
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
        beforeEnter: (to, from, next) => {
            checkUserPermission("view todo")
                ? next()
                : next("/not_authorized");
        },
        // props: route => ({ selectedDate: route.query.q })
    },

    {
        //ToDo Insert
        path: "/todo/:id/insert",
        name: "todo_insert",
        component: ToDoInsert,
        props: true,
        beforeEnter: (to, from, next) => {
            checkUserPermission("insert todo")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //ToDo Create
        path: "/todo/create",
        name: "todo_create",
        component: ToDoCreate,
        beforeEnter: (to, from, next) => {
            checkUserPermission("create todo")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //ToDo Edit
        path: "/todo/:id/edit",
        name: "todo_edit",
        component: ToDoEdit,
        props: true,
        beforeEnter: (to, from, next) => {
            checkUserPermission("edit todo")
                ? next()
                : next("/not_authorized");
        },
    },

    /*                                                  
            Follow Up Routes 
    */

    {
        //Follow Up Index
        path: "/followup/index",
        name: "followup_index",
        component: FollowUpIndex,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view followup")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Follow Up Create
        path: "/followup/:id/:todo_id/create",
        name: "followup_create",
        component: FollowUpCreate,
        props: true,
        beforeEnter: (to, from, next) => {
            checkUserPermission("create followup")
                ? next()
                : next("/not_authorized");
        },
    },
    /*                                                  
            Forecast Routes 
    */

    {
        //Forecast Index
        path: "/forecast/index",
        name: "forecast_index",
        component: ForecastIndex,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view forecast")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Forecast Create
        path: "/forecast/:id/create/",
        name: "forecast_create",
        component: ForecastCreate,
        props: true,
        beforeEnter: (to, from, next) => {
            checkUserPermission("create forecast")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Forecast Edit
        path: "/forecast/:id/edit",
        name: "forecast_edit",
        component: ForecastEdit,
        beforeEnter: (to, from, next) => {
            checkUserPermission("edit forecast")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Forecast Summary
        path: "/forecast/summary",
        name: "forecast_summary",
        component: ForecastSummary,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view forecast summary")
                ? next()
                : next("/not_authorized");
        },
    },

    /*                                                  
            Project Routes 
    */

    {
        //Project Index
        path: "/project/index",
        name: "project_index",
        component: ProjectIndex,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view project")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Project Create
        path: "/project/create",
        name: "project_create",
        component: ProjectCreate,
        beforeEnter: (to, from, next) => {
            checkUserPermission("create project")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Project Edit
        path: "/project/:id/edit",
        name: "project_edit",
        component: ProjectEdit,
        beforeEnter: (to, from, next) => {
            checkUserPermission("edit project")
                ? next()
                : next("/not_authorized");
        },
    },

    /*                                                  
            Perfomance Routes 
    */

    {
        //Performance Index
        path: "/performance/index",
        name: "performance_index",
        component: PerformanceIndex,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view performance")
                ? next()
                : next("/not_authorized");
        },
    },

    /*                                                  
            Billboard Routes 
    */

    {
        //Billboard Index
        path: "/billboard/index",
        name: "billboard_index",
        component: BillboardIndex,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view billboard/tempboard")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Billboard Create
        path: "/billboard/create",
        name: "billboard_create",
        component: BillboardCreate,
        beforeEnter: (to, from, next) => {
            checkUserPermission("create billboard")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Billboard Tenure
        path: "/billboard/:id/tenure",
        name: "billboard_tenure",
        component: BillboardTenure,
    },

    {
        //Tempboard Index
        path: "/tempboard/index",
        name: "tempboard_index",
        component: TempboardIndex,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view billboard/tempboard")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Tempboard Create
        path: "/tempboard/create",
        name: "tempboard_create",
        component: TempboardCreate,
        beforeEnter: (to, from, next) => {
            checkUserPermission("create tempboard")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Tempboard Edit
        path: "/tempboard/:id/edit",
        name: "tempboard_edit",
        component: TempboardEdit,
        beforeEnter: (to, from, next) => {
            checkUserPermission("edit tempboard")
                ? next()
                : next("/not_authorized");
        },
    },

    /*                                                  
            Admin Routes 
    */

    {
        //Admin Index
        path: "/admin/data",
        name: "admin_data",
        component: AdminData,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view admin data")
                ? next()
                : next("/not_authorized");
        },
    },
    {
        //Admin Management
        path: "/admin/user/management",
        name: "admin_userManagement",
        component: AdminUserManage,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view admin user manage")
                ? next()
                : next("/not_authorized");
        },
    },
    {
        //Admin Access
        path: "/admin/user/access",
        name: "admin_userAccess",
        component: AdminUserAccess,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view admin user access")
                ? next()
                : next("/not_authorized");
        },
    },

    {
        //Admin Export
        path: "/admin/export",
        name: "admin_export",
        component: AdminExport,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view admin export import")
                ? next()
                : next("/not_authorized");
        },
    },

    /*                                                  
        Tracking (General) Routes 
    */

    {
        //Tracking General Index
        path: "/tracking/general/index",
        name: "tracking_general",
        component: TrackingGeneralIndex,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view tracking general")
                ? next()
                : next("/not_authorized");
        },
    },
    {
        //Tracking General Create
        path: "/tracking/general/create",
        name: "tracking_general_create",
        component: MasterGeneralCreate,
        beforeEnter: (to, from, next) => {
            checkUserPermission("create tracking general")
                ? next()
                : next("/not_authorized");
        },
    },
    {
        //Tracking General Edit
        path: "/tracking/general/:id/edit",
        name: "tracking_general_edit",
        component: MasterGeneralEdit,
        beforeEnter: (to, from, next) => {
            checkUserPermission("edit master general")
                ? next()
                : next("/not_authorized");
        },
    },
    {
        //WIP General Edit
        path: "/tracking/wip/:id/edit",
        name: "tracking_wip_edit",
        component: WIPGeneralEdit,
        beforeEnter: (to, from, next) => {
            checkUserPermission("edit wip general")
                ? next()
                : next("/not_authorized");
        },
    },

    /*                                                  
        Tracking (Travel Guide) Routes 
    */

    {
        //Tracking Travel Guide Index
        path: "/tracking/travel_guide/index",
        name: "tracking_travel_guide",
        component: TrackingTravelGuideIndex,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view tracking tguide")
                ? next()
                : next("/not_authorized");
        },
    },
    {
        //Tracking Travel Guide Create
        path: "/tracking/travel_guide/create",
        name: "tracking_travel_guide_create",
        component: MasterTravelGuideCreate,
        beforeEnter: (to, from, next) => {
            checkUserPermission("create tracking travelguide")
                ? next()
                : next("/not_authorized");
        },
    },
    {
        //Tracking Travel Guide Create
        path: "/tracking/travel_guide/:id/edit",
        name: "tracking_travel_guide_edit",
        component: MasterTravelGuideEdit,
        beforeEnter: (to, from, next) => {
            checkUserPermission("edit master travelguide")
                ? next()
                : next("/not_authorized");
        },
    },

    /*                                                  
        System Tutorial Routes 
    */

    {
        //Tutorial Contact
        path: "/tutorial/contact",
        name: "tutorial_contact",
        component: TutorialContacts,
    },
    {
        //Tutorial To Do & Follow Up
        path: "/tutorial/todo_followup",
        name: "tutorial_todo_followup",
        component: TutorialToDoFollowUps,
    },

    {
        //Tutorial Forecast
        path: "/tutorial/forecast",
        name: "tutorial_forecast",
        component: TutorialForecast,
    },

    {
        //Tutorial Forecast
        path: "/tutorial/project",
        name: "tutorial_project",
        component: TutorialProject,
    },

    {
        //Tutorial Forecast
        path: "/tutorial/performance",
        name: "tutorial_performance",
        component: TutorialPerformance,
    },

    {
        //Tutorial Forecast
        path: "/tutorial/billboard_tempboard",
        name: "tutorial_billboard_tempboard",
        component: TutorialBBoardTBoard,
    },

    {
        //Tutorial Forecast
        path: "/tutorial/tracking",
        name: "tutorial_tracking",
        component: TutorialTracking,
    },

    {
        //Tutorial Forecast
        path: "/tutorial/admin",
        name: "tutorial_admin",
        component: TutorialAdmin,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view tutorial admin")
                ? next()
                : next("/not_authorized");
        },
    },

    /*                                                  
        Announcement Routes 
    */

    {
        //Announcement Page
        path: "/announcement/index",
        name: "announcement_index",
        component: AnnouncementIndex,
        beforeEnter: check,
    },
    {
        //Announcement Edit Page
        path: "/announcement/edit",
        name: "announcement_edit",
        component: AnnouncementEdit,
        beforeEnter: (to, from, next) => {
            checkUserPermission("view admin announcement")
                ? next()
                : next("/not_authorized");
        },
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
