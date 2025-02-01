<?php

use App\Http\Controllers\Dashboard\AdminsController;
use App\Http\Controllers\Dashboard\CategoriesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RolesController;
use App\Http\Controllers\Dashboard\StoresController;
use App\Http\Controllers\Dashboard\UsersController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Route;

Route::group([
    //'middleware' =>['auth','auth.type:super-admin,admin'],
    'middleware' => ['auth:admin,web'],
    'as' => 'dashboard.',
    'prefix' => 'admin/dashboard'

], function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/categories/trash', [CategoriesController::class, 'trash'])->name('categories.trash');
    Route::put('/categories/{category}/restore', [CategoriesController::class, 'restore'])->name('categories.restore');
    Route::delete('/categories/{category}/force-delete', [CategoriesController::class, 'forceDelete'])->name('categories.force-delete');

    Route::resource("/categories", CategoriesController::class)->except('show');
    Route::resource("/products", ProductsController::class);
    Route::resource("/users", UsersController::class);
    Route::resource("/admins", AdminsController::class);
    //Route::get("/products/{product:slug}", [ProductsController::class,'show'])->name('products.show');
    Route::get("/categories/{category:slug}", [CategoriesController::class,'show'])->name('categories.show');
    Route::resource("/stores", StoresController::class);
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::resource('/orders', OrdersController::class);
    Route::resource('/roles', RolesController::class);
    Route::post('/notifications/markAsRead', [NotificationsController::class, 'markAsRead'])->name('notifications.markAsRead');
});
