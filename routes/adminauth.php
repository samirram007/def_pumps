<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HubController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\MapController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\MasterOfficeController;
use App\Http\Controllers\Admin\DeliveryPlanController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SalesController as AdminSalesController;
use App\Http\Controllers\Admin\StockController as AdminStockController;
use App\Http\Controllers\Admin\GodownController as AdminGodownController;
use App\Http\Controllers\Admin\OfficeController as AdminOfficeController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ExpenseController as AdminExpenseController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\FuelRateController as AdminFuelRateController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;

// Route::prefix('companyadmin')->group(function () {
// Route::group(['prefix' => 'companyadmin'], function () {
    Route::group(['middleware' => 'CheckRole','prefix' => 'companyadmin' ], function () {
        Route::get('/', [LoginController::class, 'checkDashboard']);
        Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('companyadmin.dashboard');
        Route::get('/calculator', function () {
            return view('module.calculator.calculator');
        })->name('companyadmin.calculator');


            // Route::get('profile/{loginid}', [AdminUserController::class, 'profile'])->name('companyadmin.user.profile');
            // Route::get('profile/edit/{loginid}', [AdminUserController::class, 'profile'])->name('companyadmin.user.profile_edit');
            Route::get('/users', [AdminUserController::class, 'index'])->name('companyadmin.user.index');
            Route::get('/user/create', [AdminUserController::class, 'create'])->name('companyadmin.user.create');
            Route::get('/user/filter', [AdminUserController::class, 'show_filter'])->name('companyadmin.user.filter');
            Route::post('/user/filter', [AdminUserController::class, 'show_filter_result'])->name('companyadmin.user.filter_result');
            Route::post('/user/store', [AdminUserController::class, 'store'])->name('companyadmin.user.store');
            Route::get('/user/edit/{id}', [AdminUserController::class, 'edit'])->name('companyadmin.user.edit');
            Route::post('/user/update/{id}', [AdminUserController::class, 'update'])->name('companyadmin.user.update');
            Route::get('/user/delete/{id}', [AdminUserController::class, 'destroy'])->name('companyadmin.user.delete');
            Route::get('/user/view/{id}', [AdminUserController::class, 'view'])->name('companyadmin.user.view');


        Route::get('/map', [MapController::class, 'map'])->name('companyadmin.map');
        Route::get('/map_filter', [MapController::class, 'map_filter'])->name('companyadmin.map.filter');

        Route::get('/city/search_form', [CityController::class, 'city_search_form'])->name('companyadmin.city.search_form');
        Route::get('/city/search/{str}', [CityController::class, 'city_search'])->name('companyadmin.city.search');
        Route::post('/city/add', [CityController::class, 'city_add'])->name('companyadmin.city.add');
        Route::get('/hub/create', [HubController::class,  'create'])->name('companyadmin.hub.create');
        Route::get('/hub/list', [HubController::class,  'list'])->name('companyadmin.hub.list');
        Route::post('/hub/add', [HubController::class,  'store'])->name('companyadmin.hub.add');
        //Admin Dashboard
        Route::post('/dashboard_filter', [AdminDashboardController::class, 'dashboard_filter'])->name('companyadmin.dashboard_filter');
        Route::post('/dashboard/chart1_export', [AdminDashboardController::class, 'chart1_export'])->name('companyadmin.chart1_excel');
        Route::post('/dashboard/chart1_pdf', [AdminDashboardController::class, 'chart1_pdf'])->name('companyadmin.chart1_pdf');
        Route::post('/dashboard/chart2_export', [AdminDashboardController::class, 'chart2_export'])->name('companyadmin.chart2_excel');
        Route::post('/dashboard/chart2_pdf', [AdminDashboardController::class, 'chart2_pdf'])->name('companyadmin.chart2_pdf');


        // Delivery Plan========================
        Route::get('/delivery_plan', [DeliveryPlanController::class, 'index'])->name('companyadmin.delivery_plan');
        Route::get('/delivery_plan/create', [DeliveryPlanController::class, 'create'])->name('companyadmin.delivery_plan.create');
        Route::post('/delivery_plan/store', [DeliveryPlanController::class, 'store'])->name('companyadmin.delivery_plan.store');
        Route::get('/delivery_plan/edit/{id}', [DeliveryPlanController::class, 'edit'])->name('companyadmin.delivery_plan.edit');
        Route::get('/delivery_plan/view/{id}', [DeliveryPlanController::class, 'show'])->name('companyadmin.delivery_plan.view');
        Route::get('/delivery_plan/delete/{id}', [DeliveryPlanController::class, 'delete'])->name('companyadmin.delivery_plan.delete');
        Route::get('/delivery_plan/request', [DeliveryPlanController::class, 'requestModal'])->name('companyadmin.delivery_plan.request');
        Route::post('/delivery_plan/new_request', [DeliveryPlanController::class, 'new_request'])->name('companyadmin.delivery_plan.new_request');
        Route::post('/delivery_plan/modified_request', [DeliveryPlanController::class, 'modified_request'])->name('companyadmin.delivery_plan.modified_request');
        Route::get('/delivery_plan/status_change/{id}', [DeliveryPlanController::class, 'status_change'])->name('companyadmin.delivery_plan.status_change');
        Route::post('/delivery_plan/update_status/{id}', [DeliveryPlanController::class, 'update_status'])->name('companyadmin.delivery_plan.update_status');


        Route::post('/delivery_plan/delivery_filter', [DeliveryPlanController::class, 'delivery_filter'])->name('companyadmin.delivery_plan.delivery_filter');

        Route::post('/delivery_plan_details/delivery_details_filter', [DeliveryPlanController::class, 'delivery_details_filter'])->name('companyadmin.delivery_plan_details.delivery_details_filter');
        Route::get('/delivery_plan_details/approve_requirement/{id}', [DeliveryPlanController::class, 'approve_requirement'])->name('companyadmin.delivery_plan_details.approve_requirement');
        Route::post('/delivery_plan_details/confirm_requirement/{id}', [DeliveryPlanController::class, 'confirm_requirement'])->name('companyadmin.delivery_plan_details.confirm_requirement');
        Route::get('/delivery_plan_details/reject/{id}', [DeliveryPlanController::class, 'reject'])->name('companyadmin.delivery_plan_details.reject');
        Route::get('/delivery_plan_details/receive_delivery/{id}', [DeliveryPlanController::class, 'receive_delivery'])->name('companyadmin.delivery_plan_details.receive_delivery');
        Route::post('/delivery_plan_details/confirm_delivery/{id}', [DeliveryPlanController::class, 'confirm_delivery'])->name('companyadmin.delivery_plan_details.confirm_delivery');

        //============= User ===============

        //user profile
        // Route::get('/user/profile/{id}', [AdminUserController::class, 'show'])->name('companyadmin.user.profile');
        //============= Organization ===============
        Route::get('/master_office', [MasterOfficeController::class, 'index'])->name('companyadmin.master_office.index');
        Route::get('/master_office/create', [MasterOfficeController::class, 'create'])->name('companyadmin.master_office.create');
        Route::post('/master_office/store', [MasterOfficeController::class, 'store'])->name('companyadmin.master_office.store');

        //============= Office ===============
        Route::get('/office', [AdminOfficeController::class, 'index'])->name('companyadmin.office.index');
        Route::get('/office/users/{id}', [AdminUserController::class, 'office_users_index'])->name('companyadmin.office.users');
        Route::get('/office/user/create/{id}', [AdminUserController::class, 'office_user_create'])->name('companyadmin.office_user.create');
        Route::get('/office/user/filter/{id}', [AdminUserController::class, 'show_officeuser_filter'])->name('companyadmin.office_user.filter');

        Route::get('/user/edit/{id}/{office_id}', [AdminUserController::class, 'office_user_edit'])->name('companyadmin.office_user.edit');

        Route::get('/office/create', [AdminOfficeController::class, 'create'])->name('companyadmin.office.create');
        Route::post('/office/store', [AdminOfficeController::class, 'store'])->name('companyadmin.office.store');
        Route::post('/office/edit/{id}', [AdminOfficeController::class, 'edit'])->name('companyadmin.office.edit');
        Route::get('/office/show/{id}', [AdminOfficeController::class, 'show'])->name('companyadmin.office.show');
        Route::post('/office/update/{id}', [AdminOfficeController::class, 'update'])->name('companyadmin.office.update');
        Route::get('/office/delete/{id}', [AdminOfficeController::class, 'destroy'])->name('companyadmin.office.delete');
        Route::get('/office/view/{id}', [AdminOfficeController::class, 'view'])->name('companyadmin.office.view');
        Route::get('/office/latest_rate/{id}', [AdminFuelRateController::class, 'latest_rate'])->name('companyadmin.office.latest_rate');
        Route::post('/office/store_latest_rate', [AdminFuelRateController::class, 'store_latest_rate'])->name('companyadmin.store_latest_rate');

        Route::get('/office/current_stock/{id}', [AdminStockController::class, 'current_stock'])->name('companyadmin.office.current_stock');
        Route::post('/office/store_current_stock', [AdminStockController::class, 'store_current_stock'])->name('companyadmin.store_current_stock');
        Route::get('/office/godowns/{id}', [AdminGodownController::class, 'godowns'])->name('companyadmin.office.godowns');
        Route::get('/office/godownlist/{id}', [AdminGodownController::class, 'godownlist'])->name('companyadmin.godownlist');
        Route::get('/office/godowns/create/{id}', [AdminGodownController::class, 'create'])->name('companyadmin.godown.create');

        Route::post('/office/godowns/store', [AdminGodownController::class, 'store'])->name('companyadmin.godown.store');
        Route::post('/office/godowns/update', [AdminGodownController::class, 'update'])->name('companyadmin.godown.update');
        Route::get('/office/godowns/edit/{godownid}', [AdminGodownController::class, 'edit'])->name('companyadmin.godown.edit');
        Route::get('/office/godowns/delete/{id}', [AdminGodownController::class, 'delete'])->name('companyadmin.godown.delete');
        Route::get('/office/godowns/current_stock/{id}', [AdminGodownController::class, 'current_stock'])->name('companyadmin.godown.current_stock');
        Route::get('/office/godowns/current_stock_all/{id}', [AdminGodownController::class, 'all_stock'])->name('companyadmin.godown.current_stock_all');
        Route::post('/office/godowns/stock_update', [AdminGodownController::class, 'stock_update'])->name('companyadmin.godown.stock.update');

        Route::get('/office/invoice_no/{id}', [AdminOfficeController::class, 'invoice_no'])->name('companyadmin.office.invoice_no');
        Route::post('/office/store_invoice_no', [AdminFuelRateController::class, 'store_invoice_no'])->name('companyadmin.office.store_invoice_no');
        //produtc
        Route::get('/organization/product/{id}', [ProductTypeController::class, 'organisation_product_index'])->name('companyadmin.product');
        Route::post('/save_product', [ProductTypeController::class, 'save_product'])->name('companyadmin.save_product');

        // Route::get('/organization/product/{id}', [ProductTypeController::class, 'organisation_product_index'])->name('superadmin.organization.product');
         Route::post('/organization/product/search', [ProductTypeController::class, 'organisation_product_search'])->name('companyadmin.organization.product_search');
         Route::get('/organization/product/create/{id}', [ProductTypeController::class, 'organisation_product_create'])->name('companyadmin.organization.product_create');

          Route::get('/organization/product/edit{id}', [ProductTypeController::class, 'organisation_product_edit'])->name('companyadmin.organization.product_edit');
        // Route::post('/save_product', [ProductTypeController::class, 'save_product'])->name('superadmin.save_product');


        //============= Project ===============
        Route::get('/project', [AdminProjectController::class, 'index'])->name('companyadmin.project.index');
        Route::get('/project/create', [AdminProjectController::class, 'create'])->name('companyadmin.project.create');
        Route::post('/project/store', [AdminProjectController::class, 'store'])->name('companyadmin.project.store');
        Route::get('/project/show/{id}', [AdminProjectController::class, 'show'])->name('companyadmin.project.show');
        Route::get('/project/edit/{id}', [AdminProjectController::class, 'edit'])->name('companyadmin.project.edit');
        Route::post('/project/update', [AdminProjectController::class, 'update'])->name('companyadmin.project.update');
        Route::get('/project/delete/{id}', [AdminProjectController::class, 'destroy'])->name('companyadmin.project.delete');

        //============= Sales ===============
        Route::get('/sales', [AdminSalesController::class, 'index'])->name('companyadmin.sales.index');
        Route::get('/sales/create', [AdminSalesController::class, 'create'])->name('companyadmin.sales.create');
        Route::post('/sales/store', [AdminSalesController::class, 'store'])->name('companyadmin.sales.store');
        Route::get('/sales/show/{id}', [AdminSalesController::class, 'show'])->name('companyadmin.sales.show');
        Route::get('/sales/edit/{id}', [AdminSalesController::class, 'edit'])->name('companyadmin.sales.edit');
        Route::get('/sales/show/{id}', [AdminSalesController::class, 'show'])->name('companyadmin.sales.show');
        Route::post('/sales/update', [AdminSalesController::class, 'update'])->name('companyadmin.sales.update');
        Route::post('/sales/update_status', [AdminSalesController::class, 'UpdateStatus'])->name('companyadmin.sales.verify');
        Route::get('/sales/delete/{id}', [AdminSalesController::class, 'destroy'])->name('companyadmin.sales.delete');
        Route::get('/producttype/rate/{id}', [AdminSalesController::class, 'getRate'])->name('companyadmin.productType.getRate');
        Route::get('/producttype/{id}', [AdminSalesController::class, 'getEnv'])->name('companyadmin.productType.getEnv');
        Route::get('/producttype_index', [AdminSalesController::class, 'producttype_index'])->name('companyadmin.producttype.index');
        Route::get('/productType_by_office_id/{id}/{date}', [AdminSalesController::class, 'productType_by_office_id'])->name('companyadmin.productType_by_office_id');
        Route::post('/sales_filter', [AdminSalesController::class, 'sales_filter'])->name('companyadmin.sales_filter');
        Route::post('/sales/export', [AdminSalesController::class, 'sales_export'])->name('companyadmin.sales_export');
        Route::post('/sales_pdf', [AdminSalesController::class, 'sales_pdf'])->name('companyadmin.sales_pdf');
        // Route::get('/sales_pdf', [AdminSalesController::class, 'sales_pdf'])->name('companyadmin.sales_pdf') ;
        // Route::get('/producttype_index',function(){
        //     dd('hello');
        // })->name('companyadmin.producttype.index');
        //============= Expense ===============
        Route::get('/expense', [AdminExpenseController::class, 'index'])->name('companyadmin.expense.index');
        Route::get('/expense/create', [AdminExpenseController::class, 'create'])->name('companyadmin.expense.create');
        Route::post('/expense/store', [AdminExpenseController::class, 'store'])->name('companyadmin.expense.store');

        Route::get('/expense/show/{id}', [AdminExpenseController::class, 'show'])->name('companyadmin.expense.show');
        Route::get('/expense/edit/{id}', [AdminExpenseController::class, 'edit'])->name('companyadmin.expense.edit');
        Route::post('/expense/update', [AdminExpenseController::class, 'update'])->name('companyadmin.expense.update');
        Route::get('/expense/delete/{id}', [AdminExpenseController::class, 'destroy'])->name('companyadmin.expense.delete');

        Route::post('/expense_filter', [AdminExpenseController::class, 'expense_filter'])->name('companyadmin.expense_filter');
        Route::post('/expense/export', [AdminExpenseController::class, 'expense_export'])->name('companyadmin.expense_export');
        Route::post('/expense_pdf', [AdminExpenseController::class, 'expense_pdf'])->name('companyadmin.expense_pdf');

        //============== Report =================
        Route::get('/office/report', [AdminReportController::class, 'index'])->name('companyadmin.report');
        Route::post('/office/report/task', [AdminReportController::class, 'task_report'])->name('companyadmin.report.task');
        Route::post('/office/report/user_task/export', [AdminReportController::class, 'user_task_export'])->name('companyadmin.user_task.export');
        Route::post('/office/report/user_task/pdf', [AdminReportController::class, 'user_task_pdf'])->name('companyadmin.user_task.pdf');

        // Route::post('users-import', 'import')->name('users.import');

    });
// });
