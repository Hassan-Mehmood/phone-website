<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Dashboards\DashboardController;
use App\Http\Controllers\DevicesController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Order\DueOrderController;
use App\Http\Controllers\Order\OrderCompleteController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\OrderPendingController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\ExpenseCategory\ExpenseCategoryController;
use App\Http\Controllers\PhoneRepairController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductExportController;
use App\Http\Controllers\Product\ProductImportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\repairParts\RepairPartsController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Email\EmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
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

Route::get('php/', function () {
	return phpinfo();
});

Route::get('/', function () {
	if (Auth::check()) {
		return redirect('/dashboard');
	}
	return redirect('/login');
});

Route::middleware(['auth', 'verified'])->group(function () {

	Route::get('dashboard/', [DashboardController::class, 'index'])->name('dashboard');

	// User Management
	// Route::resource('/users', UserController::class); //->except(['show']);
	Route::put('/user/change-password/{username}', [UserController::class, 'updatePassword'])->name('users.updatePassword');

	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::get('/profile/settings', [ProfileController::class, 'settings'])->name('profile.settings');
	Route::get('/profile/store-settings', [ProfileController::class, 'store_settings'])->name('profile.store.settings');
	Route::post('/profile/store-settings', [ProfileController::class, 'store_settings_store'])->name('profile.store.settings.store');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	// Route::resource('/quotations', QuotationController::class);
	Route::resource('/customers', CustomerController::class);
	Route::resource('/suppliers', SupplierController::class);
	Route::resource('/categories', CategoryController::class);
	Route::resource('/subcategories', SubCategoryController::class);
	Route::resource('/units', UnitController::class);
	Route::resource('/phone-repairs', PhoneRepairController::class);
	Route::resource('/repair-parts', RepairPartsController::class);
	Route::resource('/devices', DevicesController::class);

	// Route Products
	Route::get('products/import/', [ProductImportController::class, 'create'])->name('products.import.view');
	Route::post('products/import/', [ProductImportController::class, 'store'])->name('products.import.store');
	Route::get('products/export/', [ProductExportController::class, 'create'])->name('products.export.store');
	Route::resource('/products', ProductController::class);

	// Route POS
	Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
	Route::post('/pos/cart/add', [PosController::class, 'addCartItem'])->name('pos.addCartItem');
	Route::post('/pos/cart/update/{rowId}', [PosController::class, 'updateCartItem'])->name('pos.updateCartItem');
	Route::delete('/pos/cart/delete/{rowId}', [PosController::class, 'deleteCartItem'])->name('pos.deleteCartItem');

	//Route::post('/pos/invoice', [PosController::class, 'createInvoice'])->name('pos.createInvoice');
	Route::post('invoice/create/', [InvoiceController::class, 'create'])->name('invoice.create');

	// Route Expenses Category
	Route::get('/expenses-category', [ExpenseCategoryController::class, 'index'])->name('expensescategory.index');
	Route::get('/expenses-category/create', [ExpenseCategoryController::class, 'create'])->name('expensescategory.create');
	Route::post('/expenses-category/store', [ExpenseCategoryController::class, 'store'])->name('expensescategory.store');
	Route::get('/expenses-category/view/{ExpenseCategory}', [ExpenseCategoryController::class, 'show'])->name('expensescategory.show');
	Route::get('/expenses-category/edit/{ExpenseCategory}', [ExpenseCategoryController::class, 'edit'])->name('expensescategory.edit');
	Route::put('/expenses-category/update/{ExpenseCategory}', [ExpenseCategoryController::class, 'update'])->name('expensescategory.update');
	Route::delete('/expenses-category/delete/{ExpenseCategory}', [ExpenseCategoryController::class, 'destroy'])->name('expensescategory.destroy');

	// Route Expenses
	Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
	Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
	Route::post('/expenses/store', [ExpenseController::class, 'store'])->name('expenses.store');
	Route::get('/expenses/view/{Expense}', [ExpenseController::class, 'show'])->name('expenses.show');
	Route::get('/expenses/edit/{Expense}', [ExpenseController::class, 'edit'])->name('expenses.edit');
	Route::put('/expenses/update/{Expense}', [ExpenseController::class, 'update'])->name('expenses.update');
	Route::delete('/expenses/delete/{Expense}', [ExpenseController::class, 'destroy'])->name('expenses.destroy');

	// Route Orders
	Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
	Route::get('/orders/pending', OrderPendingController::class)->name('orders.pending');
	Route::get('/orders/complete', OrderCompleteController::class)->name('orders.complete');

	Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
	Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

	// SHOW ORDER
	Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
	Route::put('/orders/update/{order}', [OrderController::class, 'update'])->name('orders.update');
	Route::delete('/orders/cancel/{order}', [OrderController::class, 'cancel'])->name('orders.cancel');

	// DUES
	Route::get('due/orders/', [DueOrderController::class, 'index'])->name('due.index');
	Route::get('due/order/view/{order}', [DueOrderController::class, 'show'])->name('due.show');
	Route::get('due/order/edit/{order}', [DueOrderController::class, 'edit'])->name('due.edit');
	Route::put('due/order/update/{order}', [DueOrderController::class, 'update'])->name('due.update');

	// TODO: Remove from OrderController
	Route::get('/orders/details/{order_id}/download', [OrderController::class, 'downloadInvoice'])->name('order.downloadInvoice');


	// Route Purchases
	Route::get('/purchases/approved', [PurchaseController::class, 'approvedPurchases'])->name('purchases.approvedPurchases');
	Route::get('/purchases/report', [PurchaseController::class, 'purchaseReport'])->name('purchases.purchaseReport');
	Route::get('/purchases/report/export', [PurchaseController::class, 'getPurchaseReport'])->name('purchases.getPurchaseReport');
	Route::post('/purchases/report/export', [PurchaseController::class, 'exportPurchaseReport'])->name('purchases.exportPurchaseReport');

	Route::get('/purchases', [PurchaseController::class, 'index'])->name('purchases.index');
	Route::get('/purchases/create', [PurchaseController::class, 'create'])->name('purchases.create');
	Route::post('/purchases', [PurchaseController::class, 'store'])->name('purchases.store');

	//Route::get('/purchases/show/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');
	Route::get('/purchases/{purchase}', [PurchaseController::class, 'show'])->name('purchases.show');

	//Route::get('/purchases/edit/{purchase}', [PurchaseController::class, 'edit'])->name('purchases.edit');
	Route::get('/purchases/{purchase}/edit', [PurchaseController::class, 'edit'])->name('purchases.edit');
	Route::post('/purchases/update/{purchase}', [PurchaseController::class, 'update'])->name('purchases.update');
	Route::delete('/purchases/delete/{purchase}', [PurchaseController::class, 'destroy'])->name('purchases.delete');

	Route::get('/send-welcome-email', [EmailController::class, 'sendWelcomeEmail']);

	/* for sending sms */

	Route::get('/sms-page', [SmsController::class, 'sms_page']);
	Route::post('/send-sms', [SmsController::class, 'send_sms'])->name('send.sms');
	// Route Quotations
	// Route::get('/quotations/{quotation}/edit', [QuotationController::class, 'edit'])->name('quotations.edit');
	// Route::post('/quotations/complete/{quotation}', [QuotationController::class, 'update'])->name('quotations.update');
	// Route::delete('/quotations/delete/{quotation}', [QuotationController::class, 'destroy'])->name('quotations.delete');
});

require __DIR__ . '/auth.php';

Route::get('test/', function () {
	return view('test');
});
