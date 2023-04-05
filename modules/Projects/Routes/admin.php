<?php

use Illuminate\Support\Facades\Route;

Route::admin('projects', function () {
    Route::resource('projects', 'Projects');

    Route::group(['prefix' => 'projects/{project}'], function () {
        Route::resource('tasks', 'Tasks');
        Route::resource('timesheets', 'Timesheets');
        Route::resource('milestones', 'Milestones');
        Route::resource('discussions', 'Discussions');
        Route::resource('discussions/{discussion}/comments', 'Comments');
        // Route::resource('comments/{comment}/likes', 'DiscussionLikes');

        // Route::post('/transactions', function (\Modules\Projects\Models\Project $project) {
        //     $searchStringTransactions = $project->transactions()->collect();

        //     return view('projects::projects.show', compact('project', 'searchStringTransactions'));
        // })->name('transactions.index');

        // timesheet operations
        Route::post('tasks/{task}/timesheets/start', 'Timesheets@start')->name('timesheets.start');
        Route::post('/timesheets/{timesheet}/stop', 'Timesheets@stop')->name('timesheets.stop');

        Route::post('discussions/{discussion}/like', 'Discussions@like')->name('discussions.like');

        Route::post('attachments', 'Projects@attachments')->name('attachment.store');

        Route::get('/invoice', 'Projects@invoice')->name('invoice');
        Route::post('/invoice', 'Projects@storeInvoice')->name('invoice.store');
    });

    // custom links
    Route::get('/projects/{project}/print', 'Projects@printProject')->name('projects.print');
    Route::get('/projects/discussions/{discussion}/comments', 'Discussions@comments')->name('discussions.comments');
    Route::get('/chart/profitloss/{project}', 'Projects@profitLoss');
    Route::get('/export/transactions/{project}', 'Projects@exportTransactions')->name('transactions.export');
    Route::get('/export/timesheets/{project}', 'Projects@exportTimesheets')->name('timesheets.export');
    Route::get('/projects/{project}/refresh', 'Projects@refresh')->name('projects.refresh');
    Route::get('/projects/{project}/refresh/tasks', 'Projects@refreshTasks')->name('tasks.refresh');
});
