<?php

use Illuminate\Http\Request;

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

Route::post('/store_template', 'Api\ScheduleApiController@store_template'); 
Route::post('/load_template', 'Api\ScheduleApiController@load_template'); 
Route::post('/update_template', 'Api\ScheduleApiController@update_template'); 
Route::post('/delete_template', 'Api\ScheduleApiController@delete_template'); 
Route::post('/store_template_job_duty', 'Api\ScheduleApiController@store_template_job_duty'); 
Route::post('/load_template_job_duty', 'Api\ScheduleApiController@load_template_job_duty'); 
Route::post('/update_template_job_duty', 'Api\ScheduleApiController@update_template_job_duty'); 
Route::post('/store_time_table', 'Api\ScheduleApiController@store_time_table'); 



Route::post('/load_employee', 'Api\EmployeeApiController@load_employee'); 




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});




 




























































