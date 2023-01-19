<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\AuthController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('get-main-categories' , 'App\Http\Controllers\Api\CategoriesController@index');

Route::group(['middleware' => 'api', 'namespace' => 'Api'], function () {

    Route::post('get-main-categories', [CategoriesController::class, 'index']);
    Route::post('get-category-by-id', [CategoriesController::class, 'getCategoryById']);
    Route::post('change-category-status', [CategoriesController::class, 'changeStatus']);
});

Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
    Route::get('get-all-admins', [AuthController::class, 'getAllAdmins'])->middleware('assign.guard:admin-api');
    Route::post('register', [AuthController::class, 'register'])->middleware('assign.guard:admin-api');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('assign.guard:admin-api');
});

Route::group(['prefix' => 'user', 'middleware' => 'assign.guard:user-api'], function () {
    Route::post('profile', function () {
        return Auth::user(); }
    );
    Route::post('login', [AuthController::class, 'userLogin']);
});