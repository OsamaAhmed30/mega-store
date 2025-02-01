<?php

use App\Http\Controllers\Front\Auth\TwoFactorAuthenticationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\CurrencyConverterController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\LanguagesController;
use App\Http\Controllers\Front\PaymentsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

// Auth::routes([
//     "verify"=>true
// ]);

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
],function(){
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('/product/{product:slug}', [HomeController::class,'show'])->name('front.product.show');
    Route::resource('/cart', CartController::class);
    Route::get('/checkout', [CheckoutController::class,'create'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class,'store']);
    
    Route::post('/2fa-confirm', [TwoFactorAuthenticationController::class, 'confirm'])->name('two-factor.confirm');
    Route::get('/auth/user/2fa', [TwoFactorAuthenticationController::class,'index'])->name('front.2fa');
      
    Route::post('/currency', [CurrencyConverterController::class,'store'])->name('front.currency.store');
    Route::get('/orders/{order}/pay', [PaymentsController::class,'create'])->name('orders.payments.create');
    
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
   
});
});



//require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
