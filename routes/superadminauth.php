<?php

use App\Http\Controllers\Admin\FuelRateController;
use App\Http\Controllers\Admin\OfficeController as AdminOfficeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MasterOfficeController;
use App\Http\Controllers\OfficeController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('superadmin')->group(function () {

    Route::group(['middleware' => 'CheckRole'], function () {
        Route::get('/', [LoginController::class, 'dashboard']);
        Route::get('/dashboard', [LoginController::class, 'dashboard'])->name('superadmin.dashboard');

        Route::get('/user/profile/{loginid}', [UserController::class, 'profile'])->name('superadmin.user.profile');
        Route::get('/user/profile/edit/{loginid}', [UserController::class, 'profile'])->name('superadmin.user.profile_edit');
        //============= User ===============
        // Route::get('/users', [UserController::class, 'index'])->name('superadmin.user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('superadmin.user.create');
        Route::get('/user/filter', [UserController::class, 'show_filter'])->name('superadmin.user.filter');
        //Route::get('/user/filter', [UserController::class, 'show_user_filter'])->name('superadmin.user.filter');
        Route::post('/user/filter', [UserController::class, 'show_filter_result'])->name('superadmin.user.filter_result');

        Route::post('/user/store', [UserController::class, 'store'])->name('superadmin.user.store');
        Route::get('/user/edit/{user_id}', [UserController::class, 'edit'])->name('superadmin.user.edit');
        Route::post('/user/update/{id}', [UserController::class, 'update'])->name('superadmin.user.update');
        Route::get('/user/delete/{id}', [UserController::class, 'destroy'])->name('superadmin.user.delete');
        // Route::get('/user/view/{id}', [UserController::class, 'view'])->name('superadmin.user.view');
        //user profile
        Route::get('/user/profile/{id}', [UserController::class, 'show'])->name('superadmin.user.profile');

        //============= Organization ===============
        Route::get('/master_office', [MasterOfficeController::class, 'index'])->name('superadmin.master_office.index');
        Route::get('/master_office/create', [MasterOfficeController::class, 'create'])->name('superadmin.master_office.create');
        Route::post('/master_office/store', [MasterOfficeController::class, 'store'])->name('superadmin.master_office.store');
        Route::get('/master_office/edit/{id}', [MasterOfficeController::class, 'edit'])->name('superadmin.master_office.edit');
        Route::get('/master_office/features/{id}', [MasterOfficeController::class, 'features'])->name('superadmin.master_office.features');
        Route::post('/master_office/features/toggle', [MasterOfficeController::class, 'features_toggle'])->name('superadmin.master_office.feature_toggle');
        Route::post('/master_office/update/{id}', [MasterOfficeController::class, 'update'])->name('superadmin.master_office.update');
        Route::get('/master_office/delete/{id}', [MasterOfficeController::class, 'destroy'])->name('superadmin.master_office.delete');
        Route::get('/master_office/view/{id}', [MasterOfficeController::class, 'view'])->name('superadmin.master_office.view');

        Route::get('/organization/users/{id}', [UserController::class, 'organisation_users_index'])->name('superadmin.organization.users');

        Route::get('/organization/user/create/{id}', [UserController::class, 'organisation_user_create'])->name('superadmin.organization_user.create');
        Route::get('/organization/user/filter/{id}', [UserController::class, 'show_organisation_user_filter'])->name('superadmin.organization_user.filter');

        Route::get('/user/edit/{user_id}/{id}', [UserController::class, 'office_user_edit'])->name('superadmin.organization_user.edit');

        //============= Office ===============
        Route::get('/office/{id}', [OfficeController::class, 'index'])->name('superadmin.office.index');
        Route::get('/office/create/{id}', [OfficeController::class, 'create'])->name('superadmin.office.create');
        Route::post('/office/store', [OfficeController::class, 'store'])->name('superadmin.office.store');
        Route::get('/office/edit/{id}', [OfficeController::class, 'edit'])->name('superadmin.office.edit');
        Route::post('/office/update/{id}', [OfficeController::class, 'update'])->name('superadmin.office.update');
        Route::get('/office/delete/{id}', [OfficeController::class, 'destroy'])->name('superadmin.office.delete');
        Route::get('/office/view/{id}', [OfficeController::class, 'view'])->name('superadmin.office.view');

        Route::get('/office/latest_rate/{id}', [FuelRateController::class, 'latest_rate'])->name('superadmin.office.latest_rate');
        Route::post('/office/store_latest_rate', [FuelRateController::class, 'store_latest_rate'])->name('superadmin.store_latest_rate');
        Route::get('/office/invoice_no/{id}', [AdminOfficeController::class, 'invoice_no'])->name('superadmin.office.invoice_no');
        Route::post('/office/store_invoice_no', [FuelRateController::class, 'store_invoice_no'])->name('superadmin.office.store_invoice_no');

        Route::get('/organization/product/{id}', [ProductTypeController::class, 'organisation_product_index'])->name('superadmin.organization.product');
        Route::post('/organization/product/search', [ProductTypeController::class, 'organisation_product_search'])->name('superadmin.organization.product_search');
        Route::get('/organization/product/create/{id}', [ProductTypeController::class, 'organisation_product_create'])->name('superadmin.organization.product_create');

        Route::get('/organization/product/edit{id}', [ProductTypeController::class, 'organisation_product_edit'])->name('superadmin.organization.product_edit');
        Route::post('/save_product', [ProductTypeController::class, 'save_product'])->name('superadmin.save_product');

    });
});
