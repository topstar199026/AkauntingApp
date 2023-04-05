<?php

use Illuminate\Support\Facades\Route;

Route::admin('mt940', function () {

    Route::get('create', 'Mt940Controller@create')->name('create');
    Route::get('create/bank', 'Mt940Controller@createBank')->name('create.bank');
    Route::post('import', 'Mt940Controller@import')->name('import');
    Route::post('bank', 'Mt940Controller@createBankAccount')->name('bank');

});
