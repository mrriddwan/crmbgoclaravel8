<?php

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
use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Api\ToDo\TaskController;
use App\Http\Controllers\Api\ToDo\ToDoController;
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

/*Contact API*/
Route::get('/contacts/index', [ContactController::class, 'index'])->name('contact:index');
Route::get('/contacts/list', [ContactController::class, 'list'])->name('contact:list');
Route::post('/contacts/store', [ContactController::class, 'store'])->name('contact:store');
Route::get('/contacts/show/{contact}', [ContactController::class, 'show'])->name('contact:show');
Route::put('/contacts/update/{contact}', [ContactController::class, 'update'])->name('contact:update');
Route::delete('/contacts/delete/{contact}', [ContactController::class, 'delete'])->name('contact:delete');
Route::get('/contacts/info/{contact}', [ContactController::class, 'info'])->name('contact:info');
Route::get('/contacts/summary', [ContactController::class, 'summary'])->name('contact:summary');
Route::get('/contacts/test', [ContactController::class, 'test'])->name('contact:test');

/*Sub-Contact API*/
Route::get('/contactcategory/index', [ContactCategoryController::class, 'index'])->name('category:index');
Route::get('/contacttype/index', [ContactTypeController::class, 'index'])->name('type:index');
Route::get('/contactstatus/index', [ContactStatusController::class, 'index'])->name('status:index');
Route::get('/contactindustry/index', [ContactIndustryController::class, 'index'])->name('industry:index');
// Route::get('/contactstatus/dropdown', [ContactStatusController::class, 'dropdown'])->name('status:dropdown');
Route::get('/users/index', [UserController::class, 'index'])->name('user:index');


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

/*Sub-To Do API*/
Route::get('/tasks/index', [TaskController::class, 'index'])->name('task:index');
Route::get('/actions/index', [ActionController::class, 'index'])->name('action:index');

/*Follow Up API*/
Route::get('/followups/index', [FollowUpController::class, 'index'])->name('followup:index');
Route::post('/followups/store', [FollowUpController::class, 'store'])->name('followup:store');
Route::delete('/followups/delete/{followup}', [FollowUpController::class, 'delete'])->name('followup:delete');

/*Forecast API*/
Route::get('/forecasts/index', [ForecastController::class, 'index'])->name('forecast:index');
// Route::get('/forecasts/list', [ForecastController::class, 'list'])->name('forecast:list');
Route::post('/forecasts/store', [ForecastController::class, 'store'])->name('forecast:store');
Route::get('/forecasts/show/{forecast}', [ForecastController::class, 'show'])->name('forecast:show');
Route::put('/forecasts/update/{forecast}', [ForecastController::class, 'update'])->name('forecast:update');
Route::delete('/forecasts/delete/{forecast}', [ForecastController::class, 'delete'])->name('forecast:delete');
Route::get('/forecasts/info/{forecast}', [ForecastController::class, 'info'])->name('forecast:info');
Route::put('/forecasts/resultSelected/{forecast}', [ForecastController::class, 'resultSelected'])->name('forecast:resultSelected');

/*Sub-Forecast API*/
Route::get('/forecastproducts/index', [ForecastProductController::class, 'index'])->name('forecastproduct:index');
Route::get('/forecastresults/index', [ForecastResultController::class, 'index'])->name('forecastresult:index');

/*Forecast API*/
Route::get('/projects/index', [ProjectController::class, 'index'])->name('project:index');
Route::post('/projects/store', [ProjectController::class, 'store'])->name('project:store');
Route::get('/projects/show/{project}', [ProjectController::class, 'show'])->name('project:show');
Route::put('/projects/update/{project}', [ProjectController::class, 'update'])->name('project:update');

