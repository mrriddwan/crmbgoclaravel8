<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SupervisorController;
use App\Http\Controllers\Admin\UserCategoryBenchmarkController;
use App\Http\Controllers\Admin\UserCategoryController;
use App\Http\Controllers\Api\Billboard\BillboardController;
use App\Http\Controllers\Api\Billboard\BillboardTenureController;
use App\Http\Controllers\Api\Billboard\TempboardController;
use App\Http\Controllers\Api\Tracking\BluedaleDivisionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Contact\ContactCategoryController;
use App\Http\Controllers\Api\Contact\ContactController;
use App\Http\Controllers\Api\Contact\ContactStatusController;
use App\Http\Controllers\Api\Contact\ContactTypeController;
use App\Http\Controllers\Api\Contact\ContactInchargeController;
use App\Http\Controllers\Api\Contact\ContactIndustryController;
use App\Http\Controllers\Api\FollowUp\ActionController;
use App\Http\Controllers\Api\FollowUp\FollowUpController;
use App\Http\Controllers\Api\Forecast\ForecastController;
use App\Http\Controllers\Api\Forecast\ForecastProductController;
use App\Http\Controllers\Api\Forecast\ForecastResultController;
use App\Http\Controllers\Api\Forecast\ForecastTypeController;
use App\Http\Controllers\Api\Performance\PerformanceController;
use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Api\ToDo\TaskController;
use App\Http\Controllers\Api\ToDo\ToDoController;
use App\Http\Controllers\Api\ToDo\ToDoSourceController;
use App\Http\Controllers\Api\Tracking\TrackingGeneralController;
use App\Http\Controllers\Api\Tracking\TrackingTGuideController;
use App\Http\Controllers\Api\Tracking\WIPGeneralController;
use App\Http\Controllers\Api\Tracking\WIPTGuideController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*Admin API*/

/*Admin Database Add/Delete API*/

