<?php

use Illuminate\Support\Facades\Route;

Route::portal('proposals', function () {

    Route::group([
        'as' => 'proposals.',
        'prefix' => 'proposals',
    ], function () {
        Route::get('{proposal}/download', 'Proposals@download')->name('download');
        Route::get('{proposal}/approve', 'Proposals@approve')->name('approve');
        Route::get('{proposal}/refuse', 'Proposals@refuse')->name('refuse');
    });

    Route::resource('proposals', 'Proposals');
}, ['namespace' => 'Modules\Proposals\Http\Controllers\Portal']);
