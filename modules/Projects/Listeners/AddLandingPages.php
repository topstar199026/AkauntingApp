<?php

namespace Modules\Projects\Listeners;

use App\Events\Auth\LandingPageShowing as Event;

class AddLandingPages
{
    /**
     * Handle the event.
     *
     * @param Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        $routes = [
            'projects.projects.index' => [
                'permission' => 'read-projects-projects',
                'translate'  => trans_choice('projects::general.projects', 2),
            ],
        ];

        foreach($routes as $key => $route) {
            if (user()->cannot($route['permission'])) {
                continue;
            }

            $event->user->landing_pages[$key] = $route['translate'];
        }
    }
}
