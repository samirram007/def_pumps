<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HubController;
use App\Http\Controllers\MapController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

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
Route::get('/', [LoginController::class, 'welcome'])->name('welcome');

Route::get('lang/{locale}', [LocalizationController::class, 'index'])->name('lang');
Route::get('/si/{invoice_no}', [SalesController::class, 'sales_invoice'])->name('sales_invoice');
Route::get('/unsubscribe', function(){ return view('unsubscribe');})->name('unsubscribe');
Route::post('/unsubscribe', function(){ return view('unsubscribe');});

Route::get('/office/search', [OfficeController::class, 'address_search'])->name('office.address.search');
Route::get('/hub/search', [HubController::class, 'address_search'])->name('hub.address.search');
Route::group(['middleware' => 'preventbackhistory'], function () {
    Route::get('/switchmode/{userId}', [LoginController::class, 'switchmode'])->name('switchmode');
    Route::group(['middleware' => 'isNotLoggedIn'], function () {
        Route::get('/map/{id}', [MapController::class, 'show']);
        Route::get('/map', [MapController::class, 'show']);
        Route::get('/info', [AdminReportController::class, 'phpinfo'])->name('phpinfo');
        Route::get('/', [LoginController::class, 'welcome'])->name('welcome');
        Route::get('/welcome', [LoginController::class, 'welcome'])->name('welcomes');
        Route::get('/contact', function () {
            return view('contact');
        })->name('contact');
        Route::get('/login', [LoginController::class, 'login'])->name('login');
        Route::post('/signin', [LoginController::class, 'SignIn'])->name('signin');
        Route::post('/signinmobile', [LoginController::class, 'SignInWithMobile'])->name('SignInWithMobile');

    });

    Route::group(['middleware' => 'isLoggedIn'], function () {
        Route::get('/', [LoginController::class, 'dashboard']);
        require __DIR__ . '/superadminauth.php';
        require __DIR__ . '/adminauth.php';
        require __DIR__ . '/pumpadminauth.php';
        require __DIR__ . '/driverauth.php';

        //================= Support Routes ======================
        Route::get('admin/support/list', [SupportController::class, 'SupportList'])->name('companyadmin.support.list');
        Route::get('superadmin/support/list', [SupportController::class, 'SupportList'])->name('superadmin.support.list');
        Route::get('pumpadmin/support/list', [SupportController::class, 'SupportList'])->name('pumpadmin.support.list');

        Route::get('superadmin/support/create', [SupportController::class, 'SupportCreate'])->name('superadmin.support.create');
        Route::get('admin/support/create', [SupportController::class, 'SupportCreate'])->name('companyadmin.support.create');
        Route::get('pumpadmin/support/create', [SupportController::class, 'SupportCreate'])->name('pumpadmin.support.create');

        Route::post('support/store', [SupportController::class, 'SupportStore'])->name('store.support');
        Route::post('support_details/store', [SupportController::class, 'SupportDetailsStore'])->name('store.support_details');

        Route::get('superadmin/support/add', [SupportController::class, 'SupportAdd'])->name('superadmin.support.add');
        Route::get('admin/support/add', [SupportController::class, 'SupportAdd'])->name('companyadmin.support.add');
        Route::get('pumpadmin/support/add', [SupportController::class, 'SupportAdd'])->name('pumpadmin.support.add');

        Route::get('/support/edit/{id}', [SupportController::class, 'SupportEdit'])->name('support.edit');
        Route::get('/support/chat/{supportId}', [SupportController::class, 'ChatBody'])->name('support.chat');

    });

});

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//cache clear
Route::get('/clear_cache', function () {
    $exitCode = Artisan::call('cache:clear');
    return 'Cache is cleared';
});
Route::get('/config_cache', function () {
    $exitCode = Artisan::call('config:cache');
    return 'Cache created';
});
Route::get('/optimize_clear', function () {
    $exitCode = Artisan::call('optimize:clear');
    return 'Optimize Clear';
});
//storage link
Route::get('/storage_link', function () {
    $exitCode = Artisan::call('storage:link');
    return 'Storage is linked';
});
//migrate
Route::get('/migrate', function () {
    $exitCode = Artisan::call('migrate');
    return 'Migration is done';
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
