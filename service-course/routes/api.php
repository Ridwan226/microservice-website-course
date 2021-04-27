<?php

use App\Http\Controllers\Api\ChapterController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\MentorController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/mentor', [MentorController::class, 'create']);
Route::put('/mentor/update/{id}', [MentorController::class, 'update']);
Route::get('/mentor', [MentorController::class, 'index']);
Route::get('/mentor/detail/{id}', [MentorController::class, 'show']);
Route::delete('/mentor/delete/{id}', [MentorController::class, 'del']);

Route::get('/courses', [CourseController::class, 'index']);
Route::post('/courses', [CourseController::class, 'create']);
Route::put('/courses/update/{id}', [CourseController::class, 'update']);
Route::delete('/courses/delete/{id}', [CourseController::class, 'del']);


Route::get('/chapter', [ChapterController::class, 'index']);
Route::post('/chapter', [ChapterController::class, 'create']);
Route::put('/chapter/update/{id}', [ChapterController::class, 'update']);
Route::get('/chapter/detail/{id}', [ChapterController::class, 'detail']);
Route::delete('/chapter/delete/{id}', [ChapterController::class, 'del']);

Route::get('/leasson', [LessonController::class, 'index']);
Route::get('/leasson/detail/{id}', [LessonController::class, 'detail']);
Route::post('/leasson', [LessonController::class, 'create']);
Route::put('/leasson/edit/{id}', [LessonController::class, 'update']);
Route::delete('/leasson/delete/{id}', [LessonController::class, 'del']);
