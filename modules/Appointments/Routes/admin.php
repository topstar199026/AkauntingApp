<?php

use Illuminate\Support\Facades\Route;

/**
 * 'admin' middleware and 'appointments' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::admin('appointments', function () {
    Route::resource('modals/appointments', 'Modals\Scheduled', ['names' => 'modals.appointments']);

    Route::get('appointments/{appointment}/enable', 'Appointments@enable')->name('enable');
    Route::get('appointments/{appointment}/disable', 'Appointments@disable')->name('disable');
    Route::resource('appointments', 'Appointments');

    Route::get('questions/{question}/enable', 'Questions@enable')->name('enable');
    Route::get('questions/{question}/disable', 'Questions@disable')->name('disable');
    Route::resource('questions', 'Questions');

    Route::get('scheduled/{scheduled}/approve', 'Scheduled@approve')->name('scheduled.approve');
    Route::get('scheduled/{scheduled}/sent', 'Scheduled@sent')->name('scheduled.sent');
    Route::get('scheduled/{scheduled}/dismiss', 'Scheduled@dismiss')->name('scheduled.dismiss');
    Route::resource('scheduled', 'Scheduled');

    Route::get('settings', 'Settings@edit')->name('settings.edit');
    Route::post('settings', 'Settings@update')->name('settings.update');
});