// Route::middleware('auth')->group(function () {
    Route::post('/admin/create/contact/category', [AdminController::class, 'createContactCategory'])->name('contactCategory:create');
    Route::put('/admin/update/contact/category/{category}', [AdminController::class, 'updateContactCategory'])->name('contactCategory:update');

    Route::post('/admin/create/contact/status', [AdminController::class, 'createContactStatus'])->name('contactStatus:create');
    Route::put('/admin/update/contact/status/{status}', [AdminController::class, 'updateContactStatus'])->name('contactStatus:update');

    Route::post('/admin/create/contact/type', [AdminController::class, 'createContactType'])->name('contactType:create');
    Route::put('/admin/update/contact/type/{type}', [AdminController::class, 'updateContactType'])->name('contactType:update');

    Route::post('/admin/create/contact/industry', [AdminController::class, 'createContactIndustry'])->name('contactIndustry:create');
    Route::put('/admin/update/contact/industry/{industry}', [AdminController::class, 'updateContactIndustry'])->name('contactIndustry:update');

    Route::post('/admin/create/todo/task', [AdminController::class, 'createToDoTask'])->name('todoTask:create');
    Route::put('/admin/update/todo/task/{task}', [AdminController::class, 'updateToDoTask'])->name('todoTask:update');

    Route::post('/admin/create/todo/action', [AdminController::class, 'createToDoAction'])->name('todoAction:create');
    Route::put('/admin/update/todo/action/{action}', [AdminController::class, 'updateToDoAction'])->name('todoTask:update');

    Route::post('/admin/create/forecast/type', [AdminController::class, 'createForecastType'])->name('forecastType:create');
    Route::put('/admin/update/forecast/type/{type}', [AdminController::class, 'updateForecastType'])->name('forecastType:update');

    Route::post('/admin/create/forecast/product', [AdminController::class, 'createForecastProduct'])->name('forecastProduct:create');
    Route::put('/admin/update/forecast/product/{product}', [AdminController::class, 'updateForecastProduct'])->name('forecastProduct:update');

    Route::post('/admin/create/forecast/result', [AdminController::class, 'createForecastResult'])->name('forecastResult:create');
    Route::put('/admin/update/forecast/result/{result}', [AdminController::class, 'updateForecastResult'])->name('forecastResult:update');

    Route::post('/admin/create/text_color', [AdminController::class, 'createTextColor'])->name('textColor:create');
    Route::put('/admin/update/text_color/{textColor}', [AdminController::class, 'updateTextColor'])->name('textColor:update');

    Route::delete('/admin/delete/contact/category/{category}', [AdminController::class, 'deleteContactCategory'])->name('contactCategory:delete');
    Route::delete('/admin/delete/contact/status/{status}', [AdminController::class, 'deleteContactStatus'])->name('contactStatus:delete');
    Route::delete('/admin/delete/contact/type/{type}', [AdminController::class, 'deleteContactType'])->name('contactType:delete');
    Route::delete('/admin/delete/contact/industry/{industry}', [AdminController::class, 'deleteContactIndustry'])->name('contactIndustry:delete');
    Route::delete('/admin/delete/todo/task/{task}', [AdminController::class, 'deleteToDoTask'])->name('todoTask:delete');
    Route::delete('/admin/delete/todo/action/{action}', [AdminController::class, 'deleteToDoAction'])->name('todoAction:delete');
    Route::delete('/admin/delete/forecast/type/{type}', [AdminController::class, 'deleteForecastType'])->name('forecastType:delete');
    Route::delete('/admin/delete/forecast/product/{product}', [AdminController::class, 'deleteForecastProduct'])->name('forecastProduct:delete');
    Route::delete('/admin/delete/forecast/result/{result}', [AdminController::class, 'deleteForecastResult'])->name('forecastResult:delete');
    Route::delete('/admin/delete/text_color/{textColor}', [AdminController::class, 'deleteTextColor'])->name('textColor:delete');

    Route::get('/admin/users/info/{user}', [AdminController::class, 'user_info'])->name('user:info');
    Route::post('admin/users/create', [AdminController::class, 'user_create'])->name('user:create');
    Route::put('/admin/users/update/{user}', [AdminController::class, 'user_update'])->name('user:update');
    Route::put('/admin/users/remove/category/{user}', [AdminController::class, 'user_cat_remove'])->name('user_cat:remove');

    /*Admin User Management API*/
    Route::get('/admin/users/category/index', [UserCategoryController::class, 'index'])->name('user_category:index');
    Route::get('/admin/users/category/info/{category}', [UserCategoryController::class, 'info'])->name('user_category:info');
    Route::get('/admin/users/category/user_list', [UserCategoryController::class, 'user_list'])->name('user_category:user_list');
    Route::get('/admin/users/category/benchmark', [UserCategoryController::class, 'benchmark'])->name('user_category:benchmark');
    Route::post('/admin/users/category/create', [UserCategoryController::class, 'create'])->name('user_category:create');
    Route::put('/admin/users/category/update/{category}', [UserCategoryController::class, 'update'])->name('user_category:update');
    Route::delete('/admin/users/category/delete/{category}', [UserCategoryController::class, 'delete'])->name('user_category:delete');

    Route::post('/admin/benchmarks/create', [UserCategoryBenchmarkController::class, 'create'])->name('category_benchmark:create');
    Route::delete('/admin/benchmarks/delete/{benchmark}', [UserCategoryBenchmarkController::class, 'delete'])->name('category_benchmark:delete');
    Route::get('/admin/benchmarks/category/{benchmark}', [UserCategoryBenchmarkController::class, 'info'])->name('category_benchmark:info');
    Route::put('/admin/benchmarks/target/update/{benchmark}', [UserCategoryBenchmarkController::class, 'update'])->name('category_benchmark:update');

    Route::get('/admin/supervisors/index', [SupervisorController::class, 'index'])->name('supervisor:index');
    Route::get('/admin/supervisors/users/{supervisor}', [SupervisorController::class, 'info'])->name('supervisor:info');
    Route::post('/admin/supervisors/create', [SupervisorController::class, 'create'])->name('supervisor:create');
    Route::delete('/admin/supervisors/delete/{supervisor}', [SupervisorController::class, 'delete'])->name('supervisor:delete');
    Route::delete('/admin/supervisors/users/remove/{supervisor}', [SupervisorController::class, 'user_remove'])->name('supervisor:user_remove');
    Route::post('/admin/supervisors/users/add', [SupervisorController::class, 'user_add'])->name('supervisor:user_add');
    Route::get('/admin/checksupervisor', [AdminController::class, 'check_supervisor'])->name('admin:check_supervisor');

    Route::get('/admin/roles/index', [RoleController::class, 'index'])->name('role:index');
    Route::post('/admin/roles/create', [RoleController::class, 'role_create'])->name('role:create');
    Route::put('/admin/roles/update/{role}', [RoleController::class, 'role_update'])->name('role:update');
    Route::delete('/admin/roles/delete/{role}', [RoleController::class, 'role_delete'])->name('role:delete');
    Route::get('/admin/roles/info/{role}', [RoleController::class, 'info'])->name('role:info');
    Route::get('/admin/roles/permissions', [RoleController::class, 'role_permissions'])->name('role:permissions');
    Route::post('/admin/roles/add/permission/{role}', [RoleController::class, 'add_permission'])->name('role:add_permission');
    // Route::delete('/admin/roles/remove/permission/{role}', [RoleController::class, 'remove_permission'])->name('role:remove_permission');
    Route::post('/admin/roles/remove/permission/{role}', [RoleController::class, 'remove_permission'])->name('role:remove_permission');

    Route::get('/admin/permissions/index', [PermissionController::class, 'index'])->name('permission:index');
    Route::post('admin/permissions/create', [PermissionController::class, 'permission_create'])->name('permission:create');
    Route::delete('/admin/permissions/delete/{permission}', [PermissionController::class, 'permission_delete'])->name('permission:delete');
    Route::put('admin/permissions/update/{permission}', [PermissionController::class, 'permission_update'])->name('permission:update');
    Route::get('/admin/permissions/info/{permission}', [PermissionController::class, 'info'])->name('permission:info');

    Route::get('/admin/users/role_permissions', [AdminController::class, 'user_role_permissions'])->name('admin:user_role_permissions');
    Route::get('/admin/users/role_permissions/{user_id}', [AdminController::class, 'user_role_permissions_info'])->name('admin:user_role_permissions_info');
    Route::put('/admin/roles/user/update/{user}', [AdminController::class, 'user_role_update'])->name('user:role_update');
    Route::post('/admin/roles/user/update/permission/{user}', [AdminController::class, 'user_permission_update'])->name('user:direct_permission_update');
    Route::post('/admin/users/remove/permission/{user}', [AdminController::class, 'user_permission_remove'])->name('user:direct_permission_remove');

    Route::get('/admin/module_export', [AdminController::class, 'module_export'])->name('admin:module_export');
    Route::get('/performance/target/{user}', [PerformanceController::class, 'target'])->name('performance:target');
    Route::put('/performance/target/update', [PerformanceController::class, 'target_update'])->name('performance:target_update');
    Route::get('/admin/announcement_reminder', [AdminController::class, 'announcement_reminder'])->name('admin:announcement_reminder');
    Route::post('/admin/announcement_reminder/create', [AdminController::class, 'message_create'])->name('admin:message_create');
    Route::delete('/admin/announcement_reminder/delete/{announcement}', [AdminController::class, 'message_delete'])->name('admin:message_delete');
    Route::get('/admin/announcement_reminder/{announcement_id}', [AdminController::class, 'announcement_reminder_info'])->name('admin:announcement_reminder');
    Route::put('/admin/announcement_reminder/update/{announcement}', [AdminController::class, 'message_update'])->name('admin:message_update');
