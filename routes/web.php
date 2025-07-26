<?php

use App\Http\Controllers\BikesController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierInvoicesController;
use App\Http\Controllers\UploadFilesController;
use App\Http\Controllers\VouchersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pages\HomePage;
use App\Http\Controllers\pages\Page2;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;



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
/* Route::any('/register', function () {
  return view('auth.register');
}); */
// Main Page Route

// pages
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');

Route::middleware(['auth', 'web'])->group(function () {

  Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home-dashboard');

  Route::resource('items', App\Http\Controllers\ItemsController::class);

  Route::resource('users', App\Http\Controllers\UserController::class);
  Route::any('/user/profile', [App\Http\Controllers\UserController::class, 'profile'])->name('profile');
  Route::any('/user/services/{id}', [App\Http\Controllers\UserController::class, 'services'])->name('user_services');
  Route::resource('permissions', App\Http\Controllers\PermissionsController::class);
  Route::resource('roles', App\Http\Controllers\RolesController::class);

  Route::resource('bikes', App\Http\Controllers\BikesController::class);
  Route::any('bikes/assign_rider/{id?}', [BikesController::class, 'assign_rider'])->name('bikes.assign_rider');
  Route::get('bikes/contract/{id?}', [\App\Http\Controllers\BikesController::class, 'contract'])->name('bike.contract');
  Route::any('bikes/contract_upload/{id?}', [\App\Http\Controllers\BikesController::class, 'contract_upload'])->name('bike_contract_upload');
  Route::get('bikes/delete/{id}', [\App\Http\Controllers\BikesController::class, 'destroy'])->name('bikes.delete');


  Route::resource('customers', App\Http\Controllers\CustomersController::class);
  Route::get('customer/ledger/{id}', [\App\Http\Controllers\CustomersController::class, 'ledger'])->name('customer.ledger');
  Route::get('customer/files/{id}', [\App\Http\Controllers\CustomersController::class, 'files'])->name('customer.files');
  Route::get('customers/delete/{id}', [\App\Http\Controllers\CustomersController::class, 'destroy'])->name('customers.delete');


  Route::resource('rtaFines', App\Http\Controllers\RtaFinesController::class);
  Route::get('rtaFines/create/{id}', [\App\Http\Controllers\RtaFinesController::class, 'create'])->name('rtaFines.create');
  Route::any('rtaFines/attach_file/{id}', [\App\Http\Controllers\RtaFinesController::class, 'fileUpload'])->name('rtaFines.fileupload');
  Route::get('rtaFines/delete/{id}', [\App\Http\Controllers\RtaFinesController::class, 'destroy'])->name('rtaFines.delete');

    Route::post('accountcreate', [\App\Http\Controllers\RtaFinesController::class, 'accountcreate'])->name('rtaFines.accountcreate');
    Route::post('editaccount', [\App\Http\Controllers\RtaFinesController::class, 'editaccount'])->name('rtaFines.editaccount');
  Route::get('rtaFines/deleteaccount/{id}', [\App\Http\Controllers\RtaFinesController::class, 'deleteaccount'])->name('rtaFines.deleteaccount');
  Route::get('rtaFines/tickets/{id}', [\App\Http\Controllers\RtaFinesController::class, 'tickets'])->name('rtaFines.tickets');
  Route::get('rtaFines/payfine/{id}', [\App\Http\Controllers\RtaFinesController::class, 'payfine'])->name('rtaFines.payfine');
  Route::get('rtaFines/viewvoucher/{id}', [\App\Http\Controllers\RtaFinesController::class, 'viewvoucher'])->name('rtaFines.viewvoucher');
  Route::get('rtaFines/getrider/{id}',[\App\Http\Controllers\RtaFinesController::class, 'getrider']);

  Route::resource('sims', App\Http\Controllers\SimsController::class);
  Route::get('sims/delete/{id}', [\App\Http\Controllers\SimsController::class, 'destroy'])->name('sims.delete');
  /* Rider section starts from here */

  Route::resource('riders', App\Http\Controllers\RidersController::class);
  Route::any('riders/job_status/{id?}', [\App\Http\Controllers\RidersController::class, 'job_status'])->name('rider.job_status');
  Route::get('riders/timeline/{id?}', [\App\Http\Controllers\RidersController::class, 'timeline'])->name('rider.timeline');
  Route::get('riders/contract/{id?}', [\App\Http\Controllers\RidersController::class, 'contract'])->name('rider.contract');
  Route::any('riders/contract_upload/{id?}', [\App\Http\Controllers\RidersController::class, 'contract_upload'])->name('rider_contract_upload');
  Route::any('riders/picture_upload/{id?}', [\App\Http\Controllers\RidersController::class, 'picture_upload'])->name('rider_picture_upload');
  Route::any('riders/rider-document/{id}', [\App\Http\Controllers\RidersController::class, 'document'])->name('rider.document');
  Route::get('rider/updateRider', [\App\Http\Controllers\RidersController::class, 'updateRider'])->name('rider.updateRider');
  Route::get('rider/delete/{id}', [\App\Http\Controllers\RidersController::class, 'destroy'])->name('rider.delete');
  Route::get('riders/ledger/{id}', [\App\Http\Controllers\RidersController::class, 'ledger'])->name('rider.ledger');
  Route::get('riders/attendance/{id}', [\App\Http\Controllers\RidersController::class, 'attendance'])->name('rider.attendance');
  Route::get('riders/activities/{id}', [\App\Http\Controllers\RidersController::class, 'activities'])->name('rider.activities');
  Route::get('riders/invoices/{id}', [\App\Http\Controllers\RidersController::class, 'invoices'])->name('rider.invoices');
  Route::any('riders/sendemail/{id}', [\App\Http\Controllers\RidersController::class, 'sendEmail'])->name('rider.sendemail');
  Route::get('riders/emails/{id}', [\App\Http\Controllers\RidersController::class, 'emails'])->name('rider.emails');
  Route::get('rider/exportRiders', [\App\Http\Controllers\RidersController::class, 'exportRiders'])->name('rider.exportRiders');
  Route::get('riders/files/{id}', [\App\Http\Controllers\RidersController::class, 'files'])->name('rider.files');


  Route::get('riders/file-manager', function () {
    return view('riders.file-manager');
  })->name('rider.file-manager');

  Route::resource('riderEmails', App\Http\Controllers\RiderEmailsController::class);


  Route::resource('riderInvoices', App\Http\Controllers\RiderInvoicesController::class);
  Route::any('rider/invoice-import', [\App\Http\Controllers\RiderInvoicesController::class, 'import'])->name('rider.invoice_import');
  Route::get('search_item_price/{RID}/{itemID}', [\App\Http\Controllers\ItemsController::class, 'search_item_price']);
  Route::get('riderInvoices/delete/{id}', [\App\Http\Controllers\VendorsController::class, 'destroy'])->name('riderInvoices.delete');

  Route::resource('riderAttendances', App\Http\Controllers\RiderAttendanceController::class);
  Route::any('rider/attendance-import', [\App\Http\Controllers\RiderAttendanceController::class, 'import'])->name('rider.attendance_import');

  Route::resource('riderActivities', App\Http\Controllers\RiderActivitiesController::class);
  Route::any('rider/activities-import', [\App\Http\Controllers\RiderActivitiesController::class, 'import'])->name('rider.activities_import');

  /* Rider section end here */


  Route::resource('riderActivities', App\Http\Controllers\RiderActivitiesController::class);

  Route::resource('supplier_invoices', SupplierInvoicesController::class);
  Route::get('supplierInvoices/delete/{id}', [\App\Http\Controllers\SupplierInvoicesController::class, 'destroy'])->name('supplierInvoices.delete');

  Route::get('/item/{id}/price', [ItemsController::class, 'getPrice'])->name('item.price');

  Route::get('/get-item-price/{id}', [ItemsController::class, 'getItemPrice'])->name('item.getPrice');
  Route::get('items/delete/{id}', [\App\Http\Controllers\ItemsController::class, 'destroy'])->name('items.delete');

  Route::resource('files', FilesController::class);
  Route::resource('files', FilesController::class);

  Route::resource('vendors', App\Http\Controllers\VendorsController::class);

  Route::get('vendors/delete/{id}', [\App\Http\Controllers\VendorsController::class, 'destroy'])->name('vendors.delete');

  Route::resource('bikeHistories', App\Http\Controllers\BikeHistoryController::class);

  Route::resource('leasingCompanies', App\Http\Controllers\LeasingCompaniesController::class);
  Route::get('leasingCompanies/delete/{id}', [\App\Http\Controllers\LeasingCompaniesController::class, 'destroy'])->name('leasingCompanies.delete');
  Route::resource('garages', App\Http\Controllers\GaragesController::class);
  Route::get('garages/delete/{id}', [\App\Http\Controllers\GaragesController::class, 'destroy'])->name('garages.delete');
  Route::resource('banks', App\Http\Controllers\BanksController::class);
  Route::get('bank/ledger/{id}', [\App\Http\Controllers\BanksController::class, 'ledger'])->name('bank.ledger');
  Route::get('bank/files/{id}', [\App\Http\Controllers\BanksController::class, 'files'])->name('bank.files');
  Route::get('bank/delete/{id}', [\App\Http\Controllers\BanksController::class, 'destroy'])->name('bank.delete');


  Route::resource('vouchers', \App\Http\Controllers\VouchersController::class);
  Route::any('voucher/import', [\App\Http\Controllers\VouchersController::class, 'import'])->name('voucher.import');
  Route::get('get_invoice_balance', [\App\Http\Controllers\VouchersController::class, 'GetInvoiceBalance'])->name('get_invoice_balance');
  Route::get('fetch_invoices/{id}/{vt}', [\App\Http\Controllers\VouchersController::class, 'fetch_invoices']);
  /*   Route::any('attach_file/{id}', 'VouchersController@fileUpload'); */
  Route::any('voucher/attach_file/{id}', [\App\Http\Controllers\VouchersController::class, 'fileUpload'])->name('voucher.fileupload');


  Route::prefix('settings')->group(function () {

    Route::any('/company', [HomeController::class, 'settings'])->name('settings');
    Route::resource('departments', App\Http\Controllers\DepartmentsController::class);
    Route::resource('dropdowns', App\Http\Controllers\DropdownsController::class);

  });
  Route::prefix('reports')->group(function () {
    Route::get('/rider_report', [ReportController::class, 'rider_report'])->name('reports.rider_report');
    Route::post('/rider_report_data', [ReportController::class, 'rider_report_data'])->name('reports.rider_report_data');
  });



  Route::get('/itmeslist', function () {
    return App\Helpers\General::dropdownitems();
  });

  Route::prefix('accounts')->group(function () {

    Route::resource('accounts', App\Http\Controllers\AccountsController::class);
    Route::get('tree', [\App\Http\Controllers\AccountsController::class, 'tree'])->name('accounts.tree');

    Route::get('/ledgerreport', [LedgerController::class, 'ledger'])->name('accounts.ledgerreport');
    Route::get('/ledger', [LedgerController::class, 'index'])->name('accounts.ledger');
    Route::get('/ledger/data', [LedgerController::class, 'getLedgerData'])->name('ledger.data');


  });

});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
  \UniSharp\LaravelFilemanager\Lfm::routes();
});
/* Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
  Lfm::routes();
}); */

