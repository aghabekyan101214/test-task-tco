<?php
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

Auth::routes();
Route::get("/", function () {
    return redirect("/dashboard");
});
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::resource('/', 'DashboardController');
    Route::resource('tasks', 'TaskController');
    Route::get('tasks/change-status/{task}', 'TaskController@changeStatus');
    Route::get('statistics', 'StatisticsController@index');
});
