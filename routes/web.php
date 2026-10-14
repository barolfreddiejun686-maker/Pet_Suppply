<?php




use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/', function () {
    return view('welcome');
});

Route::get('/', DashboardController::class)->name('dashboard');

Route::resource('products', ProductController::class)->except('show');
Route::resource('categories', CategoryController::class)->except('show');
Route::resource('brands', BrandController::class)->except('show');
Route::resource('suppliers', SupplierController::class)->except('show');

// Transactions are records: view/create/delete (delete reverses the stock change).
Route::resource('transactions', TransactionController::class)
    ->only(['index', 'create', 'store', 'show', 'destroy']);