Route::get('/storage/{folder}/{filename}', [FileController::class, 'show'])->where('filename', '.*');
Route::get('/storage2/{folder}/{filename}', [FileController::class, 'root'])->where('filename', '.*');


Route::get('/artisan-cache', function () {
  Artisan::call('cache:clear');
  return 'cache cleared';
});
Route::get('/artisan-route', function () {
  Artisan::call('route:clear');
  return 'ruote cleared';
});

Route::get('/artisan-optimize', function () {
  Artisan::call('optimize');
  return 'optimized';
});
Route::get('/artisan-optimize-clear', function () {
  Artisan::call('optimize:clear');
  return 'optimized';
});
Route::get('/artisan-storage-link', function () {
  Artisan::call('storage:link');
  return 'storage link';
});

Route::get('/artisan-storage-unlink', function () {
  Artisan::call('storage:unlink');
  return 'storage unlink';
});

/* Route::resource('calculations', App\Http\Controllers\CalculationsController::class)
    ->names([
        'index' => 'calculations.index',
        'store' => 'calculations.store',
        'show' => 'calculations.show',
        'update' => 'calculations.update',
        'destroy' => 'calculations.destroy',
        'create' => 'calculations.create',
        'edit' => 'calculations.edit'
    ]); */


/* Settings section end here */
/* Settings section start here */
Route::prefix('settings')->group(function () {

  Route::any('/company', [HomeController::class, 'settings'])->name('settings');
  Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
  Route::post('/settings/logo', [SettingsController::class, 'updateLogo'])->name('settings.updateLogo');
  Route::post('/settings', [SettingsController::class, 'store'])->name('settings.store');
  Route::post('settings/update-favicon', [SettingsController::class, 'updateFavicon'])->name('settings.updateFavicon');
  Route::resource('departments', App\Http\Controllers\DepartmentsController::class);
  Route::resource('dropdowns', App\Http\Controllers\DropdownsController::class);

});


