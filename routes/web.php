<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FashionBizController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

require __DIR__ . '/auth.php';

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

// Route::view('/', 'app')->name('home');
Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/install', [HomeController::class,'install'])->name('install');
Route::get('/token', [HomeController::class,'token'])->name('token');

Route::get('store/settings', [StoreController::class, 'settings'])->name('store.settings');
Route::post('store/settings', [StoreController::class, 'updateSettings'])->name('store.setting-update');

// Route::middleware('auth')->group(function () {

Route::get('products/sync', [ProductController::class, 'sync'])->name('products-sync');
Route::get('product/sync', [ProductController::class, 'shopifyUpdate'])->name('product-sync');


Route::resource('products', ProductController::class)->names([
    'index' => 'products.index',
    'edit' => 'products.edit',
    'show' => 'products.show',
    'delete' => 'products.delete',
]);
    // Route::get('products', [ProductController::class, 'index'])->name('products');
    // Route::delete('product/delete', [ProductController::class, 'destroy'])->name('product.delete');
    // // Route::resource('category', CategoryController::class);
    Route::resource('roles', RoleController::class)->names([
        'index' => 'roles.index',
        'edit' => 'roles.edit',
        'show' => 'roles.show',
        'delete' => 'roles.delete',
    ]);
    Route::resource('users', UserController::class)->names([
        'index' => 'users.index',
        'edit' => 'users.edit',
        'show' => 'users.show',
        'delete' => 'users.delete',
    ]);

    // Route::get('collections/sync', [CollectionController::class, 'sync'])->name('collections-sync');
    // Route::get('collections', [CollectionController::class, 'index'])->name('collections');

    // Settings

    // Route::get('/', function () {
    //     return redirect()->route('products.index');
    // })->name('home');

// });

//bang Product route
// Route::resource('bangproducts',BangProductController::class);
//import product view page
// Route::view('categorys/import_products', 'categorys/import_products')->name('import_products');
// //route update stock cantroller
Route::get('update_stock', [ProductController::class, 'update_stock'])->name('update_stock');
// //route product update cantroller
// Route::get('product_update', [ProductController::class, 'product_update'])->name('product_update');


// // Route::get('/add_payment', 'StoreController@addPayment')->name('payment.add');
// // Route::get('/payment_callback', 'StoreController@paymentCallback')->name('payment.callback');

// Route::resource('fashionbiz', FashionBizController::class);
// Route::get('style/product_qty', [FashionBizController::class, 'product_qty'])->name('product_qty');

// Payments
// Route::get('payment/callback', 'PaymentController@callback')->name('payment.callback');
// Route::resource('payment', PaymentController::class);


// Route::get('customers', [CustomerController::class, 'index'])->name('customers');
// Route::get('customers/sync', [CustomerController::class, 'sync'])->name('customers-sync');
Route::get('add_order', [OrderController::class, 'addOrder'])->name('add-orders');

//ch order CANTROLLER create
// Route::get('createOrder', 'OrderController@createOrder')->name('createOrder');
Route::get('orders', 'OrderController@index')->name('orders');
// Route::get('orders/sync', 'OrderController@sync')->name('orders-sync');


Route::prefix('webhooks')->group(function () {


    // Route::post('customers/create', [CustomerController::class, 'createForWebHook'])->name('webhook-customers-create');
    // Route::post('customers/update', [CustomerController::class, 'updateForWebHook'])->name('webhook-customers-update');
    // Route::post('customers/delete', [CustomerController::class, 'deleteForWebHook'])->name('webhook-customers-create');

    Route::post('orders/create', [OrderController::class, 'createForWebHook'])->name('webhook-orders-create-1');
    Route::post('orders/update', [OrderController::class, 'updateForWebHook'])->name('webhook-orders-update');
    Route::post('orders/delete', [OrderController::class, 'deleteForWebHook'])->name('webhook-orders-create');

    // Route::post('collections/create', [CollectionController::class, 'createForWebHook'])->name('webhook-collections-create');
    // Route::post('collections/update', [CollectionController::class, 'updateForWebHook'])->name('webhook-collections-update');
    // Route::post('collections/delete', [CollectionController::class, 'deleteForWebHook'])->name('webhook-collections-delete');

    // Route::post('products/create', [ProductController::class, 'createForWebHook'])->name('webhook-products-create');
    // Route::post('products/update', [ProductController::class, 'updateForWebHook'])->name('webhook-products-update');
    // Route::post('products/delete', [ProductController::class, 'deleteForWebHook'])->name('webhook-products-delete');
});


// GDPR Mandatory webhooks
Route::post('/shop_redact', [HomeController::class, 'gdprWebhook']);
Route::post('/customers_redact', [HomeController::class, 'gdprWebhook']);
Route::post('/customers_data', [HomeController::class, 'gdprWebhook']);
