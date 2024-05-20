<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\MallController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\VendorProductController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware'=>'auth:sanctum'],function (){
    Route::resource('/manager', ManagerController::class);
    Route::resource('/mall', MallController::class);
    Route::resource('/department', DepartmentController::class);
    Route::resource('/vendor', VendorController::class);
    Route::resource('/product', ProductController::class);

    Route::post('/create-vendor-product',[VendorProductController::class,'store']);
});


Route::post('/login',[AuthController::class,'login']);
