<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleInvoiceController;
use App\Http\Controllers\PurchaseInvoiceController;
use App\Http\Controllers\SalePaymentController;
use App\Http\Controllers\PurchasePaymentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\DebitNoteController;
use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReportController;

Route::resource('users', UserController::class);

Route::post('/credit_notes', [CreditNoteController::class, 'store'])->name('credit_notes.store');
Route::get('/credit_notes', [CreditNoteController::class, 'index'])->name('credit_notes.index');
Route::resource('purchase_payments', PurchasePaymentController::class);

Route::resource('debit_notes', DebitNoteController::class);
Route::get('/sale_invoices/{id}/download', [SaleInvoiceController::class, 'download'])->name('sale_invoices.download');

Route::get('/credit-notes/create', [CreditNoteController::class, 'create'])->name('credit-notes.create');

Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/sales', [ReportController::class, 'salesReport'])->name('reports.sales');
Route::get('/reports/purchases', [ReportController::class, 'purchaseReport'])->name('reports.purchases');
Route::get('/reports/stock', [ReportController::class, 'stockReport'])->name('reports.stock');
Route::get('/reports/financial', [ReportController::class, 'financialReport'])->name('reports.financial');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});


Route::resource('products', ProductController::class);
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::resource('credit_notes', CreditNoteController::class);

Route::resource('debit_notes', DebitNoteController::class);

Route::get('/credit-notes', [CreditNoteController::class, 'index'])->name('credit-notes.index');
Route::get('/credit-notes/create', [CreditNoteController::class, 'create'])->name('credit-notes.create');
Route::post('/credit-notes', [CreditNoteController::class, 'store'])->name('credit-notes.store');

Route::resource('categories', CategoriesController::class);
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');
Route::get('/sale_invoices', [SaleInvoiceController::class, 'index'])->name('sale_invoices.index');
Route::get('/admin', [AdminController::class, 'index'])->middleware('role:Admin');
Route::get('/sales', [SalesController::class, 'index'])->middleware('role:Sales');
Route::get('/sale_invoices/pdf/{id}', [SaleInvoiceController::class, 'generatePDF'])->name('sale_invoices.pdf');
Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
Route::post('/settings/update', [SettingsController::class, 'update'])->name('settings.update');

Route::resource('users', UserController::class);

Route::delete('products/{product}', [ProductController::class, 'destroy'])
     ->name('products.destroy');

Route::resource('users', UserController::class);

Route::resource('sales-payments', SalePaymentController::class);

Route::resource('purchase-payments', PurchasePaymentController::class);

Route::resource('sale-payments', SalePaymentController::class);
Route::resource('roles', RoleController::class);
Route::get('/sale-payments', [SalePaymentController::class, 'index'])->name('sale-payments.index');
Route::resource('purchase-invoices', PurchaseInvoiceController::class);
Route::post('/payments/store', [SalePaymentController::class, 'store'])->name('payments.store');


Route::get('/sale-payments/create', [SalePaymentController::class, 'create'])->name('sale_payments.create');
Route::post('/sale-payments/store', [SalePaymentController::class, 'store'])->name('sale_payments.store');

Route::get('/purchase-payments/create', [PurchasePaymentController::class, 'create'])->name('purchase_payments.create');
Route::post('/purchase-payments/store', [PurchasePaymentController::class, 'store'])->name('purchase_payments.store');


Route::resource('sale_payments', SalePaymentController::class);

Route::get('/sale_invoices/{id}/pdf', [SaleInvoiceController::class, 'pdf'])->name('sale_invoices.pdf');

Route::get('/purchase_invoices/{id}/pdf', [PurchaseInvoiceController::class, 'pdf'])->name('purchase_invoices.pdf');

Route::get('/purchase_invoices/{id}/edit', [PurchaseInvoiceController::class, 'edit'])->name('purchase_invoices.edit');
Route::put('/purchase_invoices/{id}', [PurchaseInvoiceController::class, 'update'])->name('purchase_invoices.update');

Route::resource('purchase_invoices', PurchaseInvoiceController::class);
Route::delete('/purchase_invoices/{id}', [PurchaseInvoiceController::class, 'destroy'])->name('purchase_invoices.destroy');

Route::resource('sale_invoices', SaleInvoiceController::class);
Route::resource('sales', SalesController::class);

Route::get('/purchase_invoices/{id}', [PurchaseInvoiceController::class, 'show'])->name('purchase_invoices.show');

Route::get('/sale_invoices/{id}/edit', [SaleInvoiceController::class, 'edit'])->name('sale_invoices.edit');
Route::put('/sale-invoices/{sale_invoice}', [SaleInvoiceController::class, 'update'])->name('sale_invoices.update');

Route::get('sale_invoices/{id}', [SaleInvoiceController::class, 'show'])->name('sale_invoices.show');

Route::get('sale_invoices/{id}/pdf', [SaleInvoiceController::class, 'generatePDF'])->name('sale_invoices.pdf');

Route::resource('sale_invoices', SaleInvoiceController::class);


Route::resource('products', ProductController::class);


Route::resource('products', ProductController::class);


Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


Route::get('/', function () {
    return view('welcome');
});
Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
Route::resource('customers', CustomerController::class);
Route::resource('suppliers', SupplierController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
