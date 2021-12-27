<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CarBrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserCarController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRentalsController;
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

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {

    Route::group(['prefix' => 'admin'], function (){
        Route::post('login', [AdminController::class, 'login']);
        Route::post('logout', [AdminController::class, 'logout']);
        Route::put('update/{id}', [AdminController::class, 'update']);
        Route::post('me', [AdminController::class, 'me']);
    });

    Route::group(['prefix' => 'user'], function (){
        Route::post('store', [UserController::class, 'store']);
        Route::post('login', [UserController::class, 'login']);
        Route::post('logout', [UserController::class, 'logout']);
        Route::put('update/{id}', [UserController::class, 'update']);
        Route::post('me', [UserController::class, 'me']);
    });
});


Route::group(['middleware' => 'api', 'prefix' => 'admin'], function () {
    Route::apiResource('branch', BranchController::class);

    Route::get('inquiry', [AdminController::class, 'inquiry']);
    Route::get('summary', [DashboardController::class, 'summary']);

    Route::get('transmission', [CarBrandController::class, 'transmission']);

    Route::get('payments', [ClientController::class, 'payments']);
    Route::put('rentals/{id}', [ClientController::class, 'rentalFinished']);
    Route::get('rentals', [ClientController::class, 'rentals']);
    Route::put('update/rental/{id}', [ClientController::class, 'updateRental']);
    Route::post('search/rentals', [ClientController::class, 'searchRental']);
    
    Route::post('uploadFeaturedImage', [CarController::class, 'uploadFeaturedImage']);
    Route::post('cars', [CarController::class, 'store']);
    Route::delete('cars/{id}', [CarController::class, 'destroy']);
    Route::put('cars/{id}', [CarController::class, 'update']);
    Route::get('cars', [CarController::class, 'index']);
    Route::post('search/car', [CarController::class, 'searchCar']);

    Route::get('clients', [ClientController::class, 'index']);
    Route::delete('client/{id}', [ClientController::class, 'delete']);
    Route::post('search/client', [ClientController::class, 'search']);
    Route::put('account/update/{id}', [AdminController::class, 'updateUserAccount']);
    
    Route::post('carbrand', [CarBrandController::class, 'store']);
    Route::get('carbrand/all', [CarBrandController::class, 'all']);
    Route::get('carbrand', [CarBrandController::class, 'index']);
    Route::delete('carbrand/{id}', [CarBrandController::class, 'destroy']);
    Route::put('carbrand/{id}', [CarBrandController::class, 'update']);
    Route::post('search/carbrand', [CarBrandController::class, 'searchCarBrand']);

});

Route::group(['middleware' => 'api', 'prefix' => 'user'], function () {
    Route::post('checkout',[RentalController::class,'checkout']);
    Route::get('rentals',[RentalController::class,'index']);

    Route::post('uploadFeaturedImage', [UserCarController::class, 'uploadFeaturedImage']);
    Route::post('cars', [UserCarController::class, 'store']);
    Route::delete('cars/{id}', [UserCarController::class, 'destroy']);
    Route::put('cars/{id}', [UserCarController::class, 'update']);
    Route::get('cars', [UserCarController::class, 'index']);
    Route::post('search/car', [UserCarController::class, 'searchCar']);

    // Rentals
    Route::put('rentals/{id}', [UserRentalsController::class, 'rentalFinished']);
    Route::get('rentals', [UserRentalsController::class, 'rentals']);
    Route::put('update/rental/{id}', [UserRentalsController::class, 'updateRental']);
    Route::post('search/rentals', [UserRentalsController::class, 'searchRental']);
});

Route::post('send/inquiry', [InquiryController::class, 'store']);
Route::get('cars', [CarController::class, 'getCars']);
Route::get('paymenttypes', [AdminController::class, 'paymenttype']);