<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\HomeHeroBannerController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\AlergenController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'getUser']);
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);

    Route::apiResource('homeherobanners', HomeHeroBannerController::class);
    Route::apiResource('categories', CategoryController::class)->except('show');
    Route::get('/categories/tree', [CategoryController::class, 'getAsTree']);
    Route::get('/export-categories', [CategoryController::class, 'exportCategories']);
    Route::apiResource('products', ProductController::class);
    Route::get('/export-products', [ProductController::class, 'exportProducts']);
    Route::apiResource('articles', ArticleController::class);
    Route::apiResource('authors', AuthorController::class)->except('show');
    Route::get('/authors/tree', [AuthorController::class, 'getAsTree']);
    Route::apiResource('alergens', AlergenController::class)->except('show');
    Route::get('/alergens/tree', [AlergenController::class, 'getAsTree']);
    Route::apiResource('services', ServiceController::class)->except('show');
    Route::get('/services/tree', [ServiceController::class, 'getAsTree']);
    Route::apiResource('tags', TagController::class)->except('show');
    Route::get('/tags/tree', [TagController::class, 'getAsTree']);
    Route::get('/export-tags', [TagController::class, 'exportTags']);
    Route::apiResource('clients', ClientController::class)->except('show');
    Route::get('/clients/tree', [ClientController::class, 'getAsTree']);
    Route::apiResource('projects', ProjectController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::get('/countries', [CustomerController::class, 'countries']);
    Route::get('orders', [OrderController::class, 'index']);
    Route::get('orders/statuses', [OrderController::class, 'getStatuses']);
    Route::post('orders/change-status/{order}/{status}', [OrderController::class, 'changeStatus']);
    Route::get('orders/{order}', [OrderController::class, 'view']);

    // Dashboard Routes
    Route::get('/dashboard/customers-count', [DashboardController::class, 'activeCustomers']);
    Route::get('/dashboard/total-products-count', [DashboardController::class, 'totalProducts']);
    Route::get('/dashboard/active-products-count', [DashboardController::class, 'activeProducts']);
    Route::get('/dashboard/latest-products', [DashboardController::class, 'latestProducts']);
    Route::get('/dashboard/active-categories-count', [DashboardController::class, 'activeCategories']);
    Route::get('/dashboard/popular-categories', [DashboardController::class, 'popularCategories']);
    Route::get('/dashboard/orders-count', [DashboardController::class, 'paidOrders']);
    Route::get('/dashboard/income-amount', [DashboardController::class, 'totalIncome']);
    Route::get('/dashboard/orders-by-country', [DashboardController::class, 'ordersByCountry']);
    Route::get('/dashboard/latest-customers', [DashboardController::class, 'latestCustomers']);
    Route::get('/dashboard/latest-orders', [DashboardController::class, 'latestOrders']);

    // Report routes
    Route::get('/report/orders', [ReportController::class, 'orders']);
    Route::get('/report/customers', [ReportController::class, 'customers']);
});

Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('authors', AuthorController::class)->only(['index', 'show']);
Route::get('/categories/{category:slug}/products', [ProductController::class, 'productsByCategory']);
Route::get('categories/{category}/products', [ProductController::class, 'productsByCategory'])->name('category.products');
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);