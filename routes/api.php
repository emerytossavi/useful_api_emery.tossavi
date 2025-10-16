<?php

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::prefix("auth")->middleware('CheckModuleActive')->group([
/* Route::middleware('CheckModuleActive')->group([

]); */

Route::middleware('CheckModuleActive')->group(function () {
    Route::get("/modules", [ModuleController::class, 'index']);

});


Route::post("/register", [UserController::class, "register"])->name('user.register');
