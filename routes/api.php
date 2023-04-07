<?php
 
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\RegionController;
use App\Http\Controllers\API\OriginController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\CostumerController;
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

Route::post("register", [AuthController::class, "register"]); 
Route::post("login", [AuthController::class, "login"]);
 
 
 
 


//Users routes

Route::group(['prefix' => 'users'], function () { 
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::patch('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});

 
Route::group(['prefix' => 'regions'], function () { 
    Route::get('/', [RegionController::class, 'index']);
    Route::post('/', [RegionController::class, 'store']);
    Route::get('/{id}', [RegionController::class, 'show']);
    Route::patch('/{id}', [RegionController::class, 'update']);
    Route::delete('/{id}', [RegionController::class, 'destroy']);
});

Route::group(['prefix' => 'origins'], function () { 
    Route::get('/', [OriginController::class, 'index']);
    Route::post('/', [OriginController::class, 'store']);
    Route::get('/{id}', [OriginController::class, 'show']);
    Route::patch('/{id}', [OriginController::class, 'update']);
    Route::delete('/{id}', [OriginController::class, 'destroy']);
});


Route::group(['prefix' => 'products'], function () { 
    Route::get('/', [ProductController::class, 'index']);
    Route::post('/', [ProductController::class, 'store']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::patch('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});


Route::group(['prefix' => 'custemrs'], function () { 
    Route::get('/', [CostumerController::class, 'index']);
    Route::post('/', [CostumerController::class, 'store']);
    Route::get('/{id}', [CostumerController::class, 'show']);
    Route::patch('/{id}', [CostumerController::class, 'update']);
    Route::delete('/{id}', [CostumerController::class, 'destroy']);
});
 