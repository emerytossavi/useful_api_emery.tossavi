<?php

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserModuleController;
use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// })->middleware('auth_api');


// Route::prefix("auth")->middleware('CheckModuleActive')->group([
/* Route::middleware('CheckModuleActive')->group([

]); */

// Route::middleware(['auth:sanctum', 'CheckModuleActive'])->group(function () {
    Route::get("/modules", [ModuleController::class, 'index']);
Route::middleware(['CheckModuleActive'])->prefix('modules/{id}')->group(function () {

    // Desactivation
    Route::post("/deactivate", [UserModuleController::class, "deActivateModule"])->name("module.deActivate");

    // URL
    Route::post("/shorten", [ShortLinkController::class, 'store'])->name("url.store");


});

Route::post("modules/{id}/activate", [UserModuleController::class, "activateModule"])->name("module.activate");

Route::post("/register", [UserController::class, "register"])->name('user.register');
Route::post("/login", [UserController::class, "login"])->name('user.login');
