<?php

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

Route::get('/admin/index', function () {
    return view('admin');
})->middleware(['auth'])->name('admin');
