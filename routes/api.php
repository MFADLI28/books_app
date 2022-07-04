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

Route::post( '/ping',[\App\Http\Controllers\API\TestController::class,'ping']);




Route::post( '/register',[\App\Http\Controllers\API\AuthController::class,'register']);
Route::post( '/login',[\App\Http\Controllers\API\AuthController::class,'login']);



Route::group(['middleware' => ['auth:sanctum']],function() {
    Route::apiResource('books','\App\Http\Controllers\API\BookController', [
        "only" => ["store","update","index","edit","destroy"]
    ]);
    
    Route::apiResource('category','\App\Http\Controllers\API\CategoriesController', [
        "only" => ["store","update","index","edit","destroy"]
    ]);

    Route::post( '/logout',[\App\Http\Controllers\API\AuthController::class,'logout']);
});
