<?php

use App\Http\Controllers\BikesController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LedgerController;
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


  Route::resource('customers', App\Http\Controllers\CustomersController::class);
  Route::resource('sims', App\Http\Controllers\SimsController::class);
  /* Rider section starts from here */

  Route::resource('riders', App\Http\Controllers\RidersController::class);
  Route::any('riders/job_status/{id?}', [\App\Http\Controllers\RidersController::class, 'job_status'])->name('rider.job_status');
  Route::get('riders/timeline/{id?}', [\App\Http\Controllers\RidersController::class, 'timeline'])->name('rider.timeline');
  Route::get('riders/contract/{id?}', [\App\Http\Controllers\RidersController::class, 'contract'])->name('rider.contract');
  Route::any('riders/contract_upload/{id?}', [\App\Http\Controllers\RidersController::class, 'contract_upload'])->name('rider_contract_upload');
  Route::any('riders/picture_upload/{id?}', [\App\Http\Controllers\RidersController::class, 'picture_upload'])->name('rider_picture_upload');
  Route::any('riders/rider-document/{id}', [\App\Http\Controllers\RidersController::class, 'document'])->name('rider.document');
  Route::get('rider/updateRider', [\App\Http\Controllers\RidersController::class, 'updateRider'])->name('rider.updateRider');
  Route::get('riders/ledger/{id}', [\App\Http\Controllers\RidersController::class, 'ledger'])->name('rider.ledger');
  Route::get('riders/attendance/{id}', [\App\Http\Controllers\RidersController::class, 'attendance'])->name('rider.attendance');
  Route::get('riders/activities/{id}', [\App\Http\Controllers\RidersController::class, 'activities'])->name('rider.activities');
  Route::get('riders/invoices/{id}', [\App\Http\Controllers\RidersController::class, 'invoices'])->name('rider.invoices');

  Route::resource('riderInvoices', App\Http\Controllers\RiderInvoicesController::class);
  Route::any('rider/invoice-import', [\App\Http\Controllers\RiderInvoicesController::class, 'import'])->name('rider.invoice_import');
  Route::get('search_item_price/{RID}/{itemID}', [\App\Http\Controllers\ItemsController::class, 'search_item_price']);

  Route::resource('riderAttendances', App\Http\Controllers\RiderAttendanceController::class);
  Route::any('rider/attendance-import', [\App\Http\Controllers\RiderAttendanceController::class, 'import'])->name('rider.attendance_import');

  Route::resource('riderActivities', App\Http\Controllers\RiderActivitiesController::class);
  Route::any('rider/activities-import', [\App\Http\Controllers\RiderActivitiesController::class, 'import'])->name('rider.activities_import');

  /* Rider section end here */

  Route::resource('bikeHistories', App\Http\Controllers\BikeHistoryController::class);

  Route::resource('leasingCompanies', App\Http\Controllers\LeasingCompaniesController::class);
  Route::resource('garages', App\Http\Controllers\GaragesController::class);
  Route::resource('banks', App\Http\Controllers\BanksController::class);

  Route::resource('vouchers', VouchersController::class);
  Route::any('voucher/import', [\App\Http\Controllers\VouchersController::class, 'import'])->name('voucher.import');
  Route::get('get_invoice_balance', 'VouchersController@GetInvoiceBalance')->name('get_invoice_balance');
  Route::get('fetch_invoices/{id}/{vt}', 'VouchersController@fetch_invoices');
  /*   Route::any('attach_file/{id}', 'VouchersController@fileUpload'); */
  Route::any('voucher/attach_file/{id}', [VouchersController::class, 'fileUpload'])->name('voucher.fileupload');


  Route::prefix('settings')->group(function () {

    Route::any('/company', [HomeController::class, 'settings'])->name('settings');
    Route::resource('departments', App\Http\Controllers\DepartmentsController::class);
    Route::resource('dropdowns', App\Http\Controllers\DropdownsController::class);

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










Route::resource('riderActivities', App\Http\Controllers\RiderActivitiesController::class);
