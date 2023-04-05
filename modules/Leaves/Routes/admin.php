<?php

use Illuminate\Support\Facades\Route;

/**
 * 'admin' middleware and 'leaves' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::admin('leaves', function () {
    Route::get('employees', 'Employees@index')->name('employees.index');

    Route::get('entitlements/policies', 'Entitlements@findPolicies')->name('entitlements.find-policies');
    Route::get('entitlements/employees', 'Entitlements@findEmployees')->name('entitlements.find-employees');
    Route::resource('entitlements', 'Entitlements')->except(['show', 'edit', 'update']);

    Route::resource('calendar', 'Calendar');

    Route::group(['prefix' => 'settings', 'as' => 'settings.', 'namespace' => 'Settings'], function () {
        Route::redirect('/', 'settings/policies')->name('edit');
        Route::resource('policies', 'Policies');
        Route::resource('leave-types', 'LeaveTypes');
        Route::resource('years', 'Years');
    });

    Route::group(['prefix' => 'modals', 'as' => 'modals.', 'namespace' => 'Modals'], function () {
        Route::get('entitlement/{entitlement}/leaves/create', 'Leaves@create')->name('entitlement.leaves.create');
        Route::get('leaves/create', 'Leaves@create')->name('leaves.create');
        Route::post('leaves', 'Leaves@store')->name('leaves.register');
        Route::delete('leaves/{allowance}', 'Leaves@destroy')->name('leaves.destroy');
        Route::resource('leave-types', 'Settings\LeaveTypes')->names('settings.leave-types');
        Route::resource('years', 'Settings\Years')->names('settings.years');
    });
});
