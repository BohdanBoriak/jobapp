<?php

use App\Http\Controllers\VacancyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;

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

Route::get('/workers/{vacancy}', [VacancyController::class,'workersForSingleVacancy'])->middleware('auth:sanctum');;
Route::post('/vacancy-unbook',[VacancyController::class, 'unbook'])->middleware('auth:sanctum');
Route::post('/vacancy-book',[VacancyController::class, 'book'])->middleware('auth:sanctum');
Route::get('viewAllCompanies', [CompanyController::class,'viewAllCompanies'])->middleware('auth:sanctum');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function(){
    Route::get('users', [UserController::class,'index']);
    Route::get('/user/{user}', [UserController::class,'show']);
    Route::put('/user/{user}',[UserController::class, 'update']);
    Route::delete('/user/{user}',[UserController::class, 'destroy']);
});

Route::apiResource('company', CompanyController::class)->middleware('auth:sanctum');
Route::apiResource('vacancy', VacancyController::class)->middleware('auth:sanctum');
