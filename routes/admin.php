<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Prefixed with /admin, middleware: web, auth, admin
|
*/

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Products CRUD
Route::resource('produits', ProductController::class)->names('products')->parameters([
    'produits' => 'product',
]);

// Categories CRUD
Route::resource('categories', CategoryController::class);

// Orders
Route::get('commandes', [OrderController::class, 'index'])->name('orders.index');
Route::get('commandes/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::patch('commandes/{order}/statut', [OrderController::class, 'updateStatus'])->name('orders.update-status');

// Delivery settings & slots
Route::get('livraison', [DeliveryController::class, 'index'])->name('delivery.index');
Route::put('livraison', [DeliveryController::class, 'update'])->name('delivery.update');
Route::post('livraison/pricing', [DeliveryController::class, 'updatePricing'])->name('delivery.update-pricing');
Route::post('livraison/slots', [DeliveryController::class, 'storeSlot'])->name('delivery.store-slot');
Route::post('livraison/slots/{slot}/toggle', [DeliveryController::class, 'toggleSlot'])->name('delivery.toggle-slot');
Route::post('livraison/slots/{slot}/delete', [DeliveryController::class, 'deleteSlot'])->name('delivery.delete-slot');

// Partners CRUD
Route::resource('partenaires', PartnerController::class)->names('partners')->parameters([
    'partenaires' => 'partner',
]);

// Users management
Route::get('utilisateurs', [UserController::class, 'index'])->name('users.index');
Route::patch('utilisateurs/{user}/toggle', [UserController::class, 'toggleActive'])->name('users.toggle-active');
Route::post('utilisateurs/{user}/reset-password', [UserController::class, 'sendPasswordReset'])->name('users.send-reset');

// General settings
Route::get('parametres', [SettingController::class, 'index'])->name('settings.index');
Route::put('parametres', [SettingController::class, 'update'])->name('settings.update');
