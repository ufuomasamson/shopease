<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\ChatController;

Route::get('/', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Public product routes (viewing only)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');



// Protected user routes (require authentication)
Route::middleware(['auth'])->group(function () {
    // Wallet routes
    Route::get('/wallet', [WalletController::class, 'show'])->name('wallet.show');

    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // Shipping Address routes
    Route::resource('shipping-addresses', ShippingAddressController::class);
    Route::post('/shipping-addresses/{shippingAddress}/set-default', [ShippingAddressController::class, 'setDefault'])->name('shipping-addresses.set-default');
    
    // Chat routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/create', [ChatController::class, 'create'])->name('chat.create');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/{chatRoom}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{chatRoom}/message', [ChatController::class, 'sendMessage'])->name('chat.send-message');
    Route::post('/chat/{chatRoom}/file', [ChatController::class, 'uploadFile'])->name('chat.upload-file');
    Route::post('/chat/{chatRoom}/close', [ChatController::class, 'close'])->name('chat.close');
    Route::get('/chat/{chatRoom}/messages', [ChatController::class, 'getMessages'])->name('chat.get-messages');
    Route::get('/chat/unread-count', [ChatController::class, 'getUnreadCount'])->name('chat.unread-count');
    Route::get('/chat/latest-messages', [ChatController::class, 'getLatestMessages'])->name('chat.latest-messages');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/fund-wallet', [AdminController::class, 'fundWallet'])->name('fund-wallet');
    Route::post('/fund-wallet', [AdminController::class, 'processWalletFunding'])->name('process-wallet-funding');
    Route::get('/orders', [AdminController::class, 'orders'])->name('orders');
    Route::get('/orders/{order}', [AdminController::class, 'showOrder'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminController::class, 'updateOrderStatus'])->name('orders.update-status');
    Route::get('/categories-brands', [AdminController::class, 'categoriesBrands'])->name('categories-brands');
    
    // Order Tracking Management
    Route::get('/orders/{order}/tracking', [OrderTrackingController::class, 'show'])->name('orders.tracking.show');
    Route::post('/orders/{order}/tracking', [OrderTrackingController::class, 'store'])->name('orders.tracking.store');
    Route::put('/tracking/{tracking}', [OrderTrackingController::class, 'update'])->name('orders.tracking.update');
    Route::delete('/tracking/{tracking}', [OrderTrackingController::class, 'destroy'])->name('orders.tracking.destroy');
    
    // Review Management Routes
    Route::get('/reviews', [AdminController::class, 'reviews'])->name('reviews');
    Route::get('/reviews/create', [AdminController::class, 'createReview'])->name('reviews.create');
    Route::post('/reviews', [AdminController::class, 'storeReview'])->name('reviews.store');
    Route::get('/reviews/{review}/edit', [AdminController::class, 'editReview'])->name('reviews.edit');
    Route::put('/reviews/{review}', [AdminController::class, 'updateReview'])->name('reviews.update');
    Route::delete('/reviews/{review}', [AdminController::class, 'deleteReview'])->name('reviews.destroy');
    Route::patch('/reviews/{review}/toggle-approval', [AdminController::class, 'toggleReviewApproval'])->name('reviews.toggle-approval');
    
    // Product management (admin only) - full CRUD
    Route::resource('products', ProductController::class);
    
    // Category and Brand management
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('brands', \App\Http\Controllers\Admin\BrandController::class);
    
    // Chat Management Routes
    Route::get('/chat', [\App\Http\Controllers\Admin\ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{chatRoom}', [\App\Http\Controllers\Admin\ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{chatRoom}/assign', [\App\Http\Controllers\Admin\ChatController::class, 'assign'])->name('chat.assign');
    Route::post('/chat/{chatRoom}/transfer', [\App\Http\Controllers\Admin\ChatController::class, 'transfer'])->name('chat.transfer');
    Route::post('/chat/{chatRoom}/close', [\App\Http\Controllers\Admin\ChatController::class, 'close'])->name('chat.close');
    Route::post('/chat/{chatRoom}/reopen', [\App\Http\Controllers\Admin\ChatController::class, 'reopen'])->name('chat.reopen');
    Route::post('/chat/{chatRoom}/message', [\App\Http\Controllers\Admin\ChatController::class, 'sendMessage'])->name('chat.send-message');
    Route::get('/chat/{chatRoom}/messages', [\App\Http\Controllers\Admin\ChatController::class, 'getMessages'])->name('chat.get-messages');
    Route::get('/chat/unread-count', [\App\Http\Controllers\Admin\ChatController::class, 'getUnreadCount'])->name('chat.unread-count');
    Route::get('/chat/stats', [\App\Http\Controllers\Admin\ChatController::class, 'getStats'])->name('chat.stats');
});