// });


/*Contact API*/

// Route::middleware('auth')->group(function () {
// });

Route::get('/contacts/index', [ContactController::class, 'index'])->name('contact:index');
Route::get('/contacts/list', [ContactController::class, 'list'])->name('contact:list');
Route::post('/contacts/store', [ContactController::class, 'store'])->name('contact:store');
Route::get('/contacts/show/{contact}', [ContactController::class, 'show'])->name('contact:show');
Route::put('/contacts/update/{contact}', [ContactController::class, 'update'])->name('contact:update');
Route::delete('/contacts/delete/{contact}', [ContactController::class, 'delete'])->name('contact:delete');
Route::get('/contacts/info/{contact}', [ContactController::class, 'info'])->name('contact:info');
Route::get('/contacts/test', [ContactController::class, 'test'])->name('contact:test');
Route::get('/contacts/export/{contact}', [ContactController::class, 'export'])->name('contact:export');
Route::get('/contacts/all', [ContactController::class, 'selectAll'])->name('contact:selectAll');
Route::get('/contacts/exportSummary', [ContactController::class, 'exportSummary'])->name('contact:exportSummary');
Route::get('/contacts/todo', [ContactController::class, 'todo'])->name('contact:todo');
Route::get('/contacts/history/{contact}', [ContactController::class, 'history'])->name('contact:history');
Route::get('/contacts/getuserid', [ContactController::class, 'getuserid'])->name('contact:getuserid');
Route::post('/contacts/import', [ContactController::class, 'import'])->name('contact:import');
Route::get('/contacts/contact_check_result', [ContactController::class, 'contact_check_result'])->name('contact:contact_check_result');

