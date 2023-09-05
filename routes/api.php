<?php

use App\Http\Controllers\Api\V1\AccessTokenController;
use App\Http\Controllers\Api\V1\ClassroomController;
use App\Http\Controllers\Api\V1\ClassworksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function () {

    Route::middleware('guest:sanctum')->group(function () {
        Route::post('/login',[AccessTokenController::class,'store']);
    });


    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('/classrooms',ClassroomController::class);
        Route::apiResource('classrooms.classworks',ClassworksController::class);

        Route::get('/access-tokens',[AccessTokenController::class,'index']);
        Route::delete('/logout/{id?}',[AccessTokenController::class,'destroy']);

    });

});






