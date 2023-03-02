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
    Route::post('/login',[UserController::class,'login'])->name('login');
    Route::post('/recoverPass',[UserController::class,'recoverPass']);
});
Route::prefix('cards')->group(function(){
    Route::post('/registCards',[CardController::class,'registCards']);//->middleware(['auth:sanctum', 'ability:admin']);
    Route::put('/addCardToCollection',[CardController::class,'addCardToCollection'])->middleware(['auth:sanctum', 'ability:admin']);
    Route::post('/updateCards',[CardController::class,'updateCards'])->middleware(['auth:sanctum', 'ability:admin']);
    Route::post('/buyCard',[CardController::class,'buyCard']);
});
Route::middleware(['auth:sanctum', 'ability:admin'])->prefix('collections')->group(function(){
    Route::put('/registCollections',[CollectionController::class,'registCollections']);
    Route::post('/updateCollections',[CollectionController::class,'updateCollections']);
});
Route::middleware(['auth:sanctum', 'ability:particular,professional'])->prefix('sales')->group(function(){
    Route::post('/searchCard',[SaleController::class,'searchCard']);  
    Route::post('/sellCard',[SaleController::class,'sellCard']);
});