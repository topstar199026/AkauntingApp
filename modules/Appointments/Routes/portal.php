<?php

use Illuminate\Support\Facades\Route;

/**
 * 'portal' middleware and 'portal/appointments' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::portal('appointments', function () {
    Route::resource('appointments', 'Appointments');
    Route::get('scheduled/{scheduled}/dismiss', 'Scheduled@dismiss')->name('scheduled.dismiss');
    Route::resource('scheduled', 'Scheduled');
}, [
    'namespace' => 'Modules\Appointments\Http\Controllers\Portal'
]);
