<?php

use Illuminate\Support\Facades\Route;
use Modules\Budgets\Http\Controllers\Budgets;

/**
 * 'admin' middleware and 'budgets' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::admin('budgets', function () {
    Route::get('/accounts', [Budgets::class, 'accounts'])->name('accounts.index');
    Route::get('/period', [Budgets::class, 'budgetPeriods'])->name('period');

    Route::get('/', [Budgets::class, 'index'])->name('index');
    Route::get('/create', [Budgets::class, 'create'])->name('create');
    Route::post('/create', [Budgets::class, 'store'])->name('store');
    Route::get('/edit/{budget}', [Budgets::class, 'edit'])->name('edit');
    Route::get('/{budget}', [Budgets::class, 'show'])->name('show');
    Route::patch('/{budget}', [Budgets::class, 'update'])->name('update');
    Route::delete('/{budget}', [Budgets::class, 'destroy'])->name('destroy');

});