Route::get('/contacts/summary_action', [ContactController::class, 'summary_action'])->name('contact:summary_action');
Route::get('/contacts/summary_todo', [ContactController::class, 'summary_todo'])->name('contact:summary_todo');
Route::get('/contacts/remark/{contact}', [ContactController::class, 'remark'])->name('contact:remark');
Route::get('/followups/remark/{followup}', [FollowUpController::class, 'remark'])->name('followup:remark');
Route::get('/todos/remark/{todo}', [ToDoController::class, 'remark'])->name('todo:remark');

Route::get('/tempboards/remark/{tempboard}', [TempboardController::class, 'remark'])->name('tempboard:remark');


/*Sub-Contact API*/
Route::get('/contacts/category/index', [ContactCategoryController::class, 'index'])->name('category:index');
Route::get('/contacts/category/info/{category}', [ContactCategoryController::class, 'info'])->name('category:info');

Route::get('/contacts/type/index', [ContactTypeController::class, 'index'])->name('type:index');
Route::get('/contacts/type/info/{type}', [ContactTypeController::class, 'info'])->name('type:info');

Route::get('/contacts/status/index', [ContactStatusController::class, 'index'])->name('status:info');
Route::get('/contacts/status/info/{status}', [ContactStatusController::class, 'info'])->name('status:info');

Route::get('/contacts/industry/index', [ContactIndustryController::class, 'index'])->name('industry:index');
Route::get('/contacts/industry/info/{industry}', [ContactIndustryController::class, 'info'])->name('industry:info');


Route::get('/users/index', [UserController::class, 'index'])->name('user:index');
Route::get('/users/users_list', [UserController::class, 'users_list'])->name('user:users_list');
Route::get('/users/manage_list', [UserController::class, 'manage_list'])->name('user:manage_list');
Route::get('/users/action', [UserController::class, 'action'])->name('user:action');
Route::get('/users/performance', [UserController::class, 'performance'])->name('user:performance');
Route::post('/users/check_subordinate', [UserController::class, 'check_subordinate'])->name('user:check_subordinate');
Route::get('/users/home', [UserController::class, 'user_home'])->name('user:home');

/*Incharge API*/
Route::post('/incharges/store', [ContactInchargeController::class, 'store'])->name('incharge:store');
Route::get('/incharges/index', [ContactInchargeController::class, 'index'])->name('incharge:index');
Route::get('/incharges/show/{incharge}', [ContactInchargeController::class, 'show'])->name('incharge:show');
Route::put('/incharges/update/{incharge}', [ContactInchargeController::class, 'update'])->name('incharge:update');
Route::delete('/incharges/delete/{incharge}', [ContactInchargeController::class, 'delete'])->name('incharge:delete');
Route::get('/incharges/info/{incharge}', [ContactInchargeController::class, 'info'])->name('incharge:info');

/*To Do API*/
Route::get('/todos/index', [ToDoController::class, 'index'])->name('todo:index');
Route::post('/todos/insert/{todo}', [ToDoController::class, 'insert'])->name('todo:insert');
Route::post('/todos/store', [ToDoController::class, 'store'])->name('todo:store');
Route::get('/todos/show/{todo}', [ToDoController::class, 'show'])->name('todo:show');
Route::put('/todos/update/{todo}', [ToDoController::class, 'update'])->name('todo:update');
Route::put('/todos/action/{todo}', [ToDoController::class, 'action'])->name('todo:action');
Route::delete('/todos/delete/{todo}', [ToDoController::class, 'delete'])->name('todo:delete');
Route::get('/todos/new/{todo}', [ToDoController::class, 'new'])->name('todo:new');
Route::get('/todos/info/{todo}', [ToDoController::class, 'info'])->name('todo:info');
Route::get('/todos/export/{todo}', [ToDoController::class, 'export'])->name('todo:export');
Route::get('/todos/all', [ToDoController::class, 'selectAll'])->name('todo:selectAll');
Route::get('/todos/test_api', [ToDoController::class, 'test_api'])->name('todo:test_api');

