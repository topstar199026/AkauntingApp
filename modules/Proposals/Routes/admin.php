<?php

use Illuminate\Support\Facades\Route;

Route::admin('proposals', function () {

    Route::resource('proposals', 'Proposals');
    Route::resource('templates', 'Templates');
    Route::resource('pipelines', 'Pipelines');

    Route::group([
        'as' => 'proposals.',
        'prefix' => 'proposals',
    ], function () {
        Route::get('{proposal}/duplicate', 'Proposals@duplicate')->name('duplicate');
        Route::get('{proposal}/download', 'Proposals@download')->name('download');
        Route::get('{proposal}/notify', 'Proposals@notify')->name('notify');
    });

    Route::group([
        'as' => 'templates.',
        'prefix' => 'templates',
    ], function () {
        Route::get('{template}/duplicate', 'Templates@duplicate')->name('duplicate');
        Route::get('{template}/content', 'Templates@content')->name('content');
        Route::get('{template}/download', 'Templates@download')->name('download');
    });

}, ['prefix' => 'sales']);
