<?php

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

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::get('setskills/{id}', 'Api\SkillSetsContorller@show');
Route::post('setskills', 'Api\SkillSetsContorller@store');
Route::put('setskills/{id}', 'Api\SkillSetsContorller@update');
Route::delete('setskills/{id}', 'Api\SkillSetsContorller@destroy');
Route::get('setskills', 'Api\SkillSetsContorller@index');

Route::get('candidate/{id}', 'Api\CandidateController@show');
Route::post('candidate', 'Api\CandidateController@store');
Route::put('candidate/{id}', 'Api\CandidateController@update');
Route::delete('candidate/{id}', 'Api\CandidateController@destroy');
Route::get('candidate', 'Api\CandidateController@index');

Route::get('job/{id}', 'Api\JobController@show');
Route::post('job', 'Api\JobController@store');
Route::put('job/{id}', 'Api\JobController@update');
Route::delete('job/{id}', 'Api\JobController@destroy');
Route::get('job', 'Api\JobController@index');

Route::get('skill/{id}', 'Api\SkillsController@show');
Route::post('skill', 'Api\SkillsController@store');
Route::put('skill/{id}', 'Api\SkillsController@update');
Route::delete('skill/{id}', 'Api\SkillsController@destroy');
Route::get('skill', 'Api\SkillsController@index');

Route::group(['middleware' => 'auth:api'], function(){
    
    Route::post('logout', 'Api\AuthController@logout');

});
