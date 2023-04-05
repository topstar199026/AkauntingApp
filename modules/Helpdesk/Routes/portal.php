<?php

use Illuminate\Support\Facades\Route;

/**
 * 'portal' middleware and 'portal/helpdesk' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::portal('helpdesk', function () {
    // To be used in search/filter functionality (search-string.php)
    Route::get('tickets/categories', 'Portal\Tickets@categories')->name('tickets.categories'); // Must go before the resource
    Route::get('statuses/index', 'Portal\Statuses@index')->name('statuses.index');

    // Tickets
    Route::resource('tickets', 'Portal\Tickets')->middleware('dropzone');

    // Replies
    Route::post('replies/store', 'Portal\Replies@store');
    Route::resource('replies', 'Portal\Replies');
});
