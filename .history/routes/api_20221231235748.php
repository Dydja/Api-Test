<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RegisterController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(RegisterController::class)->group(function(){
     Route::post('register','register');
     Route::post('login','login');

});

Route::controller(ProductController::class)->group(function(){
    Route::get('products/list','index');

});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('products',ProductController::class)->only('store','update','destroy');
    Route::post('profile',[RegisterController::class,'profile']);
    Route::post('logout',[RegisterController::class,'logout']);
});
