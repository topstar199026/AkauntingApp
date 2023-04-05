<?php

use Illuminate\Support\Facades\Route;

/**
 * 'api' middleware and 'api/helpdesk' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::api('helpdesk', function () {
    Route::apiResource('tickets', 'Tickets');
    Route::apiResource('replies', 'Replies');
});
