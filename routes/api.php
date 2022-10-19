<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SupervisorController;
use App\Http\Controllers\Admin\UserCategoryBenchmarkController;
use App\Http\Controllers\Admin\UserCategoryController;
use App\Http\Controllers\Api\Billboard\BillboardController;
use App\Http\Controllers\Api\Billboard\BillboardTenureController;
use App\Http\Controllers\Api\Billboard\TempboardController;
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
use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Api\ToDo\TaskController;
use App\Http\Controllers\Api\ToDo\ToDoController;
use App\Http\Controllers\Api\ToDo\ToDoSourceController;
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
Route::middleware('auth')->group(function () {
    Route::post('/admin/create/contact/category', [AdminController::class, 'createContactCategory'])->name('contactCategory:create');
    Route::post('/admin/create/contact/status', [AdminController::class, 'createContactStatus'])->name('contactStatus:create');
    Route::post('/admin/create/contact/type', [AdminController::class, 'createContactType'])->name('contactType:create');
    Route::post('/admin/create/contact/industry', [AdminController::class, 'createContactIndustry'])->name('contactIndustry:create');
    Route::post('/admin/create/todo/task', [AdminController::class, 'createToDoTask'])->name('todoTask:create');
    Route::post('/admin/create/todo/action', [AdminController::class, 'createToDoAction'])->name('todoAction:create');
    Route::post('/admin/create/forecast/type', [AdminController::class, 'createForecastType'])->name('forecastType:create');
    Route::post('/admin/create/forecast/product', [AdminController::class, 'createForecastProduct'])->name('forecastProduct:create');

    Route::delete('/admin/delete/contact/category/{category}', [AdminController::class, 'deleteContactCategory'])->name('contactCategory:delete');
    Route::delete('/admin/delete/contact/status/{status}', [AdminController::class, 'deleteContactStatus'])->name('contactStatus:delete');
    Route::delete('/admin/delete/contact/type/{type}', [AdminController::class, 'deleteContactType'])->name('contactType:delete');
    Route::delete('/admin/delete/contact/industry/{industry}', [AdminController::class, 'deleteContactIndustry'])->name('contactIndustry:delete');
    Route::delete('/admin/delete/todo/task/{task}', [AdminController::class, 'deleteToDoTask'])->name('todoTask:delete');
    Route::delete('/admin/delete/todo/action/{action}', [AdminController::class, 'deleteToDoAction'])->name('todoAction:delete');
    Route::delete('/admin/delete/forecast/type/{type}', [AdminController::class, 'deleteForecastType'])->name('forecastType:delete');
    Route::delete('/admin/delete/forecast/product/{product}', [AdminController::class, 'deleteForecastProduct'])->name('forecastProduct:delete');

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
    Route::put('/admin/benchmarks/target/update/{benchmark}', [UserCategoryBenchmarkController::class, 'update_target'])->name('category_benchmark:update_target');

    Route::get('/admin/supervisors/index', [SupervisorController::class, 'index'])->name('supervisor:index');
    Route::get('/admin/supervisors/users/{supervisor}', [SupervisorController::class, 'info'])->name('supervisor:info');
    Route::post('/admin/supervisors/create', [SupervisorController::class, 'create'])->name('supervisor:create');
    Route::delete('/admin/supervisors/delete/{supervisor}', [SupervisorController::class, 'delete'])->name('supervisor:delete');
    Route::delete('/admin/supervisors/users/remove/{supervisor}', [SupervisorController::class, 'user_remove'])->name('supervisor:user_remove');
    Route::post('/admin/supervisors/users/add', [SupervisorController::class, 'user_add'])->name('supervisor:user_add');
});
/*Contact API*/

Route::middleware('auth')->group(function () {
    Route::get('/contacts/index', [ContactController::class, 'index'])->name('contact:index');
    Route::get('/contacts/list', [ContactController::class, 'list'])->name('contact:list');
    Route::post('/contacts/store', [ContactController::class, 'store'])->name('contact:store');
    Route::get('/contacts/show/{contact}', [ContactController::class, 'show'])->name('contact:show');
    Route::put('/contacts/update/{contact}', [ContactController::class, 'update'])->name('contact:update');
    Route::delete('/contacts/delete/{contact}', [ContactController::class, 'delete'])->name('contact:delete');
    Route::get('/contacts/info/{contact}', [ContactController::class, 'info'])->name('contact:info');
    Route::get('/contacts/summary', [ContactController::class, 'summary'])->name('contact:summary');
    Route::get('/contacts/test', [ContactController::class, 'test'])->name('contact:test');
    Route::get('/contacts/export/{contact}', [ContactController::class, 'export'])->name('contact:export');
    Route::get('/contacts/all', [ContactController::class, 'selectAll'])->name('contact:selectAll');
    Route::get('/contacts/exportSummary', [ContactController::class, 'exportSummary'])->name('contact:exportSummary');
    Route::get('/contacts/todo', [ContactController::class, 'todo'])->name('contact:todo');
    Route::get('/contacts/history/{contact}', [ContactController::class, 'history'])->name('contact:history');
    Route::get('/contacts/getuserid', [ContactController::class, 'getuserid'])->name('contact:getuserid');
});

