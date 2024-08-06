<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/',[ProjectController::class,'index'])->name('home');

Route::get('/single_product',function () {
    return redirect('/');
});

Route::get('/products',[ProjectController::class,'products'])->name('products');


Route::get('/about', function () {
    return view('about');
});

Route::get('/single_product/{id}',[ProjectController::class,'single_product'])->name('single_product');

Route::get('/cart',[CartController::class,'cart'])->name('cart');

Route::post('/add_to_cart',[CartController::class,'add_to_cart'])->name('add_to_cart');
Route::get('/add_to_cart',function(){
    return redirect('/');
});
Route::post('/remove-from-cart', [CartController::class, 'remove_from_cart'])->name('remove_from_cart');
Route::post('/edit_product_quantity', [CartController::class, 'edit_product_quantity'])->name('edit_product_quantity');
Route::get('/edit_product_quantity ',function(){
    return redirect('/');
});
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/place_order', [CartController::class, 'place_order'])->name('place_order');

Route::get('/payment', [PaymentController::class, 'payment'])->name('payment');
Route::get('/verify_payment', [PayPalController::class, 'verify_payment'])->name('verify_payment');
Route::get('/complete_payment', [PayPalController::class, 'complete_payment'])->name('complete_payment');

// Route::get('paypal-payment', [PayPalController::class, 'payment'])->name('paypal.payment');
// Route::get('paypal-success', [PayPalController::class, 'success'])->name('paypal.success');
// Route::get('paypal-cancel', [PayPalController::class, 'cancel'])->name('paypal.cancel');

Route::get('/paypal', [PayPalController::class, 'index'])->name('paypal');
Route::get('/paypal/payment', [PayPalController::class, 'payment'])->name('paypal.payment');
Route::get('/paypal/payment/cancel', [PayPalController::class, 'paymentCancel'])->name('paypal.payment.cancel');
Route::get('/thank-you/{order_id}', [PayPalController::class, 'thankYou'])->name('thank.you');

Route::get('/paypal/payment/success', [PayPalController::class, 'paymentSuccess'])->name('paypal.payment.success');
