<?php

use Illuminate\Support\Facades\Route;

Route::signed('proposals', function () {
    Route::get('{proposal}', 'Proposals@signed')->name('signed');
    Route::get('{proposal}/download', 'Proposals@download')->name('download');
    Route::get('{proposal}/approve', 'Proposals@approve')->name('approve');
    Route::get('{proposal}/refuse', 'Proposals@refuse')->name('refuse');
}, ['namespace' => 'Modules\Proposals\Http\Controllers\Signed']);
