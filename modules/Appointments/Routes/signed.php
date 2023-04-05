<?php

use Illuminate\Support\Facades\Route;

/**
 * 'signed' middleware and 'signed/appointments' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::signed('appointments', function () {
    Route::get('appointments/{appointment}/signed', 'Appointments@signed')->name('appointments.signed');
    Route::resource('appointments', 'Appointments');
}, [
    'namespace' => 'Modules\Appointments\Http\Controllers\Portal'
]);

