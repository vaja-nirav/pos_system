<?php

use App\Http\Controllers\Web\Brand\BrandController;
use App\Http\Controllers\Web\Category\CategoryController;
use App\Http\Controllers\Web\Customer\CustomerController;
use App\Http\Controllers\Web\Deshboard\DashboardController;
use App\Http\Controllers\Web\Product\ProductController;
use App\Http\Controllers\Web\Purchase\PurchaseController;
use App\Http\Controllers\Web\PurchaseReturn\PurchaseReturnController;
use App\Http\Controllers\Web\Sale\SaleController;
use App\Http\Controllers\Web\SaleReturn\SaleReturnController;
use App\Http\Controllers\Web\Supplier\SupplierController;
use App\Http\Controllers\Web\Unit\UnitController;
use App\Http\Controllers\Web\Report\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Web\ExpenseCategory\ExpenseCategoryController;
use App\Http\Controllers\Web\Expense\ExpenseController;
use App\Http\Controllers\Web\POS\POSController;
use App\Http\Controllers\Web\Invoice\InvoiceController;
use App\Http\Controllers\Web\Barcode\BarcodeController;
use App\Http\Controllers\Web\Variation\VariationController;
use App\Http\Controllers\Web\User\UserController;
use App\Http\Controllers\Web\Role\RoleController;
use App\Http\Controllers\Web\Warehouse\WarehouseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

    // categories
    Route::resource('categories', CategoryController::class);

    // brands
    Route::resource('brands', BrandController::class);

    // units
    Route::resource('units', UnitController::class);

    // products
    Route::resource('products', ProductController::class);

    // variations
    Route::resource('variations', VariationController::class);

    // customers
    Route::resource('customers', CustomerController::class);

    // users
    Route::resource('users', UserController::class)->except(['show']);

    // roles
    Route::resource('roles', RoleController::class)->except(['show']);

    // warehouses
    Route::resource('warehouses', WarehouseController::class);

    // suppliers
    Route::resource('suppliers', SupplierController::class);

    // purchases
    Route::resource('purchases', PurchaseController::class);

    // sales
    Route::resource('sales', SaleController::class);

    Route::prefix('reports')->group(function () {
        Route::get('/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
        Route::get('/purchases', [ReportController::class, 'purchaseReport'])->name('reports.purchases');
        Route::get('/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
        Route::get('/profit', [ReportController::class, 'profitReport'])->name('reports.profit');
    });

    // expense categories
    Route::resource('expense-categories', ExpenseCategoryController::class);

    // expenses
    Route::resource('expenses',ExpenseController::class);

    // pos
    Route::get('/pos', [POSController::class,'index'])->name('pos.index');
    Route::post('/pos/store', [POSController::class,'store'])->name('pos.store');

    // invoice
    Route::get('/invoice/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::get('/invoice/{id}/pdf', [InvoiceController::class, 'pdf'])->name('invoice.pdf');

    // barcode
    Route::get('/products/{id}/barcode',[BarcodeController::class,'show'])->name('products.barcode');

    // purchase-returns
    Route::get('purchase-returns/create/{purchase}', [PurchaseReturnController::class, 'create'])->name('purchase-returns.create');
    Route::resource('purchase-returns', PurchaseReturnController::class)->except(['create']);

    // sale-returns
    Route::get('sale-returns/create/{sale}', [SaleReturnController::class, 'create'])->name('sale-returns.create');
    Route::resource('sale-returns', SaleReturnController::class)->except(['create']);

});

require __DIR__ . '/auth.php';