// Route::get('/contacts/index', [ContactController::class, 'index'])->name('contact:index');
// Route::get('/contacts/list', [ContactController::class, 'list'])->name('contact:list');
// Route::post('/contacts/store', [ContactController::class, 'store'])->name('contact:store');
// Route::get('/contacts/show/{contact}', [ContactController::class, 'show'])->name('contact:show');
// Route::put('/contacts/update/{contact}', [ContactController::class, 'update'])->name('contact:update');
// Route::delete('/contacts/delete/{contact}', [ContactController::class, 'delete'])->name('contact:delete');
// Route::get('/contacts/info/{contact}', [ContactController::class, 'info'])->name('contact:info');
// Route::get('/contacts/summary', [ContactController::class, 'summary'])->name('contact:summary');
// Route::get('/contacts/test', [ContactController::class, 'test'])->name('contact:test');
// Route::get('/contacts/export/{contact}', [ContactController::class, 'export'])->name('contact:export');
// Route::get('/contacts/all', [ContactController::class, 'selectAll'])->name('contact:selectAll');
// Route::get('/contacts/exportSummary', [ContactController::class, 'exportSummary'])->name('contact:exportSummary');
// Route::get('/contacts/todo', [ContactController::class, 'todo'])->name('contact:todo');
// Route::get('/contacts/history/{contact}', [ContactController::class, 'history'])->name('contact:history');
// Route::get('/contacts/getuserid', [ContactController::class, 'getuserid'])->name('contact:getuserid');


/*Sub-Contact API*/
Route::get('/contacts/category/index', [ContactCategoryController::class, 'index'])->name('category:index');
Route::get('/contacts/type/index', [ContactTypeController::class, 'index'])->name('type:index');
Route::get('/contacts/status/index', [ContactStatusController::class, 'index'])->name('status:index');
Route::get('/contacts/industry/index', [ContactIndustryController::class, 'index'])->name('industry:index');
// Route::get('/contactstatus/dropdown', [ContactStatusController::class, 'dropdown'])->name('status:dropdown');

Route::get('/users/index', [UserController::class, 'index'])->name('user:index');
// Route::get('/users/action/{id}', [UserController::class, 'action'])->name('user:action');
Route::get('/users/action', [UserController::class, 'action'])->name('user:action');


/*Incharge API*/
Route::post('/incharges/store', [ContactInchargeController::class, 'store'])->name('incharge:store');
Route::get('/incharges/index', [ContactInchargeController::class, 'index'])->name('incharge:index');
Route::get('/incharges/show/{incharge}', [ContactInchargeController::class, 'show'])->name('incharge:show');
Route::put('/incharges/update/{incharge}', [ContactInchargeController::class, 'update'])->name('incharge:update');
Route::delete('/incharges/delete/{incharge}', [ContactInchargeController::class, 'delete'])->name('incharge:delete');
Route::get('/incharges/info/{incharge}', [ContactInchargeController::class, 'info'])->name('incharge:info');

/*To Do API*/
Route::get('/todos/index', [ToDoController::class, 'index'])->name('todo:index');
Route::get('/todos/index/monthrange', [ToDoController::class, 'monthrange'])->name('todo:monthrange');
Route::get('/todos/index/daterange', [ToDoController::class, 'daterange'])->name('todo:daterange');
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

/*Sub-To Do API*/
Route::get('/tasks/index', [TaskController::class, 'index'])->name('task:index');
Route::get('/actions/index', [ActionController::class, 'index'])->name('action:index');
Route::get('/sources/index', [ToDoSourceController::class, 'index'])->name('source:index');

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
Route::get('/forecasts/result/index', [ForecastResultController::class, 'index'])->name('forecastresult:index');
Route::get('/forecasts/type/index', [ForecastTypeController::class, 'index'])->name('forecasttype:index');

/*Forecast API*/
Route::get('/projects/index', [ProjectController::class, 'index'])->name('project:index');
Route::post('/projects/store', [ProjectController::class, 'store'])->name('project:store');
Route::get('/projects/show/{project}', [ProjectController::class, 'show'])->name('project:show');
Route::put('/projects/update/{project}', [ProjectController::class, 'update'])->name('project:update');

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