/* Suppliers section start here */
Route::middleware(['auth'])->group(function () {
  // Suppliers
  Route::resource('suppliers', SupplierController::class);
  Route::get('/suppliers/show/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
  Route::get('/suppliers/ledger/{id}', [SupplierController::class, 'ledger'])->name('suppliers.ledger');
  Route::get('/suppliers/{id}', [SupplierController::class, 'show'])->name('suppliers.show');
  Route::get('/suppliers/{id}/edit', [SupplierController::class, 'edit'])->name('suppliers.edit');
  Route::get('suppliers/delete/{id}', [\App\Http\Controllers\GaragesController::class, 'destroy'])->name('suppliers.delete');

  // Suppliers
  Route::resource('suppliers', SupplierController::class);
  Route::get('suppliers/datatable', [SupplierController::class, 'datatable'])->name('suppliers.datatable');
  Route::get('suppliers/document/{id}', [SupplierController::class, 'document'])->name('suppliers.document');
  Route::get('suppliers/files/{id}', [SupplierController::class, 'files'])->name('suppliers.files');

  // Supplier invoices
  Route::resource('supplierInvoices', SupplierInvoicesController::class);
  Route::any('/supplier_invoices/import', [SupplierInvoicesController::class, 'import'])->name('supplier_invoices.import');
  Route::post('/supplier/invoice/import', [SupplierInvoicesController::class, 'import'])->name('supplier.invoice_import');
  Route::get('/supplier/ledger', [SupplierInvoicesController::class, 'ledger'])->name('supplier.ledger');
  Route::post('/supplier_invoices/send-email/{id}', [SupplierInvoicesController::class, 'sendEmail'])->name('supplier_invoices.send_email');
  Route::put('/supplierInvoices/{id}', [SupplierInvoicesController::class, 'update'])->name('supplierInvoices.update');
  // Route::get('/supplier_invoices/{id}',[SupplierInvoicesController::class, 'edit'])->name('supplier_invoices.edit');
  Route::get('supplierInvoices/edit/{id}', [\App\Http\Controllers\SupplierInvoicesController::class, 'edit'])->name('supplierInvoices.edit');
  Route::post('/supplierInvoices/{id}', [SupplierInvoicesController::class, 'update'])->name('supplierInvoices.update');
  Route::get('/supplier_invoices/{id}', [SupplierInvoicesController::class, 'show'])->name('supplierInvoices.show');
  Route::get('/supplierInvoices/create', [SupplierInvoicesController::class, 'create'])->name('supplierInvoices.create');
  Route::post('supplierInvoices', [SupplierInvoicesController::class, 'store'])->name('supplierInvoices.store');
});

/* Suppliers section end here */
Route::middleware('auth')->group(function () {
  Route::resource('upload_files', UploadFilesController::class);
  Route::get('/upload_files', [UploadFilesController::class, 'index'])->name('upload_files.index');
  Route::get('/upload_files/create', [UploadFilesController::class, 'create'])->name('upload_files.create');
  Route::post('/upload_files', [UploadFilesController::class, 'store'])->name('upload_files.store');
  Route::get('/upload_files/{id}', [UploadFilesController::class, 'show'])->name('upload_files.show');
  Route::get('/upload_files/{id}/edit', [UploadFilesController::class, 'edit'])->name('upload_files.edit');
  Route::put('/upload_files/{id}', [UploadFilesController::class, 'update'])->name('upload_files.update');
  Route::delete('/upload_files/{id}', [UploadFilesController::class, 'destroy'])->name('upload_files.destroy');
});
















