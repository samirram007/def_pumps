<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DeliveryPlanController;
use App\Http\Controllers\Admin\ExpenseController as AdminExpenseController;
use App\Http\Controllers\Admin\FuelRateController as AdminFuelRateController;
use App\Http\Controllers\Admin\GodownController as AdminGodownController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\Admin\OfficeController as AdminOfficeController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\SalesController as AdminSalesController;
use App\Http\Controllers\Admin\StockController as AdminStockController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterOfficeController;
use App\Http\Controllers\ProductTypeController;
use Illuminate\Support\Facades\Route;

// Route::prefix('companyadmin')->group(function () {
Route::group(['prefix' => 'companyadmin'], function () {
    Route::group(['middleware' => 'CheckRole','name'=>'companyadmin.'], function () {
        Route::get('/', [LoginController::class, 'checkDashboard']);
        Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('dashboard');
        Route::get('/calculator', function () {
            return view('module.calculator.calculator');
        })->name('calculator');

        // Route::group(['prefix' => 'user'],function(){});
            // Route::get('profile/{loginid}', [AdminUserController::class, 'profile'])->name('user.profile');
            // Route::get('profile/edit/{loginid}', [AdminUserController::class, 'profile'])->name('user.profile_edit');
            Route::get('/users', [AdminUserController::class, 'index'])->name('user.index');
            Route::get('/user/create', [AdminUserController::class, 'create'])->name('user.create');
            Route::get('/user/filter', [AdminUserController::class, 'show_filter'])->name('user.filter');
            Route::post('/user/filter', [AdminUserController::class, 'show_filter_result'])->name('user.filter_result');
            Route::post('/user/store', [AdminUserController::class, 'store'])->name('user.store');
            Route::get('/user/edit/{id}', [AdminUserController::class, 'edit'])->name('user.edit');
            Route::post('/user/update/{id}', [AdminUserController::class, 'update'])->name('user.update');
            Route::get('/user/delete/{id}', [AdminUserController::class, 'destroy'])->name('user.delete');
            Route::get('/user/view/{id}', [AdminUserController::class, 'view'])->name('user.view');


        Route::get('/map', [MapController::class, 'map'])->name('map');
        Route::get('/map_filter', [MapController::class, 'map_filter'])->name('map.filter');
        //Admin Dashboard
        Route::post('/dashboard_filter', [AdminDashboardController::class, 'dashboard_filter'])->name('dashboard_filter');
        Route::post('/dashboard/chart1_export', [AdminDashboardController::class, 'chart1_export'])->name('chart1_excel');
        Route::post('/dashboard/chart1_pdf', [AdminDashboardController::class, 'chart1_pdf'])->name('chart1_pdf');
        Route::post('/dashboard/chart2_export', [AdminDashboardController::class, 'chart2_export'])->name('chart2_excel');
        Route::post('/dashboard/chart2_pdf', [AdminDashboardController::class, 'chart2_pdf'])->name('chart2_pdf');


        // Delivery Plan========================
        Route::post('/delivery_plan', [DeliveryPlanController::class, 'delivery_plan'])->name('delivery_plan');
        //============= User ===============

        //user profile
        // Route::get('/user/profile/{id}', [AdminUserController::class, 'show'])->name('user.profile');
        //============= Organization ===============
        Route::get('/master_office', [MasterOfficeController::class, 'index'])->name('master_office.index');
        Route::get('/master_office/create', [MasterOfficeController::class, 'create'])->name('master_office.create');
        Route::post('/master_office/store', [MasterOfficeController::class, 'store'])->name('master_office.store');

        //============= Office ===============
        Route::get('/office', [AdminOfficeController::class, 'index'])->name('office.index');
        Route::get('/office/users/{id}', [AdminUserController::class, 'office_users_index'])->name('office.users');
        Route::get('/office/user/create/{id}', [AdminUserController::class, 'office_user_create'])->name('office_user.create');
        Route::get('/office/user/filter/{id}', [AdminUserController::class, 'show_officeuser_filter'])->name('office_user.filter');

        Route::get('/user/edit/{id}/{office_id}', [AdminUserController::class, 'office_user_edit'])->name('office_user.edit');

        Route::get('/office/create', [AdminOfficeController::class, 'create'])->name('office.create');
        Route::post('/office/store', [AdminOfficeController::class, 'store'])->name('office.store');
        Route::get('/office/edit/{id}', [AdminOfficeController::class, 'edit'])->name('office.edit');
        Route::get('/office/show/{id}', [AdminOfficeController::class, 'show'])->name('office.show');
        Route::post('/office/update/{id}', [AdminOfficeController::class, 'update'])->name('office.update');
        Route::get('/office/delete/{id}', [AdminOfficeController::class, 'destroy'])->name('office.delete');
        Route::get('/office/view/{id}', [AdminOfficeController::class, 'view'])->name('office.view');
        Route::get('/office/latest_rate/{id}', [AdminFuelRateController::class, 'latest_rate'])->name('office.latest_rate');
        Route::post('/office/store_latest_rate', [AdminFuelRateController::class, 'store_latest_rate'])->name('store_latest_rate');

        Route::get('/office/current_stock/{id}', [AdminStockController::class, 'current_stock'])->name('office.current_stock');
        Route::post('/office/store_current_stock', [AdminStockController::class, 'store_current_stock'])->name('store_current_stock');
        Route::get('/office/godowns/{id}', [AdminGodownController::class, 'godowns'])->name('office.godowns');
        Route::get('/office/godownlist/{id}', [AdminGodownController::class, 'godownlist'])->name('godownlist');
        Route::get('/office/godowns/create/{id}', [AdminGodownController::class, 'create'])->name('godown.create');

        Route::post('/office/godowns/store', [AdminGodownController::class, 'store'])->name('godown.store');
        Route::post('/office/godowns/update', [AdminGodownController::class, 'update'])->name('godown.update');
        Route::get('/office/godowns/edit/{godownid}', [AdminGodownController::class, 'edit'])->name('godown.edit');
        Route::get('/office/godowns/delete/{id}', [AdminGodownController::class, 'delete'])->name('godown.delete');
        Route::get('/office/godowns/current_stock/{id}', [AdminGodownController::class, 'current_stock'])->name('godown.current_stock');
        Route::get('/office/godowns/current_stock_all/{id}', [AdminGodownController::class, 'all_stock'])->name('godown.current_stock_all');
        Route::post('/office/godowns/stock_update', [AdminGodownController::class, 'stock_update'])->name('godown.stock.update');

        Route::get('/office/invoice_no/{id}', [AdminOfficeController::class, 'invoice_no'])->name('office.invoice_no');
        Route::post('/office/store_invoice_no', [AdminFuelRateController::class, 'store_invoice_no'])->name('office.store_invoice_no');
        //produtc
        Route::get('/organization/product/{id}', [ProductTypeController::class, 'organisation_product_index'])->name('product');
        Route::post('/save_product', [ProductTypeController::class, 'save_product'])->name('save_product');

        //============= Project ===============
        Route::get('/project', [AdminProjectController::class, 'index'])->name('project.index');
        Route::get('/project/create', [AdminProjectController::class, 'create'])->name('project.create');
        Route::post('/project/store', [AdminProjectController::class, 'store'])->name('project.store');
        Route::get('/project/show/{id}', [AdminProjectController::class, 'show'])->name('project.show');
        Route::get('/project/edit/{id}', [AdminProjectController::class, 'edit'])->name('project.edit');
        Route::post('/project/update', [AdminProjectController::class, 'update'])->name('project.update');
        Route::get('/project/delete/{id}', [AdminProjectController::class, 'destroy'])->name('project.delete');

        //============= Sales ===============
        Route::get('/sales', [AdminSalesController::class, 'index'])->name('sales.index');
        Route::get('/sales/create', [AdminSalesController::class, 'create'])->name('sales.create');
        Route::post('/sales/store', [AdminSalesController::class, 'store'])->name('sales.store');
        Route::get('/sales/show/{id}', [AdminSalesController::class, 'show'])->name('sales.show');
        Route::get('/sales/edit/{id}', [AdminSalesController::class, 'edit'])->name('sales.edit');
        Route::get('/sales/show/{id}', [AdminSalesController::class, 'show'])->name('sales.show');
        Route::post('/sales/update', [AdminSalesController::class, 'update'])->name('sales.update');
        Route::post('/sales/update_status', [AdminSalesController::class, 'UpdateStatus'])->name('sales.verify');
        Route::get('/sales/delete/{id}', [AdminSalesController::class, 'destroy'])->name('sales.delete');
        Route::get('/producttype/rate/{id}', [AdminSalesController::class, 'getRate'])->name('productType.getRate');
        Route::get('/producttype/{id}', [AdminSalesController::class, 'getEnv'])->name('productType.getEnv');
        Route::get('/producttype_index', [AdminSalesController::class, 'producttype_index'])->name('producttype.index');
        Route::get('/productType_by_office_id/{id}/{date}', [AdminSalesController::class, 'productType_by_office_id'])->name('productType_by_office_id');
        Route::post('/sales_filter', [AdminSalesController::class, 'sales_filter'])->name('sales_filter');
        Route::post('/sales/export', [AdminSalesController::class, 'sales_export'])->name('sales_export');
        Route::post('/sales_pdf', [AdminSalesController::class, 'sales_pdf'])->name('sales_pdf');
        // Route::get('/sales_pdf', [AdminSalesController::class, 'sales_pdf'])->name('sales_pdf') ;
        // Route::get('/producttype_index',function(){
        //     dd('hello');
        // })->name('producttype.index');
        //============= Expense ===============
        Route::get('/expense', [AdminExpenseController::class, 'index'])->name('expense.index');
        Route::get('/expense/create', [AdminExpenseController::class, 'create'])->name('expense.create');
        Route::post('/expense/store', [AdminExpenseController::class, 'store'])->name('expense.store');

        Route::get('/expense/show/{id}', [AdminExpenseController::class, 'show'])->name('expense.show');
        Route::get('/expense/edit/{id}', [AdminExpenseController::class, 'edit'])->name('expense.edit');
        Route::post('/expense/update', [AdminExpenseController::class, 'update'])->name('expense.update');
        Route::get('/expense/delete/{id}', [AdminExpenseController::class, 'destroy'])->name('expense.delete');

        Route::post('/expense_filter', [AdminExpenseController::class, 'expense_filter'])->name('expense_filter');
        Route::post('/expense/export', [AdminExpenseController::class, 'expense_export'])->name('expense_export');
        Route::post('/expense_pdf', [AdminExpenseController::class, 'expense_pdf'])->name('expense_pdf');

        //============== Report =================
        Route::get('/office/report', [AdminReportController::class, 'index'])->name('report');
        Route::post('/office/report/task', [AdminReportController::class, 'task_report'])->name('report.task');
        Route::post('/office/report/user_task/export', [AdminReportController::class, 'user_task_export'])->name('user_task.export');
        Route::post('/office/report/user_task/pdf', [AdminReportController::class, 'user_task_pdf'])->name('user_task.pdf');

        // Route::post('users-import', 'import')->name('users.import');

    });
});
