<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\StoreHouseController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\PresentationController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\FarmController;

use App\Jobs\Logger;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'authenticate']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('get-user', [AuthController::class, 'getUser']);
});


Route::get('/companies', [CompanyController::class, 'index']);
Route::put('/companies', [CompanyController::class, 'store']);
Route::post('/companies/update/{id}', [CompanyController::class, 'update']);
Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);

Route::get('/store-houses', [StoreHouseController::class, 'index']);
Route::put('/store-houses', [StoreHouseController::class, 'store']);
Route::post('/store-houses/update/{id}', [StoreHouseController::class, 'update']);
Route::delete('/store-houses/{id}', [StoreHouseController::class, 'destroy']);

Route::get('/sections', [SectionController::class, 'index']);
Route::put('/sections', [SectionController::class, 'store']);
Route::post('/sections/update/{id}', [SectionController::class, 'update']);
Route::delete('/sections/{id}', [SectionController::class, 'destroy']);

Route::get('/levels', [LevelController::class, 'index']);
Route::put('/levels', [LevelController::class, 'store']);
Route::post('/levels/update/{id}', [LevelController::class, 'update']);
Route::delete('/levels/{id}', [LevelController::class, 'destroy']);

Route::get('/sizes', [SizeController::class, 'index']);
Route::put('/sizes', [SizeController::class, 'store']);
Route::post('/sizes/update/{id}', [SizeController::class, 'update']);
Route::delete('/sizes/{id}', [SizeController::class, 'destroy']);

Route::get('/presentations', [PresentationController::class, 'index']);
Route::put('/presentations', [PresentationController::class, 'store']);
Route::post('/presentations/update/{id}', [PresentationController::class, 'update']);
Route::delete('/presentations/{id}', [PresentationController::class, 'destroy']);

Route::get('/boxes', [BoxController::class, 'index']);
Route::put('/boxes', [BoxController::class, 'store']);
Route::post('/boxes/update/{id}', [BoxController::class, 'update']);
Route::post('/boxes/scaffolds', [BoxController::class, 'getScaffolds']);
Route::delete('/boxes/{id}', [BoxController::class, 'destroy']);

Route::get('/types', [TypeController::class, 'index']);
Route::put('/types', [TypeController::class, 'store']);
Route::post('/types/update/{id}', [TypeController::class, 'update']);
Route::delete('/types/{id}', [TypeController::class, 'destroy']);

Route::get('/farms', [FarmController::class, 'index']);
Route::put('/farms', [FarmController::class, 'store']);
Route::post('/farms/update/{id}', [FarmController::class, 'update']);
Route::delete('/farms/{id}', [FarmController::class, 'destroy']);

Route::get('/inventories', [InventoryController::class, 'index']);
Route::put('/inventories', [InventoryController::class, 'store']);
Route::post('/inventories/update/{id}', [InventoryController::class, 'update']);
Route::post('/inventories/get/items', [InventoryController::class, 'getItems']);
Route::post('/inventories/check/scaffold', [InventoryController::class, 'checkScaffold']);
Route::delete('/inventories/{id}', [InventoryController::class, 'destroy']);
Route::post('/inventories/import', [InventoryController::class, 'import']);
