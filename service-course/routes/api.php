<?php

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