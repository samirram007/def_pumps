<?php

use App\Http\Controllers\Admin\GodownController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PumpAdmin\DashboardController;
use App\Http\Controllers\PumpAdmin\ExpenseController;
use App\Http\Controllers\PumpAdmin\FuelRateController;
use App\Http\Controllers\PumpAdmin\MapController;
use App\Http\Controllers\PumpAdmin\SalesController;
use App\Http\Controllers\PumpAdmin\UserController;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\Admin\OfficeController as AdminOfficeController;
// use App\Http\Controllers\Admin\ReportController as AdminReportController;
// use App\Http\Controllers\Admin\ExpenseController as AdminExpenseController;
// use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
// use App\Http\Controllers\Admin\FuelRateController as AdminFuelRateController;
// use App\Http\Controllers\Admin\ProductTypeController as AdminProductTypeController;

Route::prefix('pumpadmin')->group(function () {
    Route::group(['middleware' => 'CheckRole'], function () {
        Route::get('/', [LoginController::class, 'checkDashboard']);
        Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('pumpadmin.dashboard');

        Route::post('/dashboard_filter', [DashboardController::class, 'dashboard_filter'])->name('pumpadmin.dashboard_filter');
        Route::post('/dashboard/chart1_export', [DashboardController::class, 'chart1_export'])->name('pumpadmin.chart1_excel');
        Route::post('/dashboard/chart1_pdf', [DashboardController::class, 'chart1_pdf'])->name('pumpadmin.chart1_pdf');
        Route::post('/dashboard/chart2_export', [DashboardController::class, 'chart2_export'])->name('pumpadmin.chart2_excel');
        Route::post('/dashboard/chart2_pdf', [DashboardController::class, 'chart2_pdf'])->name('pumpadmin.chart2_pdf');

        Route::get('/user/profile/{loginid}', [UserController::class, 'profile'])->name('pumpadmin.user.profile');
        Route::get('/user/profile/edit/{loginid}', [UserController::class, 'profile'])->name('pumpadmin.user.profile_edit');
        Route::get('/map', [MapController::class, 'map'])->name('pumpadmin.map');
        Route::get('/map_filter', [MapController::class, 'map_filter'])->name('pumpadmin.map.filter');

        Route::get('/office/latest_rate/{id}', [FuelRateController::class, 'latest_rate'])->name('pumpadmin.latest_rate');
        Route::post('/office/store_latest_rate', [FuelRateController::class, 'store_latest_rate'])->name('pumpadmin.store_latest_rate');

        Route::get('/sales', [SalesController::class, 'index'])->name('pumpadmin.sales.index');
        Route::get('/sales/create', [SalesController::class, 'create'])->name('pumpadmin.sales.create');
        Route::post('/sales/store', [SalesController::class, 'store'])->name('pumpadmin.sales.store');
        Route::get('/sales/show/{id}', [SalesController::class, 'show'])->name('pumpadmin.sales.show');
        Route::get('/sales/edit/{id}', [SalesController::class, 'edit'])->name('pumpadmin.sales.edit');
        Route::get('/sales/show/{id}', [SalesController::class, 'show'])->name('pumpadmin.sales.show');
        Route::post('/sales/update', [SalesController::class, 'update'])->name('pumpadmin.sales.update');
        Route::post('/sales/update_status', [SalesController::class, 'UpdateStatus'])->name('pumpadmin.sales.verify');
        Route::get('/sales/delete/{id}', [SalesController::class, 'destroy'])->name('pumpadmin.sales.delete');
        Route::get('/producttype/rate/{id}', [SalesController::class, 'getRate'])->name('pumpadmin.productType.getRate');
        Route::get('/producttype/{id}', [SalesController::class, 'getEnv'])->name('pumpadmin.productType.getEnv');
        Route::get('/productType_by_office_id/{id}', [SalesController::class, 'productType_by_office_id'])->name('pumpadmin.productType_by_office_id');
        Route::post('/sales_filter', [SalesController::class, 'sales_filter'])->name('pumpadmin.sales_filter');
        Route::post('/sales/export', [SalesController::class, 'sales_export'])->name('pumpadmin.sales_export');
        Route::post('/sales_pdf', [SalesController::class, 'sales_pdf'])->name('pumpadmin.sales_pdf');

        Route::get('/office/godownlist/{id}', [GodownController::class, 'godownlist'])->name('pumpadmin.godownlist');

        Route::get('/expense', [ExpenseController::class, 'index'])->name('pumpadmin.expense.index');
        Route::get('/expense/create', [ExpenseController::class, 'create'])->name('pumpadmin.expense.create');
        Route::post('/expense/store', [ExpenseController::class, 'store'])->name('pumpadmin.expense.store');

        Route::get('/expense/show/{id}', [ExpenseController::class, 'show'])->name('pumpadmin.expense.show');
        Route::get('/expense/edit/{id}', [ExpenseController::class, 'edit'])->name('pumpadmin.expense.edit');
        Route::post('/expense/update', [ExpenseController::class, 'update'])->name('pumpadmin.expense.update');
        Route::get('/expense/delete/{id}', [ExpenseController::class, 'destroy'])->name('pumpadmin.expense.delete');

        Route::post('/expense_filter', [ExpenseController::class, 'expense_filter'])->name('pumpadmin.expense_filter');
        Route::post('/expense/export', [ExpenseController::class, 'expense_export'])->name('pumpadmin.expense_export');
        Route::post('/expense_pdf', [ExpenseController::class, 'expense_pdf'])->name('pumpadmin.expense_pdf');

        Route::get('/users', [UserController::class, 'index'])->name('pumpadmin.user.index');
        Route::get('/user/create', [UserController::class, 'office_user_create'])->name('pumpadmin.user.create');
        Route::get('/user/filter', [UserController::class, 'show_office_user_filter'])->name('pumpadmin.user.filter');
        Route::post('/user/filter', [UserController::class, 'show_filter_result'])->name('pumpadmin.user.filter_result');
        Route::post('/user/store', [UserController::class, 'store'])->name('pumpadmin.user.store');
        Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('pumpadmin.user.edit');
        Route::post('/user/update/{id}', [UserController::class, 'update'])->name('pumpadmin.user.update');
        Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('pumpadmin.user.delete');
        Route::get('/user/view/{id}', [UserController::class, 'view'])->name('pumpadmin.user.view');

    });
});
