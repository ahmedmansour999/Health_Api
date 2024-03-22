<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientCheckupsController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\FreetimeController;
use App\Models\Doctor;
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


Route::post('register', [AuthController::class, 'createUser']);
// Route::get('register', [AuthController::class, 'createUser']);
Route::post('login', [AuthController::class, 'loginUser']);
// Route::get('login', [AuthController::class, 'loginUser']);


Route::apiResource("appointments",AppointmentController::class);
Route::apiResource("department",DepartmentController::class);
Route::get('appointmentDoc/{id}' , [AppointmentController::class , 'getAppointmentsForDoctor' ]) ;
Route::get('appointmentStatus/{doctorId}/{status}', [AppointmentController::class, 'getAppointmentStatus']);
Route::patch('appointmentDoc/{id}' , [AppointmentController::class , 'updateAppointmentStatus' ]) ;


Route::apiResource('doctors' , DoctorController::class) ;
Route::apiResource('patients' , PatientController::class) ;
Route::apiResource('posts' , PostController::class) ;
Route::apiResource('freetimes' , FreetimeController::class) ;
Route::get('freetimesDoc/{doctorId}' , [FreetimeController::class , 'getFreetimesForDoctor']) ;

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


