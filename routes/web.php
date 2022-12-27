<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Api\Contact\ContactController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//         return view('contact');
// });

// Auth::routes();
Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});

Route::get('', function () {
    return view('contact');
})->middleware(['auth'])->name('contact');


Route::get('/', function () {
    return view('contact');
})->middleware(['auth'])->name('contact');

Route::view('/{any}', 'contact')
    ->middleware(['auth'])
    ->where('any', '.*');

Route::get('', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/contact/index', function () {
    return view('contact');
})->middleware(['auth'])->name('contact');

Route::get('/contact/summary', function () {
    return view('forecastsummary');
})->middleware(['auth'])->name('contact-summary');

Route::get('/todo/index', function () {
    return view('todo');
})->middleware(['auth'])->name('todo');

Route::get('/followup/index', function () {
    return view('followup');
})->middleware(['auth'])->name('followup');

Route::get('/forecast/index', function () {
    return view('forecast');
})->middleware(['auth'])->name('forecast');

Route::get('/forecast/summary', function () {
    return view('forecastsummary');
})->middleware(['auth'])->name('forecast-summary');

Route::get('/project/index', function () {
    return view('project');
})->middleware(['auth'])->name('project');

Route::get('/performance/index', function () {
    return view('performance');
})->middleware(['auth'])->name('performance');

Route::get('/billboard/index', function () {
    return view('billboard');
})->middleware(['auth'])->name('billboard');

Route::get('/tempboard/index', function () {
    return view('tempboard');
})->middleware(['auth'])->name('tempboard');

Route::get('/tracking/general/index', function () {
    return view('tracking_general');
})->middleware(['auth'])->name('tracking-general');

Route::get('/tracking/travel_guide/index', function () {
    return view('tracking_tg');
})->middleware(['auth'])->name('tracking-travel_guide');

Route::get('/tutorial/contact', function () {
    return view('tutorial_contact');
})->middleware(['auth'])->name('tutorial-contact');

Route::get('/tutorial/todo_followup', function () {
    return view('tutorial_todo_followup');
})->middleware(['auth'])->name('tutorial-todo_followup');

Route::get('/admin/data', function () {
    return view('admin_data');
})->middleware(['auth'])->name('admin-data');

Route::get('/admin/user/management', function () {
    return view('admin_management');
})->middleware(['auth'])->name('admin-management');

Route::get('/admin/user/access', function () {
    return view('admin_access');
})->middleware(['auth'])->name('admin-access');

Route::get('/admin/export', function () {
    return view('admin_export');
})->middleware(['auth'])->name('admin-export');

Route::get('/announcement/index', function () {
    return view('announcement');
})->middleware(['auth'])->name('announcement-index');

Route::get('/announcement/edit', function () {
    return view('announcement_edit');
})->middleware(['auth'])->name('announcement-edit');