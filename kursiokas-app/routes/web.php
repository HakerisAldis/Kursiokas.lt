<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;

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

Route::redirect('/', '/courses');

Route::get('/test', function () {
    return view('login');
})->name('login');

Route::get('/courses', [CourseController::class, 'index'])->name('courses');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('course.show');

Route::get('/create', [CourseController::class, 'create'])->name('course.create');
Route::post('/create', [CourseController::class, 'store'])->name('course.create');

Route::post('/courses/{id}/delete', [CourseController::class, 'destroy'])->name('course.destroy');
Route::post('/courses/{id}/register', [CourseController::class, 'register'])->name('course.register');
Route::post('/courses/{id}/cancel', [CourseController::class, 'cancel'])->name('course.cancel');

Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('course.edit');
Route::post('/courses/{id}/edit', [CourseController::class, 'update'])->name('course.update');

Route::get('/courses/{id}/users', [CourseController::class, 'users']);

Route::post('/courses/{id}/close', [CourseController::class, 'close'])->name('course.close');
Route::post('/courses/{id}/open', [CourseController::class, 'open'])->name('course.open');

Route::post('/courses/{id}/assign', [CourseController::class, 'assignLecturers'])->name('course.assign');

Route::get('/token', [CourseController::class, 'token']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
