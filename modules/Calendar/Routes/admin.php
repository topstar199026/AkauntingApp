<?php

use Illuminate\Support\Facades\Route;

/**
 * 'admin' middleware and 'calendar' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::admin('calendar', function () {
    Route::get('/modals/google', 'Main@google')->name('modals.google');
    Route::get('/modals/i-cal', 'Main@iCal')->name('modals.i-cal');
    Route::get('/', 'Main@index')->name('index');
    
    Route::get('settings', 'Settings@edit')->name('settings.edit');
    Route::post('settings', 'Settings@update')->name('settings.update');

    Livewire::component('calendar', Calendar::class);

    Route::get('calendar/events', function(\Illuminate\Http\Request $request) {
        $name = $request->get('name');

        $events = [];
        foreach (range(0,6) as $i) {
            $events[] = [
                'id' => uniqid(),
                'title' => \Str::random(4) . $name ,
                'start' => now()->addDay(random_int(-10, 10))->toDateString(),
            ];
        }

        return $events;
    });
});
