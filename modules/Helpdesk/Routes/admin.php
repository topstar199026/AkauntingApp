<?php

use Illuminate\Support\Facades\Route;

/**
 * 'admin' middleware and 'helpdesk' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::admin('helpdesk', function () {
    // To be used in search/filter functionality (search-string.php)
    Route::get('statuses/index', 'Statuses@index')->name('statuses.index');

    // Tickets
    Route::post('tickets/{id}/update-partial', 'Tickets@updatePartial');
    Route::post('tickets/import', 'Tickets@import')->name('tickets.import');
    Route::get('tickets/export', 'Tickets@export')->name('tickets.export');
    Route::resource('tickets', 'Tickets')->middleware('dropzone');
    
    // Replies
    Route::post('replies/store', 'Replies@store');
    Route::patch('replies/{id}/update', 'Replies@update');
    Route::resource('replies', 'Replies');
});
