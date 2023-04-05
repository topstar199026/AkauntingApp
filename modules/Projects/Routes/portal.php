<?php

use Illuminate\Support\Facades\Route;

Route::portal('projects', function () {
    Route::resource('projects', 'Projects');

    Route::get('{project}/overview', 'Projects@overview')->name('overview');
    Route::get('{project}/tasks', 'Projects@tasks')->name('tasks');
    Route::get('{project}/timesheets', 'Projects@timesheets')->name('timesheets');
    Route::get('{project}/milestones', 'Projects@milestones')->name('milestones');
    Route::get('{project}/activities', 'Projects@activities')->name('activities');
    Route::get('{project}/transactions', 'Projects@transactions')->name('transactions');
    Route::get('{project}/discussions', 'Projects@discussions')->name('discussions');
    Route::get('{project}/print', 'Projects@print')->name('print');
    Route::get('/export/transactions/{project}', 'Projects@exportTransactions')->name('transactions.export');

    Route::group(['prefix' => 'projects/{project}'], function () {
        Route::resource('tasks', 'Tasks');
        Route::resource('discussions', 'Discussions');
        Route::resource('discussions/{discussion}/comments', 'Comments');
        Route::post('discussions/{discussion}/like', 'Discussions@like')->name('discussions.like');
    });
}, [
    'namespace' => 'Modules\Projects\Http\Controllers\Portal'
]);
