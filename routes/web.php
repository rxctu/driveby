<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PrivacyController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Catalog
Route::get('/catalogue', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalogue/{slug}', [CatalogController::class, 'category'])->name('catalog.category');
Route::get('/catalogue/{categorySlug}/{productSlug}', [CatalogController::class, 'show'])->name('catalog.product');

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Partners
Route::get('/partenaires', [PartnerController::class, 'index'])->name('partners.index');

// Legal / RGPD pages
Route::get('/mentions-legales', [LegalController::class, 'mentions'])->name('legal.mentions');
Route::get('/politique-de-confidentialite', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/conditions-generales-de-vente', [LegalController::class, 'cgv'])->name('legal.cgv');
Route::get('/politique-cookies', [LegalController::class, 'cookies'])->name('legal.cookies');

/*
|--------------------------------------------------------------------------
| Cart (no auth required)
|--------------------------------------------------------------------------
*/

Route::prefix('panier')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/ajouter', [CartController::class, 'add'])->name('add');
    Route::patch('/modifier', [CartController::class, 'update'])->name('update');
    Route::delete('/supprimer/{productId}', [CartController::class, 'remove'])->name('remove');
});

/*
|--------------------------------------------------------------------------
| Community (Shared Lists)
|--------------------------------------------------------------------------
*/

Route::get('/communaute', [CommunityController::class, 'index'])->name('community.index');
Route::get('/communaute/mes-listes', [CommunityController::class, 'myLists'])->name('community.my-lists')->middleware('auth');
Route::get('/communaute/creer', [CommunityController::class, 'create'])->name('community.create')->middleware('auth');
Route::post('/communaute', [CommunityController::class, 'store'])->name('community.store')->middleware('auth');
Route::get('/communaute/{list}', [CommunityController::class, 'show'])->name('community.show');
Route::post('/communaute/{list}/vote', [CommunityController::class, 'vote'])->name('community.vote')->middleware('auth');
Route::post('/communaute/{list}/comment', [CommunityController::class, 'comment'])->name('community.comment')->middleware('auth');
Route::post('/communaute/{list}/copier', [CommunityController::class, 'copyToCart'])->name('community.copy');
Route::delete('/communaute/{list}', [CommunityController::class, 'destroy'])->name('community.destroy')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/connexion', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/connexion', [AuthController::class, 'login'])->middleware('throttle:5,1');
    Route::get('/inscription', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/inscription', [AuthController::class, 'register'])->middleware('throttle:5,1');
    Route::get('/auth/google', [AuthController::class, 'googleRedirect'])->name('auth.google');
    Route::get('/auth/google/callback', [AuthController::class, 'googleCallback'])->name('auth.google.callback');
});

Route::post('/deconnexion', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Checkout
    Route::prefix('commande')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/', [CheckoutController::class, 'store'])->name('store');
        Route::post('/promo', [CheckoutController::class, 'applyPromo'])->name('apply-promo');
        Route::post('/livraison-estimation', [CheckoutController::class, 'calculateDelivery'])->name('delivery.estimate');
        Route::post('/reverse-geocode', [CheckoutController::class, 'reverseGeocode'])->name('reverse-geocode');
        Route::get('/confirmation/{orderNumber}', [CheckoutController::class, 'success'])->name('success');
        Route::get('/suivi/{orderNumber}', [CheckoutController::class, 'pollOrderStatus'])->name('poll-status');
    });

    // Payment
    Route::post('/paiement/stripe-intent', [PaymentController::class, 'stripeIntent'])->name('payment.stripe.intent');

    // Account
    Route::prefix('mon-compte')->name('account.')->group(function () {
        Route::get('/', [AccountController::class, 'index'])->name('index');
        Route::get('/commandes', [AccountController::class, 'orders'])->name('orders');
        Route::get('/mes-commandes/poll', [AccountController::class, 'pollOrders'])->name('poll-orders');
        Route::get('/commandes/{orderNumber}', [AccountController::class, 'orderDetail'])->name('order.detail');
        // RGPD - User data rights
        Route::get('/donnees-personnelles', [PrivacyController::class, 'myData'])->name('privacy');
        Route::post('/exporter-donnees', [PrivacyController::class, 'exportData'])->name('export-data');
        Route::post('/supprimer-compte', [PrivacyController::class, 'deleteAccount'])->name('delete-account');
        Route::put('/mot-de-passe', [AccountController::class, 'updatePassword'])->name('password.update');
    });
});

/*
|--------------------------------------------------------------------------
| Stripe Webhook (no CSRF)
|--------------------------------------------------------------------------
*/

Route::post('/webhook/stripe', [PaymentController::class, 'stripeWebhook'])
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class])
    ->name('webhook.stripe');
