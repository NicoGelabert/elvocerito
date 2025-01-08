<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\QuotationController;

//Demo
use App\Http\Controllers\DemoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Mails de confirmación
// use App\Mail\QuotationConfirmation;
// use Illuminate\Support\Facades\Mail;
// Mails de confirmación
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['guestOrVerified'])->group(function () {
    Route::get('/underconstruction', function () {
        return view('underconstruction');
    });
    Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

    if (request()->getHost() === 'demo.chimicreativo.es' || request()->getHost() === 'demo.chimicreativo.local') {
        Route::get('/',[DemoController::class, 'index'])->name('welcome');
        Route::get('/products', [ProductController::class, 'index'])->name('product.index');
        Route::get('/categories', [CategoriesController::class, 'index'])->name('category.index');
        // Route::get('/categorias-json', [CategoryController::class, 'categoriasJson'])->name('categorias.json');
        // Route::get('/categories/{category:slug}', [CategoryController::class, 'view'])->name('category.view');
        Route::get('/products/{category:slug}/{product:slug}', [ProductController::class, 'view'])->name('product.view');
        Route::prefix('/cart')->name('cart.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add/{product:slug}', [CartController::class, 'add'])->name('add');
            Route::post('/remove/{product:slug}', [CartController::class, 'remove'])->name('remove');
            Route::post('/update-quantity/{product:slug}', [CartController::class, 'updateQuantity'])->name('update-quantity');
        });
    }else{
        Route::get('/',[WelcomeController::class, 'index'])->name('welcome');
        //Servicios
        Route::get('/servicios', [ServiceController::class, 'index'])->name('service.index');
        Route::get('/servicios/{service:slug}', [ServiceController::class, 'view'])->name('service.view');
    
        Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
    
        Route::get('/quotation', [QuotationController::class, 'create'])->name('quotation.create');
        Route::post('/quotation', [QuotationController::class, 'store'])->name('quotation.store');

        // Política de Privacidad
        Route::get('/politica-de-privacidad', function (){
            return view('legal/privacy-policy');
        });
        Route::get('/terminos-y-condiciones', function (){
            return view('legal/terms-and-conditions');
        });
    }
    
    
});
Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/profile', [ProfileController::class, 'view'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.update');
    Route::post('/profile/password-update', [ProfileController::class, 'passwordUpdate'])->name('profile_password.update');
    Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout/{order}', [CheckoutController::class, 'checkoutOrder'])->name('cart.checkout-order');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');
    Route::get('/orders', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/{order}', [OrderController::class, 'view'])->name('order.view');
});

Route::post('/webhook/stripe', [CheckoutController::class, 'webhook']);

require __DIR__.'/auth.php';
