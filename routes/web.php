<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\ReviewController;

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
    Route::get('/', function () {
        return view('underconstruction');
    });
    Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);
    Route::get('/home',[WelcomeController::class, 'index'])->name('welcome');
    
    // Search
    Route::get('/search', [SearchController::class, 'search'])->name('search');
    
    // Beneficios de Publicar en el Vocerito
    Route::get('/beneficios-de-publicar-en-el-vocerito', function (){
        return view('about/beneficios_de_publicar');
    });

    // Un poco de historia
    Route::get('/un-poco-de-historia', function (){
        return view('about/un_poco_de_historia');
    });

    
    // Política de Privacidad
    Route::get('/legal/politica-de-privacidad', function (){
        return view('legal/privacy-policy');
        });
    Route::get('/legal/terminos-y-condiciones', function (){
        return view('legal/terms-and-conditions');
        });
            
    //Faqs
    Route::get('/preguntas-frecuentes', [FaqController::class, 'index'])->name('faq.index');
    
    // Cómo usar la guía
    Route::get('/como-usar-la-guia', [FaqController::class, 'comoUsarLaGuia'])->name('faq.comoUsarLaGuia');

    //News
    Route::get('/novedades', [ArticleController::class, 'index'])->name('news.index');
    Route::get('/novedades/{article:slug}', [ArticleController::class, 'view'])->name('news.view');
    
    // Anunciantes = Products
    Route::get('/anunciantes', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{category:slug}/{product:slug}', [ProductController::class, 'view'])->name('product.view');
    Route::get('/urgencias', [ProductController::class, 'urgencies'])->name('product.urgencies');

    // Categorías
    Route::get('/categorias', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/{category:slug}', [CategoriesController::class, 'view'])->name('categories.view');
    Route::get('/categorias/{category:slug}/{subcategory:slug}', [CategoriesController::class, 'viewSubcategory'])
    ->name('categories.view.subcategory');

    //Servicios
    Route::get('/servicios', [ServiceController::class, 'index'])->name('service.index');
    Route::get('/servicios/{service:slug}', [ServiceController::class, 'view'])->name('service.view');

    Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

    Route::get('/quotation', [QuotationController::class, 'create'])->name('quotation.create');
    Route::post('/quotation', [QuotationController::class, 'store'])->name('quotation.store');

    // Crear nueva review
    Route::post('/reviews', [ReviewController::class, 'store']);
    // Verificar review por email
    Route::get('/reviews/verify/{token}', [ReviewController::class, 'verify']);
    // Listar reviews publicadas para un producto
    Route::get('/products/{product}/reviews', [ReviewController::class, 'publicReviews']);
    // Promedio de ratings para un producto
    Route::get('/products/{product}/rating-average', [ReviewController::class, 'averageRating']);
    
    Route::get('/documentation/js/carga-de-scripts', function(){
        return view('documentation/js/carga-de-scripts');
    });
    Route::get('/documentation/php/exportacion-archivos-a-excel', function(){
        return view('documentation/php/exportacion-archivos-a-excel');
    });
    Route::get('/documentation/php/cookie-productos-vistos-recientemente', function(){
        return view('documentation/php/cookie-productos-vistos-recientemente');
    });

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
    // Listar reviews pendientes de publicación
    Route::get('/admin/reviews', [ReviewController::class, 'adminIndex']);
    // Publicar una review
    Route::post('/admin/reviews/{id}/publish', [ReviewController::class, 'publish']);
    // Responder a una review
    Route::post('/admin/reviews/{id}/respond', [ReviewController::class, 'respond']);
});

Route::post('/webhook/stripe', [CheckoutController::class, 'webhook']);

require __DIR__.'/auth.php';
