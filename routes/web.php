<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PurchaseController;


Route::get('/', fn() => redirect()->route('dashboard'));

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');

    Route::middleware(['role:owner,admin'])->group(function () {
            Route::resource('categories', CategoryController::class)->except(['show']);
            Route::resource('units', UnitController::class)->except(['show']);
            Route::resource('products', ProductController::class);
        }
        );

        Route::middleware(['role:owner,admin,cashier'])->group(function () {
            Route::get('/pos', [PosController::class , 'index'])->name('pos.index');
            Route::get('/pos/search', [PosController::class , 'search'])->name('pos.search');

            Route::post('/sales/checkout', [SaleController::class , 'checkout'])->name('sales.checkout');
        }
        );

        Route::middleware(['role:owner,admin'])->group(function () {
            Route::get('/sales', [SaleController::class , 'index'])->name('sales.index');
            Route::get('/sales/{sale}', [SaleController::class , 'show'])->name('sales.show');
            Route::get('/sales/{sale}/print', [SaleController::class , 'print'])->name('sales.print');
            Route::post('/sales/{sale}/void', [SaleController::class , 'void'])->name('sales.void');        }
        );
    
});

Route::get('/stock/opening', [StockController::class , 'openingForm'])->name('stock.opening.form');
Route::post('/stock/opening', [StockController::class , 'openingStore'])->name('stock.opening.store');

Route::get('/stock/in', [StockController::class , 'inForm'])->name('stock.in.form');
Route::post('/stock/in', [StockController::class , 'inStore'])->name('stock.in.store');

Route::get('/stock/out', [StockController::class , 'outForm'])->name('stock.out.form');
Route::post('/stock/out', [StockController::class , 'outStore'])->name('stock.out.store');

Route::get('/stock/opname', [StockController::class , 'opnameForm'])->name('stock.opname.form');
Route::post('/stock/opname', [StockController::class , 'opnameStore'])->name('stock.opname.store');

Route::get('/stock/card/{product}', [StockController::class , 'card'])->name('stock.card');


Route::resource('suppliers', SupplierController::class)->except(['show']);
Route::get('/purchases', [PurchaseController::class , 'index'])->name('purchases.index');
Route::get('/purchases/create', [PurchaseController::class , 'create'])->name('purchases.create');
Route::post('/purchases', [PurchaseController::class , 'store'])->name('purchases.store');
Route::get('/purchases/{purchase}', [PurchaseController::class , 'show'])->name('purchases.show');
Route::post('/purchases/{purchase}/void', [PurchaseController::class , 'void'])->name('purchases.void');

Route::get('/reports', [ReportController::class,'dashboard'])->name('reports.dashboard');
Route::get('/reports/sales-summary', [ReportController::class,'salesSummary'])->name('reports.sales_summary');
Route::get('/reports/best-sellers', [ReportController::class,'bestSellers'])->name('reports.best_sellers');
Route::get('/reports/profit', [ReportController::class,'profitSimple'])->name('reports.profit');
Route::get('/reports/low-stock', [ReportController::class,'lowStock'])->name('reports.low_stock');

Route::get('/reports/export/sales', [ReportController::class,'exportSalesCsv'])->name('reports.export_sales_csv');
Route::get('/reports/export/low-stock', [ReportController::class,'exportLowStockCsv'])->name('reports.export_low_stock_csv');




require __DIR__ . '/auth.php';
