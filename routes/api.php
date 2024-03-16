<?php

use App\Http\Controllers\CommentController;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PatientCheckupsController;
use App\Models\PatientCheckups;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('comments', CommentController::class);


/*

GET|HEAD        api/comments ....... comments.index › App\Models\Comment@index
  POST            api/comments ....... comments.store › App\Models\Comment@store
  GET|HEAD        api/comments/{comment} ......... comments.show › App\Models\Comment@show
  PUT|PATCH       api/comments/{comment} ..... comments.update › App\Models\Comment@update
  DELETE          api/comments/{comment} ... comments.destroy › App\Models\Comment@destroy



*/


Route::resource('users', UserController::class)->except(['create', 'edit']);

Route::apiResource("appointments",AppointmentController::class);
Route::apiResource("departments",DepartmentController::class);


Route::apiResource("patientheckups",PatientCheckupsController::class);
