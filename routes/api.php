<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ResponsibilityController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\TeamController;
use App\Http\Controllers\Api\UserController;
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

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'getUserDetail']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::apiResource('users', UserController::class);

    Route::get('companies/fetch', [CompanyController::class, 'getCompanyByUser']);
    Route::apiResource('companies', CompanyController::class);

    Route::get('teams/fetch', [TeamController::class, 'getTeamByCompany']);
    Route::apiResource('teams', TeamController::class);

    Route::get('roles/fetch', [RoleController::class, 'getRoleByCompany']);
    Route::apiResource('roles', RoleController::class);

    Route::get('responsibilities/fetch', [ResponsibilityController::class, 'getResponsibilityByRole']);
    Route::apiResource('responsibilities', ResponsibilityController::class);

    Route::apiResource('employees', EmployeeController::class);
});
