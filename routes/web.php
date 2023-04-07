<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Admin;
use App\Models\Invoice;
use App\Models\ProductDescription;
use App\Models\PurchaseOrder;
use App\Models\QuoteRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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

Route::redirect('/', 'admin/dashboard', 301);
Route::redirect('admin', 'admin/dashboard', 301);
Route::redirect('dashboard', 'admin/dashboard', 301);


Route::prefix('admin')->middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', Admin\Dashboard::class)->name('admin.dashboard');
    Route::get('/settings', Admin\Settings::class)->name('admin.settings');

    // Roles
    Route::middleware('permission:Read Roles')->prefix('roles')->group(function () {
        Route::get('/', Admin\Roles\Index::class)->name('admin.roles.index');
        Route::get('/create', Admin\Roles\Create::class)->name('admin.roles.create');
        Route::get('/{id}/edit', Admin\Roles\Edit::class)->name('admin.roles.edit');
    });
    // // Permissions
    // Route::middleware('permission:Read Permissions')->prefix('permissions')->group(function () {
    //     Route::get('/', Admin\Permissions\Index::class)->name('admin.permissions.index');
    //     Route::get('/create', Admin\Permissions\Create::class)->name('admin.permissions.create');
    //     Route::get('/{id}/edit', Admin\Permissions\Edit::class)->name('admin.permissions.edit');
    // });
    // Users
    Route::middleware('permission:Read Users')->prefix('users')->group(function () {
        Route::get('/', Admin\Users\Index::class)->name('admin.users.index');
        Route::get('/create', Admin\Users\Create::class)->name('admin.users.create');
        Route::get('/{id}/edit', Admin\Users\Edit::class)->name('admin.users.edit');
    });
    // Departments
    Route::middleware('permission:Read Departments')->prefix('departments')->group(function () {
        Route::get('/', Admin\Departments\Index::class)->name('admin.departments.index');
        Route::get('/create', Admin\Departments\Create::class)->name('admin.departments.create');
        Route::get('/{id}/edit', Admin\Departments\Edit::class)->name('admin.departments.edit');
    });
    // Brands
    Route::middleware('permission:Read Brands')->prefix('brands')->group(function () {
        Route::get('/', Admin\Brands\Index::class)->name('admin.brands.index');
        Route::get('/create', Admin\Brands\Create::class)->name('admin.brands.create');
        Route::get('/{id}/edit', Admin\Brands\Edit::class)->name('admin.brands.edit');
    });
    // Suppliers
    Route::middleware('permission:Read Suppliers')->prefix('suppliers')->group(function () {
        Route::get('/', Admin\Suppliers\Index::class)->name('admin.suppliers.index');
        Route::get('/create', Admin\Suppliers\Create::class)->name('admin.suppliers.create');
        Route::get('/{id}/edit', Admin\Suppliers\Edit::class)->name('admin.suppliers.edit');
    });
    // UnitTypes
    Route::middleware('permission:Read Unit Types')->prefix('unit-types')->group(function () {
        Route::get('/', Admin\UnitTypes\Index::class)->name('admin.unit-types.index');
        Route::get('/create', Admin\UnitTypes\Create::class)->name('admin.unit-types.create');
        Route::get('/{id}/edit', Admin\UnitTypes\Edit::class)->name('admin.unit-types.edit');
    });
    // Units
    Route::middleware('permission:Read Units')->prefix('units')->group(function () {
        Route::get('/', Admin\Units\Index::class)->name('admin.units.index');
        Route::get('/create', Admin\Units\Create::class)->name('admin.units.create');
        Route::get('/{id}/edit', Admin\Units\Edit::class)->name('admin.units.edit');
    });
    // Product Categories
    Route::middleware('permission:Read Product Categories')->prefix('product-categories')->group(function () {
        Route::get('/', Admin\ProductCategories\Index::class)->name('admin.product-categories.index');
        Route::get('/create', Admin\ProductCategories\Create::class)->name('admin.product-categories.create');
        Route::get('/{id}/edit', Admin\ProductCategories\Edit::class)->name('admin.product-categories.edit');
    });
    // Product Descriptions
    Route::middleware('permission:Read Product Descriptions')->prefix('product-descriptions')->group(function () {
        Route::get('/', Admin\ProductDescriptions\Index::class)->name('admin.product-descriptions.index');
        Route::get('/create', Admin\ProductDescriptions\Create::class)->name('admin.product-descriptions.create');
        Route::get('/{id}/edit', Admin\ProductDescriptions\Edit::class)->name('admin.product-descriptions.edit');
        Route::get('/{id}/show', Admin\ProductDescriptions\Show::class)->name('admin.product-descriptions.show');
        Route::get('/stock-sheet', function(){
            $products = ProductDescription::all();

            $stock_sheet = Pdf::loadView('documents.stock-sheet',[
                'products'=>$products
            ]);

            return $stock_sheet->download('stock-sheet-'.Carbon::now()->toDateTimeString().'.pdf');
            // return $stock_sheet->stream();
        })->name('admin.product-descriptions.stock-sheet');
    });
    // Product Items
    // Route::middleware('permission:Read Product Items')->prefix('product-items')->group(function () {
    //     Route::get('/', Admin\ProductItems\Index::class)->name('admin.product-items.index');
    //     Route::get('/create', Admin\ProductItems\Create::class)->name('admin.product-items.create');
    //     Route::get('/{id}/edit', Admin\ProductItems\Edit::class)->name('admin.product-items.edit');
    // });
    // Payment Methods
    Route::middleware('permission:Read Payment Methods')->prefix('payment-methods')->group(function () {
        Route::get('/', Admin\PaymentMethods\Index::class)->name('admin.payment-methods.index');
        Route::get('/create', Admin\PaymentMethods\Create::class)->name('admin.payment-methods.create');
        Route::get('/{id}/edit', Admin\PaymentMethods\Edit::class)->name('admin.payment-methods.edit');
    });

    // // Sales Payments
    // Route::middleware('permission:Read Admins')->prefix('sales-payments')->group(function () {
    //     Route::get('/', Admin\SalesPayments\Index::class)->name('admin.sales-payments.index');
    //     Route::get('/create', Admin\SalesPayments\Create::class)->name('admin.sales-payments.create');
    //     Route::get('/{id}/edit', Admin\SalesPayments\Edit::class)->name('admin.sales-payments.edit');
    // });

    // Purchase Payments
    Route::middleware('permission:Read Purchase Payments')->prefix('purchase-payments')->group(function () {
        Route::get('/', Admin\PurchasePayments\Index::class)->name('admin.purchase-payments.index');
        Route::get('/create', Admin\PurchasePayments\Create::class)->name('admin.purchase-payments.create');
        Route::get('/{id}/edit', Admin\PurchasePayments\Edit::class)->name('admin.purchase-payments.edit');
    });
    // Quotation Requests
    Route::prefix('quotation-requests')->group(function () {
        Route::get('/', Admin\QuoteRequests\Index::class)->name('admin.quotation-requests.index');
        Route::get('/create', Admin\QuoteRequests\Create::class)->name('admin.quotation-requests.create');
        Route::get('/{id}/edit', Admin\QuoteRequests\Edit::class)->name('admin.quotation-requests.edit');
        Route::get('/{id}/show', Admin\QuoteRequests\Show::class)->name('admin.quotation-requests.show');
        Route::get('/{id}/quote-request', function($id){
            $pdf = Pdf::loadView('documents.quote-request', [
                'quoteRequest' => QuoteRequest::find($id)
            ]);

            $date = Carbon::parse(QuoteRequest::find($id)->created_at)->toDateString();
            return $pdf->download($date . '- RFQ#' . $id . '.pdf');
        })->name('admin.quotation-requests.generate');
    });
    // Quotations
    Route::middleware('permission:Read Quotations')->prefix('quotations')->group(function () {
        Route::get('/', Admin\Quotations\Index::class)->name('admin.quotations.index');
        Route::get('/create', Admin\Quotations\Create::class)->name('admin.quotations.create');
        Route::get('/{id}/edit', Admin\Quotations\Edit::class)->name('admin.quotations.edit');
    });
    // // Invoices
    // Route::middleware('permission:Read Admins')->prefix('invoices')->group(function () {
    //     Route::get('/', Admin\Invoices\Index::class)->name('admin.invoices.index');
    //     Route::get('/create', Admin\Invoices\Create::class)->name('admin.invoices.create');
    //     Route::get('/{id}/show', function ($id) {
    //         $pdf = Pdf::loadView('documents.invoice', [
    //             'invoice' => Invoice::find($id)
    //         ]);

    //         $date = Carbon::parse(Invoice::find($id)->created_at)->toDateString();
    //         return $pdf->download($date . '-Invoice#' . $id . '.pdf');
    //     })->name('admin.invoices.show');
    // });
    // Purchases
    Route::middleware('permission:Read Purchases')->prefix('purchases')->group(function () {
        Route::get('/', Admin\Purchases\Index::class)->name('admin.purchases.index');
        Route::get('/create', Admin\Purchases\Create::class)->name('admin.purchases.create');
        Route::get('/{id}/edit', Admin\Purchases\Edit::class)->name('admin.purchases.edit');
        Route::get('/{id}/show', Admin\Purchases\Show::class)->name('admin.purchases.show');
    });
    // Sales
    Route::middleware('permission:Read Admins')->prefix('sales')->group(function () {
        Route::get('/', Admin\Sales\Index::class)->name('admin.sales.index');
        Route::get('/create', Admin\Sales\Create::class)->name('admin.sales.create');
        Route::get('/{id}/edit', Admin\Sales\Edit::class)->name('admin.sales.edit');
        Route::get('/{id}/show', Admin\Sales\Show::class)->name('admin.sales.show');
    });
    // // Dispatches
    // Route::middleware('permission:Read Dispatches')->prefix('dispatches')->group(function () {
    //     Route::get('/', Admin\Dispatches\Index::class)->name('admin.dispatches.index');
    //     Route::get('/create', Admin\Dispatches\Create::class)->name('admin.dispatches.create');
    //     Route::get('/{id}/edit', Admin\Dispatches\Edit::class)->name('admin.dispatches.edit');
    //     Route::get('/{id}/show', Admin\Dispatches\Show::class)->name('admin.dispatches.show');
    // });

    // Purchase Orders
    Route::middleware('permission:Read Quotations')->prefix('purchase_orders')->group(function () {
        Route::get('/', Admin\PurchaseOrders\Index::class)->name('admin.purchase-orders.index');
        Route::get('/create', Admin\PurchaseOrders\Create::class)->name('admin.purchase-orders.create');
        Route::get('/{id}/edit', Admin\PurchaseOrders\Edit::class)->name('admin.purchase-orders.edit');
        Route::get('/{id}/show', Admin\PurchaseOrders\Show::class)->name('admin.purchase-orders.show');
        Route::get('/{id}/order', function ($id) {
            $pdf = Pdf::loadView('documents.purchase-order', [
                'order' => PurchaseOrder::find($id)
            ]);

            $date = Carbon::parse(PurchaseOrder::find($id)->created_at)->toDateString();
            return $pdf->download($date . '-LPO#' . $id . '.pdf');
        })->name('admin.purchase-orders.order');
    });
});
