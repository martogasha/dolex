<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\MpesaController;
use App\Http\Controllers\QuotationController;
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


Route::get('home', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
//client side routes
Route::get('/', [IndexController::class, 'index']);

//admin routes
Route::get('admin', [AdminController::class, 'admin']);
Route::get('disableC/{id}', [AdminController::class, 'disablePppoeSecret']);
Route::get('getPppoeProfiles', [AdminController::class, 'getPppoeProfiles']);
Route::get('storePppoe', [AdminController::class, 'storePppoe']);
Route::get('createInvoice', [AdminController::class, 'cInvoice']);
Route::get('editUser/{id}', [AdminController::class, 'editUser']);
Route::post('editEmployee/{id}', [AdminController::class, 'editEmployee'])->name('editEmployee');
Route::get('editCustomerDetail/{id}', [AdminController::class, 'editCustomerDetail'])->name('editCustomerDetail');
Route::post('activate', [AdminController::class, 'activate']);
Route::post('noneActive', [AdminController::class, 'noneActive']);
Route::post('resetUser/{id}', [AdminController::class, 'resetUser'])->name('resetUser');
Route::post('editC/{id}', [AdminController::class, 'editC'])->name('editC');
Route::post('deleteUser', [AdminController::class, 'deleteUser'])->name('deleteUser');
Route::post('deleteC', [AdminController::class, 'deleteC'])->name('deleteC');
Route::post('Login', [AuthController::class, 'login'])->name('Login');
Route::get('customers', [AdminController::class, 'customers']);
Route::get('Selectcustomers', [AdminController::class, 'Selectcustomers']);
Route::get('noneActivecustomers', [AdminController::class, 'noneActivecustomers']);
Route::get('pppoe', [AdminController::class, 'pppoe']);
Route::get('profile', [AdminController::class, 'profile']);
Route::post('editProfile/{id}', [AdminController::class, 'editProfile']);
Route::get('addCustomer', [AdminController::class, 'addCustomer']);
Route::post('filterInvoice', [AdminController::class, 'filterInvoice']);
Route::post('filterMpesa', [AdminController::class, 'filterMpesa']);
Route::get('addProduct', [AdminController::class, 'addProduct']);
Route::get('del', [AdminController::class, 'del']);
Route::get('delC', [AdminController::class, 'delC']);
Route::get('delE', [AdminController::class, 'delE']);
Route::get('delP', [AdminController::class, 'delP']);
Route::get('getReceipt/{id}', [AdminController::class, 'getReceipt']);
Route::get('cashReceipt/{id}', [AdminController::class, 'cashReceipt']);
Route::get('mpesaReceipt/{id}', [AdminController::class, 'mpesaReceipt']);
Route::get('addEmployee', [AdminController::class, 'addEmployee']);
Route::get('employees', [AdminController::class, 'employees']);
Route::get('addCash', [AdminController::class, 'addCash']);
Route::get('addMpesa', [AdminController::class, 'addMpesa']);
Route::get('bill', [AdminController::class, 'bill']);
    Route::get('autoBill', [AdminController::class, 'autoBill']);
Route::get('getQProducts', [AdminController::class, 'getQProducts']);
Route::get('getIProducts', [AdminController::class, 'getIProducts']);
Route::post('billing', [AdminController::class, 'billing'])->name('billing');
Route::post('billingEach', [AdminController::class, 'billingEach'])->name('billingEach');
Route::post('editQProduct', [AdminController::class, 'editQProduct'])->name('editQProduct');
Route::post('editIProduct', [AdminController::class, 'editIProduct'])->name('editIProduct');
Route::post('notice', [AdminController::class, 'notice'])->name('notice');
Route::post('deleteNotice/{id}', [AdminController::class, 'deleteNotice']);
Route::get('deletePro', [AdminController::class, 'deletePro']);
Route::get('receipt/{id}', [AdminController::class, 'receipt']);
Route::get('editProduct/{id}', [AdminController::class, 'editProduct']);
Route::get('pdf', [AdminController::class, 'pdf']);
Route::post('editProd/{id}', [AdminController::class, 'editProd']);
Route::get('ttt', [AdminController::class, 'ttt']);
Route::get('getUserInvoice', [AdminController::class, 'getUserInvoice']);
Route::get('products', [AdminController::class, 'product']);
Route::get('shop', [AdminController::class, 'shop']);
Route::get('cart', [IndexController::class, 'cart']);
Route::get('addByOne/{id}', [IndexController::class, 'addByOne']);
Route::get('cartReduceByOne/{id}', [IndexController::class, 'getReduceByOne']);
Route::get('cartRemove/{id}', [IndexController::class, 'removeItem']);
Route::get('checkout', [IndexController::class, 'checkout']);
Route::get('account', [IndexController::class, 'account']);
Route::post('storeCart', [IndexController::class, 'storeCart'])->name('storeCart');
Route::get('productDetail/{id}', [AdminController::class, 'productDetail']);
Route::post('storeProduct', [AdminController::class, 'storeProduct'])->name('storeProduct');
Route::post('makeCashPayment', [AdminController::class, 'makeCashPayment'])->name('makeCashPayment');
Route::post('makeMpesaPayment', [AdminController::class, 'makeMpesaPayment'])->name('makeMpesaPayment');
Route::post('storeEmployee', [AdminController::class, 'storeEmployee'])->name('storeEmployee');
Route::get('storeQuotation', [AdminController::class, 'storeQuotation']);
Route::get('storeInvoice', [AdminController::class, 'storeInvoice']);
Route::get('storeCustomer', [AdminController::class, 'storeCustomer']);
Route::get('storeCustomerOne', [AdminController::class, 'storeCustomerOne']);
Route::get('dueDate', [AdminController::class, 'dueDate']);
Route::get('updateDueDate', [AdminController::class, 'updateDueDate']);
Route::post('updateInvoiceDueDate', [AdminController::class, 'updateInvoiceDueDate']);
Route::get('getInvoiceId', [AdminController::class, 'getInvoiceId']);
Route::get('getInvoice', [AdminController::class, 'getInvoice']);
Route::get('invoicePayment/{id}', [AdminController::class, 'invoicePayment']);
Route::post('storeExpense', [AdminController::class, 'storeExpense']);
Route::get('customerDetail/{id}', [AdminController::class, 'customerDetail']);
Route::post('deleteQ/{id}', [AdminController::class, 'deleteQ']);
Route::get('downloadPdf', [AdminController::class, 'downloadPdf']);
Route::get('expenses', [AdminController::class, 'expenses']);
Route::get('viewQuotation', [AdminController::class, 'viewQuotation']);
Route::get('allQuotes', [AdminController::class, 'allQuotes']);
Route::get('expiredQuotes', [AdminController::class, 'expiredQuotes']);
Route::get('viewInvoice', [AdminController::class, 'viewInvoice']);
Route::get('currentDate', [AdminController::class, 'currentDate']);
Route::get('currentDat', [AdminController::class, 'currentDat']);
Route::get('allInvoices', [AdminController::class, 'allInvoices']);
Route::get('getAmount', [AdminController::class, 'getAmount']);
Route::get('quotes/{id}', [AdminController::class, 'quotes']);
Route::get('editQuotes', [AdminController::class, 'editQuotes']);
Route::get('editInv', [AdminController::class, 'editInv']);
Route::get('inv/{id}', [AdminController::class, 'inv']);
Route::post('invoice/{id}', [AdminController::class, 'invoice']);
Route::get('printInvoice/{id}', [AdminController::class, 'printInvoice']);
Route::get('quotation', [AdminController::class, 'quotation']);
Route::get('singleEstimate/{id}', [AdminController::class, 'singleEstimate']);
Route::get('singleInvoice/{id}', [AdminController::class, 'singleInvoice']);
Route::get('addExpense', [AdminController::class, 'addExpense']);
Route::get('editExpense/{id}', [AdminController::class, 'editExpense']);
Route::get('mpesaCustomer/{id}', [AdminController::class, 'mpesaCustomer']);
Route::post('eExpense/{id}', [AdminController::class, 'eExpense']);
Route::post('deleteExpense', [AdminController::class, 'deleteExpense']);
Route::post('deleteProduct', [AdminController::class, 'deleteProduct']);
Route::get('currentYear', [AdminController::class, 'currentYear']);
Route::get('ajax', [AdminController::class, 'ajax']);
Route::get('showMonth', [AdminController::class, 'showMonth']);
Route::get('mpesa', [MpesaController::class, 'index']);
Route::get('cash', [CashController::class, 'index']);
Route::get('test', [CashController::class, 'test']);
Route::post('testOne', [CashController::class, 'testOne']);

require __DIR__.'/auth.php';
