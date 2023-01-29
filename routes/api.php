<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::prefix('users')->group(function(){
    Route::put('/register',[UserController::class,'register']);
    Route::post('/login',[UserController::class,'login']);
    Route::post('/recoverPass',[UserController::class,'recoverPass']);
});
Route::prefix('cards')->group(function(){
    Route::put('/registCards',[UserController::class,'registCards'])->middleware(['auth:sanctum', 'ability:admin']);
    Route::put('/addCardToCollection',[CardController::class,'addCardToCollection'])->middleware(['auth:sanctum', 'ability:admin']);
    Route::post('/buyCard',[CardController::class,'buyCard']);
});
Route::prefix('collections')->group(function(){
    Route::put('/registCollections',[CollectionController::class,'registCollections'])/*->middleware(['auth:sanctum', 'ability:admin'])*/;
});
Route::prefix('sales')->group(function(){
    Route::put('/searchCard',[SaleController::class,'searchCard'])->middleware(['auth:sanctum', 'ability:particular,professional']);  
    Route::put('/sellCard',[SaleController::class,'sellCard'])->middleware(['auth:sanctum', 'ability:particular,professional']); 
});