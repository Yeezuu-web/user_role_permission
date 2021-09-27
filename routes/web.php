<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\FilesController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\BoostsController;
use App\Http\Controllers\Admin\ChannelsController;
use App\Http\Controllers\Admin\FileImportController;
use App\Http\Controllers\Admin\UserAlertsController;
use App\Http\Controllers\Admin\DepartmentsController;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\BoostsUpdateController;
use App\Http\Controllers\Auth\ChangePasswordController;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Route::get('boosts/send-mail', [BoostsController::class, 'basic_email'])->name('boosts.send_mail');
Route::post('boosts/media', [BoostsController::class, 'storeMedia'])->name('boosts.storeMedia');
Route::post('boosts/ckmedia', [BoostsController::class, 'storeCKEditorImages'])->name('boosts.storeCKEditorImages');
Route::get('boosts/request', [BoostsController::class , 'boostRequest'])->name('boosts.request');
Route::post('boosts/request', [BoostsController::class , 'boostStore'])->name('boosts.store');

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Permissions
    Route::delete('permissions/destroy', [PermissionsController::class, 'massDestroy'])->name('permissions.massDestroy');
    Route::resource('permissions', PermissionsController::class);

    // Roles
    Route::delete('roles/destroy', [RolesController::class , 'massDestroy'])->name('roles.massDestroy');
    Route::resource('roles', RolesController::class);

    // Users
    Route::delete('users/destroy', [UsersController::class , 'massDestroy'])->name('users.massDestroy');
    Route::post('users/media', [UsersController::class, 'storeMedia'])->name('users.storeMedia');
    Route::post('users/ckmedia', [UsersController::class, 'storeCKEditorImages'])->name('users.storeCKEditorImages');
    Route::resource('users', UsersController::class);

    // User Alerts
    Route::delete('user-alerts/destroy', [UserAlertsController::class , 'massDestroy'])->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', [UserAlertsController::class , 'read']);
    Route::resource('user-alerts', UserAlertsController::class)->except(['edit', 'update']);
    Route::view('alerts', 'partials.alert-read')->name('alert.read');

    //departmnt
    Route::delete('departments/destroy', [DepartmentsController::class , 'massDestroy'])->name('departments.massDestroy');
    Route::resource('departments', DepartmentsController::class);
    
    // channel
    Route::delete('channels/destroy', [ChannelsController::class , 'massDestroy'])->name('channels.massDestroy');
    Route::resource('channels', ChannelsController::class);
    
    // boost
    Route::delete('boosts/destroy', [BoostsController::class , 'massDestroy'])->name('boosts.massDestroy');
    Route::get('boosts/{boost}/firstApprove', [BoostsController::class , 'firstApprove'])->name('boosts.firstApprove');
    Route::post('boosts/firstApprove/update/{boost}', [BoostsController::class , 'firstApproveUpdate'])->name('boosts.firstApproveUpdate');
    Route::get('boosts/{boost}/secondApprove', [BoostsController::class , 'secondApprove'])->name('boosts.secondApprove');
    Route::post('boosts/secondApprove/update/{boost}', [BoostsController::class , 'secondApproveUpdate'])->name('boosts.secondApproveUpdate');
    Route::resource('boosts', BoostsController::class)->except(['create', 'store']);
    
    // production
    Route::delete('productins/destroy', [BoostsUpdateController::class , 'massDestroy'])->name('productins.massDestroy');
    Route::get('productions', [BoostsUpdateController::class , 'index'])->name('productions.index');
    Route::get('productions/edit/{id}', [BoostsUpdateController::class , 'edit'])->name('productions.edit');
    Route::post('productions/update/{id}', [BoostsUpdateController::class , 'update'])->name('productions.update');
    
    // boosts report
    Route::get('reports/boost', [BoostsUpdateController::class , 'index'])->name('reports.boosts.index');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', [ChangePasswordController::class , 'edit'])->name('password.edit');
        Route::post('password', [ChangePasswordController::class , 'update'])->name('password.update');
        Route::post('profile', [ChangePasswordController::class , 'updateProfile'])->name('password.updateProfile');
        Route::post('profile/media', [ChangePasswordController::class, 'storeMedia'])->name('password.storeMedia');
        Route::post('profile/destroy', [ChangePasswordController::class , 'destroy'])->name('password.destroyProfile');
    }
});