/*Sub-To Do API*/
Route::get('/tasks/index', [TaskController::class, 'index'])->name('task:index');
Route::get('/tasks/info/{task}', [TaskController::class, 'info'])->name('task:info');

Route::get('/actions/index', [ActionController::class, 'index'])->name('action:index');
Route::get('/actions/performance', [ActionController::class, 'performance'])->name('action:index');
Route::get('/actions/info/{action}', [ActionController::class, 'info'])->name('action:info');

Route::get('/sources/index', [ToDoSourceController::class, 'index'])->name('source:index');
Route::get('/text_colors/index', [ToDoController::class, 'colors'])->name('source:colors');
Route::get('/text_colors/info/{color}', [ToDoController::class, 'color_info'])->name('source:colors');

/*Follow Up API*/
Route::get('/followups/index', [FollowUpController::class, 'index'])->name('followup:index');
Route::get('/followups/index/monthrange', [FollowUpController::class, 'monthrange'])->name('followup:monthrange');
Route::get('/followups/index/daterange', [FollowUpController::class, 'daterange'])->name('followup:daterange');
Route::post('/followups/store', [FollowUpController::class, 'store'])->name('followup:store');
Route::delete('/followups/delete/{followup}', [FollowUpController::class, 'delete'])->name('followup:delete');
Route::get('/followups/export/{followup}', [FollowUpController::class, 'export'])->name('followup:export');
Route::get('/followups/all', [FollowUpController::class, 'selectAll'])->name('followup:selectAll');

/*Forecast API*/
Route::get('/forecasts/index', [ForecastController::class, 'index'])->name('forecast:index');
// Route::get('/forecasts/list', [ForecastController::class, 'list'])->name('forecast:list');
Route::post('/forecasts/store', [ForecastController::class, 'store'])->name('forecast:store');
Route::get('/forecasts/show/{forecast}', [ForecastController::class, 'show'])->name('forecast:show');
Route::put('/forecasts/update/{forecast}', [ForecastController::class, 'update'])->name('forecast:update');
Route::delete('/forecasts/delete/{forecast}', [ForecastController::class, 'delete'])->name('forecast:delete');
Route::get('/forecasts/info/{forecast}', [ForecastController::class, 'info'])->name('forecast:info');
Route::put('/forecasts/resultSelected/{forecast}', [ForecastController::class, 'resultSelected'])->name('forecast:resultSelected');
Route::get('/forecasts/export/{forecast}', [ForecastController::class, 'export'])->name('forecast:export');
Route::get('/forecasts/all', [ForecastController::class, 'selectAll'])->name('forecast:selectAll');
Route::get('/forecasts/summary', [ForecastController::class, 'summary'])->name('forecast:summary');
Route::get('/forecasts/exportSummary', [ForecastController::class, 'exportSummary'])->name('forecast:exportSummary');
Route::get('/forecasts/summary2', [ForecastController::class, 'summary2'])->name('forecast:summary2');

/*Sub-Forecast API*/
Route::get('/forecasts/product/index', [ForecastProductController::class, 'index'])->name('forecastproduct:index');
Route::get('/forecasts/product/info/{product}', [ForecastProductController::class, 'info'])->name('forecastproduct:info');

Route::get('/forecasts/type/index', [ForecastTypeController::class, 'index'])->name('forecasttype:index');
Route::get('/forecasts/type/info/{type}', [ForecastTypeController::class, 'info'])->name('forecasttype:info');

Route::get('/forecasts/result/index', [ForecastResultController::class, 'index'])->name('forecastresult:index');
Route::get('/forecasts/result/list', [ForecastResultController::class, 'list'])->name('forecastresult:list');
Route::get('/forecasts/result/info/{result}', [ForecastResultController::class, 'info'])->name('forecastresult:info');
/*Projects API*/
Route::get('/projects/index', [ProjectController::class, 'index'])->name('project:index');
Route::post('/projects/store', [ProjectController::class, 'store'])->name('project:store');
Route::get('/projects/show/{project}', [ProjectController::class, 'show'])->name('project:show');
Route::put('/projects/update/{project}', [ProjectController::class, 'update'])->name('project:update');
Route::delete('/projects/delete/{project}', [ProjectController::class, 'delete'])->name('project:delete');
Route::get('/projects/remark/{project}', [ProjectController::class, 'remark'])->name('project:remark');

