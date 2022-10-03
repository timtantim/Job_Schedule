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

// Route::get('/', function () {
//     return view('layouts.app');
// });
Route::get('/template', function () {
    return view('template')->with('title', '樣板');
});
Route::get('/template_search', function () {
    return view('template_search')->with('title', '樣板');
});
Route::get('/template_man_work', function () {
    return view('template_man_work')->with('title', '人力預排');
});
Route::get('/template_man_work_search', function () {
    return view('template_man_work_search')->with('title', '人力預排');
});
Route::get('/template_create_time_table', function () {
    return view('template_create_time_table')->with('title', '建立工作班');
});

Route::get('/', function () {
    return view('welcome')->with('title', '首頁');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
