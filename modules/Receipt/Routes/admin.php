<?php

use Illuminate\Support\Facades\Route;

Route::admin('receipt', function () {
    Route::group(['prefix' => 'receipt'], function () {
        Route::get('/', 'Receipts@index')->name('index');
        Route::get('export', 'Receipts@export')->name('export');

        Route::get('setting', 'Settings@edit')->name('setting');
        Route::post('setting', 'Settings@update')->name('setting.store');

        Route::post('store', 'Receipts@store')->name('store'); // Okuma işlemi
        Route::get('import', 'Receipts@import')->name('import');
        Route::get('edit/{receipt}', 'Receipts@edit')->name('edit');
        Route::patch('update/{receipt}', 'Receipts@update')->name('update');
        Route::delete('delete/{receipt}', 'Receipts@destroy')->name('destroy');
    });
}, ['prefix' => 'purchases']);