/*Billboard/Tempboard API*/
Route::get('/billboards/index', [BillboardController::class, 'index'])->name('billboard:index');
Route::get('/billboards/tenure', [BillboardController::class, 'tenure'])->name('billboard:tenure');
Route::post('/billboards/store', [BillboardController::class, 'store'])->name('billboard:store');
Route::get('/billboards/show/{billboard}', [BillboardController::class, 'show'])->name('billboard:show');
Route::get('/billboards/info/{billboard}', [BillboardController::class, 'info'])->name('billboard:info');
Route::put('/billboards/update/{billboard}', [BillboardController::class, 'update'])->name('billboard:update');
Route::delete('/billboards/delete/{billboard}', [BillboardController::class, 'delete'])->name('billboard:delete');

Route::get('/tempboards/index', [TempboardController::class, 'index'])->name('tempboard:index');
Route::post('/tempboards/store', [TempboardController::class, 'store'])->name('tempboard:store');
Route::get('/tempboards/info/{tempboard}', [TempboardController::class, 'info'])->name('tempboard:info');
Route::put('/tempboards/update/{tempboard}', [TempboardController::class, 'update'])->name('tempboard:update');
Route::delete('/tempboards/delete/{tempboard}', [TempboardController::class, 'delete'])->name('tempboard:delete');

Route::post('/billboards/tenure/store', [BillboardTenureController::class, 'store'])->name('tenure:store');
Route::delete('/billboards/tenure/delete/{tenure}', [BillboardTenureController::class, 'delete'])->name('tenure:delete');

/*Tracking & WIP Generals API*/
Route::get('/trackings/general/index', [TrackingGeneralController::class, 'index'])->name('tracking_general:index');
Route::post('/trackings/general/store', [TrackingGeneralController::class, 'store'])->name('tracking_general:store');
Route::get('/trackings/general/show/{general}', [TrackingGeneralController::class, 'show'])->name('tracking_general:show');
Route::put('/trackings/general/update/{general}', [TrackingGeneralController::class, 'update'])->name('tracking_general:update');
Route::delete('/trackings/general/delete/{tracking_general}', [TrackingGeneralController::class, 'delete'])->name('tracking_general:delete');
Route::get('/trackings/division/index', [BluedaleDivisionController::class, 'index'])->name('tracking_general:index');

Route::get('/trackings/wip/general/show/{wip_general}', [WIPGeneralController::class, 'show'])->name('wip_general:show');
Route::put('/trackings/wip/general/update/{wip_general}', [WIPGeneralController::class, 'update'])->name('tracking_general:update');
Route::delete('/trackings/wip/general/delete/{wip_general}', [WIPGeneralController::class, 'delete'])->name('tracking_general:delete');

/*Tracking & WIP Travel Guides API*/
Route::get('/trackings/travel_guide/index', [TrackingTGuideController::class, 'index'])->name('tracking_travel_guide:index');
Route::post('/trackings/travel_guide/store', [TrackingTGuideController::class, 'store'])->name('tracking_travel_guide:store');
Route::get('/trackings/travel_guide/show/{travel_guide}', [TrackingTGuideController::class, 'show'])->name('tracking_travel_guide:show');
Route::put('/trackings/travel_guide/update/{travel_guide}', [TrackingTGuideController::class, 'update'])->name('tracking_travel_guide:update');
Route::delete('/trackings/travel_guide/delete/{travel_guide}', [TrackingTGuideController::class, 'delete'])->name('tracking_travel_guide:delete');

Route::post('/trackings/wip/travel_guide/store', [WIPTGuideController::class, 'wip_tg_store'])->name('wip_travel_guide:wip_tg_store');
Route::put('/trackings/wip/travel_guide/update', [WIPTGuideController::class, 'wip_tg_update'])->name('wip_travel_guide:wip_tg_update');
Route::delete('/trackings/wip/travel_guide/delete/{wip_travel_guide}', [WIPTGuideController::class, 'delete'])->name('wip_travel_guide:delete');
