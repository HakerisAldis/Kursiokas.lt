<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

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

Route::middleware('auth:api')->get('/courses', [CourseController::class, 'index']);
Route::middleware('auth:api')->get('/courses/{id}', [CourseController::class, 'show']);
Route::middleware('auth:api')->get('/courses/{id}/users', [CourseController::class, 'users']);