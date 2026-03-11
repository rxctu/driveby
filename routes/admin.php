<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliveryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\PromoCodeController;
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
Route::get('stock-alerts', [DashboardController::class, 'stockAlerts'])->name('stock-alerts');

// Products CRUD
Route::resource('produits', ProductController::class)->names('products')->parameters([
    'produits' => 'product',
]);

// Categories CRUD
Route::resource('categories', CategoryController::class);

// Orders
Route::get('commandes', [OrderController::class, 'index'])->name('orders.index');
Route::get('commandes/poll', [OrderController::class, 'pollNewOrders'])->name('orders.poll');
Route::get('commandes/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('commandes/{order}/poll', [OrderController::class, 'pollOrderStatus'])->name('orders.poll-status');
Route::post('commandes/geocode', [OrderController::class, 'geocode'])->name('orders.geocode');
Route::patch('commandes/{order}/statut', [OrderController::class, 'updateStatus'])->name('orders.update-status');
Route::post('commandes/validate-pickup', [OrderController::class, 'validatePickup'])->name('orders.validate-pickup');

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
Route::patch('utilisateurs/{user}/trust', [UserController::class, 'updateTrust'])->name('users.update-trust');

// Inventory / Barcode scanner
Route::get('inventaire', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('inventaire/stats', [InventoryController::class, 'stats'])->name('inventory.stats');
Route::post('inventaire/scan', [InventoryController::class, 'scan'])->name('inventory.scan');
Route::post('inventaire/register', [InventoryController::class, 'registerBarcode'])->name('inventory.register');
Route::post('inventaire/movement', [InventoryController::class, 'addMovement'])->name('inventory.movement');
Route::post('inventaire/photo', [InventoryController::class, 'uploadProductPhoto'])->name('inventory.upload-photo');
Route::put('inventaire/mapping/{mapping}', [InventoryController::class, 'updateMapping'])->name('inventory.update-mapping');
Route::delete('inventaire/mapping/{mapping}', [InventoryController::class, 'deleteMapping'])->name('inventory.delete-mapping');

// Promo codes
Route::get('promos', [PromoCodeController::class, 'index'])->name('promos.index');
Route::post('promos', [PromoCodeController::class, 'store'])->name('promos.store');
Route::post('promos/{promoCode}/toggle', [PromoCodeController::class, 'toggle'])->name('promos.toggle');
Route::delete('promos/{promoCode}', [PromoCodeController::class, 'destroy'])->name('promos.destroy');

// General settings
Route::get('parametres', [SettingController::class, 'index'])->name('settings.index');
Route::put('parametres', [SettingController::class, 'update'])->name('settings.update